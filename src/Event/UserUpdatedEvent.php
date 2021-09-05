<?php

namespace App\Event;

use App\Entity\User;

class UserUpdatedEvent implements UserNewInterface, UserOldInterface
{
    /**
     * @var User
     */
    private $oldUser;

    /**
     * @var User
     */
    private $newUser;

    /**
     * @param User $oldUser
     */
    public function __construct(User $oldUser)
    {
        $this->oldUser = clone $oldUser;
    }

    /**
     * @return User
     */
    public function getOldUser(): User
    {
        return $this->oldUser;
    }

    /**
     * @param User $newUser
     */
    public function setNewUser(User $newUser): void
    {
        $this->newUser = $newUser;
    }

    /**
     * @return User
     */
    public function getNewUser(): User
    {
        return $this->newUser;
    }

}