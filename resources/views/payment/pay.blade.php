@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pay Now</h1>
    <form action="{{ route('payment.callback') }}" method="POST" id="paymentForm">
        @csrf
        <input type="hidden" name="razorpay_order_id" value="{{ $order['id'] }}">
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_signature" id="razorpay_signature">

        <button id="payButton" class="btn btn-primary">Pay with Razorpay</button>
    </form>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.getElementById('payButton').addEventListener('click', function(e) {
    e.preventDefault();

    var options = {
        "key": "{{ config('services.razorpay.key') }}",
        "amount": "{{ $amount * 100 }}",
        "currency": "INR",
        "name": "{{ $user->name }}",
        "description": "Test Transaction",
        "order_id": "{{ $order['id'] }}",
        "handler": function (response){
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            document.getElementById('razorpay_signature').value = response.razorpay_signature;
            document.getElementById('paymentForm').submit();
        },
        "prefill": {
            "name": "{{ $user->name }}",
            "email": "{{ $user->email }}"
        },
        "theme": {
            "color": "#3399cc"
        }
    };

    var rzp1 = new Razorpay(options);
    rzp1.open();
});
</script>
@endsection
