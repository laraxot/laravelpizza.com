# Lang Module - Code Coverage

## Percentuale coverage

**~4%** (stima su suite root: 2 test)

## Contesto misurazione

- **Suite eseguita**: `tests/Unit` + `tests/Feature` (root)
- **Test moduli**: i test in `Modules/Lang/tests/` non sono inclusi nella suite PHPUnit
- **File analizzati**: solo `Modules/Lang/app/`

## Riflessioni

1. **Modulo i18n**: LangServiceProvider, traduzioni, localizzazione; coverage basso.
2. **Punti coperti**: pagine Create/Edit Filament, RouteServiceProvider, TranslatorTrait.
3. **Gap principali**: LangServiceProvider, AutoLabelAction, trait, Filament AdminPanelProvider.
4. **Priorità**: coprire LangServiceProvider e AutoLabelAction; poi trait e panel.

## Comando verifica

```bash
cd laravel && php artisan test --coverage --min=0
```

## Collegamenti

- [laravel-localization-mcamara-reference](../laravel-localization-mcamara-reference.md)
