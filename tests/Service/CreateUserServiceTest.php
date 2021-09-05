<?php

namespace App\Tests\Service;

use App\DTO\UserCreateDto;
use App\Repository\UserRepository;
use App\Service\UserService;
use App\Validator\ValidatorMessagesTrait;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;
use TypeError;

class CreateUserServiceTest extends KernelTestCase
{
    use ValidatorMessagesTrait;

    public const MODE_REGULAR          = 'regular';
    public const MODE_WRONG_EMAIL      = 'wrong_email';
    public const MODE_SHORT_LENGTH     = 'short_length';
    public const MODE_WRONG_NAME_CHARS = 'wrong_name_chars';
    public const MODE_BLOCKED_NAME     = 'blocked_name';
    public const MODE_BLOCKED_DOMAIN   = 'blocked_domain';
    public const MODE_REQUIRED_NULL    = 'required_null';
    public const MODE_REQUIRED_BLANK   = 'required_blank';
    public const MODE_NON_UNIQUE_NAME  = 'non_unique_name';
    public const MODE_NON_UNIQUE_EMAIL = 'non_unique_email';

    /**
     * @var UserService|null
     */
    private $userService;

    /**
     * @var ValidatorInterface|null
     */
    private $validator;

    /**
     * @var EntityManagerInterface|null
     */
    private $entityManager;

    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
        $connection = static::$container->get(EntityManagerInterface::class)->getConnection();
        $sql = 'delete from users where id>0';
        $connection->executeQuery($sql);

        $sql = 'delete from action_log where id>0';
        $connection->executeQuery($sql);
    }

    protected function setUp(): void
    {
        self::bootKernel();
        $this->userService = static::$container->get(UserService::class);
        $this->validator = static::$container->get(ValidatorInterface::class);
    }

    /**
     * @dataProvider \App\Tests\Service\UserServiceDataProviders::createUserDataProvider()
     */
    public function testCreate(string $mode, array $data): void
    {
        echo sprintf("TestMode: %s, \tdata: %s", $mode, json_encode($data)) . PHP_EOL;
        try {
            $createDto = $this->buildUserCreateDto($data);
            $errors = $this->validator->validate($createDto);
            $this->messageViolationHandle($errors);
        } catch (Throwable $throwable) {
            switch ($mode) {
                case self::MODE_WRONG_EMAIL:
                {
                    self::assertInstanceOf(InvalidArgumentException::class, $throwable);
                    self::assertEquals('This value is not a valid email address.', $throwable->getMessage());
                    break;
                }
                case self::MODE_SHORT_LENGTH:
                {
                    self::assertInstanceOf(InvalidArgumentException::class, $throwable);
                    self::assertEquals('This value is too short. It should have 8 characters or more.', $throwable->getMessage());
                    break;
                }
                case self::MODE_WRONG_NAME_CHARS:
                {
                    self::assertInstanceOf(InvalidArgumentException::class, $throwable);
                    self::assertEquals('This value is not valid.', $throwable->getMessage());
                    break;
                }
                case self::MODE_BLOCKED_NAME:
                {
                    self::assertInstanceOf(InvalidArgumentException::class, $throwable);
                    self::assertEquals('`name` contains blocked word: blocked', $throwable->getMessage());
                    break;
                }
                case self::MODE_BLOCKED_DOMAIN:
                {
                    self::assertInstanceOf(InvalidArgumentException::class, $throwable);
                    self::assertEquals('`email` is in the blocked domain list', $throwable->getMessage());
                    break;
                }
                case self::MODE_REQUIRED_BLANK:
                {
                    self::assertEquals('This value should not be blank.', $throwable->getMessage());
                    self::assertInstanceOf(InvalidArgumentException::class, $throwable);
                    break;
                }
                case self::MODE_REQUIRED_NULL:
                {
                    self::assertInstanceOf(TypeError::class, $throwable);
                    break;
                }
                default:
                {
                    throw $throwable;
                }
            }
            return;
        }

        $name = $data['name'] ?? null;
        $email = $data['email'] ?? null;
        $notes = $data['notes'] ?? null;

        try {
            $user = $this->userService->create($createDto);
            self::assertEquals($name, $user->getName());
            self::assertEquals($email, $user->getEmail());
            self::assertEquals($notes, $user->getNotes());
        } catch (Throwable $throwable) {
            switch ($mode) {
                case self::MODE_NON_UNIQUE_NAME:
                case self::MODE_NON_UNIQUE_EMAIL:
                {
                    self::assertInstanceOf(Exception\UniqueConstraintViolationException::class, $throwable);
                    break;
                }
                default:
                {
                    throw $throwable;
                }
            }
        }
    }

    /**
     * @param array $data
     * @return UserCreateDto
     */
    private function buildUserCreateDto(array $data): UserCreateDto
    {
        $name = $data['name'] ?? null;
        $email = $data['email'] ?? null;
        $notes = $data['notes'] ?? null;
        $userCreateDto = new UserCreateDto($name, $email);
        $userCreateDto->setNotes($notes);

        return $userCreateDto;
    }
}
