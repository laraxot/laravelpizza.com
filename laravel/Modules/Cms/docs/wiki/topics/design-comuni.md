---
title: "Topic design-comuni"
type: digest
status: active
qmd: "digest ceiling 100 design-comuni"
---

# Topic design-comuni

Sintesi automatica di 13 documenti (chiave `design-comuni`).

## Design Comuni — accesso-servizio

_Fonte: `design-comuni-accesso-servizio.md`_

# Design Comuni — accesso-servizio

La pagina di test `/it/tests/accesso-servizio` è una pagina CMS, non una view Folio dedicata.

## Contratto di risoluzione

- Route: `Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`.
- Slug pubblico: `accesso-servizio`.
- Slug CMS: `tests.accesso-servizio`.
- Fixture: `config/local/fixcity/database/content/pages/tests.accesso-servizio.json`.
- Ogni blocco deve dichiarare una view realmente esistente: `BlockData` fallisce esplicitamente se il namespace non è risolvibile.

Il prefisso `tests.` è necessario perché `PageSlugMiddleware` e il componente Folio costruiscono il page slug dal container e dal segmento. Un JSON con solo `accesso-servizio` può produrre una risposta HTTP valida ma senza blocchi.

## Sequenza dei blocchi

`breadcrumb → hero → access-method-card → contacts → search-form → suggestions`.

Il contenuto resta nei dati JSON; le view accettano `data` e rendono soltanto struttura, semantica e comportamento accessibile.

## Verifica CMS

```bash
jq empty config/local/fixcity/database/content/pages/tests.accesso-servizio.json
curl -f http://192.168.1.40:8000/it/tests/accesso-servizio
```

La verifica browser deve inoltre controllare H1, sezioni SPID/CIE, asset SVG, console e overflow sui breakpoint 375, 768 e 1440.

## Design Comuni Argomenti

_Fonte: `design-comuni-argomenti.md`_

# Design Comuni Argomenti

## Source Of Truth

La route `http://127.0.0.1:8000/it/tests/argomenti` passa da:

- [laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php](/var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php)

La composizione CMS resta governata da:

- [laravel/config/local/fixcity/database/content/pages/tests.argomenti.json](/var/www/_bases/base_fixcity_fila5/laravel/config/local/fixcity/database/content/pages/tests.argomenti.json)

## Status

`argomenti` e' stata riallineata fino al punto in cui il gate strutturale di `main` risulta `100%` nell'audit coarse.

Questo la rende la prima pagina del batch effettivamente sbloccata per il lavoro visuale CSS/JS.

## CMS Changes Relevant To The Fix

Nel JSON sono stati allineati i blocchi a questa sequenza:

- breadcrumb con wrapper esterno `container#main-container`
- hero `argomenti`
- topics highlight
- topics grid
- feedback `faq-rating`
- contacts `faq`

## Design Comuni Argomento

_Fonte: `design-comuni-argomento.md`_

# Design Comuni Argomento

## Source Of Truth

La route `http://127.0.0.1:8000/it/tests/argomento` passa da:

- [laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php](/var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php)

Il contenuto CMS e la composizione blocchi arrivano da:

- [laravel/config/local/fixcity/database/content/pages/tests.argomento.json](/var/www/_bases/base_fixcity_fila5/laravel/config/local/fixcity/database/content/pages/tests.argomento.json)

## Current Structure From JSON

Blocchi dichiarati:

- `pub_theme::components.blocks.breadcrumb.default`
- `pub_theme::components.blocks.hero.default`
- `pub_theme::components.blocks.cards.grid`
- `pub_theme::components.blocks.links.list`

## Why Parity Is Not Reached

La reference `argomento.html` non e' costruita come semplice `breadcrumb + hero + cards-grid + links-list`.

La reference usa invece una pagina molto piu' articolata con:

- hero wrapper con immagine di sfondo
- card hero sovrapposta

## Design Comuni Batch CMS Audit

_Fonte: `design-comuni-batch-audit.md`_

# Design Comuni Batch CMS Audit

