---
title: "widget: Consolidated Documentation"
module: user
type: integration
tags: [integrations, modules, user]
created: 2026-08-24
updated: 2026-08-24
status: draft
qmd: "widget   consolidated documentation user"
---

# widget: Consolidated Documentation

Consolidated from **12** individual files.

## Table of Contents

- [---](#widget-rendering-analysis-3)
- [---](#widget-rendering-analysis-4)
- [---](#widget-rendering-analysis-5)
- [---](#widget-rendering-analysis)
- [---](#widget-rendering)
- [---](#widget-translation-rules-3)
- [---](#widget-translation-rules)
- [---](#widget-translation)
- [🔍 Analisi Rendering LoginWidget - Docs.Italia.it Style](#widget_rendering_analysis)
- [Widget Translation Rules - SaluteOra Project](#widget_translation_rules)
- [---](#widgets-structure)
- [widgets_structure - User](#widgets_structure)

---

## widget-rendering-analysis-3

*Consolidated from: `widget-rendering-analysis.md`*

title: "🔍 Analisi Rendering LoginWidget - Docs.Italia.it Style"
type: concept
tags: [widget, rendering, analysis]
created: 2026-07-14
updated: 2026-07-14
qmd: "widget-rendering-analysis-3 🔍 analisi rendering loginwidget - docs.italia.it style"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# 🔍 Analisi Rendering LoginWidget - Docs.Italia.it Style

## 📋 Problema Analizzato

Il login dovrebbe apparire come in https://docs.italia.it/accounts/login/ - design pulito, professionale, conforme Bootstrap Italia.

### 🎯 Requisiti

1. **Design Conforme**: Seguire le linee guida Bootstrap Italia / Design Comuni
2. **Widget Filament 4**: Incorporare correttamente il widget Filament
3. **Form Rendering**: Il form deve renderizzarsi dentro il widget

## 🔍 Analisi Architetturale

### Componenti Coinvolti

#### 1. LoginWidget (PHP)
**Path**: `Modules/User/Filament/Widgets/Auth/LoginWidget.php`

```php
class LoginWidget extends XotBaseWidget
{
    protected string $view = 'pub_theme::filament.widgets.auth.login';
    
    public function getFormSchema(): array
    {
        return [
            TextInput::make('email')->email()->required(),
            TextInput::make('password')->password()->required(),
            Checkbox::make('remember'),
        ];
    }
    
    public function login(): void {
        // Logic di autenticazione
    }
}
```

#### 2. Vista Blade Login
**Path**: `Themes/Sixteen/resources/views/pages/auth/login.blade.php`

```blade
@livewire(\Modules\User\Filament\Widgets\Auth\LoginWidget::class)
```

#### 3. Vista Widget
**Path**: `Themes/Sixteen/resources/views/filament/widgets/auth/login.blade.php`

Questa è la vista che deve renderizzare il form.

## 🚨 Problema Identificato

### Causa Root: Form Non Renderizzato

Il widget Filament 4 richiede che il **form venga esplicitamente renderizzato** nella vista Blade del widget.

#### ❌ Vista Errata (Form non appare)

```blade
<x-filament-widgets::widget>
    <div class="login-container">
        <!-- Il form NON si renderizza automaticamente! -->
        <h2>Login</h2>
    </div>
</x-filament-widgets::widget>
```

#### ✅ Vista Corretta (Form renderizzato)

```blade
<x-filament-widgets::widget>
    <div class="login-container">
        <h2>Login</h2>
        
        <!-- ESSENZIALE: Renderizzare esplicitamente il form -->
        <form wire:submit="login">
            {{ $this->form }}
            
            <x-filament::button type="submit" class="w-full">
                {{ __('user::login.submit') }}
            </x-filament::button>
        </form>
        
        {{ $this->notifications() }}
    </div>
</x-filament-widgets::widget>
```

## 📐 Soluzione Architetturale

### Architettura Corretta Filament 4 Widgets

```
┌─────────────────────────────────────────┐
│ Blade Page (login.blade.php)           │
│                                         │
│  @livewire(LoginWidget::class)          │
│                                         │
└────────────┬────────────────────────────┘
             │
             ▼
┌─────────────────────────────────────────┐
│ LoginWidget.php                         │
│                                         │
│  - getFormSchema() → Definisce campi    │
│  - login() → Logica autenticazione      │
│  - $view → Vista widget                 │
│                                         │
└────────────┬────────────────────────────┘
             │
             ▼
┌─────────────────────────────────────────┐
│ Widget View                             │
│ (filament/widgets/auth/login.blade.php) │
│                                         │
│  <form wire:submit="login">             │
│      {{ $this->form }}  ← CRITICO!      │
│      <button>Submit</button>            │
│  </form>                                │
│                                         │
└─────────────────────────────────────────┘
```

### Componenti Essenziali

1. **`{{ $this->form }}`** - Rende tutti i campi definiti in `getFormSchema()`
2. **`wire:submit="login"`** - Collega il submit al metodo `login()` del widget
3. **`{{ $this->notifications() }}`** - Mostra notifiche Filament

## 🎨 Implementazione Design Docs.Italia

### Struttura Completa Vista Widget

```blade
<x-filament-widgets::widget class="fi-wi-login">
    <div class="login-widget-container">
        
        {{-- Header Branding --}}
        <div class="text-center mb-6">
            <div class="login-icon mx-auto mb-4">
                <svg class="w-12 h-12 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-italia-gray-900 mb-2">
                {{ __('user::login.title') }}
            </h1>
            <p class="text-italia-gray-600">
                {{ __('user::login.subtitle') }}
            </p>
        </div>
        
        {{-- Login Form --}}
        <div class="login-form-wrapper bg-white rounded-lg shadow-sm p-6 border border-italia-gray-200">
            
            {{-- FORM FILAMENT - ESSENZIALE --}}
            <form wire:submit="login" class="space-y-4">
                
                {{-- Renderizza tutti i campi definiti in getFormSchema() --}}
                {{ $this->form }}
                
                {{-- Actions --}}
                <div class="flex items-center justify-between mt-6">
                    {{-- Remember Me già incluso nel form --}}
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" 
                           class="text-sm text-primary-600 hover:text-primary-700">
                            {{ __('user::login.forgot_password') }}
                        </a>
                    @endif
                </div>
                
                {{-- Submit Button --}}
                <x-filament::button 
                    type="submit" 
                    class="w-full mt-4"
                    color="primary"
                    size="lg">
                    {{ __('user::login.submit') }}
                </x-filament::button>
                
            </form>
            
            {{-- Notifications --}}
            {{ $this->notifications() }}
            
        </div>
        
        {{-- Registration CTA --}}
        @if (Route::has('register'))
            <div class="text-center mt-6">
                <p class="text-sm text-italia-gray-600">
                    {{ __('user::login.no_account') }}
                    <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                        {{ __('user::login.create_account') }}
                    </a>
                </p>
            </div>
        @endif
        
        {{-- SPID/CIE (Future) --}}
        <div class="mt-6 pt-6 border-t border-italia-gray-200">
            <p class="text-xs text-center text-italia-gray-500 mb-3">
                {{ __('user::login.or_login_with') }}
            </p>
            
            <div class="flex gap-3">
                <button type="button" disabled 
                        class="flex-1 btn btn-outline-primary opacity-50 cursor-not-allowed">
                    <img src="/images/spid-icon.svg" alt="SPID" class="h-5 w-5 mr-2">
                    SPID
                    <span class="ml-2 text-xs">({{ __('common.coming_soon') }})</span>
                </button>
                
                <button type="button" disabled 
                        class="flex-1 btn btn-outline-primary opacity-50 cursor-not-allowed">
                    <img src="/images/cie-icon.svg" alt="CIE" class="h-5 w-5 mr-2">
                    CIE 3.0
                    <span class="ml-2 text-xs">({{ __('common.coming_soon') }})</span>
                </button>
            </div>
        </div>
        
    </div>
</x-filament-widgets::widget>

<style>
.login-widget-container {
    max-width: 420px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

.login-icon {
    width: 64px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0066CC 0%, #004A99 100%);
    border-radius: 50%;
    box-shadow: 0 4px 12px rgba(0, 102, 204, 0.2);
}

.login-form-wrapper {
    animation: fadeInUp 0.4s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
```

## 🔑 Best Practices

### 1. Struttura Widget

```php
class LoginWidget extends XotBaseWidget
{
    // ✅ Buono: Vista tema personalizzabile
    protected string $view = 'pub_theme::filament.widgets.auth.login';
    
    // ✅ Buono: Data property per form state
    public ?array $data = [];
    
    // ✅ Buono: Schema form chiaro
    public function getFormSchema(): array
    {
        return [
            TextInput::make('email')
                ->email()
                ->required()
                ->autofocus()
                ->placeholder(__('user::login.email_placeholder')),
            
            TextInput::make('password')
                ->password()
                ->required()
                ->revealable()
                ->placeholder(__('user::login.password_placeholder')),
            
            Checkbox::make('remember')
                ->label(__('user::login.remember_me')),
        ];
    }
    
    // ✅ Buono: Gestione errori completa
    public function login(): void
    {
        $data = $this->form->getState();
        
        if (Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ], $data['remember'] ?? false)) {
            session()->regenerate();
            $this->redirect(route('dashboard'));
            return;
        }
        
        $this->addError('email', __('auth.failed'));
    }
}
```

### 2. Vista Widget Minima

```blade
{{-- Vista minima funzionante --}}
<x-filament-widgets::widget>
    <form wire:submit="login">
        {{ $this->form }}
        <x-filament::button type="submit">Login</x-filament::button>
    </form>
</x-filament-widgets::widget>
```

### 3. Traduzioni

```php
// lang/it/login.php
return [
    'title' => 'Accedi ai servizi',
    'subtitle' => 'Utilizza le tue credenziali per accedere',
    'email_placeholder' => 'nome@esempio.it',
    'password_placeholder' => 'Inserisci la password',
    'remember_me' => 'Ricordami',
    'forgot_password' => 'Password dimenticata?',
    'submit' => 'Accedi',
    'no_account' => 'Non hai un account?',
    'create_account' => 'Registrati ora',
    'or_login_with' => 'Oppure accedi con',
];
```

## ✅ Checklist Implementazione

- [ ] Widget estende `XotBaseWidget`
- [ ] Vista configurata con `pub_theme::`
- [ ] `getFormSchema()` definisce i campi
- [ ] Vista widget include `{{ $this->form }}`
- [ ] Form ha `wire:submit="login"`
- [ ] Incluso `{{ $this->notifications() }}`
- [ ] Button submit presente
- [ ] Traduzioni complete
- [ ] Styling Bootstrap Italia applicato
- [ ] Test funzionale eseguito

## 🐛 Troubleshooting

### Form non appare

**Problema**: Il widget si rende ma non vedo i campi

**Soluzione**: Aggiungi `{{ $this->form }}` nella vista widget

### Errore "Call to undefined method"

**Problema**: `Method [form] not found`

**Soluzione**: Assicurati che il widget estenda `XotBaseWidget` che implementa `InteractsWithForms`

### Submit non funziona

**Problema**: Click su submit non fa nulla

**Soluzione**: 
1. Verifica `wire:submit="login"` nel form
2. Controlla che il metodo `login()` esista nel widget
3. Verifica CSRF token presente (automatico in Livewire)

### Styling non applicato

**Problema**: Il form appare senza stile

**Soluzione**: Filament 4 usa Tailwind CSS. Verifica che il tema abbia:
```html
<link rel="stylesheet" href="{{ asset('css/filament/app.css') }}">
```

## 📚 Riferimenti

- [Filament 4 Widgets Documentation](https://filamentphp.com/docs/4.x/widgets)
- [Filament Forms Documentation](https://filamentphp.com/docs/4.x/forms)
- [Bootstrap Italia Design System](https://italia.github.io/bootstrap-italia/)
- [Design Comuni Guidelines](https://designers.italia.it/modello/comuni/)

---

**Creato**: 14 Ottobre 2025  
**Autore**: Super Mucca Documentation Team  
**Status**: ✅ Validato e Testato  
**Versione**: 1.0.0





---

## widget-rendering-analysis-4

*Consolidated from: `widget-rendering-analysis.md`*

title: "🔍 Analisi Rendering LoginWidget - Docs.Italia.it Style"
type: concept
tags: [widget, rendering, analysis]
created: 2026-07-14
updated: 2026-07-14
qmd: "widget-rendering-analysis-4 🔍 analisi rendering loginwidget - docs.italia.it style"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# 🔍 Analisi Rendering LoginWidget - Docs.Italia.it Style

## 📋 Problema Analizzato

Il login dovrebbe apparire come in https://docs.italia.it/accounts/login/ - design pulito, professionale, conforme Bootstrap Italia.

### 🎯 Requisiti

1. **Design Conforme**: Seguire le linee guida Bootstrap Italia / Design Comuni
2. **Widget Filament 4**: Incorporare correttamente il widget Filament
3. **Form Rendering**: Il form deve renderizzarsi dentro il widget

## 🔍 Analisi Architetturale

### Componenti Coinvolti

#### 1. LoginWidget (PHP)
**Path**: `Modules/User/Filament/Widgets/Auth/LoginWidget.php`

```php
class LoginWidget extends XotBaseWidget
{
    protected string $view = 'pub_theme::filament.widgets.auth.login';
    
    public function getFormSchema(): array
    {
        return [
            TextInput::make('email')->email()->required(),
            TextInput::make('password')->password()->required(),
            Checkbox::make('remember'),
        ];
    }
    
    public function login(): void {
        // Logic di autenticazione
    }
}
```

#### 2. Vista Blade Login
**Path**: `Themes/Sixteen/resources/views/pages/auth/login.blade.php`

```blade
@livewire(\Modules\User\Filament\Widgets\Auth\LoginWidget::class)
```

#### 3. Vista Widget
**Path**: `Themes/Sixteen/resources/views/filament/widgets/auth/login.blade.php`

Questa è la vista che deve renderizzare il form.

## 🚨 Problema Identificato

### Causa Root: Form Non Renderizzato

Il widget Filament 4 richiede che il **form venga esplicitamente renderizzato** nella vista Blade del widget.

#### ❌ Vista Errata (Form non appare)

```blade
<x-filament-widgets::widget>
    <div class="login-container">
        <!-- Il form NON si renderizza automaticamente! -->
        <h2>Login</h2>
    </div>
</x-filament-widgets::widget>
```

#### ✅ Vista Corretta (Form renderizzato)

```blade
<x-filament-widgets::widget>
    <div class="login-container">
        <h2>Login</h2>
        
        <!-- ESSENZIALE: Renderizzare esplicitamente il form -->
        <form wire:submit="login">
            {{ $this->form }}
            
            <x-filament::button type="submit" class="w-full">
                {{ __('user::login.submit') }}
            </x-filament::button>
        </form>
        
        {{ $this->notifications() }}
    </div>
</x-filament-widgets::widget>
```

## 📐 Soluzione Architetturale

### Architettura Corretta Filament 4 Widgets

```
┌─────────────────────────────────────────┐
│ Blade Page (login.blade.php)           │
│                                         │
│  @livewire(LoginWidget::class)          │
│                                         │
└────────────┬────────────────────────────┘
             │
             ▼
┌─────────────────────────────────────────┐
│ LoginWidget.php                         │
│                                         │
│  - getFormSchema() → Definisce campi    │
│  - login() → Logica autenticazione      │
│  - $view → Vista widget                 │
│                                         │
└────────────┬────────────────────────────┘
             │
             ▼
┌─────────────────────────────────────────┐
│ Widget View                             │
│ (filament/widgets/auth/login.blade.php) │
│                                         │
│  <form wire:submit="login">             │
│      {{ $this->form }}  ← CRITICO!      │
│      <button>Submit</button>            │
│  </form>                                │
│                                         │
└─────────────────────────────────────────┘
```

### Componenti Essenziali

1. **`{{ $this->form }}`** - Rende tutti i campi definiti in `getFormSchema()`
2. **`wire:submit="login"`** - Collega il submit al metodo `login()` del widget
3. **`{{ $this->notifications() }}`** - Mostra notifiche Filament

## 🎨 Implementazione Design Docs.Italia

### Struttura Completa Vista Widget

```blade
<x-filament-widgets::widget class="fi-wi-login">
    <div class="login-widget-container">
        
        {{-- Header Branding --}}
        <div class="text-center mb-6">
            <div class="login-icon mx-auto mb-4">
                <svg class="w-12 h-12 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-italia-gray-900 mb-2">
                {{ __('user::login.title') }}
            </h1>
            <p class="text-italia-gray-600">
                {{ __('user::login.subtitle') }}
            </p>
        </div>
        
        {{-- Login Form --}}
        <div class="login-form-wrapper bg-white rounded-lg shadow-sm p-6 border border-italia-gray-200">
            
            {{-- FORM FILAMENT - ESSENZIALE --}}
            <form wire:submit="login" class="space-y-4">
                
                {{-- Renderizza tutti i campi definiti in getFormSchema() --}}
                {{ $this->form }}
                
                {{-- Actions --}}
                <div class="flex items-center justify-between mt-6">
                    {{-- Remember Me già incluso nel form --}}
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" 
                           class="text-sm text-primary-600 hover:text-primary-700">
                            {{ __('user::login.forgot_password') }}
                        </a>
                    @endif
                </div>
                
                {{-- Submit Button --}}
                <x-filament::button 
                    type="submit" 
                    class="w-full mt-4"
                    color="primary"
                    size="lg">
                    {{ __('user::login.submit') }}
                </x-filament::button>
                
            </form>
            
            {{-- Notifications --}}
            {{ $this->notifications() }}
            
        </div>
        
        {{-- Registration CTA --}}
        @if (Route::has('register'))
            <div class="text-center mt-6">
                <p class="text-sm text-italia-gray-600">
                    {{ __('user::login.no_account') }}
                    <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                        {{ __('user::login.create_account') }}
                    </a>
                </p>
            </div>
        @endif
        
        {{-- SPID/CIE (Future) --}}
        <div class="mt-6 pt-6 border-t border-italia-gray-200">
            <p class="text-xs text-center text-italia-gray-500 mb-3">
                {{ __('user::login.or_login_with') }}
            </p>
            
            <div class="flex gap-3">
                <button type="button" disabled 
                        class="flex-1 btn btn-outline-primary opacity-50 cursor-not-allowed">
                    <img src="/images/spid-icon.svg" alt="SPID" class="h-5 w-5 mr-2">
                    SPID
                    <span class="ml-2 text-xs">({{ __('common.coming_soon') }})</span>
                </button>
                
                <button type="button" disabled 
                        class="flex-1 btn btn-outline-primary opacity-50 cursor-not-allowed">
                    <img src="/images/cie-icon.svg" alt="CIE" class="h-5 w-5 mr-2">
                    CIE 3.0
                    <span class="ml-2 text-xs">({{ __('common.coming_soon') }})</span>
                </button>
            </div>
        </div>
        
    </div>
</x-filament-widgets::widget>

<style>
.login-widget-container {
    max-width: 420px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

.login-icon {
    width: 64px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0066CC 0%, #004A99 100%);
    border-radius: 50%;
    box-shadow: 0 4px 12px rgba(0, 102, 204, 0.2);
}

.login-form-wrapper {
    animation: fadeInUp 0.4s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
```

## 🔑 Best Practices

### 1. Struttura Widget

```php
class LoginWidget extends XotBaseWidget
{
    // ✅ Buono: Vista tema personalizzabile
    protected string $view = 'pub_theme::filament.widgets.auth.login';
    
    // ✅ Buono: Data property per form state
    public ?array $data = [];
    
    // ✅ Buono: Schema form chiaro
    public function getFormSchema(): array
    {
        return [
            TextInput::make('email')
                ->email()
                ->required()
                ->autofocus()
                ->placeholder(__('user::login.email_placeholder')),
            
            TextInput::make('password')
                ->password()
                ->required()
                ->revealable()
                ->placeholder(__('user::login.password_placeholder')),
            
            Checkbox::make('remember')
                ->label(__('user::login.remember_me')),
        ];
    }
    
    // ✅ Buono: Gestione errori completa
    public function login(): void
    {
        $data = $this->form->getState();
        
        if (Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ], $data['remember'] ?? false)) {
            session()->regenerate();
            $this->redirect(route('dashboard'));
            return;
        }
        
        $this->addError('email', __('auth.failed'));
    }
}
```

### 2. Vista Widget Minima

```blade
{{-- Vista minima funzionante --}}
<x-filament-widgets::widget>
    <form wire:submit="login">
        {{ $this->form }}
        <x-filament::button type="submit">Login</x-filament::button>
    </form>
</x-filament-widgets::widget>
```

### 3. Traduzioni

```php
// lang/it/login.php
return [
    'title' => 'Accedi ai servizi',
    'subtitle' => 'Utilizza le tue credenziali per accedere',
    'email_placeholder' => 'nome@esempio.it',
    'password_placeholder' => 'Inserisci la password',
    'remember_me' => 'Ricordami',
    'forgot_password' => 'Password dimenticata?',
    'submit' => 'Accedi',
    'no_account' => 'Non hai un account?',
    'create_account' => 'Registrati ora',
    'or_login_with' => 'Oppure accedi con',
];
```

## ✅ Checklist Implementazione

- [ ] Widget estende `XotBaseWidget`
- [ ] Vista configurata con `pub_theme::`
- [ ] `getFormSchema()` definisce i campi
- [ ] Vista widget include `{{ $this->form }}`
- [ ] Form ha `wire:submit="login"`
- [ ] Incluso `{{ $this->notifications() }}`
- [ ] Button submit presente
- [ ] Traduzioni complete
- [ ] Styling Bootstrap Italia applicato
- [ ] Test funzionale eseguito

## 🐛 Troubleshooting

### Form non appare

**Problema**: Il widget si rende ma non vedo i campi

**Soluzione**: Aggiungi `{{ $this->form }}` nella vista widget

### Errore "Call to undefined method"

**Problema**: `Method [form] not found`

**Soluzione**: Assicurati che il widget estenda `XotBaseWidget` che implementa `InteractsWithForms`

### Submit non funziona

**Problema**: Click su submit non fa nulla

**Soluzione**: 
1. Verifica `wire:submit="login"` nel form
2. Controlla che il metodo `login()` esista nel widget
3. Verifica CSRF token presente (automatico in Livewire)

### Styling non applicato

**Problema**: Il form appare senza stile

**Soluzione**: Filament 4 usa Tailwind CSS. Verifica che il tema abbia:
```html
<link rel="stylesheet" href="{{ asset('css/filament/app.css') }}">
```

## 📚 Riferimenti

- [Filament 4 Widgets Documentation](https://filamentphp.com/docs/4.x/widgets)
- [Filament Forms Documentation](https://filamentphp.com/docs/4.x/forms)
- [Bootstrap Italia Design System](https://italia.github.io/bootstrap-italia/)
- [Design Comuni Guidelines](https://designers.italia.it/modello/comuni/)

---

**Creato**: 14 Ottobre 2025  
**Autore**: Super Mucca Documentation Team  
**Status**: ✅ Validato e Testato  
**Versione**: 1.0.0





---

## widget-rendering-analysis-5

*Consolidated from: `widget-rendering-analysis.md`*

title: "🔍 Analisi Rendering LoginWidget - Docs.Italia.it Style"
type: concept
tags: [widget, rendering, analysis]
created: 2026-07-14
updated: 2026-07-14
qmd: "widget-rendering-analysis-5 🔍 analisi rendering loginwidget - docs.italia.it style"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# 🔍 Analisi Rendering LoginWidget - Docs.Italia.it Style

## 📋 Problema Analizzato

Il login dovrebbe apparire come in https://docs.italia.it/accounts/login/ - design pulito, professionale, conforme Bootstrap Italia.

### 🎯 Requisiti

1. **Design Conforme**: Seguire le linee guida Bootstrap Italia / Design Comuni
2. **Widget Filament 4**: Incorporare correttamente il widget Filament
3. **Form Rendering**: Il form deve renderizzarsi dentro il widget

## 🔍 Analisi Architetturale

### Componenti Coinvolti

#### 1. LoginWidget (PHP)
**Path**: `Modules/User/Filament/Widgets/Auth/LoginWidget.php`

```php
class LoginWidget extends XotBaseWidget
{
    protected string $view = 'pub_theme::filament.widgets.auth.login';
    
    public function getFormSchema(): array
    {
        return [
            TextInput::make('email')->email()->required(),
            TextInput::make('password')->password()->required(),
            Checkbox::make('remember'),
        ];
    }
    
    public function login(): void {
        // Logic di autenticazione
    }
}
```

#### 2. Vista Blade Login
**Path**: `Themes/Sixteen/resources/views/pages/auth/login.blade.php`

```blade
@livewire(\Modules\User\Filament\Widgets\Auth\LoginWidget::class)
```

#### 3. Vista Widget
**Path**: `Themes/Sixteen/resources/views/filament/widgets/auth/login.blade.php`

Questa è la vista che deve renderizzare il form.

## 🚨 Problema Identificato

### Causa Root: Form Non Renderizzato

Il widget Filament 4 richiede che il **form venga esplicitamente renderizzato** nella vista Blade del widget.

#### ❌ Vista Errata (Form non appare)

```blade
<x-filament-widgets::widget>
    <div class="login-container">
        <!-- Il form NON si renderizza automaticamente! -->
        <h2>Login</h2>
    </div>
</x-filament-widgets::widget>
```

#### ✅ Vista Corretta (Form renderizzato)

```blade
<x-filament-widgets::widget>
    <div class="login-container">
        <h2>Login</h2>
        
        <!-- ESSENZIALE: Renderizzare esplicitamente il form -->
        <form wire:submit="login">
            {{ $this->form }}
            
            <x-filament::button type="submit" class="w-full">
                {{ __('user::login.submit') }}
            </x-filament::button>
        </form>
        
        {{ $this->notifications() }}
    </div>
</x-filament-widgets::widget>
```

## 📐 Soluzione Architetturale

### Architettura Corretta Filament 4 Widgets

```
┌─────────────────────────────────────────┐
│ Blade Page (login.blade.php)           │
│                                         │
│  @livewire(LoginWidget::class)          │
│                                         │
└────────────┬────────────────────────────┘
             │
             ▼
┌─────────────────────────────────────────┐
│ LoginWidget.php                         │
│                                         │
│  - getFormSchema() → Definisce campi    │
│  - login() → Logica autenticazione      │
│  - $view → Vista widget                 │
│                                         │
└────────────┬────────────────────────────┘
             │
             ▼
┌─────────────────────────────────────────┐
│ Widget View                             │
│ (filament/widgets/auth/login.blade.php) │
│                                         │
│  <form wire:submit="login">             │
│      {{ $this->form }}  ← CRITICO!      │
│      <button>Submit</button>            │
│  </form>                                │
│                                         │
└─────────────────────────────────────────┘
```

### Componenti Essenziali

1. **`{{ $this->form }}`** - Rende tutti i campi definiti in `getFormSchema()`
2. **`wire:submit="login"`** - Collega il submit al metodo `login()` del widget
3. **`{{ $this->notifications() }}`** - Mostra notifiche Filament

## 🎨 Implementazione Design Docs.Italia

### Struttura Completa Vista Widget

```blade
<x-filament-widgets::widget class="fi-wi-login">
    <div class="login-widget-container">
        
        {{-- Header Branding --}}
        <div class="text-center mb-6">
            <div class="login-icon mx-auto mb-4">
                <svg class="w-12 h-12 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-italia-gray-900 mb-2">
                {{ __('user::login.title') }}
            </h1>
            <p class="text-italia-gray-600">
                {{ __('user::login.subtitle') }}
            </p>
        </div>
        
        {{-- Login Form --}}
        <div class="login-form-wrapper bg-white rounded-lg shadow-sm p-6 border border-italia-gray-200">
            
            {{-- FORM FILAMENT - ESSENZIALE --}}
            <form wire:submit="login" class="space-y-4">
                
                {{-- Renderizza tutti i campi definiti in getFormSchema() --}}
                {{ $this->form }}
                
                {{-- Actions --}}
                <div class="flex items-center justify-between mt-6">
                    {{-- Remember Me già incluso nel form --}}
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" 
                           class="text-sm text-primary-600 hover:text-primary-700">
                            {{ __('user::login.forgot_password') }}
                        </a>
                    @endif
                </div>
                
                {{-- Submit Button --}}
                <x-filament::button 
                    type="submit" 
                    class="w-full mt-4"
                    color="primary"
                    size="lg">
                    {{ __('user::login.submit') }}
                </x-filament::button>
                
            </form>
            
            {{-- Notifications --}}
            {{ $this->notifications() }}
            
        </div>
        
        {{-- Registration CTA --}}
        @if (Route::has('register'))
            <div class="text-center mt-6">
                <p class="text-sm text-italia-gray-600">
                    {{ __('user::login.no_account') }}
                    <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                        {{ __('user::login.create_account') }}
                    </a>
                </p>
            </div>
        @endif
        
        {{-- SPID/CIE (Future) --}}
        <div class="mt-6 pt-6 border-t border-italia-gray-200">
            <p class="text-xs text-center text-italia-gray-500 mb-3">
                {{ __('user::login.or_login_with') }}
            </p>
            
            <div class="flex gap-3">
                <button type="button" disabled 
                        class="flex-1 btn btn-outline-primary opacity-50 cursor-not-allowed">
                    <img src="/images/spid-icon.svg" alt="SPID" class="h-5 w-5 mr-2">
                    SPID
                    <span class="ml-2 text-xs">({{ __('common.coming_soon') }})</span>
                </button>
                
                <button type="button" disabled 
                        class="flex-1 btn btn-outline-primary opacity-50 cursor-not-allowed">
                    <img src="/images/cie-icon.svg" alt="CIE" class="h-5 w-5 mr-2">
                    CIE 3.0
                    <span class="ml-2 text-xs">({{ __('common.coming_soon') }})</span>
                </button>
            </div>
        </div>
        
    </div>
</x-filament-widgets::widget>

<style>
.login-widget-container {
    max-width: 420px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

.login-icon {
    width: 64px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0066CC 0%, #004A99 100%);
    border-radius: 50%;
    box-shadow: 0 4px 12px rgba(0, 102, 204, 0.2);
}

.login-form-wrapper {
    animation: fadeInUp 0.4s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
```

## 🔑 Best Practices

### 1. Struttura Widget

```php
class LoginWidget extends XotBaseWidget
{
    // ✅ Buono: Vista tema personalizzabile
    protected string $view = 'pub_theme::filament.widgets.auth.login';
    
    // ✅ Buono: Data property per form state
    public ?array $data = [];
    
    // ✅ Buono: Schema form chiaro
    public function getFormSchema(): array
    {
        return [
            TextInput::make('email')
                ->email()
                ->required()
                ->autofocus()
                ->placeholder(__('user::login.email_placeholder')),
            
            TextInput::make('password')
                ->password()
                ->required()
                ->revealable()
                ->placeholder(__('user::login.password_placeholder')),
            
            Checkbox::make('remember')
                ->label(__('user::login.remember_me')),
        ];
    }
    
    // ✅ Buono: Gestione errori completa
    public function login(): void
    {
        $data = $this->form->getState();
        
        if (Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ], $data['remember'] ?? false)) {
            session()->regenerate();
            $this->redirect(route('dashboard'));
            return;
        }
        
        $this->addError('email', __('auth.failed'));
    }
}
```

### 2. Vista Widget Minima

```blade
{{-- Vista minima funzionante --}}
<x-filament-widgets::widget>
    <form wire:submit="login">
        {{ $this->form }}
        <x-filament::button type="submit">Login</x-filament::button>
    </form>
</x-filament-widgets::widget>
```

### 3. Traduzioni

```php
// lang/it/login.php
return [
    'title' => 'Accedi ai servizi',
    'subtitle' => 'Utilizza le tue credenziali per accedere',
    'email_placeholder' => 'nome@esempio.it',
    'password_placeholder' => 'Inserisci la password',
    'remember_me' => 'Ricordami',
    'forgot_password' => 'Password dimenticata?',
    'submit' => 'Accedi',
    'no_account' => 'Non hai un account?',
    'create_account' => 'Registrati ora',
    'or_login_with' => 'Oppure accedi con',
];
```

## ✅ Checklist Implementazione

- [ ] Widget estende `XotBaseWidget`
- [ ] Vista configurata con `pub_theme::`
- [ ] `getFormSchema()` definisce i campi
- [ ] Vista widget include `{{ $this->form }}`
- [ ] Form ha `wire:submit="login"`
- [ ] Incluso `{{ $this->notifications() }}`
- [ ] Button submit presente
- [ ] Traduzioni complete
- [ ] Styling Bootstrap Italia applicato
- [ ] Test funzionale eseguito

## 🐛 Troubleshooting

### Form non appare

**Problema**: Il widget si rende ma non vedo i campi

**Soluzione**: Aggiungi `{{ $this->form }}` nella vista widget

### Errore "Call to undefined method"

**Problema**: `Method [form] not found`

**Soluzione**: Assicurati che il widget estenda `XotBaseWidget` che implementa `InteractsWithForms`

### Submit non funziona

**Problema**: Click su submit non fa nulla

**Soluzione**: 
1. Verifica `wire:submit="login"` nel form
2. Controlla che il metodo `login()` esista nel widget
3. Verifica CSRF token presente (automatico in Livewire)

### Styling non applicato

**Problema**: Il form appare senza stile

**Soluzione**: Filament 4 usa Tailwind CSS. Verifica che il tema abbia:
```html
<link rel="stylesheet" href="{{ asset('css/filament/app.css') }}">
```

## 📚 Riferimenti

- [Filament 4 Widgets Documentation](https://filamentphp.com/docs/4.x/widgets)
- [Filament Forms Documentation](https://filamentphp.com/docs/4.x/forms)
- [Bootstrap Italia Design System](https://italia.github.io/bootstrap-italia/)
- [Design Comuni Guidelines](https://designers.italia.it/modello/comuni/)

---

**Creato**: 14 Ottobre 2025  
**Autore**: Super Mucca Documentation Team  
**Status**: ✅ Validato e Testato  
**Versione**: 1.0.0





---

## widget-rendering-analysis

*Consolidated from: `widget-rendering-analysis.md`*

title: "🔍 Analisi Rendering LoginWidget - Docs.Italia.it Style"
type: concept
tags: [widget, rendering, analysis]
created: 2026-07-14
updated: 2026-07-14
qmd: "widget-rendering-analysis 🔍 analisi rendering loginwidget - docs.italia.it style"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# 🔍 Analisi Rendering LoginWidget - Docs.Italia.it Style

## 📋 Problema Analizzato

Il login dovrebbe apparire come in https://docs.italia.it/accounts/login/ - design pulito, professionale, conforme Bootstrap Italia.

### 🎯 Requisiti

1. **Design Conforme**: Seguire le linee guida Bootstrap Italia / Design Comuni
2. **Widget Filament 4**: Incorporare correttamente il widget Filament
3. **Form Rendering**: Il form deve renderizzarsi dentro il widget

## 🔍 Analisi Architetturale

### Componenti Coinvolti

#### 1. LoginWidget (PHP)
**Path**: `Modules/User/Filament/Widgets/Auth/LoginWidget.php`

```php
class LoginWidget extends XotBaseWidget
{
    protected string $view = 'pub_theme::filament.widgets.auth.login';
    
    public function getFormSchema(): array
    {
        return [
            TextInput::make('email')->email()->required(),
            TextInput::make('password')->password()->required(),
            Checkbox::make('remember'),
        ];
    }
    
    public function login(): void {
        // Logic di autenticazione
    }
}
```

#### 2. Vista Blade Login
**Path**: `Themes/Sixteen/resources/views/pages/auth/login.blade.php`

```blade
@livewire(\Modules\User\Filament\Widgets\Auth\LoginWidget::class)
```

#### 3. Vista Widget
**Path**: `Themes/Sixteen/resources/views/filament/widgets/auth/login.blade.php`

Questa è la vista che deve renderizzare il form.

## 🚨 Problema Identificato

### Causa Root: Form Non Renderizzato

Il widget Filament 4 richiede che il **form venga esplicitamente renderizzato** nella vista Blade del widget.

#### ❌ Vista Errata (Form non appare)

```blade
<x-filament-widgets::widget>
    <div class="login-container">
        <!-- Il form NON si renderizza automaticamente! -->
        <h2>Login</h2>
    </div>
</x-filament-widgets::widget>
```

#### ✅ Vista Corretta (Form renderizzato)

```blade
<x-filament-widgets::widget>
    <div class="login-container">
        <h2>Login</h2>
        
        <!-- ESSENZIALE: Renderizzare esplicitamente il form -->
        <form wire:submit="login">
            {{ $this->form }}
            
            <x-filament::button type="submit" class="w-full">
                {{ __('user::login.submit') }}
            </x-filament::button>
        </form>
        
        {{ $this->notifications() }}
    </div>
</x-filament-widgets::widget>
```

## 📐 Soluzione Architetturale

### Architettura Corretta Filament 4 Widgets

```
┌─────────────────────────────────────────┐
│ Blade Page (login.blade.php)           │
│                                         │
│  @livewire(LoginWidget::class)          │
│                                         │
└────────────┬────────────────────────────┘
             │
             ▼
┌─────────────────────────────────────────┐
│ LoginWidget.php                         │
│                                         │
│  - getFormSchema() → Definisce campi    │
│  - login() → Logica autenticazione      │
│  - $view → Vista widget                 │
│                                         │
└────────────┬────────────────────────────┘
             │
             ▼
┌─────────────────────────────────────────┐
│ Widget View                             │
│ (filament/widgets/auth/login.blade.php) │
│                                         │
│  <form wire:submit="login">             │
│      {{ $this->form }}  ← CRITICO!      │
│      <button>Submit</button>            │
│  </form>                                │
│                                         │
└─────────────────────────────────────────┘
```

### Componenti Essenziali

1. **`{{ $this->form }}`** - Rende tutti i campi definiti in `getFormSchema()`
2. **`wire:submit="login"`** - Collega il submit al metodo `login()` del widget
3. **`{{ $this->notifications() }}`** - Mostra notifiche Filament

## 🎨 Implementazione Design Docs.Italia

### Struttura Completa Vista Widget

```blade
<x-filament-widgets::widget class="fi-wi-login">
    <div class="login-widget-container">
        
        {{-- Header Branding --}}
        <div class="text-center mb-6">
            <div class="login-icon mx-auto mb-4">
                <svg class="w-12 h-12 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-italia-gray-900 mb-2">
                {{ __('user::login.title') }}
            </h1>
            <p class="text-italia-gray-600">
                {{ __('user::login.subtitle') }}
            </p>
        </div>
        
        {{-- Login Form --}}
        <div class="login-form-wrapper bg-white rounded-lg shadow-sm p-6 border border-italia-gray-200">
            
            {{-- FORM FILAMENT - ESSENZIALE --}}
            <form wire:submit="login" class="space-y-4">
                
                {{-- Renderizza tutti i campi definiti in getFormSchema() --}}
                {{ $this->form }}
                
                {{-- Actions --}}
                <div class="flex items-center justify-between mt-6">
                    {{-- Remember Me già incluso nel form --}}
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" 
                           class="text-sm text-primary-600 hover:text-primary-700">
                            {{ __('user::login.forgot_password') }}
                        </a>
                    @endif
                </div>
                
                {{-- Submit Button --}}
                <x-filament::button 
                    type="submit" 
                    class="w-full mt-4"
                    color="primary"
                    size="lg">
                    {{ __('user::login.submit') }}
                </x-filament::button>
                
            </form>
            
            {{-- Notifications --}}
            {{ $this->notifications() }}
            
        </div>
        
        {{-- Registration CTA --}}
        @if (Route::has('register'))
            <div class="text-center mt-6">
                <p class="text-sm text-italia-gray-600">
                    {{ __('user::login.no_account') }}
                    <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                        {{ __('user::login.create_account') }}
                    </a>
                </p>
            </div>
        @endif
        
        {{-- SPID/CIE (Future) --}}
        <div class="mt-6 pt-6 border-t border-italia-gray-200">
            <p class="text-xs text-center text-italia-gray-500 mb-3">
                {{ __('user::login.or_login_with') }}
            </p>
            
            <div class="flex gap-3">
                <button type="button" disabled 
                        class="flex-1 btn btn-outline-primary opacity-50 cursor-not-allowed">
                    <img src="/images/spid-icon.svg" alt="SPID" class="h-5 w-5 mr-2">
                    SPID
                    <span class="ml-2 text-xs">({{ __('common.coming_soon') }})</span>
                </button>
                
                <button type="button" disabled 
                        class="flex-1 btn btn-outline-primary opacity-50 cursor-not-allowed">
                    <img src="/images/cie-icon.svg" alt="CIE" class="h-5 w-5 mr-2">
                    CIE 3.0
                    <span class="ml-2 text-xs">({{ __('common.coming_soon') }})</span>
                </button>
            </div>
        </div>
        
    </div>
</x-filament-widgets::widget>

<style>
.login-widget-container {
    max-width: 420px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

.login-icon {
    width: 64px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0066CC 0%, #004A99 100%);
    border-radius: 50%;
    box-shadow: 0 4px 12px rgba(0, 102, 204, 0.2);
}

.login-form-wrapper {
    animation: fadeInUp 0.4s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
```

## 🔑 Best Practices

### 1. Struttura Widget

```php
class LoginWidget extends XotBaseWidget
{
    // ✅ Buono: Vista tema personalizzabile
    protected string $view = 'pub_theme::filament.widgets.auth.login';
    
    // ✅ Buono: Data property per form state
    public ?array $data = [];
    
    // ✅ Buono: Schema form chiaro
    public function getFormSchema(): array
    {
        return [
            TextInput::make('email')
                ->email()
                ->required()
                ->autofocus()
                ->placeholder(__('user::login.email_placeholder')),
            
            TextInput::make('password')
                ->password()
                ->required()
                ->revealable()
                ->placeholder(__('user::login.password_placeholder')),
            
            Checkbox::make('remember')
                ->label(__('user::login.remember_me')),
        ];
    }
    
    // ✅ Buono: Gestione errori completa
    public function login(): void
    {
        $data = $this->form->getState();
        
        if (Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ], $data['remember'] ?? false)) {
            session()->regenerate();
            $this->redirect(route('dashboard'));
            return;
        }
        
        $this->addError('email', __('auth.failed'));
    }
}
```

### 2. Vista Widget Minima

```blade
{{-- Vista minima funzionante --}}
<x-filament-widgets::widget>
    <form wire:submit="login">
        {{ $this->form }}
        <x-filament::button type="submit">Login</x-filament::button>
    </form>
</x-filament-widgets::widget>
```

### 3. Traduzioni

```php
// lang/it/login.php
return [
    'title' => 'Accedi ai servizi',
    'subtitle' => 'Utilizza le tue credenziali per accedere',
    'email_placeholder' => 'nome@esempio.it',
    'password_placeholder' => 'Inserisci la password',
    'remember_me' => 'Ricordami',
    'forgot_password' => 'Password dimenticata?',
    'submit' => 'Accedi',
    'no_account' => 'Non hai un account?',
    'create_account' => 'Registrati ora',
    'or_login_with' => 'Oppure accedi con',
];
```

## ✅ Checklist Implementazione

- [ ] Widget estende `XotBaseWidget`
- [ ] Vista configurata con `pub_theme::`
- [ ] `getFormSchema()` definisce i campi
- [ ] Vista widget include `{{ $this->form }}`
- [ ] Form ha `wire:submit="login"`
- [ ] Incluso `{{ $this->notifications() }}`
- [ ] Button submit presente
- [ ] Traduzioni complete
- [ ] Styling Bootstrap Italia applicato
- [ ] Test funzionale eseguito

## 🐛 Troubleshooting

### Form non appare

**Problema**: Il widget si rende ma non vedo i campi

**Soluzione**: Aggiungi `{{ $this->form }}` nella vista widget

### Errore "Call to undefined method"

**Problema**: `Method [form] not found`

**Soluzione**: Assicurati che il widget estenda `XotBaseWidget` che implementa `InteractsWithForms`

### Submit non funziona

**Problema**: Click su submit non fa nulla

**Soluzione**: 
1. Verifica `wire:submit="login"` nel form
2. Controlla che il metodo `login()` esista nel widget
3. Verifica CSRF token presente (automatico in Livewire)

### Styling non applicato

**Problema**: Il form appare senza stile

**Soluzione**: Filament 4 usa Tailwind CSS. Verifica che il tema abbia:
```html
<link rel="stylesheet" href="{{ asset('css/filament/app.css') }}">
```

## 📚 Riferimenti

- [Filament 4 Widgets Documentation](https://filamentphp.com/docs/4.x/widgets)
- [Filament Forms Documentation](https://filamentphp.com/docs/4.x/forms)
- [Bootstrap Italia Design System](https://italia.github.io/bootstrap-italia/)
- [Design Comuni Guidelines](https://designers.italia.it/modello/comuni/)

---

**Creato**: 14 Ottobre 2025  
**Autore**: Super Mucca Documentation Team  
**Status**: ✅ Validato e Testato  
**Versione**: 1.0.0





---

## widget-rendering

*Consolidated from: `widget-rendering.md`*

title: "🔍 Analisi Rendering LoginWidget - Docs.Italia.it Style"
type: concept
tags: [widget, rendering]
created: 2026-07-14
updated: 2026-07-14
qmd: "widget-rendering 🔍 analisi rendering loginwidget - docs.italia.it style"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# 🔍 Analisi Rendering LoginWidget - Docs.Italia.it Style

## 📋 Problema Analizzato

Il login dovrebbe apparire come in https://docs.italia.it/accounts/login/ - design pulito, professionale, conforme Bootstrap Italia.

### 🎯 Requisiti

1. **Design Conforme**: Seguire le linee guida Bootstrap Italia / Design Comuni
2. **Widget Filament 4**: Incorporare correttamente il widget Filament
3. **Form Rendering**: Il form deve renderizzarsi dentro il widget

## 🔍 Analisi Architetturale

### Componenti Coinvolti

#### 1. LoginWidget (PHP)
**Path**: `Modules/User/Filament/Widgets/Auth/LoginWidget.php`

```php
class LoginWidget extends XotBaseWidget
{
    protected string $view = 'pub_theme::filament.widgets.auth.login';
    
    public function getFormSchema(): array
    {
        return [
            TextInput::make('email')->email()->required(),
            TextInput::make('password')->password()->required(),
            Checkbox::make('remember'),
        ];
    }
    
    public function login(): void {
        // Logic di autenticazione
    }
}
```

#### 2. Vista Blade Login
**Path**: `Themes/Sixteen/resources/views/pages/auth/login.blade.php`

```blade
@livewire(\Modules\User\Filament\Widgets\Auth\LoginWidget::class)
```

#### 3. Vista Widget
**Path**: `Themes/Sixteen/resources/views/filament/widgets/auth/login.blade.php`

Questa è la vista che deve renderizzare il form.

## 🚨 Problema Identificato

### Causa Root: Form Non Renderizzato

Il widget Filament 4 richiede che il **form venga esplicitamente renderizzato** nella vista Blade del widget.

#### ❌ Vista Errata (Form non appare)

```blade
<x-filament-widgets::widget>
    <div class="login-container">
        <!-- Il form NON si renderizza automaticamente! -->
        <h2>Login</h2>
    </div>
</x-filament-widgets::widget>
```

#### ✅ Vista Corretta (Form renderizzato)

```blade
<x-filament-widgets::widget>
    <div class="login-container">
        <h2>Login</h2>
        
        <!-- ESSENZIALE: Renderizzare esplicitamente il form -->
        <form wire:submit="login">
            {{ $this->form }}
            
            <x-filament::button type="submit" class="w-full">
                {{ __('user::login.submit') }}
            </x-filament::button>
        </form>
        
        {{ $this->notifications() }}
    </div>
</x-filament-widgets::widget>
```

## 📐 Soluzione Architetturale

### Architettura Corretta Filament 4 Widgets

```
┌─────────────────────────────────────────┐
│ Blade Page (login.blade.php)           │
│                                         │
│  @livewire(LoginWidget::class)          │
│                                         │
└────────────┬────────────────────────────┘
             │
             ▼
┌─────────────────────────────────────────┐
│ LoginWidget.php                         │
│                                         │
│  - getFormSchema() → Definisce campi    │
│  - login() → Logica autenticazione      │
│  - $view → Vista widget                 │
│                                         │
└────────────┬────────────────────────────┘
             │
             ▼
┌─────────────────────────────────────────┐
│ Widget View                             │
│ (filament/widgets/auth/login.blade.php) │
│                                         │
│  <form wire:submit="login">             │
│      {{ $this->form }}  ← CRITICO!      │
│      <button>Submit</button>            │
│  </form>                                │
│                                         │
└─────────────────────────────────────────┘
```

### Componenti Essenziali

1. **`{{ $this->form }}`** - Rende tutti i campi definiti in `getFormSchema()`
2. **`wire:submit="login"`** - Collega il submit al metodo `login()` del widget
3. **`{{ $this->notifications() }}`** - Mostra notifiche Filament

## 🎨 Implementazione Design Docs.Italia

### Struttura Completa Vista Widget

```blade
<x-filament-widgets::widget class="fi-wi-login">
    <div class="login-widget-container">
        
        {{-- Header Branding --}}
        <div class="text-center mb-6">
            <div class="login-icon mx-auto mb-4">
                <svg class="w-12 h-12 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-italia-gray-900 mb-2">
                {{ __('user::login.title') }}
            </h1>
            <p class="text-italia-gray-600">
                {{ __('user::login.subtitle') }}
            </p>
        </div>
        
        {{-- Login Form --}}
        <div class="login-form-wrapper bg-white rounded-lg shadow-sm p-6 border border-italia-gray-200">
            
            {{-- FORM FILAMENT - ESSENZIALE --}}
            <form wire:submit="login" class="space-y-4">
                
                {{-- Renderizza tutti i campi definiti in getFormSchema() --}}
                {{ $this->form }}
                
                {{-- Actions --}}
                <div class="flex items-center justify-between mt-6">
                    {{-- Remember Me già incluso nel form --}}
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" 
                           class="text-sm text-primary-600 hover:text-primary-700">
                            {{ __('user::login.forgot_password') }}
                        </a>
                    @endif
                </div>
                
                {{-- Submit Button --}}
                <x-filament::button 
                    type="submit" 
                    class="w-full mt-4"
                    color="primary"
                    size="lg">
                    {{ __('user::login.submit') }}
                </x-filament::button>
                
            </form>
            
            {{-- Notifications --}}
            {{ $this->notifications() }}
            
        </div>
        
        {{-- Registration CTA --}}
        @if (Route::has('register'))
            <div class="text-center mt-6">
                <p class="text-sm text-italia-gray-600">
                    {{ __('user::login.no_account') }}
                    <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                        {{ __('user::login.create_account') }}
                    </a>
                </p>
            </div>
        @endif
        
        {{-- SPID/CIE (Future) --}}
        <div class="mt-6 pt-6 border-t border-italia-gray-200">
            <p class="text-xs text-center text-italia-gray-500 mb-3">
                {{ __('user::login.or_login_with') }}
            </p>
            
            <div class="flex gap-3">
                <button type="button" disabled 
                        class="flex-1 btn btn-outline-primary opacity-50 cursor-not-allowed">
                    <img src="/images/spid-icon.svg" alt="SPID" class="h-5 w-5 mr-2">
                    SPID
                    <span class="ml-2 text-xs">({{ __('common.coming_soon') }})</span>
                </button>
                
                <button type="button" disabled 
                        class="flex-1 btn btn-outline-primary opacity-50 cursor-not-allowed">
                    <img src="/images/cie-icon.svg" alt="CIE" class="h-5 w-5 mr-2">
                    CIE 3.0
                    <span class="ml-2 text-xs">({{ __('common.coming_soon') }})</span>
                </button>
            </div>
        </div>
        
    </div>
</x-filament-widgets::widget>

<style>
.login-widget-container {
    max-width: 420px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

.login-icon {
    width: 64px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0066CC 0%, #004A99 100%);
    border-radius: 50%;
    box-shadow: 0 4px 12px rgba(0, 102, 204, 0.2);
}

.login-form-wrapper {
    animation: fadeInUp 0.4s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
```

## 🔑 Best Practices

### 1. Struttura Widget

```php
class LoginWidget extends XotBaseWidget
{
    // ✅ Buono: Vista tema personalizzabile
    protected string $view = 'pub_theme::filament.widgets.auth.login';
    
    // ✅ Buono: Data property per form state
    public ?array $data = [];
    
    // ✅ Buono: Schema form chiaro
    public function getFormSchema(): array
    {
        return [
            TextInput::make('email')
                ->email()
                ->required()
                ->autofocus()
                ->placeholder(__('user::login.email_placeholder')),
            
            TextInput::make('password')
                ->password()
                ->required()
                ->revealable()
                ->placeholder(__('user::login.password_placeholder')),
            
            Checkbox::make('remember')
                ->label(__('user::login.remember_me')),
        ];
    }
    
    // ✅ Buono: Gestione errori completa
    public function login(): void
    {
        $data = $this->form->getState();
        
        if (Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ], $data['remember'] ?? false)) {
            session()->regenerate();
            $this->redirect(route('dashboard'));
            return;
        }
        
        $this->addError('email', __('auth.failed'));
    }
}
```

### 2. Vista Widget Minima

```blade
{{-- Vista minima funzionante --}}
<x-filament-widgets::widget>
    <form wire:submit="login">
        {{ $this->form }}
        <x-filament::button type="submit">Login</x-filament::button>
    </form>
</x-filament-widgets::widget>
```

### 3. Traduzioni

```php
// lang/it/login.php
return [
    'title' => 'Accedi ai servizi',
    'subtitle' => 'Utilizza le tue credenziali per accedere',
    'email_placeholder' => 'nome@esempio.it',
    'password_placeholder' => 'Inserisci la password',
    'remember_me' => 'Ricordami',
    'forgot_password' => 'Password dimenticata?',
    'submit' => 'Accedi',
    'no_account' => 'Non hai un account?',
    'create_account' => 'Registrati ora',
    'or_login_with' => 'Oppure accedi con',
];
```

## ✅ Checklist Implementazione

- [ ] Widget estende `XotBaseWidget`
- [ ] Vista configurata con `pub_theme::`
- [ ] `getFormSchema()` definisce i campi
- [ ] Vista widget include `{{ $this->form }}`
- [ ] Form ha `wire:submit="login"`
- [ ] Incluso `{{ $this->notifications() }}`
- [ ] Button submit presente
- [ ] Traduzioni complete
- [ ] Styling Bootstrap Italia applicato
- [ ] Test funzionale eseguito

## 🐛 Troubleshooting

### Form non appare

**Problema**: Il widget si rende ma non vedo i campi

**Soluzione**: Aggiungi `{{ $this->form }}` nella vista widget

### Errore "Call to undefined method"

**Problema**: `Method [form] not found`

**Soluzione**: Assicurati che il widget estenda `XotBaseWidget` che implementa `InteractsWithForms`

### Submit non funziona

**Problema**: Click su submit non fa nulla

**Soluzione**: 
1. Verifica `wire:submit="login"` nel form
2. Controlla che il metodo `login()` esista nel widget
3. Verifica CSRF token presente (automatico in Livewire)

### Styling non applicato

**Problema**: Il form appare senza stile

**Soluzione**: Filament 4 usa Tailwind CSS. Verifica che il tema abbia:
```html
<link rel="stylesheet" href="{{ asset('css/filament/app.css') }}">
```

## 📚 Riferimenti

- [Filament 4 Widgets Documentation](https://filamentphp.com/docs/4.x/widgets)
- [Filament Forms Documentation](https://filamentphp.com/docs/4.x/forms)
- [Bootstrap Italia Design System](https://italia.github.io/bootstrap-italia/)
- [Design Comuni Guidelines](https://designers.italia.it/modello/comuni/)

---

**Creato**: 14 Ottobre 2025  
**Autore**: Super Mucca Documentation Team  
**Status**: ✅ Validato e Testato  
**Versione**: 1.0.0





---

## widget-translation-rules-3

*Consolidated from: `widget-translation-rules.md`*
*Consolidated from: `widget-translation-rules-memory-integration.md`*

title: "Widget Translation Rules 3"
type: rule
tags: [widget, translation, rules]
created: 2026-07-14
updated: 2026-07-14
qmd: "widget-translation-rules-3 widget translation rules 3"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
---

- [User Module Widget Structure](../Modules/User/docs/widgets-structure.md)
- [EditUserWidget Documentation](../Modules/User/docs/widgets/edit-user-widget.md)
- [Widget Translation Guidelines](../Modules/User/docs/widgets/translation-guidelines.md)
- [Filament Widget Conventions](../Modules/Xot/docs/filament-widgets.md)
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

- [User Module Widget Structure](../../widgets-structure-user.md)
- [EditUserWidget Documentation](../Modules/User/docs/widgets/edit-user-widget.md)
- [Widget Translation Guidelines](../Modules/User/docs/widgets/translation-guidelines.md)
- [Filament Widget Conventions](../../best-practices/filament-widgets.md)

## Memory Integration

This document serves as a reference for:
- Widget development standards
- Translation implementation patterns
- Code quality requirements
- Documentation standards

All widget development should follow these rules to maintain consistency and quality across the SaluteOra project.
---
module: theme
topic: widget_translation_rules
canonical: ../../../Themes/docs/shared-components/widget-translation-rules.md
---

See canonical documentation: ../../../Themes/docs/shared-components/widget-translation-rules.md
canonical: ../../../Themes/docs/shared-components/widget-translation-rules-memory-integration.md
---

See canonical documentation: ../../../Themes/docs/shared-components/widget-translation-rules-memory-integration.md
---

## widget-translation-rules

*Consolidated from: `widget-translation-rules.md`*

module: theme
topic: widget-translation-rules
canonical: ../../../Themes/docs/shared-components/widget-translation-rules-Modules.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/widget-translation-rules-Modules.md

---

## widget-translation

*Consolidated from: `widget-translation.md`*

title: "Widget Translation Rules - <nome progetto> Project"
type: concept
tags: [widget, translation]
created: 2026-07-14
updated: 2026-07-14
qmd: "widget-translation widget translation rules - <nome progetto> project"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Widget Translation Rules - <nome progetto> Project

## Core Principles
### Translation File Structure
- All widget translations MUST be in `Modules/{ModuleName}/lang/{locale}/widgets.php`
- Use expanded structure with `label`, `placeholder`, `help` for all fields
- Never use hardcoded strings in widgets or views
### Widget Implementation Rules
- NEVER use `->label()`, `->placeholder()`, or `->help()` in form components
- NEVER use `__()` or `trans()` functions directly in form components
- Let LangServiceProvider handle automatic translation loading
- Use translation keys for select options and dynamic content
### View Path Convention
- Widget views MUST use path: `modulename::filament.widgets.widget-name`
- NEVER use `modulename::widgets.widget-name` (missing filament prefix)
- Views located in `resources/views/filament/widgets/`
## Translation Structure Pattern
### Required Structure
```php
return [
    'widget_name' => [
        'title' => 'Widget Title',
        'description' => 'Widget Description',
        'sections' => [
            'section_name' => [
                'title' => 'Section Title',
                'description' => 'Section Description',
            ],
        ],
        'fields' => [
            'field_name' => [
                'label' => 'Field Label',
                'placeholder' => 'Field Placeholder',
                'help' => 'Field Help Text',
                'options' => [
                    'option_key' => 'Option Label',
                ],
        'actions' => [
            'action_name' => [
                'label' => 'Action Label',
                'tooltip' => 'Action Tooltip',
        'messages' => [
            'success' => 'Success Message',
            'error' => 'Error Message',
        'validation' => [
            'rule_name' => 'Validation Message',
    ],
];
```
## Widget Class Rules
### Base Class Extension
- ALWAYS extend `XotBaseWidget` from `Modules\Xot\Filament\Widgets`
- NEVER extend Filament widgets directly
- Use `HasForms` interface with `InteractsWithForms` trait
### Form Schema Rules
- `getFormSchema()` MUST return associative array with string keys
- Field names automatically map to translation keys
- Use sections for logical grouping
### Example Correct Implementation
<?php
declare(strict_types=1);
namespace Modules\User\Filament\Widgets;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
class EditUserWidget extends XotBaseWidget
{
    protected static string $view = 'user::filament.widgets.edit-user';
    public function getFormSchema(): array
    {
        return [
            'personal_info' => Section::make()->schema([
                TextInput::make('first_name')->required(),
                TextInput::make('last_name')->required(),
                TextInput::make('email')->required()->email(),
            ]),
        ];
    }
}
## View Implementation Rules
### Blade View Structure
- Use translation keys for all text content
- Follow responsive design patterns
- Use Tailwind CSS for styling consistency
### Example Correct View
```blade
<div class="p-6">
    <h2 class="text-xl font-semibold mb-4">
        {{ __('user::widgets.edit_user.title') }}
    </h2>

    <p class="text-gray-600 mb-6">
        {{ __('user::widgets.edit_user.description') }}
    </p>
    {{ $this->form }}
    <div class="mt-6 flex justify-end space-x-3">
        <button type="button" class="btn-secondary">
            {{ __('user::widgets.edit_user.actions.cancel.label') }}
        </button>
        <button type="submit" class="btn-primary">
            {{ __('user::widgets.edit_user.actions.save.label') }}
    </div>
</div>
## Anti-Patterns to Avoid
### ❌ WRONG - Direct Labels
TextInput::make('name')->label('Name')->placeholder('Enter name')
### ❌ WRONG - Translation Functions in Components
TextInput::make('name')->label(__('user::fields.name'))
### ❌ WRONG - Incorrect View Path
protected static string $view = 'user::widgets.edit-user';
### ❌ WRONG - Hardcoded Strings in Views
<h2>Edit User Profile</h2>
## Documentation Requirements
### Module Documentation
- Document all widgets in module's `docs/widgets/` folder
- Include translation guidelines and examples
- Link to related documentation
### Translation Documentation
- Document all translation keys and their purpose
- Provide examples for complex structures
- Maintain consistency across languages
## Quality Assurance
### Checklist for Widget Development
- [ ] Extends XotBaseWidget
- [ ] Uses correct view path with filament prefix
- [ ] No direct labels or hardcoded strings
- [ ] Translation files follow expanded structure
- [ ] Documentation updated in module docs
- [ ] All supported languages have translations
### Testing Requirements
- Test widget functionality across all supported languages
- Verify translation key resolution
- Check responsive design and accessibility
- Validate form submission and error handling
## Related Documentation
- [User Module Widget Structure](../modules/user/project_docs/widgets-structure.md)
- [EditUserWidget Documentation](../modules/user/project_docs/widgets/edit-user-widget.md)
- [Widget Translation Guidelines](../modules/user/project_docs/widgets/translation-guidelines.md)
- [Filament Widget Conventions](../modules/xot/project_docs/filament-widgets.md)
- [User Module Widget Structure](../modules/user/docs/widgets-structure.md)
- [User Module Widget Structure](../modules/user/project_docs/widgets-structure-user.md)
- [EditUserWidget Documentation](../modules/user/project_docs/widgets/edit-user-widget.md)
- [Widget Translation Guidelines](../modules/user/project_docs/widgets/translation-guidelines.md)
- [Filament Widget Conventions](../modules/xot/project_docs/filament-widgets.md)
- [User Module Widget Structure](../modules/user/docs/widgets-structure-user.md)
- [EditUserWidget Documentation](../modules/user/docs/widgets/edit-user-widget.md)
- [Widget Translation Guidelines](../modules/user/docs/widgets/translation-guidelines.md)
- [Filament Widget Conventions](../modules/xot/docs/filament-widgets.md)
## Memory Integration
This document serves as a reference for:
- Widget development standards
- Translation implementation patterns
- Code quality requirements
- Documentation standards
All widget development should follow these rules to maintain consistency and quality across the <nome progetto> project.
# Widget Translation Rules - <nome progetto> Project

## Core Principles

### Translation File Structure
- All widget translations MUST be in `Modules/{ModuleName}/lang/{locale}/widgets.php`
- Use expanded structure with `label`, `placeholder`, `help` for all fields
- Never use hardcoded strings in widgets or views

### Widget Implementation Rules
- NEVER use `->label()`, `->placeholder()`, or `->help()` in form components
- NEVER use `__()` or `trans()` functions directly in form components
- Let LangServiceProvider handle automatic translation loading
- Use translation keys for select options and dynamic content

### View Path Convention
- Widget views MUST use path: `modulename::filament.widgets.widget-name`
- NEVER use `modulename::widgets.widget-name` (missing filament prefix)
- Views located in `resources/views/filament/widgets/`

## Translation Structure Pattern

### Required Structure
```

```php
return [
    'widget_name' => [
        'title' => 'Widget Title',
        'description' => 'Widget Description',
        'sections' => [
            'section_name' => [
                'title' => 'Section Title',
                'description' => 'Section Description',
            ],
        ],
        'fields' => [
            'field_name' => [
                'label' => 'Field Label',
                'placeholder' => 'Field Placeholder',
                'help' => 'Field Help Text',
                'options' => [
                    'option_key' => 'Option Label',
                ],
            ],
        ],
        'actions' => [
            'action_name' => [
                'label' => 'Action Label',
                'tooltip' => 'Action Tooltip',
            ],
        ],
        'messages' => [
            'success' => 'Success Message',
            'error' => 'Error Message',
        ],
        'validation' => [
            'rule_name' => 'Validation Message',
        ],
    ],
];
```

## Widget Class Rules

### Base Class Extension
- ALWAYS extend `XotBaseWidget` from `Modules\Xot\Filament\Widgets`
- NEVER extend Filament widgets directly
- Use `HasForms` interface with `InteractsWithForms` trait

### Form Schema Rules
- `getFormSchema()` MUST return associative array with string keys
- Field names automatically map to translation keys
- Use sections for logical grouping

### Example Correct Implementation
```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class EditUserWidget extends XotBaseWidget
{
    protected static string $view = 'user::filament.widgets.edit-user';

    public function getFormSchema(): array
    {
        return [
            'personal_info' => Section::make()->schema([
                TextInput::make('first_name')->required(),
                TextInput::make('last_name')->required(),
                TextInput::make('email')->required()->email(),
            ]),
        ];
    }
}
```

## View Implementation Rules

### Blade View Structure
- Use translation keys for all text content
- Follow responsive design patterns
- Use Tailwind CSS for styling consistency

### Example Correct View
```blade
<div class="p-6">
    <h2 class="text-xl font-semibold mb-4">
        {{ __('user::widgets.edit_user.title') }}
    </h2>

    <p class="text-gray-600 mb-6">
        {{ __('user::widgets.edit_user.description') }}
    </p>

    {{ $this->form }}

    <div class="mt-6 flex justify-end space-x-3">
        <button type="button" class="btn-secondary">
            {{ __('user::widgets.edit_user.actions.cancel.label') }}
        </button>
        <button type="submit" class="btn-primary">
            {{ __('user::widgets.edit_user.actions.save.label') }}
        </button>
    </div>
</div>
```

## Anti-Patterns to Avoid

### ❌ WRONG - Direct Labels
```php
TextInput::make('name')->label('Name')->placeholder('Enter name')
```

### ❌ WRONG - Translation Functions in Components
```php
TextInput::make('name')->label(__('user::fields.name'))
```

### ❌ WRONG - Incorrect View Path
```php
protected static string $view = 'user::widgets.edit-user';
```

### ❌ WRONG - Hardcoded Strings in Views
```blade
<h2>Edit User Profile</h2>
```

## Documentation Requirements

### Module Documentation
- Document all widgets in module's `docs/widgets/` folder
- Include translation guidelines and examples
- Link to related documentation

### Translation Documentation
- Document all translation keys and their purpose
- Provide examples for complex structures
- Maintain consistency across languages

## Quality Assurance

### Checklist for Widget Development
- [ ] Extends XotBaseWidget
- [ ] Uses correct view path with filament prefix
- [ ] No direct labels or hardcoded strings
- [ ] Translation files follow expanded structure
- [ ] Documentation updated in module docs
- [ ] All supported languages have translations

### Testing Requirements
- Test widget functionality across all supported languages
- Verify translation key resolution
- Check responsive design and accessibility
- Validate form submission and error handling

## Related Documentation

- [User Module Widget Structure](../modules/user/docs/widgets-structure.md)
- [EditUserWidget Documentation](../modules/user/docs/widgets/edit-user-widget.md)
- [Widget Translation Guidelines](../modules/user/docs/widgets/translation-guidelines.md)
- [Filament Widget Conventions](../modules/xot/docs/filament-widgets.md)
- [User Module Widget Structure](../../widgets-structure-user.md)
- [EditUserWidget Documentation](../modules/user/docs/widgets/edit-user-widget.md)
- [Widget Translation Guidelines](../modules/user/docs/widgets/translation-guidelines.md)
- [Filament Widget Conventions](../../best-practices/filament-widgets.md)

## Memory Integration

This document serves as a reference for:
- Widget development standards
- Translation implementation patterns
- Code quality requirements
- Documentation standards

All widget development should follow these rules to maintain consistency and quality across the <nome progetto> project.

---

## widget_rendering_analysis

*Consolidated from: `widget_rendering_analysis.md`*


## 📋 Problema Analizzato

Il login dovrebbe apparire come in https://docs.italia.it/accounts/login/ - design pulito, professionale, conforme Bootstrap Italia.

### 🎯 Requisiti

1. **Design Conforme**: Seguire le linee guida Bootstrap Italia / Design Comuni
2. **Widget Filament 4**: Incorporare correttamente il widget Filament
3. **Form Rendering**: Il form deve renderizzarsi dentro il widget

## 🔍 Analisi Architetturale

### Componenti Coinvolti

#### 1. LoginWidget (PHP)
**Path**: `Modules/User/Filament/Widgets/Auth/LoginWidget.php`

```php
class LoginWidget extends XotBaseWidget
{
    protected string $view = 'pub_theme::filament.widgets.auth.login';
    
    public function getFormSchema(): array
    {
        return [
            TextInput::make('email')->email()->required(),
            TextInput::make('password')->password()->required(),
            Checkbox::make('remember'),
        ];
    }
    
    public function login(): void {
        // Logic di autenticazione
    }
}
```

#### 2. Vista Blade Login
**Path**: `Themes/Sixteen/resources/views/pages/auth/login.blade.php`

```blade
@livewire(\Modules\User\Filament\Widgets\Auth\LoginWidget::class)
```

#### 3. Vista Widget
**Path**: `Themes/Sixteen/resources/views/filament/widgets/auth/login.blade.php`

Questa è la vista che deve renderizzare il form.

## 🚨 Problema Identificato

### Causa Root: Form Non Renderizzato

Il widget Filament 4 richiede che il **form venga esplicitamente renderizzato** nella vista Blade del widget.

#### ❌ Vista Errata (Form non appare)

```blade
<x-filament-widgets::widget>
    <div class="login-container">
        <!-- Il form NON si renderizza automaticamente! -->
        <h2>Login</h2>
    </div>
</x-filament-widgets::widget>
```

#### ✅ Vista Corretta (Form renderizzato)

```blade
<x-filament-widgets::widget>
    <div class="login-container">
        <h2>Login</h2>
        
        <!-- ESSENZIALE: Renderizzare esplicitamente il form -->
        <form wire:submit="login">
            {{ $this->form }}
            
            <x-filament::button type="submit" class="w-full">
                {{ __('user::login.submit') }}
            </x-filament::button>
        </form>
        
        {{ $this->notifications() }}
    </div>
</x-filament-widgets::widget>
```

## 📐 Soluzione Architetturale

### Architettura Corretta Filament 4 Widgets

```
┌─────────────────────────────────────────┐
│ Blade Page (login.blade.php)           │
│                                         │
│  @livewire(LoginWidget::class)          │
│                                         │
└────────────┬────────────────────────────┘
             │
             ▼
┌─────────────────────────────────────────┐
│ LoginWidget.php                         │
│                                         │
│  - getFormSchema() → Definisce campi    │
│  - login() → Logica autenticazione      │
│  - $view → Vista widget                 │
│                                         │
└────────────┬────────────────────────────┘
             │
             ▼
┌─────────────────────────────────────────┐
│ Widget View                             │
│ (filament/widgets/auth/login.blade.php) │
│                                         │
│  <form wire:submit="login">             │
│      {{ $this->form }}  ← CRITICO!      │
│      <button>Submit</button>            │
│  </form>                                │
│                                         │
└─────────────────────────────────────────┘
```

### Componenti Essenziali

1. **`{{ $this->form }}`** - Rende tutti i campi definiti in `getFormSchema()`
2. **`wire:submit="login"`** - Collega il submit al metodo `login()` del widget
3. **`{{ $this->notifications() }}`** - Mostra notifiche Filament

## 🎨 Implementazione Design Docs.Italia

### Struttura Completa Vista Widget

```blade
<x-filament-widgets::widget class="fi-wi-login">
    <div class="login-widget-container">
        
        {{-- Header Branding --}}
        <div class="text-center mb-6">
            <div class="login-icon mx-auto mb-4">
                <svg class="w-12 h-12 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-italia-gray-900 mb-2">
                {{ __('user::login.title') }}
            </h1>
            <p class="text-italia-gray-600">
                {{ __('user::login.subtitle') }}
            </p>
        </div>
        
        {{-- Login Form --}}
        <div class="login-form-wrapper bg-white rounded-lg shadow-sm p-6 border border-italia-gray-200">
            
            {{-- FORM FILAMENT - ESSENZIALE --}}
            <form wire:submit="login" class="space-y-4">
                
                {{-- Renderizza tutti i campi definiti in getFormSchema() --}}
                {{ $this->form }}
                
                {{-- Actions --}}
                <div class="flex items-center justify-between mt-6">
                    {{-- Remember Me già incluso nel form --}}
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" 
                           class="text-sm text-primary-600 hover:text-primary-700">
                            {{ __('user::login.forgot_password') }}
                        </a>
                    @endif
                </div>
                
                {{-- Submit Button --}}
                <x-filament::button 
                    type="submit" 
                    class="w-full mt-4"
                    color="primary"
                    size="lg">
                    {{ __('user::login.submit') }}
                </x-filament::button>
                
            </form>
            
            {{-- Notifications --}}
            {{ $this->notifications() }}
            
        </div>
        
        {{-- Registration CTA --}}
        @if (Route::has('register'))
            <div class="text-center mt-6">
                <p class="text-sm text-italia-gray-600">
                    {{ __('user::login.no_account') }}
                    <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                        {{ __('user::login.create_account') }}
                    </a>
                </p>
            </div>
        @endif
        
        {{-- SPID/CIE (Future) --}}
        <div class="mt-6 pt-6 border-t border-italia-gray-200">
            <p class="text-xs text-center text-italia-gray-500 mb-3">
                {{ __('user::login.or_login_with') }}
            </p>
            
            <div class="flex gap-3">
                <button type="button" disabled 
                        class="flex-1 btn btn-outline-primary opacity-50 cursor-not-allowed">
                    <img src="/images/spid-icon.svg" alt="SPID" class="h-5 w-5 mr-2">
                    SPID
                    <span class="ml-2 text-xs">({{ __('common.coming_soon') }})</span>
                </button>
                
                <button type="button" disabled 
                        class="flex-1 btn btn-outline-primary opacity-50 cursor-not-allowed">
                    <img src="/images/cie-icon.svg" alt="CIE" class="h-5 w-5 mr-2">
                    CIE 3.0
                    <span class="ml-2 text-xs">({{ __('common.coming_soon') }})</span>
                </button>
            </div>
        </div>
        
    </div>
</x-filament-widgets::widget>

<style>
.login-widget-container {
    max-width: 420px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

.login-icon {
    width: 64px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0066CC 0%, #004A99 100%);
    border-radius: 50%;
    box-shadow: 0 4px 12px rgba(0, 102, 204, 0.2);
}

.login-form-wrapper {
    animation: fadeInUp 0.4s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
```

## 🔑 Best Practices

### 1. Struttura Widget

```php
class LoginWidget extends XotBaseWidget
{
    // ✅ Buono: Vista tema personalizzabile
    protected string $view = 'pub_theme::filament.widgets.auth.login';
    
    // ✅ Buono: Data property per form state
    public ?array $data = [];
    
    // ✅ Buono: Schema form chiaro
    public function getFormSchema(): array
    {
        return [
            TextInput::make('email')
                ->email()
                ->required()
                ->autofocus()
                ->placeholder(__('user::login.email_placeholder')),
            
            TextInput::make('password')
                ->password()
                ->required()
                ->revealable()
                ->placeholder(__('user::login.password_placeholder')),
            
            Checkbox::make('remember')
                ->label(__('user::login.remember_me')),
        ];
    }
    
    // ✅ Buono: Gestione errori completa
    public function login(): void
    {
        $data = $this->form->getState();
        
        if (Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ], $data['remember'] ?? false)) {
            session()->regenerate();
            $this->redirect(route('dashboard'));
            return;
        }
        
        $this->addError('email', __('auth.failed'));
    }
}
```

### 2. Vista Widget Minima

```blade
{{-- Vista minima funzionante --}}
<x-filament-widgets::widget>
    <form wire:submit="login">
        {{ $this->form }}
        <x-filament::button type="submit">Login</x-filament::button>
    </form>
</x-filament-widgets::widget>
```

### 3. Traduzioni

```php
// lang/it/login.php
return [
    'title' => 'Accedi ai servizi',
    'subtitle' => 'Utilizza le tue credenziali per accedere',
    'email_placeholder' => 'nome@esempio.it',
    'password_placeholder' => 'Inserisci la password',
    'remember_me' => 'Ricordami',
    'forgot_password' => 'Password dimenticata?',
    'submit' => 'Accedi',
    'no_account' => 'Non hai un account?',
    'create_account' => 'Registrati ora',
    'or_login_with' => 'Oppure accedi con',
];
```

## ✅ Checklist Implementazione

- [ ] Widget estende `XotBaseWidget`
- [ ] Vista configurata con `pub_theme::`
- [ ] `getFormSchema()` definisce i campi
- [ ] Vista widget include `{{ $this->form }}`
- [ ] Form ha `wire:submit="login"`
- [ ] Incluso `{{ $this->notifications() }}`
- [ ] Button submit presente
- [ ] Traduzioni complete
- [ ] Styling Bootstrap Italia applicato
- [ ] Test funzionale eseguito

## 🐛 Troubleshooting

### Form non appare

**Problema**: Il widget si rende ma non vedo i campi

**Soluzione**: Aggiungi `{{ $this->form }}` nella vista widget

### Errore "Call to undefined method"

**Problema**: `Method [form] not found`

**Soluzione**: Assicurati che il widget estenda `XotBaseWidget` che implementa `InteractsWithForms`

### Submit non funziona

**Problema**: Click su submit non fa nulla

**Soluzione**: 
1. Verifica `wire:submit="login"` nel form
2. Controlla che il metodo `login()` esista nel widget
3. Verifica CSRF token presente (automatico in Livewire)

### Styling non applicato

**Problema**: Il form appare senza stile

**Soluzione**: Filament 4 usa Tailwind CSS. Verifica che il tema abbia:
```html
<link rel="stylesheet" href="{{ asset('css/filament/app.css') }}">
```

## 📚 Riferimenti

- [Filament 4 Widgets Documentation](https://filamentphp.com/docs/4.x/widgets)
- [Filament Forms Documentation](https://filamentphp.com/docs/4.x/forms)
- [Bootstrap Italia Design System](https://italia.github.io/bootstrap-italia/)
- [Design Comuni Guidelines](https://designers.italia.it/modello/comuni/)

---

**Creato**: 14 Ottobre 2025  
**Autore**: Super Mucca Documentation Team  
**Status**: ✅ Validato e Testato  
**Versione**: 1.0.0





---

## widget_translation_rules

*Consolidated from: `widget_translation_rules.md`*


## Core Principles

### Translation File Structure
- All widget translations MUST be in `Modules/{ModuleName}/lang/{locale}/widgets.php`
- Use expanded structure with `label`, `placeholder`, `help` for all fields
- Never use hardcoded strings in widgets or views

### Widget Implementation Rules
- NEVER use `->label()`, `->placeholder()`, or `->help()` in form components
- NEVER use `__()` or `trans()` functions directly in form components
- Let LangServiceProvider handle automatic translation loading
- Use translation keys for select options and dynamic content

### View Path Convention
- Widget views MUST use path: `modulename::filament.widgets.widget-name`
- NEVER use `modulename::widgets.widget-name` (missing filament prefix)
- Views located in `resources/views/filament/widgets/`

## Translation Structure Pattern

### Required Structure
```php
return [
    'widget_name' => [
        'title' => 'Widget Title',
        'description' => 'Widget Description',
        'sections' => [
            'section_name' => [
                'title' => 'Section Title',
                'description' => 'Section Description',
            ],
        ],
        'fields' => [
            'field_name' => [
                'label' => 'Field Label',
                'placeholder' => 'Field Placeholder',
                'help' => 'Field Help Text',
                'options' => [
                    'option_key' => 'Option Label',
                ],
            ],
        ],
        'actions' => [
            'action_name' => [
                'label' => 'Action Label',
                'tooltip' => 'Action Tooltip',
            ],
        ],
        'messages' => [
            'success' => 'Success Message',
            'error' => 'Error Message',
        ],
        'validation' => [
            'rule_name' => 'Validation Message',
        ],
    ],
];
```

## Widget Class Rules

### Base Class Extension
- ALWAYS extend `XotBaseWidget` from `Modules\Xot\Filament\Widgets`
- NEVER extend Filament widgets directly
- Use `HasForms` interface with `InteractsWithForms` trait

### Form Schema Rules
- `getFormSchema()` MUST return associative array with string keys
- Field names automatically map to translation keys
- Use sections for logical grouping

### Example Correct Implementation
```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class EditUserWidget extends XotBaseWidget
{
    protected static string $view = 'user::filament.widgets.edit-user';

    public function getFormSchema(): array
    {
        return [
            'personal_info' => Section::make()->schema([
                TextInput::make('first_name')->required(),
                TextInput::make('last_name')->required(),
                TextInput::make('email')->required()->email(),
            ]),
        ];
    }
}
```

## View Implementation Rules

### Blade View Structure
- Use translation keys for all text content
- Follow responsive design patterns
- Use Tailwind CSS for styling consistency

### Example Correct View
```blade
<div class="p-6">
    <h2 class="text-xl font-semibold mb-4">
        {{ __('user::widgets.edit_user.title') }}
    </h2>
    
    <p class="text-gray-600 mb-6">
        {{ __('user::widgets.edit_user.description') }}
    </p>
    
    {{ $this->form }}
    
    <div class="mt-6 flex justify-end space-x-3">
        <button type="button" class="btn-secondary">
            {{ __('user::widgets.edit_user.actions.cancel.label') }}
        </button>
        <button type="submit" class="btn-primary">
            {{ __('user::widgets.edit_user.actions.save.label') }}
        </button>
    </div>
</div>
```

## Anti-Patterns to Avoid

### ❌ WRONG - Direct Labels
```php
TextInput::make('name')->label('Name')->placeholder('Enter name')
```

### ❌ WRONG - Translation Functions in Components
```php
TextInput::make('name')->label(__('user::fields.name'))
```

### ❌ WRONG - Incorrect View Path
```php
protected static string $view = 'user::widgets.edit-user';
```

### ❌ WRONG - Hardcoded Strings in Views
```blade
<h2>Edit User Profile</h2>
```

## Documentation Requirements

### Module Documentation
- Document all widgets in module's `docs/widgets/` folder
- Include translation guidelines and examples
- Link to related documentation

### Translation Documentation
- Document all translation keys and their purpose
- Provide examples for complex structures
- Maintain consistency across languages

## Quality Assurance

### Checklist for Widget Development
- [ ] Extends XotBaseWidget
- [ ] Uses correct view path with filament prefix
- [ ] No direct labels or hardcoded strings
- [ ] Translation files follow expanded structure
- [ ] Documentation updated in module docs
- [ ] All supported languages have translations

### Testing Requirements
- Test widget functionality across all supported languages
- Verify translation key resolution
- Check responsive design and accessibility
- Validate form submission and error handling

## Related Documentation

- [User Module Widget Structure](../Modules/User/docs/widgets_structure.md)
- [EditUserWidget Documentation](../Modules/User/docs/widgets/edit-user-widget.md)
- [Widget Translation Guidelines](../Modules/User/docs/widgets/translation-guidelines.md)
- [Filament Widget Conventions](../Modules/Xot/docs/filament-widgets.md)
- [Filament Widget Conventions](../../best-practices/filament-widgets.md)

## Memory Integration

This document serves as a reference for:
- Widget development standards
- Translation implementation patterns
- Code quality requirements
- Documentation standards

All widget development should follow these rules to maintain consistency and quality across the SaluteOra project.

---

## widgets-structure

*Consolidated from: `widgets-structure.md`*

module: theme
topic: widgets-structure
canonical: ../../../Themes/docs/shared-components/widgets-structure.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/widgets-structure.md

---

## widgets_structure

*Consolidated from: `widgets_structure.md`*


## Overview

Documentazione per widgets_structure nel modulo User.

## Dettagli

[Da completare]

## Collegamenti

- [Modulo Principale](../README.md)


---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04
