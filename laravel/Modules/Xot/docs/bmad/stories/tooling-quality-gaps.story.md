---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
issues: []
discussions: []
title: "Story — gap tooling quality: phpinsights assente, qmd embed backlog, graphify lento"
type: story
module: Xot
epic: quality
story_id: "tooling-quality-gaps"
status: ready
track: quality/tooling
qmd: "phpinsights install qmd embed backlog graphify update lento phpmd ruleset quality tooling gap"
related:
  - ../../../../../../bashscripts/docs/prompts/03-quality-gates.md
  - ../../../docs/bmad/stories/quality-gates-03-exec-improve.story.md
---

# tooling-quality-gaps

## Perche'

Quality gates (prompt 03 v3.32.0) girano ma con buchi documentati:

- `phpinsights`: non installato → gate sempre skipped
- `qmd embed`: ~34k hash senza vettori → ricerca semantica degradata
- `graphify update .`: >10min su monorepo → spesso saltato/background
- Pest dipende da DB 10.100.200.53: quando down, zero copertura test

## Task

- [ ] Decidere: installare `nunomaduro/phpinsights` (dev dep) o rimuovere
      il gate dal prompt 03 (onesta' documentazione)
- [ ] Schedulare `qmd embed` in batch notturno o CI (fuori sessione agente)
- [ ] Valutare `graphify update` scoped per modulo (`graphify update laravel/Modules/X`)
      invece di `.` — misurare tempi
- [ ] Documentare policy Pest: suite smoke senza DB (unit pure) vs suite DB
- [ ] Verificare `laravel/.php-cs-fixer.php` presente (peer segnala possibile
      `.php_cs` legacy)

## AC

- [ ] Ogni gate del prompt 03 o funziona o e' marcato deprecated con motivo
- [ ] Tempi graphify misurati e documentati
