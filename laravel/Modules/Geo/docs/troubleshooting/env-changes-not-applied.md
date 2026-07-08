# .env Changes Not Applied - Troubleshooting

**Issue**: Modified .env but changes not reflected  
**Common In**: Laravel applications  
**Priority**: 🔴 CRITICAL when happens

---

## 🚨 The Problem

After changing values in `.env` file (like `DB_HOST`, `DB_PASSWORD`, etc.), the application continues using old values.

---

## ✅ Solutions (In Order)

### Solution 1: Clear Laravel Caches (ALWAYS DO THIS FIRST)

```bash
cd /var/www/_bases/base_ptvx_fila5_mono/laravel

# Clear all caches
php artisan config:clear    # Configuration cache
php artisan cache:clear     # Application cache
php artisan view:clear      # Compiled views
php artisan route:clear     # Route cache

# Verify new config is loaded
php artisan tinker --execute="echo config('database.connections.mysql.host');"
```

**When to use**: ALWAYS when you change .env

---

### Solution 2: Reset PHP OPcache

```bash
# Reset OPcache
php -r "if(function_exists('opcache_reset')){opcache_reset(); echo 'OPcache reset\n';}"

# Or via web (create file in public/)
# opcache_reset.php
<?php
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "OPcache reset!";
}
```

**When to use**: If Solution 1 doesn't work

---

### Solution 3: Restart PHP-FPM

```bash
# Ubuntu/Debian
sudo systemctl restart php8.3-fpm
# or
sudo service php8.3-fpm restart

# Check status
sudo systemctl status php8.3-fpm
```

**When to use**: If Solutions 1-2 don't work

---

### Solution 4: Restart Queue Workers

```bash
cd /var/www/_bases/base_ptvx_fila5_mono/laravel

# Restart queue workers
php artisan queue:restart

# If using Horizon
php artisan horizon:terminate

# Check workers are restarted
php artisan queue:work --once  # Test one job
```

**When to use**: If you have queue workers running

---

### Solution 5: Restart Web Server (Last Resort)

```bash
# Nginx
sudo systemctl restart nginx

# Apache
sudo systemctl restart apache2

# Check
sudo systemctl status nginx  # or apache2
```

**When to use**: If all above fail

---

## 🔍 Verification Steps

### Step 1: Check .env File

```bash
# View DB_HOST in .env
grep "DB_HOST" /var/www/_bases/base_ptvx_fila5_mono/laravel/.env

# Expected: Your new value
```

### Step 2: Check Laravel Config

```bash
# Check what Laravel is using
php artisan tinker --execute="
echo 'DB_HOST: ' . config('database.connections.mysql.host') . PHP_EOL;
echo 'DB_DATABASE: ' . config('database.connections.mysql.database') . PHP_EOL;
"
```

### Step 3: Test Database Connection

```bash
# Try to connect
php artisan tinker --execute="
try {
    DB::connection()->getPdo();
    echo '✅ Database connection successful!' . PHP_EOL;
    echo 'Connected to: ' . DB::connection()->getDatabaseName() . PHP_EOL;
} catch (\Exception \$e) {
    echo '❌ Database connection failed: ' . \$e->getMessage() . PHP_EOL;
}
"
```

---

## 🔧 Complete Cleanup Script

Create this script for quick cleanup:

```bash
# /var/www/_bases/base_ptvx_fila5_mono/bashscripts/maintenance/cleanup/clear_all_caches.sh

#!/bin/bash

echo "🔄 Clearing all Laravel caches..."

cd /var/www/_bases/base_ptvx_fila5_mono/laravel

# Clear Laravel caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan event:clear

# Reset OPcache
php -r "if(function_exists('opcache_reset')){opcache_reset();echo '✅ OPcache reset\n';}"

# Restart queue workers
php artisan queue:restart

echo "✅ All caches cleared!"
echo "📝 Remember to restart PHP-FPM if needed: sudo systemctl restart php8.3-fpm"
```

**Usage**:
```bash
bash /var/www/_bases/base_ptvx_fila5_mono/bashscripts/maintenance/cleanup/clear_all_caches.sh
```

---

## ⚠️ Common Mistakes

### Mistake 1: Edited Wrong .env

```bash
# Check you edited the correct file
ls -la /var/www/_bases/base_ptvx_fila5_mono/laravel/.env

# Not .env.example!
# Not in a different directory!
```

### Mistake 2: Syntax Error in .env

```bash
# ❌ WRONG - Spaces around =
DB_HOST = 10.100.200.53

# ✅ CORRECT - No spaces
DB_HOST=10.100.200.53

# ❌ WRONG - Quotes when not needed
DB_HOST="10.100.200.53"

# ✅ CORRECT - No quotes for simple values
DB_HOST=10.100.200.53
```

### Mistake 3: Forgot to Clear Cache

After ANY .env change:
```bash
php artisan config:clear  # ALWAYS!
```

### Mistake 4: Queue Workers Not Restarted

If you have workers, restart them:
```bash
php artisan queue:restart  # REQUIRED if using queues
```

---

## 📋 Quick Checklist

When you change .env:

- [ ] Saved .env file
- [ ] Ran `php artisan config:clear`
- [ ] Ran `php artisan cache:clear`
- [ ] Verified new config: `php artisan tinker --execute="config('your.key')"`
- [ ] Tested database connection
- [ ] Restarted queue workers (if applicable)
- [ ] Restarted PHP-FPM (if still not working)
- [ ] Restarted web server (last resort)

---

## 🔗 Related

- [Configuration Caching](https://laravel.com/docs/11.x/configuration#configuration-caching)
- [Environment Configuration](https://laravel.com/docs/11.x/configuration#environment-configuration)

---

**Priority**: 🔴 CRITICAL when it happens  
**Solution Time**: 1-5 minutes  
**Most Common**: Forgotten `config:clear`


