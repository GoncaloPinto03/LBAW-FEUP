<?php
 
 namespace App\Http\Controllers\Article;

 use App\Http\Controllers\Controller;
 use Illuminate\Http\Request;
 
 use Illuminate\Http\RedirectResponse;
 use Illuminate\Support\Facades\Auth;
 
 use Illuminate\View\View;
 
 use App\Models\User;

class ArticleController extends Controller
{

    /**
     * Display article page.
     */
    public function showArticle(){
        return view('articles.article');
    }
}
