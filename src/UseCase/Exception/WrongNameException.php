<?php

declare(strict_types=1);

namespace App\UseCase\Exception;

use RuntimeException;

class WrongNameException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Wrong user name');
    }
}
