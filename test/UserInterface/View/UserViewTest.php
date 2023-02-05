<?php

declare(strict_types=1);

namespace UserInterfaceTest\View;

use App\Domain\Entity\User;
use App\UserInterface\View\UserView;
use DateTime;
use PHPUnit\Framework\TestCase;

class UserViewTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = $this->createMock(User::class);
        $user->method('getId')
            ->willReturn(1);

        $user->method('getName')
            ->willReturn('username');

        $user->method('getEmail')
            ->willReturn('email');

        $user->method('getNotes')
            ->willReturn('notes text');

        $user->method('getCreated')
            ->willReturn(new DateTime());


        $view = new UserView($user);

        $expected = [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'notes' => $user->getNotes(),
            'created' => $user->getCreated()->format('Y-m-d H:i:s')
        ];

        self::assertEquals($expected, $view->toArray());
    }
}
