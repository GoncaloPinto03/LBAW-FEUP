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

 
    public function getArticleData($topic = null)
    {
        $query = Article::query();
    
        if ($topic) {
            $query->where('topic_id', $topic);
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

    public function filter_idx(Request $request)
    {
        //dd($request->all());
        $topics = $this->getSidebarData();
    
        // Pass the selected category to the getArticleData method
        $articles = Article::all();

        $query = Article::query();

        if(isset($request->search_text) && !is_null($request->search_text))
        {
            $search_text = $request->search_text;
            $search_words = explode(' ', $search_text);
            $ts_query = implode(' & ', $search_words);

            $query->where(function ($query) use ($ts_query) {
                $query->whereRaw("to_tsvector('english', name) @@ to_tsquery(?)", ['"'.$ts_query.'"'])
                      ->orWhereRaw("to_tsvector('english', description) @@ to_tsquery(?)", ['"'.$ts_query.'"']);
            });
            
        }

        if(isset($request->topic) && ($request->topic != null))
        {
            $query->where(function($subQuery) use ($request) {
                $subQuery->whereIn('topic_id', $request->topic);
            });
        }

        $articles = $query->get();
    
        return view('filter-search', compact('topics', 'articles'));
    }
    
}


    
    

