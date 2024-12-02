<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\UploadedFile;

class ContactoMailable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $contacto;
    public $subject;
    public $adjunto;

    public function __construct($contacto, UploadedFile $adjunto = null)
    {
        $this->from($contacto['correo_remitente']);
        $this->contacto = $contacto;
        $this->subject = $contacto['asunto'];
        $this->adjunto = $adjunto;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contacto Mailable',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.email',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return $this->adjunto ? [
            Attachment::fromData(fn() => $this->adjunto->get(), 'PlanNutricional.pdf')->withMime('application/pdf')
        ] : [];
    }
}







