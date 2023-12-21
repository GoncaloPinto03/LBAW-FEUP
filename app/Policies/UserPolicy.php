<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function editArticle(User $user, User $current): bool
    {
        return $user->user_id === Auth::user()->user_id;
    }

}
