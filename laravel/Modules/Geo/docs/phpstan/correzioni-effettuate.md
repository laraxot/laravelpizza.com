# Correzioni Effettuate per Errori PHPStan

Questo documento riassume le correzioni applicate per risolvere gli errori PHPStan di livello 9 nel codice.

## Modulo Xot

### 1. GetProductsArrayDummyAction.php

**Errore**: `Parameter #1 $array of static method Illuminate\Support\Arr::only() expects array, mixed given`

**Soluzione**: Aggiunto controllo del tipo prima di utilizzare `Arr::only()`:

```php
// Verifichiamo che $item sia un array prima di usare Arr::only
if (!is_array($item)) {
    return []; // Restituiamo un array vuoto se $item non è un array
}
```

### 2. ExportXlsByCollection.php

**Errore**: `Parameter $fields of class Modules\Xot\Exports\CollectionExport constructor expects array<int, string>, array given`

**Soluzione**: Aggiunta conversione esplicita dei campi in stringhe:

```php
// Assicuriamo che $fields sia un array di stringhe
$stringFields = array_map(function ($field) {
    return (string) $field;
}, array_values($fields));
```

### 3. ExportXlsByLazyCollection.php

**Errore**: `Parameter #3 $fields of class Modules\Xot\Exports\LazyCollectionExport constructor expects array<int, string>, array given`

**Soluzione**: Aggiunta conversione esplicita dei campi in stringhe e migliorata la documentazione:

```php
/**
 * @param array<int, string> $fields Campi da includere nell'export
 */
// Assicuriamo che $fields sia un array di stringhe
$stringFields = array_map(function ($field) {
    return (string) $field;
}, array_values($fields));
```

### 4. ExportXlsByQuery.php

**Errore**: `Parameter #3 $fields of class Modules\Xot\Exports\QueryExport constructor expects array<int, string>, array given`

**Soluzione**: Aggiunta conversione esplicita dei campi in stringhe e migliorata la documentazione:

```php
/**
 * @param array<int, string> $fields Campi da includere nell'export
 */
// Assicuriamo che $fields sia un array di stringhe
$stringFields = array_map(function ($field) {
    return (string) $field;
}, array_values($fields));
```

### 5. ExportXlsByView.php

**Errore**: `Parameter #3 $fields of class Modules\Xot\Exports\ViewExport constructor expects array<string>|null, array|null given`

**Soluzione**: Aggiunta conversione esplicita dei campi in stringhe quando non sono null:

```php
// Se $fields non è null, assicuriamo che sia un array di stringhe
$stringFields = null;
if (is_array($fields)) {
    $stringFields = array_map(function ($field) {
        return (string) $field;
    }, array_values($fields));
}
```

### 6. ExportXlsStreamByLazyCollection.php

**Errori**:
- `Parameter #2 $fields of function Safe\fputcsv expects array<bool|float|int|string|Stringable|null>, array given`
- `Parameter #2 $fields of function Safe\fputcsv expects array<bool|float|int|string|Stringable|null>, mixed given`

**Soluzioni**:
1. Aggiunta conversione esplicita delle intestazioni in stringhe:
   ```php
   // Assicuriamo che le intestazioni siano stringhe
   $headStrings = array_map(function ($item) {
       return (string) $item;
   }, $head);
   ```

2. Migliorata la gestione dei dati nelle righe:
   ```php
   // Gestiamo sia oggetti che possono essere convertiti ad array che array diretti
   if (is_object($value) && method_exists($value, 'toArray')) {
       /** @var array<string|int|float|bool|null> $rowData */
       $rowData = $value->toArray();
   } elseif (is_array($value)) {
       /** @var array<string|int|float|bool|null> $rowData */
       $rowData = $value;
   } else {
       // Se non è né un oggetto con toArray né un array, saltiamo
       continue;
   }
   
   // Convertiamo tutti i valori in stringhe o null
   $safeRowData = array_map(function ($item) {
       if ($item === null) {
           return null;
       }
       return (string) $item;
   }, $rowData);
   ```

### 7. XlsByModelClassAction.php

**Errori**: Numerosi errori relativi a chiamate di metodi su mixed, cast di mixed a string, e altri problemi di tipo.

**Soluzioni**:
1. Aggiunta verifica della classe del modello:
   ```php
   // Verifichiamo che la classe del modello esista
   Assert::classExists($modelClass);
   Assert::subclassOf($modelClass, Model::class);
   ```

