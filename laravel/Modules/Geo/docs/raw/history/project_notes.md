# Project Notes

## Architettura del Progetto

### Service Provider Requirements

#### Module Service Providers
- Tutti i ModuleServiceProvider devono estendere `XotBaseServiceProvider`
- Devono avere la proprietà pubblica `$name` che corrisponde al nome del modulo
- Devono definire le proprietà protette `$module_dir` e `$module_ns`
- Esempio:
```php
class PrenotazioniServiceProvider extends XotBaseServiceProvider
{
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
    public string $name = 'Prenotazioni'; // Required!
}
```

### Form Schema Best Practices

#### Regole Obbligatorie per getFormSchema()
1. Il metodo DEVE essere dichiarato come `public static function getFormSchema(): array`
2. DEVE restituire un array associativo di campi form
3. Ogni campo DEVE avere una chiave stringa univoca che corrisponde al nome della colonna nel database
4. Tutti i campi DEVONO essere istanze di `Filament\Forms\Components`
5. NON utilizzare mai ->label() poiché le etichette sono gestite dal LangServiceProvider

#### Validazione dei Campi
1. Campi Numerici:
   - SEMPRE utilizzare `->numeric()`
   - Specificare `->min()` e `->max()` quando applicabile
   - Per importi monetari, usare `->numeric()->mask(fn (TextInput\Mask $mask) => $mask->money())`

2. Campi di Testo:
   - SEMPRE specificare `->maxLength()`
   - Per campi obbligatori, usare `->required()`
   - Per email, usare `->email()`
   - Per URL, usare `->url()`

3. Campi Select:
   - SEMPRE utilizzare `->options()` con array associativo
   - Per relazioni, usare `->relationship()`
   - Specificare `->searchable()` per liste lunghe

4. Campi Booleani:
   - SEMPRE usare `Toggle::make()` invece di `Checkbox::make()`
   - Specificare `->default(false)` quando appropriato

5. Campi Password:
   - SEMPRE utilizzare `->password()`
   - Aggiungere `->dehydrated(false)` per campi di conferma

#### Layout
1. Utilizzare `->columnSpan()` per il layout multi-colonna
2. NON utilizzare `columns()` direttamente sull'array di ritorno
3. Raggruppare campi correlati con `Forms\Components\Group`
4. Utilizzare `Forms\Components\Section` per sezioni logiche

#### Esempio Completo e Corretto:
```php
public static function getFormSchema(): array
{
    return [
        Forms\Components\Group::make()
            ->schema([
                Forms\Components\Section::make('Informazioni Base')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('amount')
                            ->numeric()
                            ->required()
                            ->min(0)
                            ->mask(fn (TextInput\Mask $mask) => $mask->money()),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Configurazione')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive'
                            ])
                            ->required(),
                            
                        Forms\Components\Toggle::make('is_featured')
                            ->default(false),
                            
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->required(),
                    ])->columns(2),
            ]),
            
        Forms\Components\Section::make('Contenuto')
            ->schema([
                Forms\Components\RichEditor::make('description')
                    ->columnSpan('full')
                    ->maxLength(1000),
                    
                Forms\Components\FileUpload::make('attachment')
                    ->directory('attachments')
                    ->maxSize(5120)
                    ->acceptedFileTypes(['application/pdf']),
            ])->columnSpan('full'),
    ];
}
```

#### Errori Comuni da Evitare
❌ NON FARE:
```php
public static function getFormSchema(): array
{
    return [
        // ❌ Mai usare ->label()
        Forms\Components\TextInput::make('name')
            ->label('Nome Utente'),
            
        // ❌ Mai dimenticare ->maxLength() per campi testo
        Forms\Components\TextInput::make('description'),
            
        // ❌ Mai usare Checkbox per campi booleani
        Forms\Components\Checkbox::make('is_active'),
            
        // ❌ Mai dimenticare ->numeric() per campi numerici
        Forms\Components\TextInput::make('price'),
    ];
}
```

## Struttura dei Moduli

### Organizzazione dei File
- Ogni modulo **DEVE** avere il proprio `composer.json`
- Il `composer.json` definisce:
  1. Namespace del modulo
  2. Struttura delle directory
  3. Dipendenze
  4. Autoload paths

### Lettura del composer.json
- Il composer.json è il **punto di verità** per la struttura del modulo
- **ERRORE COMUNE**: Non leggere attentamente la sezione "autoload"
- La sezione "autoload" definisce il mapping tra namespace e directory

