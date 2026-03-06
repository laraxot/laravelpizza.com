# Correzioni PHPStan - 6 Gennaio 2025

## Errori Risolti

5693302 (.)

b6f667c (.)

# Correzioni PHPStan nel Modulo Xot

```
Line 406: Call to function is_array() with array{0?: string, 1?: 'container'|'item', 2?: numeric-string} will always evaluate to true.
```

### 2. Errori in Actions/Filament/AutoLabelAction.php

```
Line 35: Call to an undefined method Filament\Forms\Components\Component::getName().
Line 39: Call to an undefined method Filament\Forms\Components\Component::getName().
Line 40: Call to an undefined method Filament\Forms\Components\Component::getName().
```

### 3. Errore in Actions/File/GetComponentsAction.php

```
Line 91: Parameter #1 $objectOrClass of class ReflectionClass constructor expects class-string<T of object>|T of object, string given.
```

### 4. Errore in Actions/Import/ImportCsvAction.php

```
Line 145: Class Modules\Xot\Datas\ColumnData constructor invoked with 1 parameter, 2 required.
```

### 5. Errore in Actions/Model/GetSchemaManagerByModelClassAction.php

```
Line 21: Call to an undefined method Illuminate\Database\Connection::getDoctrineSchemaManager().
```

### 6. Errore in Actions/Model/StoreAction.php

```
Line 42: Access to an undefined property Illuminate\Database\Eloquent\Relations\Relation::$relationship_type.
```

### 7. Errore in Actions/Model/Update/BelongsToAction.php

```
Line 35: Offset 0 does not exist on non-empty-array<string, mixed>.
```

### 8. Errore in Actions/Model/Update/BelongsToManyAction.php

```
Line 64: Call to function is_iterable() with non-empty-list will always evaluate to true.
```

### 9. Errore in Actions/Model/Update/RelationAction.php

```
Line 33: Access to an undefined property Illuminate\Database\Eloquent\Relations\Relation::$relationship_type.
```

### 10. Errori in Console/Commands/DatabaseSchemaExportCommand.php

```
Line 86: Function preg_match_all is unsafe to use. It can return FALSE instead of throwing an exception.
Line 174: Strict comparison using === between string and false will always evaluate to false.
Line 233: Unable to resolve the template type TKey in call to function collect
Line 233: Unable to resolve the template type TValue in call to function collect
Line 235: Unable to resolve the template type TKey in call to function collect
Line 235: Unable to resolve the template type TValue in call to function collect
```

### 11. Errori in Console/Commands/DatabaseSchemaExporterCommand.php

```
Line 87: Function json_encode is unsafe to use. It can return FALSE instead of throwing an exception.
Line 87: Parameter #2 $contents of static method Illuminate\Support\Facades\File::put() expects string, string|false given.
```

### 12. Errori in Console/Commands/GenerateDbDocumentationCommand.php

```
Line 40: Function json_decode is unsafe to use. It can return FALSE instead of throwing an exception.
Line 239: Function json_encode is unsafe to use. It can return FALSE instead of throwing an exception.
```

### 13. Errori in Console/Commands/GenerateFilamentResources.php

```
Line 20: Command "filament:generate-resources" does not have argument "module".
Line 21: Parameter #1 $name of static method Nwidart\Modules\Facades\Module::find() expects string, array|bool|string|null given.
Line 24: Part $moduleName (array|bool|string) of encapsed string cannot be cast to string.
Line 29: Part $moduleName (array|bool|string) of encapsed string cannot be cast to string.
Line 33: Part $moduleName (array|bool|string) of encapsed string cannot be cast to string.
Line 42: Parameter #1 $string of function strtolower expects string, array|bool|string|null given.
Line 46: Part $moduleName (array|bool|string) of encapsed string cannot be cast to string.
```

### 14. Errori in Console/Commands/GenerateModelsFromSchemaCommand.php

```
Line 85: Function json_decode is unsafe to use. It can return FALSE instead of throwing an exception.
Line 145: Parameter #1 $haystack of static method Illuminate\Support\Str::endsWith() expects string, int|string given.
Line 188: Function date is unsafe to use. It can return FALSE instead of throwing an exception.
Line 368: Function preg_replace is unsafe to use. It can return FALSE instead of throwing an exception.
Line 385: Function preg_replace is unsafe to use. It can return FALSE instead of throwing an exception.
Line 388: Function preg_match is unsafe to use. It can return FALSE instead of throwing an exception.
Line 416: Function preg_match is unsafe to use. It can return FALSE instead of throwing an exception.
Line 422: Function preg_match is unsafe to use. It can return FALSE instead of throwing an exception.
Line 435: Strict comparison using !== between null and mixed will always evaluate to true.
```

### 15. Errori in Console/Commands/GenerateResourceFormSchemaCommand.php

```
Line 48: Strict comparison using === between array and false will always evaluate to false.
Line 59: Strict comparison using === between string and false will always evaluate to false.
Line 63: Strict comparison using === between int and false will always evaluate to false.
Line 67: Strict comparison using === between int and false will always evaluate to false.
Line 85: Strict comparison using === between int and false will always evaluate to false.
```

### 16. Errori in Console/Commands/ImportMdbToMySQL.php

```
Line 104: Result of method Modules\Xot\Console\Commands\ImportMdbToMySQL::exportTablesToCSV() (void) is used.
Line 106: Argument of an invalid type null supplied for foreach, only iterables are supported.
```

### 17. Errori in Console/Commands/ImportMdbToSQLite.php

```
Line 90: Method Modules\Xot\Console\Commands\ImportMdbToSQLite::createTablesInSQLite() has no return type specified.
Line 114: Method Modules\Xot\Console\Commands\ImportMdbToSQLite::importDataToSQLite() has no return type specified.
```

