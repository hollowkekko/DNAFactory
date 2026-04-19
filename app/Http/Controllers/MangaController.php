<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use Illuminate\Http\Request;

class MangaController extends Controller
{
    public function index()
    {
        $mangas = Manga::paginate(12); 
        return view('manga.index', compact('mangas'));
    }

    public function show($mal_id)
    {
        $manga = Manga::findOrFail($mal_id);
        return view('manga.show', compact('manga'));
    }
}