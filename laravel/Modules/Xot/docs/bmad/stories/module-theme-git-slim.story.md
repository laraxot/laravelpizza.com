---
title: "Snellire .git di moduli e temi"
status: in-progress
qmd: "git gc prune repack module theme multi-repo notify pollution sync"
---

# Story — Snellire `.git` moduli/temi

## Why

Ogni `Modules/*` e `Themes/*` e' un repo indipendente (`git remote -v`).
Dopo sync/`unrelated histories` i `.git` locali si gonfiano di oggetti
monorepo (path `laravel/`, `node_modules/`, altri moduli) anche se il
remoto owner e' piccolo. `git gc` non basta se gli oggetti sono raggiungibili.

## Inventario (base_laravelpizza_fila5)

| Path | .git ~MB | Note |
|------|----------|------|
| Notify | **~14** (was ~428–461) | **slimmed 2026-11-24 18:31**: depth-1 `--single-branch` tip `c642ea4 first`; bak `.git.polluted.bak.202611241827` kept. Full clone remoto ancora ~431MB/1930 (storia monorepo sul remoto; no force-push) |
| Themes/Meetup | ~65 | PDF manuale + `repo.bundle` tracciato (~5MB) |
| User | ~40 | gc -2MB; path monorepo in object DB da verificare |
| Xot/UI | ~30 | storia lunga allineata al remoto; gc marginale |
| altri | <25 | dopo `reflog expire` + `repack -Ad` + `gc --prune=now` |

## Procedura sicura (KISS)

1. **Mai** `gc` sul modulo sotto cwd di `merge_remote_repo_2.sh` (`/proc/<pid>/cwd`).
2. Per ogni repo libero:
   ```bash
   git reflog expire --expire=now --all
   git remote prune laraxot 2>/dev/null || true
   git repack -Ad
   git gc --prune=now
   ```
3. Se `git rev-list --count HEAD` >> `git rev-list --count laraxot/dev` **e**
   `git rev-list --objects --all | awk '{print $2}' | grep -cE '^(laravel/|node_modules/)'` alto:
   **re-clone** dal remoto owner (non history rewrite forward-only sul remoto):
   ```bash
   cd laravel/Modules/<M>
   git status -sb   # salvare WIP
   git fetch laraxot
   # sostituire .git con clone pulito del solo modulo, ripristinare WIP
   ```
4. Rimuovere leftover disco: `.git-rewrite/` (filter-branch crash) — non e' storia.
5. `repo.bundle` / PDF enormi in tema: togliere dal tracking con commit forward se non servono al runtime; la storia resta finche' non si fa filter-repo (fuori scope di default).

## Coordinamento

| Agente | Scope | Claim |
|--------|-------|-------|
| coordinator | inventario + gc safe (skip Notify/Job sync) → 740→736MB | 2026-11-24 18:10 done |
| coordinator | Notify pollution diagnostic (1930 vs 1 commit remoto) | 2026-11-24 18:12 done |
| coordinator | Activity `.git-rewrite` rimosso | 2026-11-24 18:13 |
| lane-notify-reclone | Notify slim: wait sync → full clone (= remoto polluto 431MB/1930) → depth-1 14MB/1; bak polluted kept; no force-push | 2026-11-24 18:31 done |

## Verify

```bash
cd laravel && du -sm Modules/*/.git Themes/*/.git | sort -nr
cd Modules/Notify && git rev-list --count HEAD && git rev-list --count laraxot/dev
```

## Related

- [multi-repo map](../../../../../../docs/wiki/rules/multi-repo-modules-themes-map.md)
- [git-push-pack-errors](../../../../../../docs/wiki/rules/git-push-pack-errors.md)
- [cleanup-git-rewrite-artifact](./cleanup-git-rewrite-artifact.story.md)
- [phpstan standing](./phpstan-modules-zero-swarm-standing.story.md)
