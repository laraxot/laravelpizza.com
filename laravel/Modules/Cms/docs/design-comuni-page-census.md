# Design Comuni Page Census For CMS Blocks

## Purpose
This document translates the official Design Comuni static-page catalog into CMS-oriented implementation work.

Primary source:
- <https://italia.github.io/design-comuni-pagine-statiche/>

## Implementation Rule
For each source page:
- route: `/it/tests/<slug>`
- page JSON: `config/local/fixcity/database/content/pages/tests.<slug>.json`
- renderer: `Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`
- content source of truth: `content_blocks.it[]`

## Current Universal Block Families
These block families should be preferred over page-specific templates.

### Structural
- `header.*`
- `footer.*`
- `navigation.*`
- `breadcrumb.*`

### Listing
- `listing.page-header`
- `listing.featured-cards`
- `listing.search-results`
- `listing.pagination`
- `listing.category-grid`
- `listing.mixed-grid`

### Detail
- `detail.page-header`
- `detail.meta`
- `detail.content`
- `detail.related-items`

### Feedback / support
- `feedback.survey`
- `search.support-links`
- `contact.support-grid`

### Flow
- `flow.stepper`
- `flow.form-section`
- `flow.summary`
- `flow.confirmation`

## Full Page Census
- `homepage`
- `domande-frequenti`
- `risultati-ricerca`
- `argomenti`
- `argomento`
- `lista-risorse`
- `lista-categorie`
- `lista-risorse-categorie`
- `mappa-sito`
- `amministrazione`
- `documenti-dati`
- `novita`
- `novita-dettaglio`
- `servizi`
- `servizi-categoria`
- `servizio-dettaglio`
- `eventi`
- `evento-dettaglio`
- `appuntamento-01-ufficio`
- `appuntamento-01-ufficio-luogo`
- `appuntamento-02-data-orario`
- `appuntamento-03-dettagli`
- `appuntamento-04-richiedente`
- `appuntamento-04-richiedente-autenticato`
- `appuntamento-05-riepilogo`
- `appuntamento-06-conferma`
- `assistenza-01-dati`
- `assistenza-02-conferma`
- `segnalazione-dettaglio`
- `segnalazione-01-privacy`
- `segnalazione-02-dati`
- `segnalazione-03-riepilogo`
- `segnalazione-04-conferma`
- `segnalazione-area-personale`
- `segnalazioni-elenco`

## BMAD-Oriented Next Step
Use each converted page as evidence for refining the reusable taxonomy instead of treating conversion as a one-off page port.

## Cross References
- [Theme Census](../../../Themes/Sixteen/docs/design-comuni-page-census.md)
- [CMS README](README.md)
- [Content Blocks System](content-blocks-system.md)
