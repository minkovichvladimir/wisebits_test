<?php

namespace App\Event;

use App\Entity\User;

class UserCreatedEvent implements UserNewInterface
{
    /**
     * @var User
     */
    private $newUser;

    /**
     * @param User $newUser
     */
    public function __construct(User $newUser)
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