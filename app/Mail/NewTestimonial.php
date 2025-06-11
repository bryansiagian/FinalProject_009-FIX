<?php

namespace App\Mail;

use App\Models\Testimonial;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewTestimonial extends Mailable
{
    use Queueable, SerializesModels;

    public $testimonial;

    /**
     * Create a new message instance.
     */
    public function __construct(Testimonial $testimonial)
    {
        $this->testimonial = $testimonial;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Testimoni Baru Menunggu Persetujuan',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.new_testimonial', // Buat view email
            with: [
                'testimonial' => $this->testimonial,
            ]
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