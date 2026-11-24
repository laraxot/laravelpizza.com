---
title: "ADR — FolioVoltServiceProvider del modulo Cms e' l'unico punto che monta Folio e Volt"
type: decision
module: Cms
tags: [adr, cms, folio, volt, routing, provider]
created: 2026-11-24
updated: 2026-11-24
status: accepted
related:
  - ../../app/Providers/FolioVoltServiceProvider.php
  - ../bmad/folio-volt-sole-owner.md
---

# ADR: `FolioVoltServiceProvider` del modulo Cms e' l'unico punto che monta Folio e Volt

## Contesto

- Le pagine del front office arrivano da piu' sorgenti: `resources/views/pages` del tema attivo (`pub_theme`, per ogni
  locale), `resources/views/pages` di ogni modulo abilitato, `pages/api` con prefisso `/api`.
- L'installer di Laravel Folio genera `app/Providers/FolioServiceProvider.php`; documenti vecchi lo citavano come owner.
  Due provider che montano Folio = rotte duplicate o in ordine diverso a seconda dell'ordine di boot (vedi
  `../bmad/folio-volt-sole-owner.md`).

Domanda: chi registra i percorsi Folio e Volt?

## Decisione

- Solo `Modules\Cms\Providers\FolioVoltServiceProvider` (`app/Providers/FolioVoltServiceProvider.php`), registrato dal
  modulo Cms: monta in `booted()` le pagine del tema per locale, quelle dei moduli e `pages/api`, e fa `Volt::mount` sugli
  stessi percorsi.
- Non esiste `App\Providers\FolioServiceProvider`; i provider dei moduli non chiamano `Folio::path`.

## Alternative scartate

- Provider Folio dell'applicazione (default dell'installer): un secondo cervello di routing fuori dai moduli, ignaro di tema
  e locali.
- Un `Folio::path` in ogni modulo: stessa logica di locale e middleware ripetuta N volte.

## Conseguenze

- Pro: un solo posto per ordine, locali e middleware delle pagine.
- Contro: Folio dipende dal modulo Cms; senza Cms non ci sono pagine.
- Chi aggiunge pagine a un modulo le mette in `resources/views/pages` del modulo, senza toccare provider.
- Violazione aperta (misurata il 2026-11-24): `laravel/app/Providers/FolioServiceProvider.php` esiste (monta
  `resources/views/pages`) anche se non e' elencato in `bootstrap/providers.php`; il test qui sotto e' rosso finche' non
  viene rimosso.

## Verifica

- `Modules/Cms/tests/Unit/Providers/FolioVoltSoleOwnerTest.php`: `app/Providers/FolioServiceProvider.php` non esiste e
  `FolioVoltServiceProvider` c'e'.
- Solo revisione: `grep -rn "Folio::path" laravel/Modules/*/app/Providers` trova solo `FolioVoltServiceProvider`.
