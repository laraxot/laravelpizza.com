# PHPStan Fixes Gennaio 2025 - Modulo Xot

## Riassunto delle Correzioni

In data Gennaio 2025, sono stati risolti diversi errori PHPStan livello 9 nel modulo Xot, principalmente relativi a problemi di tipizzazione e compatibilità tra tipi di Collection.

## Batch 1: Errori Risolti (Prima fase)

### 1. ExceptionHandler::handles() - Missing Return Type

**File**: `laravel/Modules/Xot/app/Exceptions/ExceptionHandler.php`
**Errore**: `Method Modules\Xot\Exceptions\ExceptionHandler::handles() has no return type specified.`

**Soluzione**: Aggiunto tipo di ritorno esplicito `void`

### 2. Collection Type Incompatibility - Export Actions

**File**: `laravel/Modules/Xot/app/Actions/Export/ExportXlsByCollection.php`
**Errore**: Incompatibilità tra `Illuminate\Database\Eloquent\Collection` e `Illuminate\Support\Collection`

**Soluzione**: Union types implementati per accettare entrambi i tipi di Collection

### 3. ExportXlsByView - Named Arguments e Collection Types

**File**: `laravel/Modules/Xot/app/Actions/Export/ExportXlsByView.php`
**Errore**: Named argument issues e collection type mismatches

**Soluzione**: Corretti named arguments e implementati union types

## Batch 2: Errori Risolti (Seconda fase)

### 4. PathHelper::getModules() - Return Type Inference

**File**: `laravel/Modules/Xot/Helpers/PathHelper.php`
**Errore**: `Method should return array<string> but returns array<mixed>`

**Soluzione**: Aggiunto type hint esplicito nella closure:
```php
->map(fn(string $path): string => basename($path))
```

**Motivazione**: PHPStan non riusciva a inferire correttamente il tipo di ritorno di `basename()` all'interno della closure.

### 5. DownloadZipByPathsDiskAction - Missing Return Type e Null Handling

**File**: `laravel/Modules/Xot/app/Actions/File/DownloadZipByPathsDiskAction.php`
**Errori**: 
- Missing return type specification
- `string|null` given to parameter expecting `string`

**Soluzioni**:
- Aggiunto tipo di ritorno: `?BinaryFileResponse`
- Gestione null per `Storage::get()`:
```php
$fileContent = Storage::disk($disk)->get($filePath);
if ($fileContent !== null) {
    $zip->addFromString($attachment . '.pdf', $fileContent);
}
```
- Utilizzato `response()->download()` invece di `Storage::disk()->download()`

### 6. GetViewByClassAction - view-string Type

**File**: `laravel/Modules/Xot/app/Actions/GetViewByClassAction.php`
**Errore**: `Parameter expects view-string|null, string given`

**Soluzione**: Aggiunto cast esplicito per view-string:
```php
/** @var view-string $viewName */
return view($viewName, $params);
```

### 7. SendMailByRecordAction - Undefined Properties/Methods

**File**: `laravel/Modules/Xot/app/Actions/Mail/SendMailByRecordAction.php`
**Errori**:
- Access to undefined property `Model::$email`
- Call to undefined method `Model::option()`
- Call to undefined method `Model::myLogs()`

**Soluzione**: Aggiunti controlli di esistenza runtime:
```php
if (!property_exists($record, 'email') || !isset($record->email)) {
    throw new \InvalidArgumentException('Model must have email property');
}

if (!method_exists($record, 'option')) {
    throw new \InvalidArgumentException('Model must implement option method');
}

if (!method_exists($record, 'myLogs')) {
    throw new \InvalidArgumentException('Model must implement myLogs method');
}
```

### 8. PdfByHtmlAction - Syntax Error e Return Type

**File**: `laravel/Modules/Xot/app/Actions/Pdf/PdfByHtmlAction.php`
**Errori**:
- Syntax error in array (using `->` instead of `=>`)
- Return value not matching declared type

**Soluzioni**:
- Corretti gli arrow operators nell'array:
```php
'html' => $html,
'filename' => $filename,
// etc.
```
- Implementata logica di ritorno corretta con match expression
- Aggiunta generazione PDF tramite PdfData

### 9. MetatagData::getAllColors() - Array Type Mismatch

**File**: `laravel/Modules/Xot/app/Datas/MetatagData.php`
**Errore**: Type mismatch nel merge tra array di tipi diversi

**Soluzione**: Conversione dei tipi custom in formato compatibile con Filament:
```php
public function getAllColors(): array
{
    $filamentColors = $this->getFilamentColors();
    $customColors = [];
    
    foreach ($this->colors as $key => $value) {
        if (is_array($value) && Arr::has($value, 'color')) {
            $colorValue = (string) $value['color'];
            $customColors[$key] = [$colorValue];
        }
    }
    
    return array_merge($filamentColors, $customColors);
}
```

## Pattern Comuni Identificati

1. **Collection Type Handling**: Frequente necessità di gestire incompatibilità tra `Support\Collection` e `Eloquent\Collection`
2. **Missing Return Types**: Molti metodi senza tipo di ritorno esplicito
3. **Null Safety**: Gestione insufficiente dei valori nullable da Laravel API
4. **Array Type Mismatches**: Problemi nel merge di array con tipi diversi
5. **Model Property Access**: Accesso non sicuro a proprietà/metodi di Model

## Best Practices Implementate

1. **Union Types** per gestire multiple Collection types
2. **Null checks** espliciti per API che possono restituire null
3. **Runtime validation** per proprietà/metodi di Model
4. **Type casting** esplicito per view-string e altri tipi speciali
5. **Array conversion** per compatibilità tra formati diversi

## Impatto

- **Total errors fixed**: 9 errori principali
- **Files modified**: 6 files core + documentazione
- **PHPStan compliance**: Livello 9 mantenuto
- **Functionality preserved**: Nessuna perdita di funzionalità

## Note per il Futuro

- Monitorare l'uso di Collection types in nuove implementazioni
- Implementare controlli di tipo più rigorosi in fase di sviluppo
- Documentare contratti per Model custom (email, option, myLogs)
- Considerare l'uso di interfacce per standardizzare i contratti dei Model

## Collegamenti

- [PHPStan Collection Types](phpstan-collection-types.md)
- [Exception Handler Types](exceptions/exception-handler-types.md)
- [PHPStan Level 10 Guide](phpstan_livello10_linee_guida.md)

*Ultimo aggiornamento: Gennaio 2025* 