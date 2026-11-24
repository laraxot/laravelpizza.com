---
title: "Git — inventario conflitti merge (User)"
type: troubleshooting
module: User
tags: [git, merge, conflict, user]
created: 2026-04-28
updated: 2026-11-16
qmd: "git merge conflict markers User docs inventory rebase"
related:
  - "./filament-user-creation-pty-error.md"
  - "./git-merge-conflict-inventory-1.md"
  - "./git-push-lfs-missing-objects.md"
  - "./phpstan-module-analysis-memory.md"
  - "./phpstan-widget-property-types.md"
  - "./spatie-permission-team-model-not-configured.md"
  - "./git-merge-conflict-inventory-stato-rinominato.md"
  - "./phpstan-widget-property-types-stato-rinominato.md"
  - "../../bmad/stories/phpstan-conflict-markers-bootstrap.story.md"
  - "../../bmad/stories/committed-conflict-markers.story.md"
status: draft
---

# Git — inventario conflitti merge (User)

<<<<<<< HEAD
## Stato 2026-11-24 (post merge_remote_repo_2)

- `module.json` valido (providers User+AdminPanel+Passport+Socialite, requires Xot+UI).
- `app/**/*.php`: **0** marker `<<<<<<<` (incl. `HasTeams.php`).
- Lang: dedup `array.duplicateKey` su overview widgets, oauth PAC, password_resets, base_profile(s); parse mashup `attach_role`/`user_section`/`passport_stats` ripuliti.
- Verify: `php artisan about --only=environment` OK; `phpstan analyse Modules/User` → `errors=0`, `file_errors=0`.
- Restano marker in `docs/` e `tests/` (fuori scope boot/PHPStan: tests esclusi da `phpstan.neon`).

=======
>>>>>>> laraxot/dev
## Stato 2026-11-16

- Marker PHP User risolti (bootstrap `UserServiceProvider` + BaseUser/BaseTenant/Socialite/UserForm):
  [phpstan-conflict-markers-bootstrap](../../bmad/stories/phpstan-conflict-markers-bootstrap.story.md).
- Scan marker su `*.php` / `*.blade.php` → **NONE**.
- Aggiorna (non sostituisce) lo storico 2026-07; link da story BMAD e `git-conflicts-resolution.md`.

## Stato 2026-07-08

- **Rebase abortito** su `dev` (328 pick, 623 file `AA`) — causa: tentativo rebase sopra `laraxot/dev` con storico LFS corrotto.
- Dopo `git rebase --abort`: **0** marker `<<<<<<<` nei `.md` tracciati (`git grep`).
- Push risolto con squash → [git-push-lfs-missing-objects](./git-push-lfs-missing-objects.md).

## Inventario storico (2026-04-28)

File con marker (da risolvere forward-only se riappaiono):

- `docs/archive/historical/volt-folio-logout-error.md`
- `docs/archive/historical/volt-folio-logout.md`
- `docs/phpstan-fixes-roadmap.md`
- `docs/volt-folio-logout-error.md`
- `docs/wiki/README.md`

## Note operative

- Rigenerare lista: `git grep -l '^<<<<<<<' -- '*.md' 'docs/'`
- Non risolvere in parallelo senza lock; preferire wiki canonico `docs/wiki/` rispetto a duplicati root `docs/*.md`.
- Task dedicato marker doc: `docs/tasks/fix-doc-merge-markers.md`
<<<<<<< HEAD


---

<!-- Contenuto unito da git-merge-conflict-inventory-.md (rimozione date dai nomi file, issue #64) -->

<!-- recovery from broken basename `git-merge-conflict-inventory-.md` after docs-guardian mass rename -->

Stub: il contenuto utile resta nei path datati ripristinati da HEAD. Questo file evita nomi `*-.md`.



---

<!-- Contenuto unito da git-merge-conflict-inventory-28.md (rimozione date dai nomi file, issue #64) -->

# Git Conflict Inventory

- Date: 2026-04-28
- Owner: Modules/User
- Files with conflict markers: 5

## Files

- docs/archive/historical/volt-folio-logout-error.md
- docs/archive/historical/volt-folio-logout.md
- docs/phpstan-fixes-roadmap.md
- docs/volt-folio-logout-error.md
- docs/wiki/README.md

## Notes

- Inventory generated from `rg -l "^(<<<<<<<|=======|>>>>>>>)"`.
- Use this list as a volatile coordination map; re-open each file before editing because other agents may resolve items in parallel.
=======
>>>>>>> laraxot/dev
