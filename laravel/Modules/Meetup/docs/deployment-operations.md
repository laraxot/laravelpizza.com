# Laravel Pizza Deployment & Operations Guide

## Deployment Overview

The Laravel Pizza project follows modern deployment practices with support for multiple environments, zero-downtime deployments, and automated CI/CD pipelines. This guide covers deployment strategies, server configuration, and operational procedures.

## Server Requirements

### System Requirements
- **Operating System**: Ubuntu 20.04+ LTS or CentOS 8+
- **PHP**: 8.2+ with extensions:
  - `bcmath`, `ctype`, `curl`, `dom`, `fileinfo`, `gd`, `intl`, `json`
  - `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`, `zip`
- **Web Server**: Nginx 1.18+ or Apache 2.4+
- **Database**: MySQL 8.0+ or PostgreSQL 12+
- **Redis**: 6.0+ for caching and queues
- **Node.js**: 18+ for asset compilation

### Recommended Server Specifications
- **Development**: 2 CPU, 4GB RAM, 20GB SSD
- **Staging**: 4 CPU, 8GB RAM, 50GB SSD
- **Production**: 8 CPU, 16GB RAM, 100GB+ SSD (scale as needed)

## Environment Configuration

### Production Environment (.env.production)
```env
APP_NAME=LaravelPizza
APP_ENV=production
APP_KEY=base64:your-production-app-key
APP_DEBUG=false
APP_URL=https://your-domain.com

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravelpizza_prod
DB_USERNAME=laravelpizza_user
DB_PASSWORD=secure_password

BROADCAST_DRIVER=log
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=your_redis_password
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your_mail_username
MAIL_PASSWORD=your_mail_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@your-domain.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=your_aws_access_key
AWS_SECRET_ACCESS_KEY=your_aws_secret_key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your_aws_bucket
AWS_URL=https://your_aws_bucket.s3.amazonaws.com

PUSHER_APP_ID=your_pusher_app_id
PUSHER_APP_KEY=your_pusher_app_key
PUSHER_APP_SECRET=your_pusher_app_secret
PUSHER_APP_CLUSTER=your_pusher_cluster

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

# Performance and Security Settings
FILESYSTEM_DISK=s3
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE_COOKIE=strict

# Queue Worker Settings
QUEUE_FAILED_DRIVER=database
QUEUE_MAX_JOBS=1000
QUEUE_MAX_RUNTIME=60
```

## Deployment Process

### 1. Pre-deployment Checklist
- [ ] Database schema is up-to-date
- [ ] Configuration files are properly set
- [ ] Environment variables are secure
- [ ] SSL certificates are valid
- [ ] Backup strategy is in place
- [ ] Monitoring is configured
- [ ] Health checks are passing

### 2. Deployment Steps

#### Manual Deployment
```bash
# 1. Pull latest code
git pull origin main

# 2. Install/update PHP dependencies
composer install --no-dev --optimize-autoloader --no-interaction

# 3. Install/update Node.js dependencies
npm ci --production

# 4. Run database migrations
php artisan migrate --force

# 5. Clear and cache configuration
php artisan config:clear
php artisan config:cache

# 6. Clear and cache routes
php artisan route:clear
php artisan route:cache

# 7. Clear and cache views
php artisan view:clear
php artisan view:cache

# 8. Build production assets
npm run build

# 9. Restart queue workers
php artisan queue:restart

# 10. Clear any remaining caches
php artisan cache:clear
php artisan event:cache
```

#### Zero-Downtime Deployment Script
```bash
#!/bin/bash
# deploy.sh

set -e

APP_DIR="/var/www/laravel-pizza"
BACKUP_DIR="/var/backups/laravel-pizza"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)

echo "Starting deployment..."

# Create backup
echo "Creating backup..."
mkdir -p $BACKUP_DIR
cp -r $APP_DIR $BACKUP_DIR/backup_$TIMESTAMP

# Maintenance mode
echo "Enabling maintenance mode..."
php $APP_DIR/artisan down || true

# Update code
echo "Updating code..."
cd $APP_DIR
git fetch origin
git reset --hard origin/main

# Update dependencies
echo "Updating PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "Updating Node.js dependencies..."
npm ci --production

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Cache configuration
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Build assets
echo "Building assets..."
npm run build

# Restart queue workers
echo "Restarting queue workers..."
php artisan queue:restart

# Disable maintenance mode
echo "Disabling maintenance mode..."
php artisan up

echo "Deployment completed successfully!"
```

### 3. Automated Deployment (CI/CD)

#### GitHub Actions Example
```yaml
# .github/workflows/deploy.yml
name: Deploy to Production

on:
  push:
    branches: [main]

jobs:
  deploy:
    runs-on: ubuntu-latest
    environment: production
    
    steps:
      - name: Deploy to server
        uses: appleboy/ssh-action@v0.1.5
        with:
          host: ${{ secrets.HOST }}
          username: ${{ secrets.USERNAME }}
          key: ${{ secrets.SSH_KEY }}
          script: |
            cd /var/www/laravel-pizza
            git pull origin main
            composer install --no-dev --optimize-autoloader
            npm ci --production
            npm run build
            php artisan migrate --force
            php artisan config:cache
            php artisan route:cache
            php artisan view:cache
            php artisan queue:restart
            sudo systemctl reload nginx
```

## Server Configuration

### Nginx Configuration
```nginx
# /etc/nginx/sites-available/laravel-pizza
server {
    listen 80;
    server_name your-domain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name your-domain.com;

    # SSL Configuration
    ssl_certificate /path/to/ssl/certificate.crt;
    ssl_certificate_key /path/to/ssl/private.key;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512:ECDHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES256-GCM-SHA384;
    ssl_prefer_server_ciphers off;

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    add_header Content-Security-Policy "default-src 'self' http: https: data: blob: 'unsafe-inline'" always;

    root /var/www/laravel-pizza/public;
    
    index index.php;

    # Main location block
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP-FPM Configuration
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Deny access to hidden files
    location ~ /\. {
        deny all;
    }

    # Cache static assets
    location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    # Logging
    access_log /var/log/nginx/laravel-pizza.access.log;
    error_log /var/log/nginx/laravel-pizza.error.log;
}
```

### PHP-FPM Configuration
```ini
; /etc/php/8.2/fpm/pool.d/laravel-pizza.conf
[laravel-pizza]

user = www-data
group = www-data
listen = /run/php/php8.2-fpm-laravel-pizza.sock

listen.owner = www-data
listen.group = www-data
listen.mode = 0660

pm = dynamic
pm.max_children = 50
pm.start_servers = 5
pm.min_spare_servers = 5
pm.max_spare_servers = 35
pm.max_requests = 500

; Memory and time limits
php_admin_value[memory_limit] = 512M
php_admin_value[max_execution_time] = 300
php_admin_value[upload_max_filesize] = 100M
php_admin_value[post_max_size] = 100M
```

## Database Management

### Migration Strategy
```bash
# Production migration with backup
php artisan migrate --force

# Rollback if needed
php artisan migrate:rollback --step=1 --force

# Fresh database (use with caution in production)
php artisan migrate:fresh --seed --force
```

### Database Backup
```bash
#!/bin/bash
# backup-database.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/backups/database"
DB_NAME="laravelpizza_prod"

mkdir -p $BACKUP_DIR

# MySQL backup
mysqldump -u root -p $DB_NAME > $BACKUP_DIR/$DB_NAME-$DATE.sql

# Compress backup
gzip $BACKUP_DIR/$DB_NAME-$DATE.sql

# Remove backups older than 30 days
find $BACKUP_DIR -name "*.sql.gz" -mtime +30 -delete
```

## Queue Management

### Queue Worker Configuration
```bash
# /etc/systemd/system/laravel-pizza-queue.service
[Unit]
Description=Laravel Pizza Queue Worker
After=redis-server.service

[Service]
Type=simple
User=www-data
Restart=always
RestartSec=3
WorkingDirectory=/var/www/laravel-pizza
ExecStart=/usr/bin/php artisan queue:work --timeout=300 --sleep=3 --tries=3
StandardOutput=append:/var/log/laravel-pizza-queue.log
StandardError=append:/var/log/laravel-pizza-queue-error.log

[Install]
WantedBy=multi-user.target
```

### Queue Worker Management
```bash
# Start queue worker
sudo systemctl start laravel-pizza-queue

# Enable auto-start on boot
sudo systemctl enable laravel-pizza-queue

# Check status
sudo systemctl status laravel-pizza-queue

# View logs
sudo journalctl -u laravel-pizza-queue -f
```

## Caching Strategy

### Cache Configuration
```php
// config/cache.php for production
<?php

return [
    'default' => env('CACHE_DRIVER', 'redis'),
    
    'stores' => [
        'redis' => [
            'driver' => 'redis',
            'connection' => 'cache',
            'lock_connection' => 'default',
        ],
        
        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/data'),
        ],
    ],
];
```

### Cache Optimization
```bash
# Clear all caches
php artisan cache:clear

# Clear specific caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear
```

## Monitoring and Logging

