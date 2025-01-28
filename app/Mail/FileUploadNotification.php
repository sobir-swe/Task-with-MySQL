<?php

namespace App\Mail;

use App\Traits\AccountTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FileUploadNotification extends Mailable
{
    use Queueable, SerializesModels, AccountTrait;

    protected $client;
    protected $fileName;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
        $this->client = $this->getAccount();
    }

    public function envelope(): Envelope
    {
        $this->client = $this->getAccount();
        return new Envelope(
            from: new Address($this->client->email, 'Task'),
            subject: 'File Upload Notification',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.fileUpload',
            with: [
                'FirstName' => $this->client->FirstName,
                'email' => $this->client->email,
                'fileName' => $this->fileName,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
