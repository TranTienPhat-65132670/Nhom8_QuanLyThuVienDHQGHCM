<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendOTPMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $student_code;

    public function __construct($otp, $student_code)
    {
        $this->otp = $otp;
        $this->student_code = $student_code;
    }

    public function build()
    {
        return $this->subject('Mã xác thực OTP khôi phục mật khẩu')
            ->html("
                    <div style='font-family: Arial, sans-serif; padding: 20px; color: #333;'>
                        <h2>Mã Xác Thực OTP</h2>
                        <p>Xin chào sinh viên có MSSV: <strong>{$this->student_code}</strong>,</p>
                        <p>Mã OTP để khôi phục mật khẩu của bạn là:</p>
                        <h1 style='color: #0d9488; letter-spacing: 5px;'>{$this->otp}</h1>
                        <p>Mã này có hiệu lực trong <strong>5 phút</strong>. Vui lòng không chia sẻ mã này cho bất kỳ ai.</p>
                    </div>
                    ");
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send O T P Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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
