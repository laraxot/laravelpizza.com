# Activity Module - Code Coverage

## Percentuale coverage

**~5%** (stima su suite root: 2 test)

## Contesto misurazione

- **Suite eseguita**: `tests/Unit` + `tests/Feature` (root)
- **Test moduli**: i test in `Modules/Activity/tests/` non sono inclusi nella suite PHPUnit
- **File analizzati**: solo `Modules/Activity/app/` (config, database, resources esclusi)

## Riflessioni

1. **Test moduli isolati**: Activity ha test unit e feature propri; la suite root non li esegue, quindi il coverage globale sottostima il reale.
2. **Punti coperti indirettamente**: `Activity`, `Snapshot`, `RouteServiceProvider`, pagine Create/Edit Filament risultano al 100% quando bootstrap/app carica i moduli.
3. **Gap principali**: Actions (LogActivity, LogModel*, RestoreActivity), Listeners, Policies, trait HasEvents.
4. **Priorità**: coprire `LogActivityAction`, `ActivityLogger` e listener login/logout; poi Policies e trait.

## Comando verifica

```bash
cd laravel && php artisan test --coverage --min=0
```

## Collegamenti

- [testing](../testing/)
- [architecture-reference](../architecture-reference.md)