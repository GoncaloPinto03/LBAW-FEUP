<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Article;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Topic;

use App\Models\Comment; 
use App\Models\Article_vote; 
use App\Models\Favourite; 
use App\Models\Tag; 
use App\Models\ArticleTag; 



//use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    
    public function getArticleInformation($articleId)
    {
        $article = Article::find($articleId);
        
        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        } else {
            $user = Auth::user();


            /*DB::listen(function ($query) {
                dump($query->sql);
                dump($query->bindings);
                dump($query->time);
            });*/
            

            if (Auth::user())
            {
                $article_vote = Article_vote::where('user_id', $user->user_id)->where('article_id', $articleId)->first();
            }
            else
            {
                $article_vote = null;
            }

            $likes = Article_vote::where('article_id', $articleId)->where('is_like', TRUE)->count();
            $dislikes = Article_vote::where('article_id', $articleId)->where('is_like', FALSE)->count();


            /*DB::flushQueryLog();
            dd($article_vote);*/



            $comments= Comment::where('article_id', $articleId)->get();
            $topic = Topic::find($article->topic_id);

            $tagInstance = new Tag();

            $tags = ArticleTag::where('article_id', $articleId)->get();
            if(Auth::user()){
                $isFavourite = Favourite::where('user_id', $user->user_id)->where('article_id', $articleId)->exists();
                return view('article', compact('article', 'comments', 'article_vote', 'likes', 'dislikes', 'topic', 'tags', 'isFavourite'));

            }
            else{
                return view('article', compact('article', 'comments', 'article_vote', 'likes', 'dislikes', 'topic', 'tags'));
            }
            
        }        
    }        

    public function editArticle($id)
    {
        $article = Article::find($id);
        $topics = Topic::all();

        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        } else {
            $comments= Comment::where('article_id', $id)->get();
            

        //    return view('article', compact('article', 'comments' , 'popular', 'topicName'));
        }


        return view('edit_article', compact('article', 'topics', 'comments'));
    }

    public function updateArticle(Request $request, $id)
    {
        $article = Article::find($id);

        $request->validate([
            'name' => 'max:255',
            'description' => 'max:1000'
        ]);
        $article->name = $request->input('name');
        $article->description = $request->input('description');
        $article->topic_id = Topic::where('name', '=', $request->input('topic'))->first()->topic_id;

        if($request->file('image')){
            if( !in_array(pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION),['jpg','jpeg','png'])) {
                return redirect('article/edit');
            }
            $request->validate([
                'image' =>  'mimes:png,jpeg,jpg',
            ]);
            PhotoController::update($article->article_id, 'article', $request);
        }
        
        $article->save();


        return redirect('articles/'.$article->article_id);
    }

    public function deleteArticle(Request $request)
    {
        $article = Article::find($request->input('article_id'));

        if (!$article) {
            return redirect()->back()->with('error', 'Article not found');
        }

        $comments = $article->comments();
        if($comments)
        {
            foreach($comments as $comment) $comment->delete();
        }

        $article->article_vote()->delete();
    
        $article->delete();
    }



    public function createArticlePage()
    {
        $topics = Topic::all();
        return view('create-article', compact('topics'));
    }

    public function newArticle(Request $request)
    {
        $article = new Article();
        $article->name = $request->input('name');
        $article->description = $request->input('description');
        $article->date = Carbon::now(); 
        $article->user_id = Auth::user()->user_id;
        $article->topic_id = Topic::where('name', '=', $request->topic)->first()->topic_id;

        $article->save();

        PhotoController::update($article->article_id, 'article', $request);
        


        return redirect('profile/articles/'.$article->user_id);
    }


    


    public function search_user_articles(Request $request)
    {
        $search_text = $request->input('query');
        $search_words = explode(' ', $search_text);
        $ts_query = implode(' & ', $search_words);
        $user_id = Auth::user()->user_id;

        $articles = Article::where('user_id', $user_id)->where(function ($query) use ($ts_query) {
            $query->whereRaw("to_tsvector('english', name) @@ to_tsquery(?)", ['"'.$ts_query.'"'])
                  ->orWhereRaw("to_tsvector('english', description) @@ to_tsquery(?)", ['"'.$ts_query.'"']);
        })
    ->get();

        return view('user-articles', compact('articles'));
    }

    public function getPopularArticles(Request $request) {
        $selectedOption= $request->input('selectedOption');
        $articles = Article::orderBy('likes', 'desc')->get();
        return repsonse->json($articles);
    }

    public function getRecentArticles(Request $request) {
        $selectedOption= $request->input('selectedOption');
        $articles = Article::orderBy('date', 'desc')->get();
        return repsonse->json($articles);
    }

}

