# REGOLA CRITICA: Usa SEMPRE transClass() negli Enum

## Data: 2025-01-06

## ✅ CORRETTO - Implementazione Enum con TransTrait

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
        return $this->transClass(self::class, $this->value . '.label');
    }

    public function getColor(): string
    {
        return $this->transClass(self::class, $this->value . '.color');
    }

    public function getIcon(): string
    {
        return $this->transClass(self::class, $this->value . '.icon');
    }

    public function getDescription(): string
    {
        return $this->transClass(self::class, $this->value . '.description');
    }

    public function getTooltip(): string
    {
        return $this->transClass(self::class, $this->value . '.tooltip');
    }

    public function getHelperText(): string
    {
        return $this->transClass(self::class, $this->value . '.helper_text');
    }
}
```

## ❌ ERRORE - Non fare mai questo

```php
// ❌ ERRORE - Non usare mai match() per traduzioni
public function getLabel(): string
{
    return match ($this) {
        self::LIST => __('ui::table-layout.list.label'),
        self::GRID => __('ui::table-layout.grid.label'),
    };
}

// ❌ ERRORE - Non hardcodare valori
public function getColor(): string
{
    return match ($this) {
        self::LIST => 'primary',
        self::GRID => 'secondary',
    };
}
```

## Perché questa Regola è Critica

### 1. Centralizzazione Traduzioni
- Tutte le traduzioni sono nei file `lang/`
- Facile manutenzione e aggiornamento
- Sincronizzazione automatica tra lingue

### 2. Type Safety
- Il `transClass()` gestisce automaticamente le traduzioni
- Controllo automatico delle traduzioni mancanti
- Struttura coerente per tutti gli enum

### 3. Performance
- Cache delle traduzioni ottimizzata
- Nessun overhead di match() per ogni chiamata
- Codice più pulito e manutenibile

### 4. Estensibilità
- Facile aggiungere nuove proprietà
- Struttura scalabile per enum complessi
- Pattern riutilizzabile

## Struttura Traduzioni Obbligatoria

### File: `Modules/UI/lang/it/table-layout.php`
```php
<?php

declare(strict_types=1);

return [
    'list' => [
        'label' => 'Lista',
        'description' => 'Visualizzazione a lista tradizionale',
        'tooltip' => 'Mostra elementi in formato lista',
        'helper_text' => 'Layout tradizionale con righe e colonne',
        'color' => 'primary',
        'icon' => 'heroicon-o-list-bullet',
    ],
    'grid' => [
        'label' => 'Griglia',
        'description' => 'Visualizzazione a griglia con card',
        'tooltip' => 'Mostra elementi in formato griglia',
        'helper_text' => 'Layout a griglia con card responsive',
        'color' => 'secondary',
        'icon' => 'heroicon-o-squares-2x2',
    ],
];
```

## Pattern Standard per Enum

### 1. Import TransTrait
```php
use Modules\Xot\Filament\Traits\TransTrait;

enum MyEnum: string implements HasColor, HasIcon, HasLabel
{
    use TransTrait;

    case VALUE1 = 'value1';
    case VALUE2 = 'value2';
}
```

### 2. Metodi Standard
```php
public function getLabel(): string
{
    return $this->transClass(self::class, $this->value . '.label');
}

public function getColor(): string
{
    return $this->transClass(self::class, $this->value . '.color');
}

public function getIcon(): string
{
    return $this->transClass(self::class, $this->value . '.icon');
}

public function getDescription(): string
{
    return $this->transClass(self::class, $this->value . '.description');
}

public function getTooltip(): string
{
    return $this->transClass(self::class, $this->value . '.tooltip');
}

