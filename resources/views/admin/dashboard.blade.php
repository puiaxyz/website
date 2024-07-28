@extends('layouts.app')

@section('content')
<div class="container admin-dashboard">
    <div class="dashboard-header">
        <h1 class="text-2xl font-bold">Admin Dashboard</h1>
    </div>

    <div class="dashboard-content">
        <div class="col-span-2">
            <h2 class="text-xl font-semibold">Recent Transactions</h2>
            <table class="table">
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
                    @foreach ($recentTransactions as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->user->name }}</td>
                            <td>{{ $transaction->amount }}</td>
                            <td>{{ $transaction->status }}</td>
                            <td>{{ $transaction->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>
            <h2 class="text-xl font-semibold">Payment Stats</h2>
            <canvas id="paymentChart"></canvas>
        </div>

        <div>
            <h2 class="text-xl font-semibold">Manage Users</h2>
            <a href="{{ route('admin.users.create') }}" class="btn">Add User</a>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->id }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->usertype }}</td>
                            <td>
                                <a href="{{ route('admin.users.edit', $student) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.users.destroy', $student) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>
            <h2 class="text-xl font-semibold">Reports</h2>
            <form action="{{ route('admin.reports.generate') }}" method="POST">
                @csrf
                <button type="submit" class="btn">Generate Report</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('paymentChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Payments',
                data: @json($chartData),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
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
