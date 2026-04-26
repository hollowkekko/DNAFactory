<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggleAnime($mal_id)
    {
        $user = Auth::user();

        $existingFavorite = $user->favorites()
            ->where('favoritable_id', $mal_id)
            ->where('favoritable_type', Anime::class)
            ->first();

        if ($existingFavorite) {
            $existingFavorite->delete();
            $isFavorite = false;
        } else {
            $user->favorites()->create([
                'favoritable_id' => $mal_id,
                'favoritable_type' => Anime::class
            ]);
            $isFavorite = true;
        }

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'isFavorite' => $isFavorite]);
        }

        return back();
    }

    public function toggleManga($mal_id)
    {
        $user = Auth::user();

        $existingFavorite = $user->favorites()
            ->where('favoritable_id', $mal_id)
            ->where('favoritable_type', Manga::class)
            ->first();

        if ($existingFavorite) {
            $existingFavorite->delete();
        } else {
            $user->favorites()->create([
                'favoritable_id' => $mal_id,
                'favoritable_type' => Manga::class
            ]);
        }

        return back();
    }

    public function index()
    {
        $favorites = Auth::user()->favorites()->with('favoritable')->get();
        return view('favorites.index', compact('favorites'));
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $favorite = $user->favorites()->findOrFail($id);
        $favorite->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back();
    }
}