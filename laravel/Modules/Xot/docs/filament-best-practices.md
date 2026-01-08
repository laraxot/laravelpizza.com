# Best Practices per Risorse Filament in Laraxot

Questo documento riassume le migliori pratiche per la creazione e gestione delle risorse Filament all'interno dell'ecosistema Laraxot. Seguire queste linee guida garantirà compatibilità e coerenza in tutto il progetto.

## Estensione delle Classi Base

### Risorse

1. **SEMPRE** estendere `Modules\Xot\Filament\Resources\XotBaseResource`:
   ```php
   // CORRETTO ✅
   class ClienteResource extends XotBaseResource
   
   // ERRATO ❌
   class ClienteResource extends Resource
   ```

2. **SEMPRE** implementare `getFormSchema()`:
   ```php
   public static function getFormSchema(): array
   {
       return [
           TextInput::make('nome')->required(),
           TextInput::make('email')->email()->required(),
       ];
   }
   ```

3. **MAI** definire `navigationIcon` se si estende `XotBaseResource`:
   ```php
   // ❌ ERRATO
   class ReportResource extends XotBaseResource
   {
       protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack'; // GESTITO AUTOMATICAMENTE
   }
   
   // ✅ CORRETTO
   class ReportResource extends XotBaseResource
   {
       // Navigation icon gestita automaticamente da XotBaseResource
   }
   ```

4. **MAI** usare `->label()` nei form components:
   ```php
   // ❌ ERRATO
   TextInput::make('name')->label('Nome')
   
   // ✅ CORRETTO
   TextInput::make('name') // Label gestita da LangServiceProvider
   ```

### Pagine

1. **SEMPRE** estendere le classi base di Xot:
   ```php
   // CORRETTO ✅
   class ListClienti extends XotBaseListRecords
   class CreateCliente extends XotBaseCreateRecord
   class EditCliente extends XotBaseEditRecord
   class ViewCliente extends XotBaseViewRecord
   
   // ERRATO ❌
   class ListClienti extends ListRecords
   class CreateCliente extends CreateRecord
   class EditCliente extends EditRecord
   class ViewCliente extends ViewRecord
   ```

## Regole per XotBaseListRecords

### Metodo Obbligatorio: getTableColumns()

**⚠️ IMPORTANTE**: Tutte le classi che estendono `XotBaseListRecords` DEVONO implementare il metodo `getTableColumns()`:

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Filament\Actions;
use Filament\Tables;

/**
 * Pagina di elenco per i report.
 * 
 * ✅ IMPLEMENTAZIONE CORRETTA: Estende XotBaseListRecords
 * ✅ SEGUE IL PATTERN LARAXOT: Non estende ListRecords di Filament direttamente
 * ✅ IMPLEMENTA getTableColumns(): Metodo obbligatorio per XotBaseListRecords
 * ✅ DOCUMENTAZIONE AGGIORNATA: PHPDoc completo e chiaro
 * ✅ CAMPI REALI: Solo campi che esistono nel modello Report
 * ✅ NO LABEL: Non uso ->label() perché gestito da LangServiceProvider
 */
class ListReports extends XotBaseListRecords
{
    protected static string $resource = ReportResource::class;

