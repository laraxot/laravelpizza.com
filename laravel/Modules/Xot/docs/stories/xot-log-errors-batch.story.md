# Story: lotto errori `laravel.log` del 2026-11-10 (batch 2)

**Modulo owner:** Xot (tooling e log; nessuna modifica di codice di Mobile)
**Stato:** done per le voci risolte; aperto per le voci DB (decisione utente)
**Supersede:** nulla. Non collegata da altre story.

## Voci del log e causa

1. `Unable to locate a class or view for component [mobile::layout]` (10:46, 10:47).
   `php artisan view:cache` compilava le view di `Modules/Mobile`, che usa `<x-mobile::layout>`.
   Il modulo Mobile non è abilitato (assente da `modules_statuses.json`), quindi il namespace
   `mobile` non viene registrato. Verifica: `php artisan view:cache` ora passa senza errori.
2. `Failed to decode package-lock.json` (10:46, WARNING). Il file `laravel/package-lock.json`
   era JSON non valido, e la versione in HEAD era già rotta. Corrotto in più punti:
   - blocchi di `node_modules/axios` 1.11.0 e `@esbuild/aix-ppc64` 0.25.9 troncati e seguiti
     da una seconda entry dello stesso pacchetto;
   - `devDependencies` della radice duplicato con un frammento troncato;
   - `node_modules/vite` 7.1.5 troncato prima del corpo 7.3.5;
   - `node_modules/postcss` 8.5.6 troncato prima di 8.5.15;
   - `node_modules/picomatch` con due corpi incollati (4.0.3 e 4.0.4).
   Fix: rimossi solo i frammenti troncati, tenute le entry complete coerenti con `package.json`
   (`axios ^1.17.0`, `vite ^7.0.4`). Backup pre-fix nello scratchpad di sessione
   (`package-lock.before-fix.json`).
   Verifica: JSON valido, nessuna chiave duplicata, `json_decode` PHP (lo stesso usato da
   `laravel/roster`) decodifica il file.
   Aperto: `package.json` dichiara `autoprefixer` in devDependencies, la radice del lock no.
   Va risolto con `npm install --package-lock-only`: non eseguito, da confermare.
3. `Command "module:status" is not defined` (10:47, 10:50). Il comando non esiste nella
   versione di nwidart in uso: è `module:list`, che mostra già Enabled/Disabled. Riferimenti
   corretti in `Modules/Notify/docs/console/commands.md` e `Modules/Activity/docs/bmad/README.md`.
4. `SQLSTATE[HY000] [1045] Access denied for user ''@'localhost'` (connessione `user`, 10:50).
   **Aperto, non toccato:** `DB_DATABASE_USER` non è configurato e la connessione `user` è
   commentata in `config/local/restaurant/database.php`. Serve una decisione dell'utente su
   `.env`/config DB, che l'agente non modifica.

## Rimozione dal log

Rimosse da `storage/logs/laravel.log` solo le voci 1–3 (5 blocchi). Restano le 4 voci SQLSTATE.

## Verifica

- `php artisan module:list`: 16 righe con stato, comando funzionante.
- `php artisan view:cache`: successo.
- `grep module:status` in Modules/docs: resta solo il commento esplicativo di Activity.
