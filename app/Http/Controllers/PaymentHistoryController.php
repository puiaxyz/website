<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentHistoryController extends Controller
{
    public function index()
    {
        // Fetch payment history for the logged-in user
        $payments = auth()->user()->payments; // Adjust as per your data structure
        
        return view('payment-history', compact('payments'));
    }
}
