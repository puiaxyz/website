<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'usertype' => 'required|string|in:admin,student',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->usertype = $request->usertype;
        $user->save();

        return redirect()->route('admin.dashboard')->with('status', 'User created successfully!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'usertype' => 'required|string|in:admin,student',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->usertype = $request->usertype;
        $user->save();

        return redirect()->route('admin.dashboard')->with('status', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.dashboard')->with('status', 'User deleted successfully!');
    }
    public function index()
    {
        $students = User::where('usertype', 'student')->get();
        return view('admin.manage-users', compact('students'));
    }
    public function showAssignPaymentForm()
{
    $students = User::where('usertype', 'student')->with(['payments' => function ($query) {
        $query->where('status', 'due');
    }])->get();

    return view('admin.assign-payment', compact('students'));
}

public function assignPayments(Request $request)
{
    $request->validate([
        'user_ids' => 'required|array',
        'user_ids.*' => 'exists:users,id',
        'payment_amount' => 'required|numeric|min:0',
    ]);

    foreach ($request->user_ids as $userId) {
        $user = User::findOrFail($userId);
        $user->payments()->create([
            'amount' => $request->payment_amount,
            'status' => 'due',
        ]);
    }

    return redirect()->route('admin.assign.payment')->with('success', 'Payments assigned successfully.');
}
}
