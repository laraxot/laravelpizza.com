---
title: "Git push — oggetti LFS mancanti (module_user_fila5)"
type: rule
module: User
tags: [git, lfs, push, troubleshooting, user]
created: 2026-07-08
updated: 2026-07-08
qmd: "git push LFS missing objects module User risoluzione squash rebase"
related:
  - ./git-merge-conflict-inventory.md
  - ../../../../UI/docs/wiki/troubleshooting/git-push-lfs-missing-objects.md
  - ../concepts/module-root-folder-violations.md
---

# Git push — oggetti LFS mancanti

## Sintomo

Da `laravel/Modules/User`:

```bash
git push -u laraxot dev
```

Errore tipico:

```text
Git LFS upload failed:
  (missing) docs/img/roles-list.jpg (5375e5e...)
  (missing) resources/svg/user-animated.svg (40b6bdc...)
  ...
hint: Your push was rejected due to missing or corrupt local objects.
error: failed to push some refs to 'github.com:laraxot/module_user_fila5.git'
```

Spesso **41+** file (`svg`, `png`, `jpg`) risultano missing in `.git/lfs/objects/` mentre il working tree ha blob reali.

## Perché succede

1. Commit storici (centinaia di messaggi `.`) contengono **puntatori LFS** non più presenti sul remote.
2. `git lfs push laraxot dev` segnala oggetti missing anche se i file su disco esistono (OID diverso).
3. Un **rebase** su `laraxot/dev` con 328 commit può lasciare il repo in `(no branch, rebasing dev)` con centinaia di conflitti `AA` — **non** proseguire il rebase; abortire e usare squash.

Verifica rapida:

```bash
cd laravel/Modules/User
git status -sb                    # ahead N su laraxot/dev?
git lfs push laraxot dev 2>&1 | grep -c missing
test -d .git/rebase-merge && echo REBASE_BLOCCATO
```

## Soluzione definitiva (applicata 2026-07-08)

### 1. Uscire da rebase bloccato (se presente)

```bash
cd laravel/Modules/User
git rebase --abort
git checkout dev
```

### 2. Squash sopra `laraxot/dev`

Un solo commit con il tree attuale (blob Git normali, senza storico LFS corrotto):

```bash
git fetch laraxot
git reset --soft laraxot/dev
git commit -m "fix(git): consolidamento commit locali e blob Git al posto di LFS corrotto"
git push -u laraxot dev
```

Risultato sessione 2026-07-08: `a8cd01ad..b0fa6e3d` su `laraxot/dev`, branch traccia `laraxot/dev`.

### Cosa **non** fare

- `git config lfs.allowincompletepush true` — push incompleto, clone rotti.
- Rebase di 300+ commit con catena di `.` quando LFS è già corrotto.
- Cartelle legacy `Application/`, `Database/Migrations/` alla root modulo (violano [module-root-folder-violations](../concepts/module-root-folder-violations.md) e duplicano path per PHPStan).

## Checklist post-push

```bash
cd laravel/Modules/User
git status -sb                    # dev...laraxot/dev (in sync)
cd ../..
php -d memory_limit=2048M ./vendor/bin/phpstan analyse Modules/User --no-progress
```

| Problema residuo | Fix |
|------------------|-----|
| PHPStan `method.notFound` su migrazione legacy `Database/Migrations/` | Rimuovi cartella PascalCase; canonico = `database/migrations/` |
| `trait.unused` / generics su contract duplicato in `Application/` | Solo `app/Application/` |
| Dependabot alert su push | [dependabot-discipline](../../../../../docs/wiki/how-to/dependabot-discipline.md) |

## Riferimenti

- Stesso pattern modulo UI: [UI git-push-lfs-missing-objects](../../../../UI/docs/wiki/troubleshooting/git-push-lfs-missing-objects.md)
- Inventario conflitti: [git-merge-conflict-inventory](./git-merge-conflict-inventory.md)
- Prevenzione push monorepo: [push-error-prevention](../../../../../docs/wiki/git/push-error-prevention.md)
