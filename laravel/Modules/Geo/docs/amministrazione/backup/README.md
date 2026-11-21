---
title: "README"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "README"
issues: []
discussions: []
---

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
* [README.md](bashscripts/docs/README.md)
* [README.md](bashscripts/docs/it/README.md)
* [README.md](docs/laravel-app/phpstan/README.md)
* [README.md](docs/laravel-app/README.md)
* [README.md](docs/moduli/struttura/README.md)
* [README.md](docs/moduli/README.md)
* [README.md](docs/moduli/manutenzione/README.md)
* [README.md](docs/moduli/core/README.md)
* [README.md](docs/moduli/installati/README.md)
* [README.md](docs/moduli/comandi/README.md)
* [README.md](docs/phpstan/README.md)
* [README.md](docs/README.md)
* [README.md](docs/module-links/README.md)
* [README.md](docs/troubleshooting/git-conflicts/README.md)
* [README.md](docs/tecnico/laraxot/README.md)
* [README.md](docs/modules/README.md)
* [README.md](docs/conventions/README.md)
* [README.md](docs/amministrazione/backup/README.md)
* [README.md](docs/amministrazione/monitoraggio/README.md)
* [README.md](docs/amministrazione/deployment/README.md)
* [README.md](docs/translations/README.md)
* [README.md](docs/roadmap/README.md)
* [README.md](docs/ide/cursor/README.md)
* [README.md](docs/implementazione/api/README.md)
* [README.md](docs/implementazione/testing/README.md)
* [README.md](docs/implementazione/pazienti/README.md)
* [README.md](docs/implementazione/ui/README.md)
* [README.md](docs/implementazione/dental/README.md)
* [README.md](docs/implementazione/core/README.md)
* [README.md](docs/implementazione/reporting/README.md)
* [README.md](docs/implementazione/isee/README.md)
* [README.md](docs/it/README.md)
* [README.md](laravel/vendor/mockery/mockery/docs/README.md)
* [README.md](laravel/modules/chart/docs/README.md)
* [README.md](laravel/modules/reporting/docs/README.md)
* [README.md](laravel/modules/gdpr/docs/phpstan/README.md)
* [README.md](laravel/modules/gdpr/docs/README.md)
* [README.md](laravel/modules/notify/docs/phpstan/README.md)
* [README.md](laravel/modules/notify/docs/README.md)
* [README.md](laravel/modules/xot/docs/filament/README.md)
* [README.md](laravel/modules/xot/docs/phpstan/README.md)
* [README.md](laravel/modules/xot/docs/exceptions/README.md)
* [README.md](laravel/modules/xot/docs/README.md)
* [README.md](laravel/modules/xot/docs/standards/README.md)
* [README.md](laravel/modules/xot/docs/conventions/README.md)
* [README.md](laravel/modules/xot/docs/development/README.md)
* [README.md](laravel/modules/dental/docs/README.md)
* [README.md](laravel/modules/user/docs/phpstan/README.md)
* [README.md](laravel/modules/user/docs/README.md)
* [README.md](laravel/modules/user/resources/views/docs/README.md)
* [README.md](laravel/modules/ui/docs/phpstan/README.md)
* [README.md](laravel/modules/ui/docs/README.md)
* [README.md](laravel/modules/ui/docs/standards/README.md)
* [README.md](laravel/modules/ui/docs/themes/README.md)
* [README.md](laravel/modules/ui/docs/components/README.md)
* [README.md](laravel/modules/lang/docs/phpstan/README.md)
* [README.md](laravel/modules/lang/docs/README.md)
* [README.md](laravel/modules/job/docs/phpstan/README.md)
* [README.md](laravel/modules/job/docs/README.md)
* [README.md](laravel/modules/media/docs/phpstan/README.md)
* [README.md](laravel/modules/media/docs/README.md)
* [README.md](laravel/modules/tenant/docs/phpstan/README.md)
* [README.md](laravel/modules/tenant/docs/README.md)
* [README.md](laravel/modules/activity/docs/phpstan/README.md)
* [README.md](laravel/modules/activity/docs/README.md)
* [README.md](laravel/modules/patient/docs/README.md)
* [README.md](laravel/modules/patient/docs/standards/README.md)
* [README.md](laravel/modules/patient/docs/value-objects/README.md)
* [README.md](laravel/modules/cms/docs/blocks/README.md)
* [README.md](laravel/modules/cms/docs/README.md)
* [README.md](laravel/modules/cms/docs/standards/README.md)
* [README.md](laravel/modules/cms/docs/content/README.md)
* [README.md](laravel/modules/cms/docs/frontoffice/README.md)
* [README.md](laravel/modules/cms/docs/components/README.md)
* [README.md](laravel/themes/two/docs/README.md)
* [README.md](laravel/themes/one/docs/README.md)
