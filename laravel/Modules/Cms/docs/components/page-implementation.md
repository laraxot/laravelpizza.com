# Implementazione del Componente Page

## Introduzione

Questo documento descrive l'implementazione tecnica del componente `<x-page>`, che è responsabile del rendering dei contenuti delle pagine nel sistema CMS. Il componente è progettato per essere flessibile, modulare e facilmente estensibile.

## Architettura

Il componente `<x-page>` è implementato seguendo il pattern Model-View-Component di Laravel:

1. **Model**: La classe `Page` nel namespace `Modules\Cms\Models` che utilizza `HasTranslations` per il supporto multilingua
2. **View**: Il file Blade `page.blade.php` in `Modules\Cms\resources\views\components`
3. **Component**: La classe `Page` nel namespace `Modules\Cms\View\Components`

## Classe Component

```php
<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Webmozart\Assert\Assert;
use Illuminate\View\Component;
use Modules\Xot\Datas\XotData;
use Modules\Cms\Datas\BlockData;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Blade;
use Modules\Cms\Models\Page as PageModel;
use Illuminate\Contracts\View\View as ViewContract;

/**
 * Page Component.
 *
 * Renders page content sections using the Page model.
 * Replaces the old $_theme->showPageContent() method with a modern Blade component approach.
 */
class Page extends Component
{
    public string $slug;
    public string $side;
    public bool $lazy;
    public bool $debug;
    public bool $cache;
    public array $blocks = [];
    public ?PageModel $page = null;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $slug,
        string $side = 'content',
        bool $lazy = false,
        bool $debug = false,
        bool $cache = true
    ) {
        $this->slug = $slug;
        $this->side = $side;
        $this->lazy = $lazy;
        $this->debug = $debug;
        $this->cache = $cache;

        if (!$this->lazy) {
            $this->loadPageContent();
        }
    }

    /**
     * Load page content based on the specified side.
     */
    protected function loadPageContent(): void
    {
        try {
            // Carica o crea la pagina dal database
            $page = PageModel::firstOrCreate(
                ['slug' => $this->slug],
                ['title' => $this->slug, 'content_blocks' => [], 'sidebar_blocks' => []]
            );

            $this->page = $page;

            // Determina quale campo di blocchi utilizzare in base al lato specificato
            $blocksField = match ($this->side) {
                'content' => 'content_blocks',
                'sidebar' => 'sidebar_blocks',
                'header' => 'header_blocks',
                'footer' => 'footer_blocks',
                default => 'content_blocks',
            };
            
            // Ottieni la lingua corrente
            $currentLocale = app()->getLocale();
            
            // Verifica se il campo è traducibile
            if (in_array($blocksField, $page->translatable)) {
                // Ottieni i blocchi per la lingua corrente
                $blocks = $page->getTranslation($blocksField, $currentLocale);
                
                // Se non ci sono blocchi per la lingua corrente, prova con la lingua primaria
                if (empty($blocks) && $currentLocale !== XotData::make()->primary_lang) {
                    $blocks = $page->getTranslation($blocksField, XotData::make()->primary_lang);
                }
            } else {
                // Se il campo non è traducibile, ottieni direttamente il valore
                $blocks = $page->{$blocksField};
            }
            
            // Assicurati che $blocks sia un array
            if (!is_array($blocks)) {
                $blocks = [];
            }

            // Converti i blocchi in oggetti BlockData
            $this->blocks = BlockData::collect($blocks);

        } catch (\Exception $e) {
            if ($this->debug) {
                throw $e;
            }

            // Log error and set empty blocks
            Log::error('Error loading page content', [
                'slug' => $this->slug,
                'side' => $this->side,
                'error' => $e->getMessage(),
            ]);

            $this->blocks = [];
        }
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): ViewContract
    {
        // If lazy loading is enabled and content hasn't been loaded yet
        if ($this->lazy && empty($this->blocks)) {
            $this->loadPageContent();
        }

        return view('cms::components.page', [
            'slug' => $this->slug,
            'side' => $this->side,
            'blocks' => $this->blocks,
            'page' => $this->page,
            'debug' => $this->debug,
        ]);
    }
}
```

