<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function getArticleInformation($articleId)
    {
        $article = Article::find($articleId);

        if ($article) {
            $articleName = $article->name;
            $articleDescription = $article->description;
            $articleDate = $article->date;
            $authorName = $article->user->name;
            $topicName = $article->topic->name;

            return view('article', compact('articleName', 'articleDescription', 'articleDate', 'authorName', 'topicName'));
        } else {
            return response()->json(['message' => 'Article not found'], 404);
        }
    }
}
