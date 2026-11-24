---
title: "ADR — Tenant"
type: index
owner: Tenant
updated: 2026-11-24
qmd: "Tenant ADR architecture decision record MADR formato isolamento configurazione"
---

# ADR — Tenant

Un ADR del modulo Tenant registra una scelta difficile da invertire, sorprendente o frutto di un trade-off reale sull'identificazione del tenant e sulla sua configurazione. Ogni affermazione ha un file di prova. Template condiviso: [0000-template](../../../Xot/docs/adr/0000-template.md); standard: [Xot ADR](../../../Xot/docs/adr/README.md).

## Formato MADR

Frontmatter (`title`, `type: decision`, `status`, `created`, `updated`, `decision-makers`, `module`, `qmd`) e sezioni nell'ordine: `## Contesto`, `## Driver della decisione`, `## Alternative scartate`, `## Decisione`, `## Conseguenze`, `## Conferma`. Nome file in kebab-case senza data né numero.

## ADR presenti

Elenco con stato: [INDEX.md](INDEX.md). Nessun ADR nuovo in questa passata: le decisioni dimostrabili dal codice (risoluzione della config tramite Action, overlay centralizzato) sono già coperte da [tenant-config-is-resolved-by-action](tenant-config-is-resolved-by-action.md) e [tenant-isolation-is-invariant](tenant-isolation-is-invariant.md); non si duplicano.

Policy trasversale su dati sacri e test isolati: [0013-dati-sacri-migrazioni-e-test](../../../Xot/docs/adr/0013-dati-sacri-migrazioni-e-test.md).
