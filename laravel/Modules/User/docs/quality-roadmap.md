---
title: Quality roadmap — User
type: concept
tags: [user, quality, perfection, pest, phpstan, foundation]
created: 2026-08-31
updated: 2026-08-31
qmd: user quality roadmap perfection foundation spatie
related:
  - ./import-status.md
  - ./quality-status.md
  - ./testing.md
  - ../../Xot/docs/wiki/concepts/progetto-perfezione-criteri.md
---

# Quality roadmap — User

Modulo **foundation** — non è un modulo GC importato ma è prerequisito di perfezione globale.

## Stato perfezione (2026-08-31)

| Dimensione | Stato |
|------------|-------|
| PHPStan | Documentato in `quality-status.md` |
| Pest | Ampio; `MigrateDbTest` skip dati sacri |
| `import-status.md` | **Atipico** (log fix, non checklist GC) |
| Spatie roles | **Blocco D17** per tutti i test admin |

---

## Azioni ordinate

1. **D17** — tabella `roles` + permission su DB test (sblocca tutta la piattaforma).
2. **D12** — ownership migrazione `users` vs Auth.
3. Normalizzare `import-status.md` verso template GC o linkare `quality-status.md` come SSoT.
4. Ridurre doc legacy duplicata (audit User già esteso).

[quality-status.md](./quality-status.md) · [testing.md](./testing.md)
