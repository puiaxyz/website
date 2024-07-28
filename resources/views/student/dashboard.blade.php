@extends('layouts.app')

@section('content')
<div class="container">
    <div class="dashboard-header">
        <h1>Student Dashboard</h1>
    </div>

    <div class="dashboard-content">
        <div>
            <h2>Profile</h2>
            <p>Name: {{ $user->name }}</p>
            <p>Email: {{ $user->email }}</p>
        </div>

        <div>
            <h2>Payments</h2>
            <button id="togglePayments" class="btn">Show Due Payments</button>

            <div id="duePayments" style="display: none;">
                <h3>Due Payments</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($duePayments as $payment)
                            <tr>
                                <td>{{ $payment->amount }}</td>
                                <td>{{ $payment->status }}</td>
                                <td><a href="{{ route('payment.create') }}" class="btn btn-primary">Pay Now</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="paidPayments">
                <h3>Paid Payments</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Receipt</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paidPayments as $payment)
                            <tr>
                                <td>{{ $payment->amount }}</td>
                                <td>{{ $payment->status }}</td>
                                <td><a href="{{ route('payment.receipt', $payment) }}" class="btn btn-primary">View Receipt</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('togglePayments').addEventListener('click', function() {
        var duePayments = document.getElementById('duePayments');
        var paidPayments = document.getElementById('paidPayments');
        if (duePayments.style.display === 'none') {
            duePayments.style.display = 'block';
            paidPayments.style.display = 'none';
            this.textContent = 'Show Paid Payments';
        } else {
            duePayments.style.display = 'none';
            paidPayments.style.display = 'block';
            this.textContent = 'Show Due Payments';
        }
    });
</script>
@endsection