Questo report riassume quali pagine `tests.<slug>` sono pronte per parity visuale e quali sono bloccate a livello di struttura CMS/rendering.

- homepage: json=yes, runtime=ok, overall=38%, gate=BLOCK
- domande-frequenti: json=yes, runtime=ok, overall=40%, gate=BLOCK
- risultati-ricerca: json=yes, runtime=ok, overall=42%, gate=BLOCK
- argomenti: json=yes, runtime=ok, overall=50%, gate=BLOCK
- argomento: json=yes, runtime=ok, overall=27%, gate=BLOCK
- lista-risorse: json=yes, runtime=ok, overall=13%, gate=BLOCK
- lista-categorie: json=yes, runtime=error, overall=0%, gate=BLOCK
- lista-risorse-categorie: json=yes, runtime=error, overall=0%, gate=BLOCK
- mappa-sito: json=yes, runtime=ok, overall=27%, gate=BLOCK
- amministrazione: json=yes, runtime=ok, overall=27%, gate=BLOCK
- aree-amministrative: json=no, runtime=ok, overall=70%, gate=BLOCK
- area-amministrativa-dettaglio: json=no, runtime=ok, overall=70%, gate=BLOCK
- organo: json=no, runtime=ok, overall=70%, gate=BLOCK
- persona: json=no, runtime=ok, overall=70%, gate=BLOCK
- persona-dettaglio: json=no, runtime=ok, overall=70%, gate=BLOCK
- ufficio: json=no, runtime=ok, overall=70%, gate=BLOCK
- ufficio-dettaglio: json=no, runtime=ok, overall=70%, gate=BLOCK
- enti-e-fondazioni: json=no, runtime=ok, overall=70%, gate=BLOCK
- ente-dettaglio: json=no, runtime=ok, overall=70%, gate=BLOCK
- documenti-dati: json=yes, runtime=error, overall=0%, gate=BLOCK
- documento-dettaglio: json=no, runtime=ok, 

## Design Comuni Batch Parity

_Fonte: `design-comuni-batch-parity.md`_

# Design Comuni Batch Parity

## Scopo

Documento di coordinamento Cms per l'audit batch delle pagine Design Comuni servite da `Themes/Sixteen/resources/views/pages/tests/[slug].blade.php` e dai JSON `config/local/fixcity/database/content/pages/tests.<slug>.json`.

Il report dettagliato vive nel tema, perche' e' il tema il punto dove convergono parity HTML del body, screenshot e successivi fix CSS/JS.

## Report attivo

- [../../../Themes/Sixteen/docs/design-comuni/batch-body-parity-2026-04-03.md](../../../Themes/Sixteen/docs/design-comuni/batch-body-parity-2026-04-03.md)
- [../../../Themes/Sixteen/docs/design-comuni/batch-body-parity](../../../Themes/Sixteen/docs/design-comuni/batch-body-parity)

## Script correlato

- [../../../bashscripts/design-comuni/batch-body-parity.sh](../../../bashscripts/design-comuni/batch-body-parity.sh)
- [../../../bashscripts/docs/design-comuni-batch-body-parity.md](../../../bashscripts/docs/design-comuni-batch-body-parity.md)

## Regola operativa

- Se una pagina risulta `READY_FOR_CSS_JS`, il lavoro successivo va nel tema Sixteen.
- Se una pagina risulta `HTML_DELTA`, prima va riallineata la struttura o il JSON Cms.
- Se una pagina risulta `LOCAL_500`, la priorita' e' sbloccare il rendering locale prima di parlare di parity visiva.

## Design Comuni - Domande Frequenti (FAQ)

_Fonte: `design-comuni-faq.md`_

# Design Comuni - Domande Frequenti (FAQ)

> **Obsoleto: `npm run copy` non esiste piu' (2026-11-11).** Gli asset dei temi
> arrivano nella document root con un symlink, non con una copia. Per il
> procedimento valido vedi
> [Xot/docs/theme-assets-workflow.md](/laravel/Modules/Xot/docs/theme-assets-workflow.md).
> Le istruzioni di copia qui sotto sono lasciate come documentazione storica.

