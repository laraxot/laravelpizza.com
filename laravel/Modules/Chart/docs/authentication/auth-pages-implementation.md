# Implementazione delle Pagine di Autenticazione

## Collegamenti correlati
- [Documentazione centrale](../README.md)
- [Collegamenti documentazione](../collegamenti-documentazione.md)
- [Implementazione Auth Pages](../../laravel/Modules/User/docs/AUTH_PAGES_IMPLEMENTATION.md)
- [Implementazione Logout](../../laravel/Modules/User/docs/LOGOUT_BLADE_IMPLEMENTATION.md)
- [Analisi Logout](../../laravel/Modules/User/docs/LOGOUT_BLADE_ANALYSIS.md)
- [Conclusioni Logout](../../laravel/Modules/User/docs/LOGOUT_BLADE_CONCLUSIONS.md)
- [Analisi Errore Logout](../../laravel/Modules/User/docs/LOGOUT_IMPLEMENTATION_ERROR.md)
- [Logout con Widget Filament](../../laravel/Modules/User/docs/LOGOUT_FILAMENT_WIDGET.md)
- [Struttura Widget](../../laravel/Modules/User/docs/WIDGETS_STRUCTURE.md)
- [Documentazione Auth Tema One](../../laravel/Themes/One/docs/AUTH.md)

## Panoramica

Questo documento descrive l'implementazione delle pagine di autenticazione in <nome progetto>, con particolare attenzione al file `logout.blade.php`. Le pagine di autenticazione sono implementate utilizzando Laravel Folio, Livewire Volt e componenti Filament, seguendo le convenzioni del progetto <nome progetto>.

## Struttura delle Directory

```
laravel/Themes/One/resources/views/pages/auth/
├── login.blade.php      # Pagina di login
├── register.blade.php   # Pagina di registrazione
├── logout.blade.php     # Pagina di logout
├── [type]/              # Registrazione per tipo utente
│   └── register.blade.php
├── password/            # Gestione password
│   ├── [token].blade.php  # Reset password
│   ├── confirm.blade.php  # Conferma password
│   └── reset.blade.php    # Richiesta reset
├── thank-you.blade.php  # Conferma registrazione
└── verify.blade.php     # Verifica email
```

## Approcci di Implementazione

In <nome progetto>, ci sono tre approcci principali per implementare le pagine di autenticazione:

1. **Folio con PHP puro (Raccomandato per logout)**: Semplice, diretto, senza gestione dello stato
2. **Volt Action dedicata**: Per azioni che richiedono POST (es. form di logout)
3. **Folio con Volt**: Per pagine con interazione utente (login, registrazione)

## Implementazione del Logout

### Approccio Raccomandato: Folio con PHP puro

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use function Laravel\Folio\{middleware, name};

middleware(['auth']);
name('logout');

if(Auth::check()) {
    // Ottieni l'utente prima del logout per il logging
    $user = Auth::user();
    
    // Evento pre-logout
    Event::dispatch('auth.logout.attempting', [$user]);

    // Esegui il logout
    Auth::logout();

    // Invalida e rigenera la sessione per prevenire session fixation
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    
    // Evento post-logout
    Event::dispatch('auth.logout.successful');
    
    // Log dell'operazione
    Log::info('Utente disconnesso', [
        'user_id' => $user->id ?? null,
        'timestamp' => now()
    ]);
}

// Reindirizza l'utente alla home page localizzata
$locale = app()->getLocale();
return redirect()->to('/' . $locale)
    ->with('success', __('Logout effettuato con successo'));
?>
```

### Vantaggi dell'Approccio Raccomandato

1. **Semplicità**: Il logout è un'operazione semplice che non richiede gestione dello stato o interazione con l'utente.
2. **Efficienza**: Il reindirizzamento immediato offre una migliore esperienza utente rispetto a una pagina di conferma.
3. **Coerenza**: Questo approccio è coerente con le convenzioni di <nome progetto> per le operazioni semplici.
4. **Sicurezza**: Implementa correttamente tutte le misure di sicurezza necessarie (invalidazione sessione, rigenerazione token).
5. **Tracciabilità**: Include eventi e logging per una migliore tracciabilità delle operazioni.

### Approccio Alternativo: Widget Filament

Per casi in cui è necessaria una conferma dell'utente, <nome progetto> raccomanda l'utilizzo di widget Filament invece di implementazioni Volt personalizzate:

```php
<?php
declare(strict_types=1);

