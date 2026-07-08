---
name: git_push_error_prevention
description: Prevenzione errori git push — LFS, merge conflicts, branch divergence
metadata:
  type: operational
  verified_date: 2026-07-08
  version: 1.0
---

# Git Push Error Prevention

**Problem**: Push fail con errori LFS, merge conflicts, branch divergence.  
**Solution**: Configurazione permanente + workflow discipline.

---

## Errori specifici PTVX (2026-07-08)

### Origin su `module_geo_fila5` (SBAGLIATO)

Il monorepo **non** è `laraxot/module_geo_fila5`. Geo è modulo opzionale e **non** va clonato in `laravel/Modules/Geo/`.

```bash
# Remote canonico
git remote set-url origin git@github.com:provtv/base_ptv_fila5.git
# Solo riferimento opzionale (mai come origin)
git remote add geo git@github.com:laraxot/module_geo_fila5.git 2>/dev/null || true
```

### Rebase onto commit Geo (`331ba6c…`)

**Mai** `git pull` / `git rebase` da remote `geo` sul branch `dev` del monorepo.

```bash
git rebase --abort 2>/dev/null || true
git reset --hard dev
git checkout dev
```

### Geo embedded / tracciato

```bash
git rm --cached -r laravel/Modules/Geo 2>/dev/null || true
echo 'laravel/Modules/Geo/' >> .gitignore
rm -rf laravel/Modules/Geo
```

### Guard automatico

```bash
bash laravel/tools/guard-monorepo-push.sh
git config core.hooksPath .githooks   # hook versionato nel repo
```

---

## Configurazioni Permanente

### 1. LFS Incomplete Push (Allow)

```bash
git config lfs.allowincompletepush true
```

**Why**: SVG/image files in LFS may be missing locally during rebase/merge. Allow push anyway.  
**Applied**: ✅ Laravel root `.git/config`

### 2. Rename Limit (Increase)

```bash
git config merge.renamelimit 26445
```

**Why**: Rebase con 14K+ file changes soffre di "exhaustive rename detection skipped".  
**Applied**: ✅ Laravel root `.git/config`

### 3. Prune LFS Before Push

```bash
git lfs prune
git push -u origin dev
```

**Why**: Rimuove local LFS objects orfani che causano "corrupt" errors.  
**Pattern**: Always run `git lfs prune` prima di push se vedi errori LFS.

---

## Workflow Discipline

### ✅ Safe Push Sequence

```bash
# 1. Pull latest remote
git pull --ff-only

# 2. Fix merge conflicts (if any)
# ... resolve conflicts ...

# 3. Prune LFS
git lfs prune

# 4. Push with lease (safe force push)
git push -u origin dev --force-with-lease
```

### ✅ Regola operativa: commit/push dal repo del modulo o tema

Quando modifichi file dentro un modulo o tema, chiudi il lavoro entrando nella sua cartella e facendo commit/push dal suo repository, non dalla root del monorepo.

```bash
cd laravel/Modules/<NomeModulo>
git status --short
git add .
git commit -m "fix(<modulo>): descrizione sintetica"
git push -u
```

Per i temi:

```bash
cd laravel/Themes/<NomeTema>
git status --short
git add .
git commit -m "fix(<tema>): descrizione sintetica"
git push -u
```

Se il repo del modulo/tema e' pulito, eseguire comunque `git push -u` e verificare che risponda `Everything up-to-date`.

**Why**: ogni modulo/tema e' un repository autonomo; il monorepo non deve nascondere modifiche che appartengono al repo del package.

### ❌ What to Avoid

- ❌ `git push` without `git pull` first (causes non-fast-forward)
- ❌ `git push --force` (dangerous, overwrites others' work)
- ❌ `git rebase` on divergent history without investigating
- ❌ Ignoring "corrupt LFS objects" — always run `git lfs prune`
- ❌ Trying to merge unrelated histories without `--allow-unrelated-histories`

---

## Common Errors & Fixes

### Error: "non-fast-forward" / "remote rejected"

**Cause**: Local branch behind remote.

**Fix**:
```bash
git pull --ff-only
git push
```

### Error: "corrupt LFS objects" / "GH008: unknown LFS objects"

**Cause**: LFS objects missing or desynchronized during rebase/merge.

**Fix**:
```bash
git lfs prune
git push --force-with-lease
```

### Error: "Rebase conflict" / "too many files"

**Cause**: Large file renames during merge; rename detection times out.

**Fix**:
```bash
git merge --abort  # Reset to safe state
git merge -X ours origin/dev  # Merge with preference for local changes
# Then resolve any remaining conflicts manually
```

### Error: "refusing to merge unrelated histories"

**Cause**: Branches have no common ancestor (history was rewritten).

**Fix**:
```bash
git merge --allow-unrelated-histories origin/dev
# Then resolve conflicts and commit
```

---

## Automation: Pre-Push Hook

Add to `.git/hooks/pre-push`:

```bash
#!/bin/bash
echo "[*] Running pre-push checks..."

# 1. Check for LFS issues
if git lfs ls-files | head -5 >/dev/null 2>&1; then
  echo "[*] Pruning LFS objects..."
  git lfs prune
fi

# 2. Check for uncommitted changes
if ! git diff-index --quiet HEAD --; then
  echo "[!] ERROR: Uncommitted changes detected"
  exit 1
fi

echo "[✓] Pre-push checks passed"
exit 0
```

Make executable:
```bash
chmod +x .git/hooks/pre-push
```

---

## Current Status

**Date**: 2026-07-08  
**Push Status**: ✅ Successful (dev branch synced with origin/dev)  
**Configurations Applied**: ✅ LFS + rename limit  
**Recommended Next**: Setup pre-push hook in CI/CD

---

## Related

- [[git_forward_only]] — Never reset/revert, always move forward
- [[feedback_context_overflow]] — Token budget management during large pushes
- [[module_discipline]] — Module file organization
