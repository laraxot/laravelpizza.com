# Enum Translation Rules - Laraxot Framework

## REGOLA CRITICA: TransTrait per Enum

### Principio Assoluto

**SEMPRE utilizzare TransTrait e transClass() negli enum per le traduzioni, MAI implementare match() manualmente**

### Pattern Corretto Obbligatorio

```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Filament\Traits\TransTrait;

enum MyEnum: string implements HasColor, HasIcon, HasLabel
{
    use TransTrait;
    
    case VALUE_ONE = 'value_one';
    case VALUE_TWO = 'value_two';
    
    public function getLabel(): string
    {
        return $this->transClass(self::class, $this->value.'.label');
    }
    
    public function getColor(): string
    {
        return $this->transClass(self::class, $this->value.'.color');
    }
    
    public function getIcon(): string
    {
        return $this->transClass(self::class, $this->value.'.icon');
    }
    
    public function getDescription(): string
    {
        return $this->transClass(self::class, $this->value.'.description');
    }
    
    public function getTooltip(): string
    {
        return $this->transClass(self::class, $this->value.'.tooltip');
    }
    
    public function getHelperText(): string
    {
        return $this->transClass(self::class, $this->value.'.helper_text');
    }
}
```

### Anti-Pattern Vietato

```php
// ❌ MAI FARE QUESTO - Implementazione manuale con match()
public function getLabel(): string
{
    return match ($this) {
        self::VALUE_ONE => __('module::enum.value_one.label'),
        self::VALUE_TWO => __('module::enum.value_two.label'),
    };
}

// ❌ MAI FARE QUESTO - Hardcoded values
public function getColor(): string
{
    return match ($this) {
        self::VALUE_ONE => 'primary',
        self::VALUE_TWO => 'secondary',
    };
}
```

## Motivazione Tecnica

### Vantaggi del TransTrait

1. **DRY (Don't Repeat Yourself)**: Elimina duplicazione di codice
2. **Consistency**: Approccio uniforme in tutto il framework Laraxot
3. **Maintainability**: Centralizzazione della logica di traduzione
4. **Flexibility**: Il trait gestisce fallback e logiche complesse automaticamente
5. **Framework Compliance**: Segue le convenzioni stabilite dal framework
6. **Type Safety**: Gestione automatica dei tipi e validazione
7. **Performance**: Ottimizzazioni interne del trait

### Funzionalità Automatiche del TransTrait

- **Fallback automatico**: Se una traduzione non esiste, usa fallback intelligenti
- **Cache delle traduzioni**: Ottimizzazione automatica delle performance
- **Gestione namespace**: Risoluzione automatica dei namespace di traduzione
- **Validazione**: Controlli automatici di esistenza delle chiavi
- **Debug**: Logging automatico per traduzioni mancanti

## Processo Obbligatorio

### Checklist per Implementazione Enum

1. **✅ SEMPRE** verificare se esiste TransTrait prima di implementare traduzioni
2. **✅ SEMPRE** importare il trait: `use Modules\Xot\Filament\Traits\TransTrait;`
3. **✅ SEMPRE** aggiungere `use TransTrait;` nella classe enum
4. **✅ SEMPRE** usare `transClass()` invece di `match()` per traduzioni
5. **✅ SEMPRE** seguire la convenzione di naming: `$this->value.'.property'`
6. **✅ SEMPRE** implementare tutti i metodi richiesti dalle interfacce
7. **✅ SEMPRE** validare con PHPStan livello 9+

### Struttura File di Traduzione Richiesta

```php
// Modules/ModuleName/lang/it/enum-name.php
return [
    'value_one' => [
        'label' => 'Etichetta Valore Uno',
        'description' => 'Descrizione dettagliata del primo valore',
        'tooltip' => 'Tooltip per il primo valore',
        'helper_text' => 'Testo di aiuto per il primo valore',
        'color' => 'primary',
        'icon' => 'heroicon-o-star',
    ],
    'value_two' => [
        'label' => 'Etichetta Valore Due',
        'description' => 'Descrizione dettagliata del secondo valore',
        'tooltip' => 'Tooltip per il secondo valore',
        'helper_text' => 'Testo di aiuto per il secondo valore',
        'color' => 'secondary',
        'icon' => 'heroicon-o-heart',
    ],
];
```

## Esempi Reali nel Framework

### TableLayoutEnum (Corretto)

```php
enum TableLayoutEnum: string implements HasColor, HasIcon, HasLabel
{
    use TransTrait;
    
    case LIST = 'list';
    case GRID = 'grid';
    
    public function getLabel(): string
    {
        return $this->transClass(self::class, $this->value.'.label');
    }
    
    public function getColor(): string
    {
        return $this->transClass(self::class, $this->value.'.color');
    }
    
    public function getIcon(): string
    {
        return $this->transClass(self::class, $this->value.'.icon');
    }
}
```

## Errori Comuni da Evitare

### 1. Dimenticare il TransTrait

```php
// ❌ ERRORE: Manca use TransTrait
enum MyEnum: string implements HasLabel
{
    // Manca: use TransTrait;
    
    case VALUE = 'value';
    
    public function getLabel(): string
    {
        return $this->transClass(self::class, $this->value.'.label'); // ERRORE!
    }
}
```

### 2. Import Mancante

```php
// ❌ ERRORE: Manca import del trait
namespace Modules\ModuleName\Enums;

// Manca: use Modules\Xot\Filament\Traits\TransTrait;

enum MyEnum: string implements HasLabel
{
    use TransTrait; // ERRORE: Trait non importato
}
```

### 3. Convenzione di Naming Errata

```php
// ❌ ERRORE: Convenzione di naming sbagliata
public function getLabel(): string
{
    return $this->transClass(self::class, 'label.'.$this->value); // ERRORE!
}

// ✅ CORRETTO
public function getLabel(): string
{
    return $this->transClass(self::class, $this->value.'.label');
}
```

## Filosofia del Framework

- **Filosofia**: "Il framework fornisce, noi utilizziamo"
- **Politica**: "Non reinventare la ruota delle traduzioni"
- **Religione**: "TransTrait è sacro per gli enum"
- **Zen**: "Semplicità attraverso il riuso intelligente"

## Validazione e Testing

### PHPStan Compliance

Tutti gli enum devono passare PHPStan livello 9:

```bash
cd /var/www/html/_bases/base_<nome progetto>/laravel
./vendor/bin/phpstan analyze Modules/ModuleName/Enums/MyEnum.php --level=9
```

### Test di Regressione

```php
// Test che l'enum implementi correttamente le traduzioni
public function test_enum_translations(): void
{
    $enum = MyEnum::VALUE_ONE;
    
    $this->assertIsString($enum->getLabel());
    $this->assertNotEmpty($enum->getLabel());
    $this->assertIsString($enum->getColor());
    $this->assertIsString($enum->getIcon());
}
```

## Documentazione Correlata

- [TransTrait Documentation](../laravel/Modules/Xot/docs/traits/trans-trait.md)
- [Translation Standards](translation-standards.md)
- [Enum Best Practices](enum-best-practices.md)
- [Filament Integration](../filament/enum-integration.md)

---

*Ultima modifica: 4 Agosto 2025*
*Versione: 1.0*
*Stato: Regola Critica - Compliance Obbligatoria*
