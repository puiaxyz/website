<?php

namespace App\Services;

use Razorpay\Api\Api;

class RazorpayService
{
    protected $api;

    public function __construct()
    {
        $this->api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
    }

    public function createOrder($amount)
    {
        return $this->api->order->create([
            'amount' => $amount * 100, // Amount in paise
            'currency' => 'INR',
            'receipt' => uniqid()
        ]);
    }

    public function verifySignature($attributes)
    {
        $api = $this->api;
        $attributes['razorpay_order_id'] = $attributes['razorpay_order_id'];
        $attributes['razorpay_payment_id'] = $attributes['razorpay_payment_id'];
        $attributes['razorpay_signature'] = $attributes['razorpay_signature'];
        $api->utility->verifyPaymentSignature($attributes);
    }
}
