# Type Safety Patterns - Progressioni Module

## 🎯 **Architectural Patterns & Business Domain**

### Business Domain Overview
Il modulo **Progressioni** implementa un sistema complesso per la gestione delle progressioni economiche del personale, caratterizzato da:

- **Schede Valutazione**: Documenti di valutazione per progressioni
- **Criteri di Precedenza**: Regole per determinare l'ordine di progressione
- **Calcoli Complessi**: Punteggi, pesi e conversioni
- **Multi-Model Operations**: Operazioni su modelli correlati

### Core Architectural Patterns

#### 1. **Dynamic Field Conversion Pattern**
```php
/**
 * Converte un campo in base al tipo di conversione specificato.
 * Usato per normalizzare punteggi in scale diverse.
 */
public function convertedIn(string $field, int $converted_in): float|int|null
{
    /** @var int|float|null $fieldValue */
    $fieldValue = $this->$field;
    
    switch ($converted_in) {
        case 1: // 'max 10 valutatore'
            return $this->rapportatoMax10Valutatore($field);
        case 2: // 'se stesso'
            return $fieldValue;
        case 3: // 'da 4 a 10'
            return $fieldValue !== null ? (float) $fieldValue * 2.5 : null;
        // ... altri casi
    }
}
```

#### 2. **Multi-Model Refresh Pattern**
```php
/**
 * Aggiorna record di diversi modelli per un anno specifico.
 * Pattern usato per refresh automatico dei dati.
 */
public function execute(string $modelClass, string $fieldname, int|string $year): void
{
    /** @var \Illuminate\Database\Eloquent\Builder $query */
    $query = $modelClass::query();
    
    /** @var \Illuminate\Database\Eloquent\Collection $rows */
    $rows = $query->where($fieldname, $year)->get();
    
    foreach ($rows as $row) {
        /** @var \Illuminate\Database\Eloquent\Model $row */
        $row->update(['refreshed_at' => now()]);
    }
}
```

#### 3. **Complex Calculation Pattern**
```php
/**
 * Calcola il punteggio totale considerando pesi e criteri.
 * Pattern per operazioni matematiche complesse.
 */
public function getTotaleAttribute(): float
{
    /** @var float $exp */
    $exp = $this->esperienza_acquisita ?? 0.0;
    /** @var float $pesoExp */
    $pesoExp = $this->peso_esperienza_acquisita ?? 0.0;
    
    return ($exp * $pesoExp) + /* altri calcoli */;
}
```

## 🛡️ **Type Safety Implementation Patterns**

### Pattern 1: Dynamic Property Access with Type Safety

#### Problem
Accesso dinamico a proprietà senza validazione tipo:
```php
// ❌ UNSAFE
$value = $this->$fieldName; // PHPStan: Binary operation with mixed
return $value * 2.5;
```

#### Solution
Validazione tipo con PHPDoc e null checks:
```php
// ✅ TYPE-SAFE
/**
 * @param string $fieldName Nome del campo da accedere
 * @return float|int|null Valore convertito
 */
public function getConvertedValue(string $fieldName): float|int|null
{
    /** @var int|float|null $fieldValue */
    $fieldValue = $this->$fieldName;
    
    if ($fieldValue === null) {
        return null;
    }
    
    return (float) $fieldValue * 2.5;
}
```

### Pattern 2: Multi-Model Operations with Type Safety

#### Problem
Operazioni su classi modello dinamiche:
```php
// ❌ UNSAFE
$rows = $modelClass::where($field, $value)->get();
foreach ($rows as $row) {
    $row->update($data); // PHPStan: Cannot call method on mixed
}
```

#### Solution
Type hints e PHPDoc per operazioni sicure:
```php
// ✅ TYPE-SAFE
/**
 * @param class-string<\Illuminate\Database\Eloquent\Model> $modelClass
 * @param string $field Campo da filtrare
 * @param mixed $value Valore del filtro
 */
public function refreshModelRecords(string $modelClass, string $field, mixed $value): void
{
    /** @var \Illuminate\Database\Eloquent\Builder $query */
    $query = $modelClass::query();
    
    /** @var \Illuminate\Database\Eloquent\Collection $rows */
    $rows = $query->where($field, $value)->get();
    
    foreach ($rows as $row) {
        /** @var \Illuminate\Database\Eloquent\Model $row */
        $row->update(['refreshed_at' => now()]);
    }
}
```

