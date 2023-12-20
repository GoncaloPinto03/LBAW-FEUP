<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\Article_vote;
use App\Models\Article;
use App\Models\User;
use App\Models\Notification;
use App\Models\LikePostNotif;
use App\Models\DislikePostNotif;
use App\Models\ArticleNotif;
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


        Article_vote::insert([
            'user_id' => Auth::user()->user_id,
            'article_id' => $articleId,
            'is_like' => TRUE,
        ]);

        $article = Article::find($articleId);

        DB::beginTransaction();

        Notification::insert([
            'date' => date('Y-m-d H:i'),
            'viewed' => false,
            'emitter_user' => Auth::user()->user_id,
            'notified_user' => $article->user_id,
        ]);
        
        $newNotification = Notification::where('emitter_user', Auth::user()->user_id)->where('notified_user', $article->user_id)->get()->last();

        if(!$newNotification)
        {
            print("No notif");
        }
  
        ArticleNotif::insert([
            'notification_id' => $newNotification->notification_id,
            'article_id' => $articleId,
        ]);

        LikePostNotif::insert([
              'notification_id' => $newNotification->notification_id,
              'user_id' => $newNotification->notified_user,
        ]);
  
        DB::commit();





        return redirect('articles/'.$articleId)->with('success', 'Article liked successfully');
        /*$likeCount = Article_vote::where('article_id', $articleId)->where('is_like', TRUE)->count();
        $isLiked = Article_vote::where('article_id', $articleId)->where('is_like', TRUE)->exists();

        $author_id = Article::find($articleId)->user_id;
        $userReputation = User::find($author_id)->reputation;
        $responseData = [
            'likeCount' => $likeCount,
            'isLike' => $isLiked,
            'userRep' => $userReputation
        ];

        return response()->json($responseData);*/
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


        Article_vote::insert([
            'user_id' => Auth::user()->user_id,
            'article_id' => $articleId,
            'is_like' => FALSE,
        ]);


        $article = Article::find($articleId);

        DB::beginTransaction();

        Notification::insert([
            'date' => date('Y-m-d H:i'),
            'viewed' => false,
            'emitter_user' => Auth::user()->user_id,
            'notified_user' => $article->user_id,
        ]);
        
        $newNotification = Notification::where('emitter_user', Auth::user()->user_id)->where('notified_user', $article->user_id)->get()->last();

        if(!$newNotification)
        {
            print("No notif");
        }
  
        ArticleNotif::insert([
            'notification_id' => $newNotification->notification_id,
            'article_id' => $articleId,
        ]);

        DislikePostNotif::insert([
              'notification_id' => $newNotification->notification_id,
              'user_id' => $newNotification->notified_user,
        ]);
  
        DB::commit();


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
