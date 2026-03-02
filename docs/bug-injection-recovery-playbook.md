# Bug Injection Recovery Playbook

Playbook per risolvere bug e file infetti introdotti deliberatamente. Seguire sempre l'ordine indicato.

## Principio Fondamentale

**NO FIX SENZA ANALISI CAUSA RADICE.** Sintomi ≠ causa. Ogni fix deve essere basato su comprensione.

## Fase 1: Triage Rapido (5 min)

### Comandi diagnostici immediati

```bash
cd laravel

# PHPStan - errori di tipo/sintassi
./vendor/bin/phpstan analyse --memory-limit=-1 2>&1 | head -80

# Test - fallimenti funzionali
php artisan test --compact 2>&1 | tail -50

# Pint - sintassi/formattazione
./vendor/bin/pint --test 2>&1 | head -30

# Log Laravel
tail -100 storage/logs/laravel.log
```

### Identificare il layer colpito

| Sintomo | Layer probabile | Doc da consultare |
|---------|-----------------|-------------------|
| ParseError, Class not found | PHP/Composer | composer-packages-reference, namespace |
| View not found, pub_theme | CMS/Theme | chaos-monkey-recovery-playbook |
| 404, route non trovata | Folio/Routing | folio-routing-locale |
| SQLSTATE, constraint | Database | migration-patterns |
| Test falliti | Business logic | systematic-debugging-laravel |
| Filament error | Admin | filament-* rules |

## Fase 2: Analisi Causa Radice

### Workflow obbligatorio

1. **Leggere messaggio di errore completo** - non solo la prima riga
2. **Stack trace** - identificare il file e la riga esatta
3. **Modifiche recenti** - `git status`, `git diff`
4. **Doc del modulo** - `Modules/{Modulo}/docs/` prima di toccare codice
5. **Pattern working** - cercare codice simile che funziona

6. **Dependency map** - verificare dipendenze e pacchetti runtime-critical: [dependencies](./dependencies.md)

### Domande da porsi

- Quale file/riga ha introdotto il problema?
- È un errore di sintassi, tipo, logica o configurazione?
- Esiste documentazione per questo pattern?
- Quale regola Laraxot potrebbe essere violata?

## Fase 3: Fix Minimale

### Regole del fix

- **Un fix per volta** - non bundlare miglioramenti
- **Reversibile** - fix che si può annullare facilmente
- **Documentato** - aggiornare docs subito dopo
- **Testato** - PHPStan + Pint + test mirati

### Anti-pattern da evitare

- "Quick fix for now, investigate later"
- Aggiungere `@phpstan-ignore` senza capire
- Usare `mixed` o `array` senza tipizzazione
- Saltare l'aggiornamento della documentazione

## Fase 4: Verifica e Documentazione

### Checklist post-fix

```bash
./vendor/bin/phpstan analyse Modules/{Modulo} --memory-limit=-1
./vendor/bin/pint --dirty
php artisan test --filter={test_pertinente}
```

### Documentazione obbligatoria

1. Aggiornare `docs/` del modulo più vicino
2. Se emerge pattern/anti-pattern: creare/aggiornare rule `.cursor/rules/*.mdc`
3. Se emerge memoria utile: aggiornare `.cursor/memories/*.md`

## Riferimenti Rapidi

### Skills da applicare

- **laraxot-bugfix-workflow** - Ordine: docs → analisi → fix → verifica → docs
- **systematic-debugging-laravel** - 4 fasi: Root Cause → Pattern → Hypothesis → Implementation
- **error-resolution-process** - Processo completo con documentazione

### Playbook per dominio

| Dominio | Playbook |
|---------|----------|
| CMS/Theme | [chaos-monkey-recovery-playbook](../Modules/Cms/docs/chaos-monkey-recovery-playbook.md) |
| Theme Meetup | [chaos-monkey-theme-recovery-playbook](../Themes/Meetup/docs/chaos-monkey-theme-recovery-playbook.md) |
| Tenant | [chaos-monkey-tenant-isolation-checklist](../Modules/Tenant/docs/chaos-monkey-tenant-isolation-checklist.md) |
| Eventi Meetup | [chaos-monkey-event-rendering-playbook](../Modules/Meetup/docs/chaos-monkey-event-rendering-playbook.md) |

### Comandi di recovery emergenza

```bash
# Cache e config
php artisan optimize:clear
php artisan config:clear
php artisan view:clear

# Theme assets
cd Themes/Meetup && npm run build && npm run copy

# Composer
cd laravel && composer dump-autoload
```

## Collegamenti

- [error-resolution-process](../../.cursor/rules/error-resolution-process.mdc)
- [chaos-monkey-readiness](../.agents/docs/agents-guide/15-chaos-monkey/chaos-monkey-readiness.md)
- [build-lint-test-commands](../.agents/docs/agents-guide/02-tooling/build-lint-test-commands.md)
