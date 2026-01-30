# Piano di Riorganizzazione della Documentazione

## Fase 1: Analisi e Categorizzazione

### Documenti da Mantenere nella Root
- `progetto.md` - Documentazione specifica del progetto
- `roadmap.md` - Roadmap del progetto
- `stime.md` - Stime del progetto
- `filosofia.md` - Filosofia del progetto
- `politica.md` - Politiche del progetto
- `zen.md` e `religione.md` - Documenti specifici del progetto

### Documenti da Spostare nel Modulo Xot
- `standard-codice.md` → `laravel/Modules/Xot/docs/standards/coding-standards.md`
- `laravel-conventions.md` → `laravel/Modules/Xot/docs/conventions/laravel.md`
- `naming-conventions.md` → `laravel/Modules/Xot/docs/conventions/naming.md`
- `filament-resources-structure.md` → `laravel/Modules/Xot/docs/filament/resources.md`
- `form_filament_widgets.md` → `laravel/Modules/Xot/docs/filament/widgets.md`
- `git.md` → `laravel/Modules/Xot/docs/development/git.md`
- `risoluzione_conflitti_git.md` → `laravel/Modules/Xot/docs/development/git-conflicts.md`
- `risoluzione_conflitti_merge.md` → `laravel/Modules/Xot/docs/development/merge-conflicts.md`
- `risoluzione_conflitti_merge_update.md` → `laravel/Modules/Xot/docs/development/merge-updates.md`

### Documenti da Spostare nel Modulo Cms
- `blocks-system.md` → `laravel/Modules/Cms/docs/blocks/system.md`
- `blocks.md` → `laravel/Modules/Cms/docs/blocks/index.md`
- `componenti-blocchi-contenuto.md` → `laravel/Modules/Cms/docs/blocks/components.md`
- `components.md` → `laravel/Modules/Cms/docs/components/index.md`
- `content-management.md` → `laravel/Modules/Cms/docs/content/management.md`
- `frontoffice.md` → `laravel/Modules/Cms/docs/frontoffice/index.md`
- `gestione-homepage.md` → `laravel/Modules/Cms/docs/frontoffice/homepage.md`
- `homepage-contenuti.md` → `laravel/Modules/Cms/docs/frontoffice/homepage-content.md`
- `homepage-errori-comuni.md` → `laravel/Modules/Cms/docs/frontoffice/homepage-errors.md`
- `homepage-struttura-corretta.md` → `laravel/Modules/Cms/docs/frontoffice/homepage-structure.md`
- `homepage.md` → `laravel/Modules/Cms/docs/frontoffice/homepage.md`
- `page-content-management.md` → `laravel/Modules/Cms/docs/content/page-management.md`

### Documenti da Spostare nel Modulo UI
- `compilazione_temi.md` → `laravel/Modules/UI/docs/themes/compilation.md`

## Fase 2: Creazione Struttura

1. Creare le cartelle necessarie nei moduli:
   ```
   Xot/docs/
   ├── standards/
   ├── conventions/
   ├── filament/
   └── development/

   Cms/docs/
   ├── blocks/
   ├── components/
   ├── content/
   └── frontoffice/

   UI/docs/
   └── themes/
   ```

2. Creare file README.md in ogni cartella per spiegare il contenuto

## Fase 3: Spostamento File

1. Per ogni file:
   - Copiare il contenuto nella nuova posizione
   - Aggiornare i riferimenti interni
   - Creare un file di reindirizzamento nella vecchia posizione
   - Aggiornare i link in altri documenti

## Fase 4: Verifica e Pulizia

1. Verificare che tutti i link funzionino
2. Rimuovere i file duplicati
3. Aggiornare l'indice della documentazione
4. Verificare la coerenza della documentazione

## Fase 5: Documentazione della Riorganizzazione

1. Aggiornare il file `spostare-documenti.md`
2. Creare un changelog della riorganizzazione
3. Aggiornare i file di link bidirezionali 