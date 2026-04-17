#!/bin/bash
# Healthcheck script for both web and worker services

# For web service: check HTTP endpoint
if [ "$PROCESS_TYPE" = "worker" ] || [ "$RAILWAY_SERVICE_NAME" = "worker" ]; then
    # Worker healthcheck - just check if PHP process is running
    if pgrep -f "queue:work" > /dev/null; then
        exit 0
    else
        exit 1
    fi
else
    # Web healthcheck - check HTTP endpoint
    curl -f http://localhost:8080/api/health || exit 1
fi
