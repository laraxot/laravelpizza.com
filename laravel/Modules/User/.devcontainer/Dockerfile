# Usa l'immagine ufficiale PHP 8.3 con Apache
FROM php:8.3-apache

# Aggiorna i pacchetti di sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libicu-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd exif \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-enable gd \
    && docker-php-ext-install bcmath \
    && docker-php-ext-enable bcmath \
    && docker-php-ext-install exif \
    && docker-php-ext-enable exif \
    && docker-php-ext-install gettext \
    && docker-php-ext-enable gettext 
    #&& docker-php-ext-install opcache \
    #&& docker-php-ext-enable opcache \

# Installa Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Abilita i moduli Apache richiesti
RUN a2enmod rewrite

# Imposta la working directory
WORKDIR /var/www/html

# Copia i file di configurazione per il Virtual Host
COPY vhost.conf /etc/apache2/sites-available/000-default.conf

# Modifica i permessi della directory /var/www per l'utente www-data
RUN chown -R www-data:www-data /var/www

# Imposta l'utente a www-data per evitare problemi di permessi
USER www-data

# Aggiungi e configura VS Code server
RUN mkdir -p '/var/www/.vscode-server/bin' && \
    ln -snf '/vscode/vscode-server/bin/linux-x64/5c3e652f63e798a5ac2f31ffd0d863669328dc4c' '/var/www/.vscode-server/bin/5c3e652f63e798a5ac2f31ffd0d863669328dc4c'

# Esponi la porta 8000 per Apache
EXPOSE 8000

# Avvia Apache in modalità foreground
CMD ["apache2-foreground"]
