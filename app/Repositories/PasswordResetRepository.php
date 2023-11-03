<?php

namespace App\Repositories;

use App\Models\User;

class PasswordResetRepository
{
    /**
     * findByEmail
     *
     * @param  string $email Contains the Email of the user whose password is to be reseted
     * @return object Returns the user object of the user whose password is to be reseted.
     */
    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    /**
     * updatePassword
     *
     * @param  object $user This is the user object
     * @param  string $password This contains the updated password in the payload
     * @return void
     */
    public function updatePassword($user, $password)
    {
        $user->password = $password;
        $user->save();
    }
}
