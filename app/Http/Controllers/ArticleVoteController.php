<?php

namespace App\Http\Controllers;

use App\Models\Article_vote;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class ArticleVoteController extends Controller
{
    public function like($articleId)
    {

        $article_user = Article::find($articleId)->user_id;

        if (Auth::user()->user_id === $article_user) return redirect('articles/'.$articleId)->with('error', 'User cannot like its own article');

        if (Article_vote::where(['user_id' => Auth::user()->user_id, 'article_id' => $articleId, 'is_like' => FALSE])->exists()) 
        {
            Article_vote::where([
                'user_id' => Auth::user()->user_id,
                'article_id' => $articleId,
                'is_like' => FALSE
            ])->delete();
        }

        if(Article_vote::where([
            'user_id' => Auth::user()->user_id,
            'article_id' => $articleId,
            'is_like' => TRUE
        ])->exists()) return redirect('articles/'.$articleId)->with('error', 'User already liked this article');

        //TRIGGER 1 ATUALIZA MAL A REPUTAÇÃO

        Article_vote::insert([
            'user_id' => Auth::user()->user_id,
            'article_id' => $articleId,
            'is_like' => TRUE,
        ]);
        return redirect('articles/'.$articleId)->with('success', 'Article liked successfully');
    }

    public function unlike($articleId)
    {
        Article_vote::where([
            'user_id' => Auth::user()->user_id,
            'article_id' => $articleId,
        ])->delete();
        return redirect('articles/'.$articleId)->with('success', 'Article unliked successfully');
    }


    public function dislike($articleId)
    {

        $article_user = Article::find($articleId)->user_id;

        if (Auth::user()->user_id === $article_user) return redirect('articles/'.$articleId)->with('error', 'User cannot dislike its own article');

        if (Article_vote::where(['user_id' => Auth::user()->user_id, 'article_id' => $articleId, 'is_like' => TRUE])->exists()) 
        {
            Article_vote::where([
                'user_id' => Auth::user()->user_id,
                'article_id' => $articleId,
                'is_like' => TRUE
            ])->delete();
        }

        if(Article_vote::where([
            'user_id' => Auth::user()->user_id,
            'article_id' => $articleId,
            'is_like' => FALSE
        ])->exists()) return redirect('articles/'.$articleId)->with('error', 'User already disliked this article');

        //TRIGGER 1 ATUALIZA MAL A REPUTAÇÃO

        Article_vote::insert([
            'user_id' => Auth::user()->user_id,
            'article_id' => $articleId,
            'is_like' => FALSE,
        ]);
        return redirect('articles/'.$articleId)->with('success', 'Article disliked successfully');
    }

    public function undislike($articleId)
    {
        Article_vote::where([
            'user_id' => Auth::user()->user_id,
            'article_id' => $articleId,
        ])->delete();
        return redirect('articles/'.$articleId)->with('success', 'Article undisliked successfully');
    }
}
