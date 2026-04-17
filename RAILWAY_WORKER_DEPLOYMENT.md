# Railway Deployment Guide - Queue Worker Setup (Option A)

## Overview
This guide walks through setting up the password reset queue worker on Railway using a separate service (Option A) with Docker.

## Prerequisites
- Updated environment variable: `QUEUE_CONNECTION=database` (change from `sync`)
- All mail configuration is set correctly ✅

## Step 1: Verify Environment Variables in Railway

Your current configuration is good! Just verify these are set correctly:

### Must Change:
```
QUEUE_CONNECTION=database
```
(Change from current `sync` to `database`)

### Verify these exist and are correct:
```
APP_KEY=base64:69swAzxCsYoWL7JfPDv0CVCRnQHwXHQUQkKTerjG0XM=
APP_ENV=production
APP_DEBUG=false
QUEUE_CONNECTION=database
DB_CONNECTION=mysql
DB_HOST=mainline.proxy.rlwy.net
DB_PORT=18379
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=FTPaHICViXirNrIoVCfJcVTsioFKCzTP
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=rellmontezor@gmail.com
MAIL_PASSWORD=vnav kzbx emup lbfb
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@vacctrack.ph
MAIL_FROM_NAME=VaxTrack
```

✅ **All mail credentials look good!**

## Step 2: Add Worker Service to Railway

### Create Separate Worker Service:

1. **In Railway Dashboard:**
   - Go to your VaxTrack project
   - Click `+ New`
   - Select `Empty Service`
   - Name it: `worker` or `queue-worker`

2. **Configure the Service:**
   - Click on the new worker service
   - Go to `Settings`
   - Set `Service Name` to: `worker`

3. **Add Variables to Worker Service:**
   Go to `Variables` tab and add ALL these variables:
   
   ```
   APP_NAME=VaxTrack
   APP_KEY=base64:69swAzxCsYoWL7JfPDv0CVCRnQHwXHQUQkKTerjG0XM=
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://your-railway-app.railway.app
   
   LOG_CHANNEL=single
   LOG_LEVEL=error
   
   DB_CONNECTION=mysql
   DB_HOST=mainline.proxy.rlwy.net
   DB_PORT=18379
   DB_DATABASE=railway
   DB_USERNAME=root
   DB_PASSWORD=FTPaHICViXirNrIoVCfJcVTsioFKCzTP
   
   BROADCAST_CONNECTION=log
   FILESYSTEM_DISK=local
   QUEUE_CONNECTION=database
   CACHE_DRIVER=file
   SESSION_DRIVER=file
   
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=rellmontezor@gmail.com
   MAIL_PASSWORD=vnav kzbx emup lbfb
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=noreply@vacctrack.ph
   MAIL_FROM_NAME=VaxTrack
   ```

4. **Connect to Source Repo:**
   - In the worker service, go to `Deployment`
   - Click `Connect Repository`
   - Select your `rellmon/Vax-Track` repository
   - Branch: `master` (or your main branch)

5. **Deploy:**
   - Railway will automatically:
     - Build the Docker image
     - Run migrations
     - Start the queue worker
   - Wait for deployment to complete

## Step 3: Update Your Main Web Service

In your main **web** service in Railway:

### Ensure Variables Include:
```
QUEUE_CONNECTION=database
```

### The web service Dockerfile will:
- Run migrations on startup: `release: php artisan migrate --force`
- Start the web server on default process

Both services will share the same database and queue table (`jobs`).

## Step 4: Verify Services are Running

1. **Check Web Service:**
   - Click on web service
   - View Logs - should show requests working
   - Health check should show ✅

2. **Check Worker Service:**
   - Click on worker service
   - View Logs - should show:
     ```
     🔄 Starting Queue Worker...
     Listening for jobs...
     Processing jobs...
     ```

3. **Verify Both Can Access Database:**
   - Both services should connect to the same MySQL database
   - Jobs table should be created and accessible

## Step 5: Test the Password Reset Feature

1. **Go to your deployed app:**
   ```
   https://your-railway-app.railway.app/forgot-password
   ```

