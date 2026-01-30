# Prevenzione Errori Critici - Guida Completa

## ⚠️ ERRORI CRITICI DA EVITARE SEMPRE ⚠️

Questa guida documenta gli errori più comuni e come evitarli per mantenere la qualità del codice.

## 1. MAI USARE ->label() NEI COMPONENTI FILAMENT

### ❌ ERRORE CRITICO - MAI FARE QUESTO
```php
TextColumn::make('name')->label('Nome')
Action::make('save')->label('Salva')
Select::make('status')->label('Stato')
TextInput::make('email')->label('Email')
```

### ✅ CORRETTO - SEMPRE FARE QUESTO
```php
TextColumn::make('name')  // Traduzione automatica
Action::make('save')      // Traduzione automatica
Select::make('status')    // Traduzione automatica
TextInput::make('email')  // Traduzione automatica
```

### Motivazione
- Il LangServiceProvider gestisce automaticamente le traduzioni
- Le chiavi vengono generate automaticamente dal nome del campo
- Struttura: `modulo::risorsa.fields.campo.label`
- Permette override delle traduzioni per temi/moduli

## 2. MAI USARE VALORI HARDCODED NEI TEST

### ❌ ERRORE CRITICO - MAI FARE QUESTO
```php
$this->assertEquals('primary', $listColor);
$this->assertEquals('heroicon-o-list-bullet', $listIcon);
$this->assertEquals('Lista', $listLabel);
```

### ✅ CORRETTO - SEMPRE FARE QUESTO
```php
$this->assertIsString($listColor);
$this->assertIsString($listIcon);
$this->assertIsString($listLabel);
$this->assertNotEmpty($listColor);
$this->assertNotEmpty($listIcon);
$this->assertNotEmpty($listLabel);
```

### Motivazione
- I test devono essere resilienti ai cambiamenti
- Testare il comportamento, non i valori specifici
- I valori possono cambiare nelle traduzioni
- Focus su type safety e presenza di valori

## 3. MAI USARE __() O trans() DIRETTAMENTE NEGLI ENUM

### ❌ ERRORE CRITICO - MAI FARE QUESTO
```php
public function getLabel(): string
{
    return __('ui::table-layout.'.$this->value.'.label');
}

public function getColor(): string
{
    return trans('ui::table-layout.'.$this->value.'.color');
}
```

### ✅ CORRETTO - SEMPRE FARE QUESTO
```php
public function getLabel(): string
{
    return $this->transClass(self::class, $this->value.'.label');
}

public function getColor(): string
{
    return $this->transClass(self::class, $this->value.'.color');
}
```

### Motivazione
- `transClass()` è tipizzato e sicuro
- Usa automaticamente il namespace della classe
- Evita errori di digitazione
- Pattern uniforme in tutto il progetto

## 4. SEMPRE STRUTTURA ESPANSA NEI FILE DI TRADUZIONE

### ❌ ERRORE CRITICO - MAI FARE QUESTO
```php
return [
    'list' => 'Lista',
    'grid' => 'Griglia',
    'toggle' => 'Cambia Layout',
];
```

### ✅ CORRETTO - SEMPRE FARE QUESTO
```php
return [
    'list' => [
        'label' => 'Lista',
        'color' => 'primary',
        'icon' => 'heroicon-o-list-bullet',
        'description' => 'Visualizzazione a lista tradizionale',
        'tooltip' => 'Mostra elementi in formato lista',
        'helper_text' => 'Layout tradizionale con righe e colonne',
    ],
    'grid' => [
        'label' => 'Griglia',
        'color' => 'success',
        'icon' => 'heroicon-o-squares-2x2',
        'description' => 'Visualizzazione a griglia con card',
        'tooltip' => 'Mostra elementi in formato griglia',
        'helper_text' => 'Layout a griglia con card responsive',
    ],
    'toggle' => [
        'label' => 'Cambia Layout',
        'tooltip' => 'Alterna tra visualizzazione lista e griglia',
        'helper_text' => 'Cambia il tipo di visualizzazione',
    ],
];
```

