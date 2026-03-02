# Gdpr Module - Code Coverage

## Percentuale coverage

**~8%** (stima su suite root: 2 test)

## Contesto misurazione

- **Suite eseguita**: `tests/Unit` + `tests/Feature` (root)
- **Test moduli**: i test in `Modules/Gdpr/tests/` non sono inclusi nella suite PHPUnit
- **File analizzati**: solo `Modules/Gdpr/app/`

## Riflessioni

1. **Modello GDPR**: Profile, Consent, Event, Treatment; BaseModel/BasePivot/BaseMorphPivot e RouteServiceProvider risultano coperti.
2. **Punti coperti**: pagine Create/Edit Filament per Consent, Event, Profile, Treatment.
3. **Gap principali**: RegisterWidget, SaveGdprConsents listener, Policies, trait HasGdpr.
4. **Priorità**: coprire flusso registrazione con consensi; listener SaveGdprConsents; Policies.

## Comando verifica

```bash
cd laravel && php artisan test --coverage --min=0
```

## Collegamenti

- [gdpr-overview](../gdpr-overview.md)
