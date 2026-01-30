# REGOLA CRITICA: Utilizzare transClass() negli Enum per Traduzioni

## Principio Fondamentale
**Negli enum, utilizzare SEMPRE il metodo `transClass()` per gestire le traduzioni invece di chiamate dirette a `__()` o `trans()`.**

## Pattern CORRETTO per Enum

```php
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
```

## Anti-Pattern VIETATI

```php
// ❌ ERRORE: Chiamate dirette a __() o trans()
public function getLabel(): string
{
    return match ($this) {
        self::LIST => __('ui::table-layout.list.label'),
        self::GRID => __('ui::table-layout.grid.label'),
    };
}

// ❌ ERRORE: Hardcoded strings
public function getLabel(): string
{
    return match ($this) {
        self::LIST => 'Lista',
        self::GRID => 'Griglia',
    };
}
```

## Vantaggi di transClass()

1. **Centralizzazione**: Gestione automatica delle traduzioni
2. **Consistenza**: Pattern uniforme per tutti gli enum
3. **Manutenibilità**: Facile aggiunta di nuove proprietà
4. **Scalabilità**: Supporto automatico per nuove lingue
5. **DRY**: Nessuna duplicazione di logica di traduzione
6. **Type Safety**: Controllo automatico delle chiavi di traduzione

## Struttura File di Traduzione per Enum

```php
// Modules/UI/lang/it/table-layout-enum.php
return [
    'list' => [
        'label' => 'Lista',
        'color' => 'primary',
        'icon' => 'heroicon-o-list-bullet',
        'description' => 'Layout a lista tradizionale con righe di tabella',
        'tooltip' => 'Visualizza i dati in formato tabella strutturata',
        'helper_text' => 'Ideale per visualizzare molti dati in modo organizzato',
    ],
    'grid' => [
        'label' => 'Griglia',
        'color' => 'secondary', 
        'icon' => 'heroicon-o-squares-2x2',
        'description' => 'Layout a griglia responsive con card',
        'tooltip' => 'Visualizza i dati in formato card responsive',
        'helper_text' => 'Ideale per visualizzare pochi dati con focus visivo',
    ],
];
```

## Implementazione Corretta

### 1. Metodi Standard negli Enum
Ogni enum DEVE implementare questi metodi utilizzando `transClass()`:
- `getLabel()` - Etichetta principale
- `getColor()` - Colore per UI
- `getIcon()` - Icona per UI
- `getDescription()` - Descrizione dettagliata
- `getTooltip()` - Testo per tooltip
- `getHelperText()` - Testo di aiuto

### 2. Pattern Uniforme
```php
public function getProprietà(): string
{
    return $this->transClass(self::class, $this->value.'.proprietà');
}
```

### 3. File di Traduzione Completi
Ogni enum deve avere traduzioni complete per tutte le proprietà in tutte le lingue supportate.

## Filosofia e Principi

### Filosofia
**"Gli enum sono entità intelligenti che si traducono da soli"**

### Politica
**"Non avrai traduzioni hardcoded negli enum"**

### Religione
**"transClass() è la via della salvezza"**

### Zen
**"Un enum che si traduce è un enum in pace"**

## Regola d'Oro
**"Ogni metodo di traduzione negli enum DEVE utilizzare transClass() con il pattern self::class, \$this->value.'.proprietà'"**

## Applicazione Immediata
1. **Audit** di tutti gli enum nel progetto
2. **Conversione** di tutti i metodi di traduzione a `transClass()`
3. **Creazione** dei file di traduzione appropriati
4. **Test** che le traduzioni funzionino correttamente

## Esempi di Conversione

### Prima (ERRATO)
```php
public function getLabel(): string
{
    return match ($this) {
        self::ACTIVE => 'Attivo',
        self::INACTIVE => 'Inattivo',
    };
}
```

### Dopo (CORRETTO)
```php
public function getLabel(): string
{
    return $this->transClass(self::class, $this->value.'.label');
}
```

## Collegamenti
- [Modules/UI/docs/enum-transclass-implementation.md](../laravel/Modules/UI/docs/enum-transclass-implementation.md)
- [docs/translation-expanded-rules.md](translation-expanded-rules.md)

*Ultimo aggiornamento: 2025-08-04*
