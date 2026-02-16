# Implementazione dei Form con Widget Filament

## Collegamenti correlati
- [README modulo User](./README.md)
- [Convenzioni Path](./PATH_CONVENTIONS.md)
- [Best Practices Volt e Folio](../../Xot/docs/VOLT_FOLIO_BEST_PRACTICES.md)
- [Analisi dell'Errore di Implementazione](./VOLT_BLADE_IMPLEMENTATION_ERROR.md)

## Introduzione

Questo documento descrive l'implementazione corretta dei form nel tema One utilizzando widget Filament invece di form personalizzati. Questo approccio garantisce coerenza, riutilizzabilità e adattabilità a diverse grafiche, evitando di "reinventare la ruota".

## Approccio Raccomandato: Widget Filament

Per i form complessi , l'approccio raccomandato è utilizzare i widget Filament invece di implementare form personalizzati con Volt o Blade. Questo approccio offre numerosi vantaggi:

1. **Riutilizzabilità**: I widget possono essere utilizzati in diverse parti dell'applicazione
2. **Adattabilità**: Si adattano facilmente a diverse grafiche
3. **Manutenibilità**: Sfruttano le funzionalità di Filament per la validazione e la gestione degli errori
4. **Coerenza**: Mantengono uno stile coerente con il resto dell'applicazione
5. **Accessibilità**: I componenti Filament sono progettati per essere accessibili

## Struttura delle Directory

```
/var/www/html/saluteora/laravel/
├── Modules/
│   └── User/
│       └── app/
│           └── Filament/
│               └── Widgets/
│                   ├── LoginFormWidget.php
│                   ├── RegisterFormWidget.php
│                   └── PasswordResetFormWidget.php
└── Themes/
    └── One/
        └── resources/
            └── views/
                ├── pages/
                │   └── auth/
                │       ├── login.blade.php
                │       ├── register.blade.php
                │       └── password/
                │           ├── reset.blade.php
                │           └── email.blade.php
                └── livewire/
                    └── widgets/
                        ├── login-form-widget.blade.php
                        ├── register-form-widget.blade.php
                        └── password-reset-form-widget.blade.php
```

## Template Blade per i Widget

### 1. Template per il Widget di Login (login-form-widget.blade.php)

```blade
<div>
    <form wire:submit="login">
        {{ $this->form }}
        
        <div class="mt-4">
            <x-filament::button type="submit" class="w-full">
                {{ __('auth.login.submit_button') }}
            </x-filament::button>
        </div>
        
        @if ($errors->any())
            <div class="mt-4 p-4 bg-red-50 text-red-700 rounded-lg">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>
</div>
```

### 2. Template per il Widget di Registrazione (register-form-widget.blade.php)

```blade
<div>
    <form wire:submit="register">
        {{ $this->form }}
        
        <div class="mt-4">
            <x-filament::button type="submit" class="w-full">
                {{ __('auth.register.submit_button') }}
            </x-filament::button>
        </div>
        
        @if ($errors->any())
            <div class="mt-4 p-4 bg-red-50 text-red-700 rounded-lg">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>
</div>
```

## Vantaggi dell'Utilizzo di Widget Filament

1. **Riutilizzabilità**: I widget possono essere utilizzati in diverse parti dell'applicazione e in diversi temi.

2. **Adattabilità**: Si adattano facilmente a diverse grafiche e layout senza dover modificare la logica.

3. **Manutenibilità**: Il codice è organizzato in modo strutturato, con una chiara separazione tra logica e presentazione.

4. **Coerenza UI/UX**: Utilizzo dei componenti nativi Filament garantisce coerenza visiva con il resto dell'applicazione.

5. **Accessibilità**: I componenti Filament sono progettati per essere accessibili secondo gli standard WCAG.

6. **Validazione integrata**: Gestione semplificata della validazione e degli errori.

7. **Localizzazione**: Supporto completo per la localizzazione degli URL e dei contenuti.

## Implementazione dei Widget Filament

### 1. Widget di Login

```php
<?php

namespace Modules\User\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class LoginFormWidget extends XotBaseWidget
{
    use InteractsWithForms;

    protected static string $view = 'user::livewire.widgets.login-form-widget';
    
    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill();
    }
    
    public function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return $form
            ->schema([
                'email' => TextInput::make('email')
                    ->email()
                    ->required(),
                'password' => TextInput::make('password')
                    ->password()
                    ->required(),
                'remember' => Checkbox::make('remember'),
            ])
            ->statePath('data');
    }
    
    public function login(): void
    {
        $data = $this->form->getState();
        
        if (Auth::attempt([
            'email' => $data['email'], 
            'password' => $data['password']
        ], $data['remember'] ?? false)) {
            session()->regenerate();
            
            $locale = app()->getLocale();
            redirect('/' . $locale . '/dashboard');
        }
        
        $this->addError('email', __('auth.failed'));
    }
}
```

### 2. Widget di Registrazione

```php
<?php

namespace Modules\User\Filament\Widgets;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\User\Models\User;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class RegisterFormWidget extends XotBaseWidget
{
    use InteractsWithForms;

    protected static string $view = 'user::livewire.widgets.register-form-widget';
    
    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill();
    }
    
    public function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return $form
            ->schema([
                'first_name' => TextInput::make('first_name')
                    ->required(),
                'last_name' => TextInput::make('last_name')
                    ->required(),
                'email' => TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(User::class),
                'password' => TextInput::make('password')
                    ->password()
                    ->required()
                    ->minLength(8)
                    ->confirmed(),
                'password_confirmation' => TextInput::make('password_confirmation')
                    ->password()
                    ->required(),
            ])
            ->statePath('data');
    }
    
    public function register(): void
    {
        $data = $this->form->getState();
        
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        
        Auth::login($user);
        
        $locale = app()->getLocale();
        redirect('/' . $locale . '/dashboard');
    }
}
```

## Conclusione

L'utilizzo di widget Filament per l'implementazione dei form  offre un approccio coerente, manutenibile e riutilizzabile. Questo approccio evita di "reinventare la ruota" e garantisce che tutti i form seguano le stesse convenzioni e standard di qualità.

## Collegamenti Utili

- [Documentazione Filament](https://filamentphp.com/docs)
- [Documentazione Widgets Filament](https://filamentphp.com/docs/3.x/widgets/installation)
- [Documentazione Forms Filament](https://filamentphp.com/docs/3.x/forms/installation)
- [Documentazione Laravel Livewire](https://laravel-livewire.com/docs)
- [Documentazione Laravel Folio](https://laravel.com/docs/10.x/folio)
1. **Widget vs Form**:
   - Utilizzare widget per componenti riutilizzabili
   - Evitare form personalizzati
   - Sfruttare i componenti Filament

2. **Routing**:
   - Utilizzare le rotte di Filament
   - Evitare rotte personalizzate
   - Mantenere coerenza URL

3. **Layout**:
   - Utilizzare i layout Filament
   - Mantenere coerenza UI
   - Seguire le linee guida di design

## Collegamenti Correlati
- [Documentazione Filament Widgets](https://filamentphp.com/docs/3.x/panels/widgets)
- [Best Practices di Sicurezza](./SECURITY_BEST_PRACTICES.md)
- [Gestione Sessione](./SESSION_MANAGEMENT.md)
- [Tema One Documentation](../../Themes/One/docs/README.md) 
