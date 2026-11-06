---
title: "Architecture: solo Filament widget"
type: architecture
module: User
status: approved
track: campaign
source_prd: ./livewire-widget-prd.md
related:
  - ./architecture.md
  - ./livewire-widget-tech-spec.md
  - ./livewire-inventory.md
  - ./decision-log.md
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "architecture: un albero ui filament user"
---

# Architecture: un albero UI Filament

**PRD campagna:** [livewire-widget-prd.md](./livewire-widget-prd.md)  
**Slice SuperAdmin:** [architecture.md](./architecture.md) (ADR-001…004 restano).

## 1. Overview

UI admin = Filament. Widget = Livewire **specializzato** (discovery, `canView`, hook). `Http\Livewire` per il panel è un adattatore storico Jet.

**In:** inventario, hook FQCN, ritiro HTTP, confine Gdpr.  
**Out:** RBAC seed, Notify, Volt.

**Driver:** NFR-C-REL-001 (`/admin` non muore per un namespace), FR-C001.

## 2. Pattern

```
AdminPanelProvider
  ├─ login.form.after  → SocialLoginWidget (già esiste)
  └─ user-menu.before  → TeamChangeWidget + SuperAdminWidget
Filament/Widgets/Auth/*  → SSoT login/register/password/logout
Http/Livewire            → vuoto
Gdpr                     → privacy / terms
DeleteUserAction         → invariata, chiamata dal widget profilo
```

## 3. ADR campagna

### ADR-C001: Widget è il contenitore, non “in più”

Non si affianca un widget al Livewire HTTP. Si sostituisce, poi si cancella. Due UI = bug di sicurezza (login) o 500 (chrome).

### ADR-C002: Gemello esistente batte classe nuova

`SocialLoginWidget` esiste: 10.2 è switch hook + parametro route panel vs FO, non `ButtonsWidget`. Stesso per Cluster B.

### ADR-C003: Chrome: `$isDiscovered = false`

User menu e login-after non sono KPI. `discoverWidgets` li metterebbe in dashboard.

### ADR-C004: Provider: un hook per story

`AdminPanelProvider` è un file. 9.2 SuperAdmin, 10.1 team, 10.2 social. Mai tre hook nella stessa story.

### ADR-C005: ViewCopyAction è un anti-pattern

Copiare viste a runtime non è theming: è mutazione disco. Il tema vince a **compile/deploy**, non a `render()`.

### ADR-C006: Gdpr possiede legal text

User non serve Privacy/Terms. L’hook commentato è già la decisione.

### ADR-C007: Categoria: chrome vs pagina vs ritiro

Widget = frammento nel panel. Pagina auth/legal ≠ widget forzato. HTTP gemello di un widget esistente = **ritiro**, non Page nuova. Legal = Gdpr. Notify vendor = fuori User (hook attivo nel modulo Notify).

## 4. Trade-off

Tenere HTTP “perché Volt è commentato”: falso. I widget auth sono già registrati in `registerLivewireAuthWidgets()`. HTTP Login non ha route.

Creare widget verify prima di scegliere la route SSoT: over-scope. 10.3 ritira HTTP Verify; la pagina verify è epic FO/tema.

## 5. Deploy

Nessuna migrazione. `view:clear` dopo switch hook. Nessun env.

## 6. FR coverage

| FR | Dove |
|----|------|
| C001 | AdminPanelProvider (9.2, 10.1, 10.2) |
| C002 | TeamChangeWidget |
| C003 | SocialLoginWidget + hook |
| C004–C005 | delete Cluster B |
| C006 | DeleteAccount widget/page |
| C007 | delete Privacy/Terms User |
