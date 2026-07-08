---
title: "PHPStan Remediation Swarm — Lessons"
type: concept
tags: [phpstan, larastan, remediation, xot, techplanner]
created: 2026-06-06
updated: 2026-06-06
qmd: "phpstan remediation swarm TechPlanner main_module XotData Larastan BelongsTo Profile"
issues:
  - "https://github.com/laraxot/module_xot_fila5/issues/28"
discussions:
  - "https://github.com/laraxot/module_xot_fila5/discussions/29"
related:
  - ../concepts/phpstan-fixes-log.md
  - ../concepts/phpstan-cluster-map-and-false-friends.md
  - ../troubleshooting/phpstan-perfection-guide.md
  - ../memories/INDEX.md
---

# PHPStan Remediation Swarm — Lessons

Runbook for the recurring **30-error tail** seen in swarm PHPStan passes on TechPlanner (`phpstan-run5` pattern). Fixes target root cause, not baselines or `@phpstan-ignore`.

## 1. Bootstrap: pin `main_module` to TechPlanner

**Symptom:** `class.notFound` — Blog models report `@property … $deleter` referencing `Modules\Fixcity\Models\Profile`.

**Root cause:** Larastan resolves `Updater::deleter()` / `creator()` / `updater()` via `XotData::getProfileClass()` at analysis time. A stale or cross-tenant `main_module` points at a module that is not in this mono-repo.

**Fix:** In `laravel/phpstan_bootstrap.php`, after Laravel boot:

```php
config(['xra.main_module' => 'TechPlanner']);
// reset XotData::$instance singleton, then XotData::make()
```

**Lesson:** PHPStan bootstrap is part of the tenant contract — not optional. TechPlanner Profile lives in `Modules\TechPlanner\Models\Profile`.

## 2. `HasDynamicFillable` — no `??` on declared arrays

**Symptom:** `nullCoalesce.property` on `$this->dynamicFillableEnums ?? null`.

**Fix:** Models using the trait must declare `protected array $dynamicFillableEnums = []`. Guard with `property_exists` + `is_array`, then assign without coalesce.

**Lesson:** Optional trait properties are a contract — empty array default beats nullable coalesce for PHPStan max.

## 3. `EnumTrait::getColumnNames()` — list keys

**Symptom:** `return.type` — expects `array<int, string>`, returns `array<string>`.

**Fix:** `return array_values(array_map(...))`.

## 4. Lang files — duplicate top-level keys

**Symptom:** `array.duplicateKey` in `Modules/UI/lang/{it,en}/auth.php`.

**Fix:** One top-level `'profile'` block only; nested menu labels stay under `user_dropdown.profile` / `navigation.profile` (different paths, not duplicate root keys).

## 5. `GeoTrait` — Safe JSON + SQL typing

| Issue | Fix |
|-------|-----|
| `theCodingMachineSafe.function` on `json_decode` | `use function Safe\json_decode;` + try/catch in `isJsonString()` |
| `varTag.nativeType` on `@var literal-string` | Remove incorrect `@var`; use bound parameters in `whereRaw($sql, [$pointWkt])` instead of string-interpolated WKT |

## 6. Notify enums — `getLabel()` in `mapWithKeys`

**Symptom:** `method.notFound` for `::label()` and unresolved `TMapWithKeysValue`.

**Fix:** Enums use `EnumTrait::getLabel()`, not Filament's `label()`. Typed callback:

```php
->mapWithKeys(static function (NotificationTypeEnum $type): array {
    return [$type->value => $type->getLabel()];
})
```

## 7. Filament widgets — `view-string`

**Symptom:** `SocialShareWidget::$view` default not accepted as `view-string` when set explicitly.

**Fix:** Rely on `XotBaseWidget::resolveView()` + `GetViewByClassAction` (view at `seo::filament.widgets.social-share`). Do not duplicate a string `$view` default unless it is a class constant PHPStan can narrow.

## 8. `BuildTimelineVisualizationAction` — Carbon vs string

**Symptom:** `format()` on `Carbon|string` for `WorkHour::$timestamp`.

**Fix:** Rely on model `casts()` (`datetime`) and `@property Carbon $timestamp`; avoid union in session block arrays (`startTime` / `endTime` as `Carbon` only).

## 9. `HasGdpr::getMissingRequiredConsents()` — `array_diff` types

**Symptom:** `argument.type` — second array not `list<string>`.

**Fix:** `Assert::allString($givenConsents)` after `pluck()->all()`, then `array_values(array_diff(...))`.

## 10. `MediaResource::getPages()` — drop sealed psalm shape

**Symptom:** Child returns `view` + `convert` keys; strict `@psalm-return array{index, create, edit}` on override fails `return.type`.

**Fix:** Use `@return array<string, PageRegistration>` on the resource override (same as `XotBaseResource`). Do **not** seal parent shape — Job/User resources add custom keys (`board`, `preview`, `time-clock`).

## Verification command

```bash
cd laravel
./vendor/bin/phpstan clear-result-cache
./vendor/bin/phpstan analyse --no-progress
```

Target: **0 errors**, empty baseline.

## False friends (do not “fix”)

- Do not replace `ProfileContract` PHPDoc with concrete Fixcity class — fix bootstrap `main_module`.
- Do not add `@phpstan-ignore` for Safe functions — import Safe variants.
- Do not widen enum unions to silence `mapWithKeys` — type the callback return `array<string, string>`.
