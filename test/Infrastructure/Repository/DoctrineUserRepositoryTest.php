<?php

declare(strict_types=1);

namespace InfrastructureTest\Repository;

use App\Domain\Entity\User;
use App\Infrastructure\Repository\DoctrineUserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DoctrineUserRepositoryTest extends TestCase
{
    private DoctrineUserRepository $repository;

    private EntityRepository&MockObject $entityRepository;

    private EntityManager&MockObject $entityManager;

    protected function setUp(): void
    {
        $this->entityRepository = $this->createMock(EntityRepository::class);
        $this->entityManager = $this->createMock(EntityManager::class);

        $this->repository = new DoctrineUserRepository(
            $this->entityRepository,
            $this->entityManager
        );
    }

    public function testAdd(): void
    {
        $this->entityManager->expects(self::once())
            ->method('persist');

        $user = $this->createMock(User::class);
        $this->repository->add($user);
    }

    public function testFind(): void
    {
        $id = 1;

        $this->entityRepository->expects(self::once())
            ->method('find')
            ->with($id);

        $this->repository->find($id);
    }

    public function testFindByName(): void
    {
        $name = 'name';

        $this->entityRepository->expects(self::once())
            ->method('findOneBy')
            ->with(['name' => $name]);

        $this->repository->findByName($name);
    }

    public function testFindByEmail(): void
    {
        $email = 'email';

        $this->entityRepository->expects(self::once())
            ->method('findOneBy')
            ->with(['email' => $email]);

        $this->repository->findByEmail($email);
    }
}
