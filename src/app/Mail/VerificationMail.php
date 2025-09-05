<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $verificationUrl;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        //
        $this->user = $user;
        $this->verificationUrl = $verificationUrl;
    }

    /**
     * Get the message envelope. 헤더
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from:'from@example.come',
            subject: '이메일 인증을 완료해주세요.',
        );
    }

    /**
     * Get the message content definition. 본문
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.verification',
        );
    }

    /**
     * Get the attachments for the message. 첨부파일
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
