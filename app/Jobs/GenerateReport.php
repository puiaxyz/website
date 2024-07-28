<?php

namespace App\Jobs;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PDF;

class GenerateReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        $payments = Payment::all();
        $pdf = PDF::loadView('admin.reports.pdf', compact('payments'));
        $pdf->save(storage_path('app/reports/payments_report.pdf'));

        // Optionally, you can notify the admin about the report generation
    }
}
