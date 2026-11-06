---
title: "Tech spec: campagna Livewire → widget"
type: tech-spec
module: User
status: approved
track: campaign
version: "1.0"
related:
  - ./livewire-widget-prd.md
  - ./livewire-widget-architecture.md
  - ./tech-spec.md
  - ./livewire-inventory.md
  - ./epics.md
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "technical specification: campagna widget-only user"
---

# Technical specification: campagna widget-only

**Non implementare da questo documento in questa sessione.**

Lo slice SuperAdmin (classe, vista, lang, hook, ritiro, test) resta in [tech-spec.md](./tech-spec.md). Qui: gli altri 13 e le regole comuni.

## Problem & solution

`AdminPanelProvider` monta tre alias HTTP. Auth HTTP duplica widget già in `Filament/Widgets`. Privacy/Terms e `dddx` non appartengono a User. Si chiude l’albero `Http/Livewire`.

## Scope

**In:** TeamChangeWidget, switch SocialLoginWidget, ritiro Cluster B/C, grep zero alias.  
**Out:** codice SuperAdmin (Epic 9); Notify; Volt.

## Stack

Come SuperAdmin: Filament 5, Livewire 4, `XotBaseWidget` / `XotBaseSchemaWidget`, lang `user::`.

## Componenti

### TeamChangeWidget (10.1)

**Path previsto:** `app/Filament/Widgets/Team/TeamChangeWidget.php`  
Estende `XotBaseWidget`. `$isDiscovered = false`.  
Portare `mount` / `switchTeam` / empty `ui::livewire.empty` dal Livewire attuale.  
Lang: `__('Team switched')` → chiave `user::team_change_widget.*`.  
Vista: `user::filament.widgets.team.change`.  
Hook **solo** il blocco `team.change` nel provider → FQCN. SuperAdmin e social **intatti** in 10.1.

### Social login (10.2)

Nessuna classe nuova. Hook `panels::auth.login.form.after`:

```php
FilamentView::registerRenderHook(
    PanelsRenderHook::AUTH_LOGIN_FORM_AFTER,
    static fn (): string => Blade::render(
        '@livewire(\'' . SocialLoginWidget::class . '\')',
    ),
);
```

Poi eliminare `Http/Livewire/Socialite/Buttons.php` e vista `user::livewire.socialite.buttons`.

**Gap obbligatorio (inventario):** Buttons usa `filament-socialite.providers` + `route('socialite.oauth.redirect')`. `SocialLoginWidget` usa `services.*.client_id` + `route('socialite.oauth.fo.redirect')`. Prima dello switch: una config; proprietà/parametro route sul widget esistente. Montare il widget com’è oggi sul login admin **sbaglia il redirect OAuth**.

### Cluster B ritiro (10.3)

Eliminare le 8 classi auth HTTP e viste `livewire/auth/**` dopo grep:

- zero `Http\Livewire\Auth`
- zero `ViewCopyAction` in User `app/`
- test `LoginComponentTest` → puntare a `LoginWidget` o cancellare se duplica `RegisterWidgetTest`

Scegliere SSoT logout: un file tra `Filament/Widgets/LogoutWidget.php` e `Filament/Widgets/Auth/LogoutWidget.php` (due classi oggi). La story **sceglie e documenta**, non ne crea una terza. Idem reset (`PasswordResetWidget` vs `ResetPasswordWidget`).

Verify HTTP: cancellare. Se FO serve verify, è pagina tema/Volt: fuori da questa story oltre il ritiro.

### Cluster C (10.4)

- `DeleteAccount` → widget/schema su profilo; `DeleteUserAction` locked.
- `PrivacyPolicy` / `TermsOfService` → delete da User; non decommentare hook terms.
- Rimuovere `dddx('wip')` con la classe, non “fixare” il WIP in User.

## Errori noti da non ripetere

- Namespace `filament-jet::`: [filament_errors.md](../filament_errors.md).
- `canView(): false` globale che spegne anche l’hook: usare `$isDiscovered`.
- Registrare chrome widget in `->widgets()`.

## Testing strategia

- 9.4 copre SuperAdmin.
- 10.1: switch team 403 se non member; redirect path Filament.
- 10.2: login page panel contiene bottoni provider configurati; grep zero `socialite.buttons`.
- 10.3: `class_exists` HTTP auth false; widget auth `Livewire::test` verdi.
- 10.4: delete account via action; grep zero PrivacyPolicy User HTTP.

## Rischi

| Rischio | Mitigazione |
|---------|-------------|
| Provider toccato in parallelo | lock + sequenza 9.2 → 10.1 → 10.2 |
| SocialLoginWidget route FO sul login admin | parametro route + tabella in [livewire-inventory.md](./livewire-inventory.md) |
| Ritiro Login mentre un Blade orfano lo chiama | grep modulo + temi prima di delete |
| Due LogoutWidget | decisione esplicita in 10.3 |
| `canView(): false` spegne l’hook | solo `$isDiscovered = false` |

## Success

- [ ] Tre hook FQCN
- [ ] `app/Http/Livewire` vuoto
- [ ] Zero `ViewCopyAction` / `dddx` UI User
