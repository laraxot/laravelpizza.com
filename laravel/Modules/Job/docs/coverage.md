# Job Module - Code Coverage

## Percentuale coverage

**~2%** (stima su suite root: 2 test)

## Contesto misurazione

- **Suite eseguita**: `tests/Unit` + `tests/Feature` (root)
- **Test moduli**: i test in `Modules/Job/tests/` non sono inclusi nella suite PHPUnit
- **File analizzati**: solo `Modules/Job/app/`

## Riflessioni

1. **Modulo job/queue**: monitoraggio job, RouteServiceProvider, EventServiceProvider; coverage basso.
2. **Punti coperti**: pagine Create/Edit Filament, RouteServiceProvider.
3. **Gap principali**: JobServiceProvider, Actions, comandi, widget.
4. **Priorità**: coprire JobServiceProvider e logica core; poi comandi e widget.

## Comando verifica

```bash
cd laravel && php artisan test --coverage --min=0
```

## Collegamenti

- [job-overview](../job-overview.md)
