# Activity — Migrazioni

Bridge minimale alla **fonte canonica**:

> **docs/wiki/rules/migration-convention-zen.md**

Non duplicare la filosofia qui. Questa pagina è solo un ponte.

---

## Regola rapida per Activity

- Tutte le migrazioni estendono `XotBaseMigration`
- Nessun `protected $connection` (si ricava dal modello)
- Nomi file: `YYYY_MM_DD_HHMMSS_create_<tabella>_table.php`
- Parità: 1 migrazione = 1 modello = 1 seeder = 1 factory

## Riferimenti

- Regola tecnica: `.kilo/rules/migration-xot-base-standard.md`
- Pattern completo: `docs/wiki/patterns/migration-xot-base-pattern.md`
- Zen: `docs/wiki/rules/migration-convention-zen.md`