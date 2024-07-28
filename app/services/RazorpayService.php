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
        $order = $this->api->order->create([
            'amount' => $amount * 100, // Amount in paise
            'currency' => 'INR',
            'payment_capture' => 1
        ]);

        return $order;
    }

    public function verifySignature($attributes)
    {
        return $this->api->utility->verifyPaymentSignature($attributes);
    }
}