2. Migliorata la costruzione della query:
   ```php
   // Creiamo l'istanza del modello e costruiamo la query
   /** @var Model $model */
   $model = app($modelClass);
   $query = $model->query()->with($with);
   
   // Applichiamo le condizioni where
   foreach ($where as $key => $value) {
       $query->where($key, $value);
   }
   ```

### 8. GetFactoryAction.php

**Errore**: `Method Modules\Xot\Actions\Factory\GetFactoryAction::execute() should return Illuminate\Database\Eloquent\Factories\Factory but returns mixed`

**Soluzione**: Aggiunto tipo di ritorno corretto e migliorata la gestione del risultato:

```php
/**
 * @return Factory
 */
public function execute(string $model_class): Factory
{
    // ...
    /** @var Factory $factory */
    $factory = $factory_class::new();
    return $factory;
}
```

### 9. GetPropertiesFromMethodsByModelAction.php

**Errori**:
- `Binary operation \".=\" between mixed and array|string|false results in an error`
- `Parameter #3 $subject of function Safe\preg_replace expects array<string>|string, mixed given`
- `Parameter #1 $name of method Modules\Xot\Actions\Factory\GetFakerAction::execute() expects string, mixed given`

**Soluzioni**:
1. Aggiunta conversione esplicita a stringa:
   ```php
   $code .= (string)$file->current();
   ```

2. Verifica del tipo prima di usare preg_replace:
   ```php
   // Assicuriamo che $code sia una stringa prima di usare preg_replace
   $codeStr = (string)$code;
   $codeStr = trim(preg_replace('/\s\s+/', '', $codeStr));
   ```

3. Conversione esplicita del nome della chiave esterna:
   ```php
   // Otteniamo il nome della chiave esterna
   $name = (string)$relationObj->getForeignKeyName();
   ```

### 10. AutoLabelAction.php

**Errori**:
- `Method Modules\Xot\Actions\Filament\AutoLabelAction::getComponentName() should return string but returns mixed`
- `Cannot cast mixed to string`

**Soluzioni**:
1. Aggiunta conversione esplicita a stringa nei metodi di accesso:
   ```php
   return (string) $component->getName();
   ```

2. Gestione più robusta dei valori di proprietà:
   ```php
   $value = $property->getValue($component);
   return is_string($value) ? $value : (string) $value;
   ```

### 11. GetViewBlocksOptionsByTypeAction.php

**Errori**:
- `Parameter #1 $path of method Modules\Xot\Actions\File\FixPathAction::execute() expects string, mixed given`
- `Method Modules\Xot\Actions\Filament\Block\GetViewBlocksOptionsByTypeAction::execute() should return array<array<string>|string> but returns array`

**Soluzioni**:
1. Aggiunta conversione esplicita del percorso a stringa:
   ```php
   // Assicuriamo che $path sia una stringa
   $pathStr = (string) $path;
   ```

2. Verifica del risultato di glob:
   ```php
   if ($files === false) {
       return []; // Ritorna un array vuoto se non ci sono file
   }
   ```

3. Migliorata la tipizzazione del risultato:
   ```php
   // Assicuriamo che il risultato sia un array di stringhe
   /** @var array<string, string> $result */
   $result = $opts;
   ```

### 12. GenerateFormByFileAction.php e GenerateTableColumnsByFileAction.php

**Errori**: Vari errori relativi a chiamate di metodi su mixed e accesso a proprietà su mixed.

**Soluzioni**:
1. Aggiunta verifica dell'esistenza della classe e dei metodi:
   ```php
   // Verifichiamo che la classe esista e sia una risorsa Filament
   Assert::classExists($class_name);
   
   /** @var Resource $resourceInstance */
   $resourceInstance = app($class_name);
   
   // Verifichiamo che il metodo getModel esista
   if (!method_exists($resourceInstance, 'getModel')) {
       return 0;
   }
   ```

2. Tipizzazione esplicita delle variabili:
   ```php
   /** @var string $modelClass */
   $modelClass = $resourceInstance->getModel();
   
   /** @var Model $modelInstance */
   $modelInstance = app($modelClass);
   ```

### 13. GetModulesNavigationItems.php

**Errore**: `Binary operation \".\" between mixed and '/config.php' results in an error`

