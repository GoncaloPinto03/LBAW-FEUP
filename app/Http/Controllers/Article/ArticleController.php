<?php
 
 namespace App\Http\Controllers\Article;

 use App\Http\Controllers\Controller;
 
class ArticleController extends Controller
{
    public function showArticle(){
        return view('article');
    }
} 

/*class ArticleController extends Controller
{
    public function show($articleId)
    {
        $article = Article::find($articleId); // supondo que você tenha um modelo chamado Article

        return view('articles.show', compact('article'));
    }
}*/
