---
title: "Continuazione BMAD: Domani (User)"
type: module-fix
scope: User
epic: "10"
bmad_version: v3.30.1
updated_at: '2026-09-22'
status: in-progress
related:
  - ../../stories/user-nested-conflict-marker-cleanup.story.md
  - ./livewire-residual-conversion-cluster-c.story.md
  - ./uppercase-application-dir.story.md
  - ../../stories/12.5.filament-artifacts-cleanup.story.md
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "user   continuazione domani user"
---

# User: Continuazione Domani

## Stato verificato ora (sessione 2026-09-22)

- Riconciliazione divergenza `dev`/`laraxot-dev` (`db4ea2a9`, "ahead 60/behind
  80"): **fatta e pushata**. `git branch -vv` oggi: `dev` == `[laraxot/dev]`
  in punta (`6a799fb1`), `git rev-list --left-right --count dev...laraxot/dev`
  → `0 0`. Documentata in
  `docs/stories/user-nested-conflict-marker-cleanup.story.md`
  (addendum "riconciliazione completata").
- **Rischio residuo reale nel merge, verificato oggi (non solo ipotizzato)**:
  dei 36 conflitti, 29 file `UU` sono stati risolti in blocco con
  `git checkout --ours` dopo aver verificato il pattern (marker-di-conflitto
  senza contenuto reale in conflitto) su un **campione di soli 5 file**
  (`.github/contributing.md`, `docs/bmad/README.md`, `docs/purpose.md`,
  `tests/Unit/Datas/UserDatasAndEnumsCoverageTest.php`, `ModulesRelationManager.wip`).
  Ho verificato oggi 3 dei restanti 24 file non campionati:
  - `docs/bmad/epics.md`: il lato `laraxot/dev` (righe 272-375 di
    `ff41cfea:docs/bmad/epics.md`) **non era rumore**: era un secondo
    documento "Epics: Http/Livewire → Filament widget" (Epic 9/10,
    FR-00x → `prd.md`, ADR → `architecture.md`) completamente diverso dal
    lato `HEAD` ("Documentation Hygiene" epics) tenuto con `--ours`. Verificato
    che le story figlie citate (`9.1.super-admin-widget.story.md`,
    `10.1.team-change-widget.story.md`, `10.4.retire-gdpr-profile-livewire.story.md`)
    **esistono comunque** in `docs/stories/`: quindi il lavoro non e' perso,
    ma la prosa che collegava gli anchor FR-00x/ADR tra `epics.md`/`prd.md`/
    `architecture.md` per Epic 9/10 e' sparita da questi 3 file (recuperabile
    solo da `git show ff41cfea:docs/bmad/epics.md`).
  - `docs/bmad/architecture.md` e `docs/bmad/prd.md`: stesso pattern esatto
    (marker a riga 1/270/375 e 1/147/270), stesso verdetto: contenuto
    scartato ma non univoco (verosimilmente lo stesso doc satellite Epic 9/10).
  - `docs/bmad/decision-log.md`: lato scartato **negligibile** (righe 229-230,
    sostanzialmente vuoto): nessun rischio qui.
  - **Non verificati**: gli altri ~21 file della lista dei 29 (es.
    `resources/views/docs/html2pdf/*.md`, `docs/dry-kiss-analysis.md`,
    `docs/quality-status-activity-module-november.md`, ecc.): probabilita' alta che siano
    genuinamente solo rumore del daemon (come i 5 campionati), ma non e' stato
    riverificato uno per uno.
- `uppercase-application-dir.story.md` (status frontmatter: `review`, "Commit
  deferred"): il `git rm Application/UseCases/Owners/
  GetAllOwnersRelationshipUseCaseContract.php` che proponeva **e' gia' stato
  eseguito** dentro il merge `db4ea2a9` ("Deletion staged pre-esistente...
  inclusa nel commit"). La story ha lo status disallineato dal codice reale -
  andrebbe marcata `done`, non toccata qui perche' fuori scope per questo file.
- `livewire-residual-conversion-cluster-c.story.md` (10.4-residual-livewire,
  status `blocked` su "lock peer `user-9.8-icons`"): **nessun file `9.8` e
  nessun lock esistono nel repo oggi**: le story icone correlate (`9.5`,
  `9.6`, `9.7`, `9.9`) sono tutte `done`. Il blocco sembra risolto lato
  dipendenza tecnica; resta solo "priorita' utente" citata nella stessa nota.
- `app/Http/Livewire/TermsOfService.php:32`: `testfunction()` con `dddx('wip')`
  **live**, metodo morto/non testato: conferma sul codice che il componente
  e' proprio uno dei residui non finiti citati dalla story cluster-C.
- `app/Http/Controllers/Api/LogoutController.php:42,47,56`: 3 `TODO`
  espliciti per logica non implementata (cleanup token OAuth, logout
  dispositivi mobile): codice commentato pronto ma mai attivato.
- `app/Models/Traits/HasTeams.php`: 6 `@phpstan-ignore` ravvicinati
  (`return.type`, `property.nonObject` x2, `argument.type`) tra le righe
  97-192: trait con tipizzazione debole, non indagato oggi.
- `git status --short`: pulito.

## Continuazione domani (in ordine di priorita')

1. **Decidere sul contenuto scartato Epic 9/10 in `docs/bmad/{epics,
   architecture,prd}.md`** (vedi sopra): recuperare da
   `git show ff41cfea:docs/bmad/epics.md` (e architecture.md/prd.md) la prosa
   con gli anchor FR-00x/ADR e valutare se re-integrarla (magari in
   `docs/bmad/livewire-widget-epics.md`, gia' dedicato alla campagna) o
   confermare esplicitamente che e' superseded dalle story dedicate in
   `docs/stories/9.*` e `10.*`: oggi e' solo scomparsa senza una decisione
   scritta.
2. **Riverificare gli ~21 file non campionati** dei 29 risolti con `--ours`
   (lista completa in `git diff-tree --no-commit-id --name-only -r -m
   db4ea2a9`) con lo stesso metodo usato sui 3 di sopra: basso rischio atteso
   ma non confermato.
3. **`livewire-residual-conversion-cluster-c.story.md`**: ririchiedere
   priorita' all'utente: il presunto blocco tecnico (`user-9.8-icons`) non
   esiste piu' nel repo, le story icone 9.5/9.6/9.7/9.9 sono `done`. Se
   confermato, passare la story da `blocked` a `ready` e procedere
   sull'inventario (`DeleteAccount`, `TermsOfService`, `PrivacyPolicy`,
   `Logout`).
4. **`app/Http/Livewire/TermsOfService.php`**: rimuovere `testfunction()`
   morto con `dddx('wip')` o completarlo: e' la prova concreta che il
   componente e' un residuo non finito (rilevante per il punto 3).
5. **Allineare lo status di `uppercase-application-dir.story.md`** da
   `review` a `done` (il `git rm` proposto e' gia' nel merge `db4ea2a9`) -
   file separato, non questo.
6. **`app/Http/Controllers/Api/LogoutController.php`**: chiudere o convertire
   in story i 3 `TODO` (cleanup token OAuth, logout mobile): oggi sono solo
   commenti, nessuna story li traccia.
7. **`app/Models/Traits/HasTeams.php`**: valutare se i 6
   `@phpstan-ignore` (righe 97-192) nascondono un problema di tipizzazione
   reale nella relazione `membershipTeams`/`allTeamUsers()`, non solo
   soppressioni cosmetiche.

## Second brain

`qmd query "User dev laraxot-dev riconciliazione merge db4ea2a9 epics.md
scartato"` prima di riprendere il punto 1-2; `qmd update` dopo ogni chiusura.
