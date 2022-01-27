<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\UploadMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UploadMessageHandler implements MessageHandlerInterface
{

    public function __invoke(UploadMessage $message)
    {
        dd($message);
    }
}
