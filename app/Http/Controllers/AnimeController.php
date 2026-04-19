<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Http\Request;

class AnimeController extends Controller
{
    public function index()
    {
        // Prendiamo gli anime dal database. Usiamo paginate() così Laravel
        // crea in automatico i bottoni "Avanti" e "Indietro" se ci sono tanti anime!
        $animes = Anime::paginate(12); 

        // Inviamo i dati a una pagina HTML che chiameremo "anime.index"
        return view('anime.index', compact('animes'));
    }

    public function show($mal_id)
    {
        // Cerca l'anime nel database tramite il suo ID
        $anime = Anime::findOrFail($mal_id);
        
        // Passa i dati alla nuova pagina di dettaglio
        return view('anime.show', compact('anime'));
    }
}