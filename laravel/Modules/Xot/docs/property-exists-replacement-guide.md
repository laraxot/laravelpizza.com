# Guida Pratica: Sostituzione di property_exists() per Eloquent

## Filosofia

Dopo l'esecuzione di `php artisan ide-helper:models --write --reset`, ogni modello Eloquent ha annotazioni `@property` generate automaticamente. Queste permettono a PHPStan di riconoscere le magic properties senza bisogno di `property_exists()`.

## Pattern di Sostituzione

### Pattern 1: Check di attributo Eloquent

```php
// ❌ BEFORE (WRONG)
if (property_exists($record, 'created_at')) {
    $createdAt = $record->created_at;
}

// ✅ AFTER (CORRECT) - Option A: isset()
if (isset($record->created_at)) {
    $createdAt = $record->created_at;
}

// ✅ AFTER (CORRECT) - Option B: getAttribute()
$createdAt = $record->getAttribute('created_at');
if ($createdAt !== null) {
    // use $createdAt
}

// ✅ AFTER (CORRECT) - Option C: hasAttribute() (Laravel 10+)
if ($record->hasAttribute('created_at')) {
    $createdAt = $record->created_at;
}

// ✅ AFTER (CORRECT) - Option D: Simple null coalescing
$createdAt = $record->created_at ?? now();
```

### Pattern 2: Check di fillable attribute

```php
// ❌ BEFORE (WRONG)
if (property_exists($model, 'tenant_id')) {
    $model->tenant_id = $tenantId;
}

// ✅ AFTER (CORRECT)
if ($model->isFillable('tenant_id')) {
    $model->tenant_id = $tenantId;
}
```

### Pattern 3: Check di relazione Eloquent

```php
// ❌ BEFORE (WRONG)
if (property_exists($record, 'state') && is_object($record->state)) {
    $state = $record->state;
}

// ✅ AFTER (CORRECT) - Option A: isset()
if (isset($record->state) && is_object($record->state)) {
    $state = $record->state;
}

// ✅ AFTER (CORRECT) - Option B: getAttribute()  
$state = $record->getAttribute('state');
if (is_object($state)) {
    // use $state
}
```

### Pattern 4: property_exists su oggetti NON-Eloquent (OK!)

```php
// ✅ CORRECT - JpGraph objects have real properties
if (property_exists($graph->footer, 'right')) {
    $graph->footer->right->SetFont(...);
}

// ✅ CORRECT - State object (Spatie) has real properties
if (property_exists($state, 'name')) {
    $name = $state::$name;
}

// ✅ CORRECT - stdClass or DTO objects
if (property_exists($dto, 'email')) {
    $email = $dto->email;
}
```

## Quando NON sostituire property_exists

1. **Oggetti con proprietà reali** (non magic):
   - JpGraph objects (`$graph->img`, `$graph->footer`, etc.)
   - Spatie State objects (`$state->name`)
   - DTO/Value Objects custom
   - stdClass objects

2. **Librerie terze parti** che usano proprietà pubbliche reali

## Checklist per ogni file modificato

1. ✅ Identificare se l'oggetto è un modello Eloquent
2. ✅ Se Eloquent: sostituire con `isset()`, `hasAttribute()`, o `getAttribute()`
3. ✅ Se non-Eloquent: mantenere `property_exists()` (è corretto!)
4. ✅ Formattare con `./vendor/bin/pint [file]`
5. ✅ Verificare con `./vendor/bin/phpstan analyse [file] --level=10`
6. ✅ (Opzionale) Verificare con `./vendor/bin/phpmd [file] text cleancode,codesize,design`

## Esempi Reali dal Progetto

### Esempio 1: UserResource.php (CORRETTO)
```php
// Usa hasAttribute() invece di property_exists()
if (! $record->hasAttribute('created_at')) {
    return new HtmlString('&mdash;');
}
$createdAt = $record->created_at;
```

### Esempio 2: IconStateColumn.php (CORRETTO)
```php
// Usa isset() per magic property 'state'
if (! isset($record->state) || ! is_object($record->state)) {
    return [];
}

// Ma property_exists() OK su State object (non-Eloquent)
$stateName = property_exists($state, 'name') ? $state::$name : '';
```

### Esempio 3: InteractsWithTenant.php (CORRETTO)
```php
// Usa isFillable() invece di property_exists()
if ($model->isFillable('tenant_id')) {
    $model->tenant_id = $tenant->getKey();
}
```

## Il Perché Profondo

### Livello Tecnico
- Eloquent usa `__get()` e `__set()` per accedere agli attributi
- `property_exists()` cerca proprietà PHP reali, non magic properties
- `property_exists($user, 'email')` → SEMPRE false anche se `email` è in DB

### Livello Performance
- `property_exists()` usa reflection (lento)
- `isset()` usa magic method `__isset()` (veloce)
- `getAttribute()` accede direttamente all'array `$attributes` (velocissimo)

### Livello Static Analysis
- `@property string $email` → PHPStan sa che `$user->email` esiste
- Non serve runtime check, l'analisi statica è sufficiente
- Codice più pulito, meno boilerplate

### Livello Filosofico (Lo Zen)
> "Non cercare l'anima guardando il corpo.  
> L'anima si manifesta attraverso le azioni (__get), non attraverso l'esistenza fisica (property_exists)."

## Conclusione

**Regola d'oro:** 
- Eloquent Model? → NO `property_exists()`, usa `isset()` o `hasAttribute()`
- Altro object? → `property_exists()` va bene!

