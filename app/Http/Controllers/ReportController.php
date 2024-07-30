<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\GenerateReport;
use App\Models\Payment;
use Carbon\Carbon;

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
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Dispatch job with date range parameters
        $reportJob = new GenerateReport($startDate, $endDate);
        $path = $reportJob->handle();

        // Return a response to initiate file download
        return response()->download($path);
    }
}
