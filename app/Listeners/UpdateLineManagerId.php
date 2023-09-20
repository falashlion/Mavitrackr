<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Database\Events\Updating;

class UpdateLineManagerId
{
    public function handle(Updating $event)
    {
        /** @var User $user */
        $user = $event->getModel();

        if ($user->isDirty('manager_id')) {
            $user->line_manager = $user->department->manager_id;
        }
    }
}
