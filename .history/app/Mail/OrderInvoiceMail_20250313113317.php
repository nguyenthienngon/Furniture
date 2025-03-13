<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $pdf;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, $pdf)
    {
        $this->order = $order;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->markdown('emails.order_invoice')
            ->subject('Hóa đơn đơn hàng #' . $this->order->order_number)
            ->attachData($this->pdf, 'invoice.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