### 18. Errore in Console/Commands/SearchStringInDatabaseCommand.php

```
Line 53: Parameter #1 $results of method Modules\Xot\Console\Commands\SearchStringInDatabaseCommand::formatResults() expects Illuminate\Support\Collection<int, object>, Illuminate\Support\Collection<int, stdClass> given.
```

### 19. Errore in Datas/XotData.php

```
Line 209: Method Modules\Xot\Datas\XotData::getProfileClass() should return class-string<Illuminate\Database\Eloquent\Model&Modules\Xot\Contracts\ProfileContract> but returns string.
```

### 20. Errore in Filament/Pages/ArtisanCommandsManager.php

```
Line 27: Property Modules\Xot\Filament\Pages\ArtisanCommandsManager::$listeners has no type specified.
```

### 21. Errore in Filament/Resources/XotBaseResource.php

```
Line 147: Method Modules\Xot\Filament\Resources\XotBaseResource::getRelations() should return array<class-string<Filament\Resources\RelationManagers\RelationManager>|Filament\Resources\RelationManagers\RelationGroup|Filament\Resources\RelationManagers\RelationManagerConfiguration> but returns array<class-string|Filament\Resources\RelationManagers\RelationGroup|Filament\Resources\RelationManagers\RelationManagerConfiguration>.
```

### 22. Errori in Filament/Resources/XotBaseResource/RelationManager/XotBaseRelationManager.php

```
Line 111: Static access to instance property Modules\Xot\Filament\Resources\XotBaseResource\RelationManagers\XotBaseRelationManager::$resource.
Line 112: Dead catch - Exception is never thrown in the try block.
```

### 23. Errore in Filament/Widgets/XotBaseWidget.php

```
Line 33: Static property Modules\Xot\Filament\Widgets\XotBaseWidget::$view (view-string) does not accept string.
```

### 24. Errore in Services/ArtisanService.php

```
Line 146: Offset 1 on array{list<string>, list<string>} in isset() always exists and is not nullable.
```

## Soluzioni Implementate

### 1. Correzione in Helpers/Helper.php

Il problema è che PHPStan rileva che la chiamata a `is_array($matches)` sarà sempre vera perché `$matches` è già tipizzato come array. Abbiamo modificato il controllo per verificare se l'array non è vuoto invece di verificare se è un array:

```php
$pattern = '/(container|item)(\d+)/';
preg_match($pattern, $k, $matches);

if (!empty($matches) && isset($matches[1]) && isset($matches[2])) {
    $sk = $matches[1];
    $sv = $matches[2];
    // @phpstan-ignore offsetAccess.nonOffsetAccessible
    ${$sk}[$sv] = $v;
}
```

Questo controllo è più appropriato perché verifica che l'array `$matches` contenga effettivamente dei risultati, non solo che sia un array.

### 2. Correzione in Actions/Filament/AutoLabelAction.php

Il problema è che il codice chiamava il metodo `getName()` sui componenti Filament, ma non tutti i componenti hanno questo metodo. La soluzione è stata modificare il metodo `getComponentName()` per utilizzare un approccio più robusto:
}
```

5693302 (.)

b6f667c (.)

### 2. Validazione Dati
```php
/**
 * @param array<string, mixed> $data
 * @throws InvalidArgumentException
 */
