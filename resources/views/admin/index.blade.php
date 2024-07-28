@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <div class="row">
        <div class="col-md-6">
            <h2>Recent Transactions</h2>
            <ul class="list-group">
                @foreach($recentTransactions as $transaction)
                    <li class="list-group-item">
                        {{ $transaction->user->name }} - {{ $transaction->amount }} - {{ $transaction->status }}
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-6">
            <h2>Payment Stats</h2>
            <canvas id="paymentChart"></canvas>
        </div>
    </div>
    <div class="mt-4">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Create New User</a>
    </div>
    <div class="mt-4">
        <h2>Users</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ ucfirst($student->usertype) }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $student->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.users.destroy', $student->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('paymentChart').getContext('2d');
    var paymentChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Payments',
                data: @json($chartData),
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
