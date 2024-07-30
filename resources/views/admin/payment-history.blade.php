@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Payment History</h2>

    <div class="paid-payments">
        <h3>Paid Payments</h3>
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
                @foreach ($paidPayments as $payment)
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
        {{ $paidPayments->links() }} <!-- Pagination links for paid payments -->
    </div>

    <div class="due-payments">
        <h3>Due Payments</h3>
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
                @foreach ($duePayments as $payment)
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
        {{ $duePayments->links() }} <!-- Pagination links for due payments -->
    </div>
</div>
@endsection
