<?php
 
 namespace App\Http\Controllers\Article;

 use App\Http\Controllers\Controller;

class ArticleController extends Controller
{

    /**
     * Display article page.
     */
    public function showArticle(){
        return view('articles.article');
    }
}
