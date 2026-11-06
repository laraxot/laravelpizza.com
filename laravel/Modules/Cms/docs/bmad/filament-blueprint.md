---
title: "Filament Blueprint — Cms"
type: filament-blueprint
status: active
module: Cms
created: 2026-10-16
updated: 2026-10-20
tags: [bmad, filament, blueprint, cms]
qmd: "filament blueprint cms xotbase resource widget"
related:
  - ../bmad-planning.md
  - ../bmad-brainstorming.md
---

# Scopo

Contratto Filament del modulo **Cms**: chrome BO e/o widget FO senza violare
i confini di dominio.

## Regole non negoziabili

1. Estendere solo `XotBaseResource` / `XotBaseWidget` / basi Xot — mai classi Filament dirette.
2. Nessun `->label()` hardcoded: chiavi in `lang/<locale>/` del modulo.
3. Business logic nelle Actions del modulo, non nei form hooks grassi.
4. FO: widget montati esplicitamente; non abusare `discoverWidgets` per chrome.
5. Liste FO via Folio shell del tema + JSON del tenant. La cartella è il contenitore,
   lo slug nel file è l'ultimo pezzo (`pages/services/index.json` → `services.index`,
   `pages/services/view.json` → `services.view`, `pages/area-personale/pratiche.json` →
   `area-personale.pratiche`). `PageResource` edita quei JSON; il tema non reinventa
   match/`@include` nativi.
   Canon: [json-content-slug-uniqueness.md](../json-content-slug-uniqueness.md),
   tema [container0-index-shell-contract.md](../../../../Themes/Sixteen/docs/bmad/container0-index-shell-contract.md).

## Resource / widget

- `PageResource`
- `SectionResource`
- `MenuResource`

## Form / Table / Infolist

Preferire triad schema dedicati (`*Form`, `*Table`, `*Infolist`) quando la Resource
cresce oltre pochi campi. Enum tipizzati al posto di option array.

## Policy e tenant

Ogni query Filament rispetta tenant + policy del modello owner. Nessun elenco
cross-tenant per comodita admin.

## PHPStan

Test business e Resource CMS: helper su `TestCase` static, no mix Pest chain che crasha `pest-plugin-phpstan`. Gate unico: `cd laravel && ./vendor/bin/phpstan analyse Modules` a **zero** (`laravel/phpstan.neon` solo; agenti mai ignore/baseline).

Prima del fix: scopo pagina/Resource in questo blueprint → chiamanti → causa tipizzata; **non zittire** l'errore.

Track: [phpstan-modules-zero-standing-order](../../../Xot/docs/wiki/memories/phpstan-modules-zero-standing-order.md), [00-start.md](../../../../../bashscripts/docs/prompts/00-start.md#ordine-permanente-dellutente), [11-phpstan.md](../../../../../bashscripts/docs/prompts/11-phpstan.md). Resource: solo [XotBaseResource](../../../Xot/app/Filament/Resources/XotBaseResource.php) — ratchet [NeverExtendFilamentDirectlyTest.php](../../../Xot/tests/Unit/Filament/NeverExtendFilamentDirectlyTest.php).

## Related

- Planning: [bmad-planning.md](../bmad-planning.md)
- Brainstorming: [bmad-brainstorming.md](../bmad-brainstorming.md)
