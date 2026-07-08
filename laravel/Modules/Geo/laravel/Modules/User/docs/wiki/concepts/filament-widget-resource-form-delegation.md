---
title: "Filament widget — delega schema a *ResourceForm"
type: concept
confidence: high
created: 2026-06-04
updated: 2026-06-04
tags: [user, filament, dry, register, widget, auth-forms]
related:
  - filament-widget-no-validate-form.md
  - ../../../../Fixcity/docs/wiki/concepts/ticketform-pattern-reference.md
  - ../../../../../Modules/Xot/docs/wiki/concepts/xotbase-resourceform-zen-pattern.md
  - register-widget.md
  - ../rules/filament-widget-resource-form.mdc
---

# Widget Filament → schema in `*Form` (SSoT)

## Regola

I widget FO (auth, wizard, registrazione) **non** definiscono campi `TextInput` inline. Delegano a `Modules\{Modulo}\Filament\Resources\{Resource}\Schemas\{Entity}Form`.

### Tutti gli schemi auth (SSoT in UserForm)

| Pezzo | Responsabilità |
|-------|----------------|
| `UserForm::getRegisterFormSchema()` | Campi registrazione FO |
| `UserForm::getLoginFormSchema()` | Campi login FO |
| `UserForm::getForgotPasswordFormSchema()` | Campi forgot-password FO |
| `UserForm::getResetPasswordFormSchema()` | Campi reset-password (token) FO |
| `UserForm::getPasswordResetFormSchema()` | Campi password-reset (send link) FO |
| `UserForm::getPasswordResetConfirmFormSchema()` | Campi password-reset-confirm FO |
| `UserForm::getFormSchema()` | Form pannello admin |
| `RegisterWidget` | `getState()` → `getUserClass()::create()`, transaction, redirect |
| `LoginWidget` | Auth attempt, session, redirect |
| `ForgotPasswordWidget` | Send reset link |
| `ResetPasswordWidget` | Reset password with token |
| `PasswordResetWidget` | Send reset link (UX variant) |
| `PasswordResetConfirmWidget` | Confirm reset + auto-login |

## Esempi (User)

```php
// RegisterWidget — delega via formClass (canonico)
class RegisterWidget extends XotBaseSchemaWidget
{
    protected static function formClass(): string
    {
        return UserForm::class; // Resources/UserResource/Schemas/UserForm.php
    }

    protected static function schemaMethod(): string
    {
        return 'getRegisterFormSchema';
    }
}

// Alternativa equivalente: resourceFormSchema(UserForm::class, 'getLoginFormSchema')
```

## Perché

1. **DRY** — Un solo posto per regole password, unique email, autocomplete, validazione
2. **KISS** — Il widget resta orchestrazione Livewire (submit, redirect, log)
3. **Allineamento Filament v5** — `XotBaseResourceForm` + pattern Fixcity `TicketForm`
4. **Scalabilità** — Quando una regola di validazione cambia, si aggiorna IN UN SOLO POSTO

## Vietato

```php
// ❌ campi duplicati nel widget
public function getFormSchema(): array
{
    return [
        'email' => TextInput::make('email')->...
    ];
}
```

## Non creare per-widget Form classes

```php
// ❌ NO: Widgets/Auth/Schemas/RegisterUserForm.php
// Gli schemi auth vivono in Resources/UserResource/Schemas/UserForm
```

## Base class corretta: XotBaseSchemaWidget

```php
// ✅ SI — formClass + schemaMethod (preferito)
class RegisterWidget extends XotBaseSchemaWidget
{
    protected static function formClass(): string { return UserForm::class; }
    protected static function schemaMethod(): string { return 'getRegisterFormSchema'; }
}

// ❌ NO — Widgets/Auth/Schemas/UserForm.php (duplicato; SSoT solo in Resource)
// ❌ NO — XotBaseWidget senza schema
// ❌ NO — TextInput inline in getFormSchema()
```

## Gerarchia

```text
XotBaseWidget              (azioni, viste, traduzioni — SENZA schema)
  └── XotBaseSchemaWidget  (InteractsWithSchemas, form, save)
        └── auth widgets   (RegisterWidget, LoginWidget, …)
        └── XotBaseWizardWidget  (Wizard + Step)
```

## Collegamenti

- [UserForm.php](../../../app/Filament/Resources/UserResource/Schemas/UserForm.php)
- [RegisterWidget.php](../../../app/Filament/Widgets/Auth/RegisterWidget.php)
- ADR root: [filament-widget-resource-form-delegation.md](../../../../../docs/wiki/decisions/filament-widget-resource-form-delegation.md)
- Rule: `.cursor/rules/filament-widget-resource-form.mdc`
- Rule: `.cursor/rules/xotbase-schemawidget.mdc`