Esempio di composer.json:
```json
{
    "autoload": {
        "psr-4": {
            "Modules\\Setting\\": "app/",
            "Modules\\Setting\\Database\\Factories\\": "database/factories/",
            "Modules\\Setting\\Database\\Seeders\\": "database/seeders/"
        }
    }
}
```

#### Interpretazione Corretta
1. `"Modules\\Setting\\": "app/"` significa:
   - Il namespace base è `Modules\Setting`
   - La directory `app/` è la radice per questo namespace
   - I file in `app/Filament/Resources` avranno namespace `Modules\Setting\Filament\Resources`
   - ❌ NON `Modules\Setting\App\Filament\Resources`

2. Solo i namespace speciali hanno percorsi dedicati:
   - `Modules\Setting\Database\Factories`: per i factory
   - `Modules\Setting\Database\Seeders`: per i seeder

#### Esempi di Namespace Corretti vs Errati

✅ Corretto:
```php
namespace Modules\Setting\Filament\Resources;  // per file in app/Filament/Resources/
namespace Modules\Setting\Models;              // per file in app/Models/
namespace Modules\Setting\Providers;           // per file in app/Providers/
```

❌ Errato:
```php
namespace Modules\Setting\App\Filament\Resources;  // ERRATO: 'App' non fa parte del namespace
namespace Modules\Setting\App\Models;              // ERRATO: 'App' non fa parte del namespace
namespace Modules\Setting\App\Providers;           // ERRATO: 'App' non fa parte del namespace
```

### Regole per i Namespace
1. **SEMPRE** consultare il composer.json del modulo prima di creare o modificare file
2. Il namespace base del modulo è definito nella sezione "psr-4" del composer.json
3. La directory `app/` è trasparente nel namespace
4. Non aggiungere "App" al namespace anche se il file si trova nella directory `app/`

### Struttura Standard dei Moduli
```
Modules/
└── NomeModulo/
    ├── app/
    │   ├── Http/
    │   │   ├── Controllers/
    │   │   └── Middleware/
    │   ├── Models/
    │   ├── Providers/
    │   ├── Filament/
    │   └── Filament/
    │       └── Resources/
    ├── config/
    ├── database/
    ├── resources/
    ├── routes/
    ├── composer.json
    └── module.json
```

### Regole Importanti
1. I Resources Filament **DEVONO** essere posizionati in:
   - ✅ `Modules/NomeModulo/app/Filament/Resources/`
   - ❌ NON in `Modules/NomeModulo/Filament/Resources/`

2. Prima di creare o modificare file:
   - Consultare SEMPRE il `composer.json` del modulo
   - Verificare il namespace corretto
   - Rispettare la struttura delle directory definita

Esempio di composer.json:
```json
{
    "name": "modules/setting",
    "description": "Setting module",
    "autoload": {
        "psr-4": {
            "Modules\\Setting\\": "app/",
            "Modules\\Setting\\Database\\Factories\\": "database/factories/",
            "Modules\\Setting\\Database\\Seeders\\": "database/seeders/"
        }
    }
}
```

### Namespace nei Moduli

#### Regole Fondamentali
1. Il namespace base di ogni modulo è `Modules\NomeModulo`
2. La directory `app/` è **trasparente** nel namespace
3. **MAI** includere "App" nel namespace anche se il file si trova in `app/`
4. Consultare **SEMPRE** il composer.json del modulo prima di creare o modificare file

#### Struttura del composer.json
```json
{
    "name": "modules/setting",
    "description": "Setting module",
    "autoload": {
        "psr-4": {
            "Modules\\Setting\\": "app/",
            "Modules\\Setting\\Database\\Factories\\": "database/factories/",
            "Modules\\Setting\\Database\\Seeders\\": "database/seeders/"
        }
    }
}
```

#### Esempi di Namespace Corretti
✅ File in `app/Models/User.php`:
```php
namespace Modules\Setting\Models;
```

✅ File in `app/Http/Controllers/SettingController.php`:
```php
namespace Modules\Setting\Http\Controllers;
```

✅ File in `app/Filament/Resources/UserResource.php`:
```php
namespace Modules\Setting\Filament\Resources;
```

#### Esempi di Namespace ERRATI
❌ **NON** includere "App" nel namespace:
```php
// ERRATO: non includere "App"
namespace Modules\Setting\App\Models;
namespace Modules\Setting\App\Controllers;
namespace Modules\Setting\App\Filament\Resources;
```

