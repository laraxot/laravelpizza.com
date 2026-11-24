---
title: "ADR — Le pagine pubbliche di Meetup sono JSON del CMS resi da <x-page>, senza Blade per pagina ne' controller"
type: decision
status: accepted
theme: Meetup
created: 2026-11-24
updated: 2026-11-24
related:
  - ../folio-pages-json-only-rule.md
  - ../architecture-debate-folio-json-only.md
  - ../container0-use-x-page-not-content-resolver.md
---

# ADR: pagine pubbliche = JSON + `<x-page>`

## Contesto

- Il tema serve un sito di community/eventi: home, elenco ed evento, pagine statiche, profili.
- Il dibattito interno e' gia' scritto in [architecture-debate-folio-json-only](../architecture-debate-folio-json-only.md):
  vinse la posizione «public pages are json only» contro le eccezioni con Blade dedicate.
- Una versione del dettaglio usava `<x-blocks.content-resolver>`, un componente del tema che decideva quale blocco
  rendere per tipo di contenuto ([container0-use-x-page-not-content-resolver](../container0-use-x-page-not-content-resolver.md)).
- Domanda: come si aggiunge o si cambia una pagina pubblica?

## Decisione

- Le pagine Folio generiche (`pages/index.blade.php`, `pages/[slug].blade.php`, `pages/[container0]/index.blade.php`,
  `pages/[container0]/[slug0]/index.blade.php`) contengono solo layout e `<x-page side="content|sidebar" :slug="…">`:
  il componente CMS legge `config/local/<tenant>/database/content/pages/<slug>.json` e rende i `content_blocks`.
- Mai una Blade per singola pagina di contenuto, mai un resolver di tipo nel tema; un layout nuovo e' un blocco riusabile.
- Niente controller per il front office: routing Folio, interattivita' Volt o widget dei moduli.

## Alternative scartate

- **Blade dedicate per pagine "speciali"**: iterazione piu' rapida all'inizio, poi pagine che divergono dal resto e dal JSON.
- **`content-resolver` nel tema**: il tema torna a conoscere i tipi di contenuto; ogni tipo nuovo richiede codice.
- **Controller + rotte**: duplicano Folio e spargono la definizione delle pagine.

## Conseguenze

- Pro: una sola pipeline di rendering; le pagine si cambiano dai JSON, con review e senza deploy del tema.
- Contro: blocchi molto specifici (es. prenotazione di un evento) devono comunque diventare blocchi riusabili.
- Debito: `app/Providers/ThemeServiceProvider.php` registra ancora `POST /events/{slug}/book` verso
  `Http/Controllers/EventBookingController.php`, che dipende da `Modules\Meetup\Models\Event` (modulo non presente in ogni
  installazione) e scrive nel DB fuori da un'Action (vedi [contratti](../contracts/README.md)). Due pagine dichiarano lo
  stesso nome di rotta `profile.view` (`pages/profile/[id].blade.php` e `pages/profile/[slug0]/index.blade.php`).

## Verifica

`Themes/Meetup/tests/Unit/PagesAndAuthFormsContractTest.php` (sorgente, senza app: `vendor/bin/pest Themes/Meetup/tests`)
fallisce se una delle quattro pagine generiche smette di usare `<x-page` o reintroduce `content-resolver`. Che non nascano
Blade per singole pagine di contenuto e' solo revisione.
