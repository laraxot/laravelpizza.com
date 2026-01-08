# Integrazione Filament con Form di Autenticazione

## Introduzione

Questa documentazione descrive come implementare correttamente i form di autenticazione utilizzando widget Filament nel frontoffice del CMS. L'approccio prevede l'utilizzo di widget per garantire maggiore flessibilità, performance e integrazione con il layout esistente.

⚠️ **IMPORTANTE**: 
1. Non estendere mai direttamente le classi di Filament. Utilizzare sempre le classi base di Xot con prefisso `XotBase`.
2. Non utilizzare mai `->label()` nei form. Le traduzioni vengono gestite automaticamente dal `LangServiceProvider`.

Per una analisi dettagliata delle ragioni di questa scelta architetturale, consultare il documento [Widget vs Page per l'Autenticazione](widget-vs-page-auth.md).

## Struttura

```
Modules/
└── User/
    └── Filament/
        └── Widgets/
            └── Auth/
                ├── RegisterWidget.php
                ├── LoginWidget.php
                └── ResetPasswordWidget.php
```

## Implementazione

### 1. Creazione dei Widget di Autenticazione

#### RegisterWidget

```php
<?php

namespace Modules\User\Filament\Widgets\Auth;

use Xot\Filament\Widgets\XotBaseWidget;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Modules\User\Models\User;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class RegisterWidget extends XotBaseWidget
{
    protected static string $view = 'user::filament.widgets.auth.register';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(User::class),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->minLength(8)
                    ->same('password_confirmation'),
                TextInput::make('password_confirmation')
                    ->password()
                    ->required(),
            ])
            ->statePath('data');
    }

    public function register(): void
    {
        $data = $this->form->getState();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        Auth::login($user);

        Notification::make()
            ->title(__('auth.register.notifications.success'))
            ->success()
            ->send();

        $this->redirect(route('dashboard'));
    }
}
```

### 2. Integrazione nelle Blade

#### register.blade.php

```php
<x-filament::widget>
    <x-filament::form wire:submit="register">
        {{ $this->form }}
        
        <x-filament::button type="submit">
            {{ __('auth.register.actions.register') }}
        </x-filament::button>
    </x-filament::form>
</x-filament::widget>
```

## Best Practices

1. **Classi Base**
   - Utilizzare sempre le classi base di Xot con prefisso `XotBase`
   - Non estendere mai direttamente le classi di Filament
   - Verificare la presenza della classe base in Xot prima di implementare
   - Seguire il pattern di composizione invece dell'ereditarietà

2. **Traduzioni**
   - Non utilizzare mai `->label()` nei form
   - Le traduzioni vengono gestite automaticamente dal `LangServiceProvider`
   - Utilizzare `__()` per le traduzioni nelle notifiche
   - Mantenere i file di traduzione aggiornati
   - Supportare tutte le lingue necessarie

3. **Sicurezza**
   - Utilizzare le validazioni integrate di Filament
   - Implementare rate limiting
   - Utilizzare password hashing
   - Proteggere le rotte con middleware appropriati

4. **UX**
   - Mantenere la coerenza con il design system di Filament
   - Fornire feedback chiari sugli errori
   - Implementare validazione in tempo reale
   - Supportare l'accessibilità

5. **Performance**
   - Ottimizzare le query
   - Implementare caching dove appropriato
   - Minimizzare le richieste HTTP
   - Utilizzare lazy loading per i componenti

## Configurazione

1. **Registrazione dei Widget**

```php
// Modules/User/Providers/UserServiceProvider.php
public function boot(): void
{
    Filament::registerWidgets([
        RegisterWidget::class,
        LoginWidget::class,
        ResetPasswordWidget::class,
    ]);
}
```

2. **Configurazione delle Rotte**

```php
// Modules/User/routes/web.php
Route::middleware('web')->group(function () {
    Route::get('register', function () {
        return view('user::auth.register');
    })->name('register');
    
    Route::get('login', function () {
        return view('user::auth.login');
    })->name('login');
    
    Route::get('reset-password', function () {
        return view('user::auth.reset-password');
    })->name('password.reset');
});
```

## Troubleshooting

### Problemi Comuni

1. **Errori di Validazione**
   - Verificare le regole di validazione
   - Controllare i messaggi di errore
   - Assicurarsi che i campi siano correttamente configurati

2. **Problemi di Stile**
   - Verificare la configurazione di Filament
   - Controllare l'ordine degli import CSS
   - Assicurarsi che i componenti siano correttamente stilizzati

3. **Problemi con le Classi Base**
   - Verificare che la classe base esista in Xot
   - Controllare la corretta estensione della classe base
   - Assicurarsi che tutti i metodi necessari siano implementati

4. **Problemi con le Traduzioni**
   - Verificare che i file di traduzione esistano
   - Controllare che le chiavi siano corrette
   - Assicurarsi che il `LangServiceProvider` sia configurato correttamente

## Risorse Utili

- [Documentazione Filament Widgets](https://filamentphp.com/docs/widgets)
- [Documentazione Filament Forms](https://filamentphp.com/docs/forms)
- [Best Practices Filament](https://filamentphp.com/docs/best-practices)
- [Documentazione Xot](https://github.com/laraxot/modules) 
