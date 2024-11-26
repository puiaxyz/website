<!DOCTYPE html>
<html>
<head>
    <title>Payments Report</title>
</head>
<body>
    <h1>Payments Report</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Username</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->razorpay_order_id }}</td>
                    <td>{{ $payment->user->username }}</td> 
                    <td>{{ $payment->amount }}</td>
                    <td>{{ $payment->status }}</td>
                    <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
