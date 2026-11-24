---
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