❌ **NON** usare percorsi errati:
```php
// ERRATO: namespace non corrisponde alla struttura delle directory
namespace Setting\Models;
namespace App\Modules\Setting\Models;
```

#### Regole per Casi Speciali
1. **Factory**:
   - Directory: `database/factories/`
   - Namespace: `Modules\Setting\Database\Factories`

2. **Seeder**:
   - Directory: `database/seeders/`
   - Namespace: `Modules\Setting\Database\Seeders`

3. **Test**:
   - Directory: `tests/`
   - Namespace: `Modules\Setting\Tests`

#### Checklist per i Namespace
- [ ] Verificato il composer.json del modulo
- [ ] Namespace inizia con `Modules\NomeModulo`
- [ ] NON include "App" nel namespace
- [ ] Corrisponde alla struttura delle directory
- [ ] Segue le convenzioni PSR-4

### Filament Framework

### XotBaseResource
- Le classi che estendono `XotBaseResource` **DEVONO** implementare il metodo astratto `getFormSchema()`
- Non implementare questo metodo renderà la classe astratta e causerà errori
- Il metodo deve restituire un array associativo di campi form
- Utilizzare `columnSpan()` (con la S maiuscola) per il layout multi-colonna
- Non utilizzare `columns()` direttamente sull'array di ritorno
- **IMPORTANTE**: Non utilizzare ->label() poiché le etichette vengono gestite automaticamente dal LangServiceProvider

#### Implementazione di getFormSchema()
1. Il metodo DEVE essere dichiarato come `public static`
2. DEVE restituire `array`
3. Ogni campo DEVE avere una chiave stringa univoca
4. I campi DEVONO essere istanze di `Filament\Forms\Components`
5. Per i campi numerici, utilizzare SEMPRE `->numeric()`
6. Per i campi obbligatori, utilizzare SEMPRE `->required()`
7. Specificare SEMPRE `->maxLength()` per i campi di testo
8. Per i campi select, utilizzare SEMPRE `->options()` con array associativo
9. Per i campi booleani, utilizzare `Toggle::make()` invece di `Checkbox::make()`
10. Per i campi password, utilizzare SEMPRE `->password()`

Esempio completo:
```php
public static function getFormSchema(): array
{
    return [
        'id' => Forms\Components\TextInput::make('id')
            ->disabled(),
        
        'name' => Forms\Components\TextInput::make('name')
            ->required()
            ->maxLength(255),
        
        'amount' => Forms\Components\TextInput::make('amount')
            ->numeric()
            ->required(),
        
        'status' => Forms\Components\Select::make('status')
            ->options([
                'active' => 'Active',
                'inactive' => 'Inactive'
            ])
            ->required(),
        
        'is_featured' => Forms\Components\Toggle::make('is_featured')
            ->default(false),
        
        'description' => Forms\Components\Textarea::make('description')
            ->columnSpan('full')
            ->maxLength(1000)
    ];
}
```

### XotBaseListRecords e Pages

#### Struttura delle Pages
- Ogni XotBaseResource ha delle Pages associate
- Le Pages si trovano in una sottodirectory `Pages` del Resource
- Il namespace delle Pages segue il namespace del Resource

Esempio:
```
Resource: Modules\Setting\Filament\Resources\DatabaseConnectionResource
Pages: Modules\Setting\Filament\Resources\DatabaseConnectionResource\Pages\*
```

#### XotBaseListRecords
- Le classi che estendono `XotBaseListRecords` **DEVONO** implementare:
  1. `getListTableColumns()`: **OBBLIGATORIO**
  2. `getTableFilters()`: opzionale
  3. `getTableActions()`: opzionale
  4. `getTableBulkActions()`: opzionale
  5. `getTableHeaderActions()`: opzionale

##### getListTableColumns()
- **DEVE** restituire un array con chiavi stringa
- Ogni chiave **DEVE** corrispondere a un campo del modello
- **NON** utilizzare `->label()` (gestito dal LangServiceProvider)
- Per campi numerici, utilizzare `->numeric()->sortable()`
- Per campi di testo, utilizzare `->searchable()` se necessario

Esempio corretto:
```php
public function getListTableColumns(): array
{
    return [
        'name' => Tables\Columns\TextColumn::make('name')
            ->searchable(),
            
        'driver' => Tables\Columns\TextColumn::make('driver')
            ->searchable(),
            
        'port' => Tables\Columns\TextColumn::make('port')
            ->numeric()
            ->sortable(),
            
        'status' => Tables\Columns\BadgeColumn::make('status')
            ->colors([
                'danger' => 'inactive',
                'warning' => 'testing',
                'success' => 'active',
            ]),
    ];
}
```

