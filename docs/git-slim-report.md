---
title: "Git slim report — repo di gitmodules.ini"
type: report
status: current
updated: 2026-11-25
qmd: "git slim report count-objects in-pack pack-size shallow fsck gitmodules.ini under 10000"
related:
  - ../laravel/Modules/Xot/docs/bmad/stories/0087-git-objects-slimming-independent-repos.story.md
  - ../laravel/Modules/Xot/docs/bmad/stories/0105-module-theme-git-slim.story.md
  - ../bashscripts/docs/operations/module-theme-git-slim.md
  - ./wiki/second-brain/second-brain.md
---

# Git slim report — repo di `gitmodules.ini`

Obiettivo: ogni `.git` dei path in [`gitmodules.ini`](../gitmodules.ini) sotto **10.000 oggetti**
(`count + in-pack` da `git count-objects -v`).

Misura: **2026-11-25 18:20** (host `base_laravelpizza_fila5`). Tool: `bashscripts/git/slim-git-repos.sh`.

## Sintesi

| Metrica | Valore |
|---------|-------:|
| Path in `gitmodules.ini` | 16 |
| Sotto soglia (&lt; 10.000 ogg.) | **16 / 16** |
| Max oggetti (bashscripts) | 6.179 |
| Totale oggetti (somma path) | 32.476 |
| Totale `.git` su disco | 148 MB |
| `fsck --connectivity-only` | 16/16 ok |
| Ahead/behind vs `laraxot/dev` | tutti 0/0 |

Prima della wave serale i pezzi critici erano: Notify 153.523 / 432 MB, Xot 103.252, Job 29.774, Tenant 15.326.

## Tabella completa (path di `gitmodules.ini`)

| Path | Oggetti | Loose | In-pack | Pack KiB | `.git` MB | Reachable | Commit HEAD | Commit all | Shallow | Ahead | Behind | HEAD | `laraxot/dev` | Upstream | fsck | Dirty | Untracked | Remotes |
|------|--------:|------:|--------:|---------:|----------:|----------:|------------:|-----------:|---------|------:|-------:|------|---------------|----------|------|------:|----------:|---------|
| bashscripts | 6.179 | 83 | 6.096 | 22.275 | 24 | 6.179 | 10 | 10 | no | 0 | 0 | `f5b193e` | `f5b193e` | laraxot/dev | ok | 3 | 0 | laraxot,origin |
| laravel/Modules/Activity | 948 | 9 | 939 | 2.508 | 3 | 948 | 4 | 4 | yes(1) | 0 | 0 | `6b24d5a` | `6b24d5a` | laraxot/dev | ok | 10 | 7 | laraxot |
| laravel/Modules/Cms | 2.448 | 4 | 2.444 | 5.241 | 6 | 2.448 | 3 | 3 | yes(1) | 0 | 0 | `6a40b69` | `6a40b69` | laraxot/dev | ok | 41 | 40 | laraxot |
| laravel/Modules/Gdpr | 1.423 | 13 | 1.410 | 679 | 2 | 1.423 | 4 | 5 | yes(1) | 0 | 0 | `2afd556` | `2afd556` | laraxot/dev | ok | 8 | 8 | laraxot |
| laravel/Modules/Geo | 4.095 | 14 | 4.081 | 12.058 | 13 | 4.095 | 4 | 4 | yes(1) | 0 | 0 | `5afe246` | `5afe246` | laraxot/dev | ok | 10 | 8 | laraxot |
| laravel/Modules/Job | 867 | 0 | 867 | 706 | 1 | 867 | 1 | 1 | yes(1) | 0 | 0 | `9079fb5` | `9079fb5` | laraxot/dev | ok | 21 | 21 | laraxot |
| laravel/Modules/Lang | 776 | 9 | 767 | 2.913 | 4 | 776 | 4 | 4 | yes(1) | 0 | 0 | `de826ee` | `de826ee` | laraxot/dev | ok | 7 | 6 | laraxot |
| laravel/Modules/Media | 1.323 | 11 | 1.312 | 2.681 | 3 | 1.323 | 3 | 7 | yes(1) | 0 | 0 | `82933db` | `82933db` | laraxot/dev | ok | 53 | 53 | laraxot |
| laravel/Modules/Meetup | 956 | 19 | 937 | 3.974 | 5 | 956 | 3 | 4 | yes(1) | 0 | 0 | `d988245` | `d988245` | laraxot/dev | ok | 0 | 0 | laraxot |
| laravel/Modules/Notify | 3.730 | 0 | 3.730 | 12.002 | 13 | 3.722 | 1 | 1 | yes(1) | 0 | 0 | `850bf14` | `850bf14` | laraxot/dev | ok | 3 | 0 | laraxot |
| laravel/Modules/Seo | 690 | 25 | 665 | 317 | 1 | 690 | 5 | 6 | yes(1) | 0 | 0 | `7ad1044` | `7ad1044` | laraxot/dev | ok | 0 | 0 | laraxot |
| laravel/Modules/Tenant | 405 | 0 | 405 | 524 | 1 | 405 | 1 | 1 | yes(1) | 0 | 0 | `7be34d6` | `7be34d6` | laraxot/dev | ok | 46 | 46 | laraxot |
| laravel/Modules/UI | 1.696 | 14 | 1.682 | 16.740 | 17 | 1.674 | 4 | 4 | yes(1) | 0 | 0 | `45d674a` | `45d674a` | laraxot/dev | ok | 0 | 0 | laraxot |
| laravel/Modules/User | 3.426 | 124 | 3.302 | 3.330 | 5 | 3.337 | 4 | 4 | yes(1) | 0 | 0 | `fc57db9` | `fc57db9` | laraxot/dev | ok | 0 | 0 | laraxot |
| laravel/Modules/Xot | 2.240 | 0 | 2.240 | 4.288 | 5 | 2.240 | 1 | 1 | yes(1) | 0 | 0 | `73998fb` | `73998fb` | laraxot/dev | ok | 11 | 9 | laraxot |
| laravel/Themes/Meetup | 1.274 | 62 | 1.212 | 45.166 | 45 | 1.274 | 5 | 6 | yes(1) | 0 | 0 | `893a745` | `893a745` | laraxot/dev | ok | 0 | 0 | laraxot |

