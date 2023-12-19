<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TagController extends Controller
{
    public function tagArticles()
    {
        
    }

    public function followTag(Request $request, $tag_id)
    {
        if (auth()->check()) {
            $user_id = auth()->user()->user_id;

            $existingUserTag = UserTag::where('user_id', $user_id)
                ->where('tag_id', $tag_id)
                ->first();

            if (!$existingUserTag) {
                UserTag::create([
                    'user_id' => $user_id,
                    'tag_id' => $tag_id,
                ]);
            }
        }

        return redirect()->route('tag.articles', ['tag_id' => $tag_id]);
    }

}
