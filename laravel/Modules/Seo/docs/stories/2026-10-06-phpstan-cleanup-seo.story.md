---
title: "[STORY] PHPStan cleanup — Seo"
type: story
module: Seo
status: done
priority: medium
created: 2026-10-06
updated: 2026-10-06
tags: [phpstan, cleanup, bmad, seo]
---

# [STORY] PHPStan cleanup — Seo

## User Request

«sistema tutte le segnalazioni di phpstan [...] concentrati sullo scopo/funzionalità, non sull'errore; aumenta la qualità del codice; usa enum al posto delle costanti».

Perimetro: segnalazioni PHPStan (level max) del modulo Seo. Errori di partenza: 1 `missingType.iterableValue` in `SocialShareWidgetTest` (classe anonima). Nessuna modifica al codice applicativo.

## Analysis

**Scopo del codice.** `SocialShareWidget` costruisce i link di condivisione (facebook, twitter, linkedin, whatsapp, telegram, copy) e li espone alla vista tramite
`getViewData()` (protetto). Il test lo espone con una sottoclasse anonima `exposeViewData(): array` (docblock `@return array<string, mixed>` corretto).

L'errore non e' nel widget ne' nel docblock: e' il comportamento di PHPStan con le classi anonime (vedi Lessons Learned nella dev story Learned nella dev story). La sottoclasse e' diventata la fixture con nome
`tests/Fixtures/ExposedSocialShareWidget.php` (la cartella `tests/Fixtures` non esisteva nel modulo; autoload-dev `Modules\Seo\Tests\` -> `tests/`).
Le asserzioni del test sono invariate.

## Acceptance Criteria

- [x] Il test del widget non usa classi anonime con tipi iterabili
- [x] Nessuna modifica al codice di produzione
- [x] PHPStan: 0 errori sul modulo Seo (run per path e run completo)

## GitHub (tracciamento)

- Issue: TODO (gh non installato su questa macchina)
- Discussion: TODO

Dev story: [2026-10-06-phpstan-cleanup-seo.dev.md](./2026-10-06-phpstan-cleanup-seo.dev.md)
