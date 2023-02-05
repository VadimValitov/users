<?php

declare(strict_types=1);

namespace DomainTest\Entity;

use App\Domain\Entity\User;
use DateTime;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testCreate(): void
    {
        $name = 'name';
        $email = 'email';
        $notes = 'notes';

        $user = new User($name, $email, $notes);

        self::assertEquals($name, $user->getName());
        self::assertEquals($email, $user->getEmail());
        self::assertEquals($notes, $user->getNotes());
        self::assertNull($user->getDeleted());
        self::assertTrue($user->isActive());
    }

    public function testUpdate(): void
    {
        $name = 'name';
        $email = 'email';
        $notes = 'notes';

        $user = new User('', '', '');
        $user->update($name, $email, $notes);

        self::assertEquals($name, $user->getName());
        self::assertEquals($email, $user->getEmail());
        self::assertEquals($notes, $user->getNotes());
    }

    public function testDelete(): void
    {
        $user = new User('', '', '');
        $deleted = new DateTime();

        $user->setDeleted($deleted);

        self::assertEquals($deleted, $user->getDeleted());
        self::assertFalse($user->isActive());
    }
}
