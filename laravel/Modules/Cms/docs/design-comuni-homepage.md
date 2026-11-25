---
title: "design comuni homepage"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-11-23
qmd: "design comuni homepage"
issues: []
discussions: []
---

# Design Comuni Homepage Parity

**Last verified**: 2026-04-03
**Module**: Cms
**Theme**: Sixteen
**Scope**: coordination between Cms-driven page structure and theme-level visual parity work

## Runtime ownership

La homepage di test ` /it/tests/homepage ` e' orchestrata da due livelli distinti:

### Cms / content layer
- `config/local/fixcity/database/content/pages/tests.homepage.json`
- struttura contenuti, blocchi, ordine delle sezioni
- contratto dati per la pagina di test

### Theme / presentation layer
- `Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`
- `Themes/Sixteen/resources/css/app.css`
- `Themes/Sixteen/resources/js/app.js`
- resa visuale finale, spacing, tipografia, component rhythm e normalizzazioni runtime

## Current status

- Il confronto del `body` senza script e' oltre la soglia del 90%.
- Le differenze residue piu' importanti sono visive, non di struttura CMS.
- Per questo pass il Cms non e' il punto principale di intervento: il lavoro attivo resta nel tema Sixteen.

## Active references in theme docs

- [../../../Themes/Sixteen/docs/design-comuni/00-index.md](../../../Themes/Sixteen/docs/design-comuni/00-index.md)
- [../../../Themes/Sixteen/docs/design-comuni/homepage-structure-diff-2026-04-02.md](../../../Themes/Sixteen/docs/design-comuni/homepage-structure-diff-2026-04-02.md)
- [../../../Themes/Sixteen/docs/design-comuni/work-plan.md](../../../Themes/Sixteen/docs/design-comuni/work-plan.md)
- [../../../Themes/Sixteen/docs/design-comuni/bmad-gsd-status-2026-04-03.md](../../../Themes/Sixteen/docs/design-comuni/bmad-gsd-status-2026-04-03.md)
- [../../../Themes/Sixteen/docs/design-comuni/screenshots/homepage-visual-pass-2026-04-02.md](../../../Themes/Sixteen/docs/design-comuni/screenshots/homepage-visual-pass-2026-04-02.md)

## Cms-side guidance

- Se la struttura HTML del `body` dovesse scendere sotto la soglia di parity, verificare prima il JSON della pagina di test.
- Se le differenze sono solo visive, non toccare Blade o JSON: lavorare nel tema.
- Ogni modifica alla composizione della homepage deve essere documentata sia qui sia nei docs del tema.

## Related docs

- [00-index.md](./00-index.md) - Indice del modulo Cms
- [architecture/homepage-structure.md](./architecture/homepage-structure.md) - Architettura runtime aggiornata
- [page-component-architecture-3.md](./page-component-architecture-3.md) - Architettura generale dei componenti pagina
- [page-component-architecture-2.md](./page-component-architecture-2.md) - Architettura generale dei componenti pagina
- [page-component-architecture-3.md](./page-component-architecture-3.md) - Architettura generale dei componenti pagina