public function getHelperText(): string
{
    return $this->transClass(self::class, $this->value . '.helper_text');
}
```

### 3. Struttura Traduzioni
```php
// File: Modules/ModuleName/lang/it/enum_name.php
return [
    'value1' => [
        'label' => 'Etichetta 1',
        'description' => 'Descrizione 1',
        'tooltip' => 'Tooltip 1',
        'helper_text' => 'Helper text 1',
        'color' => 'primary',
        'icon' => 'heroicon-o-icon1',
    ],
    'value2' => [
        'label' => 'Etichetta 2',
        'description' => 'Descrizione 2',
        'tooltip' => 'Tooltip 2',
        'helper_text' => 'Helper text 2',
        'color' => 'secondary',
        'icon' => 'heroicon-o-icon2',
    ],
];
```

## Checklist Pre-Implementazione

Prima di creare un nuovo Enum:

- [ ] Importare `TransTrait`
- [ ] Implementare tutti i metodi standard con `transClass()`
- [ ] Creare file traduzioni in `lang/it/`, `lang/en/`, `lang/de/`
- [ ] Struttura espansa completa per ogni valore
- [ ] Sincronizzazione IT/EN/DE
- [ ] Testare traduzioni in ambiente di sviluppo

## Esempi di Errori Comuni

### ❌ ERRORE - Match per traduzioni
```php
public function getLabel(): string
{
    return match ($this) {
        self::LIST => __('ui::table-layout.list.label'),
        self::GRID => __('ui::table-layout.grid.label'),
    };
}
```

### ✅ CORRETTO - transClass()
```php
public function getLabel(): string
{
    return $this->transClass(self::class, $this->value . '.label');
}
```

### ❌ ERRORE - Valori hardcoded
```php
public function getColor(): string
{
    return match ($this) {
        self::LIST => 'primary',
        self::GRID => 'secondary',
    };
}
```

### ✅ CORRETTO - transClass()
```php
public function getColor(): string
{
    return $this->transClass(self::class, $this->value . '.color');
}
```

## Verifica Automatica

### PHPStan Rule (Ideale)
```php
// Regola PHPStan per rilevare match() in enum
// Implementare in phpstan.neon
rules:
    - rule: Never use match() for translations in enums
```

### Code Review Checklist
- [ ] TransTrait importato
- [ ] Tutti i metodi usano `transClass()`
- [ ] Nessun `match()` per traduzioni
- [ ] Traduzioni implementate in tutte le lingue
- [ ] Struttura espansa completa

## Penalità per Violazioni

### Livello 1 - Warning
- Commento nel code review
- Richiesta di correzione

### Livello 2 - Blocco
- Blocco del merge
- Correzione obbligatoria

### Livello 3 - Sanzione
- Documentazione della violazione
- Training obbligatorio

## Collegamenti

- [Translation Standards](../../../docs/translation_standards.md)
- [Filament Best Practices](../../../docs/filament_best_practices.md)
- [TransTrait Documentation](../../Xot/docs/trans_trait_usage.md)

## Memoria Permanente

**RICORDA SEMPRE**:
- SEMPRE `TransTrait` negli enum
- SEMPRE `transClass()` per traduzioni
- MAI `match()` per traduzioni
- SEMPRE struttura espansa nelle traduzioni
- SEMPRE sincronizzazione IT/EN/DE

*Ultimo aggiornamento: 2025-01-06*
# REGOLA CRITICA: Usa SEMPRE transClass() negli Enum

## Data: 2025-01-06

## ✅ CORRETTO - Implementazione Enum con TransTrait

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
        return $this->transClass(self::class, $this->value . '.label');
    }

    public function getColor(): string
    {
        return $this->transClass(self::class, $this->value . '.color');
    }

    public function getIcon(): string
    {
        return $this->transClass(self::class, $this->value . '.icon');
    }

    public function getDescription(): string
    {
        return $this->transClass(self::class, $this->value . '.description');
    }

    public function getTooltip(): string
    {
        return $this->transClass(self::class, $this->value . '.tooltip');
    }

    public function getHelperText(): string
    {
        return $this->transClass(self::class, $this->value . '.helper_text');
    }
}
```

## ❌ ERRORE - Non fare mai questo

```php
// ❌ ERRORE - Non usare mai match() per traduzioni
public function getLabel(): string
{
    return match ($this) {
        self::LIST => __('ui::table-layout.list.label'),
        self::GRID => __('ui::table-layout.grid.label'),
    };
}

// ❌ ERRORE - Non hardcodare valori
public function getColor(): string
{
    return match ($this) {
        self::LIST => 'primary',
        self::GRID => 'secondary',
    };
}
```

## Perché questa Regola è Critica

### 1. Centralizzazione Traduzioni
- Tutte le traduzioni sono nei file `lang/`
- Facile manutenzione e aggiornamento
- Sincronizzazione automatica tra lingue

### 2. Type Safety
- Il `transClass()` gestisce automaticamente le traduzioni
- Controllo automatico delle traduzioni mancanti
- Struttura coerente per tutti gli enum

### 3. Performance
- Cache delle traduzioni ottimizzata
- Nessun overhead di match() per ogni chiamata
- Codice più pulito e manutenibile

### 4. Estensibilità
- Facile aggiungere nuove proprietà
- Struttura scalabile per enum complessi
- Pattern riutilizzabile

## Struttura Traduzioni Obbligatoria

