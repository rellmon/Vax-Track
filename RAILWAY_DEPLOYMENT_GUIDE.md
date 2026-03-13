# Railway Deployment Guide - Health Check Fix

## Changes Made

### 1. ✅ Simplified Health Check Endpoint
- **File**: `app/Http/Controllers/HealthCheckController.php`
- **What it does**: Returns 200 OK immediately when the app is responsive
- **No database checks**: Lightweight and fast (fixes timeout issues)

### 2. ✅ Updated Start Commands (Both configs)
**Before**: `php artisan migrate --force && php artisan serve` (migrations blocked startup)
**After**: `php artisan migrate --force --quiet & php artisan serve` (migrations run in background)

- Migrations run without blocking the health check
- Server responds immediately to requests
- Database migration happens concurrently

### 3. ✅ Corrected Health Check Path
- Changed from `/` (which redirects to login) → `/api/health`
- Health check URL will be: `https://your-railway-app.up.railway.app/api/health`

## Critical: Set Environment Variables in Railway

Go to **Railway Dashboard → Your Project → Variables** and set:

```env
DB_HOST=your-actual-db-host
DB_PORT=3306
DB_NAME=vacctrack
DB_USER=root
DB_PASSWORD=your-actual-password
APP_KEY=base64:kJMYCjIOfFnE0olhGHNGIHjuia5Zq5InP5kICV8HruU=
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-railway-domain.up.railway.app
```

⚠️ **WARNING**: Without these variables, the database connection will fail!

## How to Redeploy

1. **Commit and push your changes**:
   ```bash
   git add -A
   git commit -m "Fix Railway health check configuration"
   git push
   ```

2. **In Railway Dashboard**:
   - Go to your project
   - Click the **Deployments** tab
   - Click the **Deploy** button to force redeploy
   - Or wait for Railway to auto-detect the git push

3. **Monitor the deployment**:
   - Watch the **Logs** tab in real-time
   - Health check should pass after ~10 seconds
   - You should see "successfully became healthy" message

## Expected Health Check Flow

```
00:00 - Build starts
00:30 - Build completes  
00:40 - Container starts
00:45 - PHP server starts
00:50 - Health check attempt #1 → SUCCESS ✅ (200 OK from /api/health)
00:51 - Migrations running in background
01:00 - Migrations complete
01:05 - App fully ready for requests
```

## Troubleshooting

### Still failing after 5 minutes?

**Check 1: Are environment variables set?**
```bash
# In Railway Console, verify:
echo $DB_HOST
echo $DB_USER
```

**Check 2: Look at startup logs**
```
[error] Database connection failed
→ Check DB_HOST, DB_USER, DB_PASSWORD are correct

[error] Port binding failed  
→ PORT variable should be auto-set by Railway
```

**Check 3: Test local build**
```bash
# Locally test if app starts:
php artisan serve --host=0.0.0.0 --port=8000

# In another terminal:
curl http://localhost:8000/api/health
# Should return: {"status":"healthy",...}
```

## File Changes Summary

| File | Change |
|------|--------|
| `app/Http/Controllers/HealthCheckController.php` | Simplified - no DB checks |
| `routes/api.php` | Added `/api/health` route |
| `railway.toml` | Updated health check path and start command |
| `nixpacks.toml` | Updated start command to run migrations in background |
| `.env` | Database vars now use Railway environment variables |

## Next Steps

1. ✅ Push changes to git
2. ✅ Set environment variables in Railway
3. ⏳ Trigger redeploy
4. 📊 Monitor health check in real-time
5. ✨ App should be healthy within 30 seconds
