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
        $comment = Comment::find($commentId);
        $comment_user = Comment::find($commentId)->user_id;
        $articleId = Comment::find($commentId)->article_id;

        $existingVote = Comment_vote::where([
            'comment_id' => $commentId,
            'user_id' => Auth::user()->user_id,
        ])->first();
    
        if ($existingVote) {
            // Check if the existing vote is a dislike and update the comment count
            if (!$existingVote->is_like) {
                $comment->dislikes = $comment->dislikes - 1;
            }
    
        }

        if (Auth::user()->user_id === $comment_user) return redirect('articles/'.$articleId)->with('error', 'User cannot like its own article');

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
        ])->exists()) return redirect('articles/'.$articleId)->with('error', 'User already liked this article');

        //TRIGGER 1 ATUALIZA MAL A REPUTAÇÃO

        Comment_vote::insert([
            'comment_id' => $commentId,
            'user_id' => Auth::user()->user_id,
            'is_like' => TRUE
        ]);

        $comment->likes = $comment->likes + 1; 
        $comment->save();

        return redirect('articles/'.$articleId)->with('success', 'Article liked successfully');
    }

    public function unlike($commentId)
    {
        $comment = Comment::find($commentId);
        $articleId = Comment::find($commentId)->article_id;
        $existingVote = Comment_vote::where([
            'comment_id' => $commentId,
            'user_id' => Auth::user()->user_id,
        ])->first();
    
        if ($existingVote) {
            // Check if the existing vote is a like and update the comment count
            if ($existingVote->is_like) {
                $comment->likes = $comment->likes - 1;
            }
        }

        Comment_vote::where([
            'comment_id' => $commentId,
            'user_id' => Auth::user()->user_id,
        ])->delete();
        $comment->likes = $comment->likes - 1; 
        $comment->save();
        return redirect('articles/'.$articleId)->with('success', 'Article unliked successfully');
    }


    public function dislike($commentId)
    {
        $comment = Comment::find($commentId);
        $comment_user = Comment::find($commentId)->user_id;
        $articleId = Comment::find($commentId)->article_id;
        $existingVote = Comment_vote::where([
            'comment_id' => $commentId,
            'user_id' => Auth::user()->user_id,
        ])->first();

        if ($existingVote) {
            // Check if the existing vote is a like and update the comment count
            if ($existingVote->is_like) {
                $comment->likes = $comment->likes - 1;
            }
    
        }

        if (Auth::user()->user_id === $comment_user) return redirect('articles/'.$articleId)->with('error', 'User cannot dislike its own article');

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
        ])->exists()) return redirect('articles/'.$articleId)->with('error', 'User already disliked this article');

        //TRIGGER 1 ATUALIZA MAL A REPUTAÇÃO

        Comment_vote::insert([
            'comment_id' => $commentId,
            'user_id' => Auth::user()->user_id,
            'is_like' => FALSE,
        ]);
        $comment->dislikes = $comment->dislikes + 1; 
        $comment->save();
        return redirect('articles/'.$articleId)->with('success', 'Article disliked successfully');
    }

    public function undislike($commentId)
    {
        $comment = Comment::find($commentId);
        $articleId = Comment::find($commentId)->article_id;
        $existingVote = Comment_vote::where([
            'comment_id' => $commentId,
            'user_id' => Auth::user()->user_id,
        ])->first();
    
        if ($existingVote) {
            // Check if the existing vote is a dislike and update the comment count
            if (!$existingVote->is_like) {
                $comment->dislikes = $comment->dislikes - 1;
            }
    
        }

        Comment_vote::where([
            'comment_id' => $commentId,
            'user_id' => Auth::user()->user_id,
        ])->delete();
        $comment->dislikes = $comment->dislikes - 1; 
        $comment->save();
        return redirect('articles/'.$articleId)->with('success', 'Article undisliked successfully');
    }
}
