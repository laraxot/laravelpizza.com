# Use the official PHP image with Apache
FROM php:8.2-apache

# Set the working directory inside the container
WORKDIR /var/www/html

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Update package list and install required Linux libraries and tools
RUN apt-get update -y \
    && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libmemcached-dev \
    redis-tools \
    zsh \
    git \
    libicu-dev \
    libmariadb-dev \
    unzip zip \
    zlib1g-dev \
    libjpeg62-turbo-dev

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg 

# Install required PHP extensions, including bcmath
RUN docker-php-ext-install \
    gettext \
    intl \
    pdo_mysql \
    gd \
    zip \
    exif \
    opcache \
    bcmath

    

# Install Redis and Memcached via PECL
RUN pecl install redis memcached

# Enable Redis and Memcached extensions
RUN docker-php-ext-enable redis memcached

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set proper permissions for Laravel storage and cache
#RUN chown -R www-data:www-data /var/www/html/laravel/storage /var/www/html/laravel/bootstrap/cache


# Enable PHP short tags required by Laravel
RUN echo "short_open_tag = On" > /usr/local/etc/php/conf.d/short-tags.ini

# Configure PHP Opcache
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