## Panoramica

Implementazione della pagina FAQ del progetto Design Comuni Italia nel modulo Cms.

- **Pagina**: `/it/tests/domande-frequenti`
- **JSON Content**: `config/local/fixcity/database/content/pages/tests.domande-frequenti.json`
- **Componenti**: Accordion, Hero, Breadcrumb, Search
- **Stato**: ✅ 90% Completato

## Architettura

### Content Blocks

La pagina FAQ utilizza i seguenti content blocks definiti nel JSON:

```json
{
  "content_blocks": {
    "it": [
      { "type": "breadcrumb", "data": {...} },
      { "type": "hero", "data": {...} },

## Design Comuni Homepage Parity

_Fonte: `design-comuni-homepage.md`_

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

## Design Comuni - Cms Module Documentation Index

_Fonte: `design-comuni-index-3.md`_

# Design Comuni - Cms Module Documentation Index

## Panoramica

Documentazione del modulo Cms per il progetto Design Comuni Italia.

- **Modulo**: Cms
- **Responsabilità**: Rendering pagine, content blocks, JSON management
- **Data**: 2026-04-03

## 📚 Documenti Design Comuni

### Pagine Analizzate

| Documento | File | Descrizione |
|-----------|------|-------------|
| **Homepage** | [design-comuni-homepage.md](./design-comuni-homepage.md) | Analisi homepage |
| **FAQ** | [design-comuni-faq.md](./design-comuni-faq.md) | Pagina domande frequenti |
| **Argomenti** | [design-comuni-argomenti.md](./design-comuni-argomenti.md) | Pagina argomenti |
| **Argomento** | [design-comuni-argomento.md](./design-comuni-argomento.md) | Dettaglio argomento |
| **Risultati Ricerca** | [design-comuni-risultati-ricerca.md](./design-comuni-risultati-ricerca.md) | Pagina risultati ricerca |
| **Segnalazioni Elenco** | [design-comuni-ticket-list.md](./design-comuni-ticket-list.md) | Pagina segnalazioni elenco |
| **Services Implementation** | [design-comuni-services-implementation.md](./design-comuni-services-implementation.md) | Implementazione servizi |
| **Page Census** | [design-comuni-page-census.md](./design-comuni-page-census.md) | Censimento pagine |

### Audit e Parity

| Documento | File | Descrizione |
|-----------|------|-------------|

## Design Comuni - Cms Module Documentation Index

_Fonte: `design-comuni-index.md`_

# Design Comuni - Cms Module Documentation Index

## Panoramica

Documentazione del modulo Cms per il progetto Design Comuni Italia.

- **Modulo**: Cms
- **Responsabilità**: Rendering pagine, content blocks, JSON management
- **Data**: 2026-04-03

## 📚 Documenti Design Comuni

### Pagine Analizzate

| Documento | File | Descrizione |
|-----------|------|-------------|
| **Homepage** | [design-comuni-homepage.md](./design-comuni-homepage.md) | Analisi homepage |
| **FAQ** | [design-comuni-faq.md](./design-comuni-faq.md) | Pagina domande frequenti |
| **Argomenti** | [design-comuni-argomenti.md](./design-comuni-argomenti.md) | Pagina argomenti |
| **Argomento** | [design-comuni-argomento.md](./design-comuni-argomento.md) | Dettaglio argomento |
| **Risultati Ricerca** | [design-comuni-risultati-ricerca.md](./design-comuni-risultati-ricerca.md) | Pagina risultati ricerca |
| **Segnalazioni Elenco** | [design-comuni-ticket-list.md](./design-comuni-ticket-list.md) | Pagina segnalazioni elenco |
| **Services Implementation** | [design-comuni-services-implementation.md](./design-comuni-services-implementation.md) | Implementazione servizi |
| **Page Census** | [design-comuni-page-census.md](./design-comuni-page-census.md) | Censimento pagine |

### Audit e Parity

| Documento | File | Descrizione |
|-----------|------|-------------|

## Design Comuni Page Census For CMS Blocks

_Fonte: `design-comuni-page-census.md`_

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

## Design Comuni - Risultati Ricerca

_Fonte: `design-comuni-risultati-ricerca.md`_

# Design Comuni - Risultati Ricerca

## Scope

Pagina locale: `http://127.0.0.1:8000/it/tests/risultati-ricerca`
JSON CMS: [tests.risultati-ricerca.json](/var/www/_bases/base_fixcity_fila5/laravel/config/local/fixcity/database/content/pages/tests.risultati-ricerca.json)

