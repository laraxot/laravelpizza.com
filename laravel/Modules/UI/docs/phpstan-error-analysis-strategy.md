# Strategia Correzione Errori PHPStan - RadioBadge.php

**Data**: 2025-12-23  
**File**: `app/Filament/Forms/Components/RadioBadge.php`  
**Errori**: 3

## 🔍 Analisi Approfondita Errori

### Errore #1: PHPDoc Parse Error (Line 24)

**Messaggio PHPStan**:
```
PHPDoc tag @return has invalid value
(BackedEnum&HasColor&HasIcon|null): Unexpected token "|", expected TOKEN_OTHER at offset 94
```

**Codice Attuale**:
```php
/**
 * Get enum value from string value.
 *
 * @return BackedEnum&HasColor&HasIcon|null
 */
public function getEnumValue(string $value): ?BackedEnum
```

**Problema**: PHPDoc non supporta questa sintassi per intersection types con union types.

**Riflessione Critica**:
- La sintassi `BackedEnum&HasColor&HasIcon|null` non è valida in PHPDoc
- PHPStan suggerisce che il problema è alla posizione 94, dove c'è `|`
- Devo usare parentesi per raggruppare correttamente: `(BackedEnum&HasColor&HasIcon)|null`

**Soluzione Proposta**:
```php
/**
 * Get enum value from string value.
 *
 * @return (BackedEnum&HasColor&HasIcon)|null
 */
```

### Errore #2-3: Undefined Methods getColor() e getIcon()

**Messaggio PHPStan**:
- Line 55: `Call to an undefined method BackedEnum::getColor().`
- Line 62: `Call to an undefined method BackedEnum::getIcon().`

**Codice Attuale**:
```php
public function getColorForOption(string $value): string
{
    Assert::nullOrString($color = $this->getEnumValue($value)?->getColor());
    return $color ?? $this->selectedColor;
}

public function getIconForOption(string $value): ?string
{
    $icon = $this->getEnumValue($value)?->getIcon();
    // ...
}
```

**Problema**: 
- `getEnumValue()` ritorna `?BackedEnum` (tipo base)
- PHPStan non sa che l'enum implementa `HasColor` e `HasIcon`
- Anche se c'è una verifica runtime (line 43), PHPStan non può inferire il tipo

**Riflessione Critica**:
Il codice verifica già a runtime che l'enum implementi le interfacce (line 43), ma PHPStan non può inferire che il valore ritornato abbia quelle interfacce perché:
1. Il tipo di ritorno è `?BackedEnum` (tipo base)
2. PHPStan non può fare narrowing del tipo basandosi su verifiche runtime
3. Serve un PHPDoc corretto o type assertion inline

**Soluzioni Possibili**:

**Opzione 1: PHPDoc corretto + Type assertion inline** (CONSIGLIATA)
```php
/**
 * Get enum value from string value.
 *
 * @return (BackedEnum&HasColor&HasIcon)|null
 */
public function getEnumValue(string $value): ?BackedEnum
{
    // ... verifica runtime ...
    /** @var (BackedEnum&HasColor&HasIcon)|null $res */
    $res = $enumClass::tryFrom($value);
    return $res;
}

public function getColorForOption(string $value): string
{
    $enum = $this->getEnumValue($value);
    if ($enum instanceof HasColor) {
        $color = $enum->getColor();
        return $color ?? $this->selectedColor;
    }
    return $this->selectedColor;
}
```

**Opzione 2: Type guard con instanceof** (PIÙ SICURA)
```php
public function getColorForOption(string $value): string
{
    $enum = $this->getEnumValue($value);
    if ($enum instanceof HasColor) {
        return $enum->getColor() ?? $this->selectedColor;
    }
    return $this->selectedColor;
}
```

**Decisione**: Opzione 2 è più sicura e esplicita, anche se il PHPDoc corretto dovrebbe permettere l'opzione 1.

## 🎯 Strategia Finale

1. **Correggere PHPDoc**: Usare `(BackedEnum&HasColor&HasIcon)|null`
2. **Aggiungere type guards**: Verificare `instanceof HasColor` e `instanceof HasIcon` prima di chiamare metodi
3. **Gestire fallback**: Fornire valori default quando interfacce non implementate

## 📝 Note

Il codice verifica già le interfacce a runtime (line 43), ma PHPStan ha bisogno di type guards espliciti o PHPDoc corretto per inferire i tipi corretti.