Esempio ERRATO:
```php
public function getListTableColumns(): array
{
    return [
        // ❌ NON usare ->label()
        'name' => Tables\Columns\TextColumn::make('name')
            ->label('Nome Connessione'),
            
        // ❌ NON dimenticare ->numeric() per campi numerici
        'port' => Tables\Columns\TextColumn::make('port'),
            
        // ❌ NON usare chiavi numeriche
        0 => Tables\Columns\TextColumn::make('status'),
    ];
}
```

#### Relazione tra Resource e Pages
1. Il Resource definisce:
   - Il modello (`$model`)
   - La struttura del form (`getFormSchema()`)
   - Le Pages disponibili (`getPages()`)

2. Ogni Page gestisce:
   - ListRecords: visualizzazione tabella e azioni
   - CreateRecord: creazione nuovi record
   - EditRecord: modifica record esistenti

3. La Page di tipo List **DEVE**:
   - Estendere `XotBaseListRecords`
   - Implementare `getListTableColumns()`
   - Definire la struttura della tabella
   - Gestire filtri e azioni

### Setting Module Resources

#### DatabaseConnectionResource
- Estende `XotBaseResource`
- Gestisce le connessioni database del sistema
- **DEVE** implementare `getFormSchema()` con i seguenti campi:
  1. `name`: Nome della connessione (required, max 255)
  2. `driver`: Tipo di database (mysql, pgsql, sqlite, sqlsrv)
  3. `host`: Host del database (required, max 255)
  4. `port`: Porta del database (numeric, required)
  5. `database`: Nome del database (required, max 255)
  6. `username`: Username (required, max 255)
  7. `password`: Password (required, password field)
  8. `charset`: Charset (default utf8mb4)
  9. `collation`: Collation (default utf8mb4_unicode_ci)
  10. `prefix`: Prefisso tabelle (optional)
  11. `strict`: Modalità strict (toggle)
  12. `engine`: Engine del database (InnoDB/MyISAM)
  13. `options`: Opzioni aggiuntive (key-value)
  14. `status`: Stato della connessione (active/inactive/testing)

- **DEVE** implementare le seguenti pagine:
  1. `ListDatabaseConnections`: Lista delle connessioni
  2. `CreateDatabaseConnection`: Creazione nuova connessione
  3. `EditDatabaseConnection`: Modifica connessione esistente

Esempio di implementazione:
```php
class DatabaseConnectionResource extends XotBaseResource
{
    protected static ?string $model = DatabaseConnection::class;
    protected static ?string $navigationIcon = 'heroicon-o-database';
    protected static ?string $navigationGroup = 'System';

    public static function getFormSchema(): array
    {
        return [
            'name' => Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            
            'driver' => Forms\Components\Select::make('driver')
                ->required()
                ->options([
                    'mysql' => 'MySQL',
                    'pgsql' => 'PostgreSQL',
                    'sqlite' => 'SQLite',
                    'sqlsrv' => 'SQL Server',
                ]),
            
            // ... altri campi richiesti
        ];
    }
}
```

### XotBaseListRecords
- Le classi che estendono `XotBaseListRecords` **DEVONO** implementare i seguenti metodi astratti:
  1. `getListTableColumns()`: **OBBLIGATORIO** - Definisce le colonne della tabella
  2. `getTableFilters()`: Definisce i filtri della tabella
  3. `getTableActions()`: Definisce le azioni per ogni riga
  4. `getTableBulkActions()`: Definisce le azioni bulk
  5. `getTableHeaderActions()`: Definisce le azioni nell'header della tabella

- **IMPORTANTE**: La mancata implementazione di `getListTableColumns()` causerà un errore di metodo astratto
- **IMPORTANTE**: Tutti questi metodi DEVONO restituire array con chiavi stringa
- **NON** utilizzare il metodo `table()` nelle classi che estendono `XotBaseListRecords`
- **IMPORTANTE**: Non utilizzare ->label() poiché le etichette vengono gestite automaticamente dal LangServiceProvider

