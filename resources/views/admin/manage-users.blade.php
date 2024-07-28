<!-- resources/views/admin/manage-users.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Users</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-2">Add User</a>
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
                        <form action="{{ route('admin.users.destroy', $student) }}" method="POST" style="display:inline-block;">
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
@endsection
