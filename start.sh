#!/bin/bash
# Startup script for Railway - handles web or worker processes

# Clear config and run migrations on startup
php artisan config:clear
php artisan migrate --force --no-interaction

# Determine which service is running based on environment
if [ "$PROCESS_TYPE" = "worker" ] || [ "$RAILWAY_SERVICE_NAME" = "worker" ] || [ "$1" = "worker" ]; then
    # Worker process with verbose logging and increased timeout
    echo "🔄 Starting Queue Worker with verbose logging..."
    echo "Mail driver: $(php -r 'echo getenv("MAIL_MAILER");')"
    echo "Mail host: $(php -r 'echo getenv("MAIL_HOST");')"
    exec php artisan queue:work database --timeout=120 --tries=3 --verbose
else
    # Web process (default)
    echo "🚀 Starting Web Server..."
    exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
fi
