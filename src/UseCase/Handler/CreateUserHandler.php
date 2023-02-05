<?php

declare(strict_types=1);

namespace App\UseCase\Handler;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use App\UseCase\Dto\CreateUserHandlerDto;
use App\UseCase\Exception\EmailExistsException;
use App\UseCase\Exception\UserNameExistsException;
use App\UseCase\Exception\WrongEmailException;
use App\UseCase\Exception\WrongNameException;
use Doctrine\ORM\EntityManager;

use function str_contains;

class CreateUserHandler
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EntityManager $entityManager,
    ) {
    }

    public function handle(CreateUserHandlerDto $dto): User
    {
        $this->checkName($dto->name);
        $this->checkEmailDomain($dto->email);

        $user = $this->userRepository->findByName($dto->name);

        if ($user) {
            throw new UserNameExistsException();
        }

        $user = $this->userRepository->findByEmail($dto->email);

        if ($user) {
            throw new EmailExistsException();
        }

        $user = new User(
            $dto->name,
            $dto->email,
            $dto->notes,
        );

        $this->userRepository->add($user);
        $this->entityManager->flush();

        return $user;
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
