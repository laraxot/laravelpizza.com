# Analisi Errori PHPStan - XotBaseRelationManager

**Data**: 2025-12-23  
**File**: `app/Filament/Resources/RelationManagers/XotBaseRelationManager.php`

## 🔍 Errori PHPStan Originali (3)

### Errore #1: Line 80 - Schema::components() Type Mismatch

**Messaggio PHPStan**:
```
Parameter #1 $components of method Filament\Schemas\Schema::components() expects 
array<Illuminate\Contracts\Support\Htmlable|string>|Closure|Illuminate\Contracts\Support\Htmlable|string, 
array given.
```

**Codice Originale**:
```php
$schema->components($this->getTableColumns());  // Line 80 - ERRATO (non era questo!)
```

**Analisi**:
- L'errore era in realtà su `form()` method, non su `getTableColumns()`
- `getFormSchema()` restituisce `array<Component>` ma Schema::components() si aspetta tipo più generico
- PHPStan non può inferire compatibilità

---

### Errore #2: Line 185 - canDeleteBulk() Type Mismatch

**Messaggio PHPStan**:
```
Parameter #1 $record of method canDeleteBulk() expects Model|null,
Model|stdClass given.
```

**Analisi**:
- Filament passa `Model|stdClass` nei bulk actions
- Metodo accettava solo `?Model`

---

### Errore #3: Line 189 - canDetachBulk() Type Mismatch

**Messaggio PHPStan**: Stesso problema di canDeleteBulk()

---

## 🎯 Soluzioni Applicate

### Soluzione Errore #1

**Problema**: Schema::components() si aspetta `array<Component|Action|ActionGroup|string|Htmlable>` ma riceve `array<Component>`

**Soluzione**:
1. Aggiunto import corretto: `use Filament\Support\Components\Component;`
2. PHPDoc corretto in getFormSchema(): `@return array<int|string, \Filament\Support\Components\Component>`
3. Rimossa annotazione inline ridondante (Component è già compatibile con la signature)

**Codice Finale**:
```php
final public function form(Schema $schema): Schema
{
    $components = $this->getFormSchema();
    // Schema::components() accepts: array<Component|Action|ActionGroup|string|Htmlable>|...
    // getFormSchema() returns array<Component>, which matches the signature
    return $schema->components($components);
}

/**
 * Get form schema.
 *
 * @return array<int|string, \Filament\Support\Components\Component>
 */
public function getFormSchema(): array
{
    return $this->getResource()::getFormSchema();
}
```

### Soluzione Errori #2 e #3

**Problema**: Filament passa `Model|stdClass|null` ma metodo accettava solo `?Model`

**Soluzione**:
```php
/**
 * Determine if the bulk delete action can be performed on the given record.
 *
 * @param \Illuminate\Database\Eloquent\Model|\stdClass|null $record
 */
public function canDeleteBulk(Model|\stdClass|null $record): bool
{
    if ($record instanceof \stdClass) {
        // For stdClass records (lightweight bulk operations), allow by default
        return true;
    }

    return true;
}
```

Stessa soluzione per `canDetachBulk()`.

---

## ✅ Risultato Finale

**PHPStan**: ✅ **0 errors**  
**Pint**: ✅ **PASSED**  
**PHPMD**: ⚠️ Warning pre-esistenti (non bloccanti)

---

## 📝 Note Importanti

1. **Component Import**: Usare `Filament\Support\Components\Component` (non `Filament\Forms\Components\Component`)
2. **Schema::components()**: Accetta union type complesso, Component è compatibile
3. **stdClass nei bulk actions**: Filament usa stdClass per performance, gestirlo appropriatamente
