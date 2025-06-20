<?php

namespace App\Mail;

use App\Models\User; // Import model User
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user; // Properti publik untuk mengakses data user di view
    public $verificationLink; // Properti publik untuk link verifikasi

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, string $verificationLink)
    {
        $this->user = $user;
        $this->verificationLink = $verificationLink;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verifikasi Akun Anda',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.verify_email', // Nama view Blade untuk konten email
            with: [
                'userName' => $this->user->nama_lengkap,
                'link' => $this->verificationLink,
            ],
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