Esempio corretto:
```php
class ListAssenzes extends XotBaseListRecords
{
    public function getListTableColumns(): array
    {
        return [
            'matricola' => Tables\Columns\TextColumn::make('matricola')
                ->sortable()
                ->searchable(),
            'cognome' => Tables\Columns\TextColumn::make('cognome')
                ->searchable(),
            'nome' => Tables\Columns\TextColumn::make('nome')
                ->searchable(),
            'giorni_assenza' => Tables\Columns\TextColumn::make('giorni_assenza')
                ->numeric()
                ->sortable(),
        ];
    }

    public function getTableFilters(): array
    {
        return [
            'status' => SelectFilter::make('status')
                ->options([
                    'active' => 'Active',
                    'inactive' => 'Inactive'
                ])
        ];
    }

    public function getTableActions(): array
    {
        return [
            'edit' => EditAction::make(),
            'delete' => DeleteAction::make()
        ];
    }

    public function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make()
        ];
    }

    public function getTableHeaderActions(): array
    {
        return [
            'create' => CreateAction::make()
        ];
    }
}
```

### Modulo Performance

#### Gestione Campi Numerici
- Utilizzare `TextInput::make()->numeric()` per tutti i campi numerici
- Aggiungere sempre `->sortable()` alle colonne numeriche nelle tabelle
- Esempio:
```php
// Nel form
'valore' => Forms\Components\TextInput::make('valore')
    ->numeric(),

// Nella tabella
'valore' => Tables\Columns\TextColumn::make('valore')
    ->numeric()
    ->sortable(),
```

#### Filtri Anno
- Utilizzare l'action `GetYearFilter` per i filtri basati sull'anno
- Impostare sempre un range di anni che parte da 3 anni fa fino all'anno corrente
- Esempio:
```php
public static function getTableFilters(): array
{
    return [
        'anno' => app(\Modules\Xot\Actions\Filament\Filter\GetYearFilter::class)
            ->execute('anno', intval(date('Y')) - 3, intval(date('Y'))),
    ];
}
```

#### Struttura Standard Resource
```php
class PerformanceResource extends XotBaseResource
{
    protected static ?string $model = PerformanceModel::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getFormSchema(): array
    {
        return [
            // Campi form con type hints
            'campo_numerico' => Forms\Components\TextInput::make('campo_numerico')
                ->numeric(),
        ];
    }

    public static function getListTableColumns(): array
    {
        return [
            // Colonne con type hints e sortable per i numerici
            'campo_numerico' => Tables\Columns\TextColumn::make('campo_numerico')
                ->numeric()
                ->sortable(),
        ];
    }

    public static function getTableFilters(): array
    {
        return [
            // Filtri standard
            'anno' => app(\Modules\Xot\Actions\Filament\Filter\GetYearFilter::class)
                ->execute('anno', intval(date('Y')) - 3, intval(date('Y'))),
        ];
    }

    public static function getTableActions(): array
    {
        return [
            'edit' => Tables\Actions\EditAction::make(),
        ];
    }

    public static function getTableBulkActions(): array
    {
        return [
            'delete' => Tables\Actions\DeleteBulkAction::make(),
        ];
    }

    public static function getTableHeaderActions(): array
    {
        return [
            'create' => CreateAction::make()
        ];
    }
}
```

### Errori Comuni da Evitare

#### Metodi Astratti Mancanti
1. **Resource senza getFormSchema**:
```php
// SBAGLIATO - Causerà errore
class OptionResource extends XotBaseResource
{
    // Manca getFormSchema()
}
```

2. **List Page senza getListTableColumns**:
```php
// SBAGLIATO - Causerà errore
class ListAssenzes extends XotBaseListRecords
{
    // Manca getListTableColumns()
}

// CORRETTO
class ListAssenzes extends XotBaseListRecords
{
    public function getListTableColumns(): array
    {
        return [
            'matricola' => Tables\Columns\TextColumn::make('matricola')
                ->sortable(),
        ];
    }
}
```

#### Errori di Sintassi e Convenzioni
1. **getListTableColumns senza chiavi stringa**:
```php
// SBAGLIATO
public function getListTableColumns(): array
{
    return [
        TextColumn::make('id')->sortable(),
        TextColumn::make('name')->searchable(),
    ];
}

// CORRETTO
public function getListTableColumns(): array
{
    return [
        'id' => TextColumn::make('id')->sortable(),
        'name' => TextColumn::make('name')->searchable(),
    ];
}
```

2. **Uso di ->label() (NON NECESSARIO)**:
```php
// SBAGLIATO - Le etichette sono gestite dal LangServiceProvider
TextColumn::make('name')->label('Nome Utente'),

// CORRETTO
TextColumn::make('name'),
```

