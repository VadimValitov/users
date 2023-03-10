<?php

declare(strict_types=1);

namespace App\UseCase\Handler;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use App\UseCase\Dto\CreateUserHandlerDto;
use App\UseCase\Service\UserCheckingService;
use Doctrine\ORM\EntityManager;

class CreateUserHandler
{
    public function __construct(
        private readonly UserCheckingService $userCheckingService,
        private readonly UserRepository $userRepository,
        private readonly EntityManager $entityManager,
    ) {
    }

    public function handle(CreateUserHandlerDto $dto): User
    {
        $this->userCheckingService->check($dto->name, $dto->email);

        $user = new User(
            $dto->name,
            $dto->email,
            $dto->notes,
        );

        $this->userRepository->add($user);
        $this->entityManager->flush();

        return $user;
    }
}
