<?php

namespace App\Paypal;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class CreatePayment extends Paypal
{
    public function create() {
        $item1 = new Item();
        $item1->setName('Ground Coffee 40 oz')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice(20);

        $itemList = new ItemList();
        $itemList->setItems(array($item1));

        $payment = $this->Payment(
            $this->Payer(),
            $this->RedirectUrls(),
            $this->Transaction($itemList));

        $payment->create($this->apiContext);

        return redirect($payment->getApprovalLink());
    }

    /**
     * @return Payer
     */
    public function Payer(): Payer
    {
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");
        return $payer;
    }

    /**
     * @return Details
     */
    public function Details(): Details
    {
        $details = new Details();
        $details->setShipping(0)
            ->setTax(0)
            ->setSubtotal(20);
        return $details;
    }

    /**
     * @return Amount
     */
    public function Amount(): Amount
    {
        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal(20)
            ->setDetails($this->Details());
        return $amount;
    }

    /**
     * @param ItemList $itemList
     * @return Transaction
     */
    public function Transaction(ItemList $itemList): Transaction
    {
        $transaction = new Transaction();
        $transaction->setAmount($this->Amount())
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());
        return $transaction;
    }

    /**
     * @return RedirectUrls
     */
    public function RedirectUrls(): RedirectUrls
    {
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('execute-payment'))
            ->setCancelUrl(route('cancel-payment'));
        return $redirectUrls;
    }

    /**
     * @param Payer $payer
     * @param RedirectUrls $redirectUrls
     * @param Transaction $transaction
     * @return Payment
     */
    public function Payment(
        Payer $payer,
        RedirectUrls $redirectUrls,
        Transaction $transaction
    ): Payment
    {
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));
        return $payment;
    }
}
