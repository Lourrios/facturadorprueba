<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Factura;

class FacturaGenerada extends Mailable
{
    use Queueable, SerializesModels;

    public $factura;
    public $pdfData;
    /**
     * Create a new message instance.
     */
    public function __construct(Factura $factura, $pdfData)
    {
        $this->factura=$factura;
        $this->pdfData = $pdfData;
        
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Factura Generada',
        );
    }


    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.factura-generada',
        );
    }


    public function build()
    {
       return $this->subject('Factura ' . $this->factura->numero_factura)
            ->markdown('emails.factura')
            ->attachData(
                $this->pdfData,
                'Factura_' . $this->factura->numero_factura . '.pdf',
                ['mime' => 'application/pdf']
            );
    }
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
