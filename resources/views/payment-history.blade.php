@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Payment History</h2>
    <table class="table">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Payment ID</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ auth()->user()->id }}</td>
                    <td>{{ auth()->user()->name }}</td>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->amount }}</td>
                    <td>{{ $payment->status }}</td>
                    <td>{{ $payment->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
