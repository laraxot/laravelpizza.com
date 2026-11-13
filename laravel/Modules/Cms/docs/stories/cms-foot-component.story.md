---
title: "[STORY] Componente Foot canonico per la coda del documento"
type: story
module: Cms
status: implemented
priority: high
created: 2026-11-09
updated: 2026-11-09
tags: [bmad, ecc, cms, blade, foot, scripts, document-shell, twentyone]
related:
  - "../foot-component-architecture.md"
  - "./seo-head-component.story.md"
---

# [STORY] Componente Foot canonico per la coda del documento

## Scopo

Se esiste `<x-cms::head />` per `<head>`, deve esistere `<x-cms::foot />`
per il contenuto di coda del `<body>`: script e stack in un unico punto di
verita' del modulo Cms, cosi' ogni tema non duplica piu' la coda.

**Correzione (stessa sessione)**: `foot.blade.php` emetteva `</body></html>`
— tag di chiusura per elementi aperti dal layout, non dal componente.
Frammento strutturalmente non valido: la chiusura del documento e'
tornata nel layout (`base`, `components/layouts/app`), Foot emette solo
contenuto.

## Problema risolto

- Coda documento duplicata in `TwentyOne/layouts/base.blade.php` e
  `components/layouts/app.blade.php` (notifiche, filament scripts, vite,
  yield).
- **Bug latente**: nessun layout Ventuno emetteva `@stack('scripts')`:
  tutti i `@push('scripts')` di Predict/Cms/Geo (price-chart,
  trading-form, rules-faq, calendar, menu builder) non venivano mai renderizzati.
- `@vite` del tema con nome cablato (`'themes/TwentyOne'`) in ogni layout:
  diverge dal `pubTheme` dinamico gia' usato da `cms::head`.

## Acceptance criteria

- [x] `Modules/Cms/app/View/Components/Foot.php` + `resources/views/components/foot.blade.php`.
- [x] Registrazione esplicita in `CmsServiceProvider` (`cms::foot`) e `_components.json`.
- [x] Tema risolto da `MetatagData::getPubTheme()` — stessa sorgente di Head.
- [x] `@stack('scripts')` + `@yield('scripts')` emessi a fine body.
- [x] `@livewire('notifications')`, `@filamentScripts`, `@vite` JS prima degli stack.
- [x] Layout Ventuno (`app`, `base`) usano `<x-cms::foot />` e chiudono `</body></html>` nel layout.
- [x] PHPStan level 10 pulito sui file toccati; `/it` HTTP 200 con script Livewire/Filo
      e bundle tema presenti nel DOM.

## Note

- `@livewireScripts` non serve: `livewire.inject_assets=true`.
- Gli script Alpine che servono prima di `alpine:init` restano responsabilita'
  del tema (vedi `Sixteen/docs/wiki/concepts/livewire-alpine-esm-order.md`).
