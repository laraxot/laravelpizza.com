---
id: bmad-phpstan-user-contract-fix
track: bmad-v6.3
module: User
epic: 9
title: "PHPStan User — UserContract + debito Livewire"
status: done
related:
  - ./decision-log.md
  - ./tech-spec-superadmin-widget.md
  - ./ux-design.md
---

# PHPStan User — chiusura

Gate: `cd laravel && vendor/bin/phpstan analyse Modules/User` (livello **max** da `phpstan.neon`, mai `--level`).

## Perché

Il leaf auth è `XotData::make()->getUserClass()` (spesso `Modules\Quaeris\Models\User`). I trait e i test del modulo User non possono chiudere i tipi su `Modules\User\Models\User`.

## Cosa è stato allineato

| Gruppo | File | Fix |
|--------|------|-----|
| A — contratto | `HasTeams.php` | return type sul contratto, non sulla classe foglia |
| B — debito Livewire | `routes/web_tall.php`, widget Auth, test TeamChange | gemelli Livewire → widget Filament |
| C — Action | `DeleteUserAction` | PHPDoc + `getAttribute` string-safe |
| D — identità nei test | `SuperAdminWidgetTest` Feature | `assertInstanceOf(UserContract::class)` |

## Fuori da questo file

CloudStorage factories e Job config: altri moduli, altre docs.

## Verifica

```bash
cd laravel
vendor/bin/phpstan analyse Modules/User --memory-limit=-1
```
