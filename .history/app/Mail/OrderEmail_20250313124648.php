<?php
namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade as PDF;

class OrderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $pdf;

    public function __construct($order, $pdf)
    {
        $this->order = $order;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject('Xác nhận đơn hàng #' . $this->order->order_number)
                    ->view('email.order')
                    ->attachData($this->pdf->output(), "order_{$this->order->id}.pdf", [
                        'mime' => 'application/pdf',
                    ]);
    }
}