## Vista Blade

Il file `page.blade.php` è responsabile del rendering dei blocchi di contenuto. La sua implementazione è semplice ma potente:

```blade
{{-- Page Component View --}}
@php
    $debug = $debug ?? false;
    $blocks = $blocks ?? [];
    $side = $side ?? 'content';
    $slug = $slug ?? '';
    $page = $page ?? null;
@endphp

@if($debug)
    <div class="page-debug-info" style="background: #f8f9fa; border: 1px solid #dee2e6; padding: 10px; margin: 10px 0; font-size: 12px;">
        <strong>Page Component Debug:</strong>
        <ul style="margin: 5px 0; padding-left: 20px;">
            <li>Slug: {{ $slug }}</li>
            <li>Side: {{ $side }}</li>
            <li>Blocks Count: {{ count($blocks) }}</li>
            <li>Page ID: {{ $page?->id ?? 'N/A' }}</li>
            <li>Locale: {{ app()->getLocale() }}</li>
        </ul>
        @if(!empty($blocks))
            <strong>Blocks:</strong>
            <ul style="margin: 5px 0; padding-left: 20px;">
                @foreach($blocks as $index => $block)
                    <li>{{ $index }}: {{ $block->type ?? 'unknown' }} ({{ $block->data['view'] ?? 'no view' }})</li>
                @endforeach
            </ul>
        @endif
    </div>
@endif

@if(!empty($blocks))
    <div class="page-{{ $side }}-content" data-slug="{{ $slug }}" data-side="{{ $side }}">
        @foreach($blocks as $block)
            @php
                $blockType = $block->type ?? 'unknown';
                $blockData = $block->data ?? [];
                $blockView = $blockData['view'] ?? null;
            @endphp

            @if($debug)
                <div style="background: #e3f2fd; border: 1px solid #2196f3; padding: 5px; margin: 5px 0; font-size: 11px;">
                    <strong>Block:</strong> {{ $blockType }} | <strong>View:</strong> {{ $blockView }}
                </div>
            @endif

            {{-- Render block using the view specified in the block data --}}
            @if($blockView && view()->exists($blockView))
                @include($blockView, $blockData)
            @elseif($debug)
                <div style="background: #ffebee; border: 1px solid #f44336; padding: 10px; margin: 10px 0;">
                    <strong>Error:</strong> View "{{ $blockView }}" not found for block type "{{ $blockType }}".
                </div>
            @endif
        @endforeach
    </div>
@else
    @if($debug)
        <div class="page-empty-content" style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 10px; margin: 10px 0;">
            <strong>No content found for:</strong> {{ $slug }} ({{ $side }})
            <br><strong>Page model:</strong> {{ $page ? 'Found (ID: ' . $page->id . ')' : 'Not found' }}
        </div>
    @else
        {{-- Fallback content for prediction market --}}
        <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-gray-900 sm:text-6xl">
                        Benvenuto nel Mercato delle Previsioni
                    </h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Partecipa ai mercati predittivi basati sul modello LMSR.
                        Acquista e vendi azioni sugli eventi futuri.
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a href="/register" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                            Inizia a Commerciare
                        </a>
                        <a href="/about" class="text-sm font-semibold leading-6 text-gray-900">
                            Scopri di più <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
```

## Sistema di Rendering dei Blocchi

Il componente `<x-page>` utilizza un sistema di rendering dei blocchi basato sulla vista specificata nei dati del blocco. Questo approccio offre massima flessibilità e permette di estendere facilmente il sistema con nuovi tipi di blocchi.

### Processo di Rendering

