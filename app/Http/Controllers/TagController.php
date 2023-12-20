<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag; 
use App\Models\ArticleTag; 
use App\Models\Follow; 


class TagController extends Controller
{
    
    public function tagArticles($tag_id)
    {
        $tag = Tag::find($tag_id);
        $user = auth()->user();



        if (!$tag) {
            abort(404);
        }

        $articles = ArticleTag::where('tag_id', $tag_id)
            ->join('article', 'article_tag.article_id', '=', 'article.article_id')
            ->get();

        //$isFollowingTag = Follow:: where('user_id', $user->user_id)->where('tag_id', $tag_id)->exists();
        $isFollowingTag = $user->isFollowingTag($tag_id);

        return view('tag_articles', compact('tag', 'articles', 'isFollowingTag'));
    }

}
