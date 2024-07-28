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

}
