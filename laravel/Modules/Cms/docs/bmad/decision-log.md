---
title: "Decision log — Cms"
type: decision-log
module: Cms
status: active
created: 2026-10-16
updated: 2026-10-26
tags: [bmad, decision-log, cms]
qmd: "decision log cms"
related:
  - ../bmad-planning.md
  - ../bmad-brainstorming.md
  - ./project-context.md
---

# Decision log — Cms

## 2026-10-20 — Gate PHPStan Modules zero; Filament blueprint SSoT UI admin

- **Decisione:** gate `analyse Modules` a zero; `PageResource` / JSON tenant e liste FO si allineano a [filament-blueprint.md](./filament-blueprint.md) (XotBase, Lang, niente label hardcoded).
- **Track:** [phpstan-modules-zero-standing-order](../../../Xot/docs/wiki/memories/phpstan-modules-zero-standing-order.md).

## 2026-10-16 — Kit BMAD owner

- **Decisione:** adottare `docs/bmad-planning.md` + `docs/bmad-brainstorming.md` + `docs/bmad/filament-blueprint.md` come SSoT di planning per questo owner.
- **Perche:** rimuovere stub copiati "Ticket Timeline" non pertinenti; allineare second brain e Filament blueprint allo scopo reale.
- **Track:** `bmad-method`

## 2026-10-18 — PHPStan su test Pest senza excludePaths

- **Decisione:** nei `*BusinessLogicTest.php` usare solo `PHPUnit\Framework\Assert`; niente chain `expect()` che triggerano `Internal error` di `pest-plugin-phpstan`.
- **Perche:** un crash dell'estensione blocca `phpstan analyse Modules/Cms` per intero; escludere i test non è accettabile.
- **Doc:** [testing.md](../testing.md), campagna Notify [phpstan-pest-patterns-modulo-notify.md](../../../Notify/docs/wiki/memories/phpstan-pest-patterns-modulo-notify.md).

## 2026-10-20 — PHPStan swarm e ordine permanente

- **Decisione:** il modulo Cms partecipa al gate unico `analyse Modules` con helper test su `TestCase` static tipizzato (pattern Lang/Cms/User); ogni turn non banale esegue la catena PHPStan → sorgente → docs senza conferma.
- **Perche:** `pest-plugin-phpstan` e test misti PHPUnit/Pest bloccano l'intero albero se non si corregge alla fonte; escludere path non e' accettabile.
- **Track:** [11-phpstan.md](../../../../../bashscripts/docs/prompts/11-phpstan.md), [filament-blueprint](./filament-blueprint.md), memoria [phpstan-modules-zero-standing-order](../../../Xot/docs/wiki/memories/phpstan-modules-zero-standing-order.md).

## 2026-10-26 - DCP-283: fail-closed, allowlist e niente esecuzione dinamica (C-03, C-04, C-08)

- **Decisione C-03:** `PageSlugMiddleware` e' fail-closed. Un errore nel trovare la pagina, nel leggere o validare il campo `middleware` risponde 503 (log con slug, nomi e tipo di errore, mai IP/utente/percorso). I middleware ammessi sono solo `cms.config.page_middleware_allowlist` (default `auth`, `throttle`, i soli usati dai JSON). Una classe scritta nel JSON non viene piu' eseguita.
- **Decisione C-04:** `ResolvePageAction` carica un modello solo per `blog`/`events` e per i contenitori in `cms.config.container0_models` (default vuoto), con `resolveRouteBinding()` e `Gate::allows('view')`. Tolti ramo `profile`, euristica del singolare, `newQueryWithoutScopes`, query grezza. `/it/profile/<uuid>` e `/it/user/<uuid>` ora danno 404 (prima 200 anche a un ospite).
- **Decisione C-08:** `NotificationTemplate::compileString` non usa piu' `Blade::render` (eseguiva PHP dal database): `RenderNotificationTemplateStringAction` sostituisce solo segnaposto (`{{ $name }}`, `{{name}}`, `{{ user.address.city }}`), escapati. Il resto resta testo con `Log::warning`.
- **Da decidere (titolare/Notify):** quali costrutti in piu' (`route()`, `@lang`, `localizeURL`) servono ai template di produzione, non visibili da qui (0 template in sviluppo). Proposta: leggere il warning dopo il deploy e aggiungere solo i costrutti visti, ognuno con un test.
- **Perche:** il default "tutto e' ammesso" e la tolleranza applicata alla protezione hanno reso pubbliche pagine protette; il dato editabile (JSON, template) non deve poter scegliere cosa viene eseguito o caricato.
- **Doc:** [story DCP-283](../stories/dcp-283-chiusura-dei-punti-aperti-di-esecuzione-dinamica-e-fail-open.story.md), [cms-page-middleware-json-ssot](../wiki/concepts/cms-page-middleware-json-ssot.md).
