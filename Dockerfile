FROM php:8.2-apache

# Installazione dipendenze di sistema
RUN apt-get update && apt-get install -y \
    libpng-dev zlib1g-dev libxml2-dev libzip-dev zip unzip git \
    && docker-php-ext-install pdo_mysql gd zip

# Abilita mod_rewrite per Laravel
RUN a2enmod rewrite

# Copia i file del progetto
COPY . /var/www/html

# Imposta la cartella pubblica di Laravel come root di Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Installa Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Permessi per le cartelle di Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache