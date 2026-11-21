---
title: "issue 05 phpstan 272"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "issue 05 phpstan 272"
issues: []
discussions: []
---

# Issue GH #05 — PHPStan 272 errors: piano di risoluzione modulo-per-modulo

**Repo:** `git@github.com:laraxot/module_xot_fila5.git`
**Title:** `[Quality] Ridurre i 272 errori PHPStan modulo per modulo (BMAD)`
**Labels:** `quality`, `phpstan`, `bmad`, `good-first-issue` (per i moduli piccoli)

## Stato
- PHPStan livello 6 (config immutabile) su `phpstan analyse Modules` = **272 errori**
- Distribuzione: top 20 moduli allegati
- Vincoli: nessuna baseline, nessun `@phpstan-ignore`, nessun cast per zittire

## Approccio
- Una BMAD story per modulo (story 06+: 06-billing, 07-intervention, ...)
- Sottomissione agli altri agenti AI per validazione
- Quality gate 03 sui file toccati

## Plan completo
Vedi `docs/bmad/stories/06-phpstan-272-reduction.md`.

## Comandi
```bash
cd laravel/Modules/Xot
gh issue create --title "[Quality] Ridurre i 272 errori PHPStan modulo per modulo" \
  --body-file docs/bmad/issues/issue-05-phpstan-272.md \
  --label quality --label phpstan --label bmad
```
