<?php
 
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Models\Comment;
use App\Models\Notification;
use App\Models\CommentNotif;
use App\Models\Article;
use App\Models\Comment_vote;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function getComment($commentId)
    {
        $comment = Comment::find($commentId);
        $user = Auth::user();
        if (Auth::user())
        {
            $comment_vote = Comment_vote::where('user_id', $user->user_id)->where('comment_id', $commentId)->first();
        }
        else
        {
            $comment_vote = null;
        }

        $likes = Comment_vote::where('comment_id', $commentId)->where('is_like', TRUE)->count();
        $dislikes = Comment_vote::where('comment_id', $commentId)->where('is_like', FALSE)->count();
        return view('comment', compact('comment', 'comment_vote', 'likes', 'dislikes'));
    }

    public function createComment(Request $request)
    {
        if (!Auth::user()) {
            return redirect()->back()->with('error', 'You must be logged in to comment');
        }
      $comment = new Comment();
      $comment->text = $request->input('text');
      $comment->date = Carbon::now();
      $comment->likes = 0;
      $comment->dislikes = 0; 
      $comment->user_id = Auth::user()->user_id;
      $comment->article_id = $request->article_id;
      $comment->save();

      $article = Article::find($request->article_id);

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

      CommentNotif::insert([
          'notification_id' => $newNotification->notification_id,
          'comment_id' => $comment->comment_id,
      ]);

      DB::commit();

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

    public function editComment($id)
    {
        $comment = Comment::find($id);
        
        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        return view('edit_comment', compact('comment'));

    }
    
    public function updateComment(Request $request, $id)
    {
        $comment = Comment::find($id);

        $request->validate([
            'text' => 'max:255'
        ]);
        $comment->text = $request->input('text');
        $comment->save();

        return redirect('articles/'.$comment->article_id);
    }

}

