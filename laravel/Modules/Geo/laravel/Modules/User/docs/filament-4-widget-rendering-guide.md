# Guida Rendering Widget Filament 4 - Modulo User

**Data**: 14 Ottobre 2025  
**Modulo**: User  
**Framework**: Filament 4.x + Laraxot

## 🎯 Obiettivo

Questa guida spiega **PERCHÉ** e **COME** renderizzare correttamente i widget Filament 4 nelle view Blade, con focus sul LoginWidget.

## 📊 Il Problema

### Sintomo
```blade
@livewire(\Modules\User\Filament\Widgets\Auth\LoginWidget::class)
```

Il widget viene caricato ma **il form non appare**.

### Causa Root

Filament 4 ha cambiato l'architettura dei widget rispetto a Filament 3:

1. **Widget ≠ Livewire Component Standalone**: Un widget Filament 4 NON è un semplice componente Livewire
2. **Richiede Wrapper Specifici**: Deve essere wrappato in componenti Filament
3. **Form Rendering Esplicito**: Il form deve essere renderizzato esplicitamente con `{{ $this->form }}`

## ✅ Soluzione Corretta

### 1. Struttura Widget PHP

```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class LoginWidget extends XotBaseWidget
{
    // ✅ CORRETTO: View path con pub_theme
    protected string $view = 'pub_theme::filament.widgets.auth.login';
    
    public ?array $data = [];

    // ✅ CORRETTO: Definire schema form
    public function getFormSchema(): array
    {
        return [
            TextInput::make('email')->email()->required(),
            TextInput::make('password')->password()->required(),
            Checkbox::make('remember'),
        ];
    }

    // ✅ CORRETTO: Metodo submit
    public function login(): void
    {
        $data = $this->form->getState();
        // Logica autenticazione
    }
}
```

### 2. View Blade Corretta

```blade
{{-- ✅ WRAPPER OBBLIGATORIO: x-filament-widgets::widget --}}
<x-filament-widgets::widget>
    {{-- ✅ SECTION OBBLIGATORIA: x-filament::section --}}
    <x-filament::section>
        <div class="space-y-6">
            {{-- Header --}}
            <div class="text-center">
                <h2>{{ __('user::auth.login.title') }}</h2>
            </div>

            {{-- ✅ FORM CON WIRE:SUBMIT --}}
            <form wire:submit="login" class="space-y-6">
                {{-- ✅ RENDERING FORM ESPLICITO --}}
                {{ $this->form }}

                {{-- Submit Button --}}
                <button type="submit" wire:loading.attr="disabled">
                    {{ __('user::auth.login.submit') }}
                </button>
            </form>

            {{-- Links --}}
            <div class="text-center">
                <a href="/register">{{ __('user::auth.login.register') }}</a>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
```

### 3. Uso nella Pagina

```blade
<x-layouts.app>
    <section class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-md">
            {{-- ✅ CORRETTO: Wrapper con stili --}}
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                @livewire(\Modules\User\Filament\Widgets\Auth\LoginWidget::class)
            </div>
        </div>
    </section>
</x-layouts.app>
```

## 🔍 Analisi Dettagliata

### Perché `<x-filament-widgets::widget>`?

**Filament 4 Architecture**:
```
Widget Component
    ↓
Filament Widget Wrapper (gestisce stili, tema, Livewire)
    ↓
Filament Section (gestisce layout, spacing, dark mode)
    ↓
Contenuto Custom
```

Senza il wrapper:
- ❌ Stili Filament non applicati
- ❌ Tema non caricato
- ❌ Livewire non integrato correttamente
- ❌ Errori JavaScript

### Perché `{{ $this->form }}`?

**Filament 4 Form Rendering**:

```php
// Nel Widget
public function getFormSchema(): array
{
    return [
        TextInput::make('email'),
        TextInput::make('password'),
    ];
}
```

```blade
{{-- Nella View --}}
{{ $this->form }}
{{-- Renderizza automaticamente TUTTI i campi definiti nello schema --}}
```

**Cosa fa `{{ $this->form }}`**:
1. Legge `getFormSchema()`
2. Renderizza ogni componente
3. Applica validazione
4. Gestisce errori
5. Applica stili Filament

### Perché `wire:submit="login"`?

**Livewire Integration**:

```blade
<form wire:submit="login">
    {{-- Quando submit, chiama il metodo login() nel Widget --}}
</form>
```

```php
// Nel Widget
public function login(): void
{
    $data = $this->form->getState(); // ← Ottiene dati validati
    // Autenticazione
}
```

## 📋 Checklist Debugging

### Widget non si carica

- [ ] Il widget estende `XotBaseWidget`?
- [ ] La view esiste nel path corretto?
- [ ] Il namespace è corretto (`Modules\User\Filament\Widgets\Auth`)?

### Form non appare

- [ ] `{{ $this->form }}` è presente nella view?
- [ ] `getFormSchema()` ritorna un array?
- [ ] I componenti Filament sono importati?

### Stili non applicati

- [ ] `<x-filament-widgets::widget>` è presente?
- [ ] `<x-filament::section>` è presente?
- [ ] Filament assets sono pubblicati?

### Submit non funziona

- [ ] `wire:submit="login"` è presente nel form?
- [ ] Il metodo `login()` esiste nel widget?
- [ ] `$this->form->getState()` è usato per ottenere i dati?

## 🎨 Best Practices

### 1. Separazione delle Responsabilità

```php
// ✅ CORRETTO: Widget gestisce logica
class LoginWidget extends XotBaseWidget
{
    public function getFormSchema(): array { /* ... */ }
    public function login(): void { /* ... */ }
}
```

```blade
{{-- ✅ CORRETTO: View gestisce presentazione --}}
<x-filament-widgets::widget>
    <x-filament::section>
        <form wire:submit="login">
            {{ $this->form }}
            <button type="submit">Login</button>
        </form>
    </x-filament::section>
</x-filament-widgets::widget>
```

### 2. Traduzioni

```php
// ❌ ERRATO: Hardcoded
TextInput::make('email')->label('Email')
```

```php
// ✅ CORRETTO: Traduzioni automatiche via LangServiceProvider
TextInput::make('email') // Label automatica da user::fields.email.label
```

### 3. Validazione

```php
// ✅ CORRETTO: Validazione Filament
public function getFormSchema(): array
{
    return [
        TextInput::make('email')
            ->email()
            ->required()
            ->maxLength(255),
        TextInput::make('password')
            ->password()
            ->required()
            ->minLength(8),
    ];
}
```

### 4. Error Handling

```php
public function login(): void
{
    try {
        $data = $this->form->getState();
        
        if (!Auth::attempt($data)) {
            // ✅ CORRETTO: Errore specifico sul campo
            $this->addError('email', __('auth.failed'));
            return;
        }
        
        redirect()->intended('/');
    } catch (\Exception $e) {
        // ✅ CORRETTO: Errore generico
        $this->addError('form', __('auth.error'));
    }
}
```

## 🔧 Esempi Completi

### Login Widget Completo

**Widget PHP**:
```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Auth;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class LoginWidget extends XotBaseWidget
{
    protected string $view = 'pub_theme::filament.widgets.auth.login';
    public ?array $data = [];

    public function getFormSchema(): array
    {
        return [
            TextInput::make('email')
                ->email()
                ->required()
                ->autofocus(),
            TextInput::make('password')
                ->password()
                ->required(),
            Checkbox::make('remember'),
        ];
    }

    public function login(): void
    {
        $data = $this->form->getState();

        if (!Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ], $data['remember'] ?? false)) {
            $this->addError('email', __('auth.failed'));
            return;
        }

        session()->regenerate();
        redirect()->intended('/');
    }
}
```

**View Blade**:
```blade
<x-filament-widgets::widget>
    <x-filament::section>
        <div class="space-y-6">
            <div class="text-center">
                <h2 class="text-2xl font-bold">
                    {{ __('user::auth.login.title') }}
                </h2>
            </div>

            <form wire:submit="login" class="space-y-6">
                {{ $this->form }}

                <button 
                    type="submit" 
                    wire:loading.attr="disabled"
                    class="w-full py-3 bg-primary-600 text-white rounded-md hover:bg-primary-700"
                >
                    <span wire:loading.remove>{{ __('user::auth.login.submit') }}</span>
                    <span wire:loading>{{ __('user::auth.login.submitting') }}</span>
                </button>
            </form>

            <div class="text-center text-sm">
                <a href="/register" class="text-primary-600 hover:underline">
                    {{ __('user::auth.login.register') }}
                </a>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
```

## 📚 Riferimenti

- [Filament 4 Widgets](https://filamentphp.com/docs/4.x/widgets)
- [Filament 4 Forms](https://filamentphp.com/docs/4.x/forms)
- [Livewire 3](https://livewire.laravel.com/docs/3.x)
- [Laraxot Widget Rules](./auth_widget_rules.md)

## 🎯 Conclusione

**Regola d'Oro**: Un widget Filament 4 è un componente complesso che richiede:

1. ✅ Wrapper `<x-filament-widgets::widget>`
2. ✅ Section `<x-filament::section>`
3. ✅ Form rendering `{{ $this->form }}`
4. ✅ Wire submit `wire:submit="methodName"`

Seguendo queste regole, il widget funzionerà correttamente in qualsiasi contesto.
