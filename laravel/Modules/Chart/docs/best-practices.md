# Best Practices

## Architettura

### Moduli
- Ogni modulo deve essere indipendente
- Usare le classi base di Xot
- Evitare dipendenze circolari
- Mantenere la documentazione aggiornata

### Codice
- Seguire PSR-12
- Usare type hints
- Documentare le classi e i metodi
- Mantenere il codice DRY

## Filament

### Resources
```php
// ❌ NON FARE
use Filament\Resources\Resource;

class DoctorResource extends XotBaseResource
{
    public function form(Form $form)
    {
        return $form->schema([...]);
    }
}

// ✅ FARE
use Modules\Xot\Filament\Resources\XotBaseResource;

class DoctorResource extends XotBaseResource
{
    public function form(Form $form)
    {
        return $form->schema([...]);
    }
}
```

### Best Practices per le Resources
1. **MAI** estendere direttamente `Filament\Resources\Resource`
2. **SEMPRE** estendere `Modules\Xot\Filament\Resources\XotBaseResource`
3. Utilizzare le implementazioni base fornite da Xot
4. Mantenere la coerenza con il resto del sistema
5. Sfruttare le funzionalità predefinite di XotBaseResource

### Cosa NON Implementare in XotBaseResource
```php
// ❌ NON FARE - Questi sono già gestiti da XotBaseResource
class DoctorResource extends XotBaseResource
{
    // ❌ ERRORE: Non definire queste proprietà quando si estende XotBaseResource
    protected static ?string $navigationIcon = 'heroicon-o-user';  // NON NECESSARIO
    protected static ?string $navigationGroup = 'Gestione';        // NON NECESSARIO
    protected static ?int $navigationSort = 1;                     // NON NECESSARIO
    
    // ❌ ERRORE: Utilizzare getListTableColumns() invece di getTableColumns()
    public static function getTableColumns(): array                // NON NECESSARIO
    {
        return [...];
    }
    
    public static function getRelations(): array                   // NON NECESSARIO
    {
        return [...];
    }
    
    public static function getPages(): array                       // NON NECESSARIO se usa solo index,create,edit
    {
        return [
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
        ];
    }
}

// ✅ FARE - Implementare solo ciò che è specifico del modulo
class DoctorResource extends XotBaseResource
{
    public function form(Form $form): Form
    {
        return $form->schema([
            // Schema specifico del modulo
        ]);
    }
    
    // Implementare getPages() SOLO se si aggiungono pagine custom oltre a index,create,edit
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
            'custom' => Pages\CustomDoctor::route('/custom'),  // Solo se serve una pagina custom
        ];
    }
}
```

### Regole per le Resources
1. **MAI** implementare:
   - `$navigationIcon` - Gestito da XotBaseResource
   - `$navigationGroup` - Gestito da XotBaseResource
   - `$navigationSort` - Gestito da XotBaseResource
   - `getTableColumns()` - Gestito da XotBaseResource
   - `getRelations()` - Gestito da XotBaseResource
   - `getPages()` - Se usa solo index,create,edit

2. **Implementare SOLO**:
   - `form()` - Per lo schema specifico del modulo
   - `getPages()` - Solo se si aggiungono pagine custom oltre a index,create,edit
   - Altri metodi specifici del modulo

### Motivazione
- Evita duplicazione di codice
- Mantiene la coerenza nell'interfaccia
- Semplifica la manutenzione
- Centralizza la logica comune in XotBaseResource
- Riduce la possibilità di errori
- Migliora la leggibilità del codice

### Pages
```php
// ❌ NON FARE
class DoctorPage extends Page
{
    protected function getHeaderWidgets(): array
    {
        return [...];
    }
}

// ✅ FARE
class DoctorPage extends XotBasePage
{
    // Usare le implementazioni base
}
```

## Notifiche

### Implementazione
```php
// ❌ NON FARE
class DoctorNotification extends Notification
{
    public function toMail($notifiable)
    {
        return [...];
    }
}

// ✅ FARE
$notification = new RecordNotification($record, 'doctor.registration');
```

## Traduzioni

### Implementazione
```php
// ❌ NON FARE
public function label(): string
{
    return 'Dentista';
}

// ✅ FARE
// lang/it/doctor.php
return [
    'label' => 'Dentista',
];
```

## Actions

### Implementazione
```php
// ❌ NON FARE
class DoctorService
{
    public function create(array $data)
    {
        // ...
    }
}

// ✅ FARE
class CreateDoctorAction implements QueueableAction
{
    use QueueableAction;
    
    public function execute(array $data)
    {
        // ...
    }
}
```

## Enums

### Implementazione
```php
// ❌ NON FARE
class DoctorStatus
{
    const PENDING = 'pending';
    const APPROVED = 'approved';
}

// ✅ FARE
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum RegistrationStatus: string implements HasLabel, HasColor
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    
    public function getLabel(): string
    {
        return match($this) {
            self::PENDING => 'In attesa',
            self::APPROVED => 'Approvato',
            self::REJECTED => 'Rifiutato',
        };
    }
    
    public function getColor(): string|array|null
    {
        return match($this) {
            self::PENDING => 'warning',
            self::APPROVED => 'success',
            self::REJECTED => 'danger',
        };
    }
}

// Uso in Filament
Forms\Components\Select::make('status')
    ->options(collect(RegistrationStatus::cases())->mapWithKeys(fn ($case) => [$case->value => $case->getLabel()]))
    ->colors(collect(RegistrationStatus::cases())->mapWithKeys(fn ($case) => [$case->value => $case->getColor()]))
```

