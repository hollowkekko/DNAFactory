<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class WatchHistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $watchHistory = $user->watchHistory()
            ->with('anime')
            ->orderByDesc('watch_date')
            ->paginate(20);

        // preferiti dell'utente
        $favoriteAnimeIds = $user->favorites()
            ->where('favoritable_type', \App\Models\Anime::class)
            ->pluck('favoritable_id')
            ->toArray();

        return view('watch-history.index', compact('watchHistory', 'favoriteAnimeIds'));
    }
}
