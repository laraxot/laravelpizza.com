---
title: Code quality: strict_types Cms factories + Media
type: story
module: Cms
status: ready-for-dev
priority: P1
created: 2026-10-20
updated: 2026-10-20
tags: [bmad, code-quality, strict-types, cms, media]
qmd: "declare strict_types cms factories migrations seeders media awstest"
related:
  - ./tomorrow-handoff.story.md
  - ./code-quality-pint-xot-cms-user.story.md
  - ../bmad/code-quality-wave.md
  - ../conventions/code-quality-checklist.md
---

<!--
GateGuard facts:
1. Supersedes checklist note that 17 files missing strict_types were left untouched.
2. Linked from tomorrow-handoff.story.md row 1b.
3. New story under existing Modules/Xot/docs/stories/.
4. User verbatim: "fa tutte le bmad stories per continuare domani"
-->

# strict_types: Cms database + Media AwsTest

## Perche'

Manca `declare(strict_types=1)` su ~16 file Cms (Factories/Migrations/Seeders) e 1
Media test page. Coerenza tipizzata riduce sorprese runtime.

## Owned scope

- `Modules/Cms/database/Factories/**/*.php`
- `Modules/Cms/database/Migrations/**/*.php` (solo se manca strict_types)
- `Modules/Cms/database/Seeders/**/*.php`
- `Modules/Media/app/Filament/Clusters/**/AwsTest.php` (path da rimisurare)

**Non toccare:** Filament Resources Cms (pint story), Actions, Livewire.

## Tasks

1. Rimisurare con `rg -L 'declare\(strict_types=1\)'` sul perimetro.
2. Aggiungere `declare(strict_types=1);` dopo `<?php` senza altre modifiche.
3. `php -l` batch; PHPStan se i path sono in analyse.
4. Aggiornare checklist + handoff.

## Acceptance

- [ ] Zero file owned senza `strict_types`
- [ ] Nessuna modifica di logica
- [ ] Checklist con conteggio residuo globale

## Testing strategy

`php -l`; Pest solo se un factory test fallisce per tipizzazione stretta.
