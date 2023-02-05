<?php

declare(strict_types=1);

namespace App\UseCase\Handler;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use App\UseCase\Dto\GetUserHandlerDto;
use App\UseCase\Exception\UserNotFoundException;

class GetUserHandler
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    public function handle(GetUserHandlerDto $dto): User
    {
        $user = $this->userRepository->find($dto->id);

        if (!$user || !$user->isActive()) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}