**Soluzione**: Aggiunta verifica del tipo e costruzione sicura del percorso:
   ```php
   // Assicuriamoci che $configPath sia una stringa
   $configPathStr = is_string($configPath) ? $configPath : '';
   
   // Costruiamo il percorso completo del file di configurazione
   $configFilePath = $configPathStr.'/config.php';
   
   // Verifichiamo che il file esista
   if (!File::exists($configFilePath)) {
       continue; // Saltiamo questo modulo se il file di configurazione non esiste
   }
   ```

### 14. AssetAction.php

**Errori**:
- `Binary operation \".\" between 'Themes/' and mixed results in an error`
- `Binary operation \".\" between 'themes/' and mixed results in an error`

**Soluzione**: Aggiunta verifica del tipo del tema e costruzione sicura dei percorsi:
   ```php
   // Assicuriamoci che $theme sia una stringa
   $theme = $xot->{$ns};
   Assert::string($theme, 'Il tema deve essere una stringa');
   
   // Costruiamo i percorsi
   $themeResourcePath = 'Themes/'.$theme.'/resources/'.$ns_after;
   $filename_from = app(FixPathAction::class)->execute(base_path($themeResourcePath));
   
   $themeAssetPath = 'themes/'.$theme.'/'.$ns_after;
   $asset = $themeAssetPath;
   ```

### 15. GetModulePathAction.php

**Errori**:
- `Parameter #1 $value of static method Illuminate\Support\Str::lower() expects string, mixed given`
- `Binary operation \".\" between 'Modules/' and mixed results in an error`

**Soluzione**: Aggiunta verifica del tipo degli elementi nell'array:
   ```php
   $moduleNameLower = Str::lower($moduleName);
   
   $foundModule = collect($files)
       ->filter(
           static function ($item) use ($moduleNameLower): bool {
               if (!is_string($item)) {
                   return false;
               }
               return Str::lower($item) === $moduleNameLower;
           }
       )->first();
   
   // Se non troviamo il modulo, restituiamo un percorso di fallback
   if ($foundModule === null || !is_string($foundModule)) {
       return base_path('Modules/'.$moduleName);
   }
   ```

### 16. GetViewNameSpacePathAction.php

**Errori**:
- `Cannot access offset string on mixed`
- `Cannot access offset 0 on mixed`
- `Method Modules\Xot\Actions\File\GetViewNameSpacePathAction::execute() should return string|null but returns mixed`
- `Binary operation \".\" between 'Themes/' and mixed results in an error`

**Soluzione**: Aggiunta verifica dei tipi e gestione sicura degli array:
   ```php
   // Verifichiamo che $viewHints sia un array e che contenga la chiave $ns
   if (is_array($viewHints) && isset($viewHints[$ns])) {
       $paths = $viewHints[$ns];
       // Verifichiamo che $paths sia un array e che contenga almeno un elemento
       if (is_array($paths) && isset($paths[0]) && is_string($paths[0])) {
           return $paths[0];
       }
   }
   
   // Assicuriamoci che $theme_name sia una stringa
   $theme_name = $xot->{$ns};
   
   if (!is_string($theme_name)) {
       return null; // Restituiamo null se il tema non è una stringa
   }
   ```

## Principi Generali Applicati

1. **Controlli di tipo espliciti**: Aggiunta di controlli `is_array()`, `is_object()`, ecc. prima di operazioni su variabili di tipo mixed.
2. **Conversioni esplicite**: Utilizzo di `(string)`, `(int)`, ecc. per convertire esplicitamente i tipi.
3. **Documentazione migliorata**: Aggiunta di PHPDoc con annotazioni di tipo precise.
4. **Gestione dei casi limite**: Aggiunta di controlli per gestire casi in cui i dati potrebbero non essere del tipo atteso.
5. **Utilizzo di Assert**: Utilizzo della libreria Webmozart Assert per verificare le precondizioni.
6. **Tipizzazione con annotazioni**: Utilizzo di annotazioni `@var` per aiutare PHPStan a comprendere i tipi.
7. **Valori di fallback**: Fornitura di valori predefiniti sicuri quando i dati potrebbero essere di tipo errato.

## Prossimi Passi

1. Continuare con la correzione degli altri file nel modulo Xot.
2. Procedere con la correzione degli errori nei moduli User e Notify.
3. Verificare che le correzioni non introducano regressioni nel codice.
4. Eseguire nuovamente PHPStan per verificare che gli errori siano stati risolti.