3. **Uso di table() invece dei metodi separati**:
```php
// SBAGLIATO
public function table(Table $table): Table
{
    return $table->columns([...])
        ->filters([...])
        ->actions([...]);
}

// CORRETTO
// Utilizzare i metodi separati: getListTableColumns(), getTableFilters(), getTableActions()
```

### Filament Pages
- Tutte le pagine devono implementare il metodo statico `route()`
- Utilizzare le classi base appropriate per ogni tipo di pagina:
  - `Filament\Resources\Pages\EditRecord` per modifiche
  - `Filament\Resources\Pages\CreateRecord` per creazione
  - `Filament\Resources\Pages\ListRecords` per liste
- Esempio:
```php
class CustomPage extends Page
{
    public static function route(string $path): string
    {
        return parent::route($path);
    }
}

class EditMyRecord extends EditRecord
{
    protected static string $resource = MyResource::class;
}
```

## Best Practices

### Gestione del Codice
- Mantenere il codice commentato come riferimento storico
- Rinominare i file obsoleti con estensione `.old` invece di eliminarli
- Preferire metodi `private` a `protected` quando possibile
- Implementare il metodo `route()` nelle pagine Filament senza elaborazioni aggiuntive
- Utilizzare Spatie Laravel Data per la gestione dei DTO
- Preferire Spatie QueueableActions invece dei Services tradizionali
- Utilizzare strict_types per tutti i file PHP
- Utilizzare type hints per tutti i parametri e i ritorni dei metodi
- **NON** utilizzare ->label() - le etichette sono gestite dal LangServiceProvider

### Gestione File
```bash
# Rinomina file obsoleti
mv my-file.php my-file.php.old

# Mantenere versioni precedenti
mv config.php config.php.old
```

### Pattern di Codice
```php
class MyClass
{
    // Mantenere riferimenti storici
    /*
    public function oldMethod()
    {
        // Vecchia implementazione
    }
    */
    
    // Nuova implementazione
    private function newMethod(): void
    {
        // Implementazione corrente
    }
}
```

### Validazione
- Utilizzare Form Request per la validazione
- Implementare regole di validazione specifiche in classi dedicate
- Esempio:
```php
class MyFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
        ];
    }
}

```


### Gestione delle Dipendenze in composer.json dei Moduli

#### 1. Version Constraints (Vincoli di Versione)
- **Preferire Caret (`^`) o Tilde (`~`)**: Utilizzare `^1.0` (compatibile con 1.0.0 fino a <2.0.0) o `~1.2` (compatibile con 1.2.0 fino a <1.3.0) per dipendenze stabili. Questo assicura aggiornamenti di sicurezza e bugfix senza introdurre breaking changes.
- **Evitare Asterisco (`*`)**: L'uso di `"*"` (accetta qualsiasi versione) è sconsigliato in ambienti di produzione e in moduli, poiché può portare a incompatibilità inaspettate con nuove versioni del pacchetto. Usare solo in fase di sviluppo iniziale e mai in un commit definitivo.
- **`minimum-stability` e `prefer-stable`**: Impostare `minimum-stability: "dev"` e `prefer-stable: true` nel `composer.json` del modulo per permettere l'uso di dipendenze in sviluppo ma preferire versioni stabili quando disponibili.

#### 2. Path Repositories (Repository di Percorso)
- **Scopo**: I path repositories (`"type": "path"`) sono cruciali per lo sviluppo di moduli all'interno di un monorepo (come Laraxot). Permettono a Composer di localizzare i moduli dipendenti sul filesystem locale invece di scaricarli da Packagist.
- **Configurazione**: Vanno definiti nella sezione `"repositories"` del `composer.json` del modulo e puntano al percorso relativo degli altri moduli (es. `"../Xot"`).
- **Importanza**: Essenziali per testare le modifiche tra moduli senza dover pubblicare ogni aggiornamento.

#### 3. Risoluzione dei Conflitti in composer.json
- **Merge Selettivo**: In caso di conflitti, combinare il contenuto di entrambe le versioni (HEAD e incoming), privilegiando le definizioni più complete e funzionali.
- **Priorità Funzionale**: Dare priorità alle dipendenze (`require`), ai `repositories` e agli `autoload` che garantiscono la funzionalità del modulo.
- **Standard di Progetto**: Mantenere la coerenza con gli standard e le convenzioni di naming del progetto Laraxot.
- **Verifica**: Dopo la risoluzione del conflitto, eseguire sempre `composer update --no-dev` (o `composer install` se non ci sono nuove dipendenze) e i test (`vendor/bin/pest`) per assicurarsi che il modulo sia ancora funzionale.

