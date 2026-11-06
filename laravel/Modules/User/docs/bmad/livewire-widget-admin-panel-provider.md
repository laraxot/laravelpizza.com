---
title: "AdminPanelProvider: mappa render hook → widget Filament"
type: tech-spec
module: User
status: implemented
track: campaign
verified: "2026-09-21"
related:
  - ./livewire-inventory.md
  - ./livewire-widget-architecture.md
  - ./livewire-widget-tech-spec.md
  - ../stories/9.2.admin-panel-provider-hook.story.md
  - ../stories/10.1.team-change-widget.story.md
  - ../stories/10.2.socialite-buttons-widget.story.md
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "`adminpanelprovider`: ogni hook del chrome → il suo widget user"
---

# `AdminPanelProvider`: ogni hook del chrome → il suo widget

**Solo documentazione.** Questo file è la mappa canonica del punto in cui il chrome del panel User
passa da alias Livewire HTTP a widget Filament. File di riferimento:
`Modules/User/app/Providers/Filament/AdminPanelProvider.php` (42 righe, verificato 2026-09-21).

## Stato verificato (2026-09-21)

Il provider contiene **solo tre `FilamentView::registerRenderHook` su FQCN** e nessun altro codice
attivo oltre a `parent::panel($panel)` (r. 23). Zero alias stringa nel chrome.

```php
// AdminPanelProvider.php:25-38
FilamentView::registerRenderHook(
    PanelsRenderHook::AUTH_LOGIN_FORM_AFTER,
    static fn (): string => Blade::render("@livewire('" . SocialLoginWidget::class . "')"),
);
FilamentView::registerRenderHook(
    PanelsRenderHook::USER_MENU_BEFORE,
    static fn (): string => Blade::render("@livewire('" . TeamChangeWidget::class . "')"),
);
FilamentView::registerRenderHook(
    PanelsRenderHook::USER_MENU_BEFORE,
    static fn (): string => Blade::render("@livewire('" . SuperAdminWidget::class . "')"),
);
```

## Tabella hook → sostituto

| Hook Filament | Prima (alias HTTP) | Dopo (FQCN widget) | Righe provider | Story |
|---------------|--------------------|--------------------|----------------|-------|
| `PanelsRenderHook::AUTH_LOGIN_FORM_AFTER` (`panels::auth.login.form.after`) | `@livewire('socialite.buttons')` → `Http\Livewire\Socialite\Buttons` | `@livewire(SocialLoginWidget::class)` → `Filament\Widgets\Auth\SocialLoginWidget` | 25-28 | **10.2** |
| `PanelsRenderHook::USER_MENU_BEFORE` (`panels::user-menu.before`) | `@livewire('team.change')` → `Http\Livewire\Team\Change` | `@livewire(TeamChangeWidget::class)` → `Filament\Widgets\Team\TeamChangeWidget` | 30-33 | **10.1** |
| `PanelsRenderHook::USER_MENU_BEFORE` (`panels::user-menu.before`) | `@livewire('profile.super-admin')` → `Http\Livewire\Profile\SuperAdmin` | `@livewire(SuperAdminWidget::class)` → `Filament\Widgets\Profile\SuperAdminWidget` | 35-38 | **9.2** |

Le tre classi HTTP sostituite sono **eliminate dal disco** (verificato: `git status` mostra `D` /
file assenti; `RetiredChromeLivewireTest` fissa l’assenza).

## Dettaglio per hook

### 1. `AUTH_LOGIN_FORM_AFTER` → `SocialLoginWidget` (story 10.2)

- Widget: `Modules/User/app/Filament/Widgets/Auth/SocialLoginWidget.php`: `extends XotBaseSchemaWidget` (r. 21).
- **Nessun widget nuovo creato** (ADR-C002): il gemello esisteva già; lo switch ha richiesto solo
  l’allineamento del gap config/route documentato in
  [livewire-inventory.md](./livewire-inventory.md): `$redirectRoute` default `socialite.oauth.redirect`
  (panel), FO usa `socialite.oauth.fo.redirect`.
- Classe HTTP `Socialite\Buttons` + vista `livewire/socialite/buttons` eliminate.

### 2. `USER_MENU_BEFORE` → `TeamChangeWidget` (story 10.1)

- Widget: `Modules/User/app/Filament/Widgets/Team/TeamChangeWidget.php`: `extends XotBaseWidget` (r. 27),
  `$isDiscovered = false` (r. 29), vista `user::filament.widgets.team.change` (r. 31).
