<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Transaksi;

class StrukPembayaranMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaksi;

    /**
     * Create a new message instance.
     */
    public function __construct(Transaksi $transaksi)
    {
        $this->transaksi = $transaksi;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Struk Pembayaran Klinik Gigi Maxilla - #' . str_pad($this->transaksi->id_transaksi, 10, '0', STR_PAD_LEFT),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.struk',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
