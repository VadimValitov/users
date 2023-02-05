<?php

declare(strict_types=1);

namespace App\UseCase\Dto;

class GetUserHandlerDto
{
    public function __construct(
        public readonly int $id,
    ) {
    }
}
