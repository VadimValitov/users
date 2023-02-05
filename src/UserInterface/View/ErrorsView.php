<?php

declare(strict_types=1);

namespace App\UserInterface\View;

class ErrorsView extends AbstractView
{
    public function __construct(
        private readonly array $errors
    ) {
    }

    public function toArray(): array
    {
        return ['errors' => $this->errors];
    }
}
