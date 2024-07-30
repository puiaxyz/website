<?php

namespace App\Jobs;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use TCPDF;

class GenerateReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function handle()
    {
        $payments = Payment::with('user') // Assuming the Payment model has a user relationship
            ->where('status', 'paid')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->get();

        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);

        $html = '<h1>Payments Report</h1>';
        $html .= '<table border="1" cellpadding="5">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Username</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($payments as $payment) {
            $html .= '<tr>
                        <td>' . $payment->razorpay_order_id . '</td>
                        <td>' . $payment->user->name . '</td> <!-- Assuming user relationship exists -->
                        <td>' . $payment->amount . '</td>
                        <td>' . $payment->status . '</td>
                        <td>' . $payment->created_at->format('Y-m-d') . '</td>
                      </tr>';
        }

        $html .= '   </tbody>
                  </table>';

        $pdf->writeHTML($html, true, false, true, false, '');

        // Save the PDF to storage and return the path
        $path = storage_path('app/reports/payments_report.pdf');
        $pdf->Output($path, 'F');

        return $path;
    }
}
