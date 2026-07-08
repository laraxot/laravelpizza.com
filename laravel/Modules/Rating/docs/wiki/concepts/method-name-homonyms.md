---
title: "censimento omonimi metodi — modulo Rating"
type: analysis
module: Rating
updated: 2026-06-15
related:
  - ../../../../../../docs/wiki/method-name-homonym-census.md
  - ../../../../../../bashscripts/docs/method-homonym-census.json
---

# Censimento omonimi metodi — Rating

> **41** nomi metodo omonimi coinvolgono questo modulo (su 689 totali progetto).

## Riepilogo categoria (solo Rating)

| Categoria | Metodi |
|-----------|--------|
| `A_filament_framework` | 22 |
| `E_scheda_stack` | 1 |
| `F_trait_name_collision` | 9 |
| `H_cross_module_homonym` | 9 |

## Dettaglio

### `A_filament_framework` (22 metodi)

Hook Filament/Laravel ripetuti — **non** debito. Elenco omesso.

### `E_scheda_stack`

#### `getActions` — 6 classi

- `Rating` · `EditRatingMorph` · `Modules/Rating/app/Filament/Resources/RatingMorphResource/Pages/EditRatingMorph.php`
- `Rating` · `ListRatingMorphs` · `Modules/Rating/app/Filament/Resources/RatingMorphResource/Pages/ListRatingMorphs.php`
- `Rating` · `EditRating` · `Modules/Rating/app/Filament/Resources/RatingResource/Pages/EditRating.php`

### `F_trait_name_collision`

#### `ratings` — 3 classi

- `Rating` · `trait:HasRating` · `Modules/Rating/app/Models/Traits/HasRating.php`
- `Rating` · `trait:HasRatingsTrait` · `Modules/Rating/app/Models/Traits/HasRatingsTrait.php`
- `Rating` · `trait:RatingTrait` · `Modules/Rating/app/Models/Traits/RatingTrait.php`

#### `getMyRatingAttribute` — 2 classi

- `Rating` · `trait:HasRatingsTrait` · `Modules/Rating/app/Models/Traits/HasRatingsTrait.php`
- `Rating` · `trait:RatingTrait` · `Modules/Rating/app/Models/Traits/RatingTrait.php`

#### `getRatingsAvgAttribute` — 2 classi

- `Rating` · `trait:HasRatingsTrait` · `Modules/Rating/app/Models/Traits/HasRatingsTrait.php`
- `Rating` · `trait:RatingTrait` · `Modules/Rating/app/Models/Traits/RatingTrait.php`

#### `getRatingsCountAttribute` — 2 classi

- `Rating` · `trait:HasRatingsTrait` · `Modules/Rating/app/Models/Traits/HasRatingsTrait.php`
- `Rating` · `trait:RatingTrait` · `Modules/Rating/app/Models/Traits/RatingTrait.php`

#### `myRatings` — 2 classi

- `Rating` · `trait:HasRatingsTrait` · `Modules/Rating/app/Models/Traits/HasRatingsTrait.php`
- `Rating` · `trait:RatingTrait` · `Modules/Rating/app/Models/Traits/RatingTrait.php`

#### `ratingAvgHtml` — 2 classi

- `Rating` · `trait:HasRatingsTrait` · `Modules/Rating/app/Models/Traits/HasRatingsTrait.php`
- `Rating` · `trait:RatingTrait` · `Modules/Rating/app/Models/Traits/RatingTrait.php`

#### `ratingObjectives` — 2 classi

- `Rating` · `trait:HasRatingsTrait` · `Modules/Rating/app/Models/Traits/HasRatingsTrait.php`
- `Rating` · `trait:RatingTrait` · `Modules/Rating/app/Models/Traits/RatingTrait.php`

#### `scopeWithRating` — 2 classi

- `Rating` · `trait:HasRatingsTrait` · `Modules/Rating/app/Models/Traits/HasRatingsTrait.php`
- `Rating` · `trait:RatingTrait` · `Modules/Rating/app/Models/Traits/RatingTrait.php`

#### `setMyRatingAttribute` — 2 classi

- `Rating` · `trait:HasRatingsTrait` · `Modules/Rating/app/Models/Traits/HasRatingsTrait.php`
- `Rating` · `trait:RatingTrait` · `Modules/Rating/app/Models/Traits/RatingTrait.php`

### `H_cross_module_homonym`

#### `fromArray` — 23 classi

- `Rating` · `RatingData` · `Modules/Rating/app/Datas/RatingData.php`

#### `user` — 9 classi

- `Rating` · `RatingMorph` · `Modules/Rating/app/Models/RatingMorph.php`

#### `getSlugOptions` — 4 classi

- `Rating` · `BaseRating` · `Modules/Rating/app/Models/BaseRating.php`

#### `getStats` — 4 classi

- `Rating` · `StatsOverview` · `Modules/Rating/app/Filament/Resources/HasRatingResource/Widgets/StatsOverview.php`
- `Rating` · `StatsOverview` · `Modules/Rating/app/Filament/Widgets/StatsOverview.php`

#### `profile` — 3 classi

- `Rating` · `RatingMorph` · `Modules/Rating/app/Models/RatingMorph.php`

#### `scopeWithExtraAttributes` — 3 classi

- `Rating` · `BaseRating` · `Modules/Rating/app/Models/BaseRating.php`

#### `configureEmailVerification` — 2 classi

- `Rating` · `EventServiceProvider` · `Modules/Rating/app/Providers/EventServiceProvider.php`

#### `model` — 2 classi

- `Rating` · `RatingMorph` · `Modules/Rating/app/Models/RatingMorph.php`

#### `registerMediaConversions` — 2 classi

- `Rating` · `BaseRating` · `Modules/Rating/app/Models/BaseRating.php`




## Rigenerazione

```bash
python3 bashscripts/tools/census-method-homonyms.py
```
