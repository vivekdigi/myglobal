<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoicePayment extends Mailable
{
    use Queueable, SerializesModels;
    public Invoice $invoice;
    public $title;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice, string $title)
    {
        $this->invoice = $invoice;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.invoice')
            ->subject($this->title);
    }
}
