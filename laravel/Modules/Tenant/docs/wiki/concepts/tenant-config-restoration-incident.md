---
title: Ripristino config tenant dopo delete accidentale
type: troubleshooting
confidence: high
created: 2026-07-01
updated: 2026-07-01
tags: [tenant, config, incident, ponytail]
qmd: "tenant config restoration incident accidental delete GetTenantNameAction"
related:
  - ../../../../../../docs/wiki/concepts/tenant-config-directory-sacred.md
  - ../../../../../../docs/wiki/concepts/sacred-artifacts-never-delete.md
  - ../../../../../../docs/project/incidents/tenant-config-accidental-delete.md
  - ../../../../../../docs/project/incidents/config-directory-mismatch.md
  - ../ConfigurationDistribution.md
  - ../../../app/Actions/GetTenantNameAction.php
---

# Ripristino config tenant — incidente 2026-07-01

## Cosa è successo

Commit `8a3fdd530` ha rimosso gli alberi config per dominio in `laravel/config/`:
`com/geekpiu`, `eu/fixcity`, `net/futurely`, `localhost`, file in `local/predict/`.

Classificazione errata: «obsolete» durante cleanup ponytail.

## Perché sono necessari

`GetTenantNameAction` risolve il path `config/{tenant}/` da hostname invertito.
`GetTenantFilePathAction` e `TenantService::config()` leggono file da lì.

Senza questi file il tenant non ha override DB, moduli, metatag, contenuti Orbit.

## Ripristino

Commit `6b83dfdb2` — contenuto identico a pre-delete (`git diff 8a3fdd530^..HEAD` su `laravel/config/` = 0 righe di contenuto).

## Prevenzione

```bash
bash bashscripts/tools/guard-tenant-config-delete.sh
bash bashscripts/tools/audit-tenant-config-inventory.sh
```

Hub progetto: [tenant-config-directory-sacred.md](../../../../../../docs/wiki/concepts/tenant-config-directory-sacred.md)

## Forma canonica

Non consolidare profili diversi in un unico albero. Ogni deploy mantiene la propria cartella sotto `laravel/config/`.
