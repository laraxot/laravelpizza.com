---
title: "corpi metodo duplicati — UI"
type: analysis
module: UI
tags: [dry, duplication, census, refactoring, ui]
created: 2026-07-22
updated: 2026-07-22
qmd: "duplicate method bodies UI identical hash DRY"

related:
  - ../../../../../../docs/wiki/duplicate-method-bodies-census.md
  - ./method-name-homonyms.md
---

# Corpi metodo duplicati — UI

> **19** gruppi con corpo identico coinvolgono UI (su 790 totali progetto).
> Omonimo con corpo **diverso** = configurazione, e' nel [censimento omonimi](./method-name-homonyms.md); qui solo corpi **identici**.

## Riepilogo (solo UI)

| Categoria | Gruppi | ~Righe duplicate |
|-----------|--------|------------------|
| `A_config_identical` | 3 | 22 |
| `B_business_duplicate` | 8 | 88 |
| `S_trivial_stub` | 8 | 19858 |

## Dettaglio

### B — Business logic con corpo identico (consolidare: 1 owner)

#### `normalizeViewData` — 2 classi · 17 righe · ~17 righe duplicate

- `UI` · `ResolveLocalizedBlockDataAction::normalizeViewData` · `Modules/UI/app/Actions/Block/ResolveLocalizedBlockDataAction.php:42`
- `UI` · `Block::normalizeViewData` · `Modules/UI/app/View/Components/Render/Block.php:68`

#### `before` — 3 classi · 7 righe · ~14 righe duplicate

- `UI` · `UiBasePolicy::before` · `Modules/UI/app/Models/Policies/UiBasePolicy.php:21`
- `Activity` · `ActivityBasePolicy::before` · `Modules/Activity/app/Models/Policies/ActivityBasePolicy.php:14`
- `Media` · `MediaBasePolicy::before` · `Modules/Media/app/Models/Policies/MediaBasePolicy.php:14`

#### `getRatios` — 3 classi · 7 righe · ~14 righe duplicate

- `UI` · `Image::getRatios` · `Modules/UI/app/Filament/Blocks/Image.php:39`
- `UI` · `ImagesGallery::getRatios` · `Modules/UI/app/Filament/Blocks/ImagesGallery.php:73`
- `UI` · `VideoSpatie::getRatios` · `Modules/UI/app/Filament/Blocks/VideoSpatie.php:81`

#### `getRatioClass` — 3 classi · 7 righe · ~14 righe duplicate

- `UI` · `Image::getRatioClass` · `Modules/UI/app/Filament/Blocks/Image.php:48`
- `UI` · `ImagesGallery::getRatioClass` · `Modules/UI/app/Filament/Blocks/ImagesGallery.php:82`
- `UI` · `VideoSpatie::getRatioClass` · `Modules/UI/app/Filament/Blocks/VideoSpatie.php:90`

#### `combineStateOptions` — 2 classi · 13 righe · ~13 righe duplicate

- `UI` · `SelectState::combineStateOptions` · `Modules/UI/app/Filament/Forms/Components/SelectState.php:62`
- `UI` · `SelectStateColumn::combineStateOptions` · `Modules/UI/app/Filament/Tables/Columns/SelectStateColumn.php:106`

#### `exportData` — 2 classi · 8 righe · ~8 righe duplicate

- `UI` · `NullMapServiceAdapter::exportData` · `Modules/UI/app/Adapters/Map/NullMapServiceAdapter.php:37`
- `UI` · `NullMapService::exportData` · `Modules/UI/app/Services/Map/NullMapService.php:37`

#### `make` — 2 classi · 5 righe · ~5 righe duplicate

- `UI` · `Children::make` · `Modules/UI/app/Filament/Forms/Components/Children.php:16`
- `UI` · `QrReader::make` · `Modules/UI/app/Filament/Forms/Components/Field/QrReader.php:14`

#### `geocodeAddress` — 2 classi · 3 righe · ~3 righe duplicate

- `UI` · `NullGeocodingServiceAdapter::geocodeAddress` · `Modules/UI/app/Adapters/Map/NullGeocodingServiceAdapter.php:17`
- `UI` · `NullGeocodingService::geocodeAddress` · `Modules/UI/app/Services/Map/NullGeocodingService.php:17`

### A — Hook framework con corpo identico (override ridondante / candidato default XotBase)

#### `render` — 2 classi · 10 righe · ~10 righe duplicate

- `UI` · `WithSidebar::render` · `Modules/UI/app/View/Components/Page/WithSidebar.php:21`
- `UI` · `Std::render` · `Modules/UI/app/View/Components/Std.php:26`

#### `render` — 2 classi · 8 righe · ~8 righe duplicate

- `UI` · `Logo::render` · `Modules/UI/app/View/Components/Logo.php:26`
- `UI` · `Svg::render` · `Modules/UI/app/View/Components/Svg.php:26`

#### `mount` — 2 classi · 4 righe · ~4 righe duplicate

- `UI` · `DarkModeSwitcherWidget::mount` · `Modules/UI/app/Filament/Widgets/DarkModeSwitcherWidget.php:20`
- `UI` · `DarkModeSwitcher::mount` · `Modules/UI/app/Http/Livewire/DarkModeSwitcher.php:14`

### S — Stub banali (≤30 char) — rumore, non debito

8 gruppi — elenco omesso.


## Rigenerazione

```bash
python3 bashscripts/tools/census-duplicate-method-bodies.py
```
