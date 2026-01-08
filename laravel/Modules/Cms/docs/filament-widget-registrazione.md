# Implementazione del Widget di Registrazione con Filament

## Indice
1. [Introduzione](#introduzione)
2. [Vantaggi dell'Utilizzo di Widget Filament](#vantaggi-dellutilizzo-di-widget-filament)
3. [Struttura del Widget](#struttura-del-widget)
4. [Implementazione](#implementazione)
5. [Integrazione con Folio](#integrazione-con-folio)
6. [Best Practices](#best-practices)
7. [Esempi di Codice](#esempi-di-codice)

## Introduzione

Questo documento descrive come implementare un widget di registrazione utilizzando Filament nel progetto il progetto. L'approccio basato su widget offre numerosi vantaggi in termini di riutilizzabilità, manutenibilità e coerenza con il resto dell'applicazione.

## Vantaggi dell'Utilizzo di Widget Filament

L'utilizzo di widget Filament per la registrazione offre diversi vantaggi rispetto all'implementazione diretta nel file Blade:

1. **Riutilizzabilità**: Il widget può essere facilmente riutilizzato in diverse parti dell'applicazione.
2. **Separazione delle Responsabilità**: La logica di registrazione è separata dalla vista, migliorando la manutenibilità.
3. **Coerenza**: Garantisce una coerenza visiva e funzionale con il resto dell'applicazione che utilizza Filament.
4. **Aggiornamenti Semplificati**: Modifiche al processo di registrazione possono essere implementate in un unico punto.
5. **Testing Facilitato**: La logica isolata nel widget è più facile da testare.
6. **Estensibilità**: Il widget può essere facilmente esteso con funzionalità aggiuntive.

## Struttura del Widget

Un widget di registrazione Filament dovrebbe seguire questa struttura:

```
Modules/
└── User/
    └── Filament/
        └── Widgets/
            └── RegistrationWidget.php
```

## Implementazione

### Creazione del Widget

```php
<?php

namespace Modules\User\Filament\Widgets;

use App\Models\User;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Widgets\Widget;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\HtmlString;

class RegistrationWidget extends Widget
{
    use InteractsWithForms;

    protected static string $view = 'user::filament.widgets.registration-widget';
    
    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill();
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Dati Personali')
                        ->icon('heroicon-o-user')
                        ->description('Inserisci i tuoi dati personali')
                        ->schema([
                            TextInput::make('name')
                                ->label('Nome')
                                ->required()
                                ->maxLength(255),
                                
                            TextInput::make('surname')
                                ->label('Cognome')
                                ->required()
                                ->maxLength(255),
                                
                            TextInput::make('email')
                                ->label('Email')
                                ->email()
                                ->required()
                                ->unique('users')
                                ->maxLength(255),
                        ]),
                        
                    Step::make('Credenziali')
                        ->icon('heroicon-o-key')
                        ->description('Crea le tue credenziali di accesso')
                        ->schema([
                            TextInput::make('password')
                                ->label('Password')
                                ->password()
                                ->required()
                                ->minLength(8)
                                ->same('password_confirmation'),
                                
                            TextInput::make('password_confirmation')
                                ->label('Conferma Password')
                                ->password()
                                ->required()
                                ->minLength(8),
                        ]),
                        
                    Step::make('Privacy')
                        ->icon('heroicon-o-lock-closed')
                        ->description('Informativa sulla privacy')
                        ->schema([
                            Checkbox::make('terms')
                                ->label(new HtmlString('Accetto i <a href="#" class="text-primary-600 hover:underline">Termini di Servizio</a> e l\'<a href="#" class="text-primary-600 hover:underline">Informativa sulla Privacy</a>'))
                                ->required(),
                                
                            Checkbox::make('newsletter')
                                ->label('Desidero ricevere aggiornamenti via email sul progetto il progetto'),
                        ]),
                ])
                ->skippable(false)
                ->submitAction(new HtmlString('<button type="submit" class="w-full bg-blue-900 text-white text-lg font-medium py-3 px-6 rounded-full hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-opacity-50 shadow-sm hover:shadow-md transition-all duration-200">COMPLETA REGISTRAZIONE</button>'))
            ])
            ->statePath('data');
    }
    
    public function register()
    {
        $state = $this->form->getState();
        
        $user = User::create([
            'name' => $state['name'],
            'email' => $state['email'],
            'password' => Hash::make($state['password']),
        ]);
        
        event(new Registered($user));
        
        Auth::login($user, true);
        
        return redirect()->intended('/');
    }
}
```

### Vista del Widget

```blade
<div>
    <form wire:submit.prevent="register">
        {{ $this->form }}
    </form>
    
    <div class="text-sm text-center text-gray-600 mt-6">
        Hai già un account? <a href="{{ route('login') }}" class="text-blue-800 hover:underline">Accedi</a>
    </div>
</div>
```

## Integrazione con Folio

Per utilizzare il widget in una pagina Folio, è necessario registrarlo e poi includerlo nella pagina:

### Registrazione del Widget

Nel file `Modules/User/Providers/UserServiceProvider.php`:

```php
use Filament\Facades\Filament;
use Modules\User\Filament\Widgets\RegistrationWidget;

public function boot()
{
    // ... altro codice
    
    Filament::registerWidgets([
        RegistrationWidget::class,
    ]);
}
```

### Utilizzo nella Pagina di Registrazione

Nel file `resources/views/pages/auth/register.blade.php`:

```php
<?php

use function Laravel\Folio\{middleware, name};

middleware(['guest']);
name('register');

?>

<x-layouts.main>
    <div class="bg-blue-900 text-white p-4 flex justify-between items-center mb-8">
        <div class="text-3xl font-light">
            <a href="{{ route('home') }}" class="text-white no-underline">
                <slogan>
            </a>
        </div>
        <button class="text-white" aria-label="Menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <div class="max-w-3xl mx-auto p-6">
        <h1 class="text-2xl font-medium text-blue-900 mb-2">Registrazione</h1>
        <p class="text-gray-600 mb-8">Compila i seguenti passaggi per creare il tuo account su il progetto</p>
        
        <div class="bg-white rounded-lg shadow-sm p-6">
            <livewire:user::filament.widgets.registration-widget />
        </div>
    </div>
</x-layouts.main>
```

## Best Practices

1. **Namespace Coerente**: Mantenere il widget nel namespace appropriato del modulo (es. `Modules\User\Filament\Widgets`).
2. **Validazione Robusta**: Implementare una validazione completa per tutti i campi.
3. **Gestione degli Errori**: Fornire feedback chiari in caso di errori durante la registrazione.
4. **Localizzazione**: Utilizzare le funzionalità di localizzazione per supportare più lingue.
5. **Eventi**: Utilizzare eventi Laravel per azioni post-registrazione (es. invio email di benvenuto).
6. **Sicurezza**: Implementare protezioni contro attacchi CSRF e altre vulnerabilità.

## Esempi di Codice

### Esempio 1: Widget con Validazione Personalizzata

```php
TextInput::make('password')
    ->label('Password')
    ->password()
    ->required()
    ->minLength(8)
    ->rules([
        'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
    ])
    ->validationMessages([
        'regex' => 'La password deve contenere almeno una lettera maiuscola, una minuscola, un numero e un carattere speciale.',
    ])
    ->same('password_confirmation'),
```

### Esempio 2: Integrazione con Notifiche

```php
public function register()
{
    $state = $this->form->getState();
    
    $user = User::create([
        'name' => $state['name'],
        'email' => $state['email'],
        'password' => Hash::make($state['password']),
    ]);
    
    event(new Registered($user));
    
    // Invia notifica di benvenuto
    $user->notify(new WelcomeNotification());
    
    Auth::login($user, true);
    
    return redirect()->intended('/')->with('success', 'Registrazione completata con successo!');
}
```
