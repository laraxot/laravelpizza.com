# Best Practices per Componenti Blade

## Principio Fondamentale: SEMPLICITÀ È ELEGANZA

### Mantra del Componente Blade

> **"Un componente Blade deve fare una cosa sola e farla bene"**

- **Semplicità è eleganza**
- **Consistenza è armonia**
- **Documentazione è compassione**

## Regole Assolute

### 1. KISS (Keep It Simple, Stupid)

I componenti Blade devono essere il più semplici possibile:

```blade
{{-- ✅ CORRETTO: Semplice e diretto --}}
@include($block->view, $block->data)

{{-- ❌ ERRATO: Complesso e ridondante --}}
@if(isset($block->view) && !empty($block->view) && view()->exists($block->view))
    @include($block->view, $block->data ?? [])
@else
    <div class="error">Vista non trovata</div>
@endif
```

### 2. NESSUN DEBUG O LOGGING

Mai aggiungere elementi di debug nei componenti Blade:

```blade
{{-- ❌ ERRATO: Debug nel componente --}}
@include($block->view, $block->data)
@if(config('app.debug'))
    <!-- Debug: Vista {{ $block->view }} renderizzata -->
@endif

{{-- ❌ ERRATO: Logging nel componente --}}
@php
    Log::info('Rendering vista: ' . $block->view);
@endphp
@include($block->view, $block->data)

{{-- ✅ CORRETTO: Solo rendering --}}
@include($block->view, $block->data)
```

### 3. FIDUCIA NELL'ARCHITETTURA

Non duplicare validazioni già effettuate a monte:

```blade
{{-- ✅ CORRETTO: Fiducia in BlockData --}}
@foreach($blocks as $block)
    @include($block->view, $block->data)
@endforeach

{{-- ❌ ERRATO: Duplicazione di controlli --}}
@foreach($blocks as $block)
    @if($block->view && view()->exists($block->view))
        @include($block->view, $block->data)
    @endif
@endforeach
```

### 4. NESSUNA MANIPOLAZIONE DATI

BlockData garantisce già che tutti i dati siano del tipo corretto:

```blade
{{-- ✅ CORRETTO: Usa i dati così come sono --}}
@include($block->view, $block->data)

{{-- ❌ ERRATO: Manipolazione inutile --}}
@php
    $blockData = (array) ($block->data ?? []);
@endphp
@include($block->view, $blockData)

{{-- ❌ ERRATO: Type casting ridondante --}}
@include($block->view, (array) $block->data)

{{-- ❌ ERRATO: Controllo null inutile --}}
@include($block->view, $block->data ?? [])
```

## Esempi Corretti vs Errati

### Componente Page

#### ✅ Implementazione Corretta

```blade
{{-- Page Component --}}
@props([
    'blocks' => [],
    'side' => 'content',
    'slug' => '',
    'page' => null
])

@if(!empty($blocks))
    <div class="page-{{ $side }}-content" data-slug="{{ $slug }}" data-side="{{ $side }}">
        @foreach($blocks as $block)
            @include($block->view, $block->data)
        @endforeach
    </div>
@endif
```

#### ❌ Implementazione Errata

```blade
{{-- ERRATO: Troppo complesso --}}
@props([
    'blocks' => [],
    'side' => 'content',
    'slug' => '',
    'page' => null
])

@if(!empty($blocks))
    <div class="page-{{ $side }}-content" data-slug="{{ $slug }}" data-side="{{ $side }}">
        @foreach($blocks as $block)
            @php
                // ERRATO: Debug nel componente
                Log::info('Rendering block', ['type' => $block->type, 'view' => $block->view]);
                
                // ERRATO: Validazione ridondante
                if(!view()->exists($block->view)) {
                    Log::error('Vista non trovata: ' . $block->view);
                    continue;
                }
                
                // ERRATO: Manipolazione inutile dei dati
                $blockData = (array) ($block->data ?? []);
                $blockData['_debug'] = config('app.debug');
                $blockData['_timestamp'] = now()->toISOString();
            @endphp

            {{-- ERRATO: Controllo ridondante --}}
            @if($block->view && view()->exists($block->view))
                @include($block->view, $blockData)
            @else
                <div class="error">Errore nel caricamento del blocco</div>
            @endif
        @endforeach
    </div>
@else
    {{-- ERRATO: Debug nel componente --}}
    @if(config('app.debug'))
        <div class="debug">Nessun blocco trovato per {{ $slug }}</div>
    @endif
@endif
```

## Garanzie di BlockData

### Cosa BlockData Garantisce SEMPRE

1. **`$block->view`**: Stringa valida di una vista esistente
2. **`$block->data`**: Array valido (mai null, mai undefined)
3. **`$block->type`**: Stringa valida del tipo di blocco

### Controlli Completamente Inutili

```blade
{{-- ❌ TUTTI QUESTI CONTROLLI SONO INUTILI --}}

{{-- BlockData garantisce già che view esista --}}
@if(view()->exists($block->view))
    @include($block->view, $block->data)
@endif

{{-- BlockData garantisce già che data sia array --}}
@include($block->view, $block->data ?? [])

{{-- BlockData garantisce già il tipo corretto --}}
@include($block->view, (array) $block->data)

{{-- BlockData garantisce già che le proprietà esistano --}}
@if(isset($block->view) && isset($block->data))
    @include($block->view, $block->data)
@endif
```

## Separazione delle Responsabilità

### Dove Fare Cosa

#### Nel Controller (✅ Corretto)

