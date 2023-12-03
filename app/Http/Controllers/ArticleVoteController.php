<?php

namespace App\Http\Controllers;

use App\Models\Article_vote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ArticleVoteController extends Controller
{
    public function like($articleId)
    {
        if(Article_vote::where([
            'user_id' => Auth::user()->user_id,
            'article_id' => $articleId,
            'is_like' => TRUE
        ])->exists()) return redirect('articles/'.$articleId);

        //TRIGGER 1 ATUALIZA MAL A REPUTAÇÃO

        Article_vote::insert([
            'user_id' => Auth::user()->user_id,
            'article_id' => $articleId,
            'is_like' => TRUE,
        ]);
        return redirect('articles/'.$articleId);
    }

    public function unlike($articleId)
    {
        if(Article_vote::where([
            'user_id' => Auth::user()->user_id,
            'article_id' => $article_id,
            //'is_like' => FALSE
        ])->exists()) return;
    }
}
