<?php

namespace App\Event;

use App\Entity\User;

interface UserNewInterface
{
    /**
     * @return User
     */
    public function getNewUser(): User;
}