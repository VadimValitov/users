<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\User;

interface UserRepository
{
    public function add(User $user): void;

    public function find(int $userId): ?User;

    public function findByName(string $name): ?User;

    public function findByEmail(string $email): ?User;
}
