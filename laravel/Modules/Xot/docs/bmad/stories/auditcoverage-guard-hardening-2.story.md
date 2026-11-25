---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
issues: []
discussions: []
title: "Story — guardia AuditCoverage: upstream, harness Xot, canon contraddittorio (2026-09-24)"
type: story
module: Xot
epic: quality
story_id: "auditcoverage-guard-hardening-2026-09-24"
status: done
qmd: "audit-coverage guard upstream REMOTE HARNESS claude-audit bridge superseded shallow repo"
related:
  - ../../../../Rating/docs/bmad/stories/auditcoverage-reinjection-2026-09-24.story.md
  - ../../wiki/concepts/tests-audit-coverage-forbidden.md
  - ../../../../../../bashscripts/ai/wiki/rules/tests-auditcoverage-forbidden.md
---
# auditcoverage-guard-hardening-2026-09-24

## Perché

Follow-up di `Rating/auditcoverage-reinjection-2026-09-24`, su richiesta dell'utente di
migliorare quello che si può migliorare. Due guasti in una sessione (scaffold reiniettato
dal merge, harness Xot cancellati) che la guardia esistente non vedeva.

## Fatto

1. `bashscripts/tools/ensure-audit-coverage-gitignore.sh` (e il wrapper `audit-no-audit-coverage-dir.sh`):
   - `REMOTE:`: cartella vietata tracciata su `@{upstream}` (ref locali, nessun fetch);
   - `HARNESS:`: mancano i 5 `Modules/Xot/tests/*Coverage.php` canonici (story 5.28);
   - `[ -d "$pkg" ] || continue`: il glob senza match dava un falso `GITIGNORE incompleto`.
   Test sandbox (repo bare + upstream con `tests/AuditCoverage`, Xot senza harness): entrambi rilevati, exit 1.
2. **Canon contraddittorio risolto.** `Xot/.../claude-audit-static-all-modules.md`,
   `claude-audit-all-modules-static.md` e `UI/.../claude-audit-static.md` (2026-07-09) prescrivevano
   bridge `audit-coverage/tests/*AuditBridgeTest*` e di **togliere** `audit-coverage/` da `.gitignore`;
   la regola `tests-auditcoverage-forbidden` (2026-07-27, più recente) li vieta. Marcate SUPERSEDED
   con banner; la tabella in `tests-audit-coverage-forbidden.md` non chiama più "canonico" il bridge.
3. Trigger map + regola root aggiornate (sezione "cancellarla non basta se è tracciata").

## Trovato, non risolto (serve decisione/rete)

- `audit-no-audit-coverage-dir.sh` reale → **exit 1**: `laraxot/dev` di **UI** (20 file) e **Xot** (204 file)
  traccia ancora `audit-coverage/`; localmente sono già rimossi (0 in index). Serve push dei moduli
  (outward-facing: ok utente o daemon), altrimenti la prossima sync li reinietta (UI: parse `T_SL` già visto).
- UI e Xot sono **shallow clone** (`rev-parse --is-shallow-repository` = true): `git log -S` / `status -sb`
  falliscono su oggetti mancanti → l'archeologia ("recuperare codice cancellato") è cieca oltre il confine.
  Rating non è shallow ma ha un oggetto mancante (`6f33890…`). Rimedio: `git fetch --unshallow` (rete).
- `docs/sprint-status.yaml` ancora sotto lock `opencode-phpstan` (rinnovato 20:43): voci non aggiunte.

## Gate

Nessun file PHP toccato (solo bash + md): PHPStan invariato (ultimo run `Modules` → 0/0);
Pest non applicabile; `bash -n` OK; sandbox verde.
