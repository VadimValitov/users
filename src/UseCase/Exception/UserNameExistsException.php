<?php

declare(strict_types=1);

namespace App\UseCase\Exception;

use RuntimeException;

class UserNameExistsException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('User name already exists');
    }
}
