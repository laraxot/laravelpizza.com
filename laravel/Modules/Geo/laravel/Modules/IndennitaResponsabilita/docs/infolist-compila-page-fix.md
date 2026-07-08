# Compila page: infolist integration fix (Filament v5)

## Context
Page: `CompilaIndennitaResponsabilita`
Route: `/indennitaresponsabilita/admin/indennita-responsabilitas/{record}/compila`

## Symptoms fixed
1. `Property [$infolist] not found on component`
2. Fatal errors caused by incompatible trait/property composition
3. Fatal error from overriding final `form()` in `XotBasePage`

## Root causes
- Mixing multiple infolist patterns (`HasInfolists`/`InteractsWithInfolists`) on a custom page that already uses schema resolution from Filament page base.
- `form(Schema $schema)` override in child page while `XotBasePage::form()` is final.
- Inconsistent schema composition (`components` vs `schema`) in infolist sections.

## Correct pattern for this module
Use schema-based infolist method on the page:

```php
public function infolist(Schema $schema): Schema
{
    return $schema
        ->record($this->getSpecificRecord())
        ->components([
            Section::make('Informazioni Generali')
                ->columns(4)
                ->schema([
                    TextEntry::make('matr'),
                    TextEntry::make('cognome'),
                    TextEntry::make('nome'),
                ]),
        ]);
}
```

And in Blade view:

```blade
{{ $this->infolist }}
{{ $this->form }}
```

## Mandatory rules confirmed
- Do not override `form()` in pages extending `XotBasePage`.
- Keep `getFormSchema()` for editable fields.
- Use infolist for read-only display blocks.
- Keep page view as wrapper rendering component schemas (`$this->infolist`, `$this->form`).

## Quality checks run
- `php -l` on page class and blade: OK
- PHPStan level 10 on affected pages: OK
- PHPMD / PHPInsights: not available in current environment (`vendor/bin` missing)

## Links
- Root guideline: `docs/infolist_compila_page_fix.md`
- Related class: `Modules/Xot/app/Filament/Resources/Pages/XotBasePage.php`
