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

    public function create(Request $request)
    {
        $paymentId = $request->input('payment_id');
        $payment = Payment::findOrFail($paymentId);

        // Create a Razorpay order
        $amount = $payment->amount;
        $order = $this->razorpayService->createOrder($amount);

        // Get the user who owns the payment
        $user = Auth::user();

        // Return the view to complete the payment
        return view('payment.pay', [
            'order' => $order,
            'amount' => $amount,
            'payment' => $payment,
            'user' => $user
        ]);
    }

    public function store(Request $request)
{
    $user = Auth::user();
    $amount = $request->input('amount');
    $order = $this->razorpayService->createOrder($amount);

    // Create a payment record with "due" status
    $payment = new Payment();
    $payment->user_id = $user->id;
    $payment->amount = $amount;
    $payment->status = 'due'; // Set status to due
    $payment->razorpay_order_id = $order['id'];
    $payment->save();

    // Pass the necessary data to the view
    return view('payment.pay', [
        'order' => $order,
        'amount' => $amount, // Ensure amount is passed here
        'user' => $user
    ]);
}

public function callback(Request $request)
{
    $attributes = [
        'razorpay_order_id' => $request->input('razorpay_order_id'),
        'razorpay_payment_id' => $request->input('razorpay_payment_id'),
        'razorpay_signature' => $request->input('razorpay_signature')
    ];

    try {
        // Verify the signature
        $this->razorpayService->verifySignature($attributes);

        // Find the payment by the Razorpay order ID
        $payment = Payment::where('razorpay_order_id', $request->input('razorpay_order_id'))->first();

        if ($payment && $payment->status === 'due') {
            // Update payment status to 'paid' and save other details
            $payment->status = 'paid';
            $payment->razorpay_payment_id = $request->input('razorpay_payment_id');
            $payment->razorpay_signature = $request->input('razorpay_signature');
            $payment->save();
        } else {
            // Handle case where payment record is not found or status is not 'due'
            return redirect()->route('dashboard')->with('error', 'Invalid payment record or payment already processed.');
        }

        return redirect()->route('dashboard')->with('status', 'Payment successful!');
    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Payment verification failed: ' . $e->getMessage());

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
