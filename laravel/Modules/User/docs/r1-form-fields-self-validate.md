---
title: "R1 religion — form fields self-validate, widget thin conductor (User module)"
type: religion
tags: [user, filament, widget, religion-r1, code, auth, register, opencode-minimax-m3]
created: 2026-06-05
updated: 2026-06-05
qmd: "r1 religion form fields self validate widget thin conductor user module register login auth opencode minimax"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/264"
  - "https://github.com/laraxot/module_user_fila5/issues/25"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/265"
  - "https://github.com/laraxot/module_user_fila5/discussions/26"
related:
  - ../../Xot/docs/xotbase-schemawidget-pattern.md
  - ../../Themes/Sixteen/docs/r2-ux-register-form-stacked-password.md
  - ../../../docs/chat/register-flow-religions-r1-r6.md
  - ../../../docs/wiki/memories/form-fields-self-validate-religion.md
  - WIDGET-RENDERING-ANALYSIS.md
---

# R1 religion — form fields self-validate, widget thin conductor (User module)

> Modulo: `User` · Autore code: opencode (MiniMax-M3) · Issue tracking: base #264

## La regola

**I campi del form si auto-validano e si auto-deidratano. Il widget è un conduttore sottile (5-10 LOC).**

❌ Vietato nel widget:
- `validateForm()` method
- `Hash::make` / `SafeStringCastAction` / `cast` in `submit()`
- wrapper Action per `Model::create()`
- `'type' => 'standard'` o altri magic values che parental/HasChildren cerca di istanziare

✅ Obbligatorio nella Form class:
- `->dehydrateStateUsing(static fn($s) => Hash::make($s))` sul campo `password`
- `->dehydrated(false)` su `password_confirmation`
- `->rules(['required', 'email', 'confirmed'])` oppure conferma via `password_confirmation` field

✅ Obbligatorio nel widget:
- `formClass() + schemaMethod()` pattern
- `submit()` thin: `$data = $this->form->getState(); $user = $userClass::create($data + defaults); Auth::login($user);`

## Implementazione

### Widget-level `UserForm` (NUOVO)

`laravel/Modules/User/app/Filament/Widgets/Auth/Schemas/UserForm.php`

6 metodi statici, uno per widget auth:

```php
public static function getRegisterFormSchema(Schema $schema, ?Model $record = null): Schema
{
    return $schema->components([
        TextInput::make('first_name')
            ->required()
            ->maxLength(50)
            ->autofocus()
            ->autocomplete('given-name')
            ->extraInputAttributes(['class' => 'fo-auth-input']),
        TextInput::make('last_name')
            ->required()
            ->maxLength(50)
            ->autocomplete('family-name')
            ->extraInputAttributes(['class' => 'fo-auth-input']),
        TextInput::make('email')
            ->required()
            ->email()
            ->unique(\Modules\User\Models\User::class, 'email')
            ->autocomplete('email')
            ->extraInputAttributes(['class' => 'fo-auth-input']),
        TextInput::make('password')
            ->required()
            ->password()
            ->revealable()
            ->dehydrateStateUsing(static fn(string $state): string => Hash::make($state))
            ->dehydrated(true) // mantiene il valore hashed nel payload
            ->autocomplete('new-password')
            ->extraInputAttributes(['class' => 'fo-auth-input fo-auth-input--password']),
        TextInput::make('password_confirmation')
            ->required()
            ->password()
            ->revealable()
            ->dehydrated(false) // NON inviato al server, solo client-side confirmation
            ->dehydrateStateUsing(static fn(string $state): string => $state) // identity
            ->autocomplete('new-password')
            ->extraInputAttributes(['class' => 'fo-auth-input fo-auth-input--password']),
    ])->statePath('data');
}
```

**Punti chiave R1:**
- `password` → `dehydrateStateUsing(Hash::make(...))` + `dehydrated(true)` → arriva hashed al widget
- `password_confirmation` → `dehydrated(false)` → non arriva, server non lo vede
- NO `Grid(2)` → campi stacked verticali (R2 UX)

### Widget migrati (6)

