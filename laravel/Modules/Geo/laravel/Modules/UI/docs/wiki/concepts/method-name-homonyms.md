---
title: "censimento omonimi metodi — modulo UI"
type: analysis
module: UI
updated: 2026-06-15
related:
  - ../../../../../../docs/wiki/method-name-homonym-census.md
  - ../../../../../../bashscripts/docs/method-homonym-census.json
---

# Censimento omonimi metodi — UI

> **45** nomi metodo omonimi coinvolgono questo modulo (su 689 totali progetto).

## Riepilogo categoria (solo UI)

| Categoria | Metodi |
|-----------|--------|
| `A_filament_framework` | 14 |
| `E_scheda_stack` | 3 |
| `G_module_local` | 7 |
| `H_cross_module_homonym` | 21 |

## Dettaglio

### `A_filament_framework` (14 metodi)

Hook Filament/Laravel ripetuti — **non** debito. Elenco omesso.

### `E_scheda_stack`

#### `before` — 14 classi

- `UI` · `UiBasePolicy` · `Modules/UI/app/Models/Policies/UiBasePolicy.php`

#### `getHeaderWidgets` — 13 classi

- `UI` · `Dashboard` · `Modules/UI/app/Filament/Pages/Dashboard.php`

#### `validate` — 8 classi

- `UI` · `OpeningHoursRule` · `Modules/UI/app/Rules/OpeningHoursRule.php`

### `G_module_local`

#### `getRatioClass` — 3 classi

- `UI` · `Image` · `Modules/UI/app/Filament/Blocks/Image.php`
- `UI` · `ImagesGallery` · `Modules/UI/app/Filament/Blocks/ImagesGallery.php`
- `UI` · `VideoSpatie` · `Modules/UI/app/Filament/Blocks/VideoSpatie.php`

#### `getRatios` — 3 classi

- `UI` · `Image` · `Modules/UI/app/Filament/Blocks/Image.php`
- `UI` · `ImagesGallery` · `Modules/UI/app/Filament/Blocks/ImagesGallery.php`
- `UI` · `VideoSpatie` · `Modules/UI/app/Filament/Blocks/VideoSpatie.php`

#### `exportData` — 2 classi

- `UI` · `InteractiveMap` · `Modules/UI/app/Livewire/Components/Map/InteractiveMap.php`
- `UI` · `NullMapService` · `Modules/UI/app/Services/Map/NullMapService.php`

#### `getSuggestions` — 2 classi

- `UI` · `InteractiveMap` · `Modules/UI/app/Livewire/Components/Map/InteractiveMap.php`
- `UI` · `NullGeocodingService` · `Modules/UI/app/Services/Map/NullGeocodingService.php`

#### `normalizeViewData` — 2 classi

- `UI` · `ResolveLocalizedBlockDataAction` · `Modules/UI/app/Actions/Block/ResolveLocalizedBlockDataAction.php`
- `UI` · `Block` · `Modules/UI/app/View/Components/Render/Block.php`

#### `stateClass` — 2 classi

- `UI` · `IconStateGroupColumn` · `Modules/UI/app/Filament/Tables/Columns/IconStateGroupColumn.php`
- `UI` · `IconStateSplitColumn` · `Modules/UI/app/Filament/Tables/Columns/IconStateSplitColumn.php`

#### `toggleDarkMode` — 2 classi

- `UI` · `DarkModeSwitcherWidget` · `Modules/UI/app/Filament/Widgets/DarkModeSwitcherWidget.php`
- `UI` · `DarkModeSwitcher` · `Modules/UI/app/Http/Livewire/DarkModeSwitcher.php`

### `H_cross_module_homonym`

#### `active` — 10 classi

- `UI` · `BaseModelFactory` · `Modules/UI/database/factories/BaseModelFactory.php`

#### `getData` — 8 classi

- `UI` · `StatWithIconWidget` · `Modules/UI/app/Filament/Widgets/StatWithIconWidget.php`
- `UI` · `TestChartWidget` · `Modules/UI/app/Filament/Widgets/TestChartWidget.php`

#### `getType` — 8 classi

- `UI` · `TestChartWidget` · `Modules/UI/app/Filament/Widgets/TestChartWidget.php`

#### `getColumns` — 7 classi

- `UI` · `HeroWidget` · `Modules/UI/app/Filament/Widgets/HeroWidget.php`
- `UI` · `RowWidget` · `Modules/UI/app/Filament/Widgets/RowWidget.php`

#### `inactive` — 7 classi

- `UI` · `BaseModelFactory` · `Modules/UI/database/factories/BaseModelFactory.php`

#### `canView` — 6 classi

- `UI` · `RedirectWidget` · `Modules/UI/app/Filament/Widgets/RedirectWidget.php`

#### `cards` — 4 classi

- `UI` · `RadioCardSelector` · `Modules/UI/app/Forms/Components/RadioCardSelector.php`

#### `getCards` — 4 classi

- `UI` · `RadioCardSelector` · `Modules/UI/app/Forms/Components/RadioCardSelector.php`

#### `getDescription` — 4 classi

- `UI` · `TestChartWidget` · `Modules/UI/app/Filament/Widgets/TestChartWidget.php`

#### `getOptions` — 4 classi

- `UI` · `RadioCollection` · `Modules/UI/app/Filament/Forms/Components/RadioCollection.php`
- `UI` · `TestChartWidget` · `Modules/UI/app/Filament/Widgets/TestChartWidget.php`

#### `getStats` — 4 classi

- `UI` · `HeroWidget` · `Modules/UI/app/Filament/Widgets/HeroWidget.php`

#### `panel` — 4 classi

- `UI` · `AdminPanelProvider` · `Modules/UI/app/Providers/Filament/AdminPanelProvider.php`

_… +9 metodi in questa categoria_




## Rigenerazione

```bash
python3 bashscripts/tools/census-method-homonyms.py
```