### Best Practices per gli Enum
1. Implementare sempre `HasLabel` e `HasColor` per gli enum usati in Filament
2. Usare il trait `HasTranslations` per la localizzazione
3. Centralizzare gli enum comuni in `\Modules\Xot\Enums`
4. Mantenere la coerenza tra valori, label e colori
5. Documentare i possibili valori e il loro significato

### Esempio di Enum con Traduzioni
```php
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasDescription;

enum DayOfWeek: string implements HasLabel, HasColor, HasIcon, HasDescription
{
    case MONDAY = 'monday';
    case TUESDAY = 'tuesday';
    case WEDNESDAY = 'wednesday';
    case THURSDAY = 'thursday';
    case FRIDAY = 'friday';
    case SATURDAY = 'saturday';
    case SUNDAY = 'sunday';
    
    public function getLabel(): string
    {
        return trans("xot::fields.day.options.{$this->value}");
    }
    
    public function getColor(): string|array|null
    {
        return match($this) {
            self::MONDAY, self::TUESDAY, self::WEDNESDAY, 
            self::THURSDAY, self::FRIDAY => 'primary',
            self::SATURDAY, self::SUNDAY => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match($this) {
            self::MONDAY => 'heroicon-o-calendar',
            self::TUESDAY => 'heroicon-o-calendar',
            self::WEDNESDAY => 'heroicon-o-calendar',
            self::THURSDAY => 'heroicon-o-calendar',
            self::FRIDAY => 'heroicon-o-calendar',
            self::SATURDAY => 'heroicon-o-calendar-days',
            self::SUNDAY => 'heroicon-o-calendar-days',
        };
    }

    public function getDescription(): ?string
    {
        return trans("xot::fields.day.descriptions.{$this->value}");
    }
    
    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [
            $case->value => $case->getLabel()
        ])->toArray();
    }
    
    public static function colors(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [
            $case->value => $case->getColor()
        ])->toArray();
    }

    public static function icons(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [
            $case->value => $case->getIcon()
        ])->toArray();
    }

    public static function descriptions(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [
            $case->value => $case->getDescription()
        ])->toArray();
    }
}

// Uso in Filament
Forms\Components\Select::make('day')
    ->options(DayOfWeek::options())
    ->colors(DayOfWeek::colors())
    ->icons(DayOfWeek::icons())
    ->descriptions(DayOfWeek::descriptions())
```

### Best Practices per gli Enum
1. Implementare sempre `HasLabel`, `HasColor`, `HasIcon` e `HasDescription` per gli enum usati in Filament
2. Usare il sistema di traduzioni di Laravel (`trans()`) per le label e le descrizioni
3. Centralizzare gli enum comuni in `\Modules\Xot\Enums`
4. Mantenere la coerenza tra valori, label, colori, icone e descrizioni
5. Documentare i possibili valori e il loro significato
6. Fornire metodi statici `options()`, `colors()`, `icons()` e `descriptions()` per facilitare l'uso in Filament

### Motivazione
- Allineamento completo con gli standard Filament
- Supporto nativo per colori, label, icone e descrizioni
- Integrazione con il sistema di traduzioni di Laravel
- Manutenibilità e riuso del codice
- Coerenza nell'interfaccia utente
- Migliore esperienza utente con descrizioni e icone

## Documentazione

### Struttura
- Mantenere la documentazione nel modulo corretto
- Usare backlinks per la navigazione
- Aggiornare i README.md
- Documentare le API

### Esempi
```markdown

# Titolo

## Descrizione
Breve descrizione del componente

## Implementazione
```php
// Esempio di codice
```

## Collegamenti
- [Documentazione Correlata](./related.md)
- [API Reference](./api.md)
```

## Collegamenti
- [Regole Progetto](./project-rules.md)
- [Struttura Moduli](./module-structure.md)
- [Guida Contribuzione](./CONTRIBUTING.md)

## Note
- Seguire sempre queste best practices
- Mantenere la coerenza nel codice
- Documentare le modifiche
- Testare le implementazioni 

## Ereditarietà dei Modelli nei Moduli

- Ogni modello specializzato (es. Doctor) deve estendere il modello User del proprio modulo.
- Il modello User del modulo deve estendere BaseUser del modulo User.
- BaseUser estende Authenticatable.
- **Mai estendere direttamente Model o BaseModel nei modelli child.**

### Esempio corretto
```php
// Modules/User/app/Models/BaseUser.php
class BaseUser extends Authenticatable { /* ... */ }

// Modules/Patient/app/Models/User.php
namespace Modules\Patient\Models;
use Modules\User\Models\BaseUser;
class User extends BaseUser { /* ... */ }

// Modules/Patient/app/Models/Doctor.php
namespace Modules\Patient\Models;
class Doctor extends User { /* ... */ }
```

