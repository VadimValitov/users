<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class DoctrineUserRepository implements UserRepository
{
    public function __construct(
        private readonly EntityRepository $repository,
        private readonly EntityManager $entityManager
    ) {
    }

    public function add(User $user): void
    {
        $this->entityManager->persist($user);
    }

    public function find(int $userId): ?User
    {
        return $this->repository->find($userId);
    }

    public function findByName(string $name): ?User
    {
        return $this->repository->findOneBy(['name' => $name]);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->repository->findOneBy(['email' => $email]);
    }
}
