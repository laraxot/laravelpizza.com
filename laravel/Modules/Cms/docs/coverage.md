# Cms Module - Code Coverage

## Percentuale coverage

**~3%** (stima su suite root: 2 test)

## Contesto misurazione

- **Suite eseguita**: `tests/Unit` + `tests/Feature` (root)
- **Test moduli**: i test in `Modules/Cms/tests/` non sono inclusi nella suite PHPUnit
- **File analizzati**: solo `Modules/Cms/app/`

## Riflessioni

1. **Modulo core**: Cms gestisce pagine, blocchi, Folio/Volt; il coverage basso riflette l'assenza dei test Cms nella suite globale.
2. **Punti coperti**: `LinkData`, `NavbarMenuData`, `ThemeData`, `BaseController`, pagine Create/Edit Filament, `Appearance` cluster.
3. **Gap principali**: Actions (ResolvePage, ResolveBlockQuery, GetCmsView), blocchi Filament, middleware, componenti Volt.
4. **Priorità**: coprire `ResolvePageAction`, `ResolveBlockQueryAction`; poi blocchi e middleware Folio.

## Comando verifica

```bash
cd laravel && php artisan test --coverage --min=0
```

## Collegamenti

- [content-blocks-system](../content-blocks-system.md)
- [folio-routing-locale](../folio-routing-locale.md)