<!-- resources/views/admin/reports/pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Payments Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Payments Report</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->user->name }}</td>
                    <td>{{ $payment->amount }}</td>
                    <td>{{ $payment->status }}</td>
                    <td>{{ $payment->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
