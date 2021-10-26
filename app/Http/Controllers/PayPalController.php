<?php

namespace App\Http\Controllers;

use App\Models\Ipn;
use App\Models\Order;
use App\Models\Txn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

class PayPalController extends Controller
{
    public static function environment()
    {
        //$clientId = env('PAYPAL_ID');
        $clientId = "AYUlr8hWJEpOBR-cBx5E-7DIq0gkl84891D-aABQ-eIpMOhKL8jHEJJc9Qmd8E9ZrYysjLAX3XWbVb7v";
        $clientSecret = "ELLh1NcedThIANWFyA-iq6atCBvhk9pgJY09SHYPASzNHGPQPMkcph9M-p5BukEAC4RybRXWyZoYRpOL";
        //$clientSecret = env('PAYPAL_SECRET');
        return new SandboxEnvironment($clientId, $clientSecret);
    }

    public function create(Request $request)
    {
        $request->validate([
            'money' => 'required|numeric|integer|gte:1',
        ]);
        $money = $request->money;
        // Setup make order to paypal v2
        $client = new PayPalHttpClient(self::environment());
        $orderPaypal = new OrdersCreateRequest();
        $orderPaypal->prefer('return=representation');
        $orderPaypal->body = [
            "intent" => "CAPTURE",
            "application_context" => [
                "cancel_url" => route('paypal.cancel'),
                "return_url" => route('paypal.execute'),
            ],
            "purchase_units" => [[
                "reference_id" => "test_ref_id1",
                "amount" => [
                    "value" => $money,
                    "currency_code" => "USD"
                ]
            ]],
        ];

        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($orderPaypal);
            $orderId = $response->result->id;
            Log::info("orderID:" .$orderId);
            $order = new Order([
                'user_id' => Auth::id(),
                'payment_id' => 1, //paypal
                'amount' => $money,
                'paypal_id' => $orderId,
                'state' => $response->result->status,
                'created_at' => now(),
                'expired_at' => now(),
            ]);
            $order->save();

            foreach($response->result->links as $link) {
                if ($link->rel == "approve")
                    return redirect($link->href);
            }
            // If call returns body in response, you can get the deserialized version from the result attribute of the response
        }catch (\Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    public function execute(Request $request)
    {
        Log::info("param execute:".json_encode($request->all()));
        $orderId = request('token');
        // verify order has payment.
        $order = Order::where('paypal_id', $orderId)->first();
        if ($order == null || $order->status != 1) {
            return "Don hang khong ton tai";
        }

        $client = new PayPalHttpClient(self::environment());
        $request = new OrdersCaptureRequest($order->paypal_id);
        $request->prefer('return=representation');
        try {
            $response = $client->execute($request);
            $order->state = $response->result->intent;
            $order->payer_id = $response->result->payer->payer_id;
            $order->status = config('constants.order.status.verified');
            $order->save();
            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            Log::info("result execute payment:".json_encode($response));;

            return  redirect()->route('buyer.deposit')->with('success', 'Giao dịch đang được xử lý');
        }catch (\Exception $ex) {
            echo $ex->getCode();
            print_r($ex->getMessage());
        }
    }

    public function cancel()
    {
        return null;
    }

    public function webhook(Request $request)
    {
        Log::info("webhook:".json_encode($request->all()));
        $webhookId = $request['id'];
        $eventType = $request['event_type'];
        $summary = $request['summary'];
        $orderId = $request['resource']['supplementary_data']['related_ids']['order_id'];
        $amount = $request['resource']['seller_receivable_breakdown']['gross_amount']['value'];
        $fee = $request['resource']['seller_receivable_breakdown']['paypal_fee']['value'];
        $state = $request['resource']['status']; // COMPLETED

        $order = Order::where([
            ['paypal_id', $orderId],
            ['status', config('constants.order.status.verified')],
        ])->first();

        if ($order == null || $amount != $order->amount)
            return "Khong tim thay don hang";
        try {
            DB::beginTransaction();
            // create ipns
            $ipn = new Ipn([
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'event_id' => $webhookId,
                'paypal_id' => $orderId,
                'amount' => $amount,
                'amount_fee' => $fee,
                'event_type' => $eventType,
                'summary' => $summary,
                'log' => json_encode("Order:".$orderId.",EventId:".$webhookId),
                'status' => config('constants.ipn.status.completed'),
            ]);
            $ipn->save();
            // update order
            $order->amount_fee = $fee;
            $order->state = $state;
            $order->status = config('constants.order.status.webhook');
            $order->save();
            // Create txns and change balance user
            $txn = new Txn([
                'user_id' => $order->user_id,
                'order_id' => $order->id,
                'ipn_id' => $ipn->id,
                'amount' => $order->amount*24000,
                'type' => config('constants.txn.type.webhook'),
                'status' => Txn::STAT_COMPLETED,
            ]);
            $txn->save();
            DB::commit();

            return response()->json(['code' => 201, 'message' => 'true']);
        } catch (\Exception $ex) {
            DB::rollBack();
            echo $ex->getCode();
            print_r($ex->getMessage());
        }
    }

    public function getAll()
    {
        dd(Order::all()->toArray(), Ipn::all()->toArray(), Txn::all()->toArray() );
    }
}
