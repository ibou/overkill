<?php

declare(strict_types=1);

namespace App\Message;

use App\Entity\User;

class UploadMessage
{
    public function __construct(private string $upload, private string $user)
    {
    }

    public function getUpload(): string
    {
        return $this->upload;
    }

    public function getUser(): string
    {
        return $this->user;
    }

}
