---
title: "Commit & push dopo modifiche al modulo"
type: rule
tags: [git, workflow, user]
created: 2026-07-08
updated: 2026-07-08
qmd: "User git commit push dopo modifiche regola"
related:
  - "./agent-confidence-protocol.md"
  - "./can-comment-retired-wrong-placement.md"
  - "./frontend-stack-canonical.md"
  - "./header-auth-flow.md"
  - "./header-design-colors.md"
  - "./navigation-properties.md"
  - "./no-filament-labels.md"
  - "./no-notifications-migration-in-user-module.md"
---

# Commit & push dopo modifiche al modulo

## Regola

Quando modifichi file dentro `laravel/Modules/User/` devi:

1. Entrare nella cartella del modulo (`cd laravel/Modules/User`)
2. Fare `git pull --rebase` sul remote di tracking (`laraxot` o `origin`) se il push è rifiutato
3. Fare `git commit` con messaggio descrittivo
4. Fare `git push -u laraxot dev` (o `origin dev` per provtv)

## Perché

`Modules/User` è un repository Git separato dal monorepo. Modifiche non committate o non pushate rompono tracciabilità e sincronizzazione tra ambienti.

## Push rifiutato

| Errore | Azione |
|--------|--------|
| `non-fast-forward` | `git fetch laraxot dev && git pull --rebase laraxot dev` poi ripeti push |
| LFS / object mancante | Vedi [git-push-lfs-missing-objects](../troubleshooting/git-push-lfs-missing-objects.md) |

## Post-edit obbligatorio

Dopo ogni modifica PHP nel modulo:

- PHPStan livello 10 su `app/`
- PHPMD (`bash tools/phpmd.sh` dalla root Laravel)
- Pest con `.env.testing` e MySQL (no `RefreshDatabase`, no `migrate --force`)
