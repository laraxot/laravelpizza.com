---
title: "Topic enum-select"
type: digest
status: active
qmd: "digest ceiling 100 enum-select"
---

# Topic enum-select

Sintesi automatica di 5 documenti (chiave `enum-select`).

## enum-select

_Fonte: `prompts/enum-select.md`_

bmad-create-story Agisci come un senior Laravel engineer specializzato in Filament v5 e Livewire v4 e devi progettare e implementare da zero un componente riutilizzabile chiamato EnumSelect nel namespace Modules\UI\Filament\Forms\Components seguendo rigorosamente le best practices ufficiali e producendo codice production-ready ultra DRY, KISS e clean code; prima di scrivere codice devi studiare attentamente e usare come riferimento primario le fonti ufficiali verificate Filament v5 Select docs https://filamentphp.com/docs/5.x/forms/select
 Filament v5 custom fields https://filamentphp.com/docs/5.x/forms/custom-fields
 Filament v5 forms overview https://filamentphp.com/docs/5.x/forms/overview
 Livewire v4 JavaScript https://livewire.laravel.com/docs/4.x/javascript
 Livewire v4 properties https://livewire.laravel.com/docs/4.x/properties
 Livewire v4 wire:model https://livewire.laravel.com/docs/4.x/wire-model
 Tom Select docs https://tom-select.js.org/docs/
 e devi anche studiare repository e codice reale da cui prendere spunto come Filament core repository https://github.com/filamentphp/filament
 Laravel framework https://github.com/laravel/framework
 e cercare esempi reali di enum UI patterns con Filament e PHP backed enums; il tuo obiettivo è costruire un componente EnumSelect che estende Filament\Forms\Components\Select e che accetta direttamente una enum PHP backed tramite ->enum(MyEnum::class) eliminando boilerplate nei form e centralizzando tutta la logica di mapping valu

## Overview

_Fonte: `wiki/concepts/enum-select-best-practices.md`_

## Overview
`EnumSelect` è un componente riutilizzabile per enum PHP-backed in Filament v5.

## Best Practices
- **Extend `Select`** and keep the component thin; delegate label/icon handling to the enum.
- **Validate enum class** with `enum_exists` and `is_subclass_of(..., BackedEnum::class)`.
- **Support `HasLabel` / `HasIcon`** interfaces; fallback to `label()` / `icon()` methods, then to case name.
- **Enable HTML labels** only when needed via `htmlLabels()` – this automatically disables native select rendering.
- **Use lazy evaluation** (`$this->evaluate($this->enumClass)`) to allow closures.
- **Return empty array** for missing or non‑string enum class to avoid errors.

## Bad Practices
- Hard‑coding label strings inside the component.
- Directly accessing enum cases without validation (may throw errors for non‑backed enums).
- Adding view‑related logic inside the component; keep UI concerns in Blade templates.

## False Friends
- Using `enum(string $enum)` instead of allowing closures; this prevents dynamic enum resolution.
- Calling `$this->native(true)` after setting options – defeats the TOM‑Select HTML mode.
- Assuming `BackedEnum` implements `HasLabel`/`HasIcon`; always check with `instanceof`.

## References
- `bashscripts/ai/wiki/concepts/filament-widgets.md#filament5-section-namespace`
- `docs/wiki/concepts/filament5-infolist-wizard-summary.md`
- `memory/feedback_filament5_section_namespace.md`

## EnumSelect Component Specification

_Fonte: `wiki/concepts/enum-select-component.md`_

## EnumSelect Component Specification

A reusable Iron Select for PHP-backed enums in Filament v5.

**Key Features:**
- : Enums via `->enum(MyEnum::class)`
- : Handles HasLabel/HasIcon interfaces
- : Fallback labels/icons via case name
- : HTML support in labels
- : Tom Select compatibility

**Usage Example:**
```php
use Modules\UI\Filament\Forms\Components\EnumSelect;

EnumSelect::make('type_id')
    ->enum(TicketTypeEnum::class)
    ->required()
    ->searchable()
```

... (continued in next file)

## EnumSelect Contract And False Friends

_Fonte: `wiki/concepts/enum-select-contract-and-false-friends.md`_

# EnumSelect Contract And False Friends

## Context

Durante il lavoro su `Modules\UI\Filament\Forms\Components\EnumSelect` sono emersi errori runtime e di compatibilita' con Filament:

- signature incompatibile di `make()`
- problemi di autoload PSR-4
- rischio di override con visibilita' incompatibile rispetto ai metodi parent

Questa pagina fissa il contratto minimo del componente.

## Best Practices

- Estendere `Filament\Forms\Components\Select` mantenendo compatibilita' totale con la API parent.
- Dichiarare `public static function make(?string $name = null): static`.
- Mantenere **identica** la firma di `enum()` al parent Filament: `enum(string|Closure|null $enum): static`.
- Validare sempre che la classe passata a `->enum()` sia una backed enum esistente.
- Centralizzare nel componente la trasformazione `case -> value/label/icon`.
- Usare fallback deterministici per label e icona:
  - `HasLabel` / `HasIcon` se implementati
  - `label()` / `icon()` se esistono
  - `name` del case come fallback finale
- Tenere il componente DRY: i form devono solo dichiarare `->enum(MyEnum::class)`.
- Prima di chiamare `tryFrom()`, filtrare esplicitamente il valore su `int|string`.
- Usare annotazioni di tipo (`class-string<BackedEnum>`) dove PHPStan non riesce a inferire il contratto.

## Bad Practices

## Overview

_Fonte: `wiki/concepts/enum-select-usage.md`_

## Overview
`EnumSelect` is a reusable Iron Select for PHP-backed enums in Filament v5.

**Key Features:**
- : Enums via `->enum(MyEnum::class)`
- : Handles HasLabel/HasIcon interfaces
- : Fallback labels/icons via case name
- : HTML support in labels
- : Tom Select compatibility

**Usage Example:**
```php
use Modules\UI\Filament\Forms\Components\EnumSelect;
use App\Enums\TicketTypeEnum;

EnumSelect::make('type_id')
    ->enum(TicketTypeEnum::class)
    ->required()
    ->searchable()
    ->preload();
```

## Icon Support
If your enum implements `Filament\Support\Contracts\HasIcon`, you can enable icons:
```php
EnumSelect::make('status')
    ->enum(StatusEnum::class)
    ->icons()
    ->htmlLabels(); // required for icon HTML rendering
