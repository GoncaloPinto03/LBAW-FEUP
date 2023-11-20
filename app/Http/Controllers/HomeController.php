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
    public function index()
    {
        $columns = $this->getArticleData();

        return view('home', compact('columns'));
    }

    public function getArticleData()
    {
        $column1Articles = Article::take(5)->get();

        $column2Articles = Article::skip(5)->take(5)->get();

        return [
            'column1' => $column1Articles,
            'column2' => $column2Articles
        ];
    }



}