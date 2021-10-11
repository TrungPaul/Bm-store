<?php

namespace App\Http\Controllers;

use App\Models\Ipn;
use App\Models\Order;
use App\Models\Txn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('services.paypal.id'),
                config('services.paypal.secret')
            )
        );
    }

    public function create(Request $request)
    {

        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('services.paypal.id'),
                config('services.paypal.secret')
            )
        );
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

/*        $item = new Item();
        $item->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($request->money);

        $itemList = new ItemList();
        $itemList->setItems(array($item));

        $details = new Details();
        $details->setShipping(0)
            ->setTax(0)
            ->setSubtotal($request->money);
*/
        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($request->money);
//            ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setInvoiceNumber(uniqid());
//            ->setItemList($itemList)
//            ->setDescription("Payment description")


        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('execute-payment'))
            ->setCancelUrl(route('cancel-payment'));

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));
        Log::info($payment);
        $payment->create($apiContext);

        try {
            $order = new Order([
                'user_id' => Auth::id(),
                'payment_id' => 1, //paypal
                'amount' => $request->money,
                'paypal_id' => $payment->id,
                'state' => $payment->state,
                'created_at' => now(),
                'expired_at' => now(),
            ]);
            $order->save();

            return redirect($payment->getApprovalLink());

        } catch (\Exception $exception)
        {
            return redirect()->back()->with('error', $exception->getMessage());
        }

    }
    public function execute(Request $request)
    {
//         [
//              "paymentId" => "PAYID-ME7SC7Q4RC69666UH8594012"
//              "token" => "EC-8NP590026Y485221Y"
//              "PayerID" => "RK4QVDHS84JYY"
//        ]
        $payment = Payment::get(request('paymentId'), $this->apiContext);
        $order = Order::where('paypal_id', request('paymentId'))->first();

        $amount = new Amount();
        $amount->setCurrency('USD');
        $amount->setTotal($order->amount);

        $transaction = new Transaction();
        $transaction->setAmount($amount);

        $execution = new PaymentExecution();
        $execution->setPayerId(request('PayerID'));
        $execution->addTransaction($transaction);
        $result = $payment->execute($execution, $this->apiContext);

        $order->token = request('token');
        $order->payer_id = request('PayerID');
        $order->state = $result->state;
        $order->status = config('constants.order.state.approved');
        $order->payer_id = $result->payer->payer_info->payer_id;
        $order->save();

        // handle return after payment
        return $result;
//        return redirect()->route('admin')->with('success', 'Vui long doi cong tien');
    }

    public function listEvent()
    {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('services.paypal.id'),
                config('services.paypal.secret')
            )
        );

        $output = \PayPal\Api\WebhookEventType::availableEventTypes($apiContext);
        return $output;
    }

    public function webhook(Request $request)
    {
        Log::info(json_encode($request->all()));
        $paypalId = $request['resource']['parent_payment'];
        $state = $request['resource']['state'];
        $fee = $request['resource']['transaction_fee']['value'];

        $order = Order::where('paypal_id', $paypalId)->first();
//        if ($order == null || $order->status != config('constants.order.state.approved'))
//        {
//            return "Don hang chua duoc thanh toan";
//        }

        $order->amount_fee = $fee;
        $order->state = $state;
        $order->status = config('constants.order.status.webhook');
        $order->save();

        try {
            DB::beginTransaction();
            $ipn = new Ipn([
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'event_id' => $request['id'],
                'paypal_id' => $paypalId,
                'amount' => $order->amount,
                'amount_fee' => $order->amount_fee,
                'event_type' => $request['event_type'],
                'summary' => $request['summary'],
                'log' => json_encode($request->all()),
                'status' => config('constants.ipn.status.completed')
            ]);
            $ipn->save();
//            dd($ipn);
            // create txns -> update money
//            $txn = new Txn([
//
//            ]);
//            $txn->save();
            DB::commit();
            return response()->json([
                'code' => 200,
                'message' => 'Success'
            ]);
        } catch (\Exception $exception)
        {
            dd($exception->getMessage());
            DB::rollBack();
            return response()->json([
                'code' => $exception->getCode(),
            ]);
        }
    }
}
