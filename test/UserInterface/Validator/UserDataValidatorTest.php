<?php

declare(strict_types=1);

namespace UserInterfaceTest\Validator;

use App\UserInterface\Validator\UserDataValidator;
use PHPUnit\Framework\TestCase;

use function array_keys;

class UserDataValidatorTest extends TestCase
{
    private UserDataValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new UserDataValidator();
    }

    /**
     * @dataProvider getFailData
     */
    public function testFailWithWrongData(array $data, array $errorFields): void
    {
        self::assertEquals([], $this->validator->validate($data));
        self::assertEquals($errorFields, array_keys($this->validator->getErrors()));
    }

    public function testSuccess(): void
    {
        $data = [
            'name' => 'username',
            'email' => 'email@email.ru',
            'notes' => 'notes text',
        ];

        $expected = $data;
        $data['test'] = 'test';

        self::assertEquals($expected, $this->validator->validate($data));
    }

    private function getFailData(): array
    {
        return [
            [
                'data' => [],
                'errorFields' => ['name', 'email'],
            ],
            [
                'data' => [
                    'name' => '',
                    'email' => '',
                ],
                'errorFields' => ['name', 'email'],
            ],
            [
                'data' => [
                    'name' => 'name', // too short
                    'email' => 'email',
                ],
                'errorFields' => ['name', 'email'],
            ],
            [
                'data' => [
                    'name' => 'user_name', // wrong symbols
                    'email' => 'email@local.lan', // wrong domain
                ],
                'errorFields' => ['name', 'email'],
            ],
        ];
    }
}
