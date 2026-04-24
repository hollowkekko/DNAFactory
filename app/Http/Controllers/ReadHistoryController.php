<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ReadHistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $readHistory = $user->readHistory()
            ->with('manga')
            ->orderByDesc('read_date')
            ->paginate(20);

        // Preferiti dell'utente
        $favoriteMangaIds = $user->favorites()
            ->where('favoritable_type', \App\Models\Manga::class)
            ->pluck('favoritable_id')
            ->toArray();

        return view('read-history.index', compact('readHistory', 'favoriteMangaIds'));
    }
}
