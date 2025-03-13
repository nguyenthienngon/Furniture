<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $pdf)
    {
        $this->order = $order;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->markdown('emails.order_invoice')
            ->subject('Hóa đơn đơn hàng #' . $this->order->order_number)
            ->attachData($this->pdf, 'invoice.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