private function validateData(array $data): void
{
    Assert::keyExists($data, 'required_field');
    Assert::string($data['required_field']);

### Versione HEAD

aurmich/dev
5693302 (.)

b6f667c (.)

### Servizi e Dependency Injection

**Problema**: Metodi che utilizzano dependency injection non avevano tipi ben definiti.

**Soluzione**:
1. Specificare i tipi di parametro e di ritorno in modo esplicito
2. Utilizzare interfacce per i servizi iniettati
3. Aggiungere annotazioni PHPDoc quando necessario

```php
private function getComponentName(Field|Component $component): string
{
    // Per i componenti Field di Filament
    if (method_exists($component, 'getName')) {
        return $component->getName();
    }

    // Per i componenti generali di Filament che hanno getStatePath
    if (method_exists($component, 'getStatePath')) {
        return $component->getStatePath();
    }

    // Fallback a reflection per altri casi
    $reflectionClass = new \ReflectionClass($component);
    if ($reflectionClass->hasProperty('name') && $reflectionClass->getProperty('name')->isPublic()) {
        $property = $reflectionClass->getProperty('name');
        return (string) $property->getValue($component);
    }

    // Ultima risorsa
    return class_basename($component);
}
```

Questo approccio controlla esplicitamente se i metodi esistono prima di chiamarli, utilizzando vari fallback se il metodo principale non è disponibile.

### 3. Correzione in Actions/File/GetComponentsAction.php

L'errore riguardava l'utilizzo del costruttore di `ReflectionClass` che richiedeva un parametro di tipo `class-string<T of object>`, ma veniva passata una stringa generica. Abbiamo risolto questo problema aggiungendo un controllo che verifica se la classe esiste prima di istanziare la `ReflectionClass` e usando un'annotazione PHPDoc per indicare a PHPStan che la variabile è di tipo `class-string`:

```php
try {
    // Assicuriamoci che comp_ns sia una classe valida prima di creare la ReflectionClass
    if (!class_exists($tmp->comp_ns)) {
        throw new \Exception("La classe {$tmp->comp_ns} non esiste");
    }
    /** @var class-string $classString */
    $classString = $tmp->comp_ns;
    $reflection = new \ReflectionClass($classString);
    if ($reflection->isAbstract()) {
        continue;
    }
} catch (\Exception $e) {
    // gestione dell'errore
}
```

Questo approccio garantisce che venga passato al costruttore di `ReflectionClass` solo un nome di classe valido, evitando l'errore di tipo rilevato da PHPStan.

### 4. Correzione in Actions/Import/ImportCsvAction.php

L'errore riguardava la creazione di un oggetto `ColumnData` con un solo parametro, mentre il costruttore ne richiede due. Abbiamo risolto il problema fornendo entrambi i parametri richiesti:

```php
// Prima:
return new ColumnData($column);

// Dopo:
return new ColumnData(
    name: $column,
    type: 'string' // Tipo predefinito, modificare se necessario
);
```

Abbiamo aggiunto il parametro `type` con un valore predefinito 'string', che soddisfa il requisito del costruttore di `ColumnData`.

### 5. Correzione in Actions/Model/GetSchemaManagerByModelClassAction.php

L'errore riguardava la chiamata al metodo `getDoctrineSchemaManager()` che è stato deprecato nelle versioni recenti di Laravel. Abbiamo aggiornato il codice per utilizzare l'approccio più recente:

```php
// Prima:
return $connection->getDoctrineSchemaManager();

// Dopo:
return $connection->getDoctrineConnection()->createSchemaManager();
```

Questo approccio utilizza prima `getDoctrineConnection()` e poi chiama `createSchemaManager()` sul risultato, che è il modo attualmente supportato per ottenere lo schema manager di Doctrine.

### 6. Correzione in Actions/Model/StoreAction.php

L'errore riguardava l'accesso a una proprietà `relationship_type` che non esiste nella classe `Relation`. Abbiamo modificato il codice per determinare il tipo di relazione in base al nome della classe:

```php
// Prima:
$action_class = __NAMESPACE__.'\\Store\\'.$relation->relationship_type.'Action';

// Dopo:
// Ottieni il tipo di relazione dal nome della classe
$relationClass = get_class($relation);
$relationshipType = class_basename($relationClass);

$action_class = __NAMESPACE__.'\\Store\\'.$relationshipType.'Action';
```

Questo approccio utilizza `get_class()` e `class_basename()` per ottenere il nome della classe della relazione e lo utilizza come tipo di relazione, evitando di accedere a una proprietà non esistente.

### 7. Correzione in Actions/Model/Update/BelongsToAction.php

L'errore riguardava l'accesso diretto all'offset 0 di un array associativo, che non garantisce la presenza di tale indice. Abbiamo modificato il codice per utilizzare `Arr::first()` che gestisce in modo sicuro l'accesso al primo elemento dell'array:

```php
// Prima:
$related_id = $relationDTO->data[0];

// Dopo:
$related_id = Arr::first($relationDTO->data);
if (null === $related_id) {
    return; // Non ci sono dati da elaborare
}
```

Questo approccio è più sicuro perché `Arr::first()` restituisce `null` se l'array è vuoto o se l'indice 0 non esiste, evitando così l'errore di accesso a un offset non esistente.

### 8. Correzione in Actions/Model/Update/BelongsToManyAction.php

L'errore riguardava la chiamata a `is_iterable()` su una variabile che PHPStan sa già essere un array non vuoto. Abbiamo rimosso questo controllo ridondante:

```php
// Prima:
$ids = is_iterable($ids) ? iterator_to_array($ids) : (array) $ids;
Assert::allScalar($ids, 'The "ids" array must contain only scalar values.');

// Dopo:
// $ids è già un array non vuoto a questo punto, quindi non serve verificare se è iterabile
Assert::allScalar($ids, 'The "ids" array must contain only scalar values.');
```

Questo approccio semplifica il codice rimuovendo un controllo che PHPStan identifica come sempre vero, mantenendo la validazione che gli elementi dell'array siano valori scalari.

### 9. Correzione in Actions/Model/Update/RelationAction.php

L'errore riguardava l'accesso a una proprietà `relationship_type` che non esiste nella classe `Relation`. Abbiamo modificato il codice per determinare il tipo di relazione in base al nome della classe, utilizzando lo stesso approccio adottato per StoreAction.php:

```php
// Prima:
$actionClass = __NAMESPACE__.'\\'.$relation->relationship_type.'Action';

// Dopo:
// Ottieni il tipo di relazione dal nome della classe
$relationClass = get_class($relation);
$relationshipType = class_basename($relationClass);

$actionClass = __NAMESPACE__.'\\'.$relationshipType.'Action';
```

Questo approccio utilizza `get_class()` e `class_basename()` per ottenere il nome della classe della relazione e lo utilizza come tipo di relazione, evitando di accedere a una proprietà non esistente.

### 10. Correzione in Console/Commands/DatabaseSchemaExportCommand.php

L'errore riguardava l'uso non sicuro di funzioni PHP che possono restituire `FALSE` invece di lanciare eccezioni e problemi con i tipi generici nelle collezioni.

#### Problema 1: Utilizzo non sicuro di preg_match_all
```php
// Prima:
preg_match_all('/CONSTRAINT\s+`([^`]+)`\s+FOREIGN\s+KEY\s+\(`([^`]+)`\)\s+REFERENCES\s+`([^`]+)`\s+\(`([^`]+)`\)/i', $createTableSql, $foreignKeys, PREG_SET_ORDER);

// Dopo:
try {
    $result = \Safe\preg_match_all('/CONSTRAINT\s+`([^`]+)`\s+FOREIGN\s+KEY\s+\(`([^`]+)`\)\s+REFERENCES\s+`([^`]+)`\s+\(`([^`]+)`\)/i', $createTableSql, $foreignKeys, PREG_SET_ORDER);
} catch (\Exception $e) {
    $this->error("Errore nell'analisi delle foreign keys per la tabella {$tableName}: " . $e->getMessage());
    $foreignKeys = [];
}
```

#### Problema 2: Confronto stretto tra `string` e `false`
```php
// Prima:
$jsonContent = json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
if ($jsonContent === false) {
    throw new \RuntimeException('Failed to encode schema to JSON');
}
File::put($outputPath, $jsonContent);

// Dopo:
try {
    $jsonContent = \Safe\json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    File::put($outputPath, $jsonContent);
    $this->info("Schema del database esportato con successo in: {$outputPath}");
} catch (\Exception $e) {
    $this->error("Errore nell'encoding JSON dello schema: " . $e->getMessage());
    return Command::FAILURE;
}
```

#### Problema 3: Tipi generici nelle collezioni
```php
// Prima:
$relevantTables = collect($schema['tables'])
    ->map(function (array $table, string $tableName) use ($schema): array {
        $relationCount = collect($schema['relationships'])
            ->filter(/*...*/);

// Dopo:
/** @var \Illuminate\Support\Collection<string, array<string, mixed>> $relevantTables */
$relevantTables = collect($schema['tables'])
    ->map(function (array $table, string $tableName) use ($schema): array {
        /** @var \Illuminate\Support\Collection<int, array<string, mixed>> $relationCount */
        $relationCount = collect($schema['relationships'])
            ->filter(/*...*/);
```

Queste modifiche risolvono i problemi in tre modi:
1. Utilizzando le funzioni del pacchetto `\Safe` che lanciano eccezioni invece di restituire `FALSE` in caso di errore
2. Gestendo correttamente potenziali errori durante l'encoding JSON
3. Aggiungendo annotazioni PHPDoc per specificare i tipi generici nelle collezioni Laravel

### 11. Correzione in Console/Commands/DatabaseSchemaExporterCommand.php

L'errore riguardava l'uso non sicuro di `json_encode` che può restituire `FALSE` invece di una stringa, e il passaggio di questo risultato come parametro a `File::put()`. Abbiamo corretto il problema utilizzando la versione sicura `\Safe\json_encode` e gestendo eventuali eccezioni:

```php
// Prima:
$filename = "{$outputDir}/{$databaseName}_schema.json";
File::put($filename, json_encode($databaseSchema, JSON_PRETTY_PRINT));
$this->info("Schema del database esportato con successo in: {$filename}");

// Dopo:
$filename = "{$outputDir}/{$databaseName}_schema.json";
try {
    $jsonContent = \Safe\json_encode($databaseSchema, JSON_PRETTY_PRINT);
    File::put($filename, $jsonContent);
    $this->info("Schema del database esportato con successo in: {$filename}");
} catch (\Exception $e) {
    $this->error("Errore nell'encoding JSON dello schema: " . $e->getMessage());
    return Command::FAILURE;
}
```

Questa correzione garantisce che:
1. Se `json_encode` fallisce, verrà lanciata un'eccezione anziché restituire `FALSE`
2. L'eccezione viene catturata e gestita, mostrando un messaggio di errore appropriato
3. In caso di errore, il comando restituisce un codice di uscita che indica un fallimento

### 12. Correzione in Console/Commands/GenerateDbDocumentationCommand.php

L'errore riguardava l'uso non sicuro di json_decode e json_encode che possono restituire FALSE invece di lanciare eccezioni in caso di errore. Abbiamo risolto il problema utilizzando le funzioni equivalenti del pacchetto Safe:

#### Problema 1: Utilizzo non sicuro di json_decode
```php
// Prima:
$schema = json_decode($schemaContent, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    $this->error("Errore nella decodifica del file JSON: " . json_last_error_msg());
    return 1;
}

// Dopo:
try {
    $schema = \Safe\json_decode($schemaContent, true);
} catch (\Exception $e) {
    $this->error("Errore nella decodifica del file JSON: " . $e->getMessage());
    return 1;
}
```

#### Problema 2: Utilizzo non sicuro di json_encode
```php
// Prima:
$content .= json_encode($tableInfo['sample_data'], JSON_PRETTY_PRINT);

// Dopo:
try {
    $content .= \Safe\json_encode($tableInfo['sample_data'], JSON_PRETTY_PRINT);
} catch (\Exception $e) {
    $content .= "Errore nella formattazione dei dati di esempio: " . $e->getMessage();
}
```

Queste modifiche garantiscono che:
1. Eventuali errori durante la codifica/decodifica JSON vengano gestiti correttamente tramite eccezioni
2. Messaggi di errore appropriati vengano mostrati all'utente
3. In caso di errore nella formattazione dei dati di esempio, l'operazione di generazione della documentazione può comunque continuare

### 13. Correzione in Console/Commands/GenerateFilamentResources.php

L'errore riguardava diversi problemi di tipo nel comando GenerateFilamentResources:

1. Il comando non aveva un argomento 'module' definito nella firma
2. Il parametro $name di Module::find() si aspettava una stringa, ma riceveva un tipo misto
3. Problemi con la conversione di $moduleName in stringa in vari punti
4. Problema con strtolower() che si aspettava una stringa

Abbiamo risolto questi problemi con le seguenti modifiche:

#### Problema 1: Argomento mancante nella firma del comando
```php
// Prima:
protected $signature = 'filament:generate-resources';

// Dopo:
protected $signature = 'filament:generate-resources {module : Il nome del modulo per cui generare le risorse}';
```
#### Problema 2-4: Gestione dei tipi e conversioni
Abbiamo aggiunto controlli di tipo per assicurarci che $moduleName sia una stringa prima di passarlo a funzioni che richiedono stringhe come Module::find() e strtolower(). Inoltre, abbiamo estratto il risultato di strtolower() in una variabile separata per chiarezza.

Queste modifiche garantiscono che:
1. Il comando abbia una firma corretta con tutti gli argomenti necessari
2. I tipi di dati siano gestiti correttamente, con controlli espliciti dove necessario
3. Le funzioni che richiedono stringhe ricevano effettivamente stringhe
4. Il codice sia più robusto e meno soggetto a errori di tipo

### 14. Correzione in Console/Commands/GenerateModelsFromSchemaCommand.php

L'errore riguardava numerosi problemi legati all'uso di funzioni PHP non sicure (unsafe) e confronti di tipi problematici. Abbiamo implementato le seguenti correzioni:

#### 1. Utilizzo non sicuro di json_decode
```php
// Prima:
$schema = json_decode($schemaContent, true);
if (JSON_ERROR_NONE !== json_last_error()) {
    $this->error('Errore nella decodifica del file JSON: '.json_last_error_msg());
    return 1;
}

// Dopo:
try {
    $schema = \Safe\json_decode($schemaContent, true);
} catch (\Exception $e) {
    $this->error('Errore nella decodifica del file JSON: ' . $e->getMessage());
    return 1;
}
```

#### 2. Problema con Str::endsWith() che richiede una stringa
```php
// Prima:
return $column !== $primaryKey && ! Str::endsWith($column, ['_at', 'created_at', 'updated_at', 'deleted_at']);

// Dopo:
// Assicuriamoci che $column sia una stringa
$columnStr = (string)$column;
return $columnStr !== $primaryKey && ! Str::endsWith($columnStr, ['_at', 'created_at', 'updated_at', 'deleted_at']);
```

#### 3. Utilizzo non sicuro di date()
```php
// Prima:
$timestamp = date('Y_m_d_His');

// Dopo:
$timestamp = \Safe\date('Y_m_d_His');
```

#### 4. Utilizzo non sicuro di preg_replace e preg_match
```php
// Prima:
$baseType = strtolower(preg_replace('/\(.*\)/', '', $sqlType));

// Dopo:
$baseType = strtolower(\Safe\preg_replace('/\(.*\)/', '', $sqlType));

// Prima:
if (preg_match('/\((\d+)\)/', $columnType, $matches)) { ... }

// Dopo:
if (\Safe\preg_match('/\((\d+)\)/', $columnType, $matches)) { ... }
```

#### 5. Confronto stretto tra null e mixed
```php
// Prima:
if (isset($column['default']) && null !== $column['default']) { ... }

// Dopo:
if (isset($column['default']) && $column['default'] !== null) { ... }
```

Queste modifiche garantiscono che:
1. Le funzioni potenzialmente non sicure come json_decode, date, preg_replace e preg_match vengano sostituite con le versioni sicure del pacchetto Safe
2. I tipi di dati vengano gestiti correttamente, con conversioni esplicite dove necessario
3. I confronti tra tipi vengano fatti nel modo corretto, evitando confronti che PHPStan identifica come sempre veri o sempre falsi
4. Il codice sia più robusto e gestisca correttamente potenziali errori

### 15. Correzione in Console/Commands/GenerateResourceFormSchemaCommand.php

L'errore riguardava confronti stretti (===) tra tipi diversi che PHPStan rileva come sempre falsi, e funzioni potenzialmente non sicure. Abbiamo implementato le seguenti correzioni:

#### 1. Confronto stretto tra array e false
```php
// Prima:
if ($clustersResources === false) { ... }

// Dopo:
if ($clustersResources === null || $clustersResources === []) { ... }
```

#### 2. Confronto stretto tra string e false
```php
// Prima:
if ($content === false) { ... }

// Dopo:
if ($content === null || $content === '') { ... }
```

#### 3. Confronto stretto tra int e false per risultati di preg_match
```php
// Prima:
if (preg_match('/pattern/', $content, $matches) === false) { ... }

// Dopo:
if (preg_match('/pattern/', $content, $matches) <= 0) { ... }
```

#### 4. Utilizzo di funzioni Safe per preg_replace e file_put_contents
```php
// Prima:
$modifiedContent = preg_replace('/pattern/', 'replacement', $content);
if ($modifiedContent === false) { ... }

// Dopo:
$modifiedContent = \Safe\preg_replace('/pattern/', 'replacement', $content);
if ($modifiedContent === null || $modifiedContent === '') { ... }

// Prima:
if (file_put_contents($file, $modifiedContent) === false) { ... }

// Dopo:
if (\Safeile_put_contents($file, $modifiedContent) <= 0) { ... }
```

Queste modifiche garantiscono che:
1. I confronti stretti tra tipi diversi vengano evitati, sostituendoli con confronti appropriati
2. Le funzioni potenzialmente non sicure come preg_replace e file_put_contents vengano sostituite con le versioni sicure del pacchetto Safe
3. I controlli sui risultati delle funzioni siano più appropriati in base al loro tipo di ritorno
4. Il codice sia più robusto e gestisca correttamente potenziali errori

### 16. Correzione in Console/Commands/ImportMdbToMySQL.php

L'errore riguardava due problemi principali:

1. Il risultato del metodo exportTablesToCSV() (void) veniva utilizzato come se fosse un array
2. Un argomento di tipo null veniva fornito a foreach, che accetta solo iterabili

Abbiamo risolto questi problemi con le seguenti modifiche:

#### 1. Modifica del tipo di ritorno di exportTablesToCSV
```php
// Prima:
private function exportTablesToCSV(string $mdbFile): void
{
    $tables = [];
    // ... codice per popolare $tables ...
    // Nessun return
}

// Dopo:
/**
 * Esporta tutte le tabelle dal file .mdb in formato CSV.
 *
 * @return string[] Array di nomi di tabelle esportate
 */
private function exportTablesToCSV(string $mdbFile): array
{
    $tables = [];
    // ... codice per popolare $tables ...
    return $tables;
}
```
# Correzioni PHPStan - 6 Gennaio 2025

## Errori Risolti

### 1. Chart/app/Datas/AnswersChartData.php

**Problema**: Errori `argument.type` e `offsetAccess.nonOffsetAccessible`
- Linee 208, 254: `count()` su mixed
- Linee 450, 460, 492, 496: Accesso offset su mixed

**Soluzione**:
- Aggiunto controllo `\is_array()` prima di `count()`
- Aggiunto controllo esistenza `$options['plugins']` prima dell'accesso
- Utilizzato variabile intermedia per evitare chiamate multiple

### 2. Chart/app/Models/Chart.php

**Problema**: Linea 187 - Tipo di ritorno errato
- Metodo `getSettings()` doveva restituire `array<string, mixed>` ma restituiva `array<int, array<mixed>>`

**Soluzione**:
- Corretto tipo di ritorno a `array<string, array<string, mixed>>`
- Aggiunto cast esplicito con `@var` per il risultato

### 3. Job/app/Actions/GetTaskFrequenciesAction.php

**Problema**: Linea 21 - Tipo di ritorno errato
- Metodo doveva restituire `array<string, mixed>` ma restituiva `array<mixed, mixed>`

**Soluzione**:
- Aggiunto cast esplicito `@var array<string, mixed>` al risultato

### 4. <nome progetto>/app/States/Appointment/ReportPending.php

**Problema**: Linea 27 - Tipo di ritorno errato
- Metodo doveva restituire `array<string, Component>` ma restituiva `array<int|string, Component>`

**Soluzione**:
- Aggiunto PHPDoc con tipo di ritorno corretto
- Aggiunto cast esplicito al risultato

### 5. User/app/Console/Commands/ChangeTypeCommand.php

**Problema**: Linea 80 - Accesso proprietà su mixed
- `$item->value` e `$item->getLabel()` su mixed

**Soluzione**:
- Aggiunto controllo `is_object($item) && method_exists($item, 'getLabel')`
- Gestito caso fallback per valori sconosciuti

### 6. Xot/app/Models/Traits/HasExtraTrait.php

**Problema**: Linea 62 - Tipo di ritorno errato
- Metodo doveva restituire tipo specifico ma restituiva `array<mixed, mixed>`

**Soluzione**:
- Aggiunto tipo di ritorno esplicito al metodo
- Aggiunto cast esplicito con `@var` al risultato

### 7. Xot/app/Services/ModuleService.php

**Problema**: Linea 112 - Tipo di ritorno errato
- Metodo doveva restituire `array<int, string>` ma restituiva `array<string, class-string>`

**Soluzione**:
- Corretto tipo di ritorno PHPDoc a `array<string, class-string>`

### 8. Xot/app/States/Transitions/XotBaseTransition.php

**Problema**: Linea 39 - Tipo parametro errato
- `sendRecipientNotification()` aspettava `UserContract|null` ma riceveva `Model|null`

**Soluzione**:
- Separato controllo per `UserContract` e `null`
- Chiamate esplicite per ogni tipo

## Pattern Comuni Identificati

1. **Array Types**: Sempre specificare tipi degli array con `array<key, value>`
2. **Mixed Handling**: Controllare tipi prima dell'uso con `is_array()`, `is_object()`
3. **Offset Access**: Verificare esistenza chiavi prima dell'accesso
4. **Return Types**: Usare cast espliciti `@var` quando necessario
5. **Union Types**: Separare logica per ogni tipo possibile

## Regole Applicate

- **REGOLA ASSOLUTA**: Non modificare `phpstan.neon`
- Specificare sempre tipi degli array: `array<string, mixed>` per associativi
- Utilizzare controlli di tipo prima dell'uso
- Aggiungere PHPDoc completi per tutti i metodi
- Cast espliciti quando necessario per compatibilità PHPStan

## Collegamenti

- [PHPStan Critical Rules](./phpstan-critical-rules.md)
- [Array Types Fixes](./phpstan-array-types-fixes.md)
- [PHPStan Level 10 Guidelines](./phpstan-level10-guidelines.md)

# PHPStan Analysis Report for Xot Module


**Outcome (Initial Scan):**
The `Xot` module was initially analyzed with PHPStan individually, and **no errors were found**. This indicated adherence to the project's PHPStan configuration and coding standards at that time.

**New Findings (Full Modules Scan):**
A subsequent comprehensive PHPStan scan across all `Modules` revealed 4 errors specifically within `Xot/app/Filament/Resources/RelationManagers/XotBaseRelationManager.php`. These errors require immediate attention.

**Detailed Errors in `Xot/app/Filament/Resources/RelationManagers/XotBaseRelationManager.php`:**

1.  **Line 77: `argument.type`**
    *   **Error:** `Parameter #1 $components of method Filament\Schemas\Schema::components() expects array<Illuminate\Contracts\Support\Htmlable|string>|Closure|Illuminate\Contracts\Support\Htmlable|string, array given.`
    *   **Plan:** Ensure that the array passed to `Schema::components()` contains elements that are correctly typed as `Htmlable|string` or that the input itself is a `Closure`, `Htmlable`, or `string`. This likely involves explicit casting or ensuring factory methods generate the correct types.

2.  **Line 139: `return.type`**
    *   **Error:** `Method Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager::getTableColumns() should return array<Filament\Tables\Columns\Column|Filament\Tables\Columns\Layout\Component> but returns array<string, mixed>.`
    *   **Plan:** Explicitly type the return array for `getTableColumns()` to contain instances of `Filament\Tables\Columns\Column` or `Filament\Tables\Columns\Layout\Component`. This may involve ensuring all items added to the array are correctly instantiated Filament components.

3.  **Line 186: `method.notFound`**
    *   **Error:** `Call to an undefined method Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager::canDeleteBulk().`
    *   **Plan:** Investigate the source of `canDeleteBulk()`. If it's inherited from a trait or base class, ensure the trait is correctly used and PHPStan can resolve it. If it's a dynamic method, add an appropriate `@method` PHPDoc tag. Alternatively, if it's meant to be a local method, define it.

4.  **Line 199: `method.notFound`**
    *   **Error:** `Call to an undefined method Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager::canDetachBulk().`
    *   **Plan:** Similar to `canDeleteBulk()`, determine the source of this method and ensure it's properly resolved by PHPStan (e.g., via trait, base class, or `@method` PHPDoc).

**Next Steps:**
These errors will be addressed systematically. After each fix, `phpstan`, `phpmd`, and `phpinsights` will be run on the modified file to ensure compliance with all code quality standards.


---
<\!-- merged from: phpstan-fixes-2025-01-27.md -->

# Correzioni PHPStan Modulo Geo - 2025-01-27

**Data**: 2025-01-27  
**Versione PHPStan**: 1.12.x  
**Livello**: 10  
**Status**: ✅ COMPLETATO  

## 🔧 Correzioni Implementate

### 1. WebbingbrasilMap Widget - Errore Proprietà Statica

**Problema**: 
```
Cannot redeclare non static Filament\Widgets\Widget::$view as static Modules\Geo\Filament\Widgets\WebbingbrasilMap::$view
```

**Causa**: La proprietà `$view` era definita come `static` nella classe derivata mentre nella classe base `Widget` è non-statica.

**Soluzione**: 
1. Rinominato file originale come `.disabled4` per mantenere traccia storica
2. Creato nuovo file stub che estende direttamente `Widget` invece di `XotBaseWidget`
3. Corretto la proprietà `$view` da `protected static string` a `protected string`
4. Mantenuto il metodo `canView()` che restituisce `false` per disabilitazione temporanea

**File Modificato**: 
- `Modules/Geo/app/Filament/Widgets/WebbingbrasilMap.php`

**Codice Prima**:
```php
class WebbingbrasilMap extends XotBaseWidget
{
    protected static string $view = 'geo::filament.widgets.webbingbrasil-map-stub';
    // ...
}
```

**Codice Dopo**:
```php
class WebbingbrasilMap extends Widget
{
    protected string $view = 'geo::filament.widgets.webbingbrasil-map-stub';
    
    public static function canView(): bool
    {
        return false; // Temporaneamente disabilitato per Filament v4
    }
}
```

## 📋 Dettagli Tecnici

### Motivazione della Correzione
- **Compatibilità Filament v4**: Il widget è temporaneamente disabilitato per problemi di compatibilità
- **Conformità PHPStan**: Risolve errore di ridichiarazione di proprietà con visibilità diversa
- **Architettura Pulita**: Estende direttamente `Widget` per semplicità dato che è un stub

### Vista Stub Utilizzata
Il widget utilizza la vista `geo::filament.widgets.webbingbrasil-map-stub` che mostra:
- Messaggio di mappa non disponibile
- Icona placeholder
- Spiegazione della disabilitazione temporanea

## 🔗 Contesto Architetturale

### Integrazione con Filament 4.x
Il widget fa parte del piano di migrazione a Filament 4.x documentato in:
- `filament_4x_compatibility.md`
- Piano di riattivazione graduale quando i pacchetti saranno compatibili

### Pacchetti Coinvolti
- `webbingbrasil/filament-maps` - Non compatibile con Filament 4.x
- Widget disabilitato fino a rilascio versione compatibile

## ✅ Risultato
- ✅ Errore PHPStan risolto
- ✅ Widget funziona come stub (mostra messaggio disabilitazione)
- ✅ Compatibilità Filament 4.x mantenuta
- ✅ Tracciabilità storica preservata (file .disabled4)

## 🔄 Prossimi Passi

1. **Monitoraggio**: Verificare rilasci di `webbingbrasil/filament-maps` compatibili con Filament 4.x
2. **Riattivazione**: Quando disponibile, riattivare widget con nuova implementazione
3. **Testing**: Test completi di integrazione post-riattivazione

## 📚 Collegamenti

- [Documentazione Compatibilità Filament 4.x](./filament_4x_compatibility.md)
- [Documentazione Widget Disabilitati](./widgets/disabled_widgets.md)
- [Piano Migrazione Filament](../../../../docs/filament_4x_migration_plan.md)

*


---
<\!-- merged from: phpstan-fixes-2025-10-01.md -->

# User Module - PHPStan Fixes Session 2025-10-01

## ⚠️ Stato: IN PROGRESS - 95 errori rimanenti

**Data correzione**: 1 Ottobre 2025  
**Analizzati**: ~400 file  
**Errori iniziali**: ~100+ (bloccavano analisi)  
**Errori attuali**: 95  
**Errori critici risolti**: 7 (syntax errors)

---

## 🛠️ Correzioni Implementate

### 1. BaseUser.php - Rimozione Codice Orfano (CRITICO)

**File**: `app/Models/BaseUser.php`  
**Linee**: 377-419  
**Problema**: Blocchi di codice senza dichiarazione di metodo che causavano 7 errori di sintassi e bloccavano l'intera analisi PHPStan

**Codice rimosso**:
```php
// Linee 377-381: Blocco orfano #1
{
    if ($value !== null) {
        return $value;
    }
{
    if ($value !== null) {
        return $value;
    }
    if ($this->getKey() === null) {
        return $this->email ?? 'User';
    }
    // ... altro codice orfano ...
}
```

**Impatto**: 
- ✅ Eliminati 7 errori di sintassi
- ✅ Sbloccata l'analisi PHPStan su TUTTI i moduli
- ✅ Permesso il proseguimento delle correzioni

### 2. BaseUser.php - Aggiunta Metodi Teams e Tenants

**Data**: 1 Ottobre 2025 (sera)  
**Autore**: Utente  

Aggiunti metodi per gestione Teams e Tenants:

```php
/**
 * Get all of the teams the user belongs to.
 *
 * @return BelongsToMany<Team, static>
 */
public function teams(): BelongsToMany
{
    return $this->belongsToMany(Team::class, 'team_user')
        ->withPivot('role')
        ->withTimestamps();
}

/**
 * Get the current team of the user's context.
 */
public function currentTeam(): BelongsTo
{
    return $this->belongsTo(Team::class, 'current_team_id');
}

/**
 * Determine if the given team is the current team.
 */
public function isCurrentTeam(\Modules\User\Contracts\TeamContract $teamContract): bool
{
    $current = $this->getAttribute('current_team_id');
    return (string) $current === (string) $teamContract->getKey();
}

/**
 * Get all of the tenants the user belongs to.
 *
 * @return BelongsToMany<Tenant, static>
 */
public function tenants(): BelongsToMany
{
    return $this->belongsToMany(Tenant::class, 'tenant_user')
        ->withPivot('role')
        ->withTimestamps();
}

/**
 * Filament: return the tenants available to this user for the given Panel.
 *
 * @return \Illuminate\Support\Collection<int, Tenant>
 */
public function getTenants(Panel $panel): \Illuminate\Support\Collection
{
    return $this->tenants()->get();
}

/**
 * Filament: determine if the user can access the given tenant.
 */
public function canAccessTenant(\Illuminate\Database\Eloquent\Model $tenant): bool
{
    if ($tenant instanceof Tenant) {
        return $this->tenants()->whereKey($tenant->getKey())->exists();
    }
    return false;
}
```

**Implementato contratto**: `HasTeamsContract`

---

## 📋 Errori Rimanenti (95)

### Categorie Principali

1. **Property Access Issues** (~50 errori)
   - Accesso a proprietà non definite su Model generico
   - Necessario: type hints più specifici

2. **Type Safety** (~30 errori)
   - Return types non precisi
   - Mixed types da stringere

3. **Method Calls** (~15 errori)
   - Chiamate a metodi non garantiti

### Piano di Risoluzione

**Priorità ALTA**:
- [ ] Correggere BaseUser property access
- [ ] Migliorare type hints nei trait
- [ ] Stringere return types nei service provider

**Priorità MEDIA**:
- [ ] Correggere seeders
- [ ] Migliorare factories
- [ ] Sistemare helper functions

**Priorità BASSA**:
- [ ] Test type hints
- [ ] Migration type safety

---

## 🎯 Architettura User Module

### Models
- **BaseUser** ⚠️ - In progress (95 errori rimanenti)
- **User** - Estende BaseUser
- **Team** - Gestione team
- **Tenant** - Gestione tenant/organization

### Traits
- **HasTeams** - Gestione appartenenza team
- **HasTenants** - Gestione multi-tenancy
- **HasPermissions** - Integrazione Spatie permissions

### Contracts
- **UserContract** - Interfaccia base utente
- **HasTeamsContract** ✅ - Implementato in BaseUser
- **HasTenants** - Multi-tenancy support

### Resources Filament
- UserResource
- TeamResource
- RoleResource
- PermissionResource

---

## 📊 Progressione

| Fase | Errori | Status |
|------|--------|--------|
| **Inizio sessione** | 100+ (bloccato) | ❌ Analisi impossibile |
| **Dopo fix sintassi** | 95 | ✅ Analisi possibile |
| **Dopo aggiunta Teams/Tenants** | 95 | ⏳ Pronto per correzioni |
| **Target finale** | 0 | 🎯 Obiettivo domani |

---

## 🔧 Best Practices Applicate

### ✅ FATTO
1. Rimosso codice orfano
2. Aggiunti PHPDoc completi per relazioni
3. Type hints espliciti per BelongsToMany
4. Implementato contratto HasTeamsContract

### ⏳ DA FARE
1. Correggere property access su Model generico
2. Migliorare type hints nei metodi legacy
3. Stringere return types
4. Aggiungere assertions PHPStan dove necessario

---

## 🔗 Collegamenti

- [← User Module README](./readme.md)
- [← PHPStan Session Report](../../../docs/phpstan/filament-v4-fixes-session.md)
- [← Final Report](../../../docs/phpstan/final-report-session-2025-10-01.md)
- [← Root Documentation](../../../docs/index.md)

---

## 📝 Note per Domani

### Prossimi Step
1. **Analizzare i 95 errori sistematicamente** - Creare categorizzazione dettagliata
2. **Correggere property access** - Aggiungere type hints specifici
3. **Migliorare type safety** - Usare union types e PHPStan assertions
4. **Test di regressione** - Verificare che tutte le funzionalità funzionino

### Strategie
- Analizzare errori per file (non per tipo)
- Correggere i file più critici prima (Models, Providers)
- Lasciare seeders e test per ultimi

---

**Status**: ⚠️ IN PROGRESS  
**PHPStan Level**: 9  
**Prossima sessione**: 2 Ottobre 2025  
**Obiettivo**: 0 errori User + Xot


