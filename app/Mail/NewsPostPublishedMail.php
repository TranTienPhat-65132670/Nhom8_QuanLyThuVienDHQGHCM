<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsPostPublishedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public object $post) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tin tức mới từ Thư viện ĐHQG-HCM: '.$this->post->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.news-post-published',
            with: [
                'post' => $this->post,
                'newsUrl' => route('news.show', $this->post->id),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
