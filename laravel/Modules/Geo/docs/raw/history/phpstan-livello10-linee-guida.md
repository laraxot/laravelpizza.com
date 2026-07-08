# Linee Guida per PHPStan Livello 10 - Regole Comuni

Questo documento contiene le linee guida generali e le regole comuni per risolvere gli errori PHPStan di livello 10 in tutti i moduli del progetto Laraxot.

## Principi Fondamentali

### 1. Eliminazione del tipo `mixed`

Il tipo `mixed` è spesso la causa principale degli errori PHPStan a livello 10. **Dovrebbe essere utilizzato SOLO come ultima spiaggia**, quando non è possibile determinare un tipo più specifico. In tutti gli altri casi, è necessario sostituirlo con tipi più specifici.

**Prima**:
```php
public function handle(mixed $input): mixed
{
    // ...
}
```

**Dopo**:
```php
/**
 * @param string|array<string, mixed>|null $input
 * @return object|array<string, mixed>|null
 */
public function handle($input)
{
    // ...
}
```

#### Perché evitare `mixed`?

- Riduce drasticamente l'efficacia dell'analisi statica
- Aumenta il rischio di errori a runtime
- Nasconde potenziali problemi di tipo
- Rende il codice meno comprensibile
- Compromette l'autocompletamento nell'IDE

#### Alternative al tipo `mixed`

1. **Union Types**: Specificare tutti i possibili tipi che possono essere accettati/restituiti
   ```php
   public function process(string|int|array|null $data): bool|int
   ```

2. **Tipi generici**: Per collezioni e strutture dati complesse
   ```php
   /** @var array<string, int|string> */
   ```

3. **Template Types**: Per classi generiche
   ```php
   /**
    * @template T
    * @param T $value
    * @return T
    */
   ```

4. **Tipizzare per contratto**: Utilizzare interfacce quando si lavora con oggetti di tipi diversi
   ```php
   public function process(ProcessableInterface $item): void
   ```

5. **Strict Type Checking**: Utilizzare controlli di tipo espliciti prima di operare sui dati
   ```php
   if (is_string($value)) {
       // Operazioni sicure su stringhe
   } elseif (is_array($value)) {
       // Operazioni sicure su array
   }
   ```

Solo quando nessuna di queste soluzioni è fattibile, consider l'uso di `mixed` con annotazioni dettagliate che spiegano il motivo.

### 2. Tipizzazione Corretta degli Array

Gli array dovrebbero essere sempre tipizzati correttamente utilizzando le notazioni generiche nelle annotazioni PHPDoc.

**Prima**:
```php
/** @var array */
protected $items = [];
```

**Dopo**:
```php
/** @var array<string, mixed> */
protected $items = [];

// O meglio ancora, specificando completamente il tipo:
/** @var array<string, string|int|bool> */
protected $config = [];
```

### 3. Gestione delle Risorse PHP

Per le risorse PHP (file handles, connessioni di database, ecc.) che non possono essere tipizzate direttamente in PHP 8.x:

```php
/** @var resource|null */
private $fileHandle = null;
```

### 4. Pattern per Controller

Per i metodi dei controller, utilizzare tipi di ritorno espliciti che riflettono i possibili valori restituiti:

```php
public function show(string $id): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
{
    // ...
}
```

### 5. Gestione delle Proprietà Dinamiche

Per le proprietà dinamiche nei modelli, utilizzare annotazioni PHPDoc complete:

```php
/**
 * @property string $name Nome dell'entità
 * @property \Carbon\Carbon $created_at Data di creazione
 * @property-read string|null $full_name Nome completo generato
 */
class User extends Model
{
    // ...
}
```

### 6. Conversione Sicura da `mixed` a Tipi Scalari

Quando si lavora con valori `mixed` da convertire in tipi scalari (string, int, float, bool), utilizzare controlli di tipo prima della conversione:

```php
// Conversione sicura da mixed a string
/** @var mixed $value */
$stringValue = '';
if ($value !== null) {
    if (is_string($value)) {
        $stringValue = $value;
    } elseif (is_scalar($value)) {
        // Conversione sicura per valori scalari
        $stringValue = (string)$value;
    }
}

// Conversione sicura da mixed a int
/** @var mixed $value */
$intValue = null;
if ($value !== null) {
    if (is_int($value)) {
        $intValue = $value;
    } elseif (is_string($value) && is_numeric($value)) {
        $intValue = (int)$value;
    }
}

// Conversione sicura da mixed a float
/** @var mixed $value */
$floatValue = 0.0;
if ($value !== null) {
    if (is_float($value)) {
        $floatValue = $value;
    } elseif (is_int($value)) {
        $floatValue = (float)$value;
    } elseif (is_string($value) && is_numeric($value)) {
        $floatValue = (float)$value;
    }
}
```

### 7. Gestione Sicura di Array con Chiavi Miste

Quando si ottengono array da fonti esterne (es. funzioni Laravel che restituiscono array con chiavi miste):

