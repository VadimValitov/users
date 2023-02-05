<?php

declare(strict_types=1);

namespace App\UseCase\Handler;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use App\UseCase\Dto\UpdateUserHandlerDto;
use App\UseCase\Exception\UserNotFoundException;
use App\UseCase\Service\UserCheckingService;
use Doctrine\ORM\EntityManager;

class UpdateUserHandler
{
    public function __construct(
        private readonly UserCheckingService $userCheckingService,
        private readonly UserRepository $userRepository,
        private readonly EntityManager $entityManager,
    ) {
    }

    public function handle(UpdateUserHandlerDto $dto): User
    {
        $user = $this->userRepository->find($dto->id);

        if (!$user || !$user->isActive()) {
            throw new UserNotFoundException();
        }

        $this->userCheckingService->check($dto->name, $dto->email, $user->getId());

        $user->update(
            $dto->name,
            $dto->email,
            $dto->notes,
        );

        $this->entityManager->flush();

        return $user;
    }
}
