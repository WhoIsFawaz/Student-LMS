<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can access the Filament dashboard.
     */
    public function viewAny(User $user): bool
    {
        return $user->user_type === 'admin';
    }
}
