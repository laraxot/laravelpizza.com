---
tags: [documentation]
created: 2026-09-26
issues: []
discussions: []
title: "PHPStan analyse (certify no-path) — fix swarm parallelo"
type: story
module: Xot
epic: quality
story_id: "phpstan-analyse-no-path-certify"
status: done
track: quality/fleet
updated: 2026-09-24
qmd: "phpstan analyse certify no path type-coverage swarm bmad AuditCoverage"
related:
  - ./phpstan-modules-2026-09-24.story.md
  - ../phpstan-status.md
  - ../../../../../../docs/wiki/memories/merge-remote-repo-2-reinjects-conflict-markers.md
  - ../../../../../../docs/wiki/memories/phpstan-modules-swarm-session.md
---
# phpstan-analyse-no-path-certify

## Perche'

Richiesta: `cd laravel && ./vendor/bin/phpstan` e fix di tutte le segnalazioni
in ordine random, parallelo, BMAD + second brain.

Nota: il binario nudo stampa help; il certify SSoT è
`./vendor/bin/phpstan analyse` **senza** path CLI (neon paths + type-coverage).
Vedi `phpstan-status.md`.

## Preflight

- `merge_remote_repo_2.sh laraxot` **attivo** → rischio reiniezione marker.
- Lavorare su moduli già passati dallo script; non toccare il cwd dello sync.
- `phpstan.neon` immutabile.

## Acceptance criteria

- [x] `phpstan analyse` (no path) eseguito; inventario salvato
- [x] Errori fixati root-cause, swarm random parallelo + lock
- [x] Nessun ignore/baseline/neon edit
- [x] Certify finale verde
- [x] Pest o skip ambientale documentato
- [x] Story + sprint-status + second brain aggiornati

## Esito

**done** (post swarm B + A/C + regressione harness).

- Marker `Rating/app` e `Modules/**/app`: **0** dopo [Rating markers swarm B](e71e5346-ce3c-45ee-b1ce-753a7ce7046a) + A/C.
- Certify `phpstan analyse` (no path): **16** = solo `tests/AuditCoverage` reiniettato da `laraxot/dev` (ancora tracciato sul remote) → `rm -rf` locale → **`[OK] No errors` EXIT 0**.
- Debito: `git rm` + push su `Modules/Rating` (e UI/Xot `audit-coverage`) verso `laraxot/dev`, altrimenti ogni `merge_remote_repo_2` la riporta. Non eseguito qui (no commit/push senza richiesta).

### Regressione sera (stesso giorno) — 394 → 0

Worktree: i 5 helper `Modules/Xot/tests/{FilamentSchema,ModuleBusiness,ModuleDeep,ModuleExecute,ModuleRemaining}Coverage.php`
erano **assenti su disco** pur restando in `HEAD` (tracked) → **394** `class.notFound`.
Ripristino: `git -C Modules/Xot checkout HEAD -- tests/<file>.php` (non blob antichi).
`ensure-audit-coverage-gitignore.sh --fix` ora ripristina automaticamente gli harness mancanti.
Certify: **`[OK] No errors` EXIT 0**. markers_app=0.

Pest: skip ambientale — host ≠ `10.100.200.15`; `.env.testing` `DB_HOST=10.100.200.53` **DOWN** (tcp/3306).
