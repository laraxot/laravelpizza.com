# Changelog - Modulo Sigma

Tutte le modifiche significative al modulo Sigma saranno documentate in questo file.

## [2025-06-04] - Cleanup File Template

### Changed
- **File template rinominati**: Estensione `.php` → `.template`
  - `SchedaTrait_CLEAN.php` → `SchedaTrait_CLEAN.php.template`
  - `SchedaTrait_FINAL_TEMPLATE.php` → `SchedaTrait_FINAL_TEMPLATE.php.template`
  - Motivo: Evitare autoloading Composer di file non-eseguibili
  - Dettagli: [template-files-cleanup.md](./template-files-cleanup.md)

### Documentation
- Aggiunta convenzione per file template nel modulo
- Regola: Template code usa estensione `.template` per evitare PSR-4 warnings

---

## Convenzioni Template

- File template NON devono avere estensione `.php`
- Usare `.template`, `.example.php`, `.php.template`
- Mantenere syntax highlighting IDE con `.php.` prefix