2. **Request OTP:**
   - Enter your email
   - Select role (doctor or parent)
   - Click "Send Code"
   - **Page should respond instantly** (< 1 second) ✅

3. **Check Email:**
   - Should receive OTP email within **5-10 seconds** ✅
   - If using Gmail, might appear in spam folder

4. **Verify in Database:**
   You can check if job was processed:
   ```bash
   # SSH into Railway
   railway shell
   
   # Check jobs table (should be empty after processing)
   php artisan tinker
   >>> DB::table('jobs')->count();
   >>> DB::table('failed_jobs')->count();
   ```

## Step 6: Monitor Queue Processing

### View Worker Logs:
1. Open worker service in Railway
2. Click `Logs`
3. Look for messages like:
   ```
   🔄 Starting Queue Worker...
   [2024-04-18 10:30:45] Processing App\Jobs\SendPasswordResetOtp
   [2024-04-18 10:30:46] ✅ Password reset OTP email sent successfully
   ```

### Check Failed Jobs:
```bash
railway shell
php artisan queue:failed
php artisan queue:retry all  # Retry failed jobs
```

## Step 7: Configure Auto-Restart (Optional)

In worker service settings:
- **Restart Policy**: `ON_FAILURE`
- **Max Retries**: `3`

This ensures worker restarts if it crashes.

## Troubleshooting

### Worker not starting?
1. Check worker service logs
2. Verify all environment variables are set
3. Check database connection: `DB_HOST`, `DB_PORT`, `DB_USERNAME`, `DB_PASSWORD`

### Emails not sending?
1. Verify `MAIL_USERNAME` and `MAIL_PASSWORD` in worker service
2. Check Gmail is set to allow "Less secure apps" or using App Password
3. Check worker logs for email errors

### Jobs not being processed?
1. Verify worker service is running: check Logs
2. Check if `jobs` table has records: `SELECT COUNT(*) FROM jobs;`
3. Check `failed_jobs` table for errors

### Still having issues?
1. Check worker logs: `railway logs -f`
2. Run queue worker locally with verbose: `php artisan queue:work database --verbose`
3. Test mail locally: `php artisan tinker`
   ```php
   Mail::to('test@test.com')->send(new App\Mail\PasswordResetOtp('doctor', 'John', '123456'))
   ```

## Your Deployment Architecture

```
┌─────────────────────────────┐
│     Railway Project         │
│  ┌───────────────────────┐  │
│  │   Web Service         │  │
│  │ - Handles API/Web     │  │
│  │ - Dispatches jobs    │  │
│  └───────────────────────┘  │
│  ┌───────────────────────┐  │
│  │   Worker Service      │  │
│  │ - Processes queue     │  │
│  │ - Sends emails        │  │
│  └───────────────────────┘  │
│  ┌───────────────────────┐  │
│  │   MySQL Database      │  │
│  │ - Shared database     │  │
│  │ - Jobs & failed_jobs  │  │
│  └───────────────────────┘  │
└─────────────────────────────┘
```

## Performance Expectations

After setup:
- **Page load**: < 1 second ✅
- **Email delivery**: 2-10 seconds ✅
- **Automatic retry**: Failed jobs retry 3 times
- **Logging**: All activities logged to storage/logs/laravel.log

## Useful Commands

```bash
# SSH into Railway for either service
railway shell

# Check pending jobs
php artisan tinker
>>> DB::table('jobs')->count();

# View failed jobs
php artisan queue:failed

# Retry all failed jobs
php artisan queue:retry all

# Process jobs manually (for testing)
php artisan queue:work database --once --max-jobs=5

# View queue logs
tail -f storage/logs/laravel.log | grep -i queue
```

## Next Steps

1. ✅ Update `QUEUE_CONNECTION` to `database`
2. ✅ Create worker service in Railway
3. ✅ Add all environment variables to worker service
4. ✅ Connect repository to worker service
5. ✅ Wait for deployment to complete
6. ✅ Test password reset feature
7. ✅ Monitor logs for 24 hours
8. ✅ Adjust settings if needed

You're all set! The queue worker is now ready to process password reset OTP emails asynchronously.

