<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;
  
    public function access(User $user)
    {
        return $user->where('type', 1)->exists();
    }

    public function manage(User $user)
    {
        return $user->where('type', 0)->exists();
    }
}
