---
title: "Language switcher presentation contract"
type: contract
qmd: "language switcher presentation contract"
---
# Language switcher presentation contract

```yaml
type: presentation-contract
owner: Modules\Lang\View\Components\LanguageSwitcher
input: current application locale and configured supported locales
output: accessible locale dropdown with localized href values
```

## Invariants

- `LANG-SWITCHER-001`: each supported locale is rendered as a normal anchor.
- `LANG-SWITCHER-002`: links use the widget's localized URL and do not require a Livewire component context.
- `LANG-SWITCHER-003`: the current locale is marked with `aria-current="page"`.

## Errors and fallbacks

The widget falls back to `/{locale}` when localization cannot create a URL. The view must remain renderable as a normal Blade component; `$this` and `wire:click` are not presentation dependencies.

## Non-goals

This component does not persist locale preferences or implement locale selection business logic.
