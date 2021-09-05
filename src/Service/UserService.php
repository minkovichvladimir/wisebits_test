<?php

namespace App\Service;

use App\DTO\UserCreateDto;
use App\DTO\UserDeleteDto;
use App\DTO\UserReadDto;
use App\DTO\UserUpdateDto;
use App\Entity\User;
use App\Event\UserCreatedEvent;
use App\Event\UserDeletedEvent;
use App\Event\UserUpdatedEvent;
use App\Repository\UserRepository;
use App\Service\Exception\NotFoundException;
use App\Service\Exception\NothingToChangeException;
use DateTimeImmutable;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @param UserRepository $userRepository
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        UserRepository           $userRepository,
        EventDispatcherInterface $dispatcher
    ) {
        $this->userRepository = $userRepository;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @return array
     */
    public function list(): array
    {
        return $this->userRepository->findAll();
    }

    /**
     * @param UserCreateDto $createDto
     * @return User
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(UserCreateDto $createDto): User
    {
        $user = $this->buildUserEntity($createDto);
        $this->userRepository->save($user);

        $userCreatedEvent = new UserCreatedEvent($user);
        $this->dispatcher->dispatch($userCreatedEvent);

        return $user;
    }

    /**
     * @param UserCreateDto $createDto
     * @return User
     */
    private function buildUserEntity(UserCreateDto $createDto): User
    {
        $user = new User($createDto->getName(), $createDto->getEmail());
        $user->setNotes($createDto->getNotes());

        return $user;
    }

    /**
     * @param UserReadDto $readDto
     * @return User|null
     */
    public function read(UserReadDto $readDto): ?User
    {
        $user = $this->userRepository->find($readDto->getId());
        if (!$user) {
            throw new NotFoundException(sprintf('User with id:%s not found', $readDto->getId()));
        }

        return $user;
    }

    /**
     * @param UserUpdateDto $updateDto
     * @return User
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(UserUpdateDto $updateDto): User
    {
        $user = $this->userRepository->find($updateDto->getId());
        if (!$user) {
            throw new NotFoundException(sprintf('User with id:%s not found', $updateDto->getId()));
        }

        $userUpdatedEvent = new UserUpdatedEvent($user); // user without any updates
        if (!$this->hasUserUpdates($user, $updateDto)) {
            throw new NothingToChangeException();
        }

        $this->userRepository->save($user);

        $userUpdatedEvent->setNewUser($user); // user with updates
        $this->dispatcher->dispatch($userUpdatedEvent);

        return $user;
    }

    /**
     * @param User $user
     * @param UserUpdateDto $updateDto
     * @return bool
     */
    private function hasUserUpdates(User $user, UserUpdateDto $updateDto): bool
    {
        $hasAnyUpdate = false;
        if ($updateDto->getName() && $user->getName() !== $updateDto->getName()) {
            $user->setName($updateDto->getName());
            $hasAnyUpdate = true;
        }

        if ($updateDto->getEmail() && $user->getEmail() !== $updateDto->getEmail()) {
            $user->setEmail($updateDto->getEmail());
            $hasAnyUpdate = true;
        }

        if ($updateDto->getNotes() && $user->getNotes() !== $updateDto->getNotes()) {
            $user->setNotes($updateDto->getNotes());
            $hasAnyUpdate = true;
        }

        return $hasAnyUpdate;
    }

    /**
     * @param UserDeleteDto $deleteDto
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(UserDeleteDto $deleteDto): bool
    {
        $user = $this->userRepository->find($deleteDto->getId());
        if (!$user) {
            throw new NotFoundException(sprintf('User with id:%s not found', $deleteDto->getId()));
        }

        $userDeletedEvent = new UserDeletedEvent($user);

        $user->setDeleted(new DateTimeImmutable());
        $this->userRepository->save($user);

        $userDeletedEvent->setNewUser($user);
        $this->dispatcher->dispatch($userDeletedEvent);

        return true;
    }
}