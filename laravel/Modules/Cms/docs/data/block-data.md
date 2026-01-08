# Sistema BlockData

## Introduzione

La classe `Modules\Cms\Datas\BlockData` è il cuore del sistema di rendering agnostico del modulo CMS. Si occupa di gestire automaticamente la validazione delle viste, i fallback e la conversione dei dati JSON in oggetti tipizzati.

## Caratteristiche Principali

- **Validazione Automatica**: Controlla se `view()->exists($view)` durante la costruzione
- **Fallback Sicuro**: Se la vista non esiste, usa automaticamente `ui::empty`
- **Gestione Eccezioni**: Cattura le eccezioni e fornisce fallback sicuri
- **Tipizzazione**: Utilizza Spatie Laravel Data per la tipizzazione completa
- **Wireable**: Supporta Livewire per componenti reattivi

## Struttura della Classe

```php
<?php

namespace Modules\Cms\Datas;

use Spatie\LaravelData\Data;
use Livewire\Wireable;

class BlockData extends Data implements Wireable
{
    public string $type;
    public array $data;
    public string $view;

    public function __construct(string $type, array $data)
    {
        $this->type = $type;
        $this->data = $data;
        
        // Estrae la vista dai dati o usa fallback
        $view = Arr::get($data, 'view', 'ui::empty');
        
        // Valida che la vista esista
        if(!view()->exists($view)){
            throw new \Exception('view not found: '.$view);
        }
        
        $this->view = $view;
    }
}
```

## Metodo fromArray()

Il metodo statico `fromArray()` gestisce la conversione di array di blocchi in collezioni di `BlockData`:

```php
public static function fromArray(array $blocks): Collection
{
    return collect($blocks)->map(function ($block) {
        if (!is_array($block)) {
            return null;
        }

        $type = Arr::get($block, 'type', 'unknown');
        $data = Arr::get($block, 'data', []);

        try {
            return new self($type, $data);
        } catch (\Exception $e) {
            // Se la vista non esiste, usa una vista di fallback
            $data['view'] = 'ui::empty';
            return new self($type, $data);
        }
    })->filter();
}
```

## Gestione dei Fallback

### Fallback Automatico

Quando una vista non viene trovata, `BlockData` automaticamente:

1. **Cattura l'eccezione** nel metodo `fromArray()`
2. **Imposta il fallback** `$data['view'] = 'ui::empty'`
3. **Crea un nuovo oggetto** `BlockData` con la vista di fallback
4. **Continua il rendering** senza interrompere l'applicazione

### Vista di Fallback

La vista di fallback `ui::empty` deve esistere in:
```
laravel/Modules/UI/resources/views/empty.blade.php
```

Esempio di contenuto:
```blade
{{-- Vista di fallback per blocchi con viste non trovate --}}
<div class="block-fallback" style="display: none;">
    {{-- Contenuto vuoto per fallback silenzioso --}}
</div>
```

## Esempi di Utilizzo

### Struttura JSON Tipica

```json
{
  "type": "predict_list",
  "data": {
    "view": "predict::components.blocks.predict_list.lmsr",
    "method": "getActivePredictsLmsr",
    "title": "Mercati Attivi",
    "limit": 10
  }
}
```

### Conversione in BlockData

```php
$jsonBlocks = [
    [
        'type' => 'predict_list',
        'data' => [
            'view' => 'predict::components.blocks.predict_list.lmsr',
            'method' => 'getActivePredictsLmsr',
            'title' => 'Mercati Attivi'
        ]
    ],
    [
        'type' => 'hero',
        'data' => [
            'view' => 'ui::blocks.hero.simple',
            'title' => 'Benvenuto',
            'subtitle' => 'Nel nostro sito'
        ]
    ]
];

$blockDataCollection = BlockData::fromArray($jsonBlocks);
```

### Utilizzo nel Componente Page

```blade
@foreach($blocks as $block)
    @php
        $blockData = (array) ($block->data ?? []);
    @endphp

    {{-- Include la vista specificata nel blocco --}}
    @include($block->view, $blockData)
@endforeach
```

## View Resolution

### Esempi di Risoluzione

| Vista Specificata | Percorso Risolto |
|------------------|------------------|
| `predict::components.blocks.predict_list.lmsr` | `laravel/Modules/Predict/resources/views/components/blocks/predict_list/lmsr.blade.php` |
| `ui::blocks.hero.simple` | `laravel/Modules/UI/resources/views/blocks/hero/simple.blade.php` |
| `cms::blocks.content.text` | `laravel/Modules/Cms/resources/views/blocks/content/text.blade.php` |
| `ui::empty` (fallback) | `laravel/Modules/UI/resources/views/empty.blade.php` |

### Sintassi View Resolution

Laravel utilizza la sintassi `modulo::percorso.vista` dove:
- `modulo`: Nome del modulo (predict, ui, cms, etc.)
- `percorso.vista`: Percorso relativo nella cartella `resources/views/` del modulo

## Best Practices

### 1. Specificare Sempre la Vista

```json
{
  "type": "hero",
  "data": {
    "view": "ui::blocks.hero.simple",
    "title": "Titolo"
  }
}
```

### 2. Creare Viste di Fallback

Assicurarsi che esista sempre `ui::empty` per i fallback automatici.

### 3. Gestire Errori Gracefully

Non fare affidamento su viste che potrebbero non esistere. `BlockData` gestisce automaticamente i fallback.

### 4. Mantenere Coerenza nei Nomi

Utilizzare convenzioni coerenti per i nomi delle viste:
- `modulo::components.blocks.tipo.variante`
- `modulo::blocks.categoria.nome`

## Anti-Pattern da Evitare

### ❌ Controlli Ridondanti

```blade
{{-- ERRATO: BlockData ha già validato la vista --}}
@if($blockView && view()->exists($blockView))
    @include($blockView, $blockData)
@endif
```

### ❌ Hardcoding delle Viste

```php
// ERRATO: Hardcoding nel CMS
if ($type === 'predict_list') {
    $view = 'predict::components.blocks.predict_list.lmsr';
}
```

### ✅ Approccio Corretto

```blade
{{-- CORRETTO: Fiducia in BlockData --}}
@include($block->view, $blockData)
```

## Risoluzione dei Problemi

### Vista Non Trovata

Se una vista non viene trovata:
1. `BlockData` cattura automaticamente l'eccezione
2. Imposta `ui::empty` come fallback
3. Il rendering continua senza errori

### Dati Mancanti

Se i dati del blocco sono incompleti:
1. `BlockData` usa valori di default
2. La vista riceve un array vuoto se necessario
3. Le viste devono gestire dati mancanti gracefully

### Debug

Per debuggare problemi con `BlockData`:
1. Verificare che la vista specificata esista
2. Controllare che `ui::empty` esista per i fallback
3. Verificare la struttura JSON dei blocchi

## Collegamenti Correlati

- [Componente Page](../components/page.md)
- [Architettura CMS Agnostica](../components.md)
- [Best Practices per il Rendering](../best-practices/page-rendering.md)
- [View Resolution Laravel](https://laravel.com/docs/views) 
