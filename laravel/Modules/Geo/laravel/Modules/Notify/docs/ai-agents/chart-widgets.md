# Chart widgets (Chart.js + Filament v5)

## Centralized plugin registration

Chart.js plugins / JS assets are registered **only** in `Modules/Chart`. Other modules only configure options.

## getOptions() return type

- `getOptions()` must return an **array**.
- Use `RawJs::make(<<<'JS' ... JS)` only for callbacks/formatters.

## Nowdoc for JS callbacks

Do not use multiline single-quoted PHP strings for JS callbacks: use nowdoc/heredoc.
