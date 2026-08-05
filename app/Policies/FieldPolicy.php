<?php

namespace App\Policies;

use App\Models\Field;
use App\Models\User;

class FieldPolicy
{
    /**
     * Owner may manage their own fields.
     */
    public function manage(User $user, Field $field): bool
    {
        return $user->owner !== null
            && $field->owner_id === $user->owner->id;
    }
}
