<?php
namespace App\Http\Controllers;
use App\Models\Tag;
use Illuminate\Http\Request;


class FollowController extends Controller
{
    public function followTag(Request $request, $tagId)
    {
        $user = auth()->user();
        $tag = Tag::find($tagId);

        // Verifica se a tag já está marcada como favorita pelo usuário
        $isFollowingTag = $user->isFollowingTag($tagId);

        if ($isFollowingTag) {
            $user->unfollowTag($tagId);

            $message = 'Tag deixou de ser seguida.';
        } else {
            $user->followTag($tagId);

            $message = 'Tag começou a ser seguida.';
        }

        return redirect()->back();
    }
}