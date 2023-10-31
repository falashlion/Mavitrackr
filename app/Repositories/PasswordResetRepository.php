<?php

namespace App\Repositories;

use App\Models\User;

class PasswordResetRepository
{
    /**
     * findByEmail
     *
     * @param  string $email
     * @return object
     */
    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    /**
     * updatePassword
     *
     * @param  object $user
     * @param  string $password
     * @return void
     */
    public function updatePassword($user, $password)
    {
        $user->password = $password;
        $user->save();
    }
}