    /**
     * Get the table columns.
     *
     * @return array<string, \Filament\Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => Tables\Columns\TextColumn::make('id')
                ->searchable()
                ->sortable(),
            'patient_id' => Tables\Columns\TextColumn::make('patient_id')
                ->searchable()
                ->sortable(),
            'has_mouth_or_teeth_pain' => Tables\Columns\IconColumn::make('has_mouth_or_teeth_pain')
                ->boolean()
                ->sortable(),
            // Altri campi reali del modello Report...
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(), // ✅ NO ->label() hardcoded
        ];
    }
}
```

### Regole per getTableColumns()

1. **Visibilità**: SEMPRE `public`
2. **Tipo di ritorno**: SEMPRE `array<string, \Filament\Tables\Columns\Column>`
3. **Struttura**: Array associativo con chiavi stringa
4. **Campi Reali**: MAI inventare campi, usare solo quelli del modello
5. **Traduzioni**: MAI usare `->label()`, gestite da LangServiceProvider
6. **Tipizzazione**: Includere PHPDoc completo

### Esempio di Implementazione Corretta

```php
/**
 * Get the table columns.
 *
 * @return array<string, \Filament\Tables\Columns\Column>
 */
public function getTableColumns(): array
{
    return [
        'id' => Tables\Columns\TextColumn::make('id')
            ->searchable()
            ->sortable(),
        'name' => Tables\Columns\TextColumn::make('name')
            ->searchable()
            ->sortable(),
        'email' => Tables\Columns\TextColumn::make('email')
            ->searchable()
            ->sortable(),
        'status' => Tables\Columns\BadgeColumn::make('status')
            ->colors([
                'primary' => 'active',
                'danger' => 'inactive',
            ]),
        'created_at' => Tables\Columns\TextColumn::make('created_at')
            ->dateTime('d/m/Y H:i')
            ->sortable(),
# Filament Best Practices (Moduli Riutilizzabili)

## Descrizione
Best practice generiche per l'utilizzo di Filament in moduli Laravel riutilizzabili. Nessun riferimento a nomi di progetto o brand.

## Regole principali
- NON estendere mai direttamente le classi di Filament: creare sempre wrapper personalizzati
- Utilizzare traits per funzionalità riutilizzabili
- Seguire il pattern di composizione invece dell'ereditarietà
- Mantenere la compatibilità con gli aggiornamenti di Filament
- Centralizzare le configurazioni comuni nelle classi base
- Non inserire proprietà statiche custom nei resource (es. $navigationIcon, $navigationGroup, $translationPrefix)
- Non usare ->label() direttamente nei form: usare sempre i file di traduzione

## Esempi
```php
// ❌ Anti-pattern
class MyResource extends \Filament\Resources\Resource {}

class UserResource extends XotBaseResource
{
    // ...
}
```

#### ❌ DON'T - Non estendere mai direttamente la classe base di Filament

```php
// NON FARE MAI QUESTO
use Filament\Resources\Resource;

class UserResource extends Resource
{
    // ...
}
```

### 2. Definizione Form Schema

#### ✅ DO - Utilizzare getFormSchema()

Tutte le risorse Filament devono implementare il metodo `getFormSchema()` che restituisce un array di componenti:

```php
public static function getFormSchema(): array
{
    return [
        TextInput::make('nome')->required(),
        TextInput::make('cognome')->required(),
        DatePicker::make('data_nascita'),
        // altri componenti...
    ];
}
```

## Regole per XotBaseEditRecord

### Implementazione Corretta

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Filament\Actions;

/**
 * Pagina di modifica per gli appuntamenti.
 * 
 * ✅ IMPLEMENTAZIONE CORRETTA: Estende XotBaseEditRecord
 * ✅ SEGUE IL PATTERN LARAXOT: Non estende EditRecord di Filament direttamente
 * ✅ DOCUMENTAZIONE AGGIORNATA: PHPDoc completo e chiaro
 * ✅ NO FORM: Il metodo form() è già implementato in XotBaseEditRecord
 * ✅ UTILIZZA getFormSchema(): Dalla risorsa AppointmentResource
 */
class EditAppointment extends XotBaseEditRecord
{
    protected static string $resource = AppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(), // ✅ NO ->label() hardcoded
        ];
    }
}
```

## Regole per XotBaseCreateRecord

### Implementazione Corretta

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

/**
 * Pagina di creazione per gli appuntamenti.
 * 
 * ✅ IMPLEMENTAZIONE CORRETTA: Estende XotBaseCreateRecord
 * ✅ SEGUE IL PATTERN LARAXOT: Non estende CreateRecord di Filament direttamente
 * ✅ DOCUMENTAZIONE AGGIORNATA: PHPDoc completo e chiaro
 * ✅ NO FORM: Il metodo form() è già implementato in XotBaseCreateRecord
 * ✅ UTILIZZA getFormSchema(): Dalla risorsa AppointmentResource
 */
class CreateAppointment extends XotBaseCreateRecord
{
    protected static string $resource = AppointmentResource::class;
}
```

## Esempi di Implementazione Corretta

### ReportResource.php - IMPLEMENTAZIONE CORRETTA
#### ❌ DON'T - Non utilizzare il metodo form()

```php
// NON FARE MAI QUESTO
public static function form(Form $form): Form
{
    return $form->schema([
        // componenti...
    ]);
}
```

### 3. Traduzioni e Label

#### ✅ DO - Utilizzare i file di traduzione

Non specificare le label direttamente nei componenti. Invece, definire le traduzioni nei file di lingua:

```php
// Componente senza label esplicita
TextInput::make('nome')->required()
```

Con corrispondenza nel file di traduzione:

```php
// resources/lang/it/nome-resource.php
return [
    'fields' => [
        'nome' => [
            'label' => 'Nome Utente',
            'tooltip' => 'Nome completo dell\'utente',
            'placeholder' => 'Inserisci il nome'
        ],
    ],
];
```

#### ❌ DON'T - Non utilizzare il metodo label() direttamente

```php
// NON FARE MAI QUESTO
TextInput::make('nome')
    ->label('Nome Utente')
    ->required()
```

## Struttura Completa di una Risorsa

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources;

use Modules\SaluteMo\Filament\Resources\ReportResource\Pages;
use Modules\<nome modulo>\Models\Report;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Forms;

/**
 * Risorsa Filament per i report.
 * 
 * ✅ IMPLEMENTAZIONE CORRETTA: Estende XotBaseResource
 * ✅ SEGUE IL PATTERN LARAXOT: Non estende Resource di Filament direttamente
 * ✅ IMPLEMENTA getFormSchema(): Metodo obbligatorio per XotBaseResource
 * ✅ DOCUMENTAZIONE AGGIORNATA: PHPDoc completo e chiaro
 * ✅ NO NAVIGATION ICON: Non definito perché gestito da XotBaseResource
 * ✅ NO FORM/TABLE: Metodi gestiti automaticamente da XotBaseResource
 * ✅ NO LABEL HARDCODED: Tutte le label gestite da LangServiceProvider
 */
class ReportResource extends XotBaseResource
{
    protected static ?string $model = Report::class;

