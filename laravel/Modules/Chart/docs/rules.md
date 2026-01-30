## Stati vs Workflow

- Usa spatie/laravel-model-states solo per processi semplici (pubblicazione, validazione, pagamento).
- Per workflow complessi (registrazione moderata, onboarding multi-step, processi con dati intermedi e storicizzazione) usa un modello dedicato (es. DoctorRegistrationWorkflow).
- Documenta sempre la scelta architetturale e motiva la scelta nei file di dettaglio del modulo. 

## Gerarchia delle Classi User

1. **BaseUser**
   - Classe base in `Modules\User\Models\BaseUser`
   - Contiene la logica comune a tutti gli utenti
   - Estende `Illuminate\Database\Eloquent\Model`

2. **User**
   - Classe in `Modules\Patient\Models\User`
   - Estende `Modules\User\Models\BaseUser`
   - Contiene la logica specifica per i pazienti

3. **Doctor**
   - Classe in `Modules\Patient\Models\Doctor`
   - Estende `Modules\Patient\Models\User`
   - Contiene la logica specifica per i dottori

> **IMPORTANTE**: Non assumere mai che una classe estenda Model o BaseModel senza verificare la gerarchia completa. La gerarchia delle classi User è fondamentale per il funzionamento del sistema multi-tenant. 

## Mutators e Casts in Laravel 12

1. **NO più $casts**
   - ❌ NON usare più `protected $casts = []`
   - ✅ Usare i nuovi mutators di Laravel 12:
     ```php
     protected function casts(): array
     {
         return [
             'status' => DoctorRegistrationStatus::class,
             'approved_at' => 'datetime',
             'completed_at' => 'datetime',
         ];
     }
     ```

2. **Best Practices**
   - Usa sempre il metodo `casts()` invece della proprietà `$casts`
   - Documenta i tipi di cast utilizzati
   - Usa type-hinting per i mutators
   - Implementa mutators custom quando necessario

> **IMPORTANTE**: Laravel 12 ha deprecato la proprietà `$casts`. Usa sempre il metodo `casts()` per definire i cast dei modelli.

## Gestione Giorni della Settimana

1. **NO più array hardcoded**
   - ❌ NON usare array hardcoded per i giorni
   - ❌ NON usare traduzioni manuali per ogni giorno
   - ❌ NON duplicare la logica in più punti

2. **Best Practices**
   - ✅ Usa Enum per i giorni della settimana
   - ✅ Sfrutta Carbon per le operazioni sui giorni
   - ✅ Centralizza le traduzioni
   - ✅ Implementa metodi helper nel modello

3. **Implementazione Consigliata**
   ```php
   // /laravel/Modules/Patient/app/Enums/DayOfWeek.php
   enum DayOfWeek: int
   {
       case MONDAY = 1;
       case TUESDAY = 2;
       case WEDNESDAY = 3;
       case THURSDAY = 4;
       case FRIDAY = 5;
       case SATURDAY = 6;
       case SUNDAY = 7;

       public function label(): string
       {
           return Carbon::create()->startOfWeek()->addDays($this->value - 1)->locale('it')->isoFormat('dddd');
       }

       public function shortLabel(): string
       {
           return Carbon::create()->startOfWeek()->addDays($this->value - 1)->locale('it')->isoFormat('ddd');
       }

       public static function toArray(): array
       {
           return collect(self::cases())->mapWithKeys(fn ($day) => [
               $day->value => $day->label()
           ])->toArray();
       }
   }
   ```

4. **Utilizzo nel Form**
   ```php
   Forms\Components\Select::make('day')
       ->options(DayOfWeek::toArray())
       ->required()
   ```

> **IMPORTANTE**: Usa sempre Enum per i giorni della settimana. Questo garantisce type-safety, centralizzazione della logica e facile manutenzione.

## Gestione Enum Comuni

1. **Posizione degli Enum**
   - ✅ Enum di utilità generale vanno in `Modules\Xot\Enums`
   - ✅ Enum specifici del modulo rimangono nel modulo
   - ✅ Enum riutilizzabili in più moduli vanno in Xot

2. **Criteri per Spostare in Xot**
   - Funzionalità di utilità generale (es. giorni settimana, mesi, stati)
   - Utilizzo previsto in più moduli
   - Logica indipendente dal contesto specifico
   - Funzionalità di base del sistema

3. **Esempi di Enum in Xot**
   - `DayOfWeek`: gestione giorni settimana
   - `Month`: gestione mesi
   - `Country`: gestione paesi
   - `Currency`: gestione valute

> **IMPORTANTE**: Gli enum in `Modules\Xot\Enums` devono essere ben documentati e mantenere una logica pura, senza dipendenze da moduli specifici.

## Gestione Email e Template