use function Laravel\Folio\{middleware, name};

middleware(['auth']);
name('logout');
?>

<x-layout>
    <x-slot:title>
        {{ __('Logout') }}
    </x-slot>

    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow-lg">
            @livewire(\Modules\User\Filament\Widgets\LogoutWidget::class)
        </div>
    </div>
</x-layout>
```

#### Vantaggi dell'Approccio con Widget Filament

1. **Riutilizzabilità**: Il widget può essere utilizzato sia nelle pagine Blade che nei pannelli Filament.
2. **Coerenza UI**: Utilizza i componenti UI nativi di Filament, garantendo coerenza visiva.
3. **Manutenibilità**: Separa chiaramente la logica dalla presentazione.
4. **Estensibilità**: Facilmente estensibile per aggiungere funzionalità aggiuntive.
5. **Conformità alle convenzioni**: Segue le convenzioni di <nome progetto> per i widget Filament.

## Best Practices

### Localizzazione degli URL

Utilizzare sempre `app()->getLocale()` per ottenere la lingua corrente e includerla nei link e nei reindirizzamenti:

```php
$locale = app()->getLocale();
return redirect()->to('/' . $locale);
```

### Componenti UI Filament

Utilizzare sempre i componenti Blade nativi di Filament per pulsanti e altri elementi UI:

```blade
<x-filament::button 
    type="submit"
    size="lg"
    color="primary"
    class="w-full justify-center">
    {{ __('Accedi') }}
</x-filament::button>
```

### Sicurezza della Sessione

Invalidare e rigenerare sempre la sessione dopo il logout per prevenire attacchi di session fixation:

```php
Auth::logout();
session()->invalidate();
session()->regenerateToken();
```

### Traduzioni

Utilizzare sempre la funzione `__()` per le stringhe visualizzate all'utente:

```blade
{{ __('Logout effettuato con successo') }}
```

## Documentazione Dettagliata

Per una documentazione più dettagliata sull'implementazione delle pagine di autenticazione, consultare i seguenti documenti:

- [AUTH_PAGES_IMPLEMENTATION.md](../../laravel/Modules/User/docs/AUTH_PAGES_IMPLEMENTATION.md): Guida completa all'implementazione di tutte le pagine di autenticazione.
- [LOGOUT_BLADE_IMPLEMENTATION.md](../../laravel/Modules/User/docs/LOGOUT_BLADE_IMPLEMENTATION.md): Focus specifico sull'implementazione del logout.
- [LOGOUT_BLADE_ANALYSIS.md](../../laravel/Modules/User/docs/LOGOUT_BLADE_ANALYSIS.md): Analisi dettagliata dell'implementazione attuale del logout.
- [LOGOUT_BLADE_CONCLUSIONS.md](../../laravel/Modules/User/docs/LOGOUT_BLADE_CONCLUSIONS.md): Conclusioni e raccomandazioni per l'implementazione del logout.

## Larghezza dei Widget di Autenticazione

I widget di autenticazione (login, registrazione, ecc.) devono occupare uno spazio orizzontale adeguato per garantire una buona esperienza utente. Per questo motivo:

1. I widget devono utilizzare una larghezza massima di almeno `max-w-4xl` per garantire che il contenuto sia ben distribuito
2. Il contenitore principale deve essere centrato nella pagina usando `mx-auto`
3. Il padding laterale deve essere adeguato per evitare che il contenuto sia troppo vicino ai bordi

Esempio di implementazione corretta:

```blade
<div class="p-4 bg-white rounded-xl shadow">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                {{ __('Registrazione') }}
            </h2>
        </div>
        {{ $slot }}
    </div>
