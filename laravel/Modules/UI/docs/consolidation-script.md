# Script Consolidamento Documentazione UI

## File Vuoti da Eliminare

Questi file sono vuoti (0 bytes) e possono essere eliminati:

```bash
cd laravel/Modules/UI/docs

# File vuoti con underscore
rm -f advanced_form_components.md
rm -f blade_data_handling.md
rm -f naming_conventions.md
rm -f phpstan_fixes_2025.md
```

## File Duplicati da Eliminare

Questi file hanno versioni con trattini che devono essere mantenute:

```bash
# Advanced Form Components
rm -f advanced_form_components.md

# Blade Components
rm -f blade_data_handling.md

# Filament Components
rm -f filament_4x_upgrade.md
rm -f filament_4x_upgrade_report.md
rm -f filament_blade_components_usage.md
rm -f filament_components.md
rm -f filament_components_errors.md
rm -f filament_components_location_studio.md
rm -f filament_components_usage.md
rm -f filament_fileupload.md
rm -f filament_fileupload_components.md
rm -f filament_error_fileupload_buttonlabel.md
rm -f filament_error_fileupload_icon.md
rm -f filament_error_fileupload_prefixicon.md
rm -f filament_dropdown_avatar_components.md
rm -f filament_dropdown_avatar_usage.md
rm -f filament_pages_refactoring.md
rm -f filament_resources_structure.md
rm -f filament_vscode.md

# Conflict Resolution
rm -f conflict_resolution_iconstatecolumn.md
rm -f conflict_resolution_locationselector.md
rm -f conflict_resolution_tablelayoutenum.md
rm -f conflict_resolution_translation_files.md

# Naming Conventions
rm -f convenzioni_naming_campi.md
rm -f naming_conventions.md
rm -f naming_rules.md

# PHPStan
rm -f phpstan_fixes_2025.md
rm -f phpstan_corrections_summary.md
rm -f phpstan_radio_badge_fix.md

# VSCode
rm -f vscode_filament_extension.md
rm -f vscode_filament_plugin.md

# Altri
rm -f algolia_docsearch.md
rm -f architecture_rules.md
rm -f auth_pages.md
rm -f base_components.md
rm -f best_practices.md
rm -f blocks_system.md
rm -f chart_components.md
rm -f components_guide.md
rm -f cms_link.md
rm -f cms_themes_link.md
```

## File con Date da Spostare in Archive

```bash
mkdir -p archive

# Spostare file con date
mv dry-kiss-analysis-2025-10-15.md archive/dry-kiss-analysis.md 2>/dev/null
mv phpstan-level-10-cleanup-2025-11-06.md archive/phpstan-level-10-cleanup.md 2>/dev/null

# Consolidare file PHPStan con date
# phpstan-fixes-gennaio-2025.md → consolidare in phpstan-compliance.md
```

## File con Maiuscole da Rinominare

```bash
# Verificare se METODI_DUPLICATI_ANALISI.md è diverso da metodi-duplicati-analisi.md
# Se sono identici, eliminare quello con maiuscole
if [ -f "METODI_DUPLICATI_ANALISI.md" ]; then
    if cmp -s "METODI_DUPLICATI_ANALISI.md" "metodi-duplicati-analisi.md" 2>/dev/null; then
        rm -f METODI_DUPLICATI_ANALISI.md
    else
        # Se diversi, rinominare quello con maiuscole
        mv METODI_DUPLICATI_ANALISI.md metodi-duplicati-analisi-uppercase.md
    fi
fi
```

## Verifica Finale

```bash
# Verificare che non ci siano più file con underscore
find . -maxdepth 1 -type f -name "*_*.md" | grep -v README

# Verificare che non ci siano più file con date nei nomi (tranne archive/)
find . -maxdepth 1 -type f -name "*2025*.md" -o -name "*november*.md" -o -name "*gennaio*.md" -o -name "*october*.md"

# Verificare file vuoti
find . -maxdepth 1 -type f -name "*.md" -size 0
```

## Aggiornamento Collegamenti

Dopo l'eliminazione, cercare e aggiornare tutti i riferimenti:

```bash
# Cercare riferimenti ai file eliminati
grep -r "advanced_form_components" . --include="*.md"
grep -r "blade_data_handling" . --include="*.md"
grep -r "filament_4x_upgrade" . --include="*.md"
# ... e così via per tutti i file eliminati
```

---

**Nota**: Eseguire questo script con cautela, verificando sempre prima di eliminare.
