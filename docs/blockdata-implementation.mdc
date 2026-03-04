# Implementazione BlockData

## Panoramica

`BlockData` è una classe fondamentale del sistema di gestione dei blocchi di contenuto. Fornisce type safety e gestione automatica delle viste per i blocchi di contenuto.

## Garanzie Principali

1. **Type Safety**
   - `$block->data` è SEMPRE un array valido
   - `$block->view` è SEMPRE una vista esistente
   - `$block->type` è SEMPRE una stringa valida

2. **Validazione Automatica**
   - Verifica l'esistenza delle viste
   - Fornisce fallback automatico a `ui::empty`
   - Gestisce gli errori in modo elegante

## Best Practices

### ✅ Cosa Fare

```php
// Creazione di un singolo blocco
try {
    $block = new BlockData('hero', [
        'title' => 'Titolo',
        'view' => 'cms::blocks.hero'
    ]);
} catch (\Exception $e) {
    Log::error($e->getMessage());
}

// Creazione multipla da array
$blocks = BlockData::fromArray([
    [
        'type' => 'hero',
        'data' => [
            'title' => 'Titolo',
            'view' => 'cms::blocks.hero'
        ]
    ]
]);

// In Blade
@foreach($blocks as $block)
    @include($block->view, $block->data)
@endforeach
```

### ❌ Cosa NON Fare

```php
// ❌ Controlli ridondanti
if(isset($block->data) && is_array($block->data)) { ... }

// ❵ Type casting inutile
$data = (array) $block->data;

// ❵ Validazione ridondante
if(view()->exists($block->view)) { ... }

// ❵ Controllo null non necessario
$data = $block->data ?? [];
```

## Integrazione con i Componenti

### Page Component

```blade
{{-- CORRETTO: Fiducia totale --}}
@include($block->view, $block->data)

{{-- ERRATO: Controlli ridondanti --}}
@if($block->view && view()->exists($block->view))
    @include($block->view, (array)($block->data ?? []))
@endif
```

### Nei Controller

```php
public function show($slug)
{
    $pageData = $this->getPageData($slug);
    $blocks = BlockData::fromArray($pageData['blocks'] ?? []);
    return view('page.show', compact('blocks'));
}
```

## Gestione Errori

1. **Livello Costruttore**
   - Type hints PHP per `array $data`
   - Validazione vista con eccezione

2. **Livello fromArray**
   - Gestione graceful degli errori
   - Fallback a `ui::empty`
   - Filtraggio automatico di blocchi non validi

3. **Livello Rendering**
   - Nessun controllo aggiuntivo necessario
   - Codice Blade pulito e leggibile

## Vantaggi

- **Performance**: Nessun controllo ridondante
- **Manutenibilità**: Logica centralizzata
- **Affidabilità**: Type safety garantita
- **Flessibilità**: Facile da estendere

## Collegamenti Correlati

- [Documentazione BlockData](../data/blockdata.md)
- [Guida ai Componenti](../components_guidelines.md)
- [Best Practice Frontend](../frontend-best-practices.md)