1. **SpatieEmail e Template**
   - ✅ Usa SEMPRE `SpatieEmail` come mailable
   - ✅ Usa SEMPRE il campo `slug` per identificare il tipo di email
   - ✅ I template devono essere multilingua (array associativo per lingua)
   - ❌ NON creare classi Mailable custom

2. **Implementazione Corretta**
   ```php
   MailTemplate::firstOrCreate([
       'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
       'slug' => 'registration_moderated',
   ], [
       'subject' => [
           'it' => 'Registrazione moderata, {{ first_name }}',
           'en' => 'Registration moderated, {{ first_name }}'
       ],
       'html_template' => [
           'it' => '<p>Ciao {{ first_name }},</p><p>La tua registrazione è stata moderata.</p>',
           'en' => '<p>Hello {{ first_name }},</p><p>Your registration has been moderated.</p>'
       ],
       'text_template' => [
           'it' => 'Ciao {{ first_name }}, La tua registrazione è stata moderata.',
           'en' => 'Hello {{ first_name }}, Your registration has been moderated.'
       ]
   ]);
   ```

3. **Best Practices**
   - Centralizza i template nel seeder
   - Usa sempre il locale corretto
   - Gestisci gli allegati tramite `addAttachments`
   - Mantieni i template in HTML e testo
   - Usa SEMPRE la struttura multilingua

> **IMPORTANTE**: Non usare workflow custom per le email. Usa sempre `SpatieEmail` con `MailTemplate` e struttura multilingua per una gestione centralizzata e manutenibile delle email.

## Standard Enum Filament

- Tutti gli enum devono implementare SEMPRE:
  - `Filament\Support\Contracts\HasLabel`
  - `Filament\Support\Contracts\HasColor`
  - `Filament\Support\Contracts\HasIcon`
  - `Filament\Support\Contracts\HasDescription`
- Implementare i metodi richiesti anche con valore di default/null se non serve
- Usare sempre enum native PHP (PHP 8.1+)
- Utilizzare `->options(Enum::class)` nei form e nelle tabelle
- Esempio completo:

```php
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasDescription;

enum DayOfWeek: int implements HasLabel, HasColor, HasIcon, HasDescription
{
    case MONDAY = 1;
    case TUESDAY = 2;
    // ...

    public function getLabel(): ?string
    {
        return match($this) {
            self::MONDAY => 'Lunedì',
            self::TUESDAY => 'Martedì',
            // ...
        };
    }

    public function getColor(): ?string
    {
        return match($this) {
            self::SATURDAY, self::SUNDAY => 'warning',
            default => 'primary',
        };
    }

    public function getIcon(): ?string
    {
        return match($this) {
            self::SATURDAY, self::SUNDAY => 'heroicon-o-sun',
            default => 'heroicon-o-calendar',
        };
    }

    public function getDescription(): ?string
    {
        return match($this) {
            self::MONDAY => 'Primo giorno lavorativo',
            self::SATURDAY, self::SUNDAY => 'Weekend',
            default => null,
        };
    }
}
```

> **IMPORTANTE**: Se Filament ha uno standard per una funzionalità, va sempre adottato in tutto il progetto. Gli enum DEVONO implementare tutte le interfacce Filament sopra elencate.

## Resource Filament: Estensione Corretta

- NON estendere mai direttamente `Filament\Resources\Resource`
- Estendere SEMPRE `Modules\Xot\Filament\Resources\XotBaseResource`
- Questo garantisce override centralizzati, policy, permessi e compatibilità futura
- Esempio corretto:

```php
namespace Modules\Patient\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class DoctorAvailabilityResource extends XotBaseResource
{
    // ...
}
```

> **IMPORTANTE**: Se trovi una classe che estende direttamente `Filament\Resources\Resource`, correggi immediatamente e segnala l'errore.

## Resource XotBaseResource: Proprietà e Metodi Vietati

- Chi estende `XotBaseResource` NON deve mai dichiarare:
  - `protected static ?string $navigationIcon`
  - `protected static ?string $navigationGroup`
  - `protected static ?int $navigationSort`
  - `public static function getTableColumns()`
  - `public static function getRelations()`
  - `public static function getPages()` (se restituisce solo `index`, `create`, `edit`)
- Queste proprietà e metodi sono gestiti centralmente o tramite convenzioni
- Definirli localmente porta a duplicazione e perdita di controllo
- Esempio minimale:

```php
namespace Modules\Patient\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class DoctorAvailabilityResource extends XotBaseResource
{
    // Solo metodi e proprietà specifiche del modulo
}
```

> **IMPORTANTE**: Controlla sempre che i resource dei moduli NON contengano queste proprietà/metodi. Se li trovi, rimuovili e segnala l'errore.
