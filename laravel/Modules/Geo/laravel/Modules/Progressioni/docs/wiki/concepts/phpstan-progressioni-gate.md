---
title: gate phpstan progressioni
type: concept
tags: [phpstan, progressioni, sigma, ptv, criteri-esclusione]
created: 2026-06-15
updated: 2026-06-15
qmd: "phpstan progressioni gate assenza getRouteParameters hasMany ofRangeDate whereRaw"
related:
  - ../../../../Ptv/docs/wiki/concepts/phpstan-scheda-actions.md
  - ../../../../Sigma/docs/wiki/concepts/asz-scheda-relationship.md
  - ../../../../Xot/docs/wiki/concepts/get-route-parameters-helper.md
  - ../../../../../docs/wiki/rules/eloquent-relationship-encapsulation.md
  - ../index.md
---

# Gate PHPStan — Modulo Progressioni

## Scopo

Il modulo Progressioni orchestra schede annuali, criteri di esclusione e relazioni Sigma (ASZ, qua00f, rep00f). PHPStan livello max deve restare **0** sui moduli in scope di `laravel/phpstan.neon` senza baseline né ignore.

## Verifica

```bash
cd laravel
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules --no-progress
```

## Pattern applicati (2026-06-15)

| Area | Problema | Fix |
|------|----------|-----|
| `Assenza` vs `Assenze` | PHPDoc e trait puntavano a classe inesistente | `@property Collection<int, Assenza>`; relazione `assenze()` già su `Assenza::class` |
| `getActivitylogOptions()` | `spatie/activitylog` non in vendor | Rimosso override su `Progressioni` (trait `LogsActivity` disabilitato in `BaseScheda`) |
| `hasMany($classString)` | `class-string` non narrowed | `Assert::subclassOf($class, Model::class)` + `@var class-string<Model>` |
| `ofRangeDate()` | Ymd come `string` | Cast `(int) Carbon::format('Ymd')` in `TrovaEsclusiAction` |
| `whereRaw()` dinamico | Richiede `literal-string` | Bindings `whereRaw('...?', [$val])` o closure con parametri |
| `getRouteParameters()` | Helper documentato ma assente | Implementato in `Modules/Xot/helpers/Helper.php` (scan PHPStan) |
| `RefreshHaDirittoAction` | `Collection` covarianza su `Check::execute` | `Check` accetta `Collection` non generica; query diretta `CriteriOption` |
| `SchedaContract::asz()` | PHPStan su catena scope | `@method HasMany<Asz00k1, Model> asz()` su contratto; implementazione in `BaseScheda::asz()`; action **`$scheda->asz()->ofRangeDate()`** |

## Consumer principali

- **`RefreshHaDirittoAction`** — reset campi + `Ptv\Actions\CriteriEsclusione\Check` su `Progressioni` record.
- **`TrovaEsclusiAction`** — batch esclusi; catena `$scheda->asz()->ofRangeDate()`.
- **`Scheda::updateFields`** — contesto route (`anno`, `stabi`, `repar`) via `getRouteParameters()`.
- **Blade legacy** `resources/views/admin_test/**` — link `route(..., getRouteParameters())`.

## Collegamenti

- [Helper getRouteParameters](../../../../Xot/docs/wiki/concepts/get-route-parameters-helper.md)
- [Relazione ASZ Sigma](../../../../Sigma/docs/wiki/concepts/asz-scheda-relationship.md)
- [Inventario PHPStan root](../../../../../docs/wiki/memories/phpstan-modules-inventory.md)
