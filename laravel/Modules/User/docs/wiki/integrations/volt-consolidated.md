---
title: "volt: Consolidated Documentation"
module: user
type: integration
tags: [integrations, modules, user]
created: 2026-08-24
updated: 2026-08-24
status: draft
qmd: "volt   consolidated documentation user"
---

# volt: Consolidated Documentation

Consolidated from **27** individual files.

## Table of Contents

- [---](#volt-blade-implementation-3)
- [---](#volt-blade-implementation-error-3)
- [---](#volt-blade-implementation-error)
- [---](#volt-blade-implementation)
- [---](#volt-errors)
- [---](#volt-folio-error)
- [---](#volt-folio-logout-debug)
- [---](#volt-folio-logout-error-3)
- [---](#volt-folio-logout-error)
- [---](#volt-folio-logout)
- [---](#volt-folio-logoutebug)
- [---](#volt-folio)
- [---](#volt-logout-action)
- [---](#volt-logout)
- [---](#volt-missing-directive)
- [---](#volt-missingirective)
- [Implementazione dei Form con Widget Filament](#volt_blade_implementation)
- [Analisi dell'Errore di Implementazione Volt/Blade](#volt_blade_implementation_error)
- [Errori Comuni in Volt e Soluzioni](#volt_errors)
- [Errore VoltDirectiveMissingException in Folio](#volt_folio_error)
- [Implementazione Corretta del Logout con Volt e Folio](#volt_folio_logout)
- [Debug: Perché logout.blade.php non funziona (Volt + Folio)](#volt_folio_logout_debug)
- [Errore nel Logout con Volt e Folio](#volt_folio_logout_error)
- [Implementazione del Logout con Volt](#volt_logout)
- [Logout via Volt Action](#volt_logout_action)
- [Errore VoltDirectiveMissingException](#volt_missing_directive)
- [---](#volts)

---

## volt-blade-implementation-3

*Consolidated from: `volt-blade-implementation.md`*
*Consolidated from: `volt-blade-implementation-introduzione.md`*

title: "Volt Blade Implementation 3"
type: concept
tags: [volt, blade, implementation]
created: 2026-07-14
updated: 2026-07-14
qmd: "volt-blade-implementation-3 volt blade implementation 3"
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

- [README modulo User](./readme.md)
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

- [README modulo User](./readme.md)
- [Convenzioni Path](./path-conventions.md)
- [Best Practices Volt e Folio](../../Xot/docs/VOLT_FOLIO_BEST_PRACTICES.md)
- [Analisi dell'Errore di Implementazione](./volt-blade-implementation-error.md)

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
- [Gestione Sessione](./session-management.md)
- [Tema One Documentation](../../Themes/One/docs/README.md) 
---
module: theme
topic: volt_blade_implementation
canonical: ../../../Themes/docs/shared-components/volt-blade-implementation.md
---

See canonical documentation: ../../../Themes/docs/shared-components/volt-blade-implementation.md
canonical: ../../../Themes/docs/shared-components/volt-blade-implementation-introduzione.md
---

See canonical documentation: ../../../Themes/docs/shared-components/volt-blade-implementation-introduzione.md
---

## volt-blade-implementation-error-3

*Consolidated from: `volt-blade-implementation-error.md`*
*Consolidated from: `volt-blade-implementation-error-identificazione-dell.md`*

title: "Volt Blade Implementation Error 3"
type: concept
tags: [volt, blade, implementation, error]
created: 2026-07-14
updated: 2026-07-14
qmd: "volt-blade-implementation-error-3 volt blade implementation error 3"
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

- [README modulo User](./readme.md)
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

- [README modulo User](./readme.md)
- [Convenzioni Path](./path-conventions.md)
- [Best Practices Volt e Folio](../../Xot/docs/VOLT_FOLIO_BEST_PRACTICES.md)

## Identificazione dell'Errore

Durante l'analisi del file `/var/www/html/saluteora/laravel/Themes/One/resources/views/pages/auth/logout.blade.php`, è stato commesso un errore fondamentale di interpretazione. Il file è stato erroneamente analizzato come se utilizzasse la direttiva `@volt`, mentre in realtà utilizza correttamente la sintassi PHP standard con `<?php` all'inizio del file.

### File Attuale (Corretto)

```php
<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;

if (!Auth::check()) {
    return redirect()->route('login');
}

try {
    Event::dispatch('auth.logout.attempting', [Auth::user()]);

    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

    Event::dispatch('auth.logout.successful');

    Log::info('Utente disconnesso', [
        'user_id' => Auth::id(),
        'timestamp' => now()
    ]);

    return redirect()->route('home')
        ->with('success', __('Logout effettuato con successo'));
} catch (\Exception $e) {
    Log::error('Errore durante il logout: ' . $e->getMessage());
    return back()->with('error', __('Errore durante il logout'));
}
?>

<x-layout>
    <!-- Template Blade qui -->
</x-layout>
```

### Interpretazione Errata

L'errore di analisi ha portato a raccomandazioni non corrette:

1. Si è erroneamente indicato che il file iniziava con `@volt('auth.logout')` invece di `<?php`
2. Si è suggerito di riorganizzare la struttura quando in realtà era già corretta
3. Si è proposto di utilizzare Volt quando il file utilizza già correttamente PHP puro con Folio

## Correzione dell'Analisi

Il file attuale utilizza già l'approccio corretto di Folio con PHP puro, che è l'approccio raccomandato per operazioni semplici come il logout. Tuttavia, ci sono alcuni miglioramenti che possono essere apportati:

1. **Localizzazione degli URL**: Utilizzare `app()->getLocale()` per generare URL localizzati invece di `route('home')`
2. **Componenti UI**: Utilizzare i componenti Blade nativi di Filament invece di HTML diretto
3. **Direttive Folio**: Aggiungere le direttive `middleware` e `name` di Folio per definire il middleware e il nome della rotta

## Lezione Appresa

Questo errore evidenzia l'importanza di:

1. **Analisi Accurata**: Esaminare attentamente il codice esistente prima di proporre modifiche
2. **Comprensione dei Framework**: Distinguere chiaramente tra i diversi approcci (PHP puro, Volt, Blade)
3. **Verifica delle Assunzioni**: Non assumere che un file utilizzi un determinato approccio senza verificarlo

## Approccio Corretto per l'Implementazione

Per implementare correttamente le pagine di autenticazione , è necessario scegliere l'approccio più adatto in base alla complessità dell'operazione:

1. **Folio con PHP puro**: Per operazioni semplici come il logout (già correttamente implementato)
2. **Widget Filament**: Per form complessi che devono essere adattabili a diverse grafiche
3. **Volt Action dedicata**: Per operazioni che richiedono validazione o logica complessa

## Raccomandazione per i Form

Come correttamente indicato, per i form è preferibile utilizzare un widget Filament invece di reinventare la ruota. Questo approccio offre numerosi vantaggi:

1. **Riutilizzabilità**: Il widget può essere utilizzato in diverse parti dell'applicazione
2. **Adattabilità**: Si adatta facilmente a diverse grafiche
3. **Manutenibilità**: Sfrutta le funzionalità di Filament per la validazione e la gestione degli errori
4. **Coerenza**: Mantiene uno stile coerente con il resto dell'applicazione

Questo approccio sarà documentato in dettaglio nel file `VOLT_BLADE_IMPLEMENTATION.md`.
---
module: theme
topic: volt_blade_implementation_error
canonical: ../../../Themes/docs/shared-components/volt-blade-implementation-error.md
---

See canonical documentation: ../../../Themes/docs/shared-components/volt-blade-implementation-error.md
canonical: ../../../Themes/docs/shared-components/volt-blade-implementation-error-identificazione-dell.md
---

See canonical documentation: ../../../Themes/docs/shared-components/volt-blade-implementation-error-identificazione-dell.md
---

## volt-blade-implementation-error

*Consolidated from: `volt-blade-implementation-error.md`*

module: theme
topic: volt-blade-implementation-error
canonical: ../../../Themes/docs/shared-components/volt-blade-implementation-error.md
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

See canonical documentation: ../../../Themes/docs/shared-components/volt-blade-implementation-error.md

---

## volt-blade-implementation

*Consolidated from: `volt-blade-implementation.md`*

title: "Implementazione dei Form con Widget Filament"
type: concept
tags: [volt, blade, implementation]
created: 2026-07-14
updated: 2026-07-14
qmd: "volt-blade-implementation implementazione dei form con widget filament"
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

# Implementazione dei Form con Widget Filament

## Collegamenti correlati
- [README modulo User](./readme.md)
- [Convenzioni Path](./path-conventions.md)
- [Best Practices Volt e Folio](../../xot/docs/volt_folio_best_practices.md)
- [Analisi dell'Errore di Implementazione](./volt-blade-implementation-error.md)
- [Convenzioni Path](../../path-conventions-user.md)
- [Best Practices Volt e Folio](../../xot/docs/volt_folio_best_practices.md)
- [Analisi dell'Errore di Implementazione](../../volt-blade-implementation-error-identificazione-dell.md)

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
- [Best Practices di Sicurezza](./security_best_practices.md)
- [Gestione Sessione](./session-management.md)
- [Gestione Sessione](../../session-management-gestione-sessioni.md)
- [Tema One Documentation](../../themes/one/docs/readme.md)
# Implementazione dei Form con Widget Filament

## Collegamenti correlati
- [README modulo User](./readme.md)
- [Convenzioni Path](./path-conventions.md)
- [Best Practices Volt e Folio](../../xot/docs/volt_folio_best_practices.md)
- [Analisi dell'Errore di Implementazione](./volt-blade-implementation-error.md)
- [Convenzioni Path](../../path-conventions-user.md)
- [Best Practices Volt e Folio](../../xot/docs/volt_folio_best_practices.md)
- [Analisi dell'Errore di Implementazione](../../volt-blade-implementation-error-identificazione-dell.md)

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
- [Best Practices di Sicurezza](./security_best_practices.md)
- [Gestione Sessione](./session-management.md)
- [Gestione Sessione](../../session-management-gestione-sessioni.md)
- [Tema One Documentation](../../themes/one/docs/readme.md)

---

## volt-errors

*Consolidated from: `volt-errors.md`*

title: "Errori Comuni in Volt e Soluzioni"
type: concept
tags: [volt, errors]
created: 2026-07-14
updated: 2026-07-14
qmd: "volt-errors errori comuni in volt e soluzioni"
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

# Errori Comuni in Volt e Soluzioni

## VoltDirectiveMissingException

### Descrizione dell'Errore
```
Livewire\Volt\Exceptions\VoltDirectiveMissingException
The [@volt] directive is required when using Volt anonymous components in Folio pages.
```

### Causa
Questo errore si verifica quando si tenta di utilizzare un componente Volt in una pagina Folio senza la direttiva `@volt`. La direttiva `@volt` è obbligatoria per definire un componente Volt anonimo.

### Soluzione
Per risolvere questo errore, è necessario:

1. Aggiungere la direttiva `@volt` all'inizio del file Blade
2. Definire la classe del componente Volt
3. Implementare la logica necessaria

Esempio di implementazione corretta:

```php
@volt
class LogoutPage
{
    public function logout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        
        return redirect()->route('home');
    }
}
@endvolt

<x-layouts.app>
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ __('Logout effettuato con successo') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Verrai reindirizzato alla home page tra pochi secondi...') }}
                </p>
            </div>
            
            <div class="mt-6">
                <a href="{{ route('home') }}" 
                   class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Torna alla Home') }}
                </a>
            </div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            window.location.href = "{{ route('home') }}";
        }, 3000);
    </script>
</x-layouts.app>

## Errore di Sintassi Volt

### Descrizione dell'Errore
L'errore si verifica quando la sintassi del componente Volt non è corretta. In particolare, quando si usa la sintassi PHP all'interno della direttiva `@volt` senza la corretta struttura.

### Causa
La sintassi attuale:
```php
@volt
<?php
use function Livewire\Volt\{state, mount};
// ...
?>
```
non è corretta perché:
1. Non definisce una classe
2. Usa la sintassi PHP diretta invece della sintassi Volt
3. Non segue il pattern corretto per i componenti Volt

### Soluzione Corretta
```php
@volt
class LogoutPage
{
    public $processing = false;

    public function mount()
    {
        $this->logout();
    }

    public function logout()
    {
        $this->processing = true;

        try {
            auth()->logout();
            session()->invalidate();
            session()->regenerateToken();
            
            return redirect()->route('home');
        } catch (\Exception $e) {
            $this->processing = false;
            session()->flash('error', __('Errore durante il logout. Riprova.'));
        }
    }
}
@endvolt

<x-layouts.app>
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ __('Logout effettuato con successo') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Verrai reindirizzato alla home page tra pochi secondi...') }}
                </p>
            </div>
            
            <div class="mt-6">
                <a href="{{ route('home') }}" 
                   class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Torna alla Home') }}
                </a>
            </div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            window.location.href = "{{ route('home') }}";
        }, 3000);
    </script>
</x-layouts.app>

### Differenze Chiave
1. **Definizione della Classe**: 
   - ❌ Non usare `<?php` direttamente
   - ✅ Definire una classe con nome descrittivo

2. **Gestione dello Stato**:
   - ❌ Non usare `state()` direttamente
   - ✅ Definire proprietà pubbliche nella classe

3. **Metodi**:
   - ❌ Non usare funzioni anonime
   - ✅ Definire metodi nella classe

4. **Mount**:
   - ❌ Non usare `mount()` come funzione
   - ✅ Implementare il metodo `mount()` nella classe

### Best Practices
1. **Struttura del Componente**:
   - Iniziare sempre con `@volt`
   - Definire una classe con nome descrittivo
   - Implementare i metodi necessari nella classe

2. **Gestione dello Stato**:
   - Usare proprietà pubbliche per lo stato
   - Inizializzare lo stato nel costruttore o in `mount()`

3. **Gestione degli Errori**:
   - Implementare try/catch nei metodi
   - Fornire feedback appropriato all'utente

4. **Reindirizzamenti**:
   - Gestire i reindirizzamenti nei metodi
   - Fornire feedback durante il processo

### Vantaggi della Soluzione
- **Sicurezza**: Gestione corretta della sessione
- **UX**: Feedback visivo e reindirizzamento automatico
- **Manutenibilità**: Codice organizzato e ben strutturato
- **Coerenza**: Allineamento con le best practices di Volt

### Link Correlati
- [Documentazione Volt](https://livewire.laravel.com/docs/volt)
- [Best Practices Filament](../filament_best_practices.md)
- [Routing Best Practices](../../routing_best_practices.md) 
- [Routing Best Practices](../../routing-best-practices.md) 
- [Routing Best Practices](../../routing_best_practices.md) 
- [Routing Best Practices](../../routing-best-practices-architettura-volt-folio-filament.md) 
---

## volt-folio-error

*Consolidated from: `volt-folio-error.md`*

title: "Errore VoltDirectiveMissingException in Folio"
type: concept
tags: [volt, folio, error]
created: 2026-07-14
updated: 2026-07-14
qmd: "volt-folio-error errore voltdirectivemissingexception in folio"
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

# Errore VoltDirectiveMissingException in Folio

## Il Problema
L'errore si verifica quando si cerca di utilizzare un componente Volt in una pagina Folio senza la direttiva `@volt`. L'errore specifico è:

```
Livewire\Volt\Exceptions\VoltDirectiveMissingException
The [@volt] directive is required when using Volt anonymous components in Folio pages.
```

## Perché Succede
1. Folio e Volt hanno approcci diversi per la gestione dei componenti
2. Folio utilizza un sistema di routing basato sui file
3. Volt richiede una dichiarazione esplicita per i componenti anonimi

## Soluzioni Possibili

### 1. Utilizzare la Direttiva @volt
```blade
@volt
<div>
    <!-- Contenuto del componente -->
</div>
@endvolt
```

### 2. Utilizzare un Form Standard (Soluzione Consigliata)
```blade
<form action="{{ route('logout') }}" method="post">
    @csrf
    <button type="submit">Logout</button>
</form>
```

### 3. Creare un Componente Volt Dedicato
```php
// resources/views/components/logout-form.blade.php
@volt('logout-form')
<div>
    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit">Logout</button>
    </form>
</div>
@endvolt
```

## Best Practices
1. Per pagine semplici come il logout, preferire form standard
2. Utilizzare Volt solo quando necessario (interattività complessa)
3. Mantenere la separazione tra Folio e Volt
4. Documentare chiaramente l'approccio scelto

## Collegamenti
- [Documentazione Volt](https://livewire.laravel.com/docs/volt)
- [Documentazione Folio](https://laravel.com/docs/folio)
- [Best Practices Routing](./routing-best-practices.md) 
- [Best Practices Routing](./routing-best-practices.md) 
- [Best Practices Routing](../../routing-best-practices-architettura-volt-folio-filament.md) 
---

## volt-folio-logout-debug

*Consolidated from: `volt-folio-logout-debug.md`*

module: theme
topic: volt-folio-logout-debug
canonical: ../../../Themes/docs/shared-components/volt-folio-logout-debug.md
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

See canonical documentation: ../../../Themes/docs/shared-components/volt-folio-logout-debug.md

---

## volt-folio-logout-error-3

*Consolidated from: `volt-folio-logout-error.md`*
*Consolidated from: `volt-folio-logout-error-best-practices.md`*

title: "Volt Folio Logout Error 3"
type: concept
tags: [volt, folio, logout, error]
created: 2026-07-14
updated: 2026-07-14
qmd: "volt-folio-logout-error-3 volt folio logout error 3"
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

- [Best Practices Folio](./routing-best-practices.md)
- [Best Practices Volt](./VOLT_BEST_PRACTICES.md)
- [Gestione Sessione](./session-management.md) 
---
module: theme
topic: volt_folio_logout_error
canonical: ../../../Themes/docs/shared-components/volt-folio-logout-error.md
---

See canonical documentation: ../../../Themes/docs/shared-components/volt-folio-logout-error.md
canonical: ../../../Themes/docs/shared-components/volt-folio-logout-error-best-practices.md
---

See canonical documentation: ../../../Themes/docs/shared-components/volt-folio-logout-error-best-practices.md
---

## volt-folio-logout-error

*Consolidated from: `volt-folio-logout-error.md`*

module: theme
topic: volt-folio-logout-error
canonical: ../../../Themes/docs/shared-components/volt-folio-logout-error.md
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

See canonical documentation: ../../../Themes/docs/shared-components/volt-folio-logout-error.md

---

## volt-folio-logout

*Consolidated from: `volt-folio-logout.md`*

title: "Implementazione Corretta del Logout con Volt e Folio"
type: concept
tags: [volt, folio, logout]
created: 2026-07-14
updated: 2026-07-14
qmd: "volt-folio-logout implementazione corretta del logout con volt e folio"
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

# Implementazione Corretta del Logout con Volt e Folio

## Collegamenti correlati
- [README modulo User](./readme.md)
- [Convenzioni Path](./path-conventions.md)
- [Analisi Logout Blade](./logout-blade-analysis.md)
- [Convenzioni Path](../../path-conventions-user.md)
- [Analisi Logout Blade](../../logout-blade-analysis-panoramica.md)
- [Best Practices Volt e Folio](../../xot/docs/volt_folio_best_practices.md)

## Panoramica
Questo documento descrive l'implementazione corretta del logout utilizzando Laravel Folio e Volt, seguendo le convenzioni di <nome progetto>.

## Percorso Corretto
Il file di logout deve essere posizionato in:
```
Themes/One/resources/views/pages/auth/logout.blade.php
```

## Approcci Raccomandati

In base all'analisi dettagliata del file logout.blade.php e alle convenzioni del progetto <nome progetto>, si raccomandano i seguenti approcci per l'implementazione del logout.

### 1. Approccio Folio con PHP puro (Raccomandato)

Questo approccio è raccomandato per il logout in quanto è un'operazione semplice che non richiede gestione dello stato o interazione complessa con l'utente.

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\{middleware, name};

middleware(['auth']);
name('logout');

// Esegui il logout
if (Auth::check()) {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
}

// Reindirizza l'utente alla home page localizzata
$locale = app()->getLocale();
return redirect()->to('/' . $locale);
?>
```

### 2. Volt Action dedicata

Questo approccio utilizza una Volt Action dedicata con attributi PHP 8 per definire la rotta `logout`:

```php
<?php
declare(strict_types=1);

namespace Modules\User\Http\Volt;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Volt\Routing\Attribute\Post;

#[Post('/logout', name: 'logout', middleware: ['web', 'auth'])]
final class LogoutAction
{
    public function __invoke(): RedirectResponse
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        // Reindirizza alla home page localizzata
        $locale = app()->getLocale();
        return redirect()->to('/' . $locale);
    }
}
```

Quindi nel form:

```blade
<form action="{{ route('logout') }}" method="post">
    @csrf
    <x-filament::button type="submit" color="danger">
        {{ __('Logout') }}
    </x-filament::button>
</form>
```

### 3. Folio con Volt

Questo approccio utilizza Volt all'interno di una pagina Folio per gestire il logout:

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{mount};

middleware(['auth']);
name('logout');

mount(function() {
    if(Auth::check()) {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
    }

    // Reindirizza alla home page localizzata
    $this->redirect('/' . app()->getLocale());
});
?>

<x-layouts.main>
    @volt('auth.logout')
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow-lg">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    {{ __('Logout in corso...') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Verrai reindirizzato alla home page.') }}
                </p>
            </div>
        </div>
    </div>
    @endvolt
</x-layouts.main>
```

## Punti Importanti

1. **Localizzazione degli URL**: Tutti gli URL devono includere il prefisso della lingua come primo segmento del percorso:
   ```
   /{locale}/{sezione}/{risorsa}
   ```

2. **Recuperare la Locale Corrente**: Usare sempre `app()->getLocale()` per ottenere la lingua corrente:
   ```php
   $locale = app()->getLocale();
   ```

3. **Generare Link Localizzati**: Quando si generano link, includere sempre la locale:
   ```php
   // CORRETTO
   <a href="{{ url('/' . app()->getLocale()) }}">{{ __('Home') }}</a>

   // ERRATO
   <a href="{{ route('home') }}">{{ __('Home') }}</a>
   ```

4. **Sicurezza**: Assicurarsi di invalidare e rigenerare la sessione per prevenire attacchi di session fixation.

## Problemi Comuni

1. **Mancata Localizzazione**: Non includere il prefisso della lingua negli URL.
2. **Utilizzo di route() senza Locale**: Utilizzare `route('home')` senza considerare la localizzazione.
3. **Mancata Rigenerazione Token**: Non rigenerare il token CSRF dopo il logout.

## Implementazione con Componenti Filament

Per seguire le best practices di <nome progetto>, utilizzare sempre i componenti Blade nativi di Filament:

```php
<x-filament::button tag="a" href="{{ url('/' . $locale) }}" color="primary" class="w-full">
    {{ __('Torna alla Home') }}
</x-filament::button>
```

invece di:

```php
<a href="{{ url('/' . $locale) }}" class="btn btn-primary w-full">
    {{ __('Torna alla Home') }}
</a>
```

## Conclusione

Seguire l'approccio Folio con Volt è raccomandato per la gestione del logout . Assicurarsi di includere sempre la localizzazione negli URL e di utilizzare i componenti Filament per la UI.
# Implementazione Corretta del Logout con Volt e Folio

## Collegamenti correlati
- [README modulo User](./readme.md)
- [Convenzioni Path](./path-conventions.md)
- [Analisi Logout Blade](./logout-blade-analysis.md)
- [Convenzioni Path](../../path-conventions-user.md)
- [Analisi Logout Blade](../../logout-blade-analysis-panoramica.md)
- [Best Practices Volt e Folio](../../xot/docs/volt_folio_best_practices.md)

## Panoramica
Questo documento descrive l'implementazione corretta del logout utilizzando Laravel Folio e Volt, seguendo le convenzioni di <nome progetto>.

## Percorso Corretto
Il file di logout deve essere posizionato in:
```
Themes/One/resources/views/pages/auth/logout.blade.php
```

## Approcci Raccomandati

In base all'analisi dettagliata del file logout.blade.php e alle convenzioni del progetto <nome progetto>, si raccomandano i seguenti approcci per l'implementazione del logout.

### 1. Approccio Folio con PHP puro (Raccomandato)

Questo approccio è raccomandato per il logout in quanto è un'operazione semplice che non richiede gestione dello stato o interazione complessa con l'utente.

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\{middleware, name};

middleware(['auth']);
name('logout');

// Esegui il logout
if (Auth::check()) {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
}

// Reindirizza l'utente alla home page localizzata
$locale = app()->getLocale();
return redirect()->to('/' . $locale);
?>
```

### 2. Volt Action dedicata

Questo approccio utilizza una Volt Action dedicata con attributi PHP 8 per definire la rotta `logout`:

```php
<?php
declare(strict_types=1);

namespace Modules\User\Http\Volt;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Volt\Routing\Attribute\Post;

#[Post('/logout', name: 'logout', middleware: ['web', 'auth'])]
final class LogoutAction
{
    public function __invoke(): RedirectResponse
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        // Reindirizza alla home page localizzata
        $locale = app()->getLocale();
        return redirect()->to('/' . $locale);
    }
}
```

Quindi nel form:

```blade
<form action="{{ route('logout') }}" method="post">
    @csrf
    <x-filament::button type="submit" color="danger">
        {{ __('Logout') }}
    </x-filament::button>
</form>
```

### 3. Folio con Volt

Questo approccio utilizza Volt all'interno di una pagina Folio per gestire il logout:

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{mount};

middleware(['auth']);
name('logout');

mount(function() {
    if(Auth::check()) {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
    }

    // Reindirizza alla home page localizzata
    $this->redirect('/' . app()->getLocale());
});
?>

<x-layouts.main>
    @volt('auth.logout')
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow-lg">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    {{ __('Logout in corso...') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Verrai reindirizzato alla home page.') }}
                </p>
            </div>
        </div>
    </div>
    @endvolt
</x-layouts.main>
```

## Punti Importanti

1. **Localizzazione degli URL**: Tutti gli URL devono includere il prefisso della lingua come primo segmento del percorso:
   ```
   /{locale}/{sezione}/{risorsa}
   ```

2. **Recuperare la Locale Corrente**: Usare sempre `app()->getLocale()` per ottenere la lingua corrente:
   ```php
   $locale = app()->getLocale();
   ```

3. **Generare Link Localizzati**: Quando si generano link, includere sempre la locale:
   ```php
   // CORRETTO
   <a href="{{ url('/' . app()->getLocale()) }}">{{ __('Home') }}</a>

   // ERRATO
   <a href="{{ route('home') }}">{{ __('Home') }}</a>
   ```

4. **Sicurezza**: Assicurarsi di invalidare e rigenerare la sessione per prevenire attacchi di session fixation.

## Problemi Comuni

1. **Mancata Localizzazione**: Non includere il prefisso della lingua negli URL.
2. **Utilizzo di route() senza Locale**: Utilizzare `route('home')` senza considerare la localizzazione.
3. **Mancata Rigenerazione Token**: Non rigenerare il token CSRF dopo il logout.

## Implementazione con Componenti Filament

Per seguire le best practices di <nome progetto>, utilizzare sempre i componenti Blade nativi di Filament:

```php
<x-filament::button tag="a" href="{{ url('/' . $locale) }}" color="primary" class="w-full">
    {{ __('Torna alla Home') }}
</x-filament::button>
```

invece di:

```php
<a href="{{ url('/' . $locale) }}" class="btn btn-primary w-full">
    {{ __('Torna alla Home') }}
</a>
```

## Conclusione

Seguire l'approccio Folio con Volt è raccomandato per la gestione del logout . Assicurarsi di includere sempre la localizzazione negli URL e di utilizzare i componenti Filament per la UI.

---

## volt-folio-logoutebug

*Consolidated from: `volt-folio-logoutebug.md`*

title: "Debug: Perché logout.blade.php non funziona (Volt + Folio)"
type: concept
tags: [volt, folio, logoutebug]
created: 2026-07-14
updated: 2026-07-14
qmd: "volt-folio-logoutebug debug: perché logout.blade.php non funziona (volt + folio)"
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

# Debug: Perché logout.blade.php non funziona (Volt + Folio)

## Analisi del problema

La pagina `/themes/TwentyOne/resources/views/pages/auth/logout.blade.php` non funziona come logout reale. Ecco i motivi principali:

### 1. **La logica di logout NON viene eseguita automaticamente**
- **Volt** esegue la logica solo tramite azioni (wire:click, wire:submit, ecc.) o lifecycle hooks (`mount`, ecc.), **ma solo se la pagina è una vera Volt Page** (cioè se è dichiarata come componente Volt, non solo come Blade con direttiva @volt e PHP inline).
- Se accedi direttamente alla pagina `/auth/logout`, il codice PHP dentro il file Blade **NON viene eseguito come azione Livewire/Volt**, ma solo renderizzato come Blade.
- Quindi il logout NON avviene: la pagina mostra solo il messaggio, ma l’utente è ancora autenticato!

### 2. **Il redirect e la sessione non vengono gestiti da Livewire/Volt**
- Il codice `$logout = function () { ... }` non viene invocato automaticamente.
- Serve una vera azione Livewire/Volt collegata a un evento (es. `wire:click`, `wire:init`, `mount`, ecc.).

## Come risolvere

### Soluzione 1: Pagina Logout con azione automatica (Volt Page vera)

1. **Crea una vera Volt Page** in `/app/Http/Livewire/Auth/Logout.php`:
```php
<?php
namespace App\Http\Livewire\Auth;

use Livewire\Volt\Component;

class Logout extends Component
{
    public function mount()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('home');
    }
    public function render()
    {
        return view('livewire.auth.logout');
    }
}
```
2. **Crea la view associata**: `resources/views/livewire/auth/logout.blade.php`
```blade
<x-layouts.app>
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow">
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Logout effettuato con successo') }}</h2>
            <a href="{{ route('home') }}" class="mt-6 block text-blue-500 underline">{{ __('Torna alla Home') }}</a>
        </div>
    </div>
</x-layouts.app>
```
3. **Registra la route Volt/Folio** per `/auth/logout` che punti a questo componente.
   - Se usi Folio, crea un file che richiama il componente Livewire:
   ```blade
   {{-- resources/views/pages/auth/logout.blade.php --}}
   @livewire('auth.logout')
   ```

### Soluzione 2: Logout via azione esplicita (pulsante)

Se vuoi mostrare una conferma, usa un pulsante con `wire:click="logout"` che richiama la funzione.

## Best practice
- **Non scrivere logica di logout direttamente in Blade**: usa sempre un componente Volt/Livewire.
- **Documenta la soluzione**: aggiorna la documentazione interna.

---

**In sintesi:**
- Il logout non funziona perché il codice PHP non viene eseguito come azione Volt.
- Serve una vera Volt Page o un componente Livewire che esegua il logout su mount o su evento.
- Aggiorna la pagina Blade per richiamare il componente Livewire/Volt.
# Debug: Perché logout.blade.php non funziona (Volt + Folio)

## Analisi del problema

La pagina `/themes/TwentyOne/resources/views/pages/auth/logout.blade.php` non funziona come logout reale. Ecco i motivi principali:

### 1. **La logica di logout NON viene eseguita automaticamente**
- **Volt** esegue la logica solo tramite azioni (wire:click, wire:submit, ecc.) o lifecycle hooks (`mount`, ecc.), **ma solo se la pagina è una vera Volt Page** (cioè se è dichiarata come componente Volt, non solo come Blade con direttiva @volt e PHP inline).
- Se accedi direttamente alla pagina `/auth/logout`, il codice PHP dentro il file Blade **NON viene eseguito come azione Livewire/Volt**, ma solo renderizzato come Blade.
- Quindi il logout NON avviene: la pagina mostra solo il messaggio, ma l’utente è ancora autenticato!

### 2. **Il redirect e la sessione non vengono gestiti da Livewire/Volt**
- Il codice `$logout = function () { ... }` non viene invocato automaticamente.
- Serve una vera azione Livewire/Volt collegata a un evento (es. `wire:click`, `wire:init`, `mount`, ecc.).

## Come risolvere

### Soluzione 1: Pagina Logout con azione automatica (Volt Page vera)

1. **Crea una vera Volt Page** in `/app/Http/Livewire/Auth/Logout.php`:
```php
<?php
namespace App\Http\Livewire\Auth;

use Livewire\Volt\Component;

class Logout extends Component
{
    public function mount()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('home');
    }
    public function render()
    {
        return view('livewire.auth.logout');
    }
}
```
2. **Crea la view associata**: `resources/views/livewire/auth/logout.blade.php`
```blade
<x-layouts.app>
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow">
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Logout effettuato con successo') }}</h2>
            <a href="{{ route('home') }}" class="mt-6 block text-blue-500 underline">{{ __('Torna alla Home') }}</a>
        </div>
    </div>
</x-layouts.app>
```
3. **Registra la route Volt/Folio** per `/auth/logout` che punti a questo componente.
   - Se usi Folio, crea un file che richiama il componente Livewire:
   ```blade
   {{-- resources/views/pages/auth/logout.blade.php --}}
   @livewire('auth.logout')
   ```

### Soluzione 2: Logout via azione esplicita (pulsante)

Se vuoi mostrare una conferma, usa un pulsante con `wire:click="logout"` che richiama la funzione.

## Best practice
- **Non scrivere logica di logout direttamente in Blade**: usa sempre un componente Volt/Livewire.
- **Documenta la soluzione**: aggiorna la documentazione interna.

---

**In sintesi:**
- Il logout non funziona perché il codice PHP non viene eseguito come azione Volt.
- Serve una vera Volt Page o un componente Livewire che esegua il logout su mount o su evento.
- Aggiorna la pagina Blade per richiamare il componente Livewire/Volt.

---

## volt-folio

*Consolidated from: `volt-folio.md`*

title: "Errore VoltDirectiveMissingException in Folio"
type: concept
tags: [volt, folio]
created: 2026-07-14
updated: 2026-07-14
qmd: "volt-folio errore voltdirectivemissingexception in folio"
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

# Errore VoltDirectiveMissingException in Folio

## Il Problema
L'errore si verifica quando si cerca di utilizzare un componente Volt in una pagina Folio senza la direttiva `@volt`. L'errore specifico è:

```
Livewire\Volt\Exceptions\VoltDirectiveMissingException
The [@volt] directive is required when using Volt anonymous components in Folio pages.
```

## Perché Succede
1. Folio e Volt hanno approcci diversi per la gestione dei componenti
2. Folio utilizza un sistema di routing basato sui file
3. Volt richiede una dichiarazione esplicita per i componenti anonimi

## Soluzioni Possibili

### 1. Utilizzare la Direttiva @volt
```blade
@volt
<div>
    <!-- Contenuto del componente -->
</div>
@endvolt
```

### 2. Utilizzare un Form Standard (Soluzione Consigliata)
```blade
<form action="{{ route('logout') }}" method="post">
    @csrf
    <button type="submit">Logout</button>
</form>
```

### 3. Creare un Componente Volt Dedicato
```php
// resources/views/components/logout-form.blade.php
@volt('logout-form')
<div>
    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit">Logout</button>
    </form>
</div>
@endvolt
```

## Best Practices
1. Per pagine semplici come il logout, preferire form standard
2. Utilizzare Volt solo quando necessario (interattività complessa)
3. Mantenere la separazione tra Folio e Volt
4. Documentare chiaramente l'approccio scelto

## Collegamenti
- [Documentazione Volt](https://livewire.laravel.com/docs/volt)
- [Documentazione Folio](https://laravel.com/docs/folio)
- [Best Practices Routing](./routing-best-practices.md) 
- [Best Practices Routing](../../routing-best-practices-architettura-volt-folio-filament.md) 

---

## volt-logout-action

*Consolidated from: `volt-logout-action.md`*

module: theme
topic: volt-logout-action
canonical: ../../../Themes/docs/shared-components/volt-logout-action.md
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

See canonical documentation: ../../../Themes/docs/shared-components/volt-logout-action.md

---

## volt-logout

*Consolidated from: `volt-logout.md`*

module: theme
topic: volt-logout
canonical: ../../../Themes/docs/shared-components/volt-logout.md
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

See canonical documentation: ../../../Themes/docs/shared-components/volt-logout.md

---

## volt-missing-directive

*Consolidated from: `volt-missing-directive.md`*

module: theme
topic: volt-missing-directive
canonical: ../../../Themes/docs/shared-components/volt-missing-directive.md
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

See canonical documentation: ../../../Themes/docs/shared-components/volt-missing-directive.md

---

## volt-missingirective

*Consolidated from: `volt-missingirective.md`*

title: "Errore VoltDirectiveMissingException"
type: concept
tags: [volt, missingirective]
created: 2026-07-14
updated: 2026-07-14
qmd: "volt-missingirective errore voltdirectivemissingexception"
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

# Errore VoltDirectiveMissingException

## Descrizione
In una pagina Folio con componenti Volt anonimi, è obbligatorio includere la direttiva `@volt` all'inizio del file Blade. L'assenza di questo directive genera:

```
Livewire\Volt\Exceptions\VoltDirectiveMissingException
The [@volt] directive is required when using Volt anonymous components in Folio pages.
```

## Dove correggere
File: `Themes/TwentyOne/resources/views/pages/auth/logout.blade.php`

## Soluzione
Aggiungere la direttiva `@volt` in testa al file, prima di qualsiasi codice Blade o HTML:

```blade
@volt
@php
    // ... logout logic
@endphp
<x-layout>
    <!-- contenuto pagina logout -->
</x-layout>
```

## Pulizia cache
Dopo la modifica, rigenerare la cache delle viste:

```bash
php artisan view:clear && php artisan route:clear
```

---

## volt_blade_implementation

*Consolidated from: `volt_blade_implementation.md`*


## Collegamenti correlati
- [README modulo User](./readme.md)
- [README modulo User](./readme.md)
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

---

## volt_blade_implementation_error

*Consolidated from: `volt_blade_implementation_error.md`*


## Collegamenti correlati
- [README modulo User](./readme.md)
- [README modulo User](./readme.md)
- [Convenzioni Path](./PATH_CONVENTIONS.md)
- [Best Practices Volt e Folio](../../Xot/docs/VOLT_FOLIO_BEST_PRACTICES.md)

## Identificazione dell'Errore

Durante l'analisi del file `/var/www/html/saluteora/laravel/Themes/One/resources/views/pages/auth/logout.blade.php`, è stato commesso un errore fondamentale di interpretazione. Il file è stato erroneamente analizzato come se utilizzasse la direttiva `@volt`, mentre in realtà utilizza correttamente la sintassi PHP standard con `<?php` all'inizio del file.

### File Attuale (Corretto)

```php
<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;

if (!Auth::check()) {
    return redirect()->route('login');
}

try {
    Event::dispatch('auth.logout.attempting', [Auth::user()]);

    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

    Event::dispatch('auth.logout.successful');

    Log::info('Utente disconnesso', [
        'user_id' => Auth::id(),
        'timestamp' => now()
    ]);

    return redirect()->route('home')
        ->with('success', __('Logout effettuato con successo'));
} catch (\Exception $e) {
    Log::error('Errore durante il logout: ' . $e->getMessage());
    return back()->with('error', __('Errore durante il logout'));
}
?>

<x-layout>
    <!-- Template Blade qui -->
</x-layout>
```

### Interpretazione Errata

L'errore di analisi ha portato a raccomandazioni non corrette:

1. Si è erroneamente indicato che il file iniziava con `@volt('auth.logout')` invece di `<?php`
2. Si è suggerito di riorganizzare la struttura quando in realtà era già corretta
3. Si è proposto di utilizzare Volt quando il file utilizza già correttamente PHP puro con Folio

## Correzione dell'Analisi

Il file attuale utilizza già l'approccio corretto di Folio con PHP puro, che è l'approccio raccomandato per operazioni semplici come il logout. Tuttavia, ci sono alcuni miglioramenti che possono essere apportati:

1. **Localizzazione degli URL**: Utilizzare `app()->getLocale()` per generare URL localizzati invece di `route('home')`
2. **Componenti UI**: Utilizzare i componenti Blade nativi di Filament invece di HTML diretto
3. **Direttive Folio**: Aggiungere le direttive `middleware` e `name` di Folio per definire il middleware e il nome della rotta

## Lezione Appresa

Questo errore evidenzia l'importanza di:

1. **Analisi Accurata**: Esaminare attentamente il codice esistente prima di proporre modifiche
2. **Comprensione dei Framework**: Distinguere chiaramente tra i diversi approcci (PHP puro, Volt, Blade)
3. **Verifica delle Assunzioni**: Non assumere che un file utilizzi un determinato approccio senza verificarlo

## Approccio Corretto per l'Implementazione

Per implementare correttamente le pagine di autenticazione , è necessario scegliere l'approccio più adatto in base alla complessità dell'operazione:

1. **Folio con PHP puro**: Per operazioni semplici come il logout (già correttamente implementato)
2. **Widget Filament**: Per form complessi che devono essere adattabili a diverse grafiche
3. **Volt Action dedicata**: Per operazioni che richiedono validazione o logica complessa

## Raccomandazione per i Form

Come correttamente indicato, per i form è preferibile utilizzare un widget Filament invece di reinventare la ruota. Questo approccio offre numerosi vantaggi:

1. **Riutilizzabilità**: Il widget può essere utilizzato in diverse parti dell'applicazione
2. **Adattabilità**: Si adatta facilmente a diverse grafiche
3. **Manutenibilità**: Sfrutta le funzionalità di Filament per la validazione e la gestione degli errori
4. **Coerenza**: Mantiene uno stile coerente con il resto dell'applicazione

Questo approccio sarà documentato in dettaglio nel file `VOLT_BLADE_IMPLEMENTATION.md`.

---

## volt_errors

*Consolidated from: `volt_errors.md`*


## VoltDirectiveMissingException

### Descrizione dell'Errore
```
Livewire\Volt\Exceptions\VoltDirectiveMissingException
The [@volt] directive is required when using Volt anonymous components in Folio pages.
```

### Causa
Questo errore si verifica quando si tenta di utilizzare un componente Volt in una pagina Folio senza la direttiva `@volt`. La direttiva `@volt` è obbligatoria per definire un componente Volt anonimo.

### Soluzione
Per risolvere questo errore, è necessario:

1. Aggiungere la direttiva `@volt` all'inizio del file Blade
2. Definire la classe del componente Volt
3. Implementare la logica necessaria

Esempio di implementazione corretta:

```php
@volt
class LogoutPage
{
    public function logout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        
        return redirect()->route('home');
    }
}
@endvolt

<x-layouts.app>
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ __('Logout effettuato con successo') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Verrai reindirizzato alla home page tra pochi secondi...') }}
                </p>
            </div>
            
            <div class="mt-6">
                <a href="{{ route('home') }}" 
                   class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Torna alla Home') }}
                </a>
            </div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            window.location.href = "{{ route('home') }}";
        }, 3000);
    </script>
</x-layouts.app>

## Errore di Sintassi Volt

### Descrizione dell'Errore
L'errore si verifica quando la sintassi del componente Volt non è corretta. In particolare, quando si usa la sintassi PHP all'interno della direttiva `@volt` senza la corretta struttura.

### Causa
La sintassi attuale:
```php
@volt
<?php
use function Livewire\Volt\{state, mount};
// ...
?>
```
non è corretta perché:
1. Non definisce una classe
2. Usa la sintassi PHP diretta invece della sintassi Volt
3. Non segue il pattern corretto per i componenti Volt

### Soluzione Corretta
```php
@volt
class LogoutPage
{
    public $processing = false;

    public function mount()
    {
        $this->logout();
    }

    public function logout()
    {
        $this->processing = true;

        try {
            auth()->logout();
            session()->invalidate();
            session()->regenerateToken();
            
            return redirect()->route('home');
        } catch (\Exception $e) {
            $this->processing = false;
            session()->flash('error', __('Errore durante il logout. Riprova.'));
        }
    }
}
@endvolt

<x-layouts.app>
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ __('Logout effettuato con successo') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Verrai reindirizzato alla home page tra pochi secondi...') }}
                </p>
            </div>
            
            <div class="mt-6">
                <a href="{{ route('home') }}" 
                   class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Torna alla Home') }}
                </a>
            </div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            window.location.href = "{{ route('home') }}";
        }, 3000);
    </script>
</x-layouts.app>

### Differenze Chiave
1. **Definizione della Classe**: 
   - ❌ Non usare `<?php` direttamente
   - ✅ Definire una classe con nome descrittivo

2. **Gestione dello Stato**:
   - ❌ Non usare `state()` direttamente
   - ✅ Definire proprietà pubbliche nella classe

3. **Metodi**:
   - ❌ Non usare funzioni anonime
   - ✅ Definire metodi nella classe

4. **Mount**:
   - ❌ Non usare `mount()` come funzione
   - ✅ Implementare il metodo `mount()` nella classe

### Best Practices
1. **Struttura del Componente**:
   - Iniziare sempre con `@volt`
   - Definire una classe con nome descrittivo
   - Implementare i metodi necessari nella classe

2. **Gestione dello Stato**:
   - Usare proprietà pubbliche per lo stato
   - Inizializzare lo stato nel costruttore o in `mount()`

3. **Gestione degli Errori**:
   - Implementare try/catch nei metodi
   - Fornire feedback appropriato all'utente

4. **Reindirizzamenti**:
   - Gestire i reindirizzamenti nei metodi
   - Fornire feedback durante il processo

### Vantaggi della Soluzione
- **Sicurezza**: Gestione corretta della sessione
- **UX**: Feedback visivo e reindirizzamento automatico
- **Manutenibilità**: Codice organizzato e ben strutturato
- **Coerenza**: Allineamento con le best practices di Volt

### Link Correlati
- [Documentazione Volt](https://livewire.laravel.com/docs/volt)
- [Best Practices Filament](../filament_best_practices.md)
- [Routing Best Practices](../../routing_best_practices.md) 
- [Routing Best Practices](../../routing_best_practices.md) 

---

## volt_folio_error

*Consolidated from: `volt_folio_error.md`*


## Il Problema
L'errore si verifica quando si cerca di utilizzare un componente Volt in una pagina Folio senza la direttiva `@volt`. L'errore specifico è:

```
Livewire\Volt\Exceptions\VoltDirectiveMissingException
The [@volt] directive is required when using Volt anonymous components in Folio pages.
```

## Perché Succede
1. Folio e Volt hanno approcci diversi per la gestione dei componenti
2. Folio utilizza un sistema di routing basato sui file
3. Volt richiede una dichiarazione esplicita per i componenti anonimi

## Soluzioni Possibili

### 1. Utilizzare la Direttiva @volt
```blade
@volt
<div>
    <!-- Contenuto del componente -->
</div>
@endvolt
```

### 2. Utilizzare un Form Standard (Soluzione Consigliata)
```blade
<form action="{{ route('logout') }}" method="post">
    @csrf
    <button type="submit">Logout</button>
</form>
```

### 3. Creare un Componente Volt Dedicato
```php
// resources/views/components/logout-form.blade.php
@volt('logout-form')
<div>
    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit">Logout</button>
    </form>
</div>
@endvolt
```

## Best Practices
1. Per pagine semplici come il logout, preferire form standard
2. Utilizzare Volt solo quando necessario (interattività complessa)
3. Mantenere la separazione tra Folio e Volt
4. Documentare chiaramente l'approccio scelto

## Collegamenti
- [Documentazione Volt](https://livewire.laravel.com/docs/volt)
- [Documentazione Folio](https://laravel.com/docs/folio)
- [Best Practices Routing](./ROUTING_BEST_PRACTICES.md) 

---

## volt_folio_logout

*Consolidated from: `volt_folio_logout.md`*


## Collegamenti correlati
- [README modulo User](./readme.md)
- [README modulo User](./readme.md)
- [Convenzioni Path](./PATH_CONVENTIONS.md)
- [Analisi Logout Blade](./LOGOUT_BLADE_ANALYSIS.md)
- [Best Practices Volt e Folio](../../Xot/docs/VOLT_FOLIO_BEST_PRACTICES.md)

## Panoramica
Questo documento descrive l'implementazione corretta del logout utilizzando Laravel Folio e Volt, seguendo le convenzioni di SaluteOra.

## Percorso Corretto
Il file di logout deve essere posizionato in:
```
Themes/One/resources/views/pages/auth/logout.blade.php
```

## Approcci Raccomandati

In base all'analisi dettagliata del file logout.blade.php e alle convenzioni del progetto SaluteOra, si raccomandano i seguenti approcci per l'implementazione del logout.

### 1. Approccio Folio con PHP puro (Raccomandato)

Questo approccio è raccomandato per il logout in quanto è un'operazione semplice che non richiede gestione dello stato o interazione complessa con l'utente.

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\{middleware, name};

middleware(['auth']);
name('logout');

// Esegui il logout
if (Auth::check()) {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
}

// Reindirizza l'utente alla home page localizzata
$locale = app()->getLocale();
return redirect()->to('/' . $locale);
?>
```

### 2. Volt Action dedicata

Questo approccio utilizza una Volt Action dedicata con attributi PHP 8 per definire la rotta `logout`:

```php
<?php
declare(strict_types=1);

namespace Modules\User\Http\Volt;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Volt\Routing\Attribute\Post;

#[Post('/logout', name: 'logout', middleware: ['web', 'auth'])]
final class LogoutAction
{
    public function __invoke(): RedirectResponse
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        // Reindirizza alla home page localizzata
        $locale = app()->getLocale();
        return redirect()->to('/' . $locale);
    }
}
```

Quindi nel form:

```blade
<form action="{{ route('logout') }}" method="post">
    @csrf
    <x-filament::button type="submit" color="danger">
        {{ __('Logout') }}
    </x-filament::button>
</form>
```

### 3. Folio con Volt

Questo approccio utilizza Volt all'interno di una pagina Folio per gestire il logout:

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{mount};

middleware(['auth']);
name('logout');

mount(function() {
    if(Auth::check()) {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
    }
    
    // Reindirizza alla home page localizzata
    $this->redirect('/' . app()->getLocale());
});
?>

<x-layouts.main>
    @volt('auth.logout')
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow-lg">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    {{ __('Logout in corso...') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Verrai reindirizzato alla home page.') }}
                </p>
            </div>
        </div>
    </div>
    @endvolt
</x-layouts.main>
```

## Punti Importanti

1. **Localizzazione degli URL**: Tutti gli URL devono includere il prefisso della lingua come primo segmento del percorso:
   ```
   /{locale}/{sezione}/{risorsa}
   ```

2. **Recuperare la Locale Corrente**: Usare sempre `app()->getLocale()` per ottenere la lingua corrente:
   ```php
   $locale = app()->getLocale();
   ```

3. **Generare Link Localizzati**: Quando si generano link, includere sempre la locale:
   ```php
   // CORRETTO
   <a href="{{ url('/' . app()->getLocale()) }}">{{ __('Home') }}</a>

   // ERRATO
   <a href="{{ route('home') }}">{{ __('Home') }}</a>
   ```

4. **Sicurezza**: Assicurarsi di invalidare e rigenerare la sessione per prevenire attacchi di session fixation.

## Problemi Comuni

1. **Mancata Localizzazione**: Non includere il prefisso della lingua negli URL.
2. **Utilizzo di route() senza Locale**: Utilizzare `route('home')` senza considerare la localizzazione.
3. **Mancata Rigenerazione Token**: Non rigenerare il token CSRF dopo il logout.

## Implementazione con Componenti Filament

Per seguire le best practices di SaluteOra, utilizzare sempre i componenti Blade nativi di Filament:

```php
<x-filament::button tag="a" href="{{ url('/' . $locale) }}" color="primary" class="w-full">
    {{ __('Torna alla Home') }}
</x-filament::button>
```

invece di:

```php
<a href="{{ url('/' . $locale) }}" class="btn btn-primary w-full">
    {{ __('Torna alla Home') }}
</a>
```

## Conclusione

Seguire l'approccio Folio con Volt è raccomandato per la gestione del logout . Assicurarsi di includere sempre la localizzazione negli URL e di utilizzare i componenti Filament per la UI.

---

## volt_folio_logout_debug

*Consolidated from: `volt_folio_logout_debug.md`*


## Analisi del problema

La pagina `/themes/TwentyOne/resources/views/pages/auth/logout.blade.php` non funziona come logout reale. Ecco i motivi principali:

### 1. **La logica di logout NON viene eseguita automaticamente**
- **Volt** esegue la logica solo tramite azioni (wire:click, wire:submit, ecc.) o lifecycle hooks (`mount`, ecc.), **ma solo se la pagina è una vera Volt Page** (cioè se è dichiarata come componente Volt, non solo come Blade con direttiva @volt e PHP inline).
- Se accedi direttamente alla pagina `/auth/logout`, il codice PHP dentro il file Blade **NON viene eseguito come azione Livewire/Volt**, ma solo renderizzato come Blade.
- Quindi il logout NON avviene: la pagina mostra solo il messaggio, ma l’utente è ancora autenticato!

### 2. **Il redirect e la sessione non vengono gestiti da Livewire/Volt**
- Il codice `$logout = function () { ... }` non viene invocato automaticamente.
- Serve una vera azione Livewire/Volt collegata a un evento (es. `wire:click`, `wire:init`, `mount`, ecc.).

## Come risolvere

### Soluzione 1: Pagina Logout con azione automatica (Volt Page vera)

1. **Crea una vera Volt Page** in `/app/Http/Livewire/Auth/Logout.php`:
```php
<?php
namespace App\Http\Livewire\Auth;

use Livewire\Volt\Component;

class Logout extends Component
{
    public function mount()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('home');
    }
    public function render()
    {
        return view('livewire.auth.logout');
    }
}
```
2. **Crea la view associata**: `resources/views/livewire/auth/logout.blade.php`
```blade
<x-layouts.app>
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow">
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Logout effettuato con successo') }}</h2>
            <a href="{{ route('home') }}" class="mt-6 block text-blue-500 underline">{{ __('Torna alla Home') }}</a>
        </div>
    </div>
</x-layouts.app>
```
3. **Registra la route Volt/Folio** per `/auth/logout` che punti a questo componente.
   - Se usi Folio, crea un file che richiama il componente Livewire:
   ```blade
   {{-- resources/views/pages/auth/logout.blade.php --}}
   @livewire('auth.logout')
   ```

### Soluzione 2: Logout via azione esplicita (pulsante)

Se vuoi mostrare una conferma, usa un pulsante con `wire:click="logout"` che richiama la funzione.

## Best practice
- **Non scrivere logica di logout direttamente in Blade**: usa sempre un componente Volt/Livewire.
- **Documenta la soluzione**: aggiorna la documentazione interna.

---

**In sintesi:**
- Il logout non funziona perché il codice PHP non viene eseguito come azione Volt.
- Serve una vera Volt Page o un componente Livewire che esegua il logout su mount o su evento.
- Aggiorna la pagina Blade per richiamare il componente Livewire/Volt.

---

## volt_folio_logout_error

*Consolidated from: `volt_folio_logout_error.md`*


## Il Problema
Il file `logout.blade.php` non funziona correttamente perché:

1. **Layout Errato**: 
   - Si usa `<x-layouts.app>` invece di `<x-layout>`
   - Il layout corretto è definito nel tema TwentyOne

2. **Direttiva Volt Non Necessaria**:
   - La pagina è una pagina Folio, non un componente Volt
   - Il logout può essere gestito con un form standard

3. **Gestione Sessione Non Ottimale**:
   - Il reindirizzamento JavaScript non è la soluzione migliore
   - Meglio gestire il reindirizzamento lato server

## Soluzione Corretta

### 1. Pagina di Logout (logout.blade.php)
```blade
<x-layout>
    <x-slot:title>
        {{ __('Logout') }}
    </x-slot>

    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow-lg">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    {{ __('Sei sicuro di voler uscire?') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Potrai sempre accedere nuovamente con le tue credenziali.') }}
                </p>
            </div>

            <div class="mt-8 space-y-6">
                <div class="flex items-center justify-between space-x-4">
                    <a href="{{ route('home') }}" 
                       class="flex-1 inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Annulla') }}
                    </a>

                    <form action="{{ route('logout') }}" method="post" class="flex-1">
                        @csrf
                        <button type="submit"
                                class="w-full inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            {{ __('Logout') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>
```

### 2. LogoutAction.php
```php
<?php

declare(strict_types=1);

namespace Modules\User\Http\Volt;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Volt\Routing\Attribute\Post;

#[Post('/logout', name: 'logout', middleware: ['web', 'auth'])]
final class LogoutAction
{
    public function __invoke(): RedirectResponse
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('home');
    }
}
```

## Perché Questa Soluzione Funziona

1. **Separazione delle Responsabilità**:
   - Folio gestisce il routing e la visualizzazione
   - Volt gestisce l'azione di logout
   - Il form standard gestisce l'invio della richiesta

2. **Sicurezza**:
   - CSRF token incluso
   - Sessione gestita correttamente
   - Middleware auth applicato

3. **UX Migliorata**:
   - Conferma prima del logout
   - Possibilità di annullare
   - Feedback visivo chiaro

## Best Practices

1. **Layout**:
   - Usare sempre il layout corretto del tema
   - Non mischiare diversi sistemi di layout

2. **Routing**:
   - Lasciare che Folio gestisca il routing delle pagine
   - Usare Volt solo per le azioni

3. **Sessione**:
   - Gestire il reindirizzamento lato server
   - Evitare JavaScript per operazioni critiche

## Collegamenti
- [Best Practices Folio](./ROUTING_BEST_PRACTICES.md)
- [Best Practices Volt](./VOLT_BEST_PRACTICES.md)
- [Gestione Sessione](./SESSION_MANAGEMENT.md) 

---

## volt_logout

*Consolidated from: `volt_logout.md`*


## Il Problema

L'errore `Route [logout] not defined` si verifica perché stiamo cercando di utilizzare una rotta tradizionale in un'architettura Volt + Folio + Filament. Invece di definire la rotta in `web.php`, implementeremo il logout usando Volt.

## La Soluzione

### 1. Creare il Componente Volt per il Logout

```php
// resources/js/pages/Logout.vue
<script setup>
import { useForm } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'

const form = useForm({})

const logout = () => {
    form.post('/logout', {
        onSuccess: () => {
            router.visit('/')
        }
    })
}
</script>

<template>
    <button 
        @click="logout" 
        class="flex items-center w-full p-2 space-x-2 text-red-500 rounded hover:text-red-600 hover:bg-white"
    >
        <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1012.728 0l-1.09-1.09a6 6 0 11-8.484 0l-1.09 1.09z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 12v2.5m0 0V16m0-3.5h2.5m-2.5 0H9" />
        </svg>
        <span>{{ __('Logout') }}</span>
    </button>
</template>
```

### 2. Modificare il Template del Menu

```php
// Themes/TwentyOne/resources/views/layouts/headernav/about.blade.php
@auth
    <li>
        <x-volt.logout />
    </li>
@endauth
```

### 3. Registrare il Componente Volt

```php
// resources/js/app.js
import { createApp } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'

createInertiaApp({
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el)
    },
})
```

### 4. Configurare il Controller di Autenticazione

```php
// Modules/User/app/Http/Controllers/Auth/LogoutController.php
namespace Modules\User\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home');
    }
}
```

### 5. Registrare la Rotta nel Service Provider

```php
// Modules/User/app/Providers/UserServiceProvider.php
use Modules\User\Http\Controllers\Auth\LogoutController;

public function boot()
{
    $this->app['router']->post('/logout', LogoutController::class)
        ->name('logout')
        ->middleware('web');
}
```

## Vantaggi di questa Implementazione

1. **Coerenza con l'Architettura**
   - Segue il pattern Volt + Folio + Filament
   - Non richiede rotte in `web.php`
   - Mantiene la separazione delle responsabilità

2. **Sicurezza**
   - Gestisce correttamente la sessione
   - Rigenera il token CSRF
   - Implementa il logout in modo sicuro

3. **UX Migliorata**
   - Feedback visivo immediato
   - Reindirizzamento automatico
   - Gestione degli errori

4. **Manutenibilità**
   - Codice organizzato e modulare
   - Facile da testare
   - Facile da estendere

## Best Practices

### 1. Gestione degli Stati
```php
const form = useForm({})

const logout = () => {
    form.post('/logout', {
        onStart: () => {
            // Mostra loader
        },
        onSuccess: () => {
            // Reindirizza
            router.visit('/')
        },
        onError: (errors) => {
            // Gestisci errori
            console.error(errors)
        },
        onFinish: () => {
            // Nascondi loader
        }
    })
}
```

### 2. Styling Consistente
```vue
<template>
    <button 
        @click="logout" 
        class="flex items-center w-full p-2 space-x-2 text-red-500 rounded hover:text-red-600 hover:bg-white"
        :disabled="form.processing"
    >
        <svg class="size-6" ... />
        <span>{{ __('Logout') }}</span>
        <span v-if="form.processing" class="ml-2">
            <svg class="animate-spin size-4" ... />
        </span>
    </button>
</template>
```

### 3. Gestione delle Traduzioni
```php
// lang/it/user.php
return [
    'logout' => 'Logout',
    'logging_out' => 'Disconnessione in corso...',
    'logout_success' => 'Disconnesso con successo',
];
```

## Test

### 1. Test del Componente
```php
// tests/Feature/LogoutTest.php
public function test_user_can_logout()
{
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)
        ->post('/logout');
        
    $response->assertRedirect('/');
    $this->assertGuest();
}
```

### 2. Test del Controller
```php
// tests/Unit/LogoutControllerTest.php
public function test_logout_clears_session()
{
    $user = User::factory()->create();
    $this->actingAs($user);
    
    $this->post('/logout');
    
    $this->assertGuest();
    $this->assertSessionMissing('auth');
}
```

## Collegamenti

- [Documentazione Volt](https://livewire.laravel.com/docs/volt)
- [Best Practices Filament](./FILAMENT_BEST_PRACTICES.md)
- [Routing Best Practices](./ROUTING_BEST_PRACTICES.md) 

---

## volt_logout_action

*Consolidated from: `volt_logout_action.md`*


## Contesto
Durante il logout in frontoffice, il form chiama:
```blade
<form action="{{ route('logout') }}" method="post"> @csrf
    <button>Logout</button>
</form>
```
e genera l’errore:
```
Route [logout] not defined.
```
In Volt + Folio + Filament **non** si usano rotte in `routes/web.php` per il frontoffice.

## Soluzione: Volt Action dedicata
Creiamo una Volt Action che definisce la rotta `logout` con attributo PHP8.

### 1. Creazione della Volt Action
File: `Modules/User/app/Http/Volt/LogoutAction.php`
```php
<?php

declare(strict_types=1);

namespace Modules\User\Http\Volt;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Volt\Routing\Attribute\Post;

#[Post('/logout', name: 'logout', middleware: ['web', 'auth'])]
final class LogoutAction
{
    public function __invoke(): RedirectResponse
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        // Reindirizza alla rotta "home" del frontoffice
        return redirect()->route('home');
    }
}
```

### 2. Utilizzo nel Blade
Non serve cambiare il form:
```blade
<form action="{{ route('logout') }}" method="post">
    @csrf
    <button>Logout</button>
</form>
```
Volt scoprirà automaticamente la rotta `logout` grazie all’Attribute.

## Verifica
1. Svuota cache delle rotte: `php artisan route:clear && php artisan route:cache`
2. Accedi al frontoffice e clicca "Logout": non otterrai più l’Internal Server Error.

## Note
- Il middleware `web` gestisce session e CSRF.
- Il middleware `auth` impedisce accessi non autenticati.
- Non toccare `routes/web.php` per il frontoffice.

---

## volt_missing_directive

*Consolidated from: `volt_missing_directive.md`*


## Descrizione
In una pagina Folio con componenti Volt anonimi, è obbligatorio includere la direttiva `@volt` all'inizio del file Blade. L'assenza di questo directive genera:

```
Livewire\Volt\Exceptions\VoltDirectiveMissingException
The [@volt] directive is required when using Volt anonymous components in Folio pages.
```

## Dove correggere
File: `Themes/TwentyOne/resources/views/pages/auth/logout.blade.php`

## Soluzione
Aggiungere la direttiva `@volt` in testa al file, prima di qualsiasi codice Blade o HTML:

```blade
@volt
@php
    // ... logout logic
@endphp
<x-layout>
    <!-- contenuto pagina logout -->
</x-layout>
```

## Pulizia cache
Dopo la modifica, rigenerare la cache delle viste:

```bash
php artisan view:clear && php artisan route:clear
```

---

## volts

*Consolidated from: `volts.md`*

module: theme
topic: volts
canonical: ../../../Themes/docs/shared-components/volt-errors.md
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

See canonical documentation: ../../../Themes/docs/shared-components/volt-errors.md

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04