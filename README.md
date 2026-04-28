# 🎬 DNAFactory - Piattaforma Anime & Manga

Una moderna piattaforma web fullstack sviluppata in **Laravel 10** per esplorare, scoprire e gestire anime e manga, integrando le API pubbliche di **Jikan** e **AniList**.

Questo progetto è stato realizzato come **Test Pratico Fullstack** per la candidatura presso DNA Group.

---

## ✨ Funzionalità Sviluppate (Requisiti Traccia)

✅ **Architettura Fullstack**
- Sviluppo completo sia della parte Backend (Laravel/PHP) che Frontend (Blade, TailwindCSS, Alpine.js) rispettando il mockup grafico Adobe XD fornito.

✅ **Importazione e Persistenza Dati (Backend)**
- Creazione di un comando custom (`php artisan jikan:fetch`) per importare l'anagrafica di Anime e Manga tramite le API REST di Jikan.
- **Gestione Rate Limit:** Il comando implementa meccanismi di *delay* (`sleep`) e di *retry* nativi di Laravel per rispettare rigidamente il rate limit di 3 richieste/secondo imposto da Jikan API, garantendo un'importazione stabile senza crash.
- Logica idempotente (`updateOrCreate`) per consentire esecuzioni sicure tramite Cron Job giornalieri, aggiornando i record esistenti ed evitando duplicati.

✅ **Recensioni in Real-time (Senza persistenza)**
- Le recensioni vengono caricate in real-time chiamando le API di Jikan dalla pagina di dettaglio.
- **Cache Statica (Opzionale):** È stato aggiunto un livello di cache statica di 24 ore (`JikanCacheService`) per ottimizzare i tempi di caricamento, ridurre il carico sulle API e massimizzare le performance.

✅ **Sistema Utenti e Preferiti**
- Autenticazione protetta (Login, Registrazione, Modifica profilo) tramite Laravel Breeze.
- Sistema di "Aggiungi/Rimuovi ai Preferiti" asincrono gestito nel frontend con Alpine.js.
- **Morphic Relationships:** Utilizzate nel database per gestire con un'unica tabella (`favorites`) e un unico Controller le relazioni verso i Modelli `Anime` e `Manga`.

---

## 🚀 L'Extra Mile (Scelte Architetturali e UI)

Oltre ai requisiti minimi richiesti, ho implementato ulteriori feature per ottimizzare la manutenibilità e migliorare notevolmente la User Experience:

1. **Integrazione GraphQL (AniList API):** Poiché le API di Jikan non forniscono i banner ad alta risoluzione o i loghi necessari per riprodurre fedelmente la UI "stile Netflix" richiesta dal mockup Adobe XD, ho scritto il servizio `AniListService`. Questo esegue interrogazioni GraphQL in tempo reale al database di AniList, usando il `mal_id` come chiave esterna per recuperare dinamicamente le copertine mancanti.
2. **Design Pattern (Service Layer):** Il Controller principale della dashboard e le logiche di caching sono state estratte in file **Service** dedicati. Questo rispetta il *Single Responsibility Principle* (SRP), mantenendo i Controller snelli e scalabili.
3. **Frontend a Componenti:** L'interfaccia complessa della Dashboard è stata suddivisa in Componenti Blade riutilizzabili (`<x-carousel>`). Alpine.js orchestra le animazioni complesse (Spotlight, Hero) ricevendo dati formattati in JSON dal server, prevenendo il ricaricamento della pagina e offrendo una navigazione fluida e istantanea.

---

## 📋 Setup del Progetto

### Prerequisiti
- PHP 8.1+
- Composer
- Node.js & npm
- Database (SQLite, MySQL o PostgreSQL)

### Installazione Veloce

1. **Clona il repository e installa le dipendenze:**
   ```bash
   git clone <inserisci-url-o-nome-repo>
   cd DNAFactory
   composer install
   npm install

2. **Configura l'ambiente:** 
    ```bash
    cp .env.example .env
    php artisan key:generate
