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

**Wave 21:31**: totale **296MB → 202MB** (−94MB). Causa tipica: `HEAD` pulito ma
`refs/original` + `refs/prefetch` + remote `develop`/`main`/`dev1` + tag vecchi
tengono pack monorepo. Tool: `bash bashscripts/tools/git/slim-module-theme-git.sh`.

| Path | .git MB | Note |
|------|---------|------|
| Themes/Meetup | **63** | **PDF KEEP** (~38MB tip): manuale utente; `repo.bundle` untracked+gitignore |
| Geo | 20 | tip pulito; json/dump grandi in tree |
| UI | **19** (was 29) | tip = screenshot; remotes pruned |
| Notify | **15** | depth-1 slim storico; no `git pull` pieno |
| Seo | 13 | storia lunga |
| Lang | **5** (was 12) | pruned 21:36 quando sync ha lasciato Lang |
| Job | 9 | storia lunga |
| User | **8** (was 42) | tip 5723 objs; era 94803 via remotes/tags |
| Tenant/Gdpr | 7 | storia lunga |
| Xot | **6** (was 29) | remotes pruned |
| Cms | **6** (was 10) | remotes pruned |
| Meetup (mod) / AI | 5 | ok |
| Activity | **4** (was 16) | remotes pruned |
| Media | **3** (was 8) | remotes pruned |

## Procedura sicura (KISS)

How-to: [module-theme-git-slim.md](../../../../../../bashscripts/docs/operations/module-theme-git-slim.md)

1. **Mai** sul pacchetto sotto cwd di `merge_remote_repo_2.sh` (`/proc/<pid>/cwd`).
2. `bash bashscripts/tools/git/slim-module-theme-git.sh` (o lista moduli).
3. Se il **tip** contiene ancora path monorepo: re-clone depth-1 come Notify (backup `.git`; **no force-push**).
4. Rimuovere leftover disco: `.git-rewrite/` — non e' storia.
5. Theme PDF manuals: **KEEP** (linkati da `manuale-utente/readme.md`). `repo.bundle`: non tracciare.

## Coordinamento

| Agente | Scope | Claim |
|--------|-------|-------|
| coordinator | **21:31** prune wave 296→202MB; script+ops doc; Theme PDF kept; Lang skip sync; initiative `kp-49f7fb357f59473da7964d9a262ece3a` | 2026-11-24 21:31 |
| lane-theme-meetup | Theme Meetup: repo.bundle confirm untracked; PDF KEEP; gitignore markers | 2026-11-24 21:29 |
| coordinator | inventario + gc safe (skip Notify/Job sync) → 740→736MB | 2026-11-24 18:10 done |
| coordinator | Notify pollution diagnostic (1930 vs 1 commit remoto) | 2026-11-24 18:12 done |
| coordinator | Activity `.git-rewrite` rimosso | 2026-11-24 18:13 |
| lane-notify-reclone | Notify slim: wait sync → full clone (= remoto polluto 431MB/1930) → depth-1 14MB/1; bak polluted kept; no force-push | 2026-11-24 18:31 done |
| lane-meetup-theme | Meetup `.git` 63→63MB: untrack already done; gitignore markers fixed; PDF kept intentional; gc+repack; no filter-repo | 2026-11-24 21:29 done |

## Verify

```bash
du -sm laravel/Modules/*/.git laravel/Themes/*/.git | sort -nr
bash bashscripts/tools/git/slim-module-theme-git.sh   # idempotent
# tip vs all objects (dopo slim devono coincidere circa)
cd laravel/Modules/User && git rev-list --objects HEAD | wc -l
git rev-list --objects --all | wc -l
```

## Related

- [module-theme-git-slim ops](../../../../../../bashscripts/docs/operations/module-theme-git-slim.md)
- [multi-repo map](../../../../../../docs/wiki/rules/multi-repo-modules-themes-map.md)
- [git-push-pack-errors](../../../../../../docs/wiki/rules/git-push-pack-errors.md)
- [cleanup-git-rewrite-artifact](./cleanup-git-rewrite-artifact.story.md)
- [phpstan standing](./phpstan-modules-zero-swarm-standing.story.md)
