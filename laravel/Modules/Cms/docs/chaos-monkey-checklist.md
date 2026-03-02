# Chaos monkey checklist (cms)

## Scopo

Checklist operativa per ripristinare rapidamente il frontoffice quando un “chaos monkey” introduce rotture casuali nel sistema Folio + Theme + CMS JSON blocks.

Questa checklist è basata sul runtime attuale (fail-fast su view mancanti, JSON tenant-driven via Sushi).

## Pipeline minima (source-of-truth)

1. Folio risolve la pagina da `Themes/<pub_theme>/resources/views/pages/*`

2. La pagina Folio/Volt renderizza `<x-layouts.app>` e delega a `<x-page ...>`

3. `<x-page>` carica `PageModel::getBlocksBySlug($slug, $side)`

4. `Page` usa `SushiToJsons` e legge JSON tenant da `database/content/pages/*.json`

5. `HasBlocks::getBlocks()` istanzia `new BlockData(...)` per ogni blocco

6. `cms::components.page` esegue `@include($block->view, $block->data)`

## Regole di stabilità (da non violare)

- `pub_theme::` deve restare risolvibile per views e translations.
- `BlockData` è **fail-fast** se la view non esiste (non assumere fallback silenziosi).
- Evitare `{{ route(...) }}` nei JSON dei blocchi: preferire URL stringa.

## Incident playbook (ordine consigliato)

### 1) Errore: `View [pub_theme::...] not found`

- **Sintomo**
  - Pagina 500 con eccezione `view not found: ...`

- **Diagnosi rapida**
  - Verifica registrazione namespace `pub_theme` (provider e config)

  - Verifica esistenza file Blade nel tema

  - Verifica che `xra.pub_theme` punti al tema corretto

- **Fix tipici**
  - Ripristinare file view rinominato/spostato

  - Ripristinare registrazione namespace in `CmsServiceProvider`


### 2) Errore: pagina vuota / nessun blocco renderizzato

- **Sintomo**
  - HTML senza contenuto (o solo layout)

- **Diagnosi rapida**
  - Verifica che il JSON della pagina esista e contenga `content_blocks.<locale>`

  - Verifica `slug` del JSON (deve matchare quello richiesto)

  - Verifica locale attivo e fallback lingua

- **Fix tipici**
  - Ripristinare/aggiungere `<slug>.json`

  - Aggiungere `content_blocks.it` (o primary language)


### 3) Errore: blocco con query dinamica non mostra dati

- **Sintomo**
  - Blocco renderizzato ma lista vuota

- **Diagnosi rapida**
  - Verifica `data.query.model` (classe esistente)

  - Verifica `scope/scopes` (gli scope mancanti vengono ignorati)

  - Verifica `orderBy`, `direction`, `limit`, `wrap_in`

- **Fix tipici**
  - Correggere classe modello o chiave `wrap_in`

  - Rendere la view robusta su dataset vuoti


### 4) Errore: Folio non trova pagine del tema

- **Sintomo**
  - 404 o Folio non matcha il file atteso

- **Diagnosi rapida**
  - Verifica `App\Providers\FolioServiceProvider` e path `laravel/Themes/{theme}/resources/views/pages`

  - Verifica che la directory esista

- **Fix tipici**
  - Ripristinare directory `pages/` nel tema

  - Correggere config `xra.pub_theme`


### 5) Errore: assets mancanti / CSS non applicato

- **Sintomo**
  - UI senza stile, console 404 su asset

- **Diagnosi rapida**
  - Verifica `<x-metatags>` e `@vite(..., 'themes/' . $meta->getPubTheme())`

  - Verifica build/copy del tema

- **Fix tipici**
  - Ricompilare assets tema e pulire cache view


## Chaos scenarios (da eseguire in test)

1. Rinominare un file `pub_theme::components.blocks.*` e verificare che l’errore sia immediatamente identificabile.

2. Corrompere `data.query.model` e verificare isolamento del blocco.

3. Rimuovere `events.view` e verificare fallback del routing `[container0]/[slug0]`.
4. Cambiare `xra.pub_theme` e verificare risoluzione namespace e path Folio.
