---
type: decision
title: "BMAD: Xot: Action conversion (Services → Queueable Actions, framework wave)"
status: verified
updated: 2026-10-20
date: 2026-10-20
module: Xot
tags: [xot, actions, queueable-action, services-to-actions, framework, no-services, bmad, verified]
related:
  - ../bmad/brainstorming-services-to-actions-wave.md
  - ../stories/services-to-actions-global-wave.story.md
  - ../decision-log.md
qmd: "decisione bmad   xot: action conversion (framework base) xot"
---

# Decisione BMAD: Xot: Action conversion (framework base)

## Perché esiste questo file
Documenta la conversione dei servizi framework (`Xot`) da `app/Services/` (assente per policy) verso `app/Actions/` (62 Actions). Il modulo Xot è il base framework per tutti gli altri moduli (`BaseResource`, `BasePage`, `BasePanelProvider`, dispatcher, contratti, traduzioni).

## Scopo
- Confermare `Modules/Xot/app/Services/` assente per policy (ratchet `archAllowedServicesDirs()` = `[]`)
- Registrare che `app/Actions/` contiene 62 classi Action (`ConfigAction`, `ArrayAction`, `Blade/`, `Artisan/`, `Composer/`, `Debug/`, `Export/`, `AI/`)
- Documentare che `BaseResource`, `BasePage`, `BasePanelProvider` restano come contratti/framework (non Actions), ma tutta la logica operativa vive in Actions

## Decisione
**Choose:** `app/Services/` assente; logica operativa in `app/Actions/` (62 file); contratti framework (`Contracts/`, `Models/`, `BaseResource`, `BasePage`, `BasePanelProvider`) mantenuti come layer infrastrutturale.

**Over:** mantenere `app/Services/` come layer «infrastrutturale» separato; ricreare `Service` wrapper per dispatcher/transazioni.

**Because:**
- Regola No-Services: anche il framework base non deve avere eccezioni; `Service` = monolite stateful senza confini
- `QueueableAction` fornisce `execute()` tipizzato, accodabile, testabile, conforme a `Spatie\LaravelQueueableAction`
- 0 chiamanti `app/Services/` in produzione (`find Modules/Xot/app/Services/` = 0)
- Equivalenza dimostrata: `Actions/` copre dispatcher (`ExecuteArtisanCommandAction`, `ConfigAction`), array (`ArrayAction`), blade (`Blade/`), AI (`AI/`), composer (`Composer/`)

## Verifica
- `find Modules/Xot/app/Services/` = 0 file, 0 directory
- `find Modules/Xot/app/Actions/` = 62 file (subdir incluse)
- `php artisan about` parte; `php artisan test` passa; PHPStan `analyse Modules` → 0 errori (wave3)
- `docs/INDEX.md` aggiornato con status verified, date 2026-10-20, link a `docs/decisions/action-conversion.md`

## Non appianato / Open
- `Service/` (directory storica) mantenuta solo come riferimento architetturale (`service-provider.md`, `service-providers.md`), non come `app/Services/`
- `bmad/brainstorming-services-to-actions-wave.md` traccia la storia della conversione a livello globale