    /**
     * Get the form schema.
     *
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public static function getFormSchema(): array
    {
        return [
            // ✅ NO ->label(): Tutte le label gestite da LangServiceProvider
            Forms\Components\Select::make('patient_id')
                ->relationship('patient', 'name')
                ->required(),
            
            Forms\Components\Toggle::make('has_mouth_or_teeth_pain'),
            Forms\Components\Toggle::make('smokes'),
            // Altri campi reali del modello Report...
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
namespace Modules\Brain\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Brain\Models\Socio;

class SocioResource extends XotBaseResource
{
    protected static ?string $model = Socio::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-user';
    
    protected static ?int $navigationSort = 1;
    
    // Form Schema - CORRETTO ✅
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('cognome')
                ->required()
                ->maxLength(255),
            
            TextInput::make('nome')
                ->required()
                ->maxLength(255),
            
            DatePicker::make('data_nascita'),
            
            TextInput::make('email')
                ->email()
                ->required(),
            
            Select::make('id_stato_socio')
                ->relationship('statoSocio', 'descrizione'),
            
            Toggle::make('is_attivo'),
        ];
    }
    
    // Table - CORRETTO ✅
    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('cognome')
                    ->sortable()
                    ->searchable(),
                
                TextColumn::make('nome')
                    ->sortable()
                    ->searchable(),
                
                TextColumn::make('sezione.descrizione'),
                
                TextColumn::make('statoSocio.descrizione'),
                
                BooleanColumn::make('is_attivo'),
            ])
            ->filters([
                SelectFilter::make('id_stato_socio')
                    ->relationship('statoSocio', 'descrizione'),
                
                SelectFilter::make('id_sezione')
                    ->relationship('sezione', 'descrizione'),
            ])
            ->actions([
                Action::make('view'),
                Action::make('edit'),
                Action::make('delete'),
            ]);
    }
    
    // Query Scope - CORRETTO ✅
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['sezione', 'statoSocio']);
    }
}
```

## Checklist di Conformità

Prima di considerare completa una risorsa Filament, verificare:

### ✅ Estensione Base
- [ ] Estende `XotBaseResource` invece di `Resource`
- [ ] Estende `XotBaseListRecords` invece di `ListRecords`
- [ ] Estende `XotBaseEditRecord` invece di `EditRecord`
- [ ] Estende `XotBaseCreateRecord` invece di `CreateRecord`

### ✅ Traduzioni
- [ ] NESSUN `->label()` hardcoded nei form components
- [ ] NESSUN `->placeholder()` hardcoded
- [ ] NESSUN `->helperText()` hardcoded
- [ ] Tutte le traduzioni nei file di lingua del modulo

### ✅ Campi Reali
- [ ] Tutti i campi della tabella esistono nel modello
- [ ] Tutti i campi del form esistono nel modello
- [ ] Campi presi dalla migrazione, non inventati
- [ ] Verificato con `$fillable` del modello

### ✅ Metodi Obbligatori
- [ ] `getFormSchema()` implementato in XotBaseResource
- [ ] `getTableColumns()` implementato in XotBaseListRecords
- [ ] Nessun override di metodi già gestiti da XotBaseResource

### ✅ Documentazione
- [ ] PHPDoc completo per tutte le classi e metodi
- [ ] Commenti che spiegano le scelte implementative
- [ ] Documentazione aggiornata nel modulo e nella root

## Violazioni Gravi da Evitare

1. **Estendere classi Filament direttamente**
2. **Usare `->label()` nei form components**
3. **Inventare campi che non esistono nel modello**
4. **Definire `navigationIcon` se si estende `XotBaseResource`**
5. **Non implementare metodi obbligatori come `getFormSchema()`**

## File Corretti

### ✅ ReportResource
- `ReportResource.php` - Estende `XotBaseResource`
- `ListReports.php` - Estende `XotBaseListRecords`
- `CreateReport.php` - Estende `XotBaseCreateRecord`
- `EditReport.php` - Estende `XotBaseEditRecord`

### ✅ AppointmentResource
- `AppointmentResource.php` - Estende `XotBaseResource`
- `ListAppointments.php` - Estende `XotBaseListRecords`
- `CreateAppointment.php` - Estende `XotBaseCreateRecord`
- `EditAppointment.php` - Estende `XotBaseEditRecord`

*Ultimo aggiornamento: gennaio 2025 - Correzioni per campi reali e rimozione label hardcoded*
1. **ESATTA SEQUENZA** di campi da mantenere:
   - **Dati anagrafici**: titolo_id, nome, cognome, sesso, data_nascita, etc.
   - **Classificazione professionale**: tipologia_cliente_id, stato_id, etc.
   - **Informazioni professionali**: data_iscrizione_albo, is_socio_andi, etc.
   - **Indirizzo e contatti**: via, cap, regione_id, provincia_id, etc.
   - **Dati bancari**: iban, intestatario, banca, filiale
   - **Modalità di ricezione**: Lista di modalità selezionabili
## Struttura delle Traduzioni

### File di Traduzione Completo

```php
// resources/lang/it/socio-resource.php
return [
    'label' => 'Socio',
    'plural_label' => 'Soci',
    'navigation_group' => 'Anagrafiche',
    'navigation_icon' => 'heroicon-o-user',
    'navigation_sort' => 1,
    'description' => 'Gestione completa dei soci',
    
    'fields' => [
        'id_socio' => [
            'label' => 'ID Socio',
            'tooltip' => 'Identificativo univoco del socio'
        ],
        'cognome' => [
            'label' => 'Cognome',
            'tooltip' => 'Cognome del socio',
            'placeholder' => 'Inserisci il cognome'
        ],
        'nome' => [
            'label' => 'Nome',
            'tooltip' => 'Nome del socio',
            'placeholder' => 'Inserisci il nome'
        ],
        'email' => [
            'label' => 'Email',
            'tooltip' => 'Indirizzo email principale del socio',
            'placeholder' => 'esempio@dominio.it'
        ],
        'data_nascita' => [
            'label' => 'Data di nascita',
            'tooltip' => 'Data di nascita del socio'
        ],
        'id_stato_socio' => [
            'label' => 'Stato Socio',
            'tooltip' => 'Stato attuale del socio'
        ],
        'id_sezione' => [
            'label' => 'Sezione',
            'tooltip' => 'Sezione di appartenenza del socio'
        ],
        'is_attivo' => [
            'label' => 'Attivo',
            'tooltip' => 'Indica se il socio è attualmente attivo'
        ]
    ],
    
    'actions' => [
        'create' => [
            'label' => 'Nuovo Socio',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
            'tooltip' => 'Crea un nuovo profilo socio'
        ],
        'edit' => [
            'label' => 'Modifica',
            'icon' => 'heroicon-o-pencil',
            'color' => 'primary',
            'tooltip' => 'Modifica i dati del socio'
        ],
        'view' => [
            'label' => 'Visualizza',
            'icon' => 'heroicon-o-eye',
            'color' => 'secondary',
            'tooltip' => 'Visualizza i dettagli del socio'
        ],
        'delete' => [
            'label' => 'Elimina',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'tooltip' => 'Rimuovi questo socio dal sistema'
        ]
    ],
    
    'sections' => [
        'personal_data' => [
            'label' => 'Dati Personali',
            'tooltip' => 'Informazioni anagrafiche di base'
        ],
        'contact_info' => [
            'label' => 'Contatti',
            'tooltip' => 'Informazioni di contatto del socio'
        ],
        'membership' => [
            'label' => 'Iscrizione',
            'tooltip' => 'Dettagli relativi all\'iscrizione'
        ]
    ],
    
    'messages' => [
        'created' => 'Socio creato con successo',
        'updated' => 'Socio aggiornato con successo',
        'deleted' => 'Socio eliminato con successo'
    ],
    
    'table' => [
        'empty_text' => 'Nessun socio trovato',
        'search_prompt' => 'Cerca soci...'
    ]
];
```

## Organizzazione dei Form

### Raggruppamento Logico

Utilizzare componenti come `Section`, `Tabs` e `Fieldset` per organizzare logicamente i campi:

```php
public static function getFormSchema(): array
{
    return [
        Forms\Components\Tabs::make('Tabs')
            ->tabs([
                Forms\Components\Tabs\Tab::make(trans('socio-resource.sections.personal_data.label'))
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextInput::make('cognome')->required(),
                        TextInput::make('nome')->required(),
                        DatePicker::make('data_nascita'),
                    ]),
                
                Forms\Components\Tabs\Tab::make(trans('socio-resource.sections.contact_info.label'))
                    ->icon('heroicon-o-mail')
                    ->schema([
                        TextInput::make('email')->email(),
                        TextInput::make('telefono'),
                        TextInput::make('cellulare'),
                    ]),
            ]),
    ];
}
```

### Colonne Responsive

Utilizzare Grid e Columns per layout responsivi:

```php
Forms\Components\Section::make(trans('socio-resource.sections.personal_data.label'))
    ->schema([
        Forms\Components\Grid::make()
            ->schema([
                TextInput::make('cognome')
                    ->required()
                    ->columnSpan(1),
                
                TextInput::make('nome')
                    ->required()
                    ->columnSpan(1),
            ])
            ->columns(2),
            
        DatePicker::make('data_nascita')
            ->columnSpan('full'),
    ])
```

## Validazione

### Regole di Validazione

Applicare regole di validazione direttamente sui componenti:

```php
TextInput::make('email')
    ->email()
    ->required()
    ->unique(table: 'socio', column: 'email', ignorable: fn ($record) => $record)
    ->regex('/^.+@.+\..+$/')
    ->maxLength(255)
```

### Validazione Personalizzata

Per validazioni più complesse, utilizzare i metodi rules() o rule():

```php
DatePicker::make('data_nascita')
    ->rules([
        'required', 
        'date', 
        'before:today'
    ])
    
TextInput::make('codice_fiscale')
    ->rule(fn() => function (string $attribute, $value, \Closure $fail) {
        if (!Str::isValidCF($value)) {
            $fail("Il codice fiscale non è valido.");
        }
    })
```

## Relazioni

### Relazioni Base

```php
Select::make('id_sezione')
    ->relationship('sezione', 'descrizione')
    ->searchable()
    ->preload()
```

### Relazioni Multiple

```php
CheckboxList::make('convenzioni')
    ->relationship('convenzioni', 'descrizione')
    ->columns(2)
    ->searchable()
```

## Filtri e Azioni Personalizzate

### Filtri Avanzati

```php
SelectFilter::make('sezione')
    ->relationship('sezione', 'descrizione')
    ->multiple()
    ->preload()

Filter::make('iscritto_da')
    ->form([
        Forms\Components\DatePicker::make('created_from'),
        Forms\Components\DatePicker::make('created_until'),
    ])
    ->query(function (Builder $query, array $data): Builder {
        return $query
            ->when(
                $data['created_from'],
                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
            )
            ->when(
                $data['created_until'],
                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
            );
    })
```

### Azioni Personalizzate

```php
Action::make('invia_email')
    ->requiresConfirmation()
    ->form([
        Forms\Components\TextInput::make('subject')
            ->required(),
        Forms\Components\Textarea::make('message')
            ->required(),
    ])
    ->action(function (Socio $record, array $data): void {
        // Implementazione dell'invio email
    })
```

## Uso delle funzioni Safe\*

Le funzioni `Safe\*` sono una libreria che fornisce versioni 'sicure' delle funzioni native di PHP, che lanciano eccezioni invece di restituire `false` in caso di errore. Questo approccio è particolarmente utile in contesti dove la gestione degli errori è cruciale.

### Quando usare Safe\*
- Quando si vuole gestire esplicitamente gli errori
- Quando si vuole evitare controlli multipli su `false`
- Quando si vuole migliorare la leggibilità del codice

### Esempio di utilizzo
```php
use function Safe\file_get_contents;

try {
    $content = file_get_contents('file.txt');
} catch (\Safe\Exceptions\FilesystemException $e) {
    // Gestione dell'errore
}
```

### Alternative
Se non si vuole usare `Safe\*`, si possono usare le funzioni native di PHP con controlli espliciti:
```php
$content = file_get_contents('file.txt');
if ($content === false) {
    // Gestione dell'errore
}
```

## Ottimizzazione delle Prestazioni

### Eager Loading

Utilizzare sempre l'eager loading per le relazioni utilizzate nelle tabelle:

```php
public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()
        ->with([
            'sezione', 
            'statoSocio', 
            'convenzioni',
        ]);
}
```

### Paginazione e Lazy Loading

Configurare la paginazione appropriata:

```php
public static function table(Table $table): Table
{
    return $table
        // ...
        ->defaultPaginationPageOption(25)
        ->paginated([10, 25, 50, 100]);
}
```

## Troubleshooting
- Se compare un errore di override di proprietà statiche, rimuovere la proprietà dal resource e centralizzare nella base
- Se le traduzioni non vengono applicate, controllare la struttura dei file lang e l'assenza di ->label() hardcoded

## Collegamenti
- [Filament Docs](https://filamentphp.com/docs)
- [Best practices moduli riutilizzabili](../module-documentation-neutrality.md)
- [Ereditarietà modelli](../model-inheritance-best-practices.md)


### Problema: Form non visualizzato correttamente

**Soluzione:** Assicurarsi di utilizzare `getFormSchema()` invece di `form()` e controllare che tutti i componenti siano configurati correttamente.

### Problema: Label non tradotte

**Soluzione:** Verificare che:
1. Non si stia utilizzando `->label()` direttamente sui componenti
2. I file di traduzione siano nella posizione corretta e seguano la struttura espansa
3. Le chiavi dei campi nel form corrispondano esattamente alle chiavi dei campi nel file di traduzione

### Problema: Relazioni non caricate correttamente

**Soluzione:** Verificare che:
1. I nomi delle relazioni e delle colonne siano corretti
2. Le relazioni siano definite correttamente nel modello
3. Sia utilizzato l'eager loading appropriato in `getEloquentQuery()`

## Esempi Pratici

### Risorsa Base

```php
<?php

namespace Modules\Brain\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Brain\Models\Socio;

class SocioResource extends XotBaseResource
{
    protected static ?string $model = Socio::class;
    
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('nome')->required(),
            TextInput::make('cognome')->required(),
        ];
    }
    
    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('nome'),
                TextColumn::make('cognome'),
            ]);
    }
}
```

### Risorsa Avanzata

Consulta l'esempio completo all'inizio di questo documento per una implementazione avanzata.

## Riferimenti

- [Documentazione Filament](https://filamentphp.com/docs)
- [Documentazione XotBaseResource](/var/www/html/exa/base_orisbroker_fila3/laravel/Modules/Xot/docs/resource.md)
- [Best Practices Laraxot](/var/www/html/exa/base_orisbroker_fila3/laravel/Modules/Xot/docs/best-practices.md)

## Regole per Widget Filament: Path View e Localizzazione

- Tutti i widget Filament devono avere la view in `modulo::filament.widgets.nome-widget`.
- Non usare mai `modulo::widgets.nome-widget` o altri path non standard.
- Non usare mai ->label(), ->placeholder(), __() o trans() nei form component (TextInput, Select, ecc).
- La localizzazione è centralizzata tramite LangServiceProvider e i file di lingua del modulo.
- Le chiavi dei campi devono corrispondere a quelle dei file di lingua.

### Esempio corretto
```php
protected static string $view = 'saluteora::filament.widgets.find-doctor-and-appointment';
TextInput::make('location')->required()
```

### Esempio errato
```php
protected static string $view = 'saluteora::widgets.find-doctor-and-appointment';
TextInput::make('location')->label(__('modulo::campo.label'))
```

**Motivazione:** coerenza, manutenzione, override, policy di qualità.

> Aggiornare sempre anche i file .mdc in .windsurf/rules e .cursor/rules

**Vedi anche:** [filament-best-practices.mdc](../../../.windsurf/rules/filament-best-practices.mdc)

## Regole di Ereditarietà: Trait e Interfacce

- Non replicare mai trait, interfacce o logica già presenti nella classe base che si estende (es. XotBaseWidget).
- Studiare sempre la classe base prima di estendere.
- Se serve estendere il comportamento, usare override o metodi custom, non duplicare trait/interfacce.

### Esempio errato
```php
class FindDoctorAndAppointmentWidget extends XotBaseWidget implements HasForms
{
    use InteractsWithForms; // ERRORE: già presente in XotBaseWidget
}
```

### Esempio corretto
```php
class FindDoctorAndAppointmentWidget extends XotBaseWidget
{
    // NIENTE implements HasForms, NIENTE use InteractsWithForms
}
```

**Motivazione:** DRY, KISS, manutenzione, coerenza, evitare conflitti e ridondanza.

> Aggiornare sempre anche i file .mdc in .windsurf/rules e .cursor/rules

**Vedi anche:** [filament-best-practices.mdc](../../../.windsurf/rules/filament-best-practices.mdc)

## Policy DRY su Disponibilità e Prenotazione

La disponibilità e la prenotazione sono sempre rappresentate da record Appointment con type=status specifici (es. type=availability, status=available). Non vanno mai create tabelle custom per la disponibilità. Tutte le logiche di calendario, slot, prenotazione e approvazione sono centralizzate su Appointment.

### Esempio di query DRY
```php
Appointment::where('doctor_id', $doctorId)
    ->where('type', AppointmentTypeEnum::AVAILABILITY)
    ->where('status', AppointmentStatusEnum::AVAILABLE)
    ->get();
```

### Motivazione filosofica, politica, zen
- Un solo punto di verità: nessuna duplicazione, nessun lock-in
- DRY, KISS, serenità del codice
- Refactoring sicuro, massima estendibilità

