<?php

namespace App\Policies;

use App\Models\PhotoOfField;
use App\Models\User;

class PhotoOfFieldPolicy
{
    /**
     * Owner may manage photos that belong to their own field.
     */
    public function manage(User $user, PhotoOfField $photoOfField): bool
    {
        return $user->owner !== null
            && $photoOfField->field->owner_id === $user->owner->id;
    }
}
