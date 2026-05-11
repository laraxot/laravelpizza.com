# XotBaseField View Resolution Rule

## Rule
Classes extending `Modules\Xot\Filament\Forms\Components\XotBaseField` **MUST NOT** define a `protected string $view` property.

## Motivation
Manually defining the view path is redundant and prevents the theme from overriding the view. `XotBaseField` automatically resolves the view using `GetViewByClassAction`, which checks for theme-specific overrides.

## How it works
The `getView()` method in `XotBaseField` is implemented as follows:

```php
public function getView(): string
{
    return app(GetViewByClassAction::class)->execute(static::class);
}
```

## Theme Overrides
To override a view in a theme (e.g., `Sixteen`), create the blade file in:
`Themes/Sixteen/resources/views/filament/forms/components/{kebab-case-component-name}.blade.php`
The system will automatically pick up the theme version if it exists.
