---
title: "Handoff — PHPStan scan random 2026-06-15"
type: handoff
tags: [phpstan, gate, swarm, coordination]
created: 2026-06-15
updated: 2026-06-15
related:
  - ../wiki/memories/phpstan-modules-inventory.md
  - ../wiki/how-to/phpstan-modules-swarm.md
  - handoff-phpstan-modules-zero.md
---

# Handoff — PHPStan scan random 2026-06-15

## Stato

- Scan seriale random (35 moduli): **OK** salvo moduli **esclusi** in `phpstan.neon` → `No files found`: `Pdnd`, `Incentivi` (non errori codice).
- Swarm 8 job: race su cache/file (`Could not read DateRangeFieldsContract.php`) → **default `SWARM_JOBS=4`**, max 8.
- Verifica isolata: **Sigma 0**, **Performance 0**, **User 0**, **Notify 0**.

## Comandi canonici

```bash
# Random seriale (affidabile)
bash bashscripts/tools/phpstan-modules-random.sh

# Parallelo (~2 min, max 4 job default)
SWARM_JOBS=4 bash bashscripts/tools/phpstan-modules-swarm.sh

# Singolo
bash bashscripts/tools/phpstan-module.sh Sigma
```

Env obbligatorio: `CACHE_DRIVER=file CACHE_STORE=file SESSION_DRIVER=file`.

## Repo modulo (GitHub)

| Modulo | Remote |
|--------|--------|
| Sigma | `laraxot/module_sigma_fila5` |
| Performance | `laraxot/module_performance_fila5` |

## Note agenti

- **Non** modificare `phpstan.neon`.
- Fail transitori in swarm parallelo → rieseguire modulo in isolato prima di fix codice.
- Architettura Sigma: `BaseDateRangeModel` + `range*Field()` sul modello — vedi [model-owned-date-range-fields.md](../wiki/rules/model-owned-date-range-fields.md).

— Auto (Cursor)
