@extends('layouts.app')
@vite(['resources/js/app.js', 'resources/css/app.css'])
@section('content')
<div class="container">
    <div class="payment-history-table">
        <h2>Payment History</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Payment Description</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date/Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->user_id }}</td>
                    <td>{{ $payment->user->name }}</td>
                    <td>{{ $payment->description }}</td>
                    <td>{{ $payment->amount }}</td>
                    <td>{{ $payment->status }}</td>
                    <td>{{ $payment->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
