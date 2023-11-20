<?php
 
namespace App\Http\Controllers;

use App\Models\Article;

class ArticleController extends Controller
{
    public function getArticleInformation($articleId)
    {
        $article = Article::find($articleId);

        if ($article) {
            $articleName = $article->name;
            $articleDescription = $article->description;
            $articleDate = $article->date;
            $authorName = $article->user->name;
            //$topicName = $article->topic->name;

        return view('article', compact('articleName', 'articleDescription', 'articleDate', 'authorName'/*, 'topicName'*/));
        } else {
            return response()->json(['message' => 'Article not found'], 404);
        }
    }

    public function showArticles() {
        $articles = Article::all();
        return view('partials.articles_home', compact('articles'));
    }
}

