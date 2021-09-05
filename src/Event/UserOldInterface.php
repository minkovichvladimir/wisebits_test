<?php

namespace App\Event;

use App\Entity\User;

interface UserOldInterface
{
    /**
     * @return User
     */
    public function getOldUser(): User;
}