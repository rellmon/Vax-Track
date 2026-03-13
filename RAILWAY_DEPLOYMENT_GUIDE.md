# Railway Deployment Guide - Health Check Fix

## Issues Fixed

### 1. ✅ Health Check Endpoint
- **Problem**: Root path `/` redirected to `/login`, causing timeout during health checks
- **Solution**: Created dedicated health check endpoint at `/api/health`
- **File**: `app/Http/Controllers/HealthCheckController.php`
- **Route**: Added in `routes/api.php`

### 2. ✅ Configuration Files Alignment
- **Updated `railway.toml`** to use `php artisan serve` instead of built-in PHP server
- Changed health check path to `/api/health` with 30-second timeout
- Removed `migrate:fresh --seed` to prevent data loss on restarts

### 3. ✅ Environment Variables
- **Modified `.env`** to use Railway's database variables:
  - `DB_HOST=${DB_HOST:-localhost}`
  - `DB_NAME=${DB_NAME:-vacctrack}`
  - `DB_USER=${DB_USER:-root}`
  - `DB_PASSWORD=${DB_PASSWORD:-}`

## How to Deploy on Railway

### Step 1: Set Environment Variables in Railway
Go to your Railway project Settings → Variables and add:

```
DB_HOST=your-db-host-from-railway
DB_PORT=3306
DB_NAME=vacctrack
DB_USER=root
DB_PASSWORD=your-database-password
APP_KEY=base64:kJMYCjIOfFnE0olhGHNGIHjuia5Zq5InP5kICV8HruU=
APP_ENV=production
APP_DEBUG=false
```

### Step 2: Redeploy
Push your code to your Git repository (connected to Railway), and Railway will automatically:
1. Install dependencies (`composer install --no-dev`)
2. Cache config and routes
3. Run migrations
4. Start the application

### Step 3: Verify Health Check
Test the health check endpoint:
```bash
curl https://your-railway-app.up.railway.app/api/health
```

Should return:
```json
{
  "status": "healthy",
  "timestamp": "2026-03-13T10:30:45.000000Z"
}
```

## Additional Notes

- **Migration**: Uses `php artisan migrate --force` (safe, won't recreate tables)
- **Health Check Timeout**: Set to 30 seconds (enough for cold starts)
- **Queue Processing**: Ensure `QUEUE_CONNECTION=database` is set for job processing
- **Storage**: The application uses `storage/` directory - consider configuring persistent storage in Railway if needed

## Troubleshooting

If health checks still fail:

1. **Check Railway logs**: Look for database connection errors
2. **Verify database is running**: Ensure MySQL/PostgreSQL service is deployed
3. **Check environment variables**: All DB_* variables must match your Railway database
4. **Test locally first**:
   ```bash
   php artisan serve
   curl http://localhost:8000/api/health
   ```

## Next Steps

- Monitor the deployment in Railway dashboard
- Check Application Logs for any startup errors
- Verify the health check passes for 30+ seconds before nginx directs traffic
