<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Article;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function getArticleInformation($articleId)
    {
        $article = Article::find($articleId);

        if ($article) {
            $articleName = $article->name;
            $articleDescription = $article->description;
            $articleDate = $article->date;
            $authorName = $article->user->name;
            //$topicName = $article->topic->name;

        return view('article', compact('articleName', 'articleDescription', 'articleDate', 'authorName'/*, 'topicName'*/));
        } else {
            return response()->json(['message' => 'Article not found'], 404);
        }
    }

    
    public function showArticles() {
        $articles1 = Article::take(5)->get();
        $articles2 = Article::take(5)->get();
        return view('partials.articles_home', compact('articles1', 'articles2'));
    }
/*
    public function showArticles($category = null)
{
    if ($category) {
        $articles1 = Article::where('category', $category)->take(5)->get();
        $articles2 = Article::where('category', $category)->take(5)->get();
    } else {
        $articles1 = Article::take(5)->get();
        $articles2 = Article::take(5)->get();
    }

    return view('partials.articles_home', compact('articles1', 'articles2'));
}

*/

    public function editArticle($id)
    {
        $article = Article::find($id);

        return view('edit_article', compact('article'));
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
        
        $article->save();
        /*
---------------------ERRO AQUI---------------------------------
    Segundo o ChatGPT, depois de editar o article o Laravel cria um "updated_at" e como a table não tem essa coluna dá erro.
    É um pouco estranho. O chat diz para criar uns ficheiros no database/migrations mas não sei se devemos fazer isso.
    Se calhar é melhor falar com o Fábio Sá ou com o stor sobre isso.        
        */

        return redirect('articles/'.$article->article_id);
    }

    public function deleteArticle(Request $request)
    {
        $article = Article::find($request->input('article_id'));

        foreach($article->comments() as $comment) $comment->delete();

        if (!$article) {
            return redirect()->back()->with('error', 'Article not found');
        }

        $article->delete();
    }
        /*
--------------------ERRO AQUI-----------------------------------
        Há algo muito mau no nosso código sql, o trigger 3 que é ativado ao dar delete a article não está a funcionar direito e eu não faço ideia porquê.
        Parece que deveria dar bem mas está a dar uns erros estranhos.

        return redirect('/home');
        */


    public function createArticlePage()
    {
        return view('create-article');
    }

    public function newArticle(Request $request)
    {
        $article = new Article();
        $article->name = $request->input('name');
        $article->description = $request->input('description');
        $article->date = Carbon::now(); 
        $article->user_id = Auth::user()->user_id;
        $article->topic_id = 2; //Só para ver se dá certo

        $article->save();

        return redirect('/home');
    }

    public function search_user_articles(Request $request)
    {
        $search_text = $request->input('query');

        $articles = Article::where('name', 'ilike', '%'.$search_text.'%')->get();

        return view('user-articles', compact('articles'));
    }

}

