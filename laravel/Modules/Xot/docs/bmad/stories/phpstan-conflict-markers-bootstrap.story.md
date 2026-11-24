---
title: "Xot — marker conflitto PHP e bootstrap PHPStan"
type: story
status: done
module: Xot
epic: quality
story_id: phpstan-conflict-markers-bootstrap
created: 2026-11-16
updated: 2026-11-16
tags: [xot, phpstan, git-conflict, bootstrap]
qmd: "xot conflict markers php app tests phpstan bootstrap EnvData AssetAction"
related:
  - ./8.24-merge-conflict-resolution-fleet-swarm.story.md
  - ./fleet-blocking-merge-conflict-markers.story.md
  - ../../../Job/docs/bmad/stories/phpstan-conflict-markers-bootstrap.story.md
  - ../../../Notify/docs/bmad/stories/phpstan-conflict-markers-bootstrap.story.md
---

# phpstan-conflict-markers-bootstrap (Xot)

## Scopo / perché

I marker Git nei file PHP sotto `app/` e `tests/` rompono il parser
(`unexpected token <<`) e fanno fallire il bootstrap di PHPStan su `Modules/`.
Xot è il nucleo (EnvData, migration base, asset Filament, widget env, log
artisan): un marker qui blocca la fleet, non solo il modulo.

## Lock

`bashscripts/lock/lock.sh xot-conflict-markers`

## Ambito

- `laravel/Modules/Xot/app/**/*.php` e `tests/**/*.php`
- File noti: EnvData, XotBaseMigration, InitialsAvatarProvider, EnvWidget,
  AssetAction, ShowArtisanErrorLogAction

Fuori scope primario: debito marker nei soli `.md`.

## Acceptance criteria

1. [x] Zero marker `<<<<<<<` in app/ e tests/ PHP.
2. [x] `php -l` verde (app/tests; file noti OK).
3. [x] PHPStan `Modules/Xot` documentato (exit + errori; no ignore / no mixed).
4. [x] Story BMAD + entry sprint-status.

## Esito scansione 2026-11-16

| Area | Marker | php -l |
|------|--------|--------|
| app/ | 0 | OK |
| tests/ | 0 | OK |

Marker PHP già assenti (file noti puliti). Fix collaterale PHPStan:
`FilterBuilder::dateRange` resta su `->form()` (Filament tables 5.11: `schema()` è
deprecato alias di `form()`).

Debito residuo docs: ~35 `.md` con marker (non bloccano bootstrap PHPStan).

## PHPStan

- Comando: `php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Xot`
- Exit: **0** — errori: **0**

## Note

Non re-litigare merge chiusi da 8.24 / fleet-blocking: verificare codice, non docs.
