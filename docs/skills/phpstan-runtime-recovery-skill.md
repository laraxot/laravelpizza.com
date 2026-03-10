# phpstan-runtime-recovery-skill.md

## Obiettivo

Ripristinare un run PHPStan eseguibile senza violare le regole del progetto.

## Workflow

1. Verificare `phpstan.neon`.
2. Controllare che `tmpDir` non punti a `/tmp`.
3. Spostare il runtime dir in `laravel/storage/app/phpstan` o percorso equivalente nel repo.
4. Rieseguire PHPStan con:
   `XDEBUG_MODE=off ./vendor/bin/phpstan analyse ... --memory-limit=-1 --no-progress`
5. Se il problema resta, registrare il blocker infrastrutturale in docs e GitHub tracking.

## Regole

- non usare `/tmp`;
- non modificare il livello PHPStan per aggirare il problema;
- distinguere sempre tra crash di bootstrap del tool e veri errori statici del codice.
