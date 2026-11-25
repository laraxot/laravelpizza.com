---
title: "Topic git-push"
type: digest
status: active
qmd: "digest ceiling 100 git-push"
---

# Topic git-push

Sintesi automatica di 3 documenti (chiave `git-push`).

## UI Module — Git Push & Quality Gates (2026-07-28)

_Fonte: `git-push-recovery.md`_

# UI Module — Git Push & Quality Gates (2026-07-28)

## Summary

Remote git repository corruption resolved. 18 commits pushed successfully to `provtv/dev`. All merge conflicts resolved. PHPStan L10 validation passed (0 errors).

## Resolution Steps

### 1. Merge Conflict Resolution ✅

**File:** `docs/code-quality-improvement-report.md`

Resolved 4 merge marker sections:

| Section | Location | HEAD Version | Strategy | Result |
|---------|----------|-------------|----------|--------|
| Metadata | Lines 7–28 | 2026-07-27 | Kept HEAD (more recent) | ✅ |
| GitHub docs | Lines 35–47 | Detailed section | Kept HEAD (more informative) | ✅ |
| PHPStan checklist | Lines 104–108 | [x] Done mark | Kept HEAD (work completed) | ✅ |
| Gate PHPStan | Lines 117–124 | Explicit instructions | Kept HEAD (comprehensive) | ✅ |

**Merge markers removed:** All cleaned, file now valid YAML + Markdown  
**Commit:** `39b58863 resolve: merge conflicts in code-quality-improvement-report.md (keep HEAD)`

### 2. Git Push to Remote ✅

**Command:**
```bash
git push provtv dev

## Git push UI — history unrelated (laraxot ↔ provtv) + loop automatico

_Fonte: `wiki/troubleshooting/git-push-dual-remote-unrelated.md`_

# Git push UI — history unrelated (laraxot ↔ provtv) + loop automatico

## Perché

`Modules/UI` ha due remote:

- `laraxot` → `laraxot/module_ui_fila5`
- `provtv` → `provtv/module_ui_fila5`

Stesso pattern del caso [User](../../../../User/docs/wiki/troubleshooting/git-push-dual-remote-unrelated.md): `provtv/dev` è fermo su un commit orfano (`dfbb8305`, autore `marco76tv`, msg ".", ~2200 file nel diff — snapshot completo, non un semplice gap), `git merge-base HEAD provtv/dev` fallisce (unrelated). `laraxot/dev` invece resta allineato.

## Scoperta aggiuntiva 2026-07-23: non è un evento singolo, è un loop

A differenza del caso User (diagnosticato una volta, poi fermo), su UI il ri-merge di `provtv/dev` è **ricorrente**: nella stessa sessione, la risoluzione completa dei marker di conflitto (verificata 0 marker, `php -l` pulito, push su `laraxot` riuscito) è stata **reintrodotta due volte** da un processo che rilancia periodicamente merge/rebase con `provtv/dev` — visibile in `git reflog` come `pull --rebase provtv dev (start)` / `rebase (abort)` intercalati a commit vuoti `.` dallo stesso autore. Un tentativo di `git push provtv dev` per allineare direttamente il remote stantio (bypassando il merge) è stato rifiutato come non-fast-forward nonostante localmente risultasse un FF pulito — causa non determinata (branch protection? mirror non standard?).

## Cosa fare / non fare

| Scenario | Azione |
|----------|--------|
| Solo `laraxot` da pubblicare | push normale, verificato a

## Git push — oggetti LFS mancanti

_Fonte: `wiki/troubleshooting/git-push-lfs-missing-objects.md`_

# Git push — oggetti LFS mancanti

## Sintomo

Da `laravel/Modules/UI`:

```bash
git push -u laraxot dev
```

Errore tipico:

```text
Git LFS upload failed:
  (missing) resources/svg/flags/it.svg (15777a0d...)
  ...
hint: Your push was rejected due to missing or corrupt local objects.
error: failed to push some refs to 'github.com:laraxot/module_ui_fila5.git'
```

Spesso centinaia di file (`svg`, `png`, `jpeg`) risultano **missing** sia in locale (`.git/lfs/objects/`) sia su GitHub (404 al `git lfs fetch`).

## Perché succede

1. Commit storici contengono **puntatori LFS** (blob Git da ~133 byte), non il file reale.
2. I blob LFS referenziati **non sono mai stati caricati** sul remote (o sono stati persi).
3. Il working tree ha file reali, ma con **OID diverso** da quello nei puntatori storici → non si può ricostruire lo store LFS dai file attuali.
4. `.gitattributes` attuale traccia solo `*.psd`; lo storico può comunque referenziare LFS su immagini vecchie.
