# DNAFactory - Piattaforma Anime & Manga

Una moderna piattaforma web fullstack sviluppata in **Laravel 10** per esplorare, scoprire e gestire anime e manga, integrando le API pubbliche di **Jikan** e **AniList**.

Questo progetto è stato realizzato come **Test Pratico Fullstack** per la candidatura presso DNA Group.

---

## Funzionalità Sviluppate (Requisiti Traccia)

 **Architettura Fullstack**
- Sviluppo completo sia della parte Backend (Laravel/PHP) che Frontend (Blade, TailwindCSS, Alpine.js) rispettando il mockup grafico Adobe XD fornito.

 **Importazione e Persistenza Dati (Backend)**
- Creazione di un comando custom (`php artisan jikan:fetch`) per importare l'anagrafica di Anime e Manga tramite le API REST di Jikan.
- **Gestione Rate Limit:** Il comando implementa meccanismi di *delay* (`sleep`) e di *retry* nativi di Laravel per rispettare rigidamente il rate limit di 3 richieste/secondo imposto da Jikan API, garantendo un'importazione stabile senza crash.
- Logica idempotente (`updateOrCreate`) per consentire esecuzioni sicure tramite Cron Job giornalieri, aggiornando i record esistenti ed evitando duplicati.

 **Recensioni in Real-time (Senza persistenza)**
- Le recensioni vengono caricate in real-time chiamando le API di Jikan dalla pagina di dettaglio.
- **Cache Statica (Opzionale):** È stato aggiunto un livello di cache statica di 24 ore (`JikanCacheService`) per ottimizzare i tempi di caricamento, ridurre il carico sulle API e massimizzare le performance.

 **Sistema Utenti e Preferiti**
- Autenticazione protetta (Login, Registrazione, Modifica profilo) tramite Laravel Breeze.
- Sistema di "Aggiungi/Rimuovi ai Preferiti" asincrono gestito nel frontend con Alpine.js.
- **Morphic Relationships:** Utilizzate nel database per gestire con un'unica tabella (`favorites`) e un unico Controller le relazioni verso i Modelli `Anime` e `Manga`.

---

## L'Extra Mile (Scelte Architetturali e UI)

Oltre ai requisiti minimi richiesti, ho implementato ulteriori feature per ottimizzare la manutenibilità e migliorare notevolmente la User Experience:

1. **Integrazione GraphQL (AniList API):** Poiché le API di Jikan non forniscono i banner ad alta risoluzione o i loghi necessari per riprodurre fedelmente la UI "stile Netflix" richiesta dal mockup Adobe XD, ho scritto il servizio `AniListService`. Questo esegue interrogazioni GraphQL in tempo reale al database di AniList, usando il `mal_id` come chiave esterna per recuperare dinamicamente le copertine mancanti.
2. **Design Pattern (Service Layer):** Il Controller principale della dashboard e le logiche di caching sono state estratte in file **Service** dedicati. Questo rispetta il *Single Responsibility Principle* (SRP), mantenendo i Controller snelli e scalabili.
3. **Frontend a Componenti:** L'interfaccia complessa della Dashboard è stata suddivisa in Componenti Blade riutilizzabili (`<x-carousel>`). Alpine.js orchestra le animazioni complesse (Spotlight, Hero) ricevendo dati formattati in JSON dal server, prevenendo il ricaricamento della pagina e offrendo una navigazione fluida e istantanea.

---

## Setup del Progetto

### Prerequisiti
- PHP 8.1+
- Composer
- Node.js & npm
- Database (SQLite, MySQL o PostgreSQL)

### Installazione Veloce

1. **Installa le dipendenze:**
   ```bash
   composer install
   npm install
   ```

2. **Configura l'ambiente:** 
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    Assicurati di configurare correttamente la connessione al database nel file .env.

3. **Inizializza il Database:**
    ```bash
    php artisan migrate
    ```

4. **Compila gli assets frontend (Tailwind):**
    ```bash
    npm run build
    ```