- `switchTeam()` replica i quattro effetti del Livewire HTTP: `TeamContract::switchTeam`, evento
  `TeamSwitched`, notify via lang `user::team_change_widget`, redirect `303`.
- Classe HTTP `Team\Change` eliminata.

### 3. `USER_MENU_BEFORE` → `SuperAdminWidget` (story 9.2)

- Widget: `Modules/User/app/Filament/Widgets/Profile/SuperAdminWidget.php`: `extends XotBaseWidget` (r. 18),
  `$isDiscovered = false` (r. 20), `mount()` risolve `ProfileContract` via `XotData` (rr. 25-28),
  `toggleSuperAdmin()` ritorna `redirect($this->url, 303)` (rr. 30-34), vista
  `user::filament.widgets.profile.super-admin` (r. 42).
- Classe HTTP `Profile\SuperAdmin` eliminata (story 9.3); test in 9.4
  (`tests/Unit/Filament/Widgets/SuperAdminWidgetTest.php`).

## Hook storici rimossi (non riattivare)

Nella versione pre-campagna il file conteneva due blocchi commentati, eliminati con la pulizia del
provider: documentati qui perché restano la decisione architetturale.

| Hook commentato | Destinazione decisa |
|-----------------|---------------------|
| `@livewire('terms-of-service')` su `auth.login.form.after` | **Gdpr** possiede i testi legali (ADR-C006). Non decommentare in User. |
| `@livewire('database-notifications')` su `user-menu.before` + `DatabaseNotifications::trigger` | **Notify** possiede le campanelle; il modulo Notify registra il proprio hook FQCN sul widget vendor. |
| `View::make('user::badges.super-admin')` | Alternativa a vista statica per SuperAdmin: senza stato/click non sostituisce un componente. |
| `$panel->userMenuItems([...])` con `MenuItem::make()->url('#')` | `userMenuItems` è per **navigazione**, non per toggle/switch con stato: scartato (vedi brainstorming). |

## Perché hook + `@livewire(FQCN)` e non le alternative

| Alternativa | Perché scartata |
|-------------|-----------------|
| `->widgets([...])` nel provider | Registra in dashboard (KPI). Chrome (user menu, login-after) non è KPI: si usa `$isDiscovered = false` + hook esplicito (ADR-C003). |
| `->userMenuItems()` | Solo voci di navigazione: niente stato, niente azione Livewire. |
| Pagina Filament / Folio | I tre componenti sono **frammenti di chrome**, non pagine (Cluster A, non C). |
| Alias stringa `@livewire('team.change')` | Invisibile a PHPStan, dipende dalla cache `_components.json`: un alias morto = 500 su tutto `/admin`. Il FQCN fallisce a boot, non a runtime. |

## Regole di piattaforma applicate qui

1. Widget **sempre** `extends XotBaseWidget` / `XotBaseSchemaWidget` (`Modules/Xot/app/Filament/Widgets/`),
   mai `Filament\Widgets\Widget` diretto.
2. I widget vivono in `Modules/User/app/Filament/Widgets/` e sarebbero auto-scoperti da
   `XotBasePanelProvider::discoverWidgets` (`XotBasePanelProvider.php:134`); i tre chrome usano
   `protected static bool $isDiscovered = false` per restare **fuori** dalla dashboard.
3. Nessun `->label()`: traduzioni via `LangServiceProvider` (chiavi `user::*`).
4. Nessun override di costruttore nei widget: stato in `mount()` / `getData()`.
5. Un hook per story sul provider (ADR-C004): 9.2 → 10.1 → 10.2 in sequenza.

## Verifica rapida

```bash
grep -n "registerRenderHook\|@livewire" Modules/User/app/Providers/Filament/AdminPanelProvider.php
# atteso: 3 hook, solo FQCN ::class: zero alias stringa
grep -rn "socialite.buttons\|team.change\|profile.super-admin" Modules/User/app Modules/User/resources
# atteso: solo app/Http/Livewire/_components.json (cache stale, da eliminare con la cartella)
```

## Successo

- [x] Tre hook FQCN, zero alias nel provider (2026-09-21)
- [x] Classi HTTP chrome eliminate dal disco
- [ ] Cache `_components.json` rigenerata/eliminata (residuo, non blocca il runtime: gli hook non la leggono)
