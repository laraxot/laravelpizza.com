---
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
