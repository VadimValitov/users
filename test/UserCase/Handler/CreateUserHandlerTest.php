<?php

declare(strict_types=1);

namespace UseCaseTest\Handler;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use App\UseCase\Dto\CreateUserHandlerDto;
use App\UseCase\Exception\EmailExistsException;
use App\UseCase\Exception\UserNameExistsException;
use App\UseCase\Exception\WrongEmailException;
use App\UseCase\Exception\WrongNameException;
use App\UseCase\Handler\CreateUserHandler;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateUserHandlerTest extends TestCase
{
    private CreateUserHandler $handler;

    private UserRepository&MockObject $userRepository;

    private EntityManager&MockObject $entityManager;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->entityManager = $this->createMock(EntityManager::class);

        $this->handler = new CreateUserHandler(
            $this->userRepository,
            $this->entityManager
        );
    }

    public function testFailWithWrongName(): void
    {
        self::expectException(WrongNameException::class);

        $dto = new CreateUserHandlerDto(
            'badusername',
            'email@local.lan',
            null
        );

        $this->handler->handle($dto);
    }

    public function testFailWithWrongEmail(): void
    {
        self::expectException(WrongEmailException::class);

        $dto = new CreateUserHandlerDto(
            'username',
            'bad-domain@local.lan',
            null
        );

        $this->handler->handle($dto);
    }

    public function testFailWhenUserNameExists(): void
    {
        $this->userRepository->method('findByName')
            ->willReturn($this->createMock(User::class));

        self::expectException(UserNameExistsException::class);

        $dto = new CreateUserHandlerDto(
            'username',
            'email@local.lan',
            null
        );

        $this->handler->handle($dto);
    }

    public function testFailWhenUserEmailExists(): void
    {
        $this->userRepository->method('findByEmail')
            ->willReturn($this->createMock(User::class));

        self::expectException(EmailExistsException::class);

        $dto = new CreateUserHandlerDto(
            'username',
            'email@local.lan',
            null
        );

        $this->handler->handle($dto);
    }

    public function testSuccess(): void
    {
        $this->userRepository->expects(self::once())
            ->method('add');

        $this->entityManager->expects(self::once())
            ->method('flush');

        $dto = new CreateUserHandlerDto(
            'username',
            'email@local.lan',
            'notes text'
        );

        $user = $this->handler->handle($dto);

        self::assertEquals($dto->name, $user->getName());
        self::assertEquals($dto->email, $user->getEmail());
        self::assertEquals($dto->notes, $user->getNotes());
    }
}
