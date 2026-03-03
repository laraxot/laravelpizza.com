# Gestione Permessi e Proprietà per File di Lingua (`lang/it/`)

## Problema

Durante la scrittura di file di lingua tramite PHP (es. `file_put_contents(...)`), può comparire l’errore:

```
file_put_contents(/var/www/html/ptvx/laravel/Modules/Lang/lang/it/lang_service.php): Failed to open stream: Permission denied
```

## Causa

Il file o la cartella di destinazione non è scrivibile dall’utente che esegue PHP (tipicamente `www-data`). Spesso accade perché i file sono stati creati o modificati da un utente diverso (es. `msottana`) e hanno permessi troppo restrittivi.

## Soluzione Definitiva

1. **Uniformare la proprietà** di tutti i file e cartelle di `Modules/Lang/lang/it/` a `www-data:www-data`:
   ```bash
   sudo chown -R www-data:www-data /var/www/html/ptvx/laravel/Modules/Lang/lang/it/
   ```
2. **Impostare i permessi corretti**:
   - File: scrivibili da owner e gruppo
     ```bash
     sudo find /var/www/html/ptvx/laravel/Modules/Lang/lang/it/ -type f -exec chmod 664 {} +
     ```
   - Cartelle: navigabili e scrivibili da owner e gruppo
     ```bash
     sudo find /var/www/html/ptvx/laravel/Modules/Lang/lang/it/ -type d -exec chmod 775 {} +
     ```

## Best Practice
- Tutti i file di lingua devono essere di proprietà `www-data` per garantire la scrittura da parte di PHP.
- Evitare di editare questi file come utente diverso da `www-data` oppure ripristinare sempre owner e permessi dopo modifiche manuali.
- Automatizzare questi comandi in fase di deploy o post-modifica massiva.

## Troubleshooting
- Se l’errore persiste, verificare che il filesystem non sia montato in sola lettura o che non ci siano ACL particolari.
- Usare `ls -l` e `stat` per controllare permessi e proprietà.

## Collegamenti
- [Documentazione ufficiale PHP file_put_contents](https://www.php.net/manual/en/function.file-put-contents.php)
- [Documentazione Laraxot gestione permessi](../../../../docs/links.md)

---

_Questa guida è valida per tutti i moduli Laraxot che prevedono scrittura runtime di file di lingua._
