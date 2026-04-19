<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggleAnime($mal_id)
    {
        $user = Auth::user(); // Prende l'utente attualmente loggato

        // Controlla se l'utente ha già questo anime nei preferiti
        $existingFavorite = $user->favorites()
            ->where('favoritable_id', $mal_id)
            ->where('favoritable_type', Anime::class)
            ->first();

        if ($existingFavorite) {
            // Se esiste già, lo rimuove (Toggle)
            $existingFavorite->delete();
        } else {
            // Se non esiste, lo aggiunge
            $user->favorites()->create([
                'favoritable_id' => $mal_id,
                'favoritable_type' => Anime::class
            ]);
        }

        // Torna alla pagina in cui ci trovavamo
        return back();
    }

    public function index()
    {
        // Peschiamo tutti i preferiti dell'utente loggato.
        // Usiamo "with('favoritable')" per dire a Laravel di scaricare 
        // automaticamente anche i dati dell'Anime o del Manga collegato!
        $favorites = Auth::user()->favorites()->with('favoritable')->get();

        return view('favorites.index', compact('favorites'));
    }
}