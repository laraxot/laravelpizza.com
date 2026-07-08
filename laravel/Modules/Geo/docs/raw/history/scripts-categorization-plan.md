# Script Categorization Plan - Super Mucca Analysis

**Data**: Gennaio 2025  
**Scopo**: Categorizzare 103 script .sh/.py dalla root di bashscripts/ in sottocartelle appropriate  
**Priorità**: ALTA - Organizzazione e manutenibilità

---

## 📊 Situazione Attuale

**Script nella root di bashscripts/**: ~103 file .sh/.py non categorizzati

**Categorie Esistenti**:
- `analysis/` - Script di analisi
- `backup/` - Backup e ripristino
- `composer/` - Gestione Composer
- `conflicts/` - Risoluzione conflitti
- `database/` - Operazioni database
- `development/` - Script sviluppo
- `docs/` - Script documentazione
- `fix/` - Fix automatici
- `git/` - Operazioni Git
- `maintenance/` - Manutenzione
- `mcp/` - MCP server
- `phpstan/` - PHPStan analysis
- `quality-assurance/` - QA e testing
- `translations/` - Traduzioni
- `utilities/` - Utilità generiche

---

## 🎯 Piano Categorizzazione

### Categoria: `analysis/`

Script da spostare:
- `analyze_docs_duplicates.sh`
- `check_module_reusability.sh`
- `check_trait_duplications.sh`
- `find_all_syntax_errors.sh`

### Categoria: `backup/`

Script da spostare:
- `backup.sh`

### Categoria: `composer/`

Script da spostare:
- `composer_init.sh`
- `get_composer.sh`

### Categoria: `conflicts/` o `git/conflict_resolution/`

Script da spostare:
- `fix_all_conflicts.sh`
- `fix_all_merge_conflicts.sh`
- `fix_all_merge_conflicts_v2.sh`
- `fix_all_merge_conflicts_v3.sh`
- `fix_all_merge_conflicts_v4.sh`
- `fix_conflicts.sh`
- `fix_conflicts_healthcare_app.sh`
- `fix_conflicts_robust.sh`
- `fix_conflicts_simple.sh`
- `fix_git_conflicts_*.sh` (tutti i fix_git_conflicts_*.sh)
- `fix_merge_conflicts_simple.sh`
- `fix_remaining_conflicts.sh`
- `fix_xot_merge_conflicts.sh`
- `resolve_conflicts_incoming.sh`
- `resolve_git_conflict.sh`
- `resolve_git_conflicts_current.sh`
- `resolve_git_conflicts.sh`

### Categoria: `database/`

Script da spostare:
- `check_mysql.sh`
- `check_mysql_win.sh`

### Categoria: `docs/` o `documentation/`

Script da spostare:
- `check_docs_naming_convention.sh`
- `cleanup_docs.sh`
- `docs-consolidation-radical.sh`
- `docs-naming-audit.sh`
- `docs-refactoring-dry-kiss.sh`
- `docs-refactoring-safe.sh`
- `fix_docs_naming*.sh` (tutti i fix_docs_naming*.sh)
- `migrate_docs.sh`
- `normalize_docs_naming.sh`
- `organize_docs_structure.sh`
- `update_docs.sh`

### Categoria: `fix/`

Script da spostare:
- `fix_directory_structure.sh`
- `fix_errors.sh`
- `fix_navigation_translations.sh`
- `fix_scheda_trait_accessors.sh`
- `fix_structure.sh`
- `fix_translations.sh`

### Categoria: `git/`

Script da spostare:
- `git_*.sh` (tutti i git_*.sh)
- `dual_push.sh`
- `parse_gitmodules_ini.sh`
- `reset_subtrees.sh`
- `sync_submodules.sh`

### Categoria: `maintenance/`

Script da spostare:
- `cleanup-duplicate-files.sh`
- `copy_to_mono.sh`
- `organize_files.sh`
- `sync_to_disk.sh`
- `verify_assets.sh`

### Categoria: `mcp/`

Script da spostare:
- `mcp-manager.sh`
- `mcp-manager-v2.sh`
- `start-mysql-mcp.sh`

### Categoria: `phpstan/`

Script da spostare:
- `check_before_phpstan.sh`

### Categoria: `quality-assurance/`

Script da spostare:
- `check_duplicate_translations.sh`

### Categoria: `setup/` o `development/`

Script da spostare:
- `create_svg_structure.sh`
- `organize_scripts_by_category.sh`
- `update.sh`
- `update_enums.sh`
- `update_namespaces.sh`
- `validate-shared-scripts.sh`

### Categoria: `translations/`

Script da spostare:
- `manage_translations.sh`

### Categoria: `utilities/`

Script da spostare:
- Script generici che non rientrano in altre categorie

---

## 📋 Mappatura Completa Script → Categoria

| Script | Categoria | Note |
|--------|-----------|------|
| `analyze_docs_duplicates.sh` | `analysis/` | Analisi duplicati docs |
| `backup.sh` | `backup/` | Backup sistema |
| `check_before_phpstan.sh` | `phpstan/` | Pre-check PHPStan |
| `check_docs_naming_convention.sh` | `docs/` | Check naming docs |
| `check_duplicate_translations.sh` | `quality-assurance/` | Check traduzioni |
| `check_module_reusability.sh` | `analysis/` | Analisi moduli |
| `check_mysql.sh` | `database/` | Check MySQL Linux |
| `check_mysql_win.sh` | `database/` | Check MySQL Windows |
| `check_trait_duplications.sh` | `analysis/` | Analisi trait |
| `cleanup-duplicate-files.sh` | `maintenance/` | Cleanup file duplicati |
| `cleanup_docs.sh` | `docs/` | Cleanup documentazione |
| `composer_init.sh` | `composer/` | Init Composer |
| `copy_to_mono.sh` | `maintenance/` | Copy operazioni |
| `create_svg_structure.sh` | `development/` | Setup SVG |
| `docs-consolidation-radical.sh` | `docs/` | Consolidamento docs |
| `docs-naming-audit.sh` | `docs/` | Audit naming |
| `docs-refactoring-dry-kiss.sh` | `docs/` | Refactoring docs |
| `docs-refactoring-safe.sh` | `docs/` | Refactoring sicuro |
| `dual_push.sh` | `git/` | Git dual push |
| `find_all_syntax_errors.sh` | `analysis/` | Find errori sintassi |
| `fix_all_conflicts.sh` | `conflicts/` | Fix tutti conflitti |
| `fix_all_merge_conflicts*.sh` | `conflicts/` | Fix merge conflitti |
| `fix_conflicts*.sh` | `conflicts/` | Fix conflitti vari |
| `fix_directory_structure.sh` | `fix/` | Fix struttura directory |
| `fix_docs_naming*.sh` | `docs/` | Fix naming docs |
| `fix_errors.sh` | `fix/` | Fix errori generici |
| `fix_git_conflicts*.sh` | `conflicts/` | Fix Git conflitti |
| `fix_navigation_translations.sh` | `fix/` | Fix traduzioni navigation |
| `fix_remaining_conflicts.sh` | `conflicts/` | Fix conflitti rimanenti |
| `fix_scheda_trait_accessors.sh` | `fix/` | Fix trait accessors |
| `fix_structure.sh` | `fix/` | Fix struttura |
| `fix_translations.sh` | `translations/` | Fix traduzioni |
| `fix_xot_merge_conflicts.sh` | `conflicts/` | Fix conflitti Xot |
| `get_composer.sh` | `composer/` | Get Composer |
| `git_*.sh` | `git/` | Operazioni Git |
| `manage_translations.sh` | `translations/` | Gestione traduzioni |
| `mcp-manager*.sh` | `mcp/` | MCP manager |
| `migrate_docs.sh` | `docs/` | Migrazione docs |
| `normalize_docs_naming.sh` | `docs/` | Normalizza naming |
| `organize_docs_structure.sh` | `docs/` | Organizza struttura |
| `organize_files.sh` | `maintenance/` | Organizza file |
| `organize_scripts_by_category.sh` | `development/` | Organizza script |
| `parse_gitmodules_ini.sh` | `git/` | Parse gitmodules |
| `resolve_conflicts*.sh` | `conflicts/` | Risolve conflitti |
| `reset_subtrees.sh` | `git/` | Reset subtrees |
| `start-mysql-mcp.sh` | `mcp/` | Start MySQL MCP |
| `sync_submodules.sh` | `git/` | Sync submodules |
| `sync_to_disk.sh` | `maintenance/` | Sync to disk |
| `update.sh` | `development/` | Update sistema |
| `update_docs.sh` | `docs/` | Update docs |
| `update_enums.sh` | `development/` | Update enums |
| `update_namespaces.sh` | `development/` | Update namespaces |
| `validate-shared-scripts.sh` | `development/` | Valida script |
| `verify_assets.sh` | `maintenance/` | Verifica assets |

---

## ✅ Azione Proposta

1. **Analisi Finale**: Verificare ogni script per confermare categoria
2. **Creazione Categorie Mancanti**: Se necessario, creare sottocartelle
3. **Spostamento Script**: Spostare ogni script nella categoria appropriata
4. **Verifica Link**: Controllare che eventuali link/import funzionino ancora
5. **Documentazione**: Aggiornare README.md di ogni categoria

---

**Business Logic**: Organizzazione migliora manutenibilità e chiarezza del progetto.  
**Perché**: Script sparsi nella root rendono difficile trovare e mantenere script.  
**Approccio**: DRY (no duplicazione organizzazione) + KISS (categorie chiare e semplici)