```php
class PageController extends Controller
{
    public function show($slug)
    {
        // ✅ Logging appropriato
        Log::info('Caricamento pagina', ['slug' => $slug]);
        
        $pageData = $this->getPageData($slug);
        
        // ✅ Validazione e gestione errori
        if (empty($pageData)) {
            Log::warning('Pagina non trovata', ['slug' => $slug]);
            abort(404);
        }
        
        // ✅ Processamento dati
        $blocks = BlockData::fromArray($pageData['blocks'] ?? []);
        
        // ✅ Debug appropriato
        if (config('app.debug')) {
            Log::debug('Blocchi processati', ['count' => $blocks->count()]);
        }
        
        return view('cms::pages.show', [
            'blocks' => $blocks,
            'slug' => $slug
        ]);
    }
}
```

#### Nel Componente Blade (✅ Corretto)

```blade
{{-- ✅ Solo rendering, nessuna logica complessa --}}
@if(!empty($blocks))
    <div class="page-{{ $side }}-content" data-slug="{{ $slug }}" data-side="{{ $side }}">
        @foreach($blocks as $block)
            @include($block->view, $block->data)
        @endforeach
    </div>
@endif
```

## Gestione degli Errori

### ✅ Approccio Corretto

Gli errori devono essere gestiti **prima** che i dati arrivino al componente:

1. **Nel Controller**: Validazione e logging
2. **In BlockData**: Fallback automatico
3. **Nel Componente**: Solo rendering

### ❌ Approccio Errato

Non gestire errori nel componente Blade:

```blade
{{-- ❌ ERRATO: Gestione errori nel componente --}}
@try
    @include($block->view, $block->data)
@catch(\Exception $e)
    <div class="error">Errore: {{ $e->getMessage() }}</div>
@endtry
```

## Performance e Ottimizzazione

### Principi di Performance

1. **Nessun controllo ridondante**: Se BlockData ha validato, non rivalidare
2. **Rendering diretto**: Meno codice = più veloce
3. **Nessuna manipolazione dati**: I dati devono arrivare già pronti

### Esempio di Ottimizzazione

```blade
{{-- ✅ OTTIMIZZATO: Rendering diretto --}}
@foreach($blocks as $block)
    @include($block->view, $block->data)
@endforeach

{{-- ❌ NON OTTIMIZZATO: Controlli inutili --}}
@foreach($blocks as $block)
    @if(isset($block) && is_object($block) && property_exists($block, 'view'))
        @if(!empty($block->view) && view()->exists($block->view))
            @include($block->view, $block->data ?? [])
        @endif
    @endif
@endforeach
```

## Testing dei Componenti

### Test Appropriati

```php
// ✅ Test del componente
public function test_page_component_renders_blocks()
{
    $blocks = collect([
        new BlockData('hero', ['view' => 'ui::blocks.hero', 'title' => 'Test'])
    ]);
    
    $view = $this->blade('<x-cms::page :blocks="$blocks" side="content" slug="test" />', [
        'blocks' => $blocks
    ]);
    
    $view->assertSee('Test');
    $view->assertSee('page-content-content');
}
```

### ❌ Test Inappropriati

```php
// ❌ Non testare la validazione nel componente
public function test_page_component_handles_invalid_views()
{
    // Questo test non ha senso perché BlockData gestisce già la validazione
}
```

## Documentazione dei Componenti

### Template di Documentazione

```blade
{{-- 
Componente: Nome del Componente
Responsabilità: Descrizione breve della responsabilità
Dipendenze: Cosa si aspetta di ricevere
Output: Cosa produce

Esempio di utilizzo:
<x-modulo::componente :prop="$value" />
--}}
```

### Esempio Completo

```blade
{{-- 
Componente: Page
Responsabilità: Rendering di blocchi validati da BlockData
Dipendenze: Array di oggetti BlockData validati
Output: HTML strutturato con blocchi renderizzati

Esempio di utilizzo:
<x-cms::page :blocks="$blocks" side="content" slug="homepage" />
--}}
@props([
    'blocks' => [],
    'side' => 'content',
    'slug' => '',
    'page' => null
])

@if(!empty($blocks))
    <div class="page-{{ $side }}-content" data-slug="{{ $slug }}" data-side="{{ $side }}">
        @foreach($blocks as $block)
            @include($block->view, $block->data)
        @endforeach
    </div>
@endif
```

## Checklist per Componenti Blade

### Prima di Committare

- [ ] Il componente fa una sola cosa?
- [ ] Non ci sono `dd()`, `dump()`, `Log::` nel componente?
- [ ] Non ci sono controlli `view()->exists()` ridondanti?
- [ ] Non ci sono try-catch nel componente?
- [ ] Non ci sono manipolazioni complesse dei dati?
- [ ] Il codice è leggibile e semplice?
- [ ] La documentazione è presente e chiara?

### Code Review

- [ ] Il componente rispetta il principio KISS?
- [ ] Non duplica validazioni fatte altrove?
- [ ] È testabile facilmente?
- [ ] La responsabilità è chiara e singola?

## Collegamenti correlati

- [Architettura CMS](/laravel/Modules/Cms/docs/architecture.md)
- [BlockData Documentation](/laravel/Modules/Cms/docs/data/blockdata.md)
- [Page Component](/laravel/Modules/Cms/docs/components/page.md)
- [Best Practices Generali](/laravel/Modules/Cms/docs/best-practices/)
- [Blocks Documentation](/laravel/Modules/Cms/docs/blocks.md) 
