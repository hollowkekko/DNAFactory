# 🎬 Piattaforma Anime & Manga - DNA

Una moderna piattaforma Laravel per scoprire, esplorare e gestire i tuoi anime e manga preferiti usando l'API Jikan.

## 🚀 Funzionalità

✅ **Catalogo Anime & Manga**
- Listing paginato di anime e manga
- Pagine di dettaglio con informazioni complete
- Voto e trama per ogni titolo

✅ **Recensioni Real-time**
- Caricamento dinamico delle recensioni tramite AlpineJS
- Fetch da Jikan API senza persistenza
- Cache statico di 24 ore sul backend (opzionale)

✅ **Sistema di Login**
- Registrazione e autenticazione con Laravel Breeze
- Verifica email integrata
- Gestione del profilo utente

✅ **Preferiti (Favorites)**
- Aggiungi/Rimuovi anime e manga dai preferiti
- Toggle semplice e intuitivo
- Pagina dedicata ai tuoi preferiti
- Morphic relationships per gestire sia Anime che Manga

✅ **Importazione Dati**
- Comando per importare anime e manga da Jikan API
- Rispetto automatico dei rate limits (3 req/sec)
- Update intelligente (evita duplicati)

✅ **Caching Intelligente**
- Cache statico 24 ore per le API reviews
- Servizio dedicato `JikanCacheService`
- Riducono il carico sulle API

## 📋 Setup

### Prerequisiti
- PHP 8.1+
- Composer
- Node.js & npm
- SQLite o MySQL

### Installazione

```bash
# 1. Clona il repository
git clone <repository-url>
cd DNA

# 2. Installa dipendenze
composer install
npm install

# 3. Configura ambiente
cp .env.example .env
php artisan key:generate

# 4. Database
php artisan migrate

# 5. Build assets
npm run build
```

## 🎯 Comandi Disponibili

### Importare Anime & Manga

```bash
# Importa 5 pagine di anime e manga (default)
php artisan jikan:fetch

# Importa un numero specifico di pagine
php artisan jikan:fetch --pages=10

# Importa una sola pagina (circa 25 titoli per categoria)
php artisan jikan:fetch --pages=1
```

**Nota:** Ogni importazione rispetta i rate limits di Jikan API (max 3 richieste/sec).

### Pulire la Cache

```bash
# Svuota tutte le cache (incluso i reviews)
php artisan cache:clear

# Ricompila le view
php artisan view:cache
```

## 🌐 Rotte

### Public (Senza Login)
- `GET /anime` - Listing anime
- `GET /anime/{mal_id}` - Dettaglio anime
- `GET /manga` - Listing manga
- `GET /manga/{mal_id}` - Dettaglio manga

### Protected (Con Login)
- `GET /` - Dashboard (home)
- `GET /favorites` - I miei preferiti
- `POST /favorites/anime/{mal_id}` - Toggle anime
- `POST /favorites/manga/{mal_id}` - Toggle manga
- `GET /profile` - Profilo utente

## 📁 Struttura del Progetto

```
.
├── app/
│   ├── Console/Commands/
│   │   └── FetchJikanData.php          # Comando importazione Jikan API
│   ├── Services/
│   │   └── JikanCacheService.php       # Servizio caching 24h
│   ├── Http/Controllers/
│   │   ├── AnimeController.php
│   │   ├── MangaController.php
│   │   └── FavoriteController.php
│   ├── Models/
│   │   ├── Anime.php
│   │   ├── Manga.php
│   │   ├── Favorite.php
│   │   └── User.php
│   └── ...
├── database/migrations/
│   ├── create_animes_table.php
│   ├── create_mangas_table.php
│   └── create_favorites_table.php
├── resources/views/
│   ├── anime/
│   │   ├── index.blade.php
│   │   └── show.blade.php
│   ├── manga/
│   │   ├── index.blade.php
│   │   └── show.blade.php
│   ├── favorites/
│   │   └── index.blade.php
│   └── ...
└── routes/
    └── web.php
```

## 🔗 API Integration

**Jikan API** (https://jikan.moe/)
- Base URL: `https://api.jikan.moe/v4/`
- Anime endpoint: `/anime?page={page}`
- Manga endpoint: `/manga?page={page}`
- Reviews endpoint: `/anime/{mal_id}/reviews` e `/manga/{mal_id}/reviews`
- Rate limit: 3 richieste/sec (rispettato dal comando)

## 💾 Database Schema

### animes
- `mal_id` (PK) - MyAnimeList ID
- `title` - Titolo dell'anime
- `image_url` - URL dell'immagine
- `synopsis` - Trama
- `score` - Voto medio
- `timestamps`

### mangas
- `mal_id` (PK) - MyAnimeList ID
- `title` - Titolo del manga
- `image_url` - URL dell'immagine
- `synopsis` - Trama
- `score` - Voto medio
- `timestamps`

### favorites
- `id` (PK)
- `user_id` (FK) → users
- `favoritable_id` - ID dell'Anime/Manga
- `favoritable_type` - Tipo (Anime o Manga)
- `timestamps`
- **Unique:** (user_id, favoritable_id, favoritable_type)

## 🎨 Frontend

- **Tailwind CSS** - Styling
- **AlpineJS** - Componenti interattivi
- **Blade Templates** - Template engine

## 🔐 Autenticazione

Usa **Laravel Breeze** con:
- Registrazione email
- Verifica email
- Password reset
- CSRF protection

## 🚀 Deployment

### Vercel / Hosting PHP
```bash
php artisan config:cache
php artisan route:cache
npm run build
```

### Scheduling (Cron Job)
Per importare dati automaticamente ogni giorno:
```bash
0 0 * * * php /path/to/project/artisan jikan:fetch
```

## 📝 Note Importanti

1. **Rate Limiting**: Jikan API permette max 3 richieste/sec. Il comando rispetta questo limite con delay automatici.

2. **Cache**: Le reviews vengono cachate per 24 ore per ridurre le richieste API. Usa `php artisan cache:clear` per pulire.

3. **Morphic Relationships**: Il sistema Favorite usa morphic relationships per gestire sia Anime che Manga con una singola tabella.

4. **AlpineJS**: Le pagine di dettaglio caricano le reviews dinamicamente con AlpineJS direttamente dalle API (senza server caching).

## 🤝 Contribuire

Segnalazioni di bug e suggerimenti sono benvenuti!

## 📄 Licenza

MIT License - Vedi LICENSE file

---

**Creato da:** Hollowkekko  
**Framework:** Laravel 10  
**API:** Jikan MyAnimeList API  
**Data:** Aprile 2026
