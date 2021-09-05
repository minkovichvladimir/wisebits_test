<?php

namespace App\Tests\Service;

class UserServiceDataProviders
{
    public static function createUserDataProvider(): array
    {
        return [
            [
                CreateUserServiceTest::MODE_REGULAR,
                [
                    'name'  => 'normallength1',
                    'email' => 't1@example.com',
                ],
            ],
            [
                CreateUserServiceTest::MODE_REGULAR,
                [
                    'name'  => 'normallength2',
                    'email' => 't2@example.com',
                    'notes' => 't2 notes',
                ],
            ],
            [
                CreateUserServiceTest::MODE_REGULAR,
                [
                    'name'  => 'normallength3',
                    'email' => 't3@example.com',
                    'notes' => null,
                ],
            ],
            [
                CreateUserServiceTest::MODE_WRONG_EMAIL,
                [
                    'name'  => 'normallength4',
                    'email' => 't4',
                ],
            ],
            [
                CreateUserServiceTest::MODE_SHORT_LENGTH,
                [
                    'name'  => 'short',
                    'email' => 't5@example.com',
                ],
            ],
            [
                CreateUserServiceTest::MODE_WRONG_NAME_CHARS,
                [
                    'name'  => 'name_contains_wrong_chars',
                    'email' => 't5@example.com',
                ],
            ],
            [
                CreateUserServiceTest::MODE_BLOCKED_NAME,
                [
                    'name'  => 'nameblocked',
                    'email' => 't6@example.com',
                ],
            ],
            [
                CreateUserServiceTest::MODE_BLOCKED_DOMAIN,
                [
                    'name'  => 'normallength7',
                    'email' => 't7@blocked.io',
                ],
            ],
            [
                CreateUserServiceTest::MODE_REQUIRED_BLANK,
                [
                    'name'  => '',
                    'email' => 't8@example.com',
                ],
            ],
            [
                CreateUserServiceTest::MODE_REQUIRED_NULL,
                [
                    'name'  => 'normallength8',
                    'email' => null,
                ],
            ],
            [
                CreateUserServiceTest::MODE_REQUIRED_NULL,
                [
                    'name'  => null,
                    'email' => 't8@example.com',
                ],
            ],
            [
                CreateUserServiceTest::MODE_NON_UNIQUE_NAME,
                [
                    'name'  => 'normallength1',
                    'email' => 't9@example.com',
                ],
            ],
            [
                CreateUserServiceTest::MODE_NON_UNIQUE_EMAIL,
                [
                    'name'  => 'normallength9',
                    'email' => 't1@example.com',
                ],
            ],
        ];
    }
}