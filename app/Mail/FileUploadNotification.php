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

    protected $account;
    protected $fileName;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
        $this->account = $this->getAccount();
    }

    public function envelope(): Envelope
    {
        $this->account = $this->getAccount();
        return new Envelope(
            from: new Address($this->account->email, 'Task'),
            subject: 'File Upload Notification',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.fileUpload',
            with: [
                'FirstName' => $this->account->FirstName,
                'email' => $this->account->email,
                'fileName' => $this->fileName,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
