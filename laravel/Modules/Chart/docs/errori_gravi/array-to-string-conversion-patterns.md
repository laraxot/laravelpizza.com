# Array to String Conversion - Pattern e Prevenzione Globale

## Panoramica

L'errore "Array to string conversion" in Laravel/Eloquent si verifica quando si tenta di inserire array PHP direttamente in colonne database string. Questo documento raccoglie pattern comuni e strategie di prevenzione globali per tutti i moduli.

## 🚨 Caso Critico Identificato: <nome progetto> Patient Registration

**Data**: 26 Giugno 2025  
**Impatto**: Sistema registrazione pazienti completamente bloccato  

➡️ **Documentazione completa**: [<nome progetto>: Array to String Error](../laravel/Modules/<nome progetto>/docs/errori/array-to-string-conversion-patient-registration.md)

### Problema Specifico
Conflitto architetturale tra:
- Colonne database string per attachments
- Spatie Media Library per gestione file
- Actions che passano array a `Model::create()`

## Pattern Comuni dell'Errore

### 1. Attachments/Media Library
```php
// ❌ ERRORE: Array in colonna string
$data = ['document' => ['file1.pdf', 'file2.pdf']];
Model::create($data); // Error: Array to string conversion
```

### 2. JSON Data in Fillable
```php
// ❌ ERRORE: Array JSON senza cast
$data = ['metadata' => ['key' => 'value']];
Model::create($data); // Error se metadata è colonna string
```

### 3. Relazioni Multiple
```php
// ❌ ERRORE: ID relazioni come array
$data = ['category_ids' => [1, 2, 3]];
Model::create($data); // Error se category_ids è colonna
```

## Strategie di Prevenzione

### 1. Separazione Dati in Actions
```php
public function execute(array $data): Model
{
    // Identifica campi array
    $arrayFields = ['attachments', 'relations', 'metadata'];
    
    // Separa dati modello da dati speciali
    $modelData = collect($data)->except($arrayFields)->toArray();
    $specialData = collect($data)->only($arrayFields)->toArray();
    
    // Crea modello con dati puliti
    $model = Model::create($modelData);
    
    // Gestisci dati speciali separatamente
    $this->handleSpecialData($model, $specialData);
    
    return $model;
}
```

### 2. Casting Corretto nei Modelli
```php
protected function casts(): array
{
    return [
        'metadata' => 'array',        // Per dati JSON
        'settings' => 'json',         // Per oggetti JSON
        'tags' => 'array',           // Per liste
        'created_at' => 'datetime',  // Per date
    ];
}
```

### 3. Validazione Pre-Insert
```php
// In base Action/Service
protected function validateData(array $data): array
{
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            // Log warning e gestisci separatamente
            logger("Array data detected for field: $key", ['value' => $value]);
            unset($data[$key]);
        }
    }
    return $data;
}
```

### 4. Factory Safe Patterns
```php
// In Factory
public function definition(): array
{
    return [
        'name' => $this->faker->name(),
        // ❌ MAI questo se non c'è cast JSON
        // 'metadata' => ['key' => 'value'],
        
        // ✅ Sempre string o null per campi string
        'description' => $this->faker->text(),
    ];
}
```

## Testing per Prevenzione

### Test Pattern Universale
```php
/** @test */
public function it_handles_array_data_correctly()
{
    // Simula dati con array (caso reale)
    $dataWithArrays = [
        'name' => 'Test Model',
        'attachments' => ['file1.pdf', 'file2.pdf'],
        'metadata' => ['key' => 'value'],
        'tags' => [1, 2, 3],
    ];
    
    // NON deve generare "Array to string conversion"
    $model = app(CreateModelAction::class)->execute($dataWithArrays);
    
    $this->assertInstanceOf(Model::class, $model);
    $this->assertEquals('Test Model', $model->name);
}

/** @test */
public function it_prevents_array_to_string_errors()
{
    // Test che tutti i campi fillable accettino solo tipi corretti
    $model = new Model();
    $fillable = $model->getFillable();
    
    foreach ($fillable as $field) {
        // Se il campo non ha cast array/json, non deve accettare array
        $casts = $model->getCasts();
        if (!in_array($casts[$field] ?? 'string', ['array', 'json', 'object'])) {
            // Test che il campo non accetti array
            $this->expectException(\Exception::class);
            Model::create([$field => ['array', 'value']]);
        }
    }
}
```

## Regole Globali

### 1. Model Design
```php
// ✅ Principio: Un tipo di dato per colonna
protected $fillable = [
    'name',           // string
    'email',          // string
    'settings',       // json (con cast)
    // MAI mescolare array con string senza cast
];

protected function casts(): array
{
    return [
        'settings' => 'json',  // Esplicito per array/object
    ];
}
```

### 2. Action Design
```php
// ✅ Principio: Filtra sempre i dati prima di create()
public function execute(array $data): Model
{
    $modelData = $this->filterModelData($data);
    $model = Model::create($modelData);
    $this->handleSpecialData($model, $data);
    return $model;
}
```

### 3. Migration Design
```php
// ✅ Principio: Tipo colonna deve corrispondere al dato
$table->string('name');          // Solo string
$table->json('metadata');        // Array/Object con cast
$table->text('description');     // String lunghe

// ❌ MAI creare colonne string per array
// $table->string('attachments'); // NO se deve contenere array
```

## Quick Fix Checklist

Quando si incontra "Array to string conversion":

1. **[ ] Identifica il campo**: Quale campo sta causando l'errore?
2. **[ ] Verifica il tipo**: La colonna è string e riceve array?
3. **[ ] Controlla fillable**: Il campo è in `$fillable`?
4. **[ ] Controlla cast**: C'è un cast appropriato per array?
5. **[ ] Fix immediato**: Filtra il campo dall'array before `create()`
6. **[ ] Fix architetturale**: Aggiungi cast o gestisci separatamente
7. **[ ] Test**: Implementa test di regressione
8. **[ ] Documenta**: Aggiorna docs con pattern utilizzato

## Monitoraggio e Alerting

### Log Pattern
```php
// In Actions
public function execute(array $data): Model
{
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            Log::warning('Array data passed to model create', [
                'model' => static::class,
                'field' => $key,
                'data_type' => gettype($value),
                'stack_trace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 5)
            ]);
        }
    }
    // ... resto della logica
}
```

### Sentry Integration
```php
// Per errori critici
if (is_array($value) && !$this->hasValidCast($key)) {
    \Sentry\captureMessage("Potential Array to String conversion", [
        'level' => 'warning',
        'extra' => ['field' => $key, 'model' => get_class($model)]
    ]);
}
```

## Casi Studio per Modulo

### Moduli a Rischio
- **<nome progetto>**: ✅ Documentato - Patient attachments
- **User**: Media uploads, settings JSON
- **Content**: Metadata, tags, categories
- **E-commerce**: Product variants, specifications
- **Form Builder**: Dynamic field definitions

### Pattern di Review
```bash

# Cerca potenziali problemi
grep -r "->create(" Modules/ | grep -v test
grep -r "\$fillable.*=" Modules/ | grep -v test
grep -r "array.*=" Modules/ | grep -v test
```

## Collegamenti

### Documentazione Specifica
- 🚨 [<nome progetto> Patient Registration Error](../laravel/Modules/<nome progetto>/docs/errori/array-to-string-conversion-patient-registration.md)
- 📋 [<nome progetto> Media Library Implementation](../laravel/Modules/<nome progetto>/docs/spatie_media_library_implementation.md)

### Regole AI
- 📋 [Cursor Rules: Attachment Handling](../laravel/.cursor/rules/patient-attachment-handling.mdc)
- 📋 [Windsurf Rules: Attachment Handling](../laravel/.windsurf/rules/patient-attachment-handling.mdc)

### Framework Documentation
- [Laravel Eloquent Mass Assignment](https://laravel.com/docs/eloquent#mass-assignment)
- [Laravel Attribute Casting](https://laravel.com/docs/eloquent-mutators#attribute-casting)
- [Spatie Media Library](https://spatie.be/docs/laravel-medialibrary)

---

**Ultimo aggiornamento**: 26 Giugno 2025  
**Status**: Pattern documentato, caso critico <nome progetto> identificato  
