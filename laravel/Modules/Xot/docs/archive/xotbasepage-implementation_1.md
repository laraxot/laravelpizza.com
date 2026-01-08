# xotbasepage: implementazione e best practices

## descrizione
la classe `XotBasePage` è una classe base astratta per tutte le pagine filament non collegate a risorse specifiche. fornisce funzionalità comuni come gestione delle traduzioni, integrazione con il sistema di autorizzazioni e utilità per l'accesso ai dati.

## struttura
la classe `XotBasePage` estende `Filament\Pages\Page` e si trova in:
```
/var/www/html/base_<nome progetto>/laravel/Modules/Xot/app/Filament/Pages/XotBasePage.php
```

## namespace
```php
namespace Modules\Xot\Filament\Pages;
```

## utilizzo corretto

```php
// nel modulo esempio
namespace Modules\Example\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;

class SettingsPage extends XotBasePage
{
    // implementazione...
}
```

## funzionalità principali

1. **sistema di traduzioni integrato**
   - localizzazione automatica basata sul modulo
   - generazione di chiavi di traduzione standardizzate

2. **gestione autorizzazioni**
   - integrazione con policy e autorizzazioni

3. **integrazione con form**
   - gestione form standardizzata
   - supporto per validazione

4. **rilevamento intelligente modello**
   - rilevamento automatico del modello associato
   - gestione centralizzata dell'entità associata

## best practices

### 1. traduzioni
- non usare mai stringhe hardcoded per le etichette
- utilizzare il metodo `trans()` o il trait `TransTrait`
- organizzare le traduzioni nei file del modulo (`/Modules/NomeModulo/lang/`)

### 2. override di metodi
- implementare `getFormSchema()` per definire la struttura del form SOLO nelle classi figlie che ne hanno bisogno
- NON dichiarare mai abstract getFormSchema() in XotBasePage
- non sovrascrivere metodi dichiarati come `final`
- estendere i metodi hook dove possibile

### 3. viste
- utilizzare viste nel modulo specifico
- preferire component blade riutilizzabili

### 4. performance
- evitare query n+1 utilizzando eager loading
- minimizzare il caricamento di risorse non necessarie

## esempio completo

```php
namespace Modules\<nome progetto>\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class DashboardSettings extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    
    protected static string $view = '<nome progetto>::filament.pages.dashboard-settings';
    
    protected function getFormFields(): array
    {
        return [
            'title' => [
                'type' => TextInput::class,
                'label' => true,
                'tooltip' => true,
                'placeholder' => true,
                'required' => true,
            ],
            'refresh_interval' => [
                'type' => Select::class,
                'label' => true,
                'tooltip' => true,
                'options' => [
                    '30' => '30 secondi',
                    '60' => '1 minuto',
                    '300' => '5 minuti',
                ]
            ]
        ];
    }
    
    public function submit(): void
    {
        $this->form->validate();
        // logica di salvataggio
    }

    public function authorize(): bool
    {
        return auth()->user()->can('view', static::class);
    }
}
```

## traduzioni dei campi

Le traduzioni dei campi del form devono essere definite nei file di traduzione del modulo seguendo questa struttura:

```php
// /Modules/NomeModulo/lang/it/fields.php
return [
    'title' => [
        'label' => 'Titolo',
        'tooltip' => 'Inserisci il titolo della dashboard',
        'placeholder' => 'Es. Dashboard Principale',
    ],
    'refresh_interval' => [
        'label' => 'Intervallo di aggiornamento',
        'tooltip' => 'Seleziona ogni quanto aggiornare i dati',
        'placeholder' => 'Seleziona un intervallo',
    ],
];
```

## autorizzazioni

Per implementare le autorizzazioni, è necessario:

1. Definire una policy per la pagina
2. Implementare il metodo `authorize()` nella classe della pagina
3. Registrare la policy nel service provider del modulo

```php
// /Modules/NomeModulo/Policies/DashboardSettingsPolicy.php
namespace Modules\NomeModulo\Policies;

use App\Models\User;

class DashboardSettingsPolicy
{
    public function view(User $user): bool
    {
        return $user->hasRole('admin');
    }
}
```

## considerazioni di sicurezza
- validare sempre gli input dell'utente
- utilizzare `authorizeAccess()` per controllare gli accessi
- seguire il principio del privilegio minimo

## pattern comuni
- pagine di impostazioni
- dashboard specializzate
- pagine di reportistica
- wizard personalizzati

## collegamento ad altre documentazioni
- [pattern di estensione filament](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/docs/filament_extension_pattern.md)
- [best practices filament](/var/www/html/base_<nome progetto>/laravel/Modules/<nome progetto>/docs/filament-best-practices.md)

## ATTENZIONE: errori critici da evitare
- NON dichiarare mai abstract getFormSchema() in XotBasePage: la classe base Filament lo implementa già. Fornire sempre una implementazione di default (array vuoto).
- Se serve uno schema custom, sovrascrivere il metodo nella classe figlia.
