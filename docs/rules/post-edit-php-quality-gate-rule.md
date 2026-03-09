# Post-Edit PHP Quality Gate Rule

## Regola vincolante

Dopo aver modificato qualsiasi file `.php`, prima di considerare il lavoro completato,
eseguire obbligatoriamente la quality gate completa sul file o modulo coinvolto.

## Quality gate obbligatoria (ordine)

### 1. PHPStan Level 10

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/{NomeModulo} --memory-limit=-1
```

Output atteso: `[OK] No errors`

### 2. PHPMD (PHP Mess Detector)

```bash
cd laravel
./vendor/bin/phpmd Modules/{NomeModulo}/app text cleancode,codesize,controversial,design,naming,unusedcode
```

Output atteso: nessun violation segnalato.

### 3. PHPInsights

```bash
cd laravel
./vendor/bin/phpinsights analyse Modules/{NomeModulo}
```

Output atteso: score >= 90 su tutti gli assi (Code, Complexity, Architecture, Style).

### 4. Test Pest associato

Se il file modificato e' "testabile" (Actions, Models, Services, Traits, Data):

- Verificare se esiste il test Pest associato in `Modules/{Nome}/tests/`
- Se non esiste: crearlo
- Eseguire il test e verificare che sia verde

```bash
cd laravel
./vendor/bin/pest Modules/{NomeModulo}/tests/Unit/path/al/test/FileTest.php
```

## Cosa e' "testabile"

Sono testabili obbligatoriamente:

- `Actions/` — ogni action ha un test Unit
- `Models/` — business logic, relazioni, cast
- `Services/` — ogni service ha un test Unit
- `Traits/` — ogni trait ha un test Unit
- `Datas/` — DTO, costruzione, validazione
- `Rules/` — custom validation rules

Non richiedono test obbligatori (ma possono averli):

- `Providers/` — testati indirettamente
- `Migrations/` — verificate da `migrate --env=testing`
- `Filament/` — complessi da testare in unit, preferire feature tests

## File di riferimento

- PHPStan workflow: `docs/rules/phpstan-workflow.md`
- Testing standards: `docs/rules/testing-standards.md`
- Pre-edit rule: `docs/rules/pre-edit-docs-first-rule.md`
- Skill operativa: `docs/skills/post-edit-php-quality-gate-skill.md`
