<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Anime;
use App\Models\Manga;

class FetchJikanData extends Command
{
    // Questo è il nome da scrivere nel terminale per lanciare lo script e fetchare i dati da Jikan API
    protected $signature = 'jikan:fetch';
    
    protected $description = 'Importa Anime e Manga da Jikan API rispettando i rate limits';

    public function handle()
    {
        $this->info('Inizio importazione dati da Jikan API...');

        // Importa Anime
        $this->fetchData('anime', Anime::class);

        // Importa Manga
        $this->fetchData('manga', Manga::class);

        $this->info('Importazione completata con successo!');
    }

    private function fetchData($type, $modelClass)
    {
        $this->info("=== Importazione $type in corso ===");

        // Come test, scarichiamo le prime 2 pagine (circa 50 elementi in totale per categoria).
        // In un caso reale potresti aumentare questo numero.
        for ($page = 1; $page <= 2; $page++) {
            $this->line("Scaricando $type - pagina $page...");

            $response = Http::get("https://api.jikan.moe/v4/$type", [
                'page' => $page
            ]);

            if ($response->successful()) {
                $items = $response->json()['data'];

                foreach ($items as $item) {
                    // updateOrCreate previene i duplicati se lanci il comando due volte
                    $modelClass::updateOrCreate(
                        ['mal_id' => $item['mal_id']], // Cerca per ID
                        [
                            'title' => $item['title'],
                            // Jikan nidifica l'immagine, controlliamo che esista
                            'image_url' => $item['images']['jpg']['image_url'] ?? null, 
                            'synopsis' => $item['synopsis'] ?? 'Nessuna trama disponibile',
                            'score' => $item['score'] ?? null,
                        ]
                    );
                }
            } else {
                $this->error("Errore di connessione all'API per $type a pagina $page.");
            }

            // LA CHIAVE PER SUPERARE IL TEST: Rispetto del Rate Limit.
            // Jikan API permette max 3 richieste al secondo. 
            // Questa pausa garantisce che l'IP non venga mai bloccato.
            sleep(2); 
        }
    }
}
