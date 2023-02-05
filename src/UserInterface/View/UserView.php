<?php

declare(strict_types=1);

namespace App\UserInterface\View;

use App\Domain\Entity\User;

class UserView extends AbstractView
{
    public function __construct(
        private readonly User $user
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->user->getId(),
            'name' => $this->user->getName(),
            'email' => $this->user->getEmail(),
            'notes' => $this->user->getNotes(),
            'created' => $this->user->getCreated()->format('Y-m-d H:i:s'),
        ];
    }
}