### File: `Modules/UI/lang/it/table-layout.php`
```php
<?php

declare(strict_types=1);

return [
    'list' => [
        'label' => 'Lista',
        'description' => 'Visualizzazione a lista tradizionale',
        'tooltip' => 'Mostra elementi in formato lista',
        'helper_text' => 'Layout tradizionale con righe e colonne',
        'color' => 'primary',
        'icon' => 'heroicon-o-list-bullet',
    ],
    'grid' => [
        'label' => 'Griglia',
        'description' => 'Visualizzazione a griglia con card',
        'tooltip' => 'Mostra elementi in formato griglia',
        'helper_text' => 'Layout a griglia con card responsive',
        'color' => 'secondary',
        'icon' => 'heroicon-o-squares-2x2',
    ],
];
```

## Pattern Standard per Enum

### 1. Import TransTrait
```php
use Modules\Xot\Filament\Traits\TransTrait;

enum MyEnum: string implements HasColor, HasIcon, HasLabel
{
    use TransTrait;

    case VALUE1 = 'value1';
    case VALUE2 = 'value2';
}
```

### 2. Metodi Standard
```php
public function getLabel(): string
{
    return $this->transClass(self::class, $this->value . '.label');
}

public function getColor(): string
{
    return $this->transClass(self::class, $this->value . '.color');
}

public function getIcon(): string
{
    return $this->transClass(self::class, $this->value . '.icon');
}

public function getDescription(): string
{
    return $this->transClass(self::class, $this->value . '.description');
}

public function getTooltip(): string
{
    return $this->transClass(self::class, $this->value . '.tooltip');
}

public function getHelperText(): string
{
    return $this->transClass(self::class, $this->value . '.helper_text');
}
```

### 3. Struttura Traduzioni
```php
// File: Modules/ModuleName/lang/it/enum_name.php
return [
    'value1' => [
        'label' => 'Etichetta 1',
        'description' => 'Descrizione 1',
        'tooltip' => 'Tooltip 1',
        'helper_text' => 'Helper text 1',
        'color' => 'primary',
        'icon' => 'heroicon-o-icon1',
    ],
    'value2' => [
        'label' => 'Etichetta 2',
        'description' => 'Descrizione 2',
        'tooltip' => 'Tooltip 2',
        'helper_text' => 'Helper text 2',
        'color' => 'secondary',
        'icon' => 'heroicon-o-icon2',
    ],
];
```

## Checklist Pre-Implementazione

Prima di creare un nuovo Enum:

- [ ] Importare `TransTrait`
- [ ] Implementare tutti i metodi standard con `transClass()`
- [ ] Creare file traduzioni in `lang/it/`, `lang/en/`, `lang/de/`
- [ ] Struttura espansa completa per ogni valore
- [ ] Sincronizzazione IT/EN/DE
- [ ] Testare traduzioni in ambiente di sviluppo

## Esempi di Errori Comuni

### ❌ ERRORE - Match per traduzioni
```php
public function getLabel(): string
{
    return match ($this) {
        self::LIST => __('ui::table-layout.list.label'),
        self::GRID => __('ui::table-layout.grid.label'),
    };
}
```

### ✅ CORRETTO - transClass()
```php
public function getLabel(): string
{
    return $this->transClass(self::class, $this->value . '.label');
}
```

### ❌ ERRORE - Valori hardcoded
```php
public function getColor(): string
{
    return match ($this) {
        self::LIST => 'primary',
        self::GRID => 'secondary',
    };
}
```

### ✅ CORRETTO - transClass()
```php
public function getColor(): string
{
    return $this->transClass(self::class, $this->value . '.color');
}
```

## Verifica Automatica

### PHPStan Rule (Ideale)
```php
// Regola PHPStan per rilevare match() in enum
// Implementare in phpstan.neon
rules:
    - rule: Never use match() for translations in enums
```

### Code Review Checklist
- [ ] TransTrait importato
- [ ] Tutti i metodi usano `transClass()`
- [ ] Nessun `match()` per traduzioni
- [ ] Traduzioni implementate in tutte le lingue
- [ ] Struttura espansa completa

## Penalità per Violazioni

### Livello 1 - Warning
- Commento nel code review
- Richiesta di correzione

### Livello 2 - Blocco
- Blocco del merge
- Correzione obbligatoria

### Livello 3 - Sanzione
- Documentazione della violazione
- Training obbligatorio

## Collegamenti

- [Translation Standards](../../../docs/translation_standards.md)
- [Filament Best Practices](../../../docs/filament_best_practices.md)
- [TransTrait Documentation](../../Xot/docs/trans_trait_usage.md)

## Memoria Permanente

**RICORDA SEMPRE**:
- SEMPRE `TransTrait` negli enum
- SEMPRE `transClass()` per traduzioni
- MAI `match()` per traduzioni
- SEMPRE struttura espansa nelle traduzioni
- SEMPRE sincronizzazione IT/EN/DE

*Ultimo aggiornamento: 2025-01-06*
