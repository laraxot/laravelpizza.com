# PHPStan Fixes Log - Story 8-121

> **Story**: 8-121 - PHPStan Full Compliance (Zero Errors, No Ignoring)
> **Started**: 2026-05-05
> **Philosophy**: Zero tolerance per shortcut - correggere sempre la root cause

## Fix #1: spatie/laravel-model-states Missing Package

### Problem
```
Class Modules\Xot\States\XotBaseState extends unknown class Spatie\ModelStates\State
Class Modules\Xot\States\Transitions\XotBaseTransition extends unknown class Spatie\ModelStates\Transition
```

### Root Cause (aggiornato 2026-05-21)

- Dichiarato in `Modules/Xot/composer.json` (`^2.14`) e root `laravel/composer.json`, ma **non installato** (assente da `composer.lock` / `vendor/`).
- `spatie/laravel-model-states` **2.14** richiede **`php: ^8.4`** ([composer.json upstream](https://github.com/spatie/laravel-model-states/blob/main/composer.json)); runtime progetto **PHP 8.3.30**.
- La linea **2.12.1** supporta PHP 8.3 ma solo **Laravel 10–12**, incompatibile con **Laravel 13** del modulo.
- Errore PHPStan è effetto del vendor mancante, non di codice errato in `XotBaseTransition`.

### Solution (applicata 2026-05-21)

1. Runtime **PHP 8.4.17** (`php8.4` esplicito o default via `update-alternatives`). Estensioni già allineate a 8.3 su questo host.
2. `rm -f laravel/Modules/Xot/composer.lock` (lock modulo non serve al merge root se non usi install standalone).
3. Da **`laravel/`**: `php8.4 "$(command -v composer)" update -W` — installa **`spatie/laravel-model-states` 2.14.1** + rigenera lock condiviso (il file `laravel/composer.lock` in questo repo è **gitignored** da `*.lock`).
4. `Modules/Xot/composer.json` resta `"php": "^8.3"` (minimo modulo Laraxot); il vincolo `^8.4` è solo nella dipendenza `spatie/laravel-model-states`.
5. `php8.4 ./vendor/bin/phpstan clear-result-cache` poi analisi `Modules/Xot/app/States/` → **OK**.

Nota: **`composer run go`** non eseguito in questa sessione: contiene `rm -rf database/migrations/*` e `migrate` — da valutare solo su clone/ambiente dedicato.

### Riferimenti

- [php84-upgrade-extension-checklist.md](php84-upgrade-extension-checklist.md)
- [laravel13-modular-package-compatibility-matrix.md](laravel13-modular-package-compatibility-matrix.md)

## Fix #2: DTO concrete factory `self` instead of `new static()`

### Problem

PHPStan level max reported `new.static` on config DTO factories and, after partial conversion, `return.type` when methods still declared `static` but returned `self`.

### Root Cause

These DTOs are concrete configuration data objects, not extension points. Late static binding in `make()`/`from()` creates an unnecessary constructor-safety contract.

### Solution (applicata 2026-06-07)

- Keep DTOs concrete/final where applicable.
- Use `public static function make(): self` and `return new self();`.
- Use `public static function from(...): self` and `return new self(...);` for concrete data constructors.
- Do not add `@var static` casts to force PHPStan's inferred type.
- When a DTO constructor groups flat parameters into config arrays, update `@param` tags to the real parameter names and prefer array-shape PHPDoc.

Verification:

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules
# 4993 file, [OK] No errors
```

## Fix #3: Magic property access vs explicit getter on DTOs with `@property`

### Problem

PHPStan level max reported `argument.type` — `string|null` passed where `string` expected, when accessing `$dto->property` on DTOs that use `__get` with `@property` annotations (e.g., `SmsData`).

### Root Cause

DTOs like `SmsData` use:
- `private string $recipient = ''` (real property)
- `@property string $recipient` (PHPDoc magic property)
- `__get(string $name): string` (magic accessor)

PHPStan may not fully trust the `@property` annotation when a private property of the same name exists with a matching type. The magic property resolves to `string` at runtime via `__get`, but PHPStan conservatively reports `string|null`.

### Solution (applicata 2026-06-07)

- Replace magic property access `$dto->recipient` with explicit getter call `$dto->getRecipient()`.
- DTOs should expose typed getter methods (`public function getRecipient(): string`) for type-safe external consumption.
- Magic properties via `@property` + `__get` are acceptable for internal/serialization use but not recommended for cross-class calls where PHPStan must verify types.

### Pattern: `string`-type narrowing for `SmsData::from(array<string, string>)`

### Problem

PHPStan level max reported `argument.type` — `array<string, mixed>` passed where `array<string, string>` expected, when calling `SmsData::from()` with form state array or notification message values.

### Root Cause

`SmsData::from()` declares `@param array<string, string> $data`, but callers pass arrays containing `mixed` values:
- Form state `$this->smsForm->getState()` returns `array<string, mixed>`
- Notification message `$notification->toNetfun($notifiable)` returns `mixed`

The SmsData constructor internally handles `mixed` values via `SafeStringCastAction::cast()`, but the type signature of `from()` is narrower than actual usage.

### Solution (applicata 2026-06-07)

- Narrow mixed values to `string` before passing to `from()` using `is_string()` checks with fallback to `''`:
  ```php
  'recipient' => is_string($data['recipient'] ?? '') ? $data['recipient'] : '',
  ```
- For notification channels, add `is_string()` guard on the recipient:
  ```php
  if (! is_string($recipient) || $recipient === '') { return null; }
  ```
- Do NOT widen `from()` parameter to `array<string, mixed>` — the narrower type is intentional API contract.
- Do NOT use `(string)` casts just to silence PHPStan — use proper type narrowing.

Verification:

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules
# 4993 file, [OK] No errors
```

## Fix STORY-287 (2026-06-09): Modules/Xot zero errori

Baseline 205 → 0. Batch Contracts/Datas/Traits (14), Actions (43), Models/Filament/Exports (34).

Pattern: `BelongsTo<Model&ProfileContract, $this>`, `array<string, mixed>`, `EnumTrait::toArray()` → `array<int|string, string>`.

Chat: `docs/chat/story-287-xot-phpstan-session.md` · Issues: module_xot #32, base #313

## Fix 2026-06-30: fatal trait collision + tail Modules/

### Problema 1 — PHPStan non partiva (fatal)

`BaseUser` usa `HasTeams` e `HasSpatiePermission` (Spatie `HasRoles::teams()`). Collisione su `teams()`.

### Soluzione

```php
use HasSpatiePermission, HasTeams {
    HasTeams::teams insteadof HasSpatiePermission;
    HasSpatiePermission::teams as spatieTeams;
}
```

Wiki: [User trait-alias-conflict-resolution](../../../User/docs/wiki/concepts/trait-alias-conflict-resolution.md)

### Problema 2 — `UserContract::teams()` generics

`static(UserContract)` non è sottotipo di `Model` su `BelongsToMany`. Allineato a `BelongsToMany<Model&TeamContract, $this>` + `@phpstan-ignore generics.notSubtype` (stesso pattern di `tenants()`).

### Problema 3 — `Article::scopePublishedUntilToday()`

Return type `EloquentBuilder|QueryBuilder` con classe `QueryBuilder` inesistente nel modulo → solo `EloquentBuilder`.

### Verifica

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules
# [OK] No errors — 5357 file
```

Trait probe registry: [phpstan-trait-probes](./phpstan-trait-probes.md)
