---
<<<<<<< .merge_file_G9bxLp
title: "Contratti — Tenant"
type: index
owner: Tenant
updated: 2026-11-24
qmd: "Tenant contract comportamentali isolamento risoluzione tenant invarianti TENANT-INV"
---

# Contratti — Tenant

Un contract descrive una singola operazione del modulo Tenant da cui dipende l'isolamento tra tenant: risoluzione del tenant corrente, calcolo dei percorsi dei suoi file, persistenza della sua configurazione. Documenta il comportamento **implementato**. Standard: [contract-authoring-standard](../../../Xot/docs/contracts/contract-authoring-standard.md); governance: [ADR 0012](../../../Xot/docs/adr/0012-behavioral-contract-governance.md).

## Formato

Frontmatter `type: contract` e `action: "Modules\\Tenant\\Actions\\..."`; sezioni nell'ordine `## Input`, `## Output`, `## Invarianti`, `## Effetti collaterali`, `## Errori`, `## Non fa`. Ogni invariante ha ID `TENANT-<AREA>-INV-<N>` e un test Pest con `->group('<ID>')`. Registro con copertura e comandi: [INDEX.md](INDEX.md).

## File presenti

- [get-tenant-name-action](get-tenant-name-action.md)
- [get-tenant-file-path-action](get-tenant-file-path-action.md)
- [save-tenant-config-action](save-tenant-config-action.md)
- Template: [_template](_template.md)
=======
title: "Contratti — modulo Tenant"
type: index
tags: [contracts, actions, tenant]
created: 2026-11-18
updated: 2026-11-24
---

# Contratti del modulo Tenant

Cosa promettono le Action di Tenant che risolvono o scrivono file del sito: config PHP del tenant e contenuti JSON dei
modelli Sushi. Ogni invariante ha un ID stabile; il group Pest la prova (`vendor/bin/pest Modules/Tenant/tests --group=<ID>`),
«—» è debito dichiarato.

Leggili prima di scrivere in `config/<tenant>/` o di toccare le Action `Config/*` e `Json/*`. Formato:
`Modules/Xot/docs/rules/action-behavioral-contract.md`.

## Contratti di Action

- [SaveTenantConfigAction](save-tenant-config-action.md) — fonde e riscrive un file di config del tenant; le liste si sostituiscono.
- [GetTenantFilePathAction](get-tenant-file-path-action.md) — percorso sicuro di un file del tenant; nei test i contenuti vanno sotto storage.
- [CreateJsonFileByRecordAction](create-json-file-by-record-action.md) — aggiunge una riga al JSON del tenant con id max+1 (oggi senza chiamanti).
>>>>>>> .merge_file_qmTgI7
