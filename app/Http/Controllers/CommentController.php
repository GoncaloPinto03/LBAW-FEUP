<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Comment;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function getComment($comments)
    {
        $comments = Comment::where($article_id = 'article_id')->get();
        return view('article', compact('comments'));
    }


    public function deleteComment(Request $request)
    {
        $comment = Comment::find($request->input('comment_id'));
        
        if (!$comment) {
            return redirect()->back()->with('error', 'Article not found');
        }

        $comment->delete();
    }
 

}

