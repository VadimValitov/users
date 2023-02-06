<?php

declare(strict_types=1);

namespace InfrastructureTest\Repository;

use App\Infrastructure\Repository\DoctrineUserRepository;
use App\Infrastructure\Repository\DoctrineUserRepositoryFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class DoctrineUserRepositoryFactoryTest extends TestCase
{
    public function testSuccess(): void
    {
        $entityManager = $this->createMock(EntityManager::class);
        $entityManager->method('getRepository')
            ->willReturn($this->createMock(EntityRepository::class));

        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')
            ->willReturnMap(
                [
                    [EntityManager::class, $entityManager],
                ]
            );

        $controller = (new DoctrineUserRepositoryFactory())($container);

        self::assertInstanceOf(DoctrineUserRepository::class, $controller);
    }
}
