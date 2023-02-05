<?php

declare(strict_types=1);

namespace UseCaseTest\Service;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use App\UseCase\Exception\EmailExistsException;
use App\UseCase\Exception\UserNameExistsException;
use App\UseCase\Exception\WrongEmailException;
use App\UseCase\Exception\WrongNameException;
use App\UseCase\Service\UserCheckingService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UserCheckingServiceTest extends TestCase
{
    private UserCheckingService $service;

    private UserRepository&MockObject $userRepository;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);

        $this->service = new UserCheckingService(
            $this->userRepository,
        );
    }

    public function testFailWithWrongName(): void
    {
        self::expectException(WrongNameException::class);

        $this->service->check('badusername', 'email@local.lan');
    }

    public function testFailWithWrongEmail(): void
    {
        self::expectException(WrongEmailException::class);

        $this->service->check('username', 'bad-domain@local.lan');
    }

    public function testFailWhenUserNameExists(): void
    {
        $user = $this->createMock(User::class);
        $user->method('getId')
            ->willReturn(1);

        $this->userRepository->method('findByName')
            ->willReturn($user);

        self::expectException(UserNameExistsException::class);

        $this->service->check('username', 'email@local.lan');
    }

    public function testFailWhenUserEmailExists(): void
    {
        $user = $this->createMock(User::class);
        $user->method('getId')
            ->willReturn(1);

        $this->userRepository->method('findByEmail')
            ->willReturn($user);

        self::expectException(EmailExistsException::class);

        $this->service->check('username', 'email@local.lan');
    }

    public function testSuccess(): void
    {
        $result = $this->service->check('username', 'email@local.lan');

        self::assertTrue($result);
    }

    public function testSuccessWithSameUser(): void
    {
        $user = $this->createMock(User::class);
        $userId = 1;

        $user->method('getId')
            ->willReturn($userId);

        $this->userRepository->method('findByEmail')
            ->willReturn($user);

        $result = $this->service->check('username', 'email@local.lan', $userId);

        self::assertTrue($result);
    }
}
