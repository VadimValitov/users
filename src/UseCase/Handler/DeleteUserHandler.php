<?php

declare(strict_types=1);

namespace App\UseCase\Handler;

use App\Domain\Repository\UserRepository;
use App\UseCase\Dto\DeleteUserHandlerDto;
use App\UseCase\Exception\UserNotFoundException;
use DateTime;
use Doctrine\ORM\EntityManager;

class DeleteUserHandler
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EntityManager $entityManager,
    ) {
    }

    public function handle(DeleteUserHandlerDto $dto): void
    {
        $user = $this->userRepository->find($dto->id);

        if (!$user || !$user->isActive()) {
            throw new UserNotFoundException();
        }

        $user->setDeleted(new DateTime());

        $this->entityManager->flush();
    }
}
