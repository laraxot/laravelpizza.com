# Troubleshooting Pubblicazione Asset

## Problemi Comuni

### 1. Timeout durante Pubblicazione
```
The process exceeded the timeout of 1800 seconds.
```

#### Soluzioni
1. **Pubblicazione Mirata**
   ```bash
   # Invece di
   php artisan vendor:publish --tag=laravel-assets
   
   # Usare
   php artisan filament:assets
   php artisan vendor:publish --tag=module-specific-assets
   ```

2. **Aumentare Timeout**
   ```bash
   # In composer.json
   {
       "config": {
           "process-timeout": 3600
       }
   }
   ```

3. **Pubblicazione per Parti**
   ```bash
   # Forms
   php artisan filament:assets --type=forms
   
   # Tables
   php artisan filament:assets --type=tables
   ```

### 2. Asset non Trovati
```
Unable to locate publishable assets.
```

#### Soluzioni
1. **Verifica Percorsi**
   ```bash
   ls -la public_html/vendor
   ls -la public_html/css/filament
   ```

2. **Pulizia Cache**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   ```

3. **Ripubblicazione Forzata**
   ```bash
   php artisan filament:assets --force
   ```

### 3. Permessi Errati
```
Permission denied
```

#### Soluzioni
1. **Correzione Permessi**
   ```bash
   sudo chown -R www-data:www-data public_html/vendor
   sudo chmod -R 775 public_html/vendor
   ```

2. **Verifica Proprietario**
   ```bash
   ls -la public_html/vendor
   ls -la public_html/css/filament
   ```

## Processo di Debug

### 1. Analisi Iniziale
```bash

# Verifica stato attuale
ls -la public_html/vendor
ls -la public_html/css/filament

# Verifica permessi
stat public_html/vendor
stat public_html/css/filament
```

### 2. Pulizia Sistema
```bash

# Cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Asset vecchi
rm -rf public_html/vendor/*
rm -rf public_html/css/filament/*
```

### 3. Ripubblicazione
```bash

# Filament
php artisan filament:assets

# Altri asset
php artisan vendor:publish --tag=module-assets

# Ottimizzazione
php artisan optimize
```

## Prevenzione

### 1. Monitoraggio
```bash

# Spazio disco
df -h

# Permessi
ls -la public_html/vendor
ls -la public_html/css/filament
```

### 2. Backup
```bash

# Prima degli aggiornamenti
cp -r public_html/vendor public_html/vendor_backup
cp -r public_html/css/filament public_html/css/filament_backup
```

### 3. Documentazione
- Mantenere un registro degli asset pubblicati
- Documentare i tag utilizzati
- Tracciare le personalizzazioni

## Checklist Risoluzione

### Prima della Pubblicazione
- [ ] Spazio disco sufficiente
- [ ] Permessi corretti
- [ ] Cache pulita
- [ ] Backup effettuato

### Durante la Pubblicazione
- [ ] Monitorare output comando
- [ ] Verificare timeout
- [ ] Controllare errori

### Dopo la Pubblicazione
- [ ] Verificare file pubblicati
- [ ] Testare funzionalità
- [ ] Aggiornare documentazione

## Note Importanti
- Sempre fare backup prima della pubblicazione
- Pubblicare un pacchetto alla volta
- Verificare dopo ogni pubblicazione
- Documentare le modifiche
