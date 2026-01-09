# Piano Consolidamento Documentazione - Modulo UI

## Obiettivo

Consolidare la documentazione rimuovendo duplicati e file obsoleti, mantenendo una sola fonte di verità per ogni argomento.

## Regole di Consolidamento

1. **Convenzione naming**: Usare sempre trattini (`-`) invece di underscore (`_`)
2. **Nomi file**: Maiuscole solo per `README.md`, tutto il resto minuscolo
3. **Date nei nomi**: Rimuovere date dai nomi file (spostare in archive se necessario)
4. **Versione da mantenere**: Mantenere sempre la versione più completa e aggiornata

## File Duplicati da Consolidare

### 1. Advanced Form Components
- ❌ `advanced_form_components.md` → Eliminare
- ✅ `advanced-form-components.md` → Mantenere

### 2. Blade Components
- ❌ `blade_data_handling.md` → Eliminare
- ✅ `blade-data-handling.md` → Mantenere
- ✅ `blade-components.md` → Mantenere
- ✅ `blade-icons.md` → Mantenere

### 3. Filament Components
- ❌ `filament_4x_upgrade.md` → Eliminare
- ❌ `filament_4x_upgrade_report.md` → Eliminare
- ✅ `filament-4x-upgrade.md` → Mantenere
- ✅ `filament-4x-upgrade-report.md` → Mantenere

- ❌ `filament_blade_components_usage.md` → Eliminare
- ✅ `filament-blade-components-usage.md` → Mantenere

- ❌ `filament_components.md` → Eliminare
- ❌ `filament_components_errors.md` → Eliminare
- ❌ `filament_components_location_studio.md` → Eliminare
- ❌ `filament_components_usage.md` → Eliminare
- ✅ `filament-components.md` → Mantenere
- ✅ `filament-components-errors.md` → Mantenere
- ✅ `filament-components-location-studio.md` → Mantenere
- ✅ `filament-components-usage.md` → Mantenere

- ❌ `filament_fileupload.md` → Eliminare
- ❌ `filament_fileupload_components.md` → Eliminare
- ✅ `filament-fileupload.md` → Mantenere
- ✅ `filament-fileupload-components.md` → Mantenere

### 4. Conflict Resolution
- ❌ `conflict_resolution_iconstatecolumn.md` → Eliminare
- ❌ `conflict_resolution_locationselector.md` → Eliminare
- ❌ `conflict_resolution_tablelayoutenum.md` → Eliminare
- ❌ `conflict_resolution_translation_files.md` → Eliminare
- ✅ `conflict-resolution-iconstatecolumn.md` → Mantenere
- ✅ `conflict-resolution-locationselector.md` → Mantenere
- ✅ `conflict-resolution-tablelayoutenum.md` → Mantenere
- ✅ `conflict-resolution-translation-files.md` → Mantenere

### 5. Naming Conventions
- ❌ `convenzioni_naming_campi.md` → Eliminare
- ❌ `naming_conventions.md` → Eliminare
- ❌ `naming_rules.md` → Eliminare
- ✅ `convenzioni-naming-campi.md` → Mantenere
- ✅ `naming-conventions.md` → Mantenere
- ✅ `naming-rules.md` → Mantenere
- ✅ `file-naming-rules.md` → Mantenere

### 6. PHPStan Documentation
- ❌ `phpstan_fixes_2025.md` → Eliminare (duplicato)
- ❌ `phpstan_fixes_gennaio_2025.md` → Eliminare (duplicato)
- ❌ `phpstan_corrections_summary.md` → Eliminare (duplicato)
- ❌ `phpstan_radio_badge_fix.md` → Eliminare (duplicato)
- ✅ `phpstan-compliance.md` → Mantenere (documento principale)
- ✅ `phpstan-fixes-2025.md` → Mantenere (se contiene info aggiuntive)
- ✅ `phpstan-corrections-summary.md` → Mantenere
- ✅ `phpstan-corrections.md` → Mantenere
- ✅ `phpstan-fixes.md` → Mantenere
- ✅ `phpstan-fixes-summary.md` → Mantenere

