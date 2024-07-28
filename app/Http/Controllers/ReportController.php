<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\GenerateReport;
use App\Models\Payment;
use Carbon\Carbon;
use PDF;

class ReportController extends Controller
{
    public function index()
    {
        $monthlyPayments = Payment::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->get();

        $paymentStatuses = Payment::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        return view('admin.reports.index', compact('monthlyPayments', 'paymentStatuses'));
    }

    public function generate(Request $request)
    {
        GenerateReport::dispatch();

        return redirect()->route('admin.reports')->with('status', 'Report generation started!');
    }
}
