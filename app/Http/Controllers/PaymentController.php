<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Services\RazorpayService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    protected $razorpayService;

    public function __construct(RazorpayService $razorpayService)
    {
        $this->razorpayService = $razorpayService;
    }

    public function create()
    {
        return view('payment.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $amount = $request->input('amount');
        $order = $this->razorpayService->createOrder($amount);

        $payment = new Payment();
        $payment->user_id = $user->id;
        $payment->amount = $amount;
        $payment->status = 'due';
        $payment->razorpay_order_id = $order['id'];
        $payment->save();

        return view('payment.pay', [
            'order' => $order,
            'amount' => $amount,
            'user' => $user
        ]);
    }

    public function callback(Request $request)
    {
        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature
        ];

        try {
            $this->razorpayService->verifySignature($attributes);

            $payment = Payment::where('razorpay_order_id', $request->razorpay_order_id)->first();
            $payment->status = 'paid';
            $payment->razorpay_payment_id = $request->razorpay_payment_id;
            $payment->razorpay_signature = $request->razorpay_signature;
            $payment->save();

            return redirect()->route('dashboard')->with('status', 'Payment successful!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Payment failed!');
        }
    }

    public function showReceipt(Payment $payment)
    {
        return view('payment.receipt', compact('payment'));
    }

    public function studentPaymentHistory()
    {
        $user = auth()->user();
        $payments = $user->payments()->where('status', 'paid')->get();

        return view('payment-history', compact('payments'));
    }

    public function adminPaymentHistory()
    {
        $payments = Payment::with('user')->get();

        return view('admin.payment-history', compact('payments'));
    }
}
