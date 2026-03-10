# IDE Helper Models Governance

## Regola locale

Nel progetto Laraxot il comando canonico per riallineare i PHPDoc dei model e':

```bash
cd laravel && php artisan ide-helper:models -W
```

## Perche'

- i model usano attributi dinamici, relazioni e connessioni multiple;
- PHPStan, IDE e i reviewer umani dipendono da PHPDoc aggiornati;
- il run reale distingue problemi del codice da limiti del sandbox.

## Nota operativa

Se il primo run mostra errori di connessione su alias come `activity`, `tenant`, `xot`, non assumere subito che il model sia rotto: ripetere con accesso DB reale e verificare se rimangono classi non analizzabili.

## Esito consolidato 2026-03-10

- `php artisan ide-helper:models -W` con accesso DB reale ha completato la wave senza `Could not analyze class`;
- i PHPDoc dei model sono stati rigenerati correttamente sui moduli attivi;
- il problema osservato nel sandbox era infrastrutturale, non applicativo.