### Motivazione
- Garantisce coerenza, riuso, centralizzazione delle policy e delle relazioni, e semplifica la gestione dei permessi e delle query.
- Permette di sfruttare la Single Table Inheritance (STI) con tighten/parental.

## Gestione dei Giorni della Settimana: Best Practice

- **Mai hardcodare** i giorni della settimana in array nei form, resource, ecc.
- Usare sempre un Enum PHP centralizzato (es. WeekDay) per i valori e la logica.
- Per la localizzazione, usare Carbon o le traduzioni Laravel.
- L'enum può avere un metodo label() che restituisce la label localizzata.

### Esempio corretto
```php
enum WeekDay: string
{
    case MONDAY = 'monday';
    case TUESDAY = 'tuesday';
    case WEDNESDAY = 'wednesday';
    case THURSDAY = 'thursday';
    case FRIDAY = 'friday';
    case SATURDAY = 'saturday';
    case SUNDAY = 'sunday';

    public function getLabel(): string
    {
        return $this->transClass(self::class, $this->value.'.label');
    }

    public function getColor(): string
    {
        return $this->transClass(self::class, $this->value.'.color');
    }

    public function getIcon(): string
    {
        return $this->transClass(self::class, $this->value.'.icon');
    }

    public static function getOptions(): array
    {
        return [
            self::MONDAY->value => self::MONDAY->getLabel(),
            self::TUESDAY->value => self::TUESDAY->getLabel(),
            // ... altri giorni
        ];
    }
}

// Uso in Filament
Forms\Components\Select::make('day')
    ->options(WeekDay::getOptions())
```

### Variante con Carbon per localizzazione dinamica
```php
use Carbon\Carbon;

$days = [];
foreach (range(1, 7) as $i) {
    $day = Carbon::create()->startOfWeek()->addDays($i - 1);
    $days[strtolower($day->englishDayOfWeek)] = $day->isoFormat('dddd');
}
Forms\Components\Select::make('day')
    ->options($days);
```

### Motivazione
- Centralizzazione, coerenza, DRY
- Facilità di localizzazione
- Facilità di validazione e test
- Manutenibilità e riuso

## Gestione delle Enum di Utilizzo Comune

- Le enum di utilizzo comune (es. DayOfWeek) **devono essere centralizzate** in `\Modules\Xot\Enums`.
- Questo favorisce il riuso, la coerenza e la manutenibilità tra tutti i moduli del progetto.
- Nei moduli si importano sempre le enum comuni da Xot, non si duplicano.

### Esempio corretto
```php
// Modules/Xot/Enums/DayOfWeek.php
namespace Modules\Xot\Enums;
enum DayOfWeek: string
{
    case MONDAY = 'monday';
    case TUESDAY = 'tuesday';
    case WEDNESDAY = 'wednesday';
    case THURSDAY = 'thursday';
    case FRIDAY = 'friday';
    case SATURDAY = 'saturday';
    case SUNDAY = 'sunday';

    public function getLabel(): string
    {
        return $this->transClass(self::class, $this->value.'.label');
    }

    public function getColor(): string
    {
        return $this->transClass(self::class, $this->value.'.color');
    }

    public function getIcon(): string
    {
        return $this->transClass(self::class, $this->value.'.icon');
    }

    public static function getOptions(): array
    {
        return [
            self::MONDAY->value => self::MONDAY->getLabel(),
            self::TUESDAY->value => self::TUESDAY->getLabel(),
            // ... altri giorni
        ];
    }
}

// Uso nei moduli
use Modules\Xot\Enums\DayOfWeek;
Forms\Components\Select::make('day')
    ->options(DayOfWeek::options())
```

### Motivazione
- Centralizzazione = riuso, coerenza, DRY
- Facilità di localizzazione e validazione
- Manutenzione semplificata

## Invio Email

### Implementazione
```php
// ❌ NON FARE
Mail::to($doctor->email)
    ->queue(new DoctorRegistrationModerated($workflow));

// ✅ FARE
$email = new SpatieEmail($doctor, 'registration_moderated');
Mail::to($data['to'])
    ->locale('it')
    ->send($email);
```

### Template Email
```php
// ❌ NON FARE
MailTemplate::create([
    'mailable' => \App\Mail\WelcomeMail::class,
    'subject' => 'Welcome, {{ name }}',
    'html_template' => '<p>Hello, {{ name }}.</p>',
    'text_template' => 'Hello, {{ name }}.'
]);

// ✅ FARE
MailTemplate::firstOrCreate(
    [
        'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
        'slug' => 'registration_moderated'
    ],
    [
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
    ]
);
```

### Best Practices
1. Usare sempre `SpatieEmail` per l'invio delle email
2. Definire i template nel database usando `MailTemplate::firstOrCreate`
3. Supportare le traduzioni nei template
4. Usare slug significativi per identificare i template
5. Mantenere la coerenza tra HTML e testo semplice
6. Gestire gli allegati tramite il metodo `addAttachments`
7. Impostare sempre la locale corretta prima dell'invio
