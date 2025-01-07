# Start from the official PHP image with the required extensions
FROM php:8.4-fpm

# Install system dependencies and PHP extensions required for Laravel
RUN apt-get update && apt-get install -y \
    zsh \
    git \
    curl \
    zip \
    unzip \
    vim \
    wget \
    libpq-dev \
    libonig-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_pgsql pdo_mysql zip

# Set Zsh as the default shell
RUN chsh -s /bin/zsh

ENV NODE_VERSION=12.14.0
ENV NVM_DIR /tmp/nvm
WORKDIR $NVM_DIR

RUN wget -qO- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.1/install.sh | bash \
    && . $NVM_DIR/nvm.sh \
    && nvm install $NODE_VERSION \
    && nvm alias default $NODE_VERSION \
    && nvm use default

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory inside the container
WORKDIR /var/www/html

## Set permissions for storage and bootstrap/cache
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 755 /var/www/html


# Install Oh My Zsh and use "robbyrussell" theme
RUN sh -c "$(wget -O- https://github.com/deluan/zsh-in-docker/releases/download/v1.2.1/zsh-in-docker.sh)" -- \
    -t robbyrussell