## XotBaseServiceProvider

- Il `XotBaseServiceProvider` gestisce l'autoregistrazione degli SVG tramite il metodo `registerBladeIcons()`.
- Include metodi per registrare componenti Blade e Livewire, come `registerBladeComponents()` e `registerLivewireComponents()`.
- Questi metodi facilitano l'integrazione di componenti e risorse nel progetto.

## Registrazione Automatica degli SVG

- Gli SVG vengono registrati automaticamente tramite il metodo `registerBladeIcons()` nel `XotBaseServiceProvider`.
- Il percorso degli SVG è determinato utilizzando `module_path` con un percorso di fallback.
- Gli SVG sono configurati con un prefisso basato sul nome del modulo, consentendo di richiamarli utilizzando questo prefisso.

## Sistema di Traduzione

### Struttura delle Traduzioni
- Le traduzioni sono organizzate per modulo
- Ogni modulo ha la sua directory `lang` con file per lingua
- I file di traduzione seguono una struttura gerarchica

### Convenzioni per le Chiavi di Traduzione

#### 1. Navigazione
❌ Pattern Errato:
```php
// NON usare chiavi che finiscono con .navigation
'performance.navigation' => 'Performance',
'audit.navigation' => 'Audit',
```

✅ Pattern Corretto:
```php
// Usare il formato: filament.navigation.[module].[resource]
'filament.navigation.performance.dashboard' => 'Performance Dashboard',
'filament.navigation.performance.audit' => 'Performance Audit',
```

#### 2. Struttura Gerarchica
```
filament/
├── navigation/
│   ├── performance/
│   │   ├── dashboard
│   │   ├── audit
│   │   └── metrics
│   └── setting/
│       ├── database
│       └── cache
├── resources/
│   ├── performance/
│   │   ├── dashboard/
│   │   │   ├── title
│   │   │   └── description
│   │   └── audit/
│   │       ├── title
│   │       └── description
│   └── setting/
└── forms/
```

### Regole di Traduzione
1. **Navigazione**
   - Usare `filament.navigation.[module].[resource]`
   - MAI usare suffissi `.navigation`
   - Mantenere coerenza tra moduli

2. **Risorse**
   - Usare `filament.resources.[module].[resource].[field]`
   - Evitare traduzioni dirette nei form
   - Utilizzare il sistema di traduzione per label e descrizioni

3. **Form e Campi**
   - Usare `filament.forms.[module].[form].[field]`
   - Includere placeholder e help text
   - Mantenere coerenza nella terminologia

### Esempi di Correzione

❌ Prima:
```php
// resources/lang/it/performance.php
return [
    'dashboard.navigation' => 'Dashboard',
    'audit.navigation' => 'Audit',
    'metrics.navigation' => 'Metriche',
];
```

✅ Dopo:
```php
// resources/lang/it/filament.php
return [
    'navigation' => [
        'performance' => [
            'dashboard' => 'Dashboard',
            'audit' => 'Audit',
            'metrics' => 'Metriche',
        ],
    ],
];
```

### Best Practices
1. **Organizzazione**
   - Un file per modulo
   - Struttura gerarchica chiara
   - Nomi descrittivi e coerenti

2. **Manutenibilità**
   - Evitare duplicazione
   - Mantenere coerenza tra lingue
   - Documentare le chiavi di traduzione

3. **Automazione**
   - Utilizzare strumenti di validazione
   - Mantenere un registro delle traduzioni
   - Verificare la completezza delle traduzioni

## Linee guida per le traduzioni

- Gli array delle traduzioni devono essere scritti in forma breve (short array syntax).

## Icone SVG nei Moduli

### Struttura e Naming
1. **Posizione File**
   ```
   Modules/
   └── NomeModulo/
       └── resources/
           └── svg/
               └── nome-icona.svg
   ```

2. **Convenzioni di Naming**
   - Il nome del file SVG deve essere in kebab-case
   - Il nome da usare nelle traduzioni è: `[modulo-lowercase]-[nome-file]`
   - Esempio:
     ```
     File: Modules/Badge/resources/svg/card-icon.svg
     Nome da usare: badge-card-icon
     
     File: Modules/Pluto/resources/svg/pippo.svg
     Nome da usare: pluto-pippo
     ```

3. **Registrazione Automatica**
   - XotBaseServiceProvider registra automaticamente tutte le icone
   - Il prefisso del modulo (in lowercase) viene aggiunto automaticamente
   - Non è necessaria registrazione manuale

