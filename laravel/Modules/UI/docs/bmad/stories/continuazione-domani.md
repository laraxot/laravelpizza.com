---
title: "Continuazione BMAD: Domani (regressione marker docs/architecture.md + Geo boundary InteractiveMap)"
type: module-fix
scope: UI
epic: "root-hygiene-conflict-markers"
bmad_version: v3.30.1
updated_at: '2026-09-22'
status: in-progress
related:
  - ./root-hygiene-conflict-markers.story.md
  - ../../stories/ui-readme-architecture-conflict-cleanup.story.md
  - ../../stories/18-1-drift-sync-tier1.story.md
  - ../../stories/7.15-interactivemap-geo-boundary-violation.story.md
  - ../../stories/7.1.phpstan-filament-state-components.story.md
  - ../../stories/7.2.phpstan-test-bootstrap-security.story.md
  - ../../stories/7.4.phpstan-business-deep-coverage-contracts.story.md
updated: 2026-10-07
tags: [docs, ui, bmad]
qmd: "ui   continuazione domani ui"
---

# UI: Continuazione Domani

## Stato verificato ora (sessione 2026-09-22, post cleanup marker root)

- Commit recenti reali: `fdda5618` (rimossi `ARCHITECTURE.md`/`PHILOSOPHY.md`/`TESTING.md` root con marker irrisolti) e `e6bb00a1` (risolti marker in `.github/contributing.md` e `README.md` root, corretto `.gitignore` graphify-out): verificato: `README.md` root ora **0 marker**.
- Story `docs/bmad/stories/root-hygiene-conflict-markers.story.md` (status `review`) copre esattamente questi due commit: lavoro fatto, manca solo il flip a `done`.
- **Il modulo e' scritto in questo momento da un daemon auto-commit concorrente** (commit `.`, autore `marco76tv`/`Marco Xot`): durante *questa stessa sessione* e' arrivato un nuovo commit `c6a14359` (`.`) che ha committato i due file BMAD boilerplate (`docs/bmad/architecture.md` e questo file, prima untracked): stessa firma nota nel second brain per il "daemon auto-commit locale sui moduli". `dev` risulta comunque allineato a `laraxot/dev` (0 ahead/behind) al momento della verifica.

## Priorita' #1 domani: `docs/architecture.md` ha marker di conflitto REGREDITI, non risolti

`git show 5b5b8576:docs/architecture.md` = 707 righe, **0 marker** (quel commit, descritto in `ui-readme-architecture-conflict-cleanup.story.md` status `done-partial`, aveva davvero pulito il file). Il commit daemon `8f946a06` (autore `marco76tv`, messaggio `.`), immediatamente successivo, ha **reintrodotto** il blocco marcato: il file torna a 1367 righe con 6 marker (`<<<<<<< HEAD` a riga 655 e 657, `=======` a 656 e 658, `>>>>>>> laraxot/dev` a 1313 e 1314, verificato con grep). Stato **ancora presente ora** su HEAD `c6a14359`: ne' `fdda5618` ne' `e6bb00a1` hanno toccato `docs/architecture.md`. Fix: strip innermost-first come gia' fatto in `5b5b8576` (contenuto identico, e' un puro regress del daemon, non un nuovo conflitto reale: comunque diff riga per riga prima di tagliare).

## Altri task aperti, in ordine di priorita'

1. `docs/stories/7.15-interactivemap-geo-boundary-violation.story.md` (status `backlog`): `app/Livewire/Components/Map/InteractiveMap.php` ha **9** soppressioni `@phpstan-ignore-next-line` (`class.notFound`/`assign.propertyType`/`return.type`, righe 139, 141, 143, 168, 170, 200, 202, 248, 251, verificato con grep) per import `Modules\Geo\Services\*` assente, stessa firma del precedente `LocationSelector.php` (rimosso in story 7.14 per decisione utente esplicita). Eseguito il check che la story stessa chiedeva: `git log -S "Modules\\Geo" -- app/Livewire/Components/Map/InteractiveMap.php` **non produce alcun commit**: a differenza di `LocationSelector.php` non c'e' una decisione pregressa specifica per questo file. Da chiedere esplicitamente all'utente se il dominio Geo va reintrodotto o il componente rimosso: non assumere.
2. `docs/stories/18-1-drift-sync-tier1.story.md` (status `todo`, epic 18): premessa (UI 1485 commit dietro `laraxot/dev`, dati 2026-09-06) **verificata obsoleta ora**: `git status --short --branch` mostra `dev...laraxot/dev` senza ahead/behind, cioe' gia' sincronizzato. Da ri-triagare/chiudere come superata invece di eseguire i 4 AC cosi' come scritti.
3. Story epic 7 in stato `review` da riverificare prima di chiuderle (nessuna evidenza qui che l'implementazione sia incompleta, solo che lo status non e' stato promosso a `done`): `7.1.phpstan-filament-state-components.story.md` (i checkbox Tasks sono ancora tutti `[ ]` nonostante `status: review`: verificare se e' un disallineamento status/checkbox o lavoro davvero non iniziato), `7.2.phpstan-test-bootstrap-security.story.md`, `7.4.phpstan-business-deep-coverage-contracts.story.md`.
4. Segnali minori in `app/` (pochi, citati per intero, non un dump): 2 `TODO` reali (`app/Filament/Widgets/UserCalendarWidget.php:89`, `app/Actions/Panel/ApplyCalendarToPanelAction.php:22`: entrambi rimandano a un pacchetto FullCalendar/Filament v4 non ancora disponibile, non azionabili subito) e 2 file con `dddx(...)` commentato (debug residuo in `app/Filament/Widgets/OverlookWidget.php:51`, `app/Filament/Blocks/Slider.php:20,23`: rimozione a costo zero quando si tocca quel file).

## Second brain

`qmd query` su "UI docs architecture.md marker daemon regress 8f946a06" prima di riprendere (per non ripetere la stessa diagnosi); `qmd update` dopo la chiusura del punto 1.