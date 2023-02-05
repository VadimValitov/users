<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\User;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class DoctrineUserRepositoryFactory
{
    public function __invoke(ContainerInterface $container): DoctrineUserRepository
    {
        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);

        return new DoctrineUserRepository(
            $entityManager->getRepository(User::class),
            $entityManager
        );
    }
}
