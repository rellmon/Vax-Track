# Build stage
FROM php:8.3-cli AS builder

ARG CACHEBUST=3

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
ARG CACHEBUST=4
RUN echo "Cache bust: $CACHEBUST"
COPY . .

# Install PHP dependencies
RUN mkdir -p /app/bootstrap/cache /app/storage/logs /app/storage/framework/cache /app/storage/framework/sessions /app/storage/framework/views


RUN composer install --ignore-platform-reqs --no-interaction

# Build stage - prepare for production
RUN rm -f .env && \
    composer install --no-dev --optimize-autoloader --no-interaction && \
    php artisan route:cache && \
    php artisan view:cache

# Runtime stage
FROM php:8.3-cli

ARG CACHEBUST=3

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

# Copy startup and healthcheck scripts
COPY start.sh /app/start.sh
COPY healthcheck.sh /app/healthcheck.sh
RUN chmod +x /app/start.sh /app/healthcheck.sh

# Start: clear config, migrate then start server or worker
CMD ["/app/start.sh"]
