---
title: "Notify — marker conflitto PHP e bootstrap PHPStan"
type: story
status: done
module: Notify
epic: quality
story_id: phpstan-conflict-markers-bootstrap
created: 2026-11-16
updated: 2026-11-16
tags: [notify, phpstan, git-conflict, bootstrap]
qmd: "notify conflict markers php MailTemplateVersion lang phpstan bootstrap"
related:
  - ./netfun-conflict-markers.story.md
  - ./git-status-fleet-merge-markers-notify.story.md
  - ../../../Xot/docs/bmad/stories/phpstan-conflict-markers-bootstrap.story.md
  - ../../../Job/docs/bmad/stories/phpstan-conflict-markers-bootstrap.story.md
---

# phpstan-conflict-markers-bootstrap (Notify)

## Scopo / perché

Marker Git nei PHP di Notify (modelli template mail, lang, tests) bloccano il
parser e il bootstrap PHPStan. `MailTemplateVersion` è dominio versioning
template: un conflitto irrisolto lì rompe analisi e runtime se il file è
caricato.

## Lock

`bashscripts/lock/lock.sh notify-conflict-markers`

## Ambito

- `app/**/*.php`, `tests/**/*.php`, `lang/**/*.php` se presenti
- File noto: `MailTemplateVersion.php`

Fuori scope primario: massa di `.md` wiki/project con marker (debito docs).

## Acceptance criteria

1. [x] Zero marker `<<<<<<<` in app/tests/lang PHP.
2. [x] `php -l` verde (incluso MailTemplateVersion).
3. [x] PHPStan `Modules/Notify` documentato.
4. [x] Story BMAD + sprint-status.

## Esito scansione 2026-11-16

| Area | Marker | php -l |
|------|--------|--------|
| app/ | 0 | OK |
| tests/ | 0 | OK |
| lang/ | 0 | OK |

Marker PHP/lang già assenti. Fix PHPStan collaterali:
- `MailTemplateVersion`: aggiunto `use SoftDeletes` (era importato ma non usato)
- `railsware/mailtrap-php` installato in root (dichiarato in Notify composer, mancava in vendor)
- `TestMailtrap` + test inbound/mailtrap tipizzati senza cast ciechi
- `config/notify.php`: `Env::get` al posto di `env()` (Larastan whitelista solo `laravel/config`)

Debito docs: ~53 `.md` con marker + duplicati UPPER/kebab (`ARCHITECTURE_ANALYSIS` vs
`architecture-analysis`, ecc.) — fuori scope PHP; consolidare in story docs dedicata.

## PHPStan

- Comando: `php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Notify`
- Exit: **0** — errori: **0**