1. Il componente carica i blocchi dalla pagina
2. Per ogni blocco, estrae il campo `view` dai dati
3. Utilizza la direttiva `@include` per renderizzare la vista specificata, passando i dati del blocco

### Vantaggi di Questo Approccio

1. **Estensibilità**: Nuovi tipi di blocchi possono essere aggiunti senza modificare il componente
2. **Modularità**: Ogni tipo di blocco è implementato in una vista separata
3. **Flessibilità**: Le viste dei blocchi possono essere posizionate in diversi moduli o temi
4. **Manutenibilità**: Le modifiche a un tipo di blocco non influenzano gli altri

## Modello Page

Il modello `Page` è responsabile della memorizzazione dei contenuti delle pagine. Utilizza il trait `HasTranslations` per il supporto multilingua.

```php
<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Modules\Tenant\Models\Traits\SushiToJsons;
use Modules\Xot\Contracts\ProfileContract;
use Spatie\Translatable\HasTranslations;

class Page extends BaseModelLang
{
    use SushiToJsons;

    /** @var array<int, string> */
    public $translatable = [
        'title',
        'content_blocks',
        'sidebar_blocks',
        'footer_blocks',
    ];

    protected $fillable = [
        'content',
        'slug',
        'title',
        'content_blocks',
        'sidebar_blocks',
        'footer_blocks',
    ];

    protected array $schema = [
        'id' => 'integer',
        'title' => 'json',
        'slug' => 'string',
        'content' => 'string',

        'content_blocks' => 'json',
        'sidebar_blocks' => 'json',
        'footer_blocks' => 'json',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'created_by' => 'string',
        'updated_by' => 'string',
    ];
}
```

## Classe BlockData

La classe `BlockData` è responsabile della conversione dei dati dei blocchi in oggetti strutturati.

```php
<?php

declare(strict_types=1);

namespace Modules\Cms\Datas;

use Spatie\LaravelData\Data;
use Illuminate\Support\Collection;

class BlockData extends Data
{
    public function __construct(
        public string $type,
        public array $data = [],
    ) {
    }

    /**
     * Collect blocks from array.
     *
     * @param array $blocks
     * @return array<int, BlockData>
     */
    public static function collect(array $blocks): array
    {
        $result = [];
        foreach ($blocks as $block) {
            $type = $block['type'] ?? 'unknown';
            $data = $block['data'] ?? [];
            $result[] = new self($type, $data);
        }
        return $result;
    }
}
```

## Best Practices

1. **Utilizzo del campo `view`**: Ogni blocco deve specificare una vista nel campo `view` dei suoi dati
2. **Viste modulari**: Creare viste modulari e riutilizzabili per i blocchi
3. **Validazione dei dati**: Validare sempre i dati all'interno delle viste dei blocchi
4. **Valori predefiniti**: Fornire valori predefiniti per i campi opzionali
5. **Documentazione**: Documentare i campi richiesti e opzionali per ciascun tipo di blocco

## Esempi di Implementazione

### Blocco Hero

```json
{
    "type": "hero",
    "data": {
        "view": "ui::components.blocks.hero.simple",
        "title": "Benvenuto nel Mercato delle Previsioni",
        "subtitle": "Partecipa ai mercati predittivi basati sul modello LMSR",
        "image": "/img/hero-bg.jpg",
        "cta_text": "Inizia Ora",
        "cta_link": "/register"
    }
}
```

### Blocco Predict List

```json
{
    "type": "predict_list",
    "data": {
        "view": "predict::components.blocks.predict_list.lmsr",
        "title": "Mercati Attivi",
        "method": "getActivePredictsLmsr"
    }
}
```

## Conclusione

Il componente `<x-page>` rappresenta un'evoluzione significativa rispetto al precedente metodo `$_theme->showPageContent()`. La sua implementazione modulare e flessibile permette di estendere facilmente il sistema con nuovi tipi di blocchi, mantenendo al contempo la semplicità e la manutenibilità del codice.