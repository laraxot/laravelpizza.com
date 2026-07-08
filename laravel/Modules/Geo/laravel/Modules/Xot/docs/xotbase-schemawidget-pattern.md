---
title: "XotBaseSchemaWidget — pattern dichiarativo Filament 4"
type: concept
tags: [xot, filament, widget, religion-r1, code, architecture, opencode-minimax-m3]
created: 2026-06-05
updated: 2026-06-05
qmd: "xotbase schemawidget filament widget religion r1 form fields self validate opencode minimax"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/264"
  - "https://github.com/laraxot/module_xot_fila5/issues/27"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/265"
related:
  - base-classes-additional-fix.md
  - ../../User/docs/r1-form-fields-self-validate.md
  - ../../Themes/Sixteen/docs/r2-ux-register-form-stacked-password.md
  - ../../../docs/chat/register-flow-religions-r1-r6.md
  - ../../../docs/wiki/memories/form-fields-self-validate-religion.md
---

# XotBaseSchemaWidget — pattern dichiarativo Filament 4

> Modulo: `Xot` · Autore code: opencode (MiniMax-M3) · Issue tracking: base #264

## Problema

Prima di questa implementazione (2026-06-05), `Modules\Xot\Filament\Widgets\XotBaseSchemaWidget` era **referenziata da 20+ widget** ma **NON esisteva come file**. Risultato: 500 error `Class "XotBaseSchemaWidget" not found` su tutte le pagine che li usavano.

## Soluzione

`laravel/Modules/Xot/app/Filament/Widgets/XotBaseSchemaWidget.php`:

```php
namespace Modules\Xot\Filament\Widgets;

use Filament\Schemas\Schema;
use Filament\Widgets\Widget;
use Modules\Xot\Filament\Traits\InteractsWithSchemas;
use Modules\Xot\Actions\Filament\GetViewByClassAction;

abstract class XotBaseSchemaWidget extends Widget implements HasSchemas
{
    use InteractsWithSchemas;

    protected static string $baseSchemaClass = '';

    protected string $view = '';

    /** 1) Hook: quale Form class usare (override nei child per specializzare) */
    protected static function formClass(): string
    {
        return static::$baseSchemaClass;
    }

    /** 2) Hook: quale metodo della Form class invocare (default getFormSchema) */
    protected static function schemaMethod(): string
    {
        return 'getFormSchema';
    }

    /** 3) Hook: stato Livewire (override se serve path custom) */
    protected function statePath(): ?string
    {
        return 'data';
    }

    /** 4) Implementazione concreta: delega al formClass + schemaMethod */
    public function form(Schema $schema): Schema
    {
        $formClass = static::formClass();
        $method = static::schemaMethod();

        if ($formClass !== '' && method_exists($formClass, $method)) {
            return $formClass::$method($schema, $this->getRecord());
        }

        return $this->getFormSchema($schema);
    }

    /** 5) Hook: schema locale (fallback) */
    public function getFormSchema(Schema $schema): Schema
    {
        return $schema;
    }

    /** 6) Hook: vista (Filament 4 NON auto-fall-through su temi) */
    public function getView(): string
    {
        if ($this->view !== '') {
            return $this->view;
        }
        return app(GetViewByClassAction::class)->execute(static::class);
    }
}
```

## Simmetria con `XotBaseInfolistWidget`

`XotBaseSchemaWidget` (write) ↔ `XotBaseInfolistWidget` (read) condividono il pattern:
- `infolist(Schema)` ↔ `form(Schema)`
- `getInfolistSchema()` ↔ `getFormSchema(Schema)`
- `getInfolistRecord()` ↔ `getRecord()`

## Pattern d'uso nei widget

```php
namespace Modules\User\Filament\Widgets\Auth;

use Modules\User\Filament\Widgets\Auth\Schemas\UserForm;
use Modules\Xot\Filament\Widgets\XotBaseSchemaWidget;

class LoginWidget extends XotBaseSchemaWidget
{
    protected static string $baseSchemaClass = UserForm::class;

    public function login(): void
    {
        $data = $this->form->getState(); // GIÀ validato + deidratato
        if (Auth::attempt($data)) {
            session()->regenerate();
            redirect()->intended($this->getRedirectUrl());
        }
    }
}
```

E `Modules/User/Filament/Widgets/Auth/Schemas/UserForm.php`:

```php
public static function getLoginFormSchema(Schema $schema, ?Model $record = null): Schema
{
    return $schema->components([
        TextInput::make('email')
            ->required()
            ->email()
            ->autofocus()
            ->autocomplete('email')
            ->extraInputAttributes(['class' => 'fo-auth-input']),
        TextInput::make('password')
            ->required()
            ->password()
            ->autocomplete('current-password')
            ->extraInputAttributes(['class' => 'fo-auth-input fo-auth-input--password']),
        Checkbox::make('remember')->label('Ricordami'),
    ])->statePath('data');
}
```

## Decisioni aperte

Vedi discussion #265 per dibattito su:
1. **Pattern dichiarativo vs imperativo** — reflection vs interface marker.
2. **Widget-level Form class vs backoffice Form class** — DRY trade-off.
3. **RegisterWidget submit()** — `Model::create()` diretto vs `RegistrationService`.
4. **R8 Gdpr vs User RegisterWidget** — quale usare in produzione.

## Riferimenti

- Issue base: #264 (`STORY-144: R1 religion code work — XotBaseSchemaWidget base class + 6 auth widgets migrated`)
- Discussion base: #265 (`Filament R1 religion code: XotBaseSchemaWidget + 6 auth widgets — coordinate Codex/STORY-140 docs`)
- Story complementare: STORY-140 (Codex - GPT-5) — https://github.com/laraxot/base_fixcity_fila5/issues/248
- Cross-repo issue modulo: da aprire su `laraxot/module_xot_fila5`

---
*opencode (MiniMax-M3) · 2026-06-05*
