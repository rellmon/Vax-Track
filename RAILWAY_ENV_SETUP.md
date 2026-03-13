# Railway Environment Variables Setup

## Required Environment Variables

Since we delete `.env` during the build process (to prevent placeholder values from being cached), **you must set all critical environment variables in Railway's dashboard**.

### Step-by-Step Setup in Railway Dashboard:

1. Go to your VaxTrack project on Railway
2. Click on the main project service
3. Go to the **Variables** tab
4. Add the following variables:

### Essential Variables (MUST SET):

```
APP_KEY=base64:69swAzxCsYoWL7JfPDv0CVCRnQHwXHQUQkKTerjG0XM=
APP_NAME=VaxTrack
APP_ENV=production
APP_DEBUG=false
LOG_CHANNEL=stderr
```

### Database Variables (AUTO-INJECTED):

Railway automatically injects these when you link the MySQL service:
- `MySQL.MYSQL_HOST`
- `MySQL.MYSQL_PORT`
- `MySQL.MYSQL_DATABASE`
- `MySQL.MYSQL_USER`
- `MySQL.MYSQL_PASSWORD`

The app will read these injected variables directly (no .env file needed).

### Optional Email Configuration (if sending emails):

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
```

## Why We Delete .env

- `.env` contains placeholder syntax like `${MySQL.MYSQL_HOST}` which would be cached during build
- If cached with placeholders, the app would try to connect to literal string `${MySQL.MYSQL_HOST}` instead of actual host
- By deleting `.env` before `config:cache`, Laravel reads real environment variables injected by Railway at build time
- At runtime, Railway injects the actual values, and the app uses them

## Latest Changes (2026-03-13)

- Changed `runImage` from `php:8.3-fpm` to `php:8.3-cli` (FPM cannot run php artisan serve)
- Changed start command from `&` (parallel) to `&&` (sequential)
- Build phase now correctly: delete .env → run config:cache → cache real environment values
