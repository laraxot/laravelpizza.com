# Rendering dei Blocchi di Contenuto

## Introduzione

Questo documento descrive il sistema di rendering dei blocchi di contenuto utilizzato nel componente `<x-page>`. I blocchi di contenuto sono elementi modulari che compongono le diverse sezioni di una pagina.

## Struttura dei Blocchi

Ogni blocco di contenuto ha la seguente struttura:

```json
{
    "type": "hero",
    "data": {
        "view": "ui::blocks.hero.simple",
        "title": "Titolo del Blocco",
        "subtitle": "Sottotitolo del blocco",
        "image": "/path/to/image.jpg",
        "cta_text": "Testo CTA",
        "cta_link": "/link"
    }
}
```

### Campi Principali

- **type**: Tipo di blocco (es. "hero", "text", "features", "predict_list")
- **data**: Dati specifici del blocco
  - **view**: Vista Blade da utilizzare per renderizzare il blocco
  - Altri campi specifici del tipo di blocco

## Sistema di Rendering

Il sistema di rendering dei blocchi utilizza la classe `BlockData` per gestire i blocchi di contenuto e le loro viste. Questo approccio offre massima flessibilità e permette di estendere facilmente il sistema con nuovi tipi di blocchi.

### Classe BlockData

La classe `BlockData` (in `Modules\Cms\Datas\BlockData.php`) è responsabile di:

1. Validare l'esistenza della vista specificata nel blocco
2. Fornire un fallback alla vista `ui::empty` se la vista specificata non esiste
3. Convertire gli array di blocchi in una collezione di oggetti `BlockData`

```php
// Modules\Cms\Datas\BlockData.php
public function __construct(string $type, array $data){
    $this->type = $type;
    $this->data = $data;
    $view = Arr::get($data, 'view', 'ui::empty');
    if(!view()->exists($view)){
        throw new \Exception('view not found: '.$view);
    }
    $this->view = $view;
}

public static function fromArray(array $blocks): Collection
{
    return collect($blocks)->map(function ($block) {
        // ...
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

### Processo di Rendering

1. Il componente `<x-page>` carica i blocchi dalla pagina, già convertiti in oggetti `BlockData`
2. Per ogni blocco, utilizza direttamente la proprietà `view` già validata da `BlockData`
3. Utilizza la direttiva `@include` per renderizzare la vista, passando i dati del blocco

```blade
@foreach($blocks as $block)
    {{-- Render block using the view specified in BlockData --}}
    @include($block->view, (array)$block->data)
@endforeach
```

## Viste dei Blocchi

Le viste dei blocchi sono file Blade che definiscono la struttura HTML e la presentazione di ciascun tipo di blocco. Queste viste possono essere posizionate in diversi moduli o temi, a seconda delle esigenze.

### Convenzioni di Denominazione

Le viste dei blocchi seguono una convenzione di denominazione basata sul namespace del modulo e sul percorso relativo alla vista:

- `ui::blocks.hero.simple` - Un blocco hero semplice nel modulo UI
- `predict::blocks.predict_list.lmsr` - Un blocco di lista di mercati predittivi LMSR nel modulo Predict
- `cms::blocks.features` - Un blocco di funzionalità nel modulo CMS

**IMPORTANTE**: Non includere mai il prefisso `components` nel namespace Blade. Il namespace corretto è:

```blade
<x-predict::blocks.article_list.play_money_markets._components.list_of_markets ... />
```

E NON:

```blade
<x-predict::components.blocks.article_list.play_money_markets._components.list_of_markets ... />
```

### Struttura delle Viste

Le viste dei blocchi ricevono tutti i dati specificati nel campo `data` del blocco. È responsabilità della vista utilizzare questi dati in modo appropriato.

```blade
{{-- ui::blocks.hero.simple --}}
<section class="hero-section bg-gradient-to-r from-indigo-500 to-purple-600 py-20">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-white mb-4">{{ $title }}</h1>
            <p class="text-xl text-white opacity-80 mb-8">{{ $subtitle }}</p>
            
            @if(isset($cta_text) && isset($cta_link))
                <a href="{{ $cta_link }}" class="btn btn-white">{{ $cta_text }}</a>
            @endif
        </div>
    </div>
</section>
```

## Estensibilità

Il sistema di rendering dei blocchi è progettato per essere facilmente estensibile. Per aggiungere un nuovo tipo di blocco:

1. Creare una nuova vista Blade per il blocco
2. Aggiungere il blocco ai dati della pagina, specificando il tipo e la vista
3. Il sistema di rendering utilizzerà automaticamente la vista specificata

Non è necessario modificare il componente `<x-page>` per aggiungere nuovi tipi di blocchi, rendendo il sistema altamente modulare e flessibile.

## Best Practices

1. **Separazione delle Responsabilità**: Ogni vista di blocco dovrebbe essere responsabile solo della presentazione del proprio tipo di blocco.

2. **Riutilizzo dei Componenti**: Utilizzare componenti Blade per elementi comuni tra diversi tipi di blocchi.

3. **Validazione dei Dati**: Validare i dati del blocco all'interno della vista, utilizzando operatori di null coalescing o direttive `@if`.

4. **Documentazione**: Documentare la struttura dei dati richiesti per ciascun tipo di blocco.

5. **Test**: Testare le viste dei blocchi con diversi set di dati per garantire la robustezza.

## Tipi di Blocchi Comuni

Il sistema include diversi tipi di blocchi predefiniti:

- **hero**: Sezione hero con titolo, sottotitolo e CTA
- **features**: Griglia di funzionalità con icone e descrizioni
- **stats**: Statistiche con numeri e etichette
- **cta**: Call to action con titolo, sottotitolo e pulsante
- **predict_list**: Lista di mercati predittivi (specifico per il modulo Predict)

## Riferimenti

- [Documentazione BlockData](/var/www/html/_bases/base_predict_fila3_mono/laravel/Modules/Cms/docs/data/blockdata.md)
- [Documentazione Page Component](/var/www/html/_bases/base_predict_fila3_mono/laravel/Modules/Cms/docs/components/page.md)
- [Regole del Sistema di Rendering](/var/www/html/_bases/base_predict_fila3_mono/laravel/.windsurf/rules/block-rendering-system.mdc)
