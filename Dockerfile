FROM php:8.4-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy composer files first for better layer caching
COPY composer.json composer.lock symfony.lock ./

# Install dependencies (will be overridden by volume mount in dev)
RUN composer install --no-interaction --no-scripts --no-autoloader

# Copy the rest of the application
COPY . .

# Generate autoloader and run post-install scripts
RUN composer dump-autoload --optimize && \
    php bin/console importmap:install --no-interaction || true

EXPOSE 8000

CMD ["sh", "-c", "composer install --no-interaction && php bin/console importmap:install --no-interaction && php -S 0.0.0.0:8000 -t public"]
