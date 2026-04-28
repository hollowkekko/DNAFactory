import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.toggleFavorite = function(animeId) {
    fetch(`/favorites/anime/${animeId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .catch(error => console.error('Error:', error))
    .finally(() => {
        window.dispatchEvent(new CustomEvent('toggle-favorite', { detail: animeId }));
    });
}

window.toggleFavoriteManga = function(mangaId) {
    fetch(`/favorites/manga/${mangaId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .catch(error => console.error('Error:', error))
    .finally(() => {
        window.dispatchEvent(new CustomEvent('toggle-favorite-manga', { detail: mangaId }));
    });
}