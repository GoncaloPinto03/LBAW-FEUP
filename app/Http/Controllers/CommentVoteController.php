<?php

namespace App\Http\Controllers;

use App\Models\Comment_vote;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class CommentVoteController extends Controller
{
    public function like($commentId)
    {

        $comment_user = Comment::find($commentId)->user_id;

        if (Auth::user()->user_id === $comment_user) return redirect('home')->with('error', 'User cannot like its own article');

        if (Comment_vote::where(['comment_id' => $commentId, 'user_id' => Auth::user()->user_id, 'is_like' => FALSE])->exists()) 
        {
            Comment_vote::where([
                'comment_id' => $commentId,
                'user_id' => Auth::user()->user_id,
                'is_like' => FALSE
            ])->delete();
        }

        if(Comment_vote::where([
            'comment_id' => $commentId,
            'user_id' => Auth::user()->user_id,
            'is_like' => TRUE
        ])->exists()) return redirect('home')->with('error', 'User already liked this article');

        //TRIGGER 1 ATUALIZA MAL A REPUTAÇÃO

        Comment_vote::insert([
            'comment_id' => $commentId,
            'user_id' => Auth::user()->user_id,
            'is_like' => TRUE
        ]);
        return redirect('home')->with('success', 'Article liked successfully');
    }

    public function unlike($commentId)
    {
        Comment_vote::where([
            'comment_id' => $commentId,
            'user_id' => Auth::user()->user_id,
        ])->delete();
        return redirect('home')->with('success', 'Article unliked successfully');
    }


    public function dislike($commentId)
    {

        $comment_user = Comment::find($commentId)->user_id;

        if (Auth::user()->user_id === $comment_user) return redirect('home')->with('error', 'User cannot dislike its own article');

        if (Comment_vote::where(['comment_id' => $commentId, 'user_id' => Auth::user()->user_id, 'is_like' => TRUE])->exists()) 
        {
            Comment_vote::where([
                'comment_id' => $commentId,
                'user_id' => Auth::user()->user_id,
                'is_like' => TRUE
            ])->delete();
        }

        if(Comment_vote::where([
            'comment_id' => $commentId,
            'user_id' => Auth::user()->user_id,
            'is_like' => FALSE
        ])->exists()) return redirect('home')->with('error', 'User already disliked this article');

        //TRIGGER 1 ATUALIZA MAL A REPUTAÇÃO

        Comment_vote::insert([
            'comment_id' => $commentId,
            'user_id' => Auth::user()->user_id,
            'is_like' => FALSE,
        ]);
        return redirect('home')->with('success', 'Article disliked successfully');
    }

    public function undislike($commentId)
    {
        Comment_vote::where([
            'comment_id' => $commentId,
            'user_id' => Auth::user()->user_id,
        ])->delete();
        return redirect('home')->with('success', 'Article undisliked successfully');
    }
}
