# PHPStan Return Type Mismatch Errors

## Problema

PHPStan segnala errori quando il tipo di ritorno dichiarato non corrisponde al tipo effettivamente restituito:

```
Method Modules\Geo\Models\Place::getFormattedAddressAttribute() should return string but returns mixed.
```

## Causa Root

1. **Dichiarazioni Imprecise**: Tipo di ritorno dichiarato diverso dal valore effettivo
2. **Valori Mixed**: Metodi che restituiscono valori non tipizzati
3. **Logica Condizionale**: Percorsi di codice che restituiscono tipi diversi

## Errore Specifico in Place.php

### getFormattedAddressAttribute()

```php
// ❌ PROBLEMA - Restituisce mixed invece di string
public function getFormattedAddressAttribute(): string
{
    // Logica che può restituire mixed
    return $this->some_property; // mixed
}
```

## Soluzioni

### 1. Correzione con Cast Sicuro

```php
// ✅ CORRETTO - Cast sicuro a string
public function getFormattedAddressAttribute(): string
{
    $value = $this->some_property;
    return \Modules\Xot\Actions\Cast\SafeStringCastAction::cast($value, '');
}
```

### 2. Controllo di Tipo Esplicito

```php
// ✅ CORRETTO - Controllo di tipo
public function getFormattedAddressAttribute(): string
{
    $value = $this->some_property;
    
    if (is_string($value)) {
        return $value;
    }
    
    return ''; // fallback sicuro
}
```

### 3. Utilizzo di Null Coalescing

```php
// ✅ CORRETTO - Operatore null coalescing
public function getFormattedAddressAttribute(): string
{
    return (string) ($this->some_property ?? '');
}
```

## Pattern di Correzione per Place Model

### Analisi del Metodo

Prima di correggere, identificare cosa restituisce effettivamente il metodo:

```php
// Esempio di metodo problematico
public function getFormattedAddressAttribute(): string
{
    // Questo potrebbe restituire mixed se address non è tipizzato
    return $this->address;
}
```

### Implementazione Corretta

```php
/**
 * Get formatted address attribute.
 *
 * @return string
 */
public function getFormattedAddressAttribute(): string
{
    // Utilizzo di safe casting per garantire string
    $address = \Modules\Xot\Actions\Cast\SafeStringCastAction::cast($this->address, '');
    
    // Formattazione aggiuntiva se necessaria
    return trim($address) ?: 'Indirizzo non disponibile';
}
```

## Altri Pattern Comuni

### 1. Metodi che Restituiscono Array

```php
// ❌ PROBLEMA
public function getDataAttribute(): array
{
    return $this->data; // potrebbe essere null o string
}

// ✅ SOLUZIONE
public function getDataAttribute(): array
{
    $data = $this->data;
    
    if (is_array($data)) {
        return $data;
    }
    
    if (is_string($data)) {
        return json_decode($data, true) ?: [];
    }
    
    return [];
}
```

### 2. Metodi che Restituiscono Numeri

```php
// ❌ PROBLEMA
public function getScoreAttribute(): float
{
    return $this->score; // potrebbe essere string o null
}

// ✅ SOLUZIONE
public function getScoreAttribute(): float
{
    return \Modules\Xot\Actions\Cast\SafeFloatCastAction::cast($this->score, 0.0);
}
```

### 3. Metodi che Restituiscono Bool

```php
// ❌ PROBLEMA
public function getIsActiveAttribute(): bool
{
    return $this->is_active; // potrebbe essere string o int
}

// ✅ SOLUZIONE
public function getIsActiveAttribute(): bool
{
    $value = $this->is_active;
    
    if (is_bool($value)) {
        return $value;
    }
    
    if (is_numeric($value)) {
        return (bool) $value;
    }
    
    if (is_string($value)) {
        return in_array(strtolower($value), ['true', '1', 'yes', 'on'], true);
    }
    
    return false;
}
```

## Best Practices

### 1. Sempre Validare Input

```php
public function getFormattedValueAttribute(): string
{
    // Validazione esplicita
    if (!isset($this->value)) {
        return '';
    }
    
    return \Modules\Xot\Actions\Cast\SafeStringCastAction::cast($this->value, '');
}
```

### 2. Utilizzare Union Types Quando Appropriato

```php
// Se il metodo può legittimamente restituire tipi diversi
public function getValue(): string|null
{
    return $this->value; // OK se value può essere string o null
}
```

### 3. Documentare Comportamento

```php
/**
 * Get formatted address combining multiple fields.
 * Returns empty string if no address components are available.
 *
 * @return string The formatted address or empty string
 */
public function getFormattedAddressAttribute(): string
{
    $components = array_filter([
        $this->street,
        $this->city,
        $this->postal_code,
    ]);
    
    return implode(', ', $components);
}
```

## Script di Validazione

```bash
#!/bin/bash

# Check for return type mismatches

./vendor/bin/phpstan analyze Modules/Geo/Models/Place.php --level=9 --error-format=table | grep "should return"
```

## Correzione Automatica per Accessor

```php
// Script per identificare accessor problematici
grep -n "Attribute.*string" Modules/*/Models/*.php | grep -v "SafeStringCastAction"
```

## Note Tecniche

1. **Accessor Laravel**: Gli accessor devono sempre restituire il tipo dichiarato
2. **Mutator**: I mutator possono accettare mixed ma devono gestire la conversione
3. **Casting**: Utilizzare il sistema di casting di Laravel quando possibile
4. **Performance**: I safe cast hanno overhead minimo

## Riferimenti

- [Laravel Accessors & Mutators](https://laravel.com/project_docs/eloquent-mutators)
- [PHPStan Return Types](https://phpstan.org/writing-php-code/phpdoc-types#return-types)
- [Safe Casting Actions](../../Xot/project_docs/safe-casting-actions.md)

## Backlink

- [Root PHPStan Rules](../../../project_docs/phpstan_rules.md)
- [Geo Module Structure](./structure.md)
- [Class Not Found Errors](./class_not_found_errors.md)

*Ultimo aggiornamento: 2025-07-31*