## Stato corrente verificato

La shell top-level del `body` e coerente con il riferimento, ma dentro `main` restano differenze strutturali rilevanti.

Differenze confermate:
- manca `h1.visually-hidden#search-container`
- il breadcrumb non e ancora incapsulato nel `div#main-container.container` del riferimento
- i blocchi finali `bg-primary`, `bg-grey-card.shadow-contacts` e `it-example-modal` non risultano nella shell locale

## Documentazione canonica nel tema

- [risultati-ricerca-parity-2026-04-03.md](/var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen/docs/design-comuni/risultati-ricerca-parity-2026-04-03.md)
- [analysis.md](/var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen/docs/design-comuni/screenshots/risultati-ricerca-parity/analysis.md)
- [reference-risultati-ricerca.png](/var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen/docs/design-comuni/screenshots/risultati-ricerca-parity/reference-risultati-ricerca.png)
- [local-risultati-ricerca.png](/var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen/docs/design-comuni/screenshots/risultati-ricerca-parity/local-risultati-ricerca.png)

## Nota operativa

Per `risultati-ricerca` il gate strutturale non e ancora sufficiente per consid

## Design Comuni - Segnalazioni Elenco

_Fonte: `design-comuni-segnalazioni-elenco.md`_

# Design Comuni - Segnalazioni Elenco

## Panoramica

Analisi e implementazione della pagina elenco segnalazioni del progetto Design Comuni Italia.

- **Reference**: https://italia.github.io/design-comuni-pagine-statiche/sito/ticket-list.html
- **Local**: http://127.0.0.1:8000/it/tests/ticket-list
- **Data**: 2026-04-03

## 📊 Stato

| Metrica | Inizio | Attuale | Miglioramento |
|---------|--------|---------|---------------|
| Match % | 38.4% | **95.7%** | **+57.3%** |

## 🔧 Fix Applicati

### 1. JSON Content Aggiornato
- ✅ Aggiunto blocco `heading` con titolo e subtitle
- ✅ Aggiunto blocco `sidebar-filters` con 9 categorie
- ✅ Aggiunto blocco `tabs-map-list` con mappa, CTA e items
- ✅ Aggiunti campi `description`, `images`, `edit_url` per ogni item
- ✅ Aggiunto blocco `rating` con struttura multi-step

### 2. Blade Templates Creati
- ✅ `heading/default.blade.php` - Titolo pagina con subtitle
- ✅ `filters/sidebar.blade.php` - Filtri laterali per categoria
- ✅ `tabs/map-list.blade.php` - Tabs Mappa/Elenco con cards, modals, rating

## 🏛️ Design Comuni - Services Implementation Guide

_Fonte: `design-comuni-services-implementation.md`_

# 🏛️ Design Comuni - Services Implementation Guide

**Module:** Cms
**Related:** Theme Sixteen, Design Comuni Italia

---

title: "design comuni services implementation"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "design comuni services implementation"
issues: []
discussions: []
## 📋 Overview

Questa guida descrive come implementare la gestione dei servizi comunali secondo il modello Design Comuni Italia nel modulo Cms di FixCity.

---

## 🎯 Obiettivi

1. **Conformità AGID** - Rispettare standard Design Comuni
2. **Scheda Servizio Completa** - Tutte le sezioni richieste
3. **Accessibilità** - WCAG 2.1 Level AA
4. **Integrazione SPID/CIE** - Autenticazione digitale
5. **Gestione Documentale** - Allegati e link utili