</div>
```

Questa struttura garantisce che:
- Il widget occupi uno spazio orizzontale adeguato
- Il contenuto sia ben distribuito e leggibile
- L'esperienza utente sia ottimale su tutti i dispositivi

## Layout dei Form di Registrazione

### Best Practices per il Layout

1. **Larghezza del Container**
   - Utilizzare `max-w-7xl` per i form complessi come la registrazione paziente
   - Mantenere un padding adeguato con `px-4 sm:px-6 lg:px-8`
   - Centrare il form con `mx-auto`

2. **Gestione dello Spazio**
   - Utilizzare `Grid` per organizzare i campi in colonne
   - Mantenere una larghezza minima di 300px per campo
   - Utilizzare `columnSpanFull` per campi che devono occupare l'intera larghezza

3. **Responsive Design**
   - Utilizzare breakpoints appropriati per il layout responsive
   - Adattare il numero di colonne in base alla larghezza dello schermo
   - Mantenere una leggibilità ottimale su tutti i dispositivi

### Esempio di Implementazione

```blade
<div class="p-4 bg-white rounded-xl shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                Registrazione Paziente
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Compila tutti i campi per completare la registrazione
            </p>
        </div>

        <form wire:submit="submit">
            {{ $this->form }}
        </form>
    </div>
</div>
```

## Implementazione degli Step del Wizard

### Struttura Corretta

1. **Separazione delle Responsabilità**
   - Ogni step deve avere un metodo dedicato per la definizione dello step
   - Ogni step deve avere un metodo dedicato per lo schema
   - Esempio:
   ```php
   protected static function getPrivacyStep(): Forms\Components\Wizard\Step
   {
       return Forms\Components\Wizard\Step::make('privacy_step')
           ->schema(self::getPrivacyStepSchema());
   }

   protected static function getPrivacyStepSchema(): array
   {
       return [
           Forms\Components\View::make('patient::privacy-policy')
               ->columnSpanFull(),
           Forms\Components\Checkbox::make('privacy_acceptance')
               ->required()
               ->columnSpanFull(),
           Forms\Components\Checkbox::make('newsletter')
               ->columnSpanFull(),
       ];
   }
   ```

2. **Naming Conventions**
   - I metodi degli step devono seguire il pattern `get{StepName}Step`
   - I metodi degli schema devono seguire il pattern `get{StepName}StepSchema`
   - I nomi degli step devono essere in snake_case
   - Esempio:
   ```php
   getPersonalInfoStep()
   getPersonalInfoStepSchema()
   getPrivacyStep()
   getPrivacyStepSchema()
   ```

3. **Visibilità e Validazione**
   - La visibilità dello step deve essere definita nel metodo dello step
   - La validazione deve essere definita nel metodo dello step
   - Esempio:
   ```php
   protected static function getPrivacyStep(): Forms\Components\Wizard\Step
   {
       return Forms\Components\Wizard\Step::make('privacy_step')
           ->schema(self::getPrivacyStepSchema())
           ->visible(fn () => request()->has('token'))
           ->afterValidation(function (Forms\Set $set) {
               // Logica di validazione
           });
   }
   ```

4. **Organizzazione del Codice**
   - I metodi degli step devono essere raggruppati insieme
   - I metodi degli schema devono essere raggruppati insieme
   - Esempio:
   ```php
   class PatientResource extends XotBaseResource
   {
       // 1. Step Methods
       protected static function getPersonalInfoStep(): Step
       protected static function getPrivacyStep(): Step

       // 2. Schema Methods
       protected static function getPersonalInfoStepSchema(): array
       protected static function getPrivacyStepSchema(): array
   }
   ```

### Best Practices

1. **Riutilizzo del Codice**
   - Utilizzare metodi dedicati per gli schema
   - Evitare la duplicazione del codice
   - Mantenere la coerenza nella struttura

2. **Gestione delle Traduzioni**
   - Utilizzare il sistema di traduzione di Filament
   - Evitare l'uso diretto della funzione `__()`
   - Mantenere le traduzioni nei file dedicati

3. **Validazione e Sicurezza**
   - Implementare la validazione appropriata
   - Gestire correttamente i permessi
   - Mantenere la sicurezza dei dati

4. **Manutenibilità**
   - Documentare ogni metodo
   - Mantenere il codice pulito e organizzato
   - Seguire le convenzioni di codifica
