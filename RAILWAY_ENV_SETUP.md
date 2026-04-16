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

### Email Configuration (REQUIRED for Password Reset OTP):

⚠️ **IMPORTANT**: Password reset feature requires working email. Add these variables:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@vacctrack.ph"
MAIL_FROM_NAME="VaccTrack"
```

**For Gmail users:**
- Use your Gmail address for `MAIL_USERNAME`
- For `MAIL_PASSWORD`, generate an [App Password](https://myaccount.google.com/apppasswords) (enable 2FA first)
- Do NOT use your regular Gmail password
- Do NOT use quotes around values (Railway handles this automatically)

## Why We Delete .env

- `.env` contains placeholder syntax like `${MySQL.MYSQL_HOST}` which would be cached during build
- If cached with placeholders, the app would try to connect to literal string `${MySQL.MYSQL_HOST}` instead of actual host
- By deleting `.env` before `config:cache`, Laravel reads real environment variables injected by Railway at build time
- At runtime, Railway injects the actual values, and the app uses them

## Latest Changes (2026-03-13)

- Changed `runImage` from `php:8.3-fpm` to `php:8.3-cli` (FPM cannot run php artisan serve)
- Changed start command from `&` (parallel) to `&&` (sequential)
- Build phase now correctly: delete .env → run config:cache → cache real environment values

## Latest Changes (2026-04-17) - Email Configuration Fix

- **Added**: `config/mail.php` configuration file (was missing!)
- **Why**: Without this file, Laravel cannot send emails on Railway
- **Impact**: Password reset OTP emails now work when MAIL_* variables are set
- **Action**: Make sure to set all Email Configuration variables above in Railway's dashboard
- **Test**: Try password reset feature after setting mail variables and redeploying
