---
title: "UserResource — clustering RelationManager, widget reali, audit action riusabili"
module: User
status: review
created: 2026-09-29
updated: 2026-09-29
owned_scope:
  - app/Filament/Resources/UserResource.php
  - app/Filament/Resources/UserResource/RelationManagers/**
  - app/Filament/Resources/UserResource/Widgets/**
  - app/Filament/Resources/UserResource/Pages/ViewUser.php
  - app/Filament/Actions/Header/AttachRoleAction.php
  - lang/it/user.php
  - lang/en/user.php
related:
  - ../../wiki/user-resource-clustering-widgets-actions-audit.md
  - ./filament-ux-brainstorming.md
excluded_scope:
  - app/Filament/Widgets/Auth/**  # owner concorrente PID 5418, in-progress su sprint-status.yaml
  - app/Filament/Widgets/Profile/DeleteAccountWidget.php
  - app/Filament/Widgets/PrivacyPolicyWidget.php
---

# Story: audit + interventi su clustering, widget e action di UserResource

## Obiettivo

Migliorare `Modules/User` sul fronte Filament: valutare il clustering di
RelationManager/Widgets/Actions, individuare ridondanze, applicare miglioramenti DRY +
KISS + UI/UX + accessibilita' a basso rischio, senza toccare l'area Auth Widgets
posseduta da un altro processo in corso in parallelo.

## Contesto

`UserResource` aveva 10 RelationManager tutti su tab separate (auto-discovery via
`XotBaseResource::getRelations()`, nessun raggruppamento), due widget del tutto
placeholder (`UserOverview`, `UserWidget`), e diverse action icon-only senza
`->tooltip()` (unico meccanismo aria-label per bottoni icona-sola in Filament).

## Acceptance criteria

- [x] Verificato nel codice vendor (non assunto dalla doc) se Filament v4 supporta un
      raggruppamento reale di RelationManager sotto una tab — **si', `RelationGroup`**.
- [x] Implementato il clustering (`UserResource::getRelations()`), da 9 a 4 tab
      (dopo rimozione duplicato, vedi sotto), raggruppamento Sicurezza/Organizzazione
      + due tab standalone (Profilo, Social login).
- [x] Individuata e risolta una ridondanza reale: `TokensRelationManager` e
      `OauthTokensRelationManager` puntavano alla stessa relazione Eloquent `tokens`.
      Rimosso il piu' debole/rischioso (`TokensRelationManager`).
- [x] `UserOverview`: verificato via git log + contesto d'uso che era un placeholder
      non funzionante (mostrava sempre "Utente" statico su una pagina lista senza
      `$record`). Trasformato in widget di statistiche reali riusando la base
      esistente `XotBaseStatsOverviewWidget` (pattern gia' in uso in `Rating`, `Xot`).
- [x] `UserWidget`: verificato via git log + docblock esplicito che era debug/verifica
      filtri, ridondante col form filtri sopra. Rimosso (file, vista, riferimento in
      `ViewUser`).
- [x] Cercata riusabilita' cross-modulo di `ChangePasswordAction`, `VerifyEmailAction`,
      `SendOtpAction` (grep sull'intero monorepo): nessuna duplicazione, nessuno
      spostamento verso `Xot` (evitato over-engineering senza secondo consumer reale).
- [x] `SendOtpAction`: premessa del task ("manca tooltip") falsificata — ha gia' un
      tooltip; il problema reale (segnalato, non risolto: e' una decisione di prodotto)
      e' che non e' invocata da nessuna parte nel modulo.
- [x] Corretti i gap reali di accessibilita' trovati: `EditAction`/`DetachAction`
      icon-only senza tooltip in `DevicesRelationManager`, `TenantsRelationManager`,
      `RolesRelationManager`, `ClientsRelationManager` (default ereditato da
      `XotBaseRelationManager` in `Modules/Xot`, non toccato: fuori scope, root cause
      condivisa con tutto il monorepo).
- [x] Badge di conteggio + icone semantiche sulle tab standalone rimaste
      (`ProfileRelationManager`, `SocialiteUsersRelationManager`), deferred per non
      appesantire il render iniziale.
- [ ] **Verifica visiva Filament (browser) della pagina `ViewUser` con le tab
      raggruppate — NON eseguita in questa sessione** (Playwright MCP e browser
      in-app non connessi, `CONNECTION_CLOSED`). Bloccante prima di chiudere la story
      come "done" definitivo.
- [ ] Pest gate (regola progetto #9): non eseguito in questa sessione per istruzione
      esplicita del coordinatore — demandato all'agente coordinatore sull'insieme
      delle modifiche parallele. Story resta `review`, non `done`, finche' non
      arriva conferma verde.

## Decisioni chiave (motivazione estesa in docs/wiki/user-resource-clustering-widgets-actions-audit.md)

1. **Clustering via `RelationGroup`**: nativo Filament v4, non un hack. Stack verticale
   di piu' RelationManager dentro una tab (non sub-tab con selettore) — tradeoff
   accettato per ridurre il rumore nella barra tab.
2. **Rimozione `TokensRelationManager`**: duplicato reale sulla stessa relazione,
   confermato via docblock modello + storia git (nessun refinement successivo, a
   differenza del gemello mantenuto).
3. **`UserOverview` riscritto, non solo pulito**: era codice morto de facto (mai
   mostrava altro che "Utente"), coerente con l'opzione (a) del task.
4. **`UserWidget` rimosso, non ridotto**: nessun valore informativo, confermato dead
   weight, coerente con l'opzione (b) del task.
5. **Nessuno spostamento delle 3 Action verso Xot**: zero duplicazione cross-modulo
   trovata, astrazione prematura evitata (YAGNI).
6. **`XotBaseRelationManager` (Xot) non toccato**: root cause reale del gap
   accessibilita' di default, ma fuori scope assegnato e alto raggio d'impatto
   (condiviso da tutti i moduli) — segnalato, non modificato.

## File modificati

Vedi elenco completo in `docs/wiki/user-resource-clustering-widgets-actions-audit.md#file-toccati`.

## Verifica eseguita

- `php -l` su tutti i file PHP toccati: nessun errore di sintassi.
- Lettura vendor Filament (`RelationGroup.php`, `HasRelationManagers.php`,
  `InteractsWithRelationshipTable.php`, `Stat.php`) per confermare le API usate
  esistono con la firma attesa nella versione installata.
- Grep sull'intero monorepo per riusabilita' Actions e per riferimenti residui ai file
  rimossi (`TokensRelationManager`, `UserWidget`): nessun riferimento orfano trovato.

## Da fare (fuori scope di questa story, segnalato)

- Verifica visiva browser delle 4 tab raggruppate su `ViewUser`.
- PHPStan + Pest gate sull'insieme delle modifiche (coordinatore).
- Valutare se aggiungere `->tooltip()` ai default di
  `Modules/Xot/app/Filament/Resources/RelationManagers/XotBaseRelationManager.php`
  (impatta tutti i moduli, richiede owner Xot).
- Decisione prodotto su `SendOtpAction` (agganciarla a una UI o rimuoverla).
- `ViewUser::filtersForm()` senza piu' consumer dopo rimozione `UserWidget`: valutare
  filtro reale (es. su `AuthenticationLogsRelationManager`) o rimozione.
- `BaseUserResource.php` risulta non estesa da nessuna classe (probabile dead code),
  fuori scope di questa story.