| Widget | schemaMethod | Path |
|--------|--------------|------|
| `LoginWidget` | `getLoginFormSchema` | `laravel/Modules/User/app/Filament/Widgets/Auth/LoginWidget.php` |
| `RegisterWidget` | `getRegisterFormSchema` | `laravel/Modules/User/app/Filament/Widgets/Auth/RegisterWidget.php` |
| `ForgotPasswordWidget` | `getForgotPasswordFormSchema` | `laravel/Modules/User/app/Filament/Widgets/Auth/ForgotPasswordWidget.php` |
| `PasswordResetWidget` | `getPasswordResetFormSchema` | `laravel/Modules/User/app/Filament/Widgets/Auth/PasswordResetWidget.php` |
| `ResetPasswordWidget` | `getResetPasswordFormSchema` | `laravel/Modules/User/app/Filament/Widgets/Auth/ResetPasswordWidget.php` |
| `PasswordResetConfirmWidget` | `getPasswordResetConfirmFormSchema` | `laravel/Modules/User/app/Filament/Widgets/Auth/PasswordResetConfirmWidget.php` |

Tutti importano `Schemas\UserForm` (widget-level) MAI backoffice.

### `RegisterWidget::submit()` thin conductor

```php
public function submit(): void
{
    $data = $this->form->getState(); // GIÀ validato + deidratato (password hashed)
    $userClass = config('filament-companies.user_model', \Modules\User\Models\User::class);
    $user = $userClass::create($data + [
        'name' => trim($data['first_name'].' '.($data['last_name'] ?? '')),
        'email_verified_at' => null,
    ]);
    if (\Schema::hasTable('activity_log')) {
        activity()->causedBy($user)->log('register');
    }
    \Auth::login($user, true);
    session()->regenerate();
    redirect()->intended($this->getRedirectUrl());
}
```

**12 LOC totali** (era 35+ con validateForm + cast + hash + remap).

## Differenza da Backoffice `UserForm`

Esistono DUE `UserForm` con namespace diverso:

| Path | Scope | Metodi |
|------|-------|--------|
| `Modules/User/Filament/Widgets/Auth/Schemas/UserForm.php` | Widget-level (FO auth) | 6 metodi: `getLoginFormSchema`, `getRegisterFormSchema`, ... |
| `Modules/User/Filament/Resources/UserResource/Schemas/UserForm.php` | Backoffice (admin) | Solo `getFormSchema()` con tutti i campi editabili |

**Regola**: MAI importare uno nell'altro.

## Dead code rimosso

- `laravel/Modules/User/app/Filament/Widgets/Auth/BaseAuthWidget.php` (mai esteso)
- `laravel/Modules/User/app/Filament/Widgets/Auth/UserForm.php` (vecchio layout)
- `laravel/Modules/User/app/Filament/Widgets/Auth/Schemas/RegisterUserForm.php` (duplicato)

## Verifica empirica

```bash
$ php -l laravel/Modules/User/app/Filament/Widgets/Auth/Schemas/UserForm.php
No syntax errors detected
$ php -l laravel/Modules/User/app/Filament/Widgets/Auth/RegisterWidget.php
No syntax errors detected
$ cd laravel && composer dump-autoload
Generated optimized autoload files containing 23276 classes
```

## Anti-pattern vietati (R1 religion)

❌ `validateForm()` method nel widget
❌ `$this->form->getState()` → poi `Hash::make` in widget
❌ Wrapper Action su `Model::create()` (es. `app(RegisterUserAction::class)->execute($data)`)
❌ `'type' => 'standard'` o magic values per `parental/HasChildren` (causa `Class "standard" not found`)
❌ Cast manuali in `submit()` (es. `(int) $data['age']`)
❌ Trasformazioni business in widget (es. calcolo `name` da `first_name + last_name`)

## Riferimenti

- Issue base: #264 (`STORY-144: R1 religion code work — XotBaseSchemaWidget base class + 6 auth widgets migrated`)
- Discussion base: #265 (`Filament R1 religion code: XotBaseSchemaWidget + 6 auth widgets — coordinate Codex/STORY-140 docs`)
- Story complementare: STORY-140 (Codex - GPT-5) — https://github.com/laraxot/base_fixcity_fila5/issues/248
- Cross-repo issue modulo: da aprire su `laraxot/module_user_fila5`
- WIDGET-RENDERING-ANALYSIS.md (questo modulo, da aggiornare con nuovo pattern)

---
*opencode (MiniMax-M3) · 2026-06-05*
