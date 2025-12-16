# Use the official PHP image with Apache
FROM php:8.2-apache

# Set the working directory inside the container
WORKDIR /var/www/html

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install required Linux libraries, tools, and Zsh
RUN apt-get update -y && apt-get install -y \
    zsh \
    git \
    libicu-dev \
    libmariadb-dev \
    libzip-dev \
    unzip zip \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmemcached-dev \
    redis-tools \
    && docker-php-ext-install intl pdo_mysql zip opcache exif \
    && pecl install redis memcached \
    && docker-php-ext-enable redis memcached

# Install GD with necessary dependencies
RUN apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Install Opcache
RUN docker-php-ext-install opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configure and install the GD extension for image manipulation
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Copy Apache configuration for local development
COPY apache-local.conf /etc/apache2/sites-available/000-default.conf

# Create storage directory if it does not exist
RUN mkdir -p /var/www/html/laravel/storage

# Set proper ownership and permissions for Laravel storage folder
RUN chgrp -R www-data /var/www/html \
    && chown -R www-data:www-data /var/www/html/laravel/storage \
    && chmod -R 775 /var/www/html/laravel/storage

# Copy and configure the .env.docker file for multiple databases
COPY ./laravel/.env.docker /var/www/html/laravel/.env
RUN sed -i "s/DB_DATABASE=laravel/DB_DATABASE_USERS=users_db/" /var/www/html/laravel/.env && \
    sed -i "s/DB_DATABASE=laravel/DB_DATABASE_GENERAL=general_db/" /var/www/html/laravel/.env && \
    echo "DB_DATABASE_SURVEY=survey_db" >> /var/www/html/laravel/.env

# Enable PHP short tags required by Laravel
RUN echo "short_open_tag = On" > /usr/local/etc/php/conf.d/short-tags.ini

# Configure PHP settings for Opcache
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=128" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.interned_strings_buffer=8" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.max_accelerated_files=10000" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.revalidate_freq=2" >> /usr/local/etc/php/conf.d/opcache.ini

# Set up Zsh as the default shell and configure it
RUN chsh -s $(which zsh) \
    && curl -L https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh | sh \
    && git clone https://github.com/romkatv/powerlevel10k.git $HOME/.oh-my-zsh/themes/powerlevel10k \
    && echo 'ZSH_THEME="powerlevel10k/powerlevel10k"' >> $HOME/.zshrc \
    && echo 'source $ZSH/oh-my-zsh.sh' >> $HOME/.zshrc

# Ensure the SSH keys are available for Git
RUN mkdir -p ~/.ssh && chmod 700 ~/.ssh

# Start Apache
CMD ["apache2-foreground"]
