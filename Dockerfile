# Build stage
FROM php:8.3-cli AS builder

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application code
WORKDIR /app
COPY . .

# Install PHP dependencies
RUN composer install --ignore-platform-reqs --no-interaction

# Build stage - prepare for production
RUN rm -f .env && \
    composer install --no-dev --optimize-autoloader --no-interaction && \
    php artisan route:cache && \
    php artisan view:cache

# Runtime stage
FROM php:8.3-cli

# Install only runtime dependencies and extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Create necessary directories
RUN mkdir -p /app/bootstrap/cache \
    && mkdir -p /app/storage/logs \
    && mkdir -p /app/storage/framework/cache \
    && mkdir -p /app/storage/framework/sessions \
    && mkdir -p /app/storage/framework/views \
    && chmod -R 775 /app/bootstrap/cache \
    && chmod -R 775 /app/storage

WORKDIR /app

# Copy built application from builder
COPY --from=builder /app .

# Set proper permissions
RUN chown -R www-data:www-data /app

EXPOSE 8080

# Start: clear config, attempt migrate, then always start server
CMD ["sh", "-c", "php artisan config:clear && php artisan migrate --force --no-interaction; php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]
