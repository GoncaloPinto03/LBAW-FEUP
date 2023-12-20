<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Article;



class HomeController extends Controller
{
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
     public function index(Request $request, $category = null)
     {
        $topics = $this->getSidebarData();

        $columns = $this->getArticleData($category, $request);
          
         return view('home', compact('topics', 'columns', 'category'));
     }
     
    private function getSidebarData() 
    {
        $sidebarController = new SidebarController();
        return $sidebarController->showSidebar()->getData()['topics'];
    }

    
    public function getArticleData($topic = null, Request $request)
    {
        $query = Article::query();

        if ($topic) {
            $query->where('topic_id', $topic);
        }

        if($request->has('selectedOption')){
            $sort= $request->input('selectedOption');
            if($sort==='recent'){
                $query->orderBy('date', 'desc');
            }
            else if ($sort === 'popular'){
                $query->orderBy('likes', 'desc');
            }
            else if ($sort === 'user-feed' && Auth::check()){
                $user = Auth::user();
                $query = $user->getMyFeed();
                foreach ($query as $article) {
                    $article->description = strlen($article->description) > 100 ? substr($article->description, 0, 100) . '...' : $article->description;
                }
                return [
                    'column1' => $query,
                    'sort' => 'user-feed',
                ];
            }
        }
        else {
            $sort = 'all';
        }

        if ($query->count() == 0)
        {
            return ['sort' => 'all'];
        }


        $bigArticle = $query->first();
        $column1Articles = $query->skip(1)->take(5)->get();
        $column2Articles = $query->skip(6)->take(5)->get();

        $bigArticle->description = strlen($bigArticle->description) > 100 ? substr($bigArticle->description, 0, 100) . '...' : $bigArticle->description;
        foreach ($column1Articles as $article) {
            $article->description = strlen($article->description) > 100 ? substr($article->description, 0, 100) . '...' : $article->description;
        }
        
        foreach ($column2Articles as $article) {
            $article->description = strlen($article->description) > 100 ? substr($article->description, 0, 100) . '...' : $article->description;
        }


        return [
            'bigArticle' => $bigArticle,
            'column1' => $column1Articles,
            'column2' => $column2Articles,
            'sort' => $sort
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


    
    

