# bmad method

## Scopo (business logic)

BMAD Method serve a rendere **ripetibile** lo sviluppo AI-driven su una codebase modulare grande:
- riduce duplicazioni tra agenti,
- rende esplicite le decisioni (requisiti, architettura, test),
- produce artefatti riutilizzabili (PRD, epics/stories, piani test, documentazione),
- aiuta a mantenere qualità e tracciabilità quando i task durano più sessioni.

## Dove vive BMAD in questo repo

- **Workflows e agenti**: `_bmad/`
- **Contesto progetto per BMAD**: `_bmad/bmm/workflows/bmad-generate-project-context/project-context-ptvx.md`
- **Coordinamento multi-agente**: `docs/ai-agent-coordination.md`
- **Integrazione progetto (overview)**: `docs/project/bmad-method-integration.md`
- **Sintesi**: `docs/bmad/bmad-integration-summary.md`

## Come iniziare (operativo)

- **Se non sai cosa fare dopo**: usa `bmad-help`
- **Se devi progettare** (architettura/storie): usa workflow BMAD (PM/Architect), poi passa a dev/qa
- **Se devi implementare**: `bmad-dev` (con QA quando tocchi flussi critici o test)

## Quando usare BMAD vs GSD

- **BMAD**: nuovo modulo, architettura, epics/stories, sprint planning, documentazione ampia
- **GSD**: feature o bugfix complessi ma “task-atomici”, con wave execution e verify step

## Vincoli Laraxot (sempre)

- No Services: usare Actions
- No `Log::*` in produzione
- Filament: usare XotBase; vietati `->label()`, `->placeholder()`, `->helperText()`; niente override di `table()` nei RelationManager/Widget
- PHPStan: non toccare `laravel/phpstan.neon`
- Docs: file `.md` in minuscolo (eccetto `README.md`), niente date nel contenuto, link interni relativi

## Install/update upstream (riferimento)

Installazione ufficiale BMAD Method: vedi [BMAD-METHOD](https://github.com/bmad-code-org/BMAD-METHOD) (quick start: `npx bmad-method install`).

