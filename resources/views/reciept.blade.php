@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Payment Receipt</h1>
    <p><strong>Transaction ID:</strong> {{ $payment->transaction_id }}</p>
    <p><strong>Amount:</strong> {{ $payment->amount }}</p>
    <p><strong>Date:</strong> {{ $payment->created_at }}</p>
    <p><strong>Status:</strong> {{ $payment->status }}</p>
    <!-- Add more receipt details as needed -->
</div>
@endsection
