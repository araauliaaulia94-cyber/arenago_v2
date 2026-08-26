<?php

namespace App\Policies;

use App\Models\Schedule;
use App\Models\User;

class SchedulePolicy
{
    /**
     * Owner may manage schedules that belong to their own field.
     */
    public function manage(User $user, Schedule $schedule): bool
    {
        return $user->isOwner()
            && $schedule->field !== null
            && $schedule->field->owner_id === $user->owner->id;
    }
}
