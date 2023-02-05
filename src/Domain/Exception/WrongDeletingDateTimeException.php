<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use DomainException;

class WrongDeletingDateTimeException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Wrong deleting datetime');
    }
}
