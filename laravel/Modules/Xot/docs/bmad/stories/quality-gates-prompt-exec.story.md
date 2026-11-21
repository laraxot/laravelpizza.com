---
type: note
tags: [documentation]
issues: []
discussions: []
id: "xot-quality-gates-prompt-exec"
title: "Esegui e migliora 03-quality-gates.md"
status: review
scope: bashscripts+Notify
created: 2026-09-22
updated: 2026-09-22
qmd: "quality gates prompt phpmd-ruleset pint parallel session files nested git pest skip"
related:
  - ../../../../../../bashscripts/docs/prompts/03-quality-gates.md
  - ../../stories/3.30.quality-gates-prompt-improve-and-exec.story.md
  - ../../../../../../docs/wiki/memories/03-quality-gates-workflow.md
  - ./cleanup-all-modules.story.md
---

# Esegui + migliora `03-quality-gates.md`

**Perché.** Il prompt è la legge operativa dei gate. Se i comandi al suo interno sono falsi, ogni agente fallisce lo stesso modo (PHPMD “Cannot find phpmd.xml”, Pint `--parallel` morto, dirty list della mother che non vede i moduli).

## Claim

- Agent: cursor-80f4250a
- Task: quality-gates-exec
- **STOP sul file prompt:** `03-quality-gates.md.lock` vivo (claude-sonnet-5, `quality-gates-exec-improve`, 18:53). Non rubato. Le correzioni sotto sono il patch da applicare.

## Esecuzione (SESSION_FILES Notify)

Scope (`laravel/storage/app/ai/qg-session-files.txt`): `SendNetfunSMSAction.php` + test + 4 lang.

| Gate | Exit | Evidence |
|------|------|----------|
| preflight | 0 | marker/trunc/php -l ok; `QG_DB_DOWN=1` (`10.100.200.53:3306`) |
| Pint `--test --parallel` | **123** | `ParallelisationException`: `.php_cs` outdated, rename to `.php-cs-fixer.php` |
| Pint `--test` (no parallel) | **0** | `{"tool":"pint","result":"passed"}` → `build/pint.txt` |
| PHPStan session (no tests/) | **0** | `[OK] No errors` → `build/phpstan.txt` |
| PHPMD 3-arg `phpmd.xml` (come prompt) | **1** | `Cannot find specified rule-set "phpmd.xml"` |
| PHPMD 1-arg wrapper | **2** | violazioni = exit 2 PHPMD, non timeout. 3× UnusedPrivateField su `$token/$endpoint/$vars` (usati in `execute()` — falso positivo PDepend) |
| Pest | **3** | DB irraggiungibile; `hostname -I` vuoto (host `zorin`, non 10.100.200.15) |
| Insights | **3** | `vendor/bin/phpinsights` **assente**; wrapper `tools/phpinsights.sh` c'è |

## Contraddizioni verificate (2026-09-22)

1. **`laravel/phpmd.xml` non esiste.** Esiste `laravel/phpmd-ruleset.xml` (wrapper 1-arg) e `{repo}/phpmd.xml` (`../phpmd.xml` da `laravel/`). Il prompt v3.30.1 dice l'inverso.
2. **`git -C ..` da `laravel/` è la mother**, non il modulo. Notify toplevel = `laravel/Modules/Notify`. Dirty mother 75 ≠ dirty Notify 7.
3. **`git status` clean sul modulo ≠ HEAD senza `<<<<<<<`.** Vedi fleet Notify/UI.
4. **`hostname -I` può essere vuoto.** Lo skip Pest su `10.100.200.15` non scatta. Serve anche `QG_DB_DOWN` da `nc` su `DB_HOST`.
5. **`--parallel` su Pint non è default sicuro** su questo tree (`.php_cs` stale). Fallback: senza `--parallel`.
6. **Non** `git merge … --allow-unrelated-histories -s resolve` come flusso di default (il prompt lo cita in CRITICAL). Canon: `sync_subtrees_safe.sh`.

## Patch da applicare al prompt (quando il lock cade)

- Bump `3.30.1` → `3.31.0`.
- Quick ref PHPMD: `tools/phpmd.sh <path>` (1 arg) **oppure** `… text phpmd-ruleset.xml`. Mai `phpmd.xml` da cwd `laravel/`.
- Quick ref Pint: `--test` ; `--parallel` solo se non esplode; se `ParallelisationException` / `.php_cs` → rilancia senza `--parallel`.
- Preflight dirty: unione `git -C $REPO` **e** `git -C` su ogni `path` di `gitmodules.ini` con `.git`.
- Marker: `^<<<<<<<` a inizio riga; escludere assert che *citano* la stringa (`assertStringNotContainsString('<<<<<<<'`).
- Pest skip: `QG_DB_DOWN` **oppure** host `10.100.200.15`; `hostname -I` può essere vuoto.
- Insights: skip 3 se manca `vendor/bin/phpinsights`.
- Togliere `merge --allow-unrelated-histories` dal flusso default.

## Fuori scope

- Non toccato `phpstan.neon`.
- Non commit.
- Non rubato lock prompt / sprint-status (codex `quality-gates-prompt-improve-20260922`).
