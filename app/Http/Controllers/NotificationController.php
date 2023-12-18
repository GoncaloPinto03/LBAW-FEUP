<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\LikePostNotif;
use App\Models\DislikePostNotif;
use App\Models\ArticleNotif;
use App\Models\CommentNotif;

class NotificationController extends Controller
{
    public function show_notifs($id)
    {
        $user = User::find($id);

        $notifications = Notification::where('notified_user', $id)->orderByDesc('date')->get();

        
        foreach ($notifications as $notification)
        {
            $emitter = User::find($notification->emitter_user)->name;
            $notification->emitter = $emitter;

            if (ArticleNotif::where('notification_id', $notification->notification_id)->first())
            {
                $article_id = ArticleNotif::where('notification_id', $notification->notification_id)->first()->article_id;
                $article_name = Article::find($article_id)->name;

                $notification->article = $article_name;

                if (LikePostNotif::where('notification_id', $notification->notification_id)->first())
                {
                    $notification->type = "like_post";
                }
                else
                {
                    $notification->type = "dislike_post";
                }
            }
            else if (CommentNotif::where('notification_id', $notification->notification_id)->first())
            {
                $comment_id = CommentNotif::where('notification_id', $notification->notification_id)->first()->comment_id;
                $article_id = Comment::find($comment_id)->article_id;
                $article_name = Article::find($article_id)->name;

                $notification->type = "comment";
                $notification->article = $article_name;
            }
        }

        return view('notifications', compact('notifications'));
    }
}
