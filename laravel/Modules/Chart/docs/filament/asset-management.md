# Gestione Asset Filament

## Panoramica
Filament richiede la pubblicazione di asset specifici per il suo funzionamento. Questa guida spiega come gestirli correttamente.

## Comandi Essenziali

### 1. Pubblicazione Asset
```bash

# Pubblicazione standard
php artisan filament:assets

# Pubblicazione forzata
php artisan filament:assets --force
```

### 2. Asset Specifici
```bash

# Forms
php artisan filament:assets --type=forms

# Tables
php artisan filament:assets --type=tables

# Widgets
php artisan filament:assets --type=widgets
```

## Struttura degli Asset

### Directory
```
public_html/
├── css/
│   └── filament/
│       ├── forms/
│       ├── tables/
│       └── widgets/
└── js/
    └── filament/
        ├── forms/
        ├── tables/
        └── widgets/
```

### Asset Principali
1. **Forms**
   - Rich Editor
   - Date Picker
   - File Upload
   - Select
   - etc.

2. **Tables**
   - Data Tables
   - Filters
   - Actions
   - etc.

3. **Widgets**
   - Charts
   - Stats
   - etc.

## Errori Comuni e Soluzioni

### 1. Asset non Caricati
```bash

# Verifica presenza
ls -la public_html/css/filament
ls -la public_html/js/filament

# Ripubblicazione
php artisan filament:assets --force
```

### 2. Timeout durante Pubblicazione
```bash

# Aumenta timeout PHP
php -d max_execution_time=300 artisan filament:assets

# Pubblica per tipo
php artisan filament:assets --type=forms
php artisan filament:assets --type=tables
php artisan filament:assets --type=widgets
```

### 3. Conflitti di Versione
```bash

# Pulizia cache
php artisan cache:clear
php artisan view:clear

# Ripubblicazione
composer update filament/filament
php artisan filament:assets
```

## Best Practices

### 1. Gestione Dipendenze
```json
// composer.json
{
    "scripts": {
        "post-update-cmd": [
            "@php artisan filament:assets"
        ]
    }
}
```

### 2. Versionamento
```php
// config/filament.php
'asset_version' => '1.0.0',

// In blade
@filamentScripts
@filamentStyles
```

### 3. Cache
```bash

# Dopo pubblicazione
php artisan optimize
php artisan view:cache
```

## Troubleshooting

### Checklist
1. Asset pubblicati?
   ```bash
   ls -la public_html/css/filament
   ls -la public_html/js/filament
   ```

2. Versioni corrette?
   ```bash
   composer show filament/filament
   ```

3. Cache pulita?
   ```bash
   php artisan cache:clear
   php artisan view:clear
   ```

### Risoluzione Problemi
1. Se gli asset non vengono caricati:
   - Verificare presenza in public_html
   - Controllare permessi file
   - Verificare versioni pacchetti

2. Se la pubblicazione fallisce:
   - Aumentare timeout PHP
   - Pubblicare per tipo
   - Verificare spazio disco

## Manutenzione

### Aggiornamenti
```bash

# 1. Backup
cp -r public_html/css/filament public_html/css/filament_backup
cp -r public_html/js/filament public_html/js/filament_backup

# 2. Aggiornamento
composer update filament/filament

# 3. Ripubblicazione
php artisan filament:assets
```

### Pulizia
```bash

# Rimozione vecchi asset
rm -rf public_html/css/filament_old
rm -rf public_html/js/filament_old

# Pulizia cache
php artisan cache:clear
php artisan view:clear
```

## Note Importanti
- Mantenere aggiornato Filament
- Verificare compatibilità asset
- Backup prima degli aggiornamenti
- Testare dopo pubblicazione
