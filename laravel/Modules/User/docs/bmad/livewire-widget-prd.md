---
title: "PRD: campagna solo Filament widget"
type: prd
module: User
status: approved
track: campaign
version: "1.0"
related:
  - ./livewire-widget-product-brief.md
  - ./livewire-widget-tech-spec.md
  - ./livewire-widget-architecture.md
  - ./livewire-inventory.md
  - ./prd.md
  - ./epics.md
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "prd: http/livewire → solo filament widget user"
---

# PRD: Http/Livewire → solo Filament widget

**Track:** campagna (Epic 9 + Epic 10).  
**Cosa/perché** qui. **Come** in [livewire-widget-architecture.md](./livewire-widget-architecture.md) e [livewire-widget-tech-spec.md](./livewire-widget-tech-spec.md).  
Inventario SSoT: [livewire-inventory.md](./livewire-inventory.md).

Il PRD SuperAdmin ([prd.md](./prd.md)) resta valido per FR-001…006 dell’Epic 9. Questo file **non** li duplica.

## Executive summary

**Problema:** 14 Livewire HTTP + 3 hook alias nel panel.  
**Soluzione:** chrome → widget + hook FQCN; auth → tenere i widget esistenti e cancellare i gemelli; Gdpr leftover → fuori da User.  
**Valore:** `/admin` non dipende più da un secondo stack.  
**Esito:** cartella `Http/Livewire` vuota; provider senza alias.

## Current → desired

- **Current:** tre `@livewire('alias')` attivi; auth HTTP orfana con `ViewCopyAction`; Privacy/Terms in User.
- **Desired:** tre FQCN widget; auth solo widget/tema; Privacy/Terms in Gdpr; DeleteAccount come widget profilo o pagina Filament.

## Goals

1. Un contenitore UI per il chrome Filament.
2. Zero side-effect filesystem in `render()`.
3. Nessuna seconda implementazione di login/register/password.
4. SuperAdmin resta il pathfinder (Epic 9), non l’unica conversione.

## Functional requirements

### FR-C001: Chrome senza alias: [MUST]

I tre hook attivi montano FQCN widget, non stringhe `profile.super-admin` / `team.change` / `socialite.buttons`.  
**Epic:** 9.2, 10.1, 10.2

### FR-C002: Team switcher widget: [MUST]

Stesso comportamento di `Team\Change` (`switchTeam`, abort 403, notify, redirect 303 a `filament.path`). `$isDiscovered = false`.  
**Epic:** 10.1

### FR-C003: Social login dal widget esistente: [MUST]

Hook login-form-after usa `SocialLoginWidget`, non `Socialite\Buttons`. Non creare un terzo widget.  
**Epic:** 10.2

### FR-C004: Ritiro auth HTTP: [MUST]

Classi Cluster B assenti dopo verifica grep (nessuna route, nessun `@livewire` alias). SSoT = widget già in `Filament/Widgets/Auth`. Unificare i doppi logout/reset **scegliendo** un widget, non aggiungendone.  
**Epic:** 10.3

### FR-C005: Zero ViewCopyAction in render User: [MUST]

Nessun `ViewCopyAction` nei componenti UI User.  
**Epic:** 10.3

### FR-C006: DeleteAccount nel mondo Filament: [MUST]

UI cancellazione account via widget o pagina profilo; `DeleteUserAction` invariata; testi da lang, niente toast IT hardcoded.  
**Epic:** 10.4

### FR-C007: Privacy/Terms fuori User: [MUST]

Classi `PrivacyPolicy` e `TermsOfService` ritirate da User. Non decommentare l’hook terms nel provider.  
**Epic:** 10.4

### FR-C008: Inventario rispettato: [SHOULD]

Fuori campagna resta fuori (Notify, `notifications`, Resource).  
**Epic:** 10

## Non-functional

### NFR-C-SEC-001

Nessun user-id in query string per toggle/switch/delete. Solo utente autenticato corrente.

### NFR-C-REL-001

`/admin` non 500 se manca un namespace vista Jet. Viste `user::` o `user::filament.widgets`.

### NFR-C-PERF-001

Niente copy disco a request. Widget chrome non in dashboard grid.

### NFR-C-OPS-001

Implementazione **dopo** le story `ready-for-dev`. Questa sessione è docs.

## Out of scope

- Implementare PHP in questa sessione.
- Cambiare Spatie / seed ruoli.
- Riattivare Volt in `routes/auth.php`.
- Unificare i due `LogoutWidget` oltre la scelta SSoT in 10.3 (se serve un follow-up, nuova story).
- Impersonation.

## Success

- [ ] FR-C001…007
- [ ] Epic 9 e 10 `done` (codice futuro)
- [ ] Issue [#100](https://github.com/laraxot/module_user_fila5/issues/100) chiudibile
