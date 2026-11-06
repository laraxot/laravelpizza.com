---
title: "LoginWidget: statePath data e XotBaseSchemaWidget"
type: concept
tags: [user, login, livewire, filament, xotbaseschemawidget]
created: 2026-07-13
updated: 2026-07-13
qmd: "login widget empty fields statePath data XotBaseSchemaWidget wire model auth login"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/362"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/363"
related:
  - login-page-design-comuni.md
  - ../../../../../Themes/Sixteen/docs/wiki/concepts/folio-volt-app-pages.md
  - ../../../../../Themes/Sixteen/docs/wiki/concepts/folio-volt-app-pages.md
status: draft
---

# LoginWidget: campi vuoti al submit

## Sintomo

`/it/auth/login`: l’utente compila email/password ma al submit Filament/Livewire segnala campi obbligatori vuoti o `auth.failed` senza tentativo reale.

## Causa

`XotBaseWidget::form()` imposta `statePath('data')` → input con `wire:model="data.email"`.

`LoginWidget` deve estendere `XotBaseSchemaWidget` (schema da `UserForm`, `mount()` con `form->fill`). Lo stato Livewire è `XotBaseWidget::$data` (`array`, `wire:model="data.*"`).

## Fix (religione)

```php
class LoginWidget extends XotBaseSchemaWidget
{
    protected static function formClass(): string { return UserForm::class; }
    protected static function schemaMethod(): string { return 'getLoginFormSchema'; }

    public function save(): void { /* Auth::attempt + $this->redirect */ }
}
```

Schema SSoT: `Filament/Resources/UserResource/Schemas/UserForm::getLoginFormSchema()`.

Submit: `$this->form->getState()`: mai `validateForm()`.

## Verifica

```bash
curl -s http://127.0.0.1:8000/it/auth/login | rg 'wire:model="data\.'
cd laravel && vendor/bin/pest Modules/User/tests/Feature/Filament/Widgets/Auth/LoginWidgetStateTest.php
```
