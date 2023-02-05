<?php

declare(strict_types=1);

namespace App\UseCase\Service;

use App\Domain\Repository\UserRepository;
use App\UseCase\Exception\EmailExistsException;
use App\UseCase\Exception\UserNameExistsException;
use App\UseCase\Exception\WrongEmailException;
use App\UseCase\Exception\WrongNameException;

class UserCheckingService
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    public function check(string $name, string $email, ?int $userId = null): void
    {
        $this->checkName($name);
        $this->checkEmailDomain($email);

        $user = $this->userRepository->findByName($name);

        if ($user && $user->getId() !== $userId) {
            throw new UserNameExistsException();
        }

        $user = $this->userRepository->findByEmail($email);

        if ($user && $user->getId() !== $userId) {
            throw new EmailExistsException();
        }
    }

    /**
     * Here is the bad-words checking stub
     */
    private function checkName(string $name): void
    {
        if (str_contains($name, 'badusername')) {
            throw new WrongNameException();
        }
    }

    /**
     * Here is the email domain checking stub
     */
    private function checkEmailDomain(string $email): void
    {
        if (str_contains($email, 'bad-domain')) {
            throw new WrongEmailException();
        }
    }
}
