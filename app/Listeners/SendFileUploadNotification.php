<?php

namespace App\Listeners;

use App\Events\FileUploaded;
use App\Mail\FileUploadNotification;
use App\Traits\AccountTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendFileUploadNotification
{
	use AccountTrait;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

	/**
	 * Handle the event.
	 * @param FileUploaded $event
	 */
	public function handle(FileUploaded $event): void
	{
		$fileName = $event->fileName;

		$client = $this->getAccount();

		Mail::to(auth()->user())->send(new FileUploadNotification($fileName));

	}

}
