# Claude Audit — modalità static su Modules

> Tool: [claude-audit](https://github.com/itsmesherry/claude-audit) · Comando gratis: `npx claude-audit --static`

## Perché usarlo

Complementa PHPStan L10 (tipi) con euristiche su segreti hardcoded, `console.log` residui, file enormi, nesting profondo e copertura test grezza. **Non sostituisce** PHPStan, PHPMD, PHPInsights, Pest, Playwright.

## Regola Laraxot — interpretazione score

In modalità **`--static`** ogni categoria parte da **80/100** e perde punti per finding:

| Severità | Penalità |
|----------|----------|
| critical | −20 |
| high | −10 |
| medium | −5 |
| low | −2 |

**80/100 con zero finding = massimo raggiungibile in static** (non esiste 100/100 senza API Anthropic / modalità AI).

Obiettivo operativo Laraxot:

- `overallScore >= 80`
- `criticalCount === 0`
- `highCount === 0`

## Comando wrapper progetto

```bash
bash bashscripts/tools/run-claude-audit-modules.sh
bash bashscripts/tools/run-claude-audit-modules.sh --module Geo
bash bashscripts/tools/run-claude-audit-modules.sh --json
```

Report: `laravel/.claude-audit-modules/audit-report.md`

## Pipeline post-edit (obbligatoria)

Dopo ogni modifica PHP/JS in un modulo, da `laravel/`:

```bash
./vendor/bin/phpstan analyse Modules/{Modulo}
php ../bashscripts/tools/phpmd.phar Modules/{Modulo}/app text Modules/{Modulo}/phpmd.ruleset.xml
vendor/bin/phpinsights analyse Modules/{Modulo} --no-interaction
./vendor/bin/pest Modules/{Modulo}/tests
```

UI: Playwright/Puppeteer MCP se il cambio tocca front office.

Poi **commit + push nel repo del modulo** (`cd laravel/Modules/{Modulo} && git push`).

## False positive noti

| Finding | Azione Laraxot |
|---------|----------------|
| Password in test Pest (`RegisterPageTest`) | Usare `Str::password()` — mai stringhe fisse tipo `MySecurePassword123!` |
| `Insufficient Documentation` su `lang/*.php` | Ignorare in static full-scan — i file traduzione non sono codice applicativo |
| `Large File` su array traduzione | Struttura LangServiceProvider — non splittare senza motivo business |
| Script debug in root modulo | Spostare in `docs/raw/root-import/` |

## Root modulo — igiene audit

Prima del commit modulo:

```bash
find . -maxdepth 1 -name '*.txt' -type f    # vuoto
find . -maxdepth 1 -name 'test-*.js' -type f # vuoto — script Playwright ad hoc → docs/raw/
```

Vedi [module-root-cleanup-rules](../../../docs/wiki/rules/module-root-cleanup-rules.md).

## Wave 2026-07-08

- Spostati `Notify/test-homepage*.js`, `screenshot-group-b.js` → `docs/raw/root-import/`
- Spostato `Geo/docs/mysql-db-connector.js` → `docs/raw/root-import/`
- Spostati script audit `Lang/docs/*.php` → `docs/raw/root-import/`
- `Geo/vite.config.js`: import `path` unificato
- `Gdpr/RegisterPageTest`: password dinamica con `Str::password()`
- Wrapper: `bashscripts/tools/run-claude-audit-modules.sh`
- Risultato static (2000 file): **80/100, 0 finding** (= massimo `--static`)

## Collegamenti

- [quality-gate-canonical-commands.md](../../../docs/wiki/concepts/quality-gate-canonical-commands.md)
- [phpstan-code-quality-guide.md](./phpstan-code-quality-guide.md)
- [multi-repo-modules-themes-map.md](../../../docs/wiki/rules/multi-repo-modules-themes-map.md)
