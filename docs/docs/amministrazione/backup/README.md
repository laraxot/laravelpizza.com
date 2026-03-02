# Backup il progetto

## Strategia di Backup

### Database
- Backup giornaliero completo
- Backup incrementale ogni 6 ore
- Retention: 30 giorni
- Compressione: gzip
- Verifica integrità

### Files
- Backup settimanale completo
- Backup incrementale giornaliero
- Retention: 30 giorni
- Compressione: tar.gz
- Verifica integrità

## Configurazione

### Spatie Backup
```php
// config/backup.php
return [
    'backup' => [
        'name' => env('APP_NAME', 'saluteora'),
        'source' => [
            'files' => [
                'include' => [
                    base_path(),
                ],
                'exclude' => [
                    base_path('vendor'),
                    base_path('node_modules'),
                ],
            ],
            'databases' => [
                'mysql',
            ],
        ],
        'destination' => [
            'filename_prefix' => 'saluteora-',
            'disks' => [
                'backup',
            ],
        ],
    ],
];
```

### Storage
```php
// config/filesystems.php
'disks' => [
    'backup' => [
        'driver' => 's3',
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION'),
        'bucket' => env('AWS_BACKUP_BUCKET'),
        'url' => env('AWS_URL'),
        'endpoint' => env('AWS_ENDPOINT'),
        'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
    ],
],
```

## Comandi

### Backup Manuale
```bash

# Backup completo
php artisan backup:run

# Backup solo database
php artisan backup:run --only-db

# Backup solo files
php artisan backup:run --only-files

# Backup specifico tenant
php artisan backup:run --tenant=1
```

### Verifica Backup
```bash

# Lista backup
php artisan backup:list

# Verifica backup
php artisan backup:verify

# Ripristino backup
php artisan backup:restore
```

## Automazione

### Cron Jobs
```bash

# Backup giornaliero
0 0 * * * cd /var/www/html/saluteora && php artisan backup:run

# Backup incrementale
0 */6 * * * cd /var/www/html/saluteora && php artisan backup:run --only-db

# Pulizia backup vecchi
0 1 * * * cd /var/www/html/saluteora && php artisan backup:clean
```

### Notifiche
```php
// config/backup-notifications.php
return [
    'notifications' => [
        'mail' => [
            'to' => 'admin@saluteora.it',
        ],
        'slack' => [
            'webhook_url' => env('SLACK_WEBHOOK_URL'),
        ],
    ],
];
```

## Monitoraggio

### Logs
```bash

# Log backup
tail -f storage/logs/backup.log

# Log errori
tail -f storage/logs/backup-error.log
```

### Metriche
```php
// Monitoraggio spazio
$disk = Storage::disk('backup');
$size = $disk->size('backup.tar.gz');

// Monitoraggio frequenza
$lastBackup = Backup::latest()->first();
$frequency = $lastBackup->created_at->diffInHours(now());
```

## Ripristino

### Database
```bash

# Ripristino completo
php artisan backup:restore --path=backup.tar.gz

# Ripristino database
php artisan backup:restore --path=backup.tar.gz --only-db

# Ripristino files
php artisan backup:restore --path=backup.tar.gz --only-files
```

### Verifica Ripristino
```bash

# Verifica database
php artisan db:show

# Verifica files
php artisan storage:link
php artisan view:clear
php artisan cache:clear
```

## Manutenzione

### Pulizia
```bash

# Rimuovi backup vecchi
php artisan backup:clean

# Rimuovi backup specifici
php artisan backup:delete --path=backup.tar.gz
```

### Ottimizzazione
```bash

# Compressi backup
php artisan backup:compress

# Verifica integrità
php artisan backup:verify
```

