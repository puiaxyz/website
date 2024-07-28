@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Initiate Payment</h1>
    <form action="{{ route('payment.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="text" class="form-control" id="amount" name="amount" required>
        </div>
        <button type="submit" class="btn btn-primary">Pay Now</button>
    </form>
</div>
@endsection
