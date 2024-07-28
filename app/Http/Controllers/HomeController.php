<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function redirectToDashboard()
{
    $user = auth()->user();

    if ($user->usertype === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('dashboard');
}


    public function studentDashboard()
    {
        $user = auth()->user();
        $paidPayments = $user->payments()->where('status', 'paid')->get();
        $duePayments = $user->payments()->where('status', 'due')->get();

        return view('student.dashboard', compact('user', 'paidPayments', 'duePayments'));
    }

    public function adminDashboard()
    {
        // Retrieve students and their payment info
        $students = User::where('usertype', 'student')->with('payments')->get();
        
        // Retrieve recent transactions
        $recentTransactions = Payment::orderBy('created_at', 'desc')->take(10)->get();

        // Prepare data for payment stats chart
        $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $chartData = [];

        foreach ($chartLabels as $month) {
            $chartData[] = Payment::whereMonth('created_at', Carbon::parse($month)->month)->sum('amount');
        }

        return view('admin.dashboard', compact('students', 'recentTransactions', 'chartLabels', 'chartData'));
    }
    public function generateReports()
    {
        return view('admin.reports.index');
    }
    
}
