# Gestione Permessi e Errori Filesystem su File di Lingua (Lang)

> **Backlink:** [Indice e collegamenti root](../../../docs/links.md)

## Problema

Durante operazioni di scrittura su file come `lang_service.php` in `Modules/Lang/lang/it/`, può comparire l'errore:

```
file_put_contents(/var/www/html/ptvx/laravel/Modules/Lang/lang/it/lang_service.php): Failed to open stream: Permission denied
```

## Causa

- Il file o la cartella ha permessi o proprietà non compatibili con l'utente del webserver (`www-data` su sistemi Linux tipici).
- Spesso il file viene creato o modificato da un utente diverso (es. sviluppatore locale), causando mismatch di ownership.

## Soluzione definitiva

1. **Impostare la proprietà corretta:**
   ```bash
   sudo chown www-data:www-data /var/www/html/ptvx/laravel/Modules/Lang/lang/it/lang_service.php
   ```
2. **Impostare permessi sicuri e scrivibili:**
   ```bash
   sudo chmod 664 /var/www/html/ptvx/laravel/Modules/Lang/lang/it/lang_service.php
   ```
   - `664` = scrittura per owner e gruppo, lettura per tutti.

3. **Best practice:**
   - Tutti i file di lingua devono essere di proprietà `www-data:www-data` e con permessi `664`.
   - Se si lavora in team, impostare anche la cartella `lang/it` con:
     ```bash
     sudo chown -R www-data:www-data /var/www/html/ptvx/laravel/Modules/Lang/lang/it
     sudo find /var/www/html/ptvx/laravel/Modules/Lang/lang/it -type f -exec chmod 664 {} \;
     ```
   - Evitare permessi `777` per motivi di sicurezza.

## Motivazione

- Garantisce che sia il webserver che gli sviluppatori possano scrivere senza errori.
- Evita problemi di permission denied in produzione e sviluppo.
- Mantiene la sicurezza del filesystem.

## Esempio pratico

Supponiamo che il file sia stato creato da un utente locale (es. `msottana`). Per correggere:

```bash
sudo chown www-data:www-data /var/www/html/ptvx/laravel/Modules/Lang/lang/it/lang_service.php
sudo chmod 664 /var/www/html/ptvx/laravel/Modules/Lang/lang/it/lang_service.php
```

## Collegamenti
- [Indice e collegamenti root](../../../docs/links.md)
- [Documentazione MCP e gestione errori](../../../docs/mcp_errors_and_lessons.md)

---

**Nota:**
La root `docs/` deve contenere solo il link a questo file, non la guida completa. 