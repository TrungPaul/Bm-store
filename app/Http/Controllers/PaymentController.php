<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
    public function create(Request $request) {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('services.paypal.id'),     // ClientID
                config('services.paypal.secret')     // ClientSecret
            )
        );

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $item1 = new Item();
        $item1->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($request->money);

        $itemList = new ItemList();
        $itemList->setItems(array($item1));

        $details = new Details();
        $details->setShipping(0)
            ->setTax(0)
            ->setSubtotal($request->money);

        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($request->money)
            ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('execute-payment'))
            ->setCancelUrl(route('cancel-payment'));

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        $payment->create($apiContext);

        return redirect($payment->getApprovalLink());
    }
    public function execute(Request $request)
    {
//         [
//              "paymentId" => "PAYID-ME7SC7Q4RC69666UH8594012"
//              "token" => "EC-8NP590026Y485221Y"
//              "PayerID" => "RK4QVDHS84JYY"
//        ]
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('services.paypal.id'),
                config('services.paypal.secret')
            )
        );

        $paymentId = request('paymentId');
        $payment = Payment::get($paymentId, $apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId(request('PayerID'));
        $transaction = new Transaction();
        $amount = new Amount();

        //can remove
        $details = new Details();
        $details->setShipping(0)
            ->setTax(0)
            ->setSubtotal(10);

        $amount->setCurrency('USD');
        $amount->setTotal(10); // call from order of customer
        $amount->setDetails($details);
        $transaction->setAmount($amount);

        $execution->addTransaction($transaction);

        return $payment->execute($execution, $apiContext);
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
}
