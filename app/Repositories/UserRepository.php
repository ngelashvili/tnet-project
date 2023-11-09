<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function get($email){
        return $this->user->where('email', $email)->first();
    }
}
