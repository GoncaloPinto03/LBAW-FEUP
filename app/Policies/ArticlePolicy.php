<?php

namespace App\Policies;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Article;

class ArticlePolicy
{

    public function editArticle(User $user, Article $article)
    {
        return $article->user_id === Auth::user()->user_id;
    }
}
