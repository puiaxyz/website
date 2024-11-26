@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Assign Payment</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.assign.payment.submit') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="payment_amount">Payment Amount</label>
            <input type="number" name="payment_amount" id="payment_amount" class="form-control" min="0" required>
        </div>
        <div class="form-group">
            <label for="user_ids">Select Students</label>
            <select name="user_ids[]" id="user_ids" class="form-control" multiple required>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">
                        {{ $student->name }} (Due: {{ $student->payments->sum('amount') }} {{ config('app.currency', 'INR') }})
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Assign Payment</button>
    </form>
</div>
@endsection
