<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\Manga;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q', '');

        $animes = collect();
        $mangas = collect();

        if (strlen($query) >= 2) {
            $animes = Anime::whereRaw("LOWER(title) LIKE LOWER(?)", ["%{$query}%"])
                ->limit(12)
                ->get();

            $mangas = Manga::whereRaw("LOWER(title) LIKE LOWER(?)", ["%{$query}%"])
                ->limit(12)
                ->get();
        }

        return view('search.results', compact('query', 'animes', 'mangas'));
    }
}
