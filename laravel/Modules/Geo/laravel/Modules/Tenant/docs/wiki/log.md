---
title: "Activity Log"
module: "Tenant"
---

# Activity Log — Tenant

> **Purpose:** Append-only chronological activity record tracking ingests, queries, and lint passes.

## Log Entries

## [2026-07-01] [INGEST] Database factories — rimossa `Factories_/`

- Regola generica: [database-folder-lowercase-rule.md](../../../../../docs/wiki/concepts/database-folder-lowercase-rule.md)
- Wiki modulo: [lowercase-database-factories-directory.md](./concepts/lowercase-database-factories-directory.md)
- `database/Factories_/` era copia stale (gitignore); canonico = `database/factories/`
- Aggiornati: `method-name-homonyms.md` (path solo minuscolo), `concepts/INDEX.md`, `index.md`
- Audit: `bash bashscripts/tools/audit-database-folder-lowercase.sh Tenant`

## [2026-06-30] [LINT] Removed duplicate uppercase Tests directory

- Regola: il modulo Tenant usa solo `tests/`.
- `Tests/` era duplicata rispetto a `tests/` e non deve esistere.
- Wiki: `docs/wiki/concepts/lowercase-tests-directory.md`.

### Format

```
[YYYY-MM-DD HH:MM:SS UTC] [OPERATION] Description
```

**Operations:**
- `INGEST` — Added raw document to wiki
- `QUERY` — Answered question from wiki
- `LINT` — Maintained wiki quality
- `UPDATE` — Modified existing wiki page

---

**Last Activity:** 2026-07-01  
**Total Operations:** 2