### Log Configuration
```php
// config/logging.php for production
<?php

return [
    'default' => env('LOG_CHANNEL', 'stack'),
    
    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single', 'slack'],
            'ignore_exceptions' => false,
        ],
        
        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'error'),
        ],
        
        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => env('LOG_LEVEL', 'error'),
        ],
    ],
];
```

### Health Checks
```bash
# /var/www/laravel-pizza/health-check.sh
#!/bin/bash

# Check if Laravel is responding
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" http://localhost:8000/health)

if [ $HTTP_CODE -eq 200 ]; then
    echo "Health check: OK"
    exit 0
else
    echo "Health check: FAILED (HTTP $HTTP_CODE)"
    exit 1
fi
```

## Security Measures

### Security Headers Configuration
```php
// app/Http/Middleware/SecurityHeaders.php
<?php

namespace App\Http\Middleware;

use Closure;

class SecurityHeaders
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');
        
        return $response;
    }
}
```

### Rate Limiting
```php
// app/Http/Kernel.php
protected $middlewareGroups = [
    'web' => [
        // ... other middleware
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\SecurityHeaders::class,
    ],
];

protected $middlewarePriority = [
    // ... middleware priority
];
```

## Performance Optimization

### OPcache Configuration
```ini
; /etc/php/8.2/fpm/conf.d/10-opcache.ini
opcache.enable=1
opcache.enable_cli=1
opcache.memory_consumption=512
opcache.interned_strings_buffer=12
opcache.max_accelerated_files=32531
opcache.validate_timestamps=0
opcache.save_comments=1
opcache.fast_shutdown=1
```

### Varnish Configuration (Optional)
```vcl
# /etc/varnish/default.vcl
vcl 4.1;

backend default {
    .host = "127.0.0.1";
    .port = "8000";
}

sub vcl_recv {
    # Don't cache admin and API routes
    if (req.url ~ "^/(admin|api|nova|horizon)/") {
        return (pass);
    }
    
    # Cache static assets
    if (req.url ~ "\.(css|js|png|jpg|jpeg|gif|ico|svg)$") {
        unset req.http.cookie;
        return (hash);
    }
}
```

## Backup and Recovery

### Complete Backup Script
```bash
#!/bin/bash
# complete-backup.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/backups/laravel-pizza/$DATE"
APP_DIR="/var/www/laravel-pizza"

mkdir -p $BACKUP_DIR

# Backup application files
tar -czf $BACKUP_DIR/files.tar.gz -C /var/www laravel-pizza

# Backup database
DB_NAME=$(grep DB_DATABASE $APP_DIR/.env | cut -d'=' -f2)
mysqldump -u root -p $DB_NAME | gzip > $BACKUP_DIR/database.sql.gz

# Backup storage files
tar -czf $BACKUP_DIR/storage.tar.gz -C $APP_DIR storage

# Upload to remote storage (optional)
# aws s3 cp $BACKUP_DIR s3://your-backup-bucket/$DATE --recursive

# Remove old backups (keep last 7 days)
find /var/backups/laravel-pizza -maxdepth 1 -type d -mtime +7 -exec rm -rf {} +
```

## Troubleshooting

### Common Issues and Solutions

#### Application Not Loading
```bash
# Check if services are running
sudo systemctl status nginx
sudo systemctl status php8.2-fpm
sudo systemctl status redis-server

# Check logs
sudo tail -f /var/log/nginx/error.log
sudo tail -f /var/log/php8.2-fpm.log
```

#### Queue Worker Issues
```bash
# Check queue worker status
sudo systemctl status laravel-pizza-queue

# Restart queue worker
sudo systemctl restart laravel-pizza-queue

# Check queue status
php artisan queue:status
```

#### Database Connection Issues
```bash
# Test database connection
php artisan tinker --execute="DB::connection()->getPdo(); echo 'Connection successful';"
```

### Health Check Endpoints
```php
// routes/web.php - Add health check route
Route::get('/health', function () {
    try {
        // Test database connection
        DB::connection()->getPdo();
        
        // Test cache connection
        Cache::get('health_check', 'healthy');
        
        // Test storage
        Storage::disk('local')->put('health-test.txt', 'test');
        Storage::disk('local')->delete('health-test.txt');
        
        return response()->json([
            'status' => 'healthy',
            'timestamp' => now(),
            'services' => [
                'database' => 'ok',
                'cache' => 'ok',
                'storage' => 'ok',
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'unhealthy',
            'error' => $e->getMessage(),
            'timestamp' => now()
        ], 500);
    }
});
```

This deployment and operations guide provides comprehensive instructions for deploying, maintaining, and operating the Laravel Pizza application in production environments while ensuring reliability, security, and performance.