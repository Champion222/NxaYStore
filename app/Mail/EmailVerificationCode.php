<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailVerificationCode extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $code,
        public array $brand = []
    ) {
    }

    public function envelope(): Envelope
    {
        $brandName = $this->brand['name'] ?? config('app.name');

        return new Envelope(
            subject: $brandName . ' Email Verification Code'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verify-code',
            with: [
                'user' => $this->user,
                'code' => $this->code,
                'brand' => $this->brand,
                'expiresIn' => 15,
            ]
        );
    }
}
