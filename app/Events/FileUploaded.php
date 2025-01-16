<?php

namespace App\Events;

use App\Traits\AccountTrait;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileUploaded
{
    use Dispatchable, InteractsWithSockets, SerializesModels, AccountTrait;

    public $fileName;

    /**
     * Create a new event instance.
     */
    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }


}