```php
/** @var array<string|int, \Filament\Forms\Components\Component> $componentsWithMixedKeys */
$componentsWithMixedKeys = $this->getFormSchema();

// Tipizzazione corretta per passare a un metodo che richiede chiavi stringhe
/** @var array<string, \Filament\Forms\Components\Component> $componentsWithStringKeys */
$componentsWithStringKeys = [];
foreach ($componentsWithMixedKeys as $key => $component) {
    $stringKey = is_int($key) ? (string)$key : $key;
    $componentsWithStringKeys[$stringKey] = $component;
}
```

### 8. Tipi Unione con Null

Preferire la sintassi nullable (`?tipo`) per i tipi che possono essere null:

```php
public function findById(?int $id): ?User
{
    // ...
}
```

### 9. Parametri Variabili (Variadic)

Per i parametri variabili, specificare il tipo di ogni elemento nell'array risultante:

```php
/**
 * @param string ...$segments
 * @return string
 */
public function buildPath(string ...$segments): string
{
    // ...
}
```

### 10. Callback e Closure

Per i callback e le closure, utilizzare `callable` con specifiche di tipo dettagliate:

```php
/**
 * @param callable(string): bool $filter
 * @return array<int, string>
 */
public function filterItems(callable $filter): array
{
    // ...
}
```

## Miglioramenti alla Documentazione

### 1. Annotazioni di Ritorno Dettagliate

Utilizzare annotazioni `@return` dettagliate quando il tipo di ritorno è complesso:

```php
/**
 * @return array{id: int, name: string, meta: array<string, mixed>}
 */
public function getItemDetails(): array
{
    // ...
}
```

### 2. Riferimenti a Codice Esterno

Quando si utilizza codice esterno che potrebbe non essere ben tipizzato, considerare l'uso di stub PHPStan personalizzati o asserzioni di tipo:

```php
/** @var string $result */
$result = $externalLib->doSomething();
```

## Strumenti e Configurazione

### 1. Configurazione di PHPStan

Utilizzare un file di configurazione PHPStan che includa regole specifiche per il progetto:

```neon
parameters:
    level: 10
    paths:
        - Modules
    ignoreErrors:
        # Errori specifici da ignorare con giustificazione
        - '#Dynamic call to static method#'
    excludePaths:
        - */vendor/*
        - */Tests/*
```

### 2. Ignora Soppressioni

Quando è necessario sopprimere un errore PHPStan, includere sempre un commento che spieghi il motivo:

```php
/** @phpstan-ignore-next-line Impossibile tipizzare correttamente a causa dell'API esterna */
$result = $external->complicatedMethod();
```

## Errori PHPStan Livello 10 Comuni e Soluzioni

### 1. `Cannot cast mixed to string/int/float/bool`

Questo errore si verifica quando si tenta di convertire un valore mixed direttamente a un tipo scalare.

**Soluzione**: Utilizzare il pattern di controllo del tipo prima della conversione come mostrato nella sezione "Conversione Sicura da `mixed` a Tipi Scalari".

```php
// Errato - causa errore PHPStan
$strValue = (string)$mixedValue;

// Corretto - safe casting con controllo del tipo
if (is_string($mixedValue)) {
    $strValue = $mixedValue;
} elseif (is_scalar($mixedValue)) {
    $strValue = (string)$mixedValue;
} else {
    $strValue = ''; // valore predefinito sicuro
}
```

### 2. `Parameter #X $Y of method Z expects array<string, T>, array<V, T> given`

Errore comune quando si passano array con chiavi miste a metodi che richiedono array con chiavi stringa.

**Soluzione**: Utilizzare il pattern di conversione chiavi come mostrato nella sezione "Gestione Sicura di Array con Chiavi Miste".

### 3. `Method X returns mixed, but return statement returns Y`

Errore che si verifica quando una funzione restituisce un tipo specifico ma è dichiarata per restituire mixed.

**Soluzione**: Aggiungere annotazioni PHPDoc specifiche o modificare il tipo di ritorno della funzione:

```php
/**
 * @return string|null
 */
public function getName(): ?string
{
    // ...
}
```

## Processo di Lavoro Consigliato

1. Eseguire PHPStan a livello 10 per identificare gli errori
2. Raggruppare gli errori per tipo e modulo
3. Risolvere prima gli errori più comuni e semplici
4. Documentare ogni soluzione nella cartella `docs` del modulo corrispondente
5. Verificare che le soluzioni non introducano nuovi errori
6. Aggiornare questo documento con nuovi pattern e soluzioni trovate

La risoluzione degli errori PHPStan livello 10 porta a un codice più robusto, più facile da mantenere e meno soggetto a errori in fase di esecuzione. Seguendo queste linee guida, sarà possibile migliorare progressivamente la qualità del codice e raggiungere la conformità a PHPStan livello 10 in tutto il progetto.

## Casi Specifici per Filament

### 1. Documentazione del metodo `getInfolistSchema`

