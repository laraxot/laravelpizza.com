# Logo Block

Il blocco Logo è utilizzato per gestire il logo del sito, con supporto per il caricamento dell'immagine e la configurazione delle dimensioni.

## Struttura

```php
[
    'type' => 'logo',
    'data' => [
        'src' => 'string',    // Percorso dell'immagine del logo
        'alt' => 'string',    // Testo alternativo per l'accessibilità
        'width' => 'integer', // Larghezza in pixel
        'height' => 'integer', // Altezza del logo in pixel
        'icon' => 'string',   // Nome icona Filament
        'size' => 'string',   // Classi Tailwind per dimensione icona
        'url' => 'string',    // URL di destinazione al click sul logo
        'title' => 'string',  // Titolo opzionale
        'description' => 'string' // Descrizione opzionale
    ]
]
```

## Campi

| Campo | Tipo | Descrizione | Obbligatorio | Default |
|-------|------|-------------|--------------|---------|
| src | string | Percorso dell'immagine del logo | No | - |
| alt | string | Testo alternativo per l'accessibilità | Sì | - |
| width | integer | Larghezza del logo in pixel | No | 150 |
| height | integer | Altezza del logo in pixel | No | 32 |
| icon | string | Nome icona Filament | No | - |
| size | string | Classi Tailwind per dimensione icona | No | - |
| url | string | Link di destinazione al click sul logo | No | "/" |
| title | string | Titolo opzionale | No | - |
| description | string | Descrizione opzionale | No | - |

## Supporto Icone SVG con Filament

Nel JSON del blocco, è possibile specificare i dati come segue:
```json
"data": {
  "src": "/images/logo.svg",
  "alt": "Logo",
  "width": 150,
  "height": 32,
  "icon": "heroicon-o-adjustments",
  "size": "h-8 w-8",
  "url": "/",
  "title": "My Logo",
  "description": "Descrizione opzionale"
}
```
La Blade renderizzerà il logo con un controllo su `icon` o `src`:
```blade
@if(!empty($block->data['icon']))
    <x-filament::icon :name="$block->data['icon']" :class="$block->data['size']" />
@elseif(!empty($block->data['src']))
    <img src="{{ asset($block->data['src']) }}" alt="{{ $block->data['alt'] }}" width="{{ $block->data['width'] }}" height="{{ $block->data['height'] }}" class="{{ $block->data['size'] }}" />
@endif
```

## Esempio di Utilizzo

```php
use Modules\Cms\Filament\Blocks\LogoBlock;

// In un form Filament
Builder::make('content')
    ->blocks([
        LogoBlock::make(),
    ])
```

## Blade Props Mapping

La Blade del blocco riceve direttamente le chiavi presenti in `data` tramite:
```blade
@include($block->view, $block->data)
```
Definisce quindi le props con:
```blade
@props([
  'src',
  'alt',
  'width',
  'height',
  'icon',
  'size',
  'url',
  'title',
  'description',
])
```
Questo evita di dover gestire l'oggetto `$block` e rende la view più semplice e testabile.

## Theme Styling

Le Blade dei blocchi devono includere un wrapper con le classi del tema per sfondo e padding, per evitare elementi trasparenti:
```blade
<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 p-4 flex items-center']) }}>
    {{-- logo, titolo, descrizione --}}
</div>
```

## Best Practices

1. **Immagine**:
   - Utilizzare formati vettoriali (SVG) quando possibile
   - Ottimizzare le immagini per il web
   - Mantenere un rapporto qualità/dimensione ottimale

2. **Accessibilità**:
   - Fornire un testo alternativo descrittivo
   - Assicurarsi che il logo sia visibile su tutti gli sfondi
   - Mantenere dimensioni minime per la leggibilità

3. **Dimensioni**:
   - Rispettare le proporzioni originali
   - Considerare la visualizzazione su dispositivi mobili
   - Utilizzare dimensioni appropriate per il layout

4. **Performance**:
   - Comprimere le immagini senza perdita di qualità
   - Utilizzare il lazy loading quando appropriato
   - Considerare versioni multiple per diversi dispositivi

## Specifiche Tecniche

1. **Formati Supportati**:
   - SVG (consigliato)
   - PNG (con trasparenza)
   - JPG/JPEG
   - WebP

2. **Dimensioni Consigliate**:
   - Desktop: 150x32px (default)
   - Mobile: scalare proporzionalmente
   - Retina: fornire versioni @2x

3. **Ottimizzazione**:
   - Compressione senza perdita
   - Rimozione dei metadati
   - Utilizzo di CDN per la distribuzione

## Collegamenti

- [Documentazione Filament Forms](../filament-forms.md)
- [UI Components](../ui/components.md)
- [Best Practices Immagini](../ui/image-guidelines.md)
- [Accessibilità](../ui/accessibility.md)
- [Filament Icons](https://filamentphp.com/docs/3.x/support/icons)
