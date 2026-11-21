---
title: "Meetup theme docs — index"
type: index
theme: Meetup
tags: [meetup, theme, docs, index]
updated: 2026-09-03
related:
  - ./README.md
  - ./wiki/index.md
---

# Meetup theme docs — index

Indice per argomento di tutti i file `.md` sotto `Themes/Meetup/docs/`. Punto di ingresso operativo: [wiki/index.md](./wiki/index.md) (wiki on-demand canonica). Vedi anche [README.md](./README.md) per la legenda cartelle.

## Overview / entry point

- [README.md](./README.md) — legenda cartelle di `docs/`
- [wiki/index.md](./wiki/index.md) — indice operativo wiki on-demand del tema (canonico)
- [wiki/README.md](./wiki/README.md) — scopo e workflow della wiki compilata

## Concetti e pattern architetturali

- [concepts/xotbase-never-extend-filament.md](./concepts/xotbase-never-extend-filament.md) — mai estendere `Filament*`, sempre `XotBase*`
- [wiki/concepts/INDEX.md](./wiki/concepts/INDEX.md) — indice concetti wiki
- [wiki/concepts/second-brain-local-discipline.md](./wiki/concepts/second-brain-local-discipline.md) — disciplina second brain locale (stub tema)
- [wiki/concepts/visual-testing-playwright-puppeteer.md](./wiki/concepts/visual-testing-playwright-puppeteer.md) — visual testing con Playwright/Puppeteer
- [wiki/concepts/cross-theme-redundancy-doc-stub.md](./wiki/concepts/cross-theme-redundancy-doc-stub.md) — analisi del pattern di stub `REDUNDANCY_ANALYSIS.md` duplicato tra piu' temi/moduli

## Wiki on-demand — sezioni

- [wiki/commands/INDEX.md](./wiki/commands/INDEX.md)
- [wiki/memories/INDEX.md](./wiki/memories/INDEX.md)
- [wiki/rules/INDEX.md](./wiki/rules/INDEX.md)
- [wiki/skills/INDEX.md](./wiki/skills/INDEX.md)
- [wiki/log.md](./wiki/log.md) — log cronologico aggiornamenti wiki

## Template wiki

- [wiki/_templates/concept.md](./wiki/_templates/concept.md)
- [wiki/_templates/entity.md](./wiki/_templates/entity.md)
- [wiki/_templates/source.md](./wiki/_templates/source.md)

## Qualita' e audit

- [code-quality-improvement-report.md](./code-quality-improvement-report.md) — baseline qualita' corrente (STORY-001, 2026-07-17)
- [redundancy-audit.md](./redundancy-audit.md) — audit ridondanza tema (2026-05-21)
- [stories/blade-i18n-no-hardcoded-text.story.md](./stories/blade-i18n-no-hardcoded-text.story.md) — niente testi fissi nelle Blade: chiavi `pub_theme::` in it, en, de, es

## LLM wiki / agent instructions

- [llm-wiki/AGENTS.md](./llm-wiki/AGENTS.md) — istruzioni agent per la wiki LLM del tema

## Note raw

- [raw/README.md](./raw/README.md)

## Storico / da consolidare

File non cancellati ma superati, duplicati o con puntatore a documentazione canonica non presente nel repo. Da consolidare in un secondo momento, non toccare senza decisione esplicita.

- [code-quality-report.md](./code-quality-report.md) — versione precedente/piu' sintetica, stessa data di [code-quality-improvement-report.md](./code-quality-improvement-report.md); quest'ultimo e' piu' completo e collegato a STORY-001
- [REDUNDANCY_ANALYSIS.md](./REDUNDANCY_ANALYSIS.md) — stub con canonical `../../docs/shared-components/REDUNDANCY_ANALYSIS.md` non presente nel repo; vedi analisi in [wiki/concepts/cross-theme-redundancy-doc-stub.md](./wiki/concepts/cross-theme-redundancy-doc-stub.md)
- [codex-error-fix.md](./codex-error-fix.md) — stub con canonical `../../docs/shared-components/codex-error-fix.md` non presente nel repo
- [merge-conflicts-list.md](./merge-conflicts-list.md) — stub con canonical `../../docs/shared-components/merge-conflicts-list.md` non presente nel repo
- [ON-DEMAND-PATTERN.md](./ON-DEMAND-PATTERN.md) — stub con canonical `../../docs/ON-DEMAND-PATTERN.md` (a livello Themes/) non presente nel repo
- [PERFORMANCE-OPTIMIZATION.md](./PERFORMANCE-OPTIMIZATION.md) — stub con canonical `../../docs/PERFORMANCE-OPTIMIZATION.md` non presente nel repo
- [PROJECT-STRUCTURE.md](./project-structure.md) — stub con canonical `../../docs/PROJECT-STRUCTURE.md` non presente nel repo
- [QMD-SETUP.md](./QMD-SETUP.md) — stub con canonical `../../docs/QMD-SETUP.md` non presente nel repo