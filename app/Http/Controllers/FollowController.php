<?php
namespace App\Http\Controllers;


use App\Models\Follow;
use App\Models\Tag;
use Illuminate\Http\Request;


class FollowController extends Controller
{
    public function followTag(Request $request, $tagId)
    {
        $user = auth()->user();
        $tag = Tag::find($tagId);

        // Verifica se a tag já está marcada como favorita pelo usuário
        $isFollowingTag = Follow::where('user_id', $user->user_id)
            ->where('tag_id', $tag->tag_id)
            ->exists();

        if ($isFollowingTag) {
            Follow::where('user_id', $user->user_id)
                ->where('tag_id', $tag->tag_id)
                ->delete();

            $message = 'Tag deixou de ser seguida.';
        } else {
            Follow::insert([
                'user_id' => $user->user_id,
                'tag_id' => $tag->tag_id,
            ]);

            $message = 'Tag começou a ser seguida.';
        }

        return redirect()->back();
    }
}
