<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Anime;
use App\Models\Manga;

class FetchJikanData extends Command
{
    protected $signature = 'jikan:fetch {--pages=5 : Numero di pagine da importare}';

    protected $description = 'Importa Anime e Manga da Jikan API rispettando i rate limits (3 richieste/sec)';

    public function handle()
    {
        $pages = $this->option('pages');

        $this->info('=== Inizio importazione dati da Jikan API ===');
        $this->info("Importerò $pages pagine per categoria");

        $this->fetchData('anime', Anime::class, $pages);
        $this->line('');
        $this->fetchData('manga', Manga::class, $pages);

        $this->info('✅ Importazione completata con successo!');
    }

    private function fetchData($type, $modelClass, $pages)
    {
        $this->info("=== Importazione $type in corso ===");
        $totalImported = 0;

        for ($page = 1; $page <= $pages; $page++) {
            $this->line("Scaricando $type - pagina $page...");

                $response = Http::timeout(10)
                    ->retry(3, 2000)
                    ->get("https://api.jikan.moe/v4/$type", [
                        'page' => $page,
                        'limit' => 25
                ]);

            if ($response->successful()) {
                $items = $response->json()['data'] ?? [];

                foreach ($items as $item) {
                    // Estraggo i nomi dei generi come array di stringhe
                    $genres = array_map(fn($g) => $g['name'], $item['genres'] ?? []);

                    $modelClass::updateOrCreate(
                        ['mal_id' => $item['mal_id']],
                        [
                            'title' => $item['title'],
                            'image_url' => $item['images']['jpg']['image_url'] ?? null,
                            'synopsis' => $item['synopsis'] ?? 'Nessuna trama disponibile',
                            'score' => $item['score'] ?? null,
                            'episodes' => $item['episodes'] ?? null,
                            'genres' => $genres,
                        ]
                    );
                    $totalImported++;
                }

                $this->info("✓ Pagina $page completata ({$totalImported} totali)");
            } else {
                $this->error("✗ Errore al recupero di $type pagina $page (HTTP {$response->status()})");
            }

            // Rispetto del Rate Limit: max 3 richieste al secondo
            // Attendiamo 1 secondo tra le richieste per stare al sicuro
            sleep(1);
        }

        $this->info("✅ {$type}: $totalImported elementi importati");
    }
}
