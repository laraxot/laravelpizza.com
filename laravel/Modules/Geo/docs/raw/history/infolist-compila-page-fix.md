# Filament v5 custom page infolist pattern (XotBasePage)

## Scope
Custom pages extending `XotBasePage` that render both form and read-only blocks.

## Rule
For read-only content in custom pages, use infolist schema method and render it in Blade.

### Use
```php
public function infolist(Schema $schema): Schema
{
    return $schema->record($this->record)->components([...]);
}
```

### In Blade
```blade
{{ $this->infolist }}
{{ $this->form }}
```

## Do not
- Do not override `form(Schema $schema)` if base page declares it `final`.
- Do not mix incompatible trait/property compositions that redeclare `$record` differently.

## Why
- Keeps clear separation: infolist for read-only, form for editable fields.
- Prevents `Property [$infolist] not found` runtime issues.
- Prevents final-method override fatals.

## Reference implementation
- `Modules/IndennitaResponsabilita/app/Filament/Resources/IndennitaResponsabilitaResource/Pages/CompilaIndennitaResponsabilita.php`
- `Modules/IndennitaResponsabilita/resources/views/filament/resources/indennita-responsabilita/pages/compila.blade.php`