### Motivazione
- Struttura coerente in tutto il progetto
- Facile da mantenere e debuggare
- Supporto per tooltip e helper text
- Possibilità di override per temi

## 5. SEMPRE USARE TRANS_TRAIT NEGLI ENUM

### ❌ ERRORE CRITICO - MAI FARE QUESTO
```php
enum MyEnum: string implements HasColor, HasIcon, HasLabel
{
    case VALUE1 = 'value1';
    case VALUE2 = 'value2';
    
    // Manca use TransTrait;
}
```

### ✅ CORRETTO - SEMPRE FARE QUESTO
```php
use Modules\Xot\Filament\Traits\TransTrait;

enum MyEnum: string implements HasColor, HasIcon, HasLabel
{
    use TransTrait;
    
    case VALUE1 = 'value1';
    case VALUE2 = 'value2';
}
```

### Motivazione
- Fornisce il metodo `transClass()`
- Pattern uniforme per tutti gli enum
- Type safety garantita
- Facile da testare

## Checklist Prevenzione Errori

Prima di ogni commit, verificare:

### ✅ Codice Filament
- [ ] Nessun `->label()` nei componenti
- [ ] Nessun `->placeholder()` hardcoded
- [ ] Nessun `->helperText()` hardcoded
- [ ] Solo `->make('campo')` per i componenti

### ✅ Test Unitari
- [ ] Nessun valore hardcoded nei test
- [ ] Usare `assertIsString()` e `assertNotEmpty()`
- [ ] Testare comportamento, non valori specifici
- [ ] Testare type safety, non contenuto

### ✅ Enum
- [ ] `use TransTrait;` presente
- [ ] `transClass()` usato per traduzioni
- [ ] Nessun `__()` o `trans()` diretto
- [ ] `declare(strict_types=1);` presente

### ✅ File di Traduzione
- [ ] Struttura espansa per tutti i valori
- [ ] `label`, `color`, `icon` per ogni valore
- [ ] Chiavi in inglese, valori nella lingua target
- [ ] File posizionato correttamente

### ✅ Documentazione
- [ ] Esempi corretti senza `->label()`
- [ ] Pattern enum translation documentato
- [ ] Collegamenti bidirezionali aggiornati
- [ ] Data ultimo aggiornamento corretta

## Penalità per Violazioni

- ❌ Codice non conforme
- ❌ Difficoltà di manutenzione
- ❌ Inconsistenza nelle traduzioni
- ❌ Impossibilità di override
- ❌ Errori di type safety
- ❌ Test non affidabili

## Esempi di Correzione

### Esempio 1: Componente Filament
```php
// PRIMA (ERRATO)
TextInput::make('email')
    ->label('Indirizzo Email')
    ->placeholder('Inserisci la tua email')
    ->helperText('L\'email verrà utilizzata per le comunicazioni');

// DOPO (CORRETTO)
TextInput::make('email');  // Traduzioni automatiche
```

### Esempio 2: Test Unitario
```php
// PRIMA (ERRATO)
public function test_get_color_returns_primary(): void
{
    $this->assertEquals('primary', TableLayoutEnum::LIST->getColor());
}

// DOPO (CORRETTO)
public function test_get_color_returns_valid_string(): void
{
    $color = TableLayoutEnum::LIST->getColor();
    $this->assertIsString($color);
    $this->assertNotEmpty($color);
}
```

### Esempio 3: Enum
```php
// PRIMA (ERRATO)
public function getLabel(): string
{
    return __('ui::table-layout.'.$this->value.'.label');
}

// DOPO (CORRETTO)
public function getLabel(): string
{
    return $this->transClass(self::class, $this->value.'.label');
}
```

## Collegamenti

- [Enum Translation Pattern](enum-translation-pattern.md)
- [Translation Management](translation-management.md)
- [Filament Best Practices](filament-best-practices.md)
- [Testing Guidelines](testing-guidelines.md)

## Ultimo Aggiornamento
2025-01-27 - Guida completa per prevenzione errori critici 