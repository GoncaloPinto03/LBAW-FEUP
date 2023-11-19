<?php
 
 namespace App\Http\Controllers\Article;

 use App\Http\Controllers\Controller;
 use App\Models\Article;
 
/*class ArticleController extends Controller
{
    public function showArticle(){
        return view('article');
    }
} */

/*class ArticleController extends Controller
{
    public function show($articleId)
    {
        $article = Article::find($articleId); // supondo que você tenha um modelo chamado Article

        return view('articles.show', compact('article'));
    }
}*/

class ArticleController extends Controller
{
    public function getArticleInformation($articleId)
    {
        // Retrieve an article by its ID
        $article = Article::find($articleId);

        if ($article) {
            // Access article properties
            $articleName = $article->name;
            $articleDescription = $article->description;
            $articleDate = $article->date;

            // Access related data using relationships
            $authorName = $article->user->name;
            $topicName = $article->topic->name; 


            return view('article.show', compact('articleName', 'articleDescription', 'articleDate', 'authorName', 'topicName'));
        } else {
            // Handle the case where the article with the given ID is not found
            return response()->json(['message' => 'Article not found'], 404);
        }
    }
}

