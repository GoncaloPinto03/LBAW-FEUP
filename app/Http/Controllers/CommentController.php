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

    public function createComment(Request $request)
    {
      $comment = new Comment();
      $comment->text = $request->input('text');
      $comment->date = Carbon::now();
      $comment->likes = 0;
      $comment->dislikes = 0; 
      $comment->user_id = Auth::user()->user_id;
      $comment->article_id = $request->article_id;
      $comment->save();

      return redirect('articles/'.$request->article_id);
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

