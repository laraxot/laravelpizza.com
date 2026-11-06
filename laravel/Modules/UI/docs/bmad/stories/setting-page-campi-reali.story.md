---
title: SettingPage di UI con campo reale
status: done
module: UI
type: story
created: 2026-11-04
related:
  - ../../../../Xot/docs/bmad/stories/setting-page-campi-reali.story.md
  - ./setting-page.story.md
---

# SettingPage di UI con campo reale

## Fase BMAD

Build. Contratto e matrice: story madre in Xot. Supera [setting-page](./setting-page.story.md) ("pagina senza campi").

## Campo esposto

| Campo | Default | Lettore | Decisione |
|-------|---------|---------|-----------|
| `dark_mode_switcher_enabled` | `true` | `app/Filament/Widgets/DarkModeSwitcherWidget.php` `canView()` (e, per questa via, `app/View/Components/DarkModeSwitcher.php`, che chiama `canView()`) | esposto. Era `config('ui.dark_mode_switcher.enabled', true)`; `ui.dark_mode_switcher.enabled` diventa `dark_mode_switcher_enabled` (nessun file tenant definiva la chiave) |

Altro configurabile nel modulo: niente. L'unico altro `config('ui.…')` e' `config('ui.name')` in
`resources/views/index.blade.php` (il nome del modulo, non un'impostazione) e il resto sono `config('app.*')` e
`config('metatag.*')`, che appartengono ad altri moduli. La durata del cookie `dark_mode` (30 giorni) e' scritta nel
widget e non passa da config: non e' un'impostazione esistente, resta fuori.

## Campi di Codex sostituiti

Il working tree conteneva `dark_mode` (default `false`) e `compact_navigation` (default `false`), aggiunti senza lettore:
`grep` su Modules, Themes e resources non trova nessun punto che legga `compact_navigation`, e `dark_mode` e' solo il
nome del cookie del widget, non una chiave di config. Inoltre il default reale del selettore e' `true`, non `false`.
Rimossi entrambi, sostituiti da `dark_mode_switcher_enabled`.

## Lettori cambiati

- `app/Filament/Widgets/DarkModeSwitcherWidget.php`: `canView()` legge `UIConfigData::make()->dark_mode_switcher_enabled`
  (prima `config()`, che con `config:cache` non vedrebbe un valore salvato).

## Test e gate

- `tests/Unit/Datas/UIConfigDataTest.php` (esteso, 8 test, 2 gia' esistenti): default `true`, override del tenant, file
  mancante, `DarkModeSwitcherWidget::canView()` segue il valore salvato, chiavi dello schema uguali alle proprieta' della
  Data, etichette `it` e `en`. Rosso prima (5 su 8), verde dopo.
- `tests/Support/FakeTenantUiConfig.php` (nuovo): seam di test. Il contenitore risolve `GetTenantConfigArrayAction`,
  quindi si sostituisce l'istanza e `UIConfigData::make()` legge un file finto.
- `UiGapCloser100Test` (usa il widget): 13 test verdi.
- PHPStan livello max: 0 errori sui file toccati. Pint: pulito.
