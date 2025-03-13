<?php

namespace App\Jobs;

use App\Mail\OrderInvoiceMail;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;

class SendOrderInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Lưu file PDF vào storage
        $pdfPath = 'public/invoices/invoice_' . $this->order->id . '.pdf';
        $pdf = PDF::loadView('emails.pdf_template', ['order' => $this->order]);
        Storage::put($pdfPath, $pdf->output());

        // Gửi email với hóa đơn
        Mail::to($this->order->email)->send(new OrderInvoiceMail($this->order, $pdfPath));
    }
}
