---
title: "Project context: SuperAdmin nel user menu"
type: note
status: draft
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "project context   superadmin nel user menu user"
---
# Project context: SuperAdmin nel user menu

Costituzione di **questo slice**, non del modulo User intero. Non contraddice la religione User (Actions, PHPStan max, Spatie ruoli, XotBase*).

## Perché esiste

Nel pannello Filament (`GET /admin`) un utente con ruolo `super-admin` o `negate-super-admin` deve **vedere e invertire** quel ruolo dal menu utente (icona corona), senza aprire una Resource. La logica di business vive sul profilo (`ProfileContract::toggleSuperAdmin()`). L’UI oggi è un Livewire in `Http/Livewire`, montato con un render hook: è chrome Filament, non un form pubblico.

## Utenti

- Operatore autenticato nel panel `admin`.
- Solo chi ha già `super-admin` o `negate-super-admin` vede il controllo. Chi non ha nessuno dei due vede vuoto.

## Vincoli non negoziabili

1. Estendere `XotBaseWidget`, mai `Filament\Widgets\Widget` diretto.
2. Nessuna nuova dipendenza (`filament-jet` resta fuori).
3. Namespace viste `user::filament.widgets…` (chrome admin). `pub_theme::` è per i widget auth del tema, non per questo hook.
4. Non mettere il widget nella griglia dashboard (`discoverWidgets` lo scansiona: va escluso).
5. Non cambiare `toggleSuperAdmin()` sul modello/trait: solo il contenitore UI.
6. `laravel/phpstan.neon` immutabile. Errori si risolvono nel codice, non con ignore.
7. Nessun `->label()` hardcoded: tooltip e testi da `user::` lang.
8. Documentazione e codice restano nel modulo User (repo `laraxot/module_user_fila5`).

## Fuori costituzione

Team switcher (`team.change`), Socialite, Gdpr terms, Notify: altri hook, altro epic.

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

## Icone (set Blade Icons del modulo)

Solo `Modules/User/resources/svg/`. Prefisso auto-registrato: `user`. Non `public/icons/`.

| Stato | File | Nome Filament (`icon=`) | Colore |
|-------|------|-------------------------|--------|
| attivo | `resources/svg/superman.svg` | `user-superman` | `warning` |
| negato | `resources/svg/clark-kent.svg` | `user-clark-kent` | `danger` |

Archivio (non cancellare, non usare nel bottone): `superadmin.svg`, `negate-superadmin.svg`, `user-super-admin.svg`, `user-negate-super-admin.svg`. Un file `user-superman.svg` si registra come `user-user-superman`.

Markup: `x-filament::icon-button`. Stroke `currentColor` sul root. Outline originale (cappa/ciuffo vs occhiali/cravatta), non emblemi registrati.

## Componenti

### SuperAdminWidget

**Path previsto:** `laravel/Modules/User/app/Filament/Widgets/Profile/SuperAdminWidget.php`

**Responsabilità:**
- `mount()`: profilo corrente + URL corrente (stesso del Livewire).
- `toggleSuperAdmin()`: `$this->profile->toggleSuperAdmin()` + `redirect($this->url, 303)`.
- `getViewData()`: `profile`.
- `protected static bool $isDiscovered = false`: **obbligatorio** perché `discoverWidgets` scansiona `Filament/Widgets`.
- Non dichiarare `$view` se la vista esiste al path convenzionale; altrimenti `user::filament.widgets.profile.super-admin`.

**Non fare:** `XotBaseSchemaWidget`, form schema, registrazione in `->widgets([...])`.

### Vista Blade

**Path previsto:** `laravel/Modules/User/resources/views/filament/widgets/profile/super-admin.blade.php`

Copiare il markup attuale di `livewire/profile/super-admin.blade.php` (due `x-filament::icon-button`, `wire:click="toggleSuperAdmin"`), tooltip da `user::` lang:

- `user::super_admin_widget.tooltip.active`
- `user::super_admin_widget.tooltip.negated`

(file lang da creare, struttura espansa).

### AdminPanelProvider: modifiche (9.2)

File: `laravel/Modules/User/app/Providers/Filament/AdminPanelProvider.php`

Oggi (righe 45-53 circa):

```php
FilamentView::registerRenderHook(
    'panels::user-menu.before',
    static fn (): string => Blade::render("@livewire('profile.super-admin')"),
);
```

**Target (solo questa modifica):**

```php
FilamentView::registerRenderHook(
    PanelsRenderHook::USER_MENU_BEFORE,
    static fn (): string => Blade::render("@livewire('" . SuperAdminWidget::class . "')"),
);
```

- Non toccare `team.change`, `socialite.buttons`, `terms-of-service`, `database-notifications`.
- Non modificare `XotBasePanelProvider`: solo il file `AdminPanelProvider.php`.
- Non aggiungere widget alla griglia dashboard (`discoverWidgets`).
- Non cambiare `$panel->default()` o `pages()`.

### Livewire da ritirare (9.3)

- Eliminare `Modules/User/app/Http/Livewire/Profile/SuperAdmin.php`
- Eliminare `Modules/User/resources/views/livewire/profile/super-admin.blade.php` dopo la conversione
- `grep -rn "profile.super-admin"` in tutto il modulo → 0 occorrenze

### Data / API

Nessuna modifica API, rotte o migrazioni.

### Errori

`toggleSuperAdmin()` già gestisce l'eccezione. Il widget non ingoia l'eccezione.

## Story list

| # | Epic | Titolo | Note |
|---|------|--------|------|
| 9.1 | super-admin-widget | Classe widget, vista, lang | ready-for-dev |
| 9.2 | admin-panel-provider-hook | Switch hook SuperAdmin al FQCN widget | ready-for-dev |
| 9.3 | remove-livewire-superadmin | Eliminare Livewire HTTP e vista vecchia | ready-for-dev |
| 9.4 | super-admin-widget-tests | Pest verifica visibilità, toggle, assenza da dashboard | ready-for-dev |

## Note

Implementazione **non** in questa sessione. Handoff: story `ready-for-dev`.  
Correzione del 2026-09-02: `qmd` **2.8.3** e `graphify` **0.9.32** ora in PATH, `qmd` installato correttamente (non placeholder). Indice qmd aggiornato, grafo ricostruito con `graphify update . --force`. `qmd` ora funziona: `qmd search "super-admin"` → trova il file.