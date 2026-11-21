---
title: "Media — epic 5.250: architettura e contratto API modulo"
type: epic
tags: [media, architecture, contract, module-boundary]
created: 2026-09-28
updated: 2026-09-28
qmd: "Media epic architettura contratto API modulo confini dipendenze"
related:
  - ../architecture.md
  - ../architecture/module-boundary.md
  - ./module-roadmap.md
  - ../stories/module-bmad-audit-20260928.story.md
  - ../../../../Xot/docs/bmad-method.md
---

# Epic 5.250 — architettura e contratto API modulo Media

> **SUMMARY**: epic per stabilire e documentare il contratto API pubblica del
> modulo `Modules\Media`, i confini di dipendenza e le invarianti architetturali.
> Scope: documentazione derivata dal codice reale, zero modifiche PHP.
> Grounded in `module.json`, `composer.json`, `app/Models/`, `app/Actions/`,
> `app/Filament/Resources/`, `app/Contracts/`.

## Scope

Il modulo Media gestisce upload, conversioni (FFmpeg, Intervention), diagnostica
AWS/S3/CloudFront e integrazione con Spatie MediaLibrary. Questa epic documenta:

1. Namespace e providers ufficiali (`module.json`)
2. Modelli e relazioni (Eloquent magic properties)
3. API pubblica: Action, Contracts, Resource Filament
4. Dipendenze esterne (`composer.json`)
5. Invarianti e confini (connessione DB `media`, estensione `XotBaseModel`)

## Fonti verificate

| Fonte | Path |
|---|---|
| `module.json` | `module.json` |
| `composer.json` | `composer.json` |
| Models | `app/Models/` (4 file) |
| Policies | `app/Models/Policies/` (4 file) |
| Resources | `app/Filament/Resources/` (4 resource + shard) |
| Actions | `app/Actions/` (32 file in sottodir) |
| Contracts | `app/Contracts/` (2 file) |
| Providers | `app/Providers/` (3 file) |
| Console | `app/Console/Commands/` (1 file) |
| Enums | `app/Enums/` (1 file) |
| Services | `app/Services/` (2 file) |
| Migrations | `database/migrations/` (6 file) |
| Shard architettura | `docs/bmad/architecture/module-boundary.md` |
| Shard brainstorming | `docs/bmad/brainstorming/module-opportunities.md` |

## Task

- [x] T1 — Inventariare modelli e relazioni in `app/Models/`
- [x] T2 — Mappare resource Filament e schemi in `app/Filament/Resources/`
- [x] T3 — Catalogare action per area (`S3/`, `CloudFront/`, `Ffmpeg/`, `Subtitle/`, `Diagnostic/`)
- [x] T4 — Verificare dipendenze in `composer.json`
- [x] T5 — Redigere `architecture.md` (indice root → shard)
- [x] T6 — Redigere `README.md` (indice verificato)
- [x] T7 — Redigere `quick-reference.md` e `setup-guide.md`

## Acceptance Criteria

- [AC1] `docs/bmad/README.md` esiste e linka tutti i file canonici verificati
- [AC2] `docs/bmad/architecture.md` è un indice con link a
  `architecture/module-boundary.md` (non sovrascritto)
- [AC3] `docs/bmad/brainstorming.md` è un indice con link a
  `brainstorming/module-opportunities.md` (non sovrascritto)
- [AC4] Tabella "file → responsabilità" in `README.md` con path reali
- [AC5] Nessun file PHP modificato (`git status` mostra solo `docs/`)
- [AC6] Ogni path citato nel corpo esiste: `test -e <path>` verificato

## Dependencies

- Nessuna dipendenza da altre epiche per la fase di documentazione.
- La fase di refactoring (se futura) dipenderà da story BMAD separate.

## DoD

- Documentazione architetturale completa e linkata
- Tutti i path verificati con `test -e`
- Lock rispettati per ogni scrittura
- Esito riportato in story correlata
