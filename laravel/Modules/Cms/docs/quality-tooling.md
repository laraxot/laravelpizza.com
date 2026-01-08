# Code Quality Tooling (CMS Module)

## Goals
- Individuare code smells e mantenerne la correzione senza rompere il runtime.
- Allineare stile e regole a LARAXOT e Filament v4.
- Mantenere PHPStan livello 9 a 0 errori.

## Tools
- PHPMD, Laravel Pint / PHP-CS-Fixer, Psalm (facoltativo), Actionlint.

## Riferimenti
- PHPMD: https://phpmd.org/
- JetBrains integrazioni: PHPMD/CS-Fixer/Pint/Psalm
- Gist best practices: https://gist.github.com/slayerfat/2b3cc4faf94d2863b505
- CodeRabbit: PHPMD/Actionlint

---

## Safe Execution (READ-ONLY prima)
- Scope modulo: `laravel/Modules/Cms/`
- Escludere: `vendor,node_modules,storage,bootstrap`

### PHPMD
```bash
./vendor/bin/phpmd Modules/Cms/app text cleancode,codesize,controversial,design,naming,unusedcode \
  --suffixes php --exclude vendor,node_modules,storage,bootstrap --strict
```

### Pint / CS-Fixer
```bash
./vendor/bin/pint Modules/Cms -v --test
# oppure
./vendor/bin/php-cs-fixer fix Modules/Cms --dry-run --diff
```

### Psalm (facoltativo)
```bash
./vendor/bin/psalm --no-cache --stats --show-info=false --root=Modules/Cms \
  --report=Modules/Cms/docs/psalm-report.json
```

### Actionlint (CI)
```bash
actionlint -color
```

---

## Workflow Locale
1. PHPMD read-only → log in `Modules/Cms/docs/phpmd-report.txt`.
2. Pint/CS-Fixer read-only → poi applicare in scope modulo.
3. Re-run PHPStan L9 → deve restare 0.
4. Smoke test UI: rendering blocchi/section e pagine.

---

## Note LARAXOT/Filament
- Usare `XotBaseResource`/`XotBasePage`, niente `->label()/->tooltip()/->placeholder()`.
- `getFormSchema()` nelle Resource; niente `table()` nelle Resource.

---

## Manutenzione
- Documentare i refactor guidati da PHPMD in `Modules/Cms/docs/`.