Il metodo `getInfolistSchema` è utilizzato nelle classi che estendono `XotBaseViewRecord` per definire lo schema di visualizzazione dei dettagli di un record. Questo metodo deve **sempre** restituire un array con chiavi di tipo stringa che rappresentano i componenti Filament da visualizzare.

La corretta documentazione di questo metodo deve essere:

```php
/**
 * Restituisce lo schema dell'infolist per la visualizzazione dei dettagli del record.
 *
 * @return array<string, \Filament\Infolists\Components\Component>
 */
protected function getInfolistSchema(): array
{
    return [
        'id' => TextEntry::make('id'),
        'nome' => TextEntry::make('nome'),
        // Altri componenti...
    ];
}
```

È fondamentale utilizzare sempre chiavi di tipo stringa per identificare chiaramente i componenti nell'array. Non utilizzare mai array sequenziali con indici numerici impliciti.

### 2. Documentazione del metodo `getTableHeaderActions`

Il metodo `getTableHeaderActions` è utilizzato nelle classi che estendono `XotBaseRelationManager` per definire le azioni disponibili nell'header della tabella. Questo metodo deve:

1. Essere dichiarato come **`public`** (non protected) per essere compatibile con la classe parent
2. Restituire **sempre** un array con chiavi di tipo stringa

La corretta implementazione deve essere:

```php
/**
 * Restituisce le azioni disponibili nell'header della tabella.
 *
 * @return array<string, \Filament\Tables\Actions\Action|\Filament\Tables\Actions\ActionGroup>
 */
public function getTableHeaderActions(): array
{
    return [
        'create' => CreateAction::make(),
        'attach' => AttachAction::make(),
        // Altre azioni...
    ];
}
```

#### ❌ Implementazione errata:

```php
// ERRORE: visibilità errata (protected anziché public)
protected function getTableHeaderActions(): array
{
    return [
        AddAttachmentAction::make(), // ERRORE: chiave numerica implicita
    ];
}
```

#### ✅ Implementazione corretta:

```php
// CORRETTO: visibilità public
public function getTableHeaderActions(): array
{
    return [
        'addAttachment' => AddAttachmentAction::make(), // CORRETTO: chiave stringa esplicita
    ];
}
```

## Esempi di implementazioni corrette:

```php
/**
 * Restituisce lo schema dell'infolist per la visualizzazione dei dettagli del record.
 *
 * @return array<string, \Filament\Infolists\Components\Component>
 */
protected function getInfolistSchema(): array
{
    return [
        'informazioni_personali' => Section::make('Informazioni Personali')
            ->schema([
                // Altri componenti...
            ]),
        'dettagli_contatto' => Section::make('Dettagli Contatto')
            ->schema([
                // Altri componenti...
            ]),
    ];
}
```

## Namespace Corretti

### Regola Fondamentale: Rimuovere "app" dai Namespace

Anche se i file sono fisicamente collocati nella directory `app` del modulo, il namespace **NON** deve includere questo segmento.

#### Errore Comune: Namespace Actions

Uno degli errori più frequenti riguarda il namespace delle Actions:

- ✅ **CORRETTO**: `namespace Modules\Xot\Actions;`
- ❌ **ERRATO**: `namespace Modules\Xot\app\Actions;`

Anche se il file Actions si trova fisicamente in `Modules/Xot/app/Actions/`, il namespace deve sempre essere `Modules\Xot\Actions` (senza il segmento `app`).

Gli errori PHPStan relativi a questo problema sono spesso del tipo:
```
Class 'Modules\Xot\app\Actions\MyAction' not found.
```

#### Namespace Corretti per i Componenti Principali

| Tipo di Componente       | Percorso Fisico                         | Namespace Corretto                 |
|--------------------------|----------------------------------------|-----------------------------------|
| Modelli                  | `Modules/Xot/app/Models/`              | `Modules\Xot\Models`              |
| Controller               | `Modules/Xot/app/Http/Controllers/`    | `Modules\Xot\Http\Controllers`    |
| Actions                  | `Modules/Xot/app/Actions/`             | `Modules\Xot\Actions`             |
| Providers                | `Modules/Xot/app/Providers/`           | `Modules\Xot\Providers`           |
| **Comandi Console**      | `Modules/Xot/app/Console/Commands/`    | `Modules\Xot\Console\Commands`    |
| Data Objects             | `Modules/Xot/app/Datas/`               | `Modules\Xot\Datas`               |
| Filament Resources       | `Modules/Xot/app/Filament/Resources/`  | `Modules\Xot\Filament\Resources`  |

#### Esempio per i Comandi Console

```php
// CORRETTO
namespace Modules\Xot\Console\Commands;

// ERRATO
namespace Modules\Xot\app\Console\Commands;
```

Errori PHPStan come `Class Modules\Xot\app\Console\Commands\DatabaseSchemaExportCommand not found` indicano che è necessario rimuovere il segmento `app` dal namespace.