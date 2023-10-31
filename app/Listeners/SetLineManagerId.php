<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Registered;

class SetLineManagerId
{
    public function handle(Registered $event)
    {
        /** @var User $user */
        $user = $event->user;

        if (!$user->line_manager) {
            $user->line_manager = $user->department->manager_id;
        }
    }
}
