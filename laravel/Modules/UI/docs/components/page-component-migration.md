# Migrazione Componenti di Pagina - Modulo UI

## Panoramica

Questo documento descrive la migrazione dai metodi legacy del ThemeComposer ai moderni componenti Blade per il rendering delle pagine nel modulo UI.

## Componenti Coinvolti

### 1. Componente `<x-page>`

**Namespace**: `Modules\Cms\View\Components\Page`
**Vista**: `cms::components.page`

Il componente principale per il rendering delle sezioni di pagina.

#### Parametri:

```php
public function __construct(
    string $slug,           // Identificatore univoco della pagina
    string $side = 'content', // Sezione da renderizzare
    bool $lazy = false,     // Caricamento lazy
    bool $debug = false,    // Modalità debug
    bool $cache = true      // Cache abilitata
)
```

#### Utilizzo:

```blade
{{-- Contenuto principale --}}
<x-page side="content" slug="articles" />

{{-- Sidebar --}}
<x-page side="sidebar" slug="articles" />

{{-- Con parametri dinamici --}}
<x-page side="content" :slug="$page->slug" :debug="app()->environment('local')" />
```

### 2. Componente `<x-page-content>`

**Namespace**: `Modules\Cms\View\Components\PageContent`
**Vista**: `cms::components.page-content`

Componente legacy mantenuto per retrocompatibilità.

## Pattern di Migrazione

### Migrazione Base

```blade
{{-- PRIMA --}}
{{ $_theme->showPageContent('articles') }}

{{-- DOPO --}}
<x-page side="content" slug="articles" />
```

### Migrazione Sidebar

```blade
{{-- PRIMA --}}
{{ $_theme->showPageSidebarContent('articles') }}

{{-- DOPO --}}
<x-page side="sidebar" slug="articles" />
```

### Migrazione con Variabili

```blade
{{-- PRIMA --}}
{{ $_theme->showPageContent($page->slug) }}

{{-- DOPO --}}
<x-page side="content" :slug="$page->slug" />
```

## Integrazione con il Sistema di Blocchi

Il componente `<x-page>` utilizza il sistema di blocchi del modulo UI:

1. **Caricamento Blocchi**: I blocchi vengono caricati tramite `BlockData::collect()`
2. **Rendering**: Ogni blocco viene renderizzato tramite `@include($block->view, $block->data)`
3. **Cache**: Il sistema supporta cache per migliorare le performance

## Debug e Sviluppo

### Modalità Debug

```blade
<x-page side="content" slug="articles" :debug="true" />
```

La modalità debug mostra:
- Slug della pagina
- Sezione renderizzata
- Numero di blocchi
- ID della pagina
- Locale corrente

### Caricamento Lazy

```blade
<x-page side="content" slug="articles" lazy />
```

Il caricamento lazy è utile per:
- Contenuti non immediatamente visibili
- Miglioramento delle performance iniziali
- Contenuti condizionali

## Best Practices

### 1. Utilizzo Consistente

Utilizzare sempre il nuovo componente `<x-page>` per nuovi sviluppi:

```blade
{{-- ✅ CORRETTO --}}
<x-page side="content" slug="home" />

{{-- ❌ EVITARE --}}
{{ $_theme->showPageContent('home') }}
```

### 2. Binding Dinamico

Per slug dinamici, utilizzare sempre il binding con `:`:

```blade
{{-- ✅ CORRETTO --}}
<x-page side="content" :slug="$page->slug" />

{{-- ❌ EVITARE --}}
<x-page side="content" slug="{{ $page->slug }}" />
```

### 3. Gestione Errori

Utilizzare la modalità debug in sviluppo:

```blade
<x-page
    side="content"
    :slug="$page->slug"
    :debug="app()->environment('local')"
/>
```

### 4. Performance

Abilitare il caricamento lazy per contenuti non critici:

```blade
<x-page side="sidebar" :slug="$page->slug" lazy />
```

## Compatibilità

### Retrocompatibilità

I metodi legacy continuano a funzionare ma sono deprecati:

- `$_theme->showPageContent()` → `<x-page side="content" />`
- `$_theme->showPageSidebarContent()` → `<x-page side="sidebar" />`

### Versioning

- **v1.x**: Solo metodi ThemeComposer
- **v2.x**: Introduzione componenti Blade (retrocompatibile)
- **v3.x**: Rimozione metodi legacy (pianificata)

## Testing

### Test Unitari

```php
public function test_page_component_renders_content()
{
    $component = new Page('test-page', 'content');
    $view = $component->render();

    $this->assertInstanceOf(View::class, $view);
    $this->assertEquals('cms::components.page', $view->getName());
}
```

### Test di Integrazione

```php
public function test_page_component_in_blade()
{
    $response = $this->get('/test-page');

    $response->assertSee('page-content-content');
    $response->assertSee('data-slug="test-page"');
}
```

## Troubleshooting

### Problemi Comuni

1. **Vista non trovata**: Verificare che il modulo Cms sia registrato
2. **Blocchi vuoti**: Controllare che la pagina abbia contenuti nel database
3. **Errori di binding**: Utilizzare `:slug` per variabili dinamiche

### Log e Debug

Il componente logga automaticamente gli errori:

```php
Log::error('Error loading page content', [
    'slug' => $this->slug,
    'side' => $this->side,
    'error' => $e->getMessage(),
]);
```

## Riferimenti

- [Documentazione Componenti Blade](https://laravel.com/docs/blade#components)
- [Sistema di Blocchi UI](../blocks/blocks-system.md)
- [Migrazione CMS](../../Cms/docs/migrations/02_theme_content_to_page_component.md)
