<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Article;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Topic;
use App\Models\Photo;


use App\Models\Comment; 

class ArticleController extends Controller
{
    
    public function getArticleInformation($articleId)
    {
        $article = Article::find($articleId);
        $popular = Article::getPopularArticles();
        
        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        } else {
            /*$articleName = $article->name;
            $articleDescription = $article->description;
            $articleDate = $article->date;
            $authorName = $article->user->name;
            $authorRep= $article->user->reputation;*/
            $comments= Comment::where('article_id', $articleId)->get();
            $topicName = Topic::find($article->topic_id)->name;

            
            
        return view('article', compact('article', 'comments', 'popular' , 'topicName'));        
    }        
}        

    public function showArticles() {
        $articles1 = Article::take(5)->get();
        $articles2 = Article::take(5)->get();
        return view('partials.articles_home', compact('articles1', 'articles2'));
    }


    public function editArticle($id)
    {
        $article = Article::find($id);
        $popular = Article::getPopularArticles();
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

        return redirect('profile/articles/'.$article->user_id);
    }

    public function search_user_articles(Request $request)
    {
        $search_text = $request->input('query');
        $search_words = explode(' ', $search_text);
        $ts_query = implode(' & ', $search_words);
        $user_id = Auth::user()->user_id;

        $articles = Article::where('user_id', $user_id)->whereRaw("to_tsvector('english', name) @@ to_tsquery(?)", ['"'.$ts_query.'"'])->orWhereRaw("to_tsvector('english', description) @@ to_tsquery(?)", ['"'.$ts_query.'"'])->get();

        return view('user-articles', compact('articles'));
    }


}