5. **Popola il Database con le API:**
    ```bash
    # Scarica i primi record dalle API Jikan (impostato a 5 pagine di default)
    php artisan jikan:fetch
    ```

6. **Avvia il server locale:**
    ```bash
    php artisan serve
    ```

## Struttura del Progetto

```
DNA/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php          # Dashboard principale (22 linee)
│   │   │   ├── AnimeController.php         # Dettagli anime
│   │   │   ├── MangaController.php         # Dettagli manga
│   │   │   └── FavoritesController.php     # Gestione preferiti
│   ├── Models/
│   │   ├── Anime.php                       # Model anime con cast genres
│   │   ├── Manga.php                       # Model manga con cast genres
│   │   └── User.php                        # Utente con morfiche relations
│   ├── Services/
│   │   ├── DashboardService.php            # Logica caricamento dati dashboard
│   │   ├── AniListService.php              # Integrazione GraphQL AniList
│   │   └── JikanCacheService.php           # Cache 24h per API Jikan
│   └── Console/
│       └── Commands/
│           └── FetchJikanData.php          # Command importazione dati
├── resources/
│   ├── views/
│   │   ├── dashboard.blade.php             # Dashboard principale (23 linee)
│   │   ├── anime/show.blade.php            # Dettagli anime con generi
│   │   ├── manga/show.blade.php            # Dettagli manga con generi
│   │   └── components/
│   │       ├── carousels/                  # 9 caroselli tematici
│   │       └── banners/                    # 3 banner promozionali
│   └── js/
│       └── app.js                          # Alpine.js con funzioni globali
├── database/
│   └── migrations/                         # Schema database
└── routes/
    └── web.php                             # Definizione rotte
```

---

## Tecnologie Utilizzate

### Backend
- **Laravel 10** - Framework web PHP
- **PHP 8.1+** - Linguaggio backend
- **MySQL/PostgreSQL/SQLite** - Database
- **Composer** - Package manager PHP

### Frontend
- **Blade** - Template engine Laravel
- **Alpine.js** - JavaScript reattivo leggero
- **TailwindCSS** - Utility-first CSS framework
- **JavaScript** - Logica client-side

### API Esterne
- **Jikan API v4** - Dati anime/manga
- **AniList GraphQL** - Banner e immagini ad alta qualità

---

## Features Principali

### Dashboard
-  Hero carousel con navigazione fluida
-  9 caroselli tematici (Recommended, Continue Watching/Reading, Top 10, Spotlight)
-  Banner promozionali dinamici
-  Sistema preferiti asincrono (senza page reload)
-  Responsive design (mobile, tablet, desktop)

### Pagine Dettagli
-  Visualizzazione titolo, voto, generi
-  Numero episodi (anime)
-  Trama completa
-  Recensioni live da Jikan
-  Bottone aggiungi/rimuovi preferiti

### Sistema Utenti
-  Autenticazione con Laravel Breeze
-  Cronologia guardati/letti (Watch/Read History)
-  Gestione preferiti personali
-  Profilo utente



## Responsive Design

- Desktop (1920px+)
- Tablet (768px - 1024px)
- Mobile (320px - 767px)

Tutti i caroselli sono ottimizzati per il touch e il click su dispositivi mobile.


## Performance & Best Practices

 **Dashboard refactorizzata:** Divisa in 12 componenti Blade riutilizzabili  
 **Service Layer:** Logica separata dal Controller (22 linee)  
 **Rate Limiting:** Rispetto rigido del limite API (3 req/sec)  
 **Caching:** Recensioni cachate per 24 ore  
 **Lazy Loading:** Immagini ottimizzate con object-fit  
 **Responsive:** Mobile-first design  

---

## Note Importanti

- I **generi** sono importati da Jikan e visualizzati come badge nelle pagine di dettaglio
- Le **recensioni** vengono caricate in real-time dalla pagina di dettaglio
- Il sistema **preferiti** funziona in modo asincrono senza refresh della pagina
- Usa `php artisan jikan:fetch --pages=X` per importare più dati

---

## Autore

Sviluppato come test fullstack per DNAGroup.


