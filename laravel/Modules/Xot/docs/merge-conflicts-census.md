# Censimento File con Marker 

> **Ultimo aggiornamento**: Novembre 2025  
> **Scope**: Repository `/var/www/_bases/base_ptvx_fila4_mono`

## 📊 Riepilogo Attuale
- **Totale file da ripulire**: `103`
- **Macro-aree coinvolte**:
  - `bashscripts/docs/` → 63 file (documentazione storica)
  - `bashscripts/merge_conflicts/` → 9 file (backup datati)
  - `bashscripts/altro` → 5 file (conflicts, git-management, pdf, ecc.)
  - `laravel/Modules/Xot/docs/` → 22 file
  - `laravel/Modules/{UI, Job, Media}` → 3 assets SVG
- **Themes**: nessun file con conflitti rilevato

## 🗂️ Dettaglio per Area

### Bashscripts
- **Documentazione** (`bashscripts/docs/**`): 63 file
  - Roadmap (*.md)
  - Guide conflitti Git (duplicati, versioni parziali)
  - Documentazione storica (italiano/spagnolo)
- **Cartelle aggiuntive**:
  - `merge_conflicts/` backup 20250930 (9 file)
  - `conflicts/README.md`
  - `git-management/README.md`
  - `fix_merge_conflicts_docs.md`
  - `scripts/git/git_subtree_error_resolution.md`
  - `pdf/test_info2.md`

### Moduli Laravel
- **Xot/docs/**: 22 documenti (best practices, testing, prompts, filamenti, namespace, ecc.)
- **UI/docs/**: 1 documento (`conflict-resolution.md`)
- **Job/resources/svg/**: `logo.svg`
- **Media/resources/svg/**: `logo.svg`

## ✅ File Già Bonificati (Novembre 2025)
- `Modules/Notify/docs/README.md`
- `Modules/Notify/docs/index.md`
- `Modules/Sigma/docs/README.md`
- `Modules/Xot/docs/naming-conventions.md`
- `Modules/Xot/docs/code-quality.md`
- `Modules/Xot/docs/architecture/struttura-percorsi.md`

(Questi file sono stati ripuliti e migliorati durante la sessione corrente.)

## 🛠️ Piano d'Azione Prioritizzato

1. **Moduli Core (Xot docs)** – Documentazione di riferimento
   - `filament/README.md`, `filament-best-practices.md`, `testing*.md`, `namespace_conventions.md`
   - Aggiornare contenuti, rimuovere duplicati, uniformare stile

2. **Bashscripts/docs** – Consolidamento documentazione conflitti
   - Identificare versioni finali → creare indice + cartella `archive/`
   - Eliminare duplicati (`git_conflict_resolution_*.md`)

3. **Assets SVG** (Job, Media)
   - Confrontare versioni e mantenere asset ufficiale

4. **Backup Legacy (`merge_conflicts/backup_current_20250930_190004/`)**
   - Valutare se archiviare offline o ripulire e mantenere

## 📋 Processo da Applicare (per ogni file)
1. `touch file.lock`
2. Studiare contenuto e contesto (docs/modulo)
3. Analisi filosofia/zen/politica (perché esiste il file)
4. Risolvere conflitti + migliorare contenuti
5. Aggiornare link interni, rimuovere duplicati
6. Aggiornare documenti indice / changelog moduli
7. `rm file.lock`
8. Registrare avanzamento in questo censimento

## 🔄 Tracciamento Avanzamento
| Stato | Descrizione |
|-------|-------------|
| ✅ | File ripulito e migliorato (elencato sopra) |
| 🟡 | In lavorazione (seguire la check-list) |
| 🔴 | Non ancora analizzato |

Aggiornare questa sezione (o il changelog del modulo) man mano che i file vengono ripuliti.

## 📎 Note Operative
- Dopo ogni gruppo di fix, eseguire `composer dump-autoload` e `php artisan serve`
- Per i documenti, rispettare convenzioni naming (lowercase, niente date nel filename)
- Documentare eventuali decisioni o esclusioni (es. backup da archiviare)
- Mantenere copia “prima/dopo” se i contenuti hanno valore storico

