<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag; 
use App\Models\ArticleTag; 

class TagController extends Controller
{
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

    public function tagArticles($tag_id)
    {
        $tag = Tag::find($tag_id);

        if (!$tag) {
            abort(404);
        }

        $articles = ArticleTag::where('tag_id', $tag_id)
            ->join('article', 'article_tag.article_id', '=', 'article.article_id')
            ->get();

        return view('tag_articles', ['tag' => $tag, 'articles' => $articles]);
    }

}
