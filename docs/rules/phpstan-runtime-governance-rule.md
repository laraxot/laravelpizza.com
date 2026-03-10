# PHPStan Runtime Governance Rule

## Regola

Nel progetto PHPStan non deve usare `/tmp` come `tmpDir`.

La cache/runtime directory di PHPStan deve stare dentro il repository, in un path persistente e condiviso dal workspace, per esempio:

- `laravel/storage/app/phpstan`

## Motivazione

- `/tmp` e' vietato nei workflow del progetto;
- i path fuori repo rendono meno riproducibili i run degli agenti;
- in questo ambiente PHPStan puo' fallire prima dell'analisi con errori infrastrutturali, quindi il runtime va mantenuto il piu' stabile possibile.

## Fallback operativo

Se `./vendor/bin/phpstan analyse ...` fallisce prima di analizzare il codice, usare come tentativo minimo:

```bash
XDEBUG_MODE=off ./vendor/bin/phpstan analyse Modules --memory-limit=-1 --no-progress
```

Se anche questo fallisce, il problema va tracciato come blocker infrastrutturale e riportato con evidenza reale.
