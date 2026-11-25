---
title: "ADR — Rating"
type: index
owner: Rating
updated: 2026-11-24
qmd: "Rating ADR architecture decision record MADR formato valutazioni polimorfiche"
---

# ADR — Rating

Un ADR del modulo Rating registra una scelta difficile da invertire, sorprendente o frutto di un trade-off reale sulle valutazioni polimorfiche e sui dati di performance. Ogni affermazione ha un file di prova. Template condiviso: [0000-template](../../../Xot/docs/adr/0000-template.md); standard: [Xot ADR](../../../Xot/docs/adr/README.md).

## Formato MADR

Frontmatter (`title`, `type: decision`, `status`, `created`, `updated`, `decision-makers`, `module`, `qmd`) e sezioni nell'ordine: `## Contesto`, `## Driver della decisione`, `## Alternative scartate`, `## Decisione`, `## Conseguenze`, `## Conferma`. Nome file in kebab-case senza data né numero.

## ADR presenti

Elenco con stato: [INDEX.md](index.md). Nessun ADR nuovo in questa passata: la scelta dimostrabile dal codice (relazione `morphToMany` e lettura di entrambe le forme di `model_type` in `HasRatingsTrait`) è già in [rating-is-polymorphic](rating-is-polymorphic.md) e [rating-is-domain-feedback](rating-is-domain-feedback.md).

Policy trasversale su dati sacri e test isolati: [0013-dati-sacri-migrazioni-e-test](../../../Xot/docs/adr/0013-dati-sacri-migrazioni-e-test.md).
