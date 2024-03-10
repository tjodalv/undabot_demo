FROM php:8.2-fpm

ARG UID=1000
ARG GID=1000

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    zip \
    unzip \
    git \
    curl \
    nodejs \
    npm \
    postgresql-client

# Clear the apt cache to reduce image size
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Install and configure PHP extensions
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install -j$(nproc) iconv mbstring xml dom pdo pdo_pgsql pgsql gd zip intl exif bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Add composer to the PATH
ENV PATH="$PATH:/root/.composer/vendor/bin"

# Create laravel user and group with the same IDs as on the host machine
RUN groupadd -g $GID phpuser && \
    useradd -m -u $UID -g phpuser phpuser

USER phpuser
