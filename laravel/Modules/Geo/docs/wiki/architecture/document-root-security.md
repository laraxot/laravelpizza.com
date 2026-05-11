# Architettura Web Root: public_html vs laravel/public

## Panoramica

In questo progetto, la directory radice del server web (Document Root) è configurata su `/var/www/_bases/base_fixcity_fila5/public_html`, invece della predefinita di Laravel `laravel/public`. 

Questa scelta non è estetica, ma risponde a precise direttive di **sicurezza**, **conformità** e **manutenibilità**.

---

## Razionale Tecnico

### 1. Isolamento del Codice Sorgente (Security Isolation)
Il cuore dell'applicazione, il framework Laravel, i file di configurazione (`.env`), i log e il codice sorgente risiedono in una directory (`laravel/`) che è **fisicamente al di fuori** della portata del server web. 
- **Vantaggio**: Impedisce l'esposizione accidentale di segreti (chiavi API, password DB) in caso di errori di configurazione del server (es. file `.php` serviti come testo piano).

### 2. Riduzione della Superficie di Attacco (Attack Surface Reduction)
Poiché solo gli asset compilati e l'entry point (`index.php`) sono esposti, un attaccante non può tentare di accedere direttamente a file sensibili come `composer.json`, `package.json` o file di configurazione dei moduli.
- **Vantaggio**: Protezione contro attacchi di tipo *Direct File Inclusion* (DFI) o *Path Traversal* puntati ai file di sistema del framework.

### 3. Allineamento con gli Standard di Produzione (Production Parity)
Molti ambienti di hosting professionale, server Linux gestiti tramite cPanel/Plesk e architetture enterprise utilizzano directory come `public_html`, `www` o `web` come root. 
- **Vantaggio**: Il passaggio dall'ambiente di sviluppo alla produzione è trasparente e non richiede modifiche strutturali ai percorsi degli asset o alla configurazione del server.

### 4. Gestione Centralizzata degli Asset
Gli asset di vari moduli e temi vengono copiati atomicamente in `public_html/assets/`. Questo permette di gestire le versioni e il caching in modo indipendente dal codice PHP, facilitando l'uso di CDN o proxy per le performance.

---

## Regole per gli Agenti AI

1. **Mai** puntare a `laravel/public` per il caricamento di immagini, JS o CSS.
2. **Sempre** utilizzare percorsi relativi o assoluti che puntino a `public_html`.
3. In caso di build Vite/Mix, assicurarsi che l'output (`outDir`) sia configurato correttamente per popolare le sottodirectory di `public_html`.
4. La costante `LARAVEL_DIR` definita in `public_html/index.php` deve essere l'unico punto di contatto tra il mondo pubblico e il cuore dell'app.

---

*Ultimo aggiornamento: Aprile 2026*
