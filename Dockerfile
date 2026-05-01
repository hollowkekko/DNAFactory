FROM php:8.2-apache

# 1. Installazione dipendenze di sistema + Node.js (necessario per Vite)
RUN apt-get update && apt-get install -y \
    libpng-dev zlib1g-dev libxml2-dev libzip-dev zip unzip git libpq-dev curl \
    && curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo_pgsql pgsql gd zip

# 2. Abilita mod_rewrite per Laravel
RUN a2enmod rewrite

# 3. Copia i file del progetto
COPY . /var/www/html

# 4. Configura Apache per puntare alla cartella /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 5. Installa Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# 6. Compila gli asset JS/CSS (Risolve l'errore Manifest)
RUN npm install && npm run build

# 7. Permessi cartelle storage e cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Cambiamo "migrate" in "migrate:fresh" per ricostruire le tabelle correttamente
CMD sh -c "php artisan migrate:fresh --force && php artisan jikan:fetch --pages=2 && apache2-foreground"