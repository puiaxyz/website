@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Reports</h1>

    <form action="{{ route('admin.reports.generate') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Generate Report</button>
    </form>

    @if (session('status'))
        <div class="alert alert-success mt-3">
            {{ session('status') }}
        </div>
    @endif

    <div class="mt-4">
        <h2>Monthly Payments</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($monthlyPayments as $payment)
                    <tr>
                        <td>{{ \Carbon\Carbon::create()->month($payment->month)->format('F') }}</td>
                        <td>{{ $payment->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <h2>Payment Statuses</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paymentStatuses as $status)
                    <tr>
                        <td>{{ $status->status }}</td>
                        <td>{{ $status->count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
