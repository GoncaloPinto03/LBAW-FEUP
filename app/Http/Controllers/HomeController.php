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
        }
        else {
            $sort = 'all';
        }

        if ($query->count() == 0)
        {
            return ['sort' => 'all'];
        }


        $bigArticle = $query->take(1)->first();
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
    
}


    
    

