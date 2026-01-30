# Enum Translation Pattern - Regola Critica

## ⚠️ REGOLA CRITICA: SEMPRE USARE transClass() NEGLI ENUM ⚠️

**SEMPRE** usare `transClass()` negli enum per le traduzioni. MAI usare `__()` o `trans()` direttamente.

## Pattern Corretto

### ✅ CORRETTO - SEMPRE USARE QUESTO PATTERN

```php
<?php

declare(strict_types=1);

namespace Modules\UI\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Filament\Traits\TransTrait;

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

### ❌ ERRATO - MAI FARE QUESTO

```php
// ❌ ERRATO - MAI USARE __() O trans() DIRETTAMENTE
public function getLabel(): string
{
    return __('ui::table-layout.'.$this->value.'.label');  // ❌ ERRORE CRITICO
}

public function getColor(): string
{
    return trans('ui::table-layout.'.$this->value.'.color');  // ❌ ERRORE CRITICO
}
```

## Struttura File di Traduzione

### Posizionamento
- **Moduli**: `Modules/{ModuleName}/lang/{locale}/enum-name.php`
- **Temi**: `Themes/{ThemeName}/lang/{locale}/enum-name.php`

### Struttura Espansa Obbligatoria
```php
// laravel/Modules/UI/lang/it/table-layout.php
return [
    'list' => [
        'label' => 'Lista',
        'color' => 'primary',
        'icon' => 'heroicon-o-list-bullet',
        'description' => 'Visualizzazione tradizionale in formato tabella',
        'tooltip' => 'Mostra i dati in righe di tabella',
        'helper_text' => 'Layout ottimizzato per dati strutturati',
    ],
    'grid' => [
        'label' => 'Griglia',
        'color' => 'success',
        'icon' => 'heroicon-o-squares-2x2',
        'description' => 'Visualizzazione a griglia responsive',
        'tooltip' => 'Mostra i dati in formato griglia con carte',
        'helper_text' => 'Layout ottimizzato per contenuti multimediali',
    ],
];
```

## Motivazione

### 1. Type Safety
- `transClass()` è tipizzato e sicuro
- Evita errori di runtime
- Migliore supporto IDE

### 2. Namespace Automatico
- Usa automaticamente il namespace della classe
- Non serve specificare manualmente il modulo
- Riduce errori di digitazione

### 3. Consistenza
- Pattern uniforme in tutto il progetto
- Facile da mantenere e debuggare
- Standardizzazione delle traduzioni

### 4. Manutenibilità
- Facile da testare
- Override per temi/moduli specifici
- Struttura gerarchica chiara

### 5. Override
- Permette override delle traduzioni
- Supporto per temi personalizzati
- Flessibilità per moduli specifici

## Regole Fondamentali

### 1. TransTrait Obbligatorio
- **SEMPRE** `use TransTrait;` negli enum
- **SEMPRE** `declare(strict_types=1);`
- **SEMPRE** interfacce Filament appropriate

### 2. Pattern transClass()
- **SEMPRE** `$this->transClass(self::class, $this->value.'.chiave')`
- **MAI** `__()` o `trans()` direttamente
- **MAI** concatenazione manuale di stringhe

### 3. Struttura Traduzioni
- **SEMPRE** struttura espansa per tutti i valori
- **SEMPRE** `label`, `color`, `icon` per ogni valore
- **SEMPRE** chiavi in inglese, valori nella lingua target

### 4. Naming Convention
- **SEMPRE** file di traduzione con nome dell'enum
- **SEMPRE** valori enum in minuscolo
- **SEMPRE** chiavi di traduzione coerenti

## Esempi di Implementazione

### Enum Status
```php
enum StatusEnum: string implements HasColor, HasIcon, HasLabel
{
    use TransTrait;
    
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case PENDING = 'pending';

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

### File di Traduzione Status
```php
// laravel/Modules/ModuleName/lang/it/status-enum.php
return [
    'active' => [
        'label' => 'Attivo',
        'color' => 'success',
        'icon' => 'heroicon-o-check-circle',
    ],
    'inactive' => [
        'label' => 'Inattivo',
        'color' => 'danger',
        'icon' => 'heroicon-o-x-circle',
    ],
    'pending' => [
        'label' => 'In Attesa',
        'color' => 'warning',
        'icon' => 'heroicon-o-clock',
    ],
];
```

## Controllo Automatico

Prima di ogni commit, verificare:
- [ ] `use TransTrait;` presente negli enum
- [ ] `transClass()` usato in tutti i metodi di traduzione
- [ ] Nessun `__()` o `trans()` diretto negli enum
- [ ] Struttura espansa nei file di traduzione
- [ ] Sincronizzazione tra lingue

## Penalità per Violazioni

- ❌ Codice non conforme
- ❌ Difficoltà di manutenzione
- ❌ Inconsistenza nelle traduzioni
- ❌ Impossibilità di override
- ❌ Errori di type safety

## Collegamenti

- [Enum Standards](enum_standards.md)
- [Translation Management](translation-management.md)
- [TableLayoutEnum Guide](../laravel/Modules/UI/docs/table-layout-enum-complete-guide.md)

## Ultimo Aggiornamento
2025-01-27 - Regola critica per enum translation pattern 