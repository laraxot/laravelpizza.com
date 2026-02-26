# Determinazione del Logo Basata sul Dominio

## Introduzione
Questo documento descrive il processo per determinare il logo di un'applicazione Laravel in base al dominio specificato nella variabile d'ambiente `APP_URL`. Questo approccio consente di gestire configurazioni specifiche per dominio, rendendo il sistema adattabile a più progetti o ambienti.

## Processo

1. **Estrazione del Dominio da APP_URL**:
   - La variabile `APP_URL` è definita nel file `.env` dell'applicazione Laravel (es. `http://example.local`).
   - Il protocollo (`http://` o `https://`) viene rimosso dalla stringa.
   - La stringa rimanente (`example.local`) viene esplosa usando il separatore `.` per ottenere un array (`['example', 'local']`).
   - L'array viene invertito (`['local', 'example']`) e riunito con `/` come separatore, ottenendo un percorso come `local/example`.

2. **Accesso alla Configurazione Specifica del Dominio**:
   - Il percorso generato (`local/example`) viene utilizzato per accedere alla directory di configurazione specifica del dominio all'interno di `laravel/config/local/`.
   - In questa directory, il file `metatag.php` contiene le configurazioni relative al logo, come:
     - `logo_header`: Percorso del logo per l'intestazione (es. `patient::images/logo.svg`).
     - `logo_header_dark`: Percorso del logo per l'intestazione in modalità dark (es. `patient::images/logo.svg`).

3. **Risoluzione del Percorso del Logo**:
   - I percorsi specificati in `metatag.php` utilizzano un namespace (es. `patient::`), che corrisponde a una directory specifica del modulo.
   - Ad esempio, `patient::images/logo.svg` si traduce in `/var/www/html/base_<nome progetto>/laravel/Modules/Patient/resources/images/logo.svg`.

## Considerazioni
- **Modularità**: Questo approccio permette configurazioni diverse per domini diversi, garantendo adattabilità.
- **Centralizzazione**: Le configurazioni sono centralizzate in file PHP come `metatag.php`, garantendo coerenza.
- **Riutilizzabilità**: L'uso di namespace per i percorsi degli asset consente ai moduli di essere riutilizzabili in più progetti.

## Collegamenti Bidirezionali
- Per ulteriori dettagli sul progetto specifico, consultare la documentazione nella root del progetto: [INDEX.md](../../../docs/INDEX.md).
- Linee guida generali per i loghi: [Linee Guida per i Loghi](../../../docs/standards/logo_guidelines.md).
- Convenzioni sui namespace e Filament: [Convenzioni Namespace Filament](../Cms/docs/convenzioni-namespace-filament.md).
