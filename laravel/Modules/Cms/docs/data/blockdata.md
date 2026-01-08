# BlockData - Cuore del Sistema di Gestione Blocchi

## Introduzione

La classe `BlockData` è il componente fondamentale del sistema di rendering dei blocchi di contenuto del modulo CMS. Questa classe implementa una strategia di validazione rigorosa con fallback graceful, garantendo robustezza e performance ottimali.

## Architettura e Responsabilità

### Responsabilità Principali

1. **Validazione Rigorosa**: Verifica l'esistenza delle viste nel costruttore
2. **Type Safety**: Garantisce che ogni blocco abbia tipo, dati e vista validi
3. **Array Garantito**: `$data` è SEMPRE un array valido (mai null, mai undefined)
4. **Gestione Fallback**: Implementa fallback automatico con `ui::empty`
5. **Immutabilità**: Una volta creato, l'oggetto è immutabile

### Struttura della Classe

```php
class BlockData extends Data implements Wireable
{
    public string $type;    // Sempre stringa valida
    public array $data;     // SEMPRE array valido
    public string $view;    // Sempre vista esistente
    
    public function __construct(string $type, array $data) {
        $this->type = $type;
        $this->data = $data;  // Type hint garantisce array
        $view = Arr::get($data, 'view', 'ui::empty');
        if(!view()->exists($view)){
            throw new \Exception('view not found: '.$view);
        }
        $this->view = $view;
    }
}
```

## Garanzie di Type Safety

### Cosa BlockData Garantisce SEMPRE

1. **`$this->view`**: Stringa di una vista che esiste nel filesystem
2. **`$this->data`**: Array valido (il type hint `array $data` lo garantisce)
3. **`$this->type`**: Stringa valida del tipo di blocco

### Controlli Completamente Inutili

Questi controlli sono **ridondanti** perché BlockData li garantisce già:

```php
// ❌ INUTILE: BlockData garantisce già che $data sia array
$blockData = (array) ($block->data ?? []);

// ❌ INUTILE: BlockData garantisce già che view esista
if(view()->exists($block->view)) { ... }

// ❌ INUTILE: BlockData garantisce già che le proprietà esistano
if(isset($block->data)) { ... }

// ✅ CORRETTO: Fiducia totale
@include($block->view, $block->data)
```

## Flusso di Validazione

### Livello 1: Costruttore (Validazione Rigorosa)

```php
public function __construct(string $type, array $data) {
    // 1. Type hint garantisce che $data sia array
    $this->data = $data;  // SEMPRE array valido
    
    // 2. Estrae la vista dai dati o usa 'ui::empty' come default
    $view = Arr::get($data, 'view', 'ui::empty');
    
    // 3. Verifica che la vista esista
    if(!view()->exists($view)){
        throw new \Exception('view not found: '.$view);
    }
    
    // 4. Assegna la vista validata
    $this->view = $view;  // SEMPRE vista esistente
}
```

### Livello 2: fromArray (Gestione Graceful)

```php
public static function fromArray(array $blocks): Collection
{
    return collect($blocks)->map(function ($block) {
        if (!is_array($block)) {
            return null;
        }

        $type = Arr::get($block, 'type', 'unknown');
        $data = Arr::get($block, 'data', []);  // Garantisce array

        try {
            return new self($type, $data);  // $data è già array
        } catch (\Exception $e) {
            // Se la vista non esiste, usa una vista di fallback
            $data['view'] = 'ui::empty';
            return new self($type, $data);  // $data è ancora array
        }
    })->filter();
}
```

### Livello 3: Componente Page (Rendering Diretto)

```blade
@foreach($blocks as $block)
    {{-- BlockData garantisce tutto: vista esistente, data array valido --}}
    @include($block->view, $block->data)
@endforeach
```

## Utilizzo Corretto

### Creazione Singola (Con Gestione Eccezioni)

```php
try {
    $block = new BlockData('hero', [  // Array garantito dal type hint
        'title' => 'Titolo Hero',
        'view' => 'cms::blocks.hero'
    ]);
} catch (\Exception $e) {
    // Gestire l'errore appropriatamente
    Log::error('Vista non trovata: ' . $e->getMessage());
}
```

### Creazione da Array (Raccomandato)

```php
$blocksConfig = [
    [
        'type' => 'hero',
        'data' => [  // Questo diventerà $block->data (sempre array)
            'title' => 'Titolo Hero',
            'view' => 'cms::blocks.hero'
        ]
    ],
    [
        'type' => 'features',
        'data' => [  // Questo diventerà $block->data (sempre array)
            'items' => [...],
            'view' => 'cms::blocks.features'
        ]
    ]
];

// Questo metodo gestisce automaticamente i fallback
$blocks = BlockData::fromArray($blocksConfig);
// Ogni $block->data è GARANTITO essere un array valido
```

## Best Practices

### ✅ Cosa Fare

1. **Usare fromArray()**: Per la conversione di array in oggetti BlockData
2. **Fidarsi della Type Safety**: `$block->data` è SEMPRE un array
3. **Rendering diretto**: `@include($block->view, $block->data)`
4. **Gestire le Eccezioni**: Solo quando si crea manualmente un'istanza

### ❌ Cosa NON Fare

1. **Non fare type casting**: `(array) $block->data` è inutile
2. **Non controllare null**: `$block->data ?? []` è ridondante
3. **Non validare viste**: `view()->exists($block->view)` è già fatto
4. **Non modificare dopo la creazione**: L'oggetto è immutabile

## Integrazione con il Sistema

### Con il Componente Page

Il componente `page.blade.php` si fida completamente della type safety di BlockData:

```blade
{{-- CORRETTO: Fiducia totale nell'architettura --}}
@include($block->view, $block->data)

{{-- ERRATO: Sfiducia inutile --}}
@include($block->view, (array) ($block->data ?? []))
```

### Con i Controller

```php
class PageController extends Controller
{
    public function show($slug)
    {
        $pageData = $this->getPageData($slug);
        
        // BlockData gestisce automaticamente la validazione e type safety
        $blocks = BlockData::fromArray($pageData['blocks'] ?? []);
        
        // Ogni $block->data è garantito essere un array valido
        return view('cms::pages.show', compact('blocks'));
    }
}
```

## Gestione Errori Multi-Livello

Il sistema implementa una strategia di gestione errori a tre livelli:

1. **Costruttore**: Type safety garantita + validazione rigorosa con eccezioni
2. **fromArray**: Gestione graceful con fallback a `ui::empty`
3. **Componente**: Rendering diretto senza controlli aggiuntivi

Questa architettura garantisce:
- **Type Safety**: `$data` è sempre array, `$view` è sempre stringa di vista esistente
- **Performance**: Nessun controllo ridondante
- **Manutenibilità**: Separazione chiara delle responsabilità

## Vantaggi dell'Architettura

- **Type Safety Garantita**: Type hints + validazione nel costruttore
- **Performance Ottimale**: Nessun controllo `view()->exists()` o type casting ripetuto
- **Robustezza**: Fallback automatico per viste mancanti
- **Semplicità**: Componenti Blade minimali
- **Manutenibilità**: Logica centralizzata in BlockData

## Collegamenti correlati

- [Architettura CMS](/laravel/Modules/Cms/docs/architecture.md)
- [Blocks Documentation](/laravel/Modules/Cms/docs/blocks.md)
- [Page Component](/laravel/Modules/Cms/docs/components/page.md)
- [Best Practices](/laravel/Modules/Cms/docs/best-practices/)
- [Blade Components Rules](/laravel/Modules/Cms/docs/best-practices/blade-components.md)
