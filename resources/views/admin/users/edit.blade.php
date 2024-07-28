@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
        </div>
        <div class="form-group">
            <label for="password">Password (leave blank to keep current password)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>
        <div class="form-group">
            <label for="usertype">User Type</label>
            <select class="form-control" id="usertype" name="usertype" required>
                <option value="student" {{ $user->usertype == 'student' ? 'selected' : '' }}>Student</option>
                <option value="admin" {{ $user->usertype == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
@endsection
