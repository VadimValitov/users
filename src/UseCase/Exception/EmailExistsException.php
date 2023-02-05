<?php

declare(strict_types=1);

namespace App\UseCase\Exception;

use RuntimeException;

class EmailExistsException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Email already exists');
    }
}
