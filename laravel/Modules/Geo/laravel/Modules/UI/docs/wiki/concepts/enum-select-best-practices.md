---
title: EnumSelect Best Practices
---

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
- `docs/wiki/concepts/filament5-section-namespace.md`
- `docs/wiki/concepts/filament5-infolist-wizard-summary.md`
- `memory/feedback_filament5_section_namespace.md`
