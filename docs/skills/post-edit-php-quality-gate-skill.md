# Skill Operativa: Post-Edit PHP Quality Gate

## Trigger

Usare questa skill dopo aver modificato qualsiasi file `.php` in moduli o temi.

## Procedura

1. Identificare il modulo del file modificato.
2. Eseguire PHPStan sul perimetro minimo affidabile:
   ```bash
   cd laravel && ./vendor/bin/phpstan analyse Modules/{NomeModulo} --memory-limit=-1
   ```
3. Eseguire PHPMD sul perimetro minimo affidabile:
   ```bash
   cd laravel && ./vendor/bin/phpmd Modules/{NomeModulo}/app text cleancode,codesize,controversial,design,naming,unusedcode
   ```
4. Eseguire PHPInsights sul perimetro minimo affidabile:
   ```bash
   cd laravel && ./vendor/bin/phpinsights analyse Modules/{NomeModulo}
   ```
5. Verificare se esiste il test Pest associato al file modificato.
6. Se il test non esiste e il file e' testabile: crearlo.
7. Eseguire il test e verificare verde:
   ```bash
   cd laravel && ./vendor/bin/pest Modules/{NomeModulo}/tests/...
   ```
8. Se ci sono errori: correggerli prima di considerare il task completato.
9. Se uno strumento manca o fallisce per motivi infrastrutturali, registrarlo esplicitamente e non ometterlo.
10. Non dichiarare mai "finito" senza evidenza dei comandi eseguiti (`phpstan`, `phpmd`, `phpinsights`, `pest`).

## Checklist minima

- [ ] PHPStan: 0 errori nel modulo coinvolto
- [ ] PHPMD: nessun violation critico
- [ ] PHPInsights: score >= 90
- [ ] Test Pest: esiste e passa
- [ ] Se test mancava: creato e verde

## File testabili (obbligatorio)

- `Actions/` — unit test per `execute()`
- `Models/` — relazioni, cast, business logic
- `Services/` — comportamenti pubblici
- `Traits/` — metodi esposti
- `Datas/` — costruzione DTO, validazione

## Riferimento regola

`docs/rules/post-edit-php-quality-gate-rule.md`