### Uso nelle Traduzioni
```php
// ✅ CORRETTO
return [
    'navigation' => [
        'group' => [
            'sistema' => [
                'label' => 'Sistema',
            ],
        ],
        'badge' => [
            'label' => 'Badge',
            'icon' => 'badge-card-icon', // Il prefisso 'badge-' è obbligatorio
        ],
    ],
];

// ❌ ERRATO
return [
    'navigation' => [
        'badge' => [
            'label' => 'Badge',
            'icon' => 'card-icon', // Manca il prefisso del modulo
        ],
    ],
];
```

### Requisiti SVG
1. **Struttura Base**
   ```svg
   <?xml version="1.0" encoding="UTF-8"?>
   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
       <title>Nome Icona</title>
       <desc>Descrizione per accessibilità</desc>
       <!-- contenuto svg -->
   </svg>
   ```

2. **Attributi Richiesti**
   - `viewBox="0 0 24 24"` per consistenza
   - `fill="none"` e `stroke="currentColor"` per supporto temi
   - `xmlns="http://www.w3.org/2000/svg"` per validità XML

3. **Accessibilità**
   - Tag `<title>` per tooltip
   - Tag `<desc>` per descrizione estesa
   - `aria-hidden="true"` se l'icona è decorativa

### Animazioni
1. **Stili CSS Incorporati**
   ```svg
   <svg>
       <style>
           .animated-element {
               transform-origin: center;
               transition: transform 0.3s ease;
           }
           svg:hover .animated-element {
               transform: scale(1.1);
           }
       </style>
       <path class="animated-element" d="..."/>
   </svg>
   ```

2. **Best Practices Animazioni**
   - Usare `transform-origin: center`
   - Transizioni fluide con `transition`
   - Evitare animazioni eccessive
   - Rispettare `prefers-reduced-motion`

### Esempio Completo
```svg
<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" 
     fill="none" stroke="currentColor">
    <style>
        .icon-element {
            transform-origin: center;
            transition: all 0.3s ease;
        }
        @media (prefers-reduced-motion: reduce) {
            .icon-element {
                transition: none;
            }
        }
        svg:hover .icon-element {
            transform: scale(1.1);
            stroke-width: 2.2;
        }
    </style>
    
    <title>Nome Icona</title>
    <desc>Descrizione dettagliata per screen reader</desc>
    
    <path class="icon-element" 
          d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
</svg>
```

### Checklist Implementazione
1. **File e Struttura**
   - [ ] SVG nella directory corretta del modulo
   - [ ] Nome file in kebab-case
   - [ ] Struttura XML valida

2. **Naming e Riferimenti**
   - [ ] Nome nelle traduzioni include prefisso modulo
   - [ ] Prefisso modulo in lowercase
   - [ ] Nome file corrisponde al riferimento

3. **Accessibilità e Stile**
   - [ ] Tag title e desc presenti
   - [ ] Supporto tema con currentColor
   - [ ] Animazioni rispettose dell'accessibilità

## Convenzioni di Naming per le Icone SVG
- Il nome del file SVG deve includere il prefisso del modulo in minuscolo.
- Esempio: all'interno del modulo Incentivi, il nome corretto per l'icona 'activity' è 'incentivi-activity'.

## Lezioni Apprese nella Gestione delle Traduzioni

### Errori Identificati
1. **Mancanza di Aggiornamenti**: Alcuni file non sono stati aggiornati perché non sono stati inclusi nella lista di file da modificare o perché non sono stati letti correttamente.
2. **Incoerenza nelle Icone**: Alcune icone di navigazione non erano state aggiornate per riflettere lo stile outline.
3. **Descrizioni Mancanti**: Alcuni campi nei file di traduzione mancano di descrizioni o placeholder, il che può causare confusione.

### Azioni Correttive
1. **Aggiornamento delle Icone**: Assicurarsi che tutte le icone di navigazione siano aggiornate allo stile outline.
2. **Aggiunta di Descrizioni**: Completare le descrizioni mancanti nei campi per migliorare la chiarezza.
3. **Documentazione degli Errori**: Scrivere appunti nel file `docs/project_notes.md` per evitare errori simili in futuro.

### Miglioramenti Futuri
- Implementare un sistema di controllo per verificare che tutte le traduzioni siano aggiornate e coerenti.
- Creare una checklist per la revisione delle traduzioni e delle icone prima del rilascio.
- Automatizzare il processo di verifica delle icone per garantire che siano sempre nello stile corretto.

{{ ... }}
