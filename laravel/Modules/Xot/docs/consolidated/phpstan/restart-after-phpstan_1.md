# Guida al Riavvio del Sistema Dopo Validazione PHPStan

## Introduzione

Questo documento fornisce istruzioni dettagliate su come riavviare correttamente il sistema dopo aver eseguito la validazione di tutti i moduli con PHPStan a livello 7. Il riavvio è necessario per garantire che tutte le modifiche apportate durante la correzione degli errori PHPStan vengano applicate correttamente.

## Procedura di Riavvio

### 1. Pulizia delle Cache

Prima di riavviare il sistema, è importante pulire tutte le cache per assicurarsi che le modifiche vengano applicate correttamente:

```bash
# Posizionarsi nella directory principale di Laravel
cd /path/to/laravel

# Pulizia della cache delle configurazioni
php artisan config:clear

# Pulizia della cache delle rotte
php artisan route:clear

# Pulizia della cache delle viste
php artisan view:clear

# Pulizia della cache dell'applicazione
php artisan cache:clear

# Pulizia della cache di Composer
composer dump-autoload
```

### 2. Riavvio dei Servizi Web

```bash
# Riavvio del server web (Apache/Nginx)
sudo systemctl restart apache2
# oppure
sudo systemctl restart nginx

# Riavvio di PHP-FPM (se utilizzato)
sudo systemctl restart php8.1-fpm
```

### 3. Riavvio dei Worker di Queue (se utilizzati)

```bash
# Posizionarsi nella directory principale di Laravel
cd /path/to/laravel

# Arresto dei worker esistenti
php artisan queue:restart

# Riavvio dei worker
php artisan queue:work --daemon
```

### 4. Riavvio di Horizon (se utilizzato)

```bash
# Posizionarsi nella directory principale di Laravel
cd /path/to/laravel

# Riavvio di Laravel Horizon
php artisan horizon:terminate
php artisan horizon
```

### 5. Verifica del Sistema

Dopo il riavvio, è importante verificare che il sistema funzioni correttamente:

1. Controllare i log per eventuali errori:
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. Verificare che tutte le pagine principali dell'applicazione siano accessibili
3. Eseguire test funzionali essenziali per garantire che le funzionalità chiave funzionino correttamente

## Risoluzione dei Problemi Post-Riavvio

### Errori di Autoloading

Se si verificano errori di autoloading dopo il riavvio:

```bash
# Rigenerare l'autoloader di Composer
composer dump-autoload -o

# Se necessario, cancellare la cache di Composer
rm -rf vendor/composer/autoload_*
composer install
```

### Errori di Permessi

Se si verificano errori di permessi dopo il riavvio:

```bash
# Correggere i permessi delle directory di storage e bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### Errori di Configurazione

Se si verificano errori di configurazione dopo il riavvio:

```bash
# Rigenerare la cache delle configurazioni
php artisan config:cache

# Rigenerare la cache delle rotte
php artisan route:cache
```

## Best Practices per il Riavvio

1. **Pianificare il Riavvio**: Scegliere un momento di basso traffico per minimizzare l'impatto sugli utenti
2. **Backup**: Eseguire un backup del database e dei file prima del riavvio
3. **Monitoraggio**: Monitorare attentamente il sistema dopo il riavvio per individuare eventuali problemi
4. **Comunicazione**: Informare gli utenti in anticipo se il riavvio comporterà un'interruzione del servizio

## Conclusione

Un riavvio corretto del sistema dopo la validazione PHPStan è essenziale per garantire che tutte le modifiche vengano applicate correttamente e che il sistema funzioni in modo ottimale. Seguendo questa procedura, è possibile minimizzare i rischi e garantire una transizione fluida.
