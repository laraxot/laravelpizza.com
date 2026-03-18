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