### Legenda colonne

| Colonna | Fonte |
|---------|--------|
| Oggetti | `count + in-pack` |
| Pack KiB | `size-pack` di `git count-objects -v` |
| `.git` MB | `du -sm <path>/.git` |
| Reachable | `git rev-list --objects --all \| wc -l` |
| Shallow | presenza `.git/shallow` (+ n. root) |
| Ahead/Behind | `HEAD...laraxot/dev` |
| Dirty / Untracked | righe `git status --porcelain` (untracked include docs locali post-slim) |

## Delta wave serale (4 repo critici)

| Path | Prima (ogg / MB) | Dopo (ogg / MB) | Azione |
|------|-----------------:|----------------:|--------|
| Notify | 153.523 / 432 | 3.730 / 13 | `slim-git-repos.sh --apply --shallow` (HEAD == remoto) |
| Job | 29.774 / 10 | 867 / 1 | depth-1 sul tip remoto |
| Tenant | 15.326 / 7 | 405 / 1 | depth-1 sul tip remoto |
| Xot | 103.252 / 29 | 2.240 / 5 | depth-1 sul tip remoto |

**Perche' erano grassi:** oggetti raggiungibili nella storia (non garbage). Notify: path monorepo
`laravel/`, `node_modules/` in pack. Job/Tenant/Xot: merge locali col tip `laraxot/dev` tenevano
raggiungibile tutta la storia del secondo parent anche con `.git/shallow` su un altro root.

**Push fallito prima del slim:** da repo gia' shallow i parent dei commit ahead non c'erano in locale
(`remote unpack failed: did not receive expected object …`). Per allineare serviva depth-1 sul tip
remoto; i file dei commit ahead non pushati restano in working tree come untracked (da ri-committare).

## Fuori `gitmodules.ini` (monitoraggio)

| Path | Oggetti | `.git` MB | Note |
|------|--------:|----------:|------|
| laravel/Modules/AI | 694 | 1 | `.git` proprio, non in `gitmodules.ini` |
| monorepo root `.` | 232.130 | 1.104 | fuori scope dello slim moduli/temi |

## Backup

`~/backups/git-slim-20261125-wave2/` (469 MB, `zstd -t` ok):

- `laravel_Modules_Notify.git.tar.zst`
- `laravel_Modules_Job.git.tar.zst`
- `laravel_Modules_Tenant.git.tar.zst`
- `laravel_Modules_Xot.git.tar.zst`

Recupero es.: `zstd -dc …/laravel_Modules_Notify.git.tar.zst | tar -C laravel/Modules/Notify -xf -`

## Come ripetere la misura

```bash
# dry-run piano slim
bash bashscripts/git/slim-git-repos.sh

# tabella oggetti + size
while IFS= read -r p; do
  printf '%-40s %6sMB %8s ogg\n' "$p" \
    "$(du -sm "$p/.git" | cut -f1)" \
    "$(git -C "$p" count-objects -v | awk '/^(count|in-pack):/{s+=$2} END{print s+0}')"
done < <(awk -F'= ' '/^[[:space:]]*path =/{gsub(/[[:space:]]+$/,"",$2); print $2}' gitmodules.ini)

# gate
for p in $(awk -F'= ' '/^[[:space:]]*path =/{print $2}' gitmodules.ini); do
  git -C "$p" fsck --connectivity-only --no-progress >/dev/null || echo "FAIL $p"
done
```

## Aperti

- [ ] Decisione su `MAX_GIT_OBJECTS` in `merge_remote_repo_2.sh` (oggi 130000 vs soglia locale 10000)
- [ ] Prefetch `git maintenance` (puo' far ricrescere i pack)
- [ ] Job / Tenant / Xot: ri-committare i file untracked rimasti dopo il depth-1
- [ ] Remoto Notify ancora ~431 MB di storia polluta: solo `filter-repo` + force-push (decisione proprietario)

## Collegamenti

- Story: [0087-git-objects-slimming-independent-repos](../laravel/Modules/Xot/docs/bmad/stories/0087-git-objects-slimming-independent-repos.story.md)
- Story: [0105-module-theme-git-slim](../laravel/Modules/Xot/docs/bmad/stories/0105-module-theme-git-slim.story.md)
- How-to: [module-theme-git-slim](../bashscripts/docs/operations/module-theme-git-slim.md)
- Second brain: [git-objects-under-10k](./wiki/second-brain/second-brain.md#git-objects-under-10k)

## Wave 2026-11-25 notte

- Modules/Rating: 15619→532 oggetti (--apply --shallow).
- Tutti i path gitmodules.ini <10k (max bashscripts 6203).
