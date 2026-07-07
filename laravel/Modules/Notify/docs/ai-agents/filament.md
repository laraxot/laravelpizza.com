# Filament (Claude)

## Absolute rule

Application modules must not extend Filament classes directly.

Use Laraxot wrappers from `Modules\Xot\...` (XotBase*).

## Laraxot rules

- Never extend Filament classes directly in application modules: use `XotBase*` wrappers.
- Never use `->label()`, `->placeholder()`, `->helperText()` in components: handled by LangServiceProvider translation system.
- Treat `Filament\\Forms\\Components\\Placeholder` as legacy/deprecated:
  - structured read-only data -> `Filament\\Infolists\\Components\\*`
  - static/editorial content -> `Filament\\Schemas\\Components\\*`
- Translation keys use pattern: `{module}::resource.fields.{field_name}.{type}` (e.g., `user::client.fields.name.label`)
- Use indexed arrays for form schemas instead of associative arrays

## Available XotBase classes

- `XotBaseResource` - for all Filament resources
- `XotBase{Create|Edit|List...}Record` - for standard pages
- `XotBaseWidget` - for widgets
- `XotBaseSection` - for form sections

## Form Schema Patterns

```php
// ❌ Wrong (associative array)
[
    'name' => TextInput::make('name')->required(),
]

// ✅ Correct (indexed array)
[
    TextInput::make('name')->required(),
]
```

## MCP Integration with Filament

When working with protected Filament files:
1. Use MCP tools to access protected Filament files
2. Reference `laravel/.mcp.json` for configuration
3. Apply Filament best practices even when working indirectly
4. Test component functionality after MCP-based changes

## Links

- [Claude docs index](./context.md)
- [Filament rules prompt](../../bashscripts/tools/prompts/filament-rules.md)
- [General docs](../../docs/README.md)
