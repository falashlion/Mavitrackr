<?php

namespace App\Repositories;

use App\Models\User;

class PasswordResetRepository
{
    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function updatePassword($user, $password)
    {
        $user->password = $password;
        $user->save();
    }
}
