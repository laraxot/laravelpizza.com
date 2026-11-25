---
title: "ADR — UI"
type: index
owner: UI
updated: 2026-11-25
qmd: "UI ADR architecture decision record MADR harness NNNN-slug IDColumn"
---

# ADR — UI

Un ADR del modulo UI registra una scelta difficile da invertire, sorprendente o frutto di un trade-off reale sul layer di presentazione condiviso. Ogni affermazione ha un file di prova.

## Naming (obbligatorio)

Il basename **DEVE** essere `NNNN-slug.md` (es. `0002-idcolumn-mandatory-on-tables.md`).

Eccezioni: `README.md`, `INDEX.md` / `index.md`, `0000-template.md`. Stub `superseded` senza numero sono ammessi solo come puntatori verso l'ADR `NNNN-` canonico.

## Template MADR (harness)

- Ufficiale: [laravelday-harness-workshop `0000-template.md`](https://raw.githubusercontent.com/robertogallea/laravelday-harness-workshop/refs/heads/main/docs/adr/0000-template.md)
- Locale: [0000-template.md](0000-template.md)
- Cross-modulo: [Xot 0000-template](../../../Xot/docs/adr/0000-template.md); standard: [Xot ADR](../../../Xot/docs/adr/README.md)

## Formato sezioni (inglese, ordine fisso)

Frontmatter harness: `status`, `date`, `decision-makers` (+ `qmd` opzionale per il second brain).

Sezioni:

1. `## Context and Problem Statement`
2. `## Decision Drivers`
3. `## Considered Options`
4. `## Decision Outcome`
5. `### Consequences`
6. `### Confirmation`

## ADR presenti

Elenco con stato: [index.md](index.md). Ultima decisione numerata: [0002-idcolumn-mandatory-on-tables](0002-idcolumn-mandatory-on-tables.md) (`IDColumn` prima colonna di ogni tabella Filament). Altre: [0005-ui-blocks-use-cms-localization](0005-ui-blocks-use-cms-localization.md); confine dominio in [0006-ui-does-not-authorize-domain-data](0006-ui-does-not-authorize-domain-data.md).

Policy trasversale su dati sacri e test isolati: [0013-dati-sacri-migrazioni-e-test](../../../Xot/docs/adr/0013-dati-sacri-migrazioni-e-test.md).