### Pattern 3: Complex Calculations with Type Safety

#### Problem
Calcoli matematici su proprietà non tipizzate:
```php
// ❌ UNSAFE
return $this->field1 * $this->field2 + $this->field3; // PHPStan: Mixed operations
```

#### Solution
Extraction e validazione valori:
```php
// ✅ TYPE-SAFE
public function calculateTotalScore(): float
{
    /** @var float $field1 */
    $field1 = $this->field1 ?? 0.0;
    /** @var float $field2 */
    $field2 = $this->field2 ?? 0.0;
    /** @var float $field3 */
    $field3 = $this->field3 ?? 0.0;
    
    return ($field1 * $field2) + $field3;
}
```

## 🎨 **Filament Resource Type Safety Patterns**

### Pattern 4: Proper getFormSchema() Implementation

#### Problem
Return type mismatch in Filament resources:
```php
// ❌ INCORRECT
#[Override]
public static function getFormSchema(): array<string, \Filament\Forms\Components\Component>
{
    return [
        TextInput::make('id')->disabled(), // PHPStan: Return type mismatch
    ];
}
```

#### Solution
Proper array structure with string keys:
```php
// ✅ CORRECT
#[Override]
public static function getFormSchema(): array
{
    return [
        'id' => TextInput::make('id')->disabled(),
        'name' => TextInput::make('name')->required(),
    ];
}
```

### Pattern 5: Record Access in Filament Pages

#### Problem
Accesso a proprietà record senza tipo:
```php
// ❌ UNSAFE
public function mount($record): void
{
    $this->name = $record->name; // PHPStan: Cannot access property on mixed
}
```

#### Solution
Type hint per il record:
```php
// ✅ TYPE-SAFE
public function mount(Progressioni $record): void
{
    $this->name = $record->name;
}
```

## 🔧 **Utility Patterns for Common Scenarios**

### Pattern 6: Safe Dynamic Method Calls

```php
/**
 * Chiama dinamicamente un metodo con validazione tipo.
 */
public function callDynamicMethod(string $methodName, array $parameters = []): mixed
{
    if (!method_exists($this, $methodName)) {
        throw new \InvalidArgumentException("Method {$methodName} does not exist");
    }
    
    return $this->$methodName(...$parameters);
}
```

### Pattern 7: Array Operations with Type Safety

```php
/**
 * Filtra array mantenendo la type safety.
 */
public function filterActiveUsers(array $users): array
{
    return array_filter($users, function ($user) {
        /** @var User $user */
        return $user->is_active === true;
    });
}
```

## 📋 **Implementation Checklist**

### For Dynamic Property Access
- [ ] Usa `/** @var */` annotations per proprietà dinamiche
- [ ] Implementa null checks prima delle operazioni
- [ ] Usa type casting appropriato

### For Multi-Model Operations
- [ ] Specifica `class-string` nei parametri
- [ ] Usa PHPDoc per query builder e collection
- [ ] Type hint per oggetti iterati

### For Filament Resources
- [ ] Usa array con chiavi string per `getFormSchema()`
- [ ] Type hint espliciti per record
- [ ] Segui pattern XotBaseResource

### For Complex Calculations
- [ ] Estrai valori con type annotations
- [ ] Gestisci valori null appropriatamente
- [ ] Usa type casting per operazioni matematiche

## 🚀 **Performance Considerations**

### Type Safety vs Performance
- **Type annotations** non hanno impatto runtime
- **Null checks** migliorano robustezza senza costo significativo
- **Proper typing** permette ottimizzazioni PHP

### Best Practices
1. **Minimal type annotations** - Solo dove necessario
2. **Strategic null checks** - Evita checks ridondanti
3. **Efficient type casting** - Usa casting appropriato

---

**Created**: November 2025  
**Status**: ✅ ACTIVE  
**PHPStan Compliance**: Level 10 Target  
**Pattern Coverage**: Complete