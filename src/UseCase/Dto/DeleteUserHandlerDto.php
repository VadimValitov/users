<?php

declare(strict_types=1);

namespace App\UseCase\Dto;

class DeleteUserHandlerDto
{
    public function __construct(
        public readonly int $id,
    ) {
    }
}
