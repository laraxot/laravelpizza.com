# Gestione Timeout Comandi Artisan

## Problema
Quando un comando artisan supera il timeout predefinito (1800 secondi / 30 minuti), l'esecuzione viene interrotta.

## Soluzioni

1. **Aumentare il Timeout**
   ```bash
   # Impostare timeout più lungo (es. 1 ora)
   COMPOSER_PROCESS_TIMEOUT=3600 php artisan vendor:publish

   # Disabilitare il timeout
   COMPOSER_PROCESS_TIMEOUT=0 php artisan vendor:publish
   ```

2. **Eseguire in Background**
   ```bash
   nohup php artisan vendor:publish > vendor-publish.log 2>&1 &
   ```

3. **Pubblicare Asset Specifici**
   ```bash
   # Pubblicare solo gli asset necessari
   php artisan vendor:publish --provider="VendorName\PackageName\ServiceProvider"
   php artisan vendor:publish --tag="package-assets"
   ```

4. **Pubblicare in Batch**
   ```bash
   # Creare uno script per pubblicare in batch
   #!/bin/bash
   for tag in laravel-assets filament-assets spatie-assets
   do
       php artisan vendor:publish --tag=$tag --force
       echo "Published $tag"
       sleep 2
   done
   ```

## Best Practices

1. **Verifica Preliminare**
   ```bash
   # Lista dei file da pubblicare
   php artisan vendor:publish --list
   ```

2. **Backup**
   ```bash
   # Backup dei file esistenti
   tar -czf public/vendor-backup.tar.gz public/vendor
   ```

3. **Monitoraggio**
   ```bash
   # Monitorare il processo
   tail -f vendor-publish.log
   ```

4. **Pulizia Cache**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   ```

## Prevenzione

1. **Ottimizzazione Assets**
   - Minimizzare dimensione dei file
   - Utilizzare lazy loading
   - Implementare caching efficiente

2. **Configurazione Server**
   ```ini
   # php.ini
   max_execution_time = 3600
   memory_limit = 512M
   ```

3. **Gestione Queue**
   ```php
   // Utilizzare code per operazioni lunghe
   php artisan queue:work --timeout=3600
   ```

## Troubleshooting

1. **Errore di Memoria**
   ```bash
   # Aumentare memoria PHP
   php -d memory_limit=-1 artisan vendor:publish
   ```

2. **Errore di Permessi**
   ```bash
   # Verificare e correggere permessi
   chmod -R 775 public/vendor
   chown -R www-data:www-data public/vendor
   ```

3. **Lock File**
   ```bash
   # Rimuovere file di lock se necessario
   rm storage/framework/maintenance.php
   ```

## Comandi Utili

1. **Verifica Stato**
   ```bash
   # Controllare processi PHP attivi
   ps aux | grep artisan
   ```

2. **Kill Processo**
   ```bash
   # Terminare processo bloccato
   kill -9 $(pgrep -f "artisan vendor:publish")
   ```

3. **Log Dettagliato**
   ```bash
   # Abilitare log verbose
   php artisan vendor:publish -vvv
   ```

## Documentazione Correlata

- [Laravel Asset Publishing](https://laravel.com/docs/10.x/packages#publishing-file-groups)
- [Composer Process Timeout](https://getcomposer.org/doc/06-config.md#process-timeout)
- [PHP Configuration](https://www.php.net/manual/en/info.configuration.php) 