<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class HomeController extends Controller
{
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /*
    public function index()
    {
        $topics = $this->getSidebarData();

        $columns = $this->getArticleData();

        return view('home', compact('topics', 'columns'));
    }
    */
    public function index($category = null)
    {
        $topics = $this->getSidebarData();
    
        // Pass the selected category to the getArticleData method
        $columns = $this->getArticleData($category);
    
        return view('home', compact('topics', 'columns', 'category'));
    }
    private function getSidebarData()
    {
        $sidebarController = new SidebarController();
        return $sidebarController->showSidebar()->getData()['topics'];
    }

    /*
    public function getArticleData()
    {
        $column1Articles = Article::take(5)->get();

        $column2Articles = Article::skip(5)->take(5)->get();

        return [
            'column1' => $column1Articles,
            'column2' => $column2Articles
        ];
    }
    */
    public function getArticleData($category = null)
{
    $query = Article::query();

    if ($category) {
        $query->where('category', $category);
    }

    $bigArticle = $query->take(1)->first();
    $column1Articles = $query->skip(1)->take(5)->get();
    $column2Articles = $query->skip(6)->take(5)->get();

    return [
        'bigArticle' => $bigArticle,
        'column1' => $column1Articles,
        'column2' => $column2Articles
    ];
}

}