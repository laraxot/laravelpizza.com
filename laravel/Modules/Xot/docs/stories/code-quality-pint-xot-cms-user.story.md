---
title: Code quality: Pint lotto Xot/Cms/User
type: story
module: Xot
status: ready-for-dev
priority: P1
created: 2026-10-20
updated: 2026-10-20
tags: [bmad, code-quality, pint, xot, cms, user]
qmd: "pint dirty xot cms user contracts filament code quality wave"
related:
  - ./tomorrow-handoff.story.md
  - ./code-quality-strict-types-cms-media.story.md
  - ../bmad/code-quality-wave.md
  - ../conventions/code-quality-checklist.md
  - ../bmad/filament-blueprint.md
---

<!--
GateGuard facts:
1. Supersedes nothing: new executable story from code-quality-wave "Next: Pint Cms/User".
2. Linked from tomorrow-handoff.story.md and code-quality-wave.md.
3. New file in existing docs/stories/.
4. User verbatim: "fa tutte le bmad stories per continuare domani"
-->

# Pint: lotto Xot / Cms / User

## Perche'

Il checklist qualità ha `pint --test` FAIL su contratti e Filament di Xot/Cms/User.
Formattazione incoerente nasconde diff reali e rompe review.

## Owned scope (disgiunto)

- `Modules/Xot/app/Contracts/**`
- `Modules/Xot/app/Filament/Resources/XotBaseResource.php`
- `Modules/Cms/app/Filament/Clusters/section/Resources/**` (se ancora sporchi)
- `Modules/User/app/Contracts/**`
- `Modules/User/tests/Unit/Actions/Auth/RecordAuthenticationLogActionTest.php`

**Non toccare:** Media AwsTest (altra story), Cms database factories (strict_types story), Livewire.

## Tasks

1. `cd laravel && ./vendor/bin/pint --test` → lista offender nel perimetro.
2. `./vendor/bin/pint` solo sui path owned.
3. `php -l` + PHPStan mirato (default neon).
4. Aggiornare [code-quality-checklist](../conventions/code-quality-checklist.md).

## Acceptance

- [ ] `pint --test` verde sul perimetro owned (o residui motivati fuori scope)
- [ ] Nessun cambiamento funzionale (solo stile)
- [ ] PHPStan perimetro OK
- [ ] Checklist + handoff aggiornati

## Testing strategy

`php -l` + PHPStan file-list; nessun nuovo test obbligatorio.
