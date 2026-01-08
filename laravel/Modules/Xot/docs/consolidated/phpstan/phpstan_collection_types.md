# Gestione Tipi Collection in PHPStan - Modulo Xot

## Overview

Questo documento descrive come gestire i problemi di tipo tra `Illuminate\Support\Collection` e `Illuminate\Database\Eloquent\Collection` nel modulo Xot, particolarmente nelle azioni di export Excel.

## Problema Identificato

PHPStan (livello 9) rileva incompatibilità di tipo quando si passa una `Illuminate\Database\Eloquent\Collection<int, Illuminate\Database\Eloquent\Model>` a metodi che si aspettano `Illuminate\Support\Collection<int|string, mixed>`.

### Errori Tipici

```
Parameter #1 $collection of method Modules\Xot\Actions\Export\ExportXlsByCollection::execute() expects
Illuminate\Support\Collection<int|string, mixed>, Illuminate\Database\Eloquent\Collection<int,
Illuminate\Database\Eloquent\Model> given.
```

## Soluzioni Implementate

### 1. Union Types per Parametri Collection

```php
/**
 * @param Collection<int|string, mixed>|EloquentCollection<int, \Illuminate\Database\Eloquent\Model> $collection
 */
public function execute(Collection|EloquentCollection $collection, string $filename = 'export.xlsx'): BinaryFileResponse
{
    // Conversione sicura in Collection base se necessario
    if ($collection instanceof EloquentCollection) {
        $collection = $collection->toBase();
    }
    
    return Excel::download(new CollectionExport($collection), $filename);
}
```

### 2. Gestione Type Inference in Collection Chains

**Problema**: PHPStan non riesce a inferire che `basename($path)` restituisce sempre string

```php
// ❌ PROBLEMA: PHPStan vede array<mixed>
return collect(File::directories($modulesPath))
    ->map(fn($path) => basename($path))
    ->toArray();
```

**Soluzione**: Cast esplicito e annotazione tipo

```php
/**
 * @return array<string>
 */
public static function getModules(): array
{
    $modulesPath = self::$modulesBasePath;
    
    if (!File::exists($modulesPath)) {
        return [];
    }
    
    return collect(File::directories($modulesPath))
        ->map(fn(string $path): string => basename($path))
        ->toArray();
}
```

### 3. Metodi Helper per Conversioni Sicure

```php
/**
 * Converte qualsiasi Collection in Support\Collection.
 *
 * @param Collection<int|string, mixed>|EloquentCollection<int, \Illuminate\Database\Eloquent\Model> $collection
 * @return Collection<int|string, mixed>
 */
private function ensureSupportCollection(Collection|EloquentCollection $collection): Collection
{
    if ($collection instanceof EloquentCollection) {
        return $collection->toBase();
    }
    
    return $collection;
}
```

## Problemi di Inferenza Type con Helper PHP

### Problema con `basename()`

PHPStan non riesce sempre a inferire che `basename()` restituisce string:

```php
// ❌ Problema: tipo inferito come mixed
$fileName = basename($filePath);

// ✅ Soluzione: cast esplicito o type annotation
$fileName = (string) basename($filePath);

// ✅ Soluzione alternativa: annotazione nella closure
->map(fn(string $path): string => basename($path))
```

### Problema con `File::directories()`

`File::directories()` restituisce array di path ma PHPStan può perdere il tipo:

```php
// ❌ Problema: chain lunga perde inferenza
return collect(File::directories($path))
    ->map(fn($dir) => basename($dir))  // $dir seen as mixed
    ->toArray();

// ✅ Soluzione: type hints espliciti
return collect(File::directories($path))
    ->map(fn(string $dir): string => basename($dir))
    ->toArray();
```

## Nuovi Errori Gennaio 2025

### SendMailByRecordAction - Model Property/Method Issues

**Problema**: Accesso a proprietà/metodi non definiti su `Illuminate\Database\Eloquent\Model`

```php
// ❌ ERRORE: Proprietà email non garantita su Model base
$data = [
    'to' => $record->email,                    // property.notFound
    'subject' => $record->option('mail_oggetto'), // method.notFound
    'body_html' => $record->option('mail_testo'), // method.notFound
];

$record->myLogs()->create([...]);              // method.notFound
```

**Soluzione**: Type annotation più specifica o controlli di esistenza

```php
/**
 * @param \Modules\Xot\Contracts\ModelWithEmailInterface $record
 */
public function execute(Model $record, string $mailClass): void
{
    // Verifica che il model abbia le proprietà/metodi necessari
    if (!property_exists($record, 'email')) {
        throw new \InvalidArgumentException('Model must have email property');
    }
    
    if (!method_exists($record, 'option')) {
        throw new \InvalidArgumentException('Model must implement option method');
    }
    
    // Resto del codice...
}
```

### MetatagData Array Types Issues

**Problema**: Mismatch tra tipi array restituiti e dichiarati

```php
// ❌ getThemeColors() should return array<string, string> but returns array<string, array<int, string>|string>
public function getThemeColors(): array
{
    $defaults = $this->getFilamentColors(); // array<string, array<int, string>>
    $custom = [];
    foreach ($this->colors as $key => $value) {
        if (Arr::has($value, 'color')) {
            $custom[$key] = (string) $value['color'];
        }
    }
    return array_merge($defaults, $custom); // ❌ Mix di array<string> e array<array<string>>
}
```

**Soluzione**: Normalizzazione tipo coerente

```php
/**
 * @return array<string, string>
 */
public function getThemeColors(): array
{
    $defaults = $this->getFilamentColors();
    $custom = [];
    
    // Normalizza defaults in formato string
    foreach ($defaults as $key => $colorArray) {
        $defaults[$key] = is_array($colorArray) ? $colorArray[500] ?? $colorArray[0] : $colorArray;
    }
    
    foreach ($this->colors as $key => $value) {
        if (Arr::has($value, 'color')) {
            $custom[$key] = (string) $value['color'];
        }
    }
    
    return array_merge($defaults, $custom);
}
```

## Best Practices Aggiornate

1. **Type Hints Espliciti**: Sempre specificare tipi in closures e parametri
2. **Cast Defensivi**: Usare cast quando l'inferenza PHPStan non è affidabile  
3. **Union Types**: Utilizzare union types per parametri che accettano diverse Collection
4. **Method Existence Checks**: Verificare esistenza proprietà/metodi su Model generici
5. **Array Type Consistency**: Mantenere coerenza nei tipi array di ritorno

## Errori da Evitare

- ❌ Chain di Collection senza type hints
- ❌ Assumere proprietà su Model generico senza controlli
- ❌ Merge di array con tipi incompatibili
- ❌ Return types incompleti o imprecisi

---

**Ultimo aggiornamento**: Gennaio 2025  
**Errori risolti**: ExportXls*, Collection chain inference, Model property access, Array type mismatches 