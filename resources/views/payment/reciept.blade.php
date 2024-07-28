@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Payment Receipt</h1>
    <p><strong>Amount:</strong> {{ $payment->amount }}</p>
    <p><strong>Date:</strong> {{ $payment->created_at }}</p>
    <p><strong>Status:</strong> {{ $payment->status }}</p>
    <p><strong>Transaction ID:</strong> {{ $payment->razorpay_payment_id }}</p>
</div>
@endsection
