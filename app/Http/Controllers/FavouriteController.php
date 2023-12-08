<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Favourite;


class FavouriteController extends Controller
{
    public function markFavourite(Request $request, $articleId)
    {
        $user = auth()->user();
        $article = Article::find($articleId);

        // Verifica se o artigo já está marcado como favorito pelo usuário
        $isFavourite = Favourite::where('user_id', $user->user_id)
            ->where('article_id', $article->article_id)
            ->exists();

        if ($isFavourite) {
            // Se já for favorito, remove
            Favourite::where('user_id', $user->user_id)
                ->where('article_id', $article->article_id)
                ->delete();
            $message = 'Artigo removido dos favoritos.';
        } else {
            // Se não for favorito, adiciona
            Favourite::insert([
                'user_id' => $user->user_id,
                'article_id' => $article->article_id,
            ]);
        }

        return redirect('articles/'.$article->article_id);
    }
}
