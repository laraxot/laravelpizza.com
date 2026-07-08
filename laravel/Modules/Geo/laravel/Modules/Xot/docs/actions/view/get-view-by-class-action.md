# GetViewByClassAction

`GetViewByClassAction` is a Spatie Queueable Action that converts a PHP class name into a Filament view path.

## Logic
The action performs the following steps:
1.  Extracts the module name from the namespace (e.g., `Modules\Geo\...` -> `geo`).
2.  Identifies the component path after the standard namespace (e.g., `...\Filament\Forms\Components\MapPicker`).
3.  Converts the path segments to kebab-case and slugs.
4.  Optionally removes suffixes if they match the singular form of the parent directory (e.g., `Components\Component` -> `Components`).
5.  Checks for view existence in the following order:
    - `pub_theme::{path}` (Theme override)
    - `{module}::{path}` (Module default)

## Usage
Used by `XotBaseField` and `XotBaseWidget` for automatic view resolution.

```php
$view = app(GetViewByClassAction::class)->execute(static::class);
```