## Collegamenti tra versioni di README.md
* [README.md](bashscripts/docs/readme.md)
* [README.md](bashscripts/docs/it/readme.md)
* [README.md](docs/laravel-app/phpstan/readme.md)
* [README.md](docs/laravel-app/readme.md)
* [README.md](docs/moduli/struttura/readme.md)
* [README.md](docs/moduli/readme.md)
* [README.md](docs/moduli/manutenzione/readme.md)
* [README.md](docs/moduli/core/readme.md)
* [README.md](docs/moduli/installati/readme.md)
* [README.md](docs/moduli/comandi/readme.md)
* [README.md](docs/phpstan/readme.md)
* [README.md](docs/readme.md)
* [README.md](docs/module-links/readme.md)
* [README.md](docs/troubleshooting/git-conflicts/readme.md)
* [README.md](docs/tecnico/laraxot/readme.md)
* [README.md](docs/modules/readme.md)
* [README.md](docs/conventions/readme.md)
* [README.md](docs/amministrazione/backup/readme.md)
* [README.md](docs/amministrazione/monitoraggio/readme.md)
* [README.md](docs/amministrazione/deployment/readme.md)
* [README.md](docs/translations/readme.md)
* [README.md](docs/roadmap/readme.md)
* [README.md](docs/ide/cursor/readme.md)
* [README.md](docs/implementazione/api/readme.md)
* [README.md](docs/implementazione/testing/readme.md)
* [README.md](docs/implementazione/pazienti/readme.md)
* [README.md](docs/implementazione/ui/readme.md)
* [README.md](docs/implementazione/dental/readme.md)
* [README.md](docs/implementazione/core/readme.md)
* [README.md](docs/implementazione/reporting/readme.md)
* [README.md](docs/implementazione/isee/readme.md)
* [README.md](docs/it/readme.md)
* [README.md](laravel/vendor/mockery/mockery/docs/readme.md)
* [README.md](laravel/modules/chart/docs/readme.md)
* [README.md](laravel/modules/reporting/docs/readme.md)
* [README.md](laravel/modules/gdpr/docs/phpstan/readme.md)
* [README.md](laravel/modules/gdpr/docs/readme.md)
* [README.md](laravel/modules/notify/docs/phpstan/readme.md)
* [README.md](laravel/modules/notify/docs/readme.md)
* [README.md](laravel/modules/xot/docs/filament/readme.md)
* [README.md](laravel/modules/xot/docs/phpstan/readme.md)
* [README.md](laravel/modules/xot/docs/exceptions/readme.md)
* [README.md](laravel/modules/xot/docs/readme.md)
* [README.md](laravel/modules/xot/docs/standards/readme.md)
* [README.md](laravel/modules/xot/docs/conventions/readme.md)
* [README.md](laravel/modules/xot/docs/development/readme.md)
* [README.md](laravel/modules/dental/docs/readme.md)
* [README.md](laravel/modules/user/docs/phpstan/readme.md)
* [README.md](laravel/modules/user/docs/readme.md)
* [README.md](laravel/modules/user/resources/views/docs/readme.md)
* [README.md](laravel/modules/ui/docs/phpstan/readme.md)
* [README.md](laravel/modules/ui/docs/readme.md)
* [README.md](laravel/modules/ui/docs/standards/readme.md)
* [README.md](laravel/modules/ui/docs/themes/readme.md)
* [README.md](laravel/modules/ui/docs/components/readme.md)
* [README.md](laravel/modules/lang/docs/phpstan/readme.md)
* [README.md](laravel/modules/lang/docs/readme.md)
* [README.md](laravel/modules/job/docs/phpstan/readme.md)
* [README.md](laravel/modules/job/docs/readme.md)
* [README.md](laravel/modules/media/docs/phpstan/readme.md)
* [README.md](laravel/modules/media/docs/readme.md)
* [README.md](laravel/modules/tenant/docs/phpstan/readme.md)
* [README.md](laravel/modules/tenant/docs/readme.md)
* [README.md](laravel/modules/activity/docs/phpstan/readme.md)
* [README.md](laravel/modules/activity/docs/readme.md)
* [README.md](laravel/modules/patient/docs/readme.md)
* [README.md](laravel/modules/patient/docs/standards/readme.md)
* [README.md](laravel/modules/patient/docs/value-objects/readme.md)
* [README.md](laravel/modules/cms/docs/blocks/readme.md)
* [README.md](laravel/modules/cms/docs/readme.md)
* [README.md](laravel/modules/cms/docs/standards/readme.md)
* [README.md](laravel/modules/cms/docs/content/readme.md)
* [README.md](laravel/modules/cms/docs/frontoffice/readme.md)
* [README.md](laravel/modules/cms/docs/components/readme.md)
* [README.md](laravel/themes/two/docs/readme.md)
* [README.md](laravel/themes/one/docs/readme.md)
