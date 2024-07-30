<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentHistoryController extends Controller
{
    public function adminPaymentHistory()
    {
        // Fetch paid and due payments with pagination
        $paidPayments = Payment::where('status', 'paid')->paginate(10);
        $duePayments = Payment::where('status', 'due')->paginate(10);

        return view('admin.payment-history', compact('paidPayments', 'duePayments'));
    }
}