**Nota**: File con date nei nomi (`phpstan-level-10-cleanup-2025-11-06.md`, `dry-kiss-analysis-2025-10-15.md`) dovrebbero essere spostati in `archive/` o consolidati.

### 7. VSCode Documentation
- ❌ `vscode_filament_extension.md` → Eliminare
- ❌ `vscode_filament_plugin.md` → Eliminare
- ✅ `vscode-filament-extension.md` → Mantenere
- ✅ `vscode-filament-plugin.md` → Mantenere
- ✅ `vscode-php-setup.md` → Mantenere

### 8. Altri Duplicati
- ❌ `algolia_docsearch.md` → Eliminare
- ✅ `algolia-docsearch.md` → Mantenere

- ❌ `architecture_rules.md` → Eliminare
- ✅ `architecture-rules.md` → Mantenere

- ❌ `auth_pages.md` → Eliminare
- ✅ `auth-pages.md` → Mantenere

- ❌ `base_components.md` → Eliminare
- ✅ `base-components.md` → Mantenere

- ❌ `best_practices.md` → Eliminare
- ✅ `best-practices.md` → Mantenere

- ❌ `blocks_system.md` → Eliminare
- ✅ `blocks-system.md` → Mantenere
- ✅ `blocks.md` → Mantenere

- ❌ `chart_components.md` → Eliminare
- ✅ `chart-components.md` → Mantenere

- ❌ `components_guide.md` → Eliminare
- ✅ `components-guide.md` → Mantenere
- ✅ `components.md` → Mantenere

- ❌ `cms_link.md` → Eliminare
- ❌ `cms_themes_link.md` → Eliminare
- ✅ `cms-link.md` → Mantenere
- ✅ `cms-themes-link.md` → Mantenere

## File con Date nei Nomi (da Spostare in Archive)

1. `dry-kiss-analysis-2025-10-15.md` → `archive/dry-kiss-analysis.md`
2. `phpstan-level-10-cleanup-2025-11-06.md` → `archive/phpstan-level-10-cleanup.md`
3. `phpstan-fixes-gennaio-2025.md` → Consolidare in `phpstan-compliance.md`

## File con Maiuscole (da Rinominare)

1. `METODI_DUPLICATI_ANALISI.md` → `metodi-duplicati-analisi.md` (già esiste `metodi-duplicati-analisi.md`)

## Processo di Consolidamento

### Fase 1: Backup
```bash
# Creare backup prima di eliminare
mkdir -p archive/backup-$(date +%Y%m%d)
cp *.md archive/backup-$(date +%Y%m%d)/
```

### Fase 2: Verifica Contenuti
Per ogni coppia di file duplicati:
1. Confrontare contenuti
2. Identificare informazioni uniche
3. Consolidare in un unico file
4. Aggiornare collegamenti

### Fase 3: Eliminazione
1. Eliminare file con underscore
2. Eliminare file duplicati
3. Spostare file con date in archive/

### Fase 4: Aggiornamento Collegamenti
1. Cercare riferimenti ai file eliminati
2. Aggiornare tutti i collegamenti
3. Verificare README.md

## Checklist Pre-Consolidamento

- [ ] Backup completo creato
- [ ] Contenuti confrontati per ogni coppia
- [ ] Informazioni uniche identificate
- [ ] File consolidati creati
- [ ] Collegamenti aggiornati
- [ ] README.md aggiornato

## Checklist Post-Consolidamento

- [ ] File duplicati eliminati
- [ ] File con date spostati in archive/
- [ ] File con maiuscole rinominati
- [ ] Tutti i collegamenti funzionano
- [ ] README.md aggiornato
- [ ] Documentazione verificata

## Note Importanti

1. **Mai eliminare senza backup**: Sempre creare backup prima di eliminare
2. **Verificare contenuti**: Non assumere che file con stesso nome abbiano stesso contenuto
3. **Aggiornare collegamenti**: Cercare tutti i riferimenti ai file eliminati
4. **Mantenere storia**: File storici importanti vanno in archive/, non eliminati

---

**Data creazione**: 2025-01-06
**Status**: Piano da implementare
**Priorità**: Alta
