---
title: "Tech spec: SuperAdmin widget"
type: tech-spec
module: User
status: approved
track: quick-flow
version: "1.0"
related:
  - ./prd.md
  - ./architecture.md
  - ./ux-design.md
  - ./epics.md
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "technical specification: superadmin widget user"
---

# Technical specification: SuperAdmin widget

**Track:** Quick Flow (4 story)  
Questo file è il *come* operativo. **Non implementare da questo documento in questa sessione:** è il contratto per lo sviluppatore successivo.

## Problem & solution

Oggi `SuperAdmin` è `Livewire\Component` in `Http/Livewire/Profile`. Il panel lo monta con un alias stringa. Si converte in `XotBaseWidget` nello stesso hook.

## Scope

**In:** classe widget, vista Filament, lang, `AdminPanelProvider`, rimozione Livewire, test.  
**Out:** altri hook del provider; trait `toggleSuperAdmin`; FilamentJet.

## Stack

| Layer | Tecnologia | Note |
|-------|------------|------|
| Panel | Filament 5 / `XotBasePanelProvider` | `discoverWidgets` su `Filament/Widgets` |
| Widget | `XotBaseWidget` | no form |
| Profilo | `XotData::getProfileModel()` | invariato |
| Ruoli | Spatie `super-admin` / `negate-super-admin` | invariato |
| Vista | `user::filament.widgets.profile.super-admin` | GetViewByClassAction |

## Componenti

### SuperAdminWidget

**Path previsto:** `laravel/Modules/User/app/Filament/Widgets/Profile/SuperAdminWidget.php`

**Responsabilità:**
- `mount()`: profilo corrente + URL corrente (stesso del Livewire).
- `toggleSuperAdmin()`: `$this->profile->toggleSuperAdmin()` + `redirect($this->url, 303)`.
- `getViewData()`: `profile`.
- `protected static bool $isDiscovered = false`: **obbligatorio** perché `XotBasePanelProvider` fa `discoverWidgets` su tutta `Filament/Widgets`.
- Non dichiarare `$view` se la vista esiste al path convenzionale; altrimenti `user::filament.widgets.profile.super-admin`.

**Non fare:** `XotBaseSchemaWidget`, form schema, registrazione in `->widgets([...])`.

### Vista Blade

**Path previsto:** `laravel/Modules/User/resources/views/filament/widgets/profile/super-admin-hero.blade.php`

Due bottoni distinti (`user-super-admin` / `user-negate-super-admin`), `wire:click="toggleSuperAdmin"`, tooltip e label da lang:

- `user::super_admin_widget.tooltip.active`
- `user::super_admin_widget.tooltip.negated`

(file lang da creare, struttura espansa).

### AdminPanelProvider: modifiche (cuore della 9.2)

File: `laravel/Modules/User/app/Providers/Filament/AdminPanelProvider.php`

Oggi (righe 50–54 circa):

```php
FilamentView::registerRenderHook(
    'panels::user-menu.before',
    static fn (): string => Blade::render("@livewire('profile.super-admin')"),
);
```

**Target (specifica, non codice da committare ora):**

1. `use Filament\View\PanelsRenderHook;`
2. `use Modules\User\Filament\Widgets\Profile\SuperAdminWidget;`
3. Sostituire **solo** quel `registerRenderHook` del SuperAdmin con:

```php
FilamentView::registerRenderHook(
    PanelsRenderHook::USER_MENU_BEFORE,
    static fn (): string => Blade::render(
        '@livewire(\'' . SuperAdminWidget::class . '\')',
    ),
);
```

4. **Non** convertire in questa story l’hook di `team.change` (riga ~45–48): resta `Blade::render("@livewire('team.change')")`.
5. **Non** decommentare `View::make('user::badges.super-admin')`: è un badge statico senza toggle, viola FR-002.
6. **Non** aggiungere `SuperAdminWidget` a `$panel->pages()` / `userMenuItems()` / `widgets()`.
7. Opzionale SHOULD: usare `PanelsRenderHook::USER_MENU_BEFORE` anche per `team.change` è **fuori epic** (altro lock, altro comportamento).
8. I commenti “moved into Gdpr/Notify” restano: memoria storica, non si cancellano in 9.2 se non toccano il blocco SuperAdmin.

`parent::panel($panel)` resta la prima riga utile: discovery risorse/widget invariata.

### Livewire da ritirare (9.3)

- Eliminare `app/Http/Livewire/Profile/SuperAdmin.php`
- Eliminare `resources/views/livewire/profile/super-admin.blade.php` dopo che la vista Filament è la SSoT
- Grep modulo: zero `profile.super-admin` e zero `Http\Livewire\Profile\SuperAdmin`

### Data / API

Nessuna migrazione, nessuna route nuova.

### Errori

`toggleSuperAdmin()` già notifica/lancia se manca user. Il widget non ingoia l’eccezione.

## Story list

| # | Epic | Titolo | Note |
|---|------|--------|------|
| 1 | 9 | Widget + vista + lang | nessuna modifica al provider |
| 2 | 9 | Hook in AdminPanelProvider | solo quel file |
| 3 | 9 | Rimuovere Livewire SuperAdmin | dopo 9.2 |
| 4 | 9 | Test Pest | dopo 9.2 |

**Totale:** 4 (sotto il tetto Quick Flow 15)

## Testing (strategia)

- Unit/widget: `canView`/discovery false; `getViewData` con profilo mock.
- Feature: utente con ruolo vede HTML icon-button; utente senza ruoli no.
- Feature toggle: click (o chiamata metodo) inverte `hasRole`.
- Regression: `/admin` 200 autenticato (non 500).
- Non obbligare coverage % in questa spec.

## Dipendenze

| Dipendenza | Vincolo | Rischio |
|------------|---------|---------|
| filament/filament | v5 già in root | basso |
| livewire/livewire | il widget è comunque Livewire | basso |
| spatie/laravel-permission | ruoli esistenti | basso se i ruoli non sono seedati in test |

Interne: `XotBaseWidget`, `XotData`, `ProfileContract`, `XotBasePanelProvider::discoverWidgets`.

## Rischi

| Rischio | Impatto | Mitigazione |
|---------|---------|-------------|
| Widget scoperto in dashboard | UI spuria | `$isDiscovered = false` |
| Alias `profile.super-admin` rimosso prima dello switch | 500 `/admin` | ordine 9.1 → 9.2 → 9.3 |
| `canView(): false` globale spegne anche l’hook | icona sparisce | non usare canView per nascondere il hook; usare `$isDiscovered` |
| Tooltip hardcoded restano | i18n | FR-005 in 9.1 |

## Success

- [ ] Hook provider sul FQCN widget
- [ ] Livewire HTTP SuperAdmin assente
- [ ] Dashboard senza card SuperAdmin
- [ ] Toggle ruoli invariato
