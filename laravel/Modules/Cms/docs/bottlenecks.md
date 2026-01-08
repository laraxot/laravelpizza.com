# Colli di Bottiglia e Soluzioni - Modulo Cms

## Panoramica
Questo documento identifica i principali colli di bottiglia nel modulo Cms e fornisce soluzioni dettagliate passo per passo per risolverli.

## 1. Rendering Inefficiente dei Template

### Problema
Il modulo Cms esegue il rendering completo dei template per ogni richiesta, inclusi componenti e sezioni che potrebbero essere cachati.

### Impatto
- Tempi di risposta elevati per pagine complesse
- Utilizzo eccessivo di CPU per il rendering
- Esperienze utente inconsistenti con tempi di caricamento variabili

### Soluzione Passo-Passo

1. **Implementare Fragment Caching**

```php
// Crea un nuovo helper per il caching dei frammenti
namespace Modules\Cms\Helpers;

use Illuminate\Support\Facades\Cache;

class FragmentCache
{
    public static function remember(string $key, int $ttl, callable $callback)
    {
        if (config('app.debug') && request()->has('no-cache')) {
            return $callback();
        }
        
        return Cache::remember("fragment_{$key}", $ttl, $callback);
    }
}
```

2. **Creare una Blade Directive per il Fragment Caching**

```php
// In CmsServiceProvider.php
use Illuminate\Support\Facades\Blade;
use Modules\Cms\Helpers\FragmentCache;

public function boot()
{
    // ...
    Blade::directive('cache', function ($expression) {
        return "<?php if (! function_exists('cacheFragmentStart')) { function cacheFragmentStart(\$key, \$ttl) { \$__cache_key = \$key; \$__cache_ttl = \$ttl; ob_start(); } } ?>";
    });
    
    Blade::directive('endcache', function () {
        return "<?php if (! function_exists('cacheFragmentEnd')) { function cacheFragmentEnd() { \$content = ob_get_clean(); echo FragmentCache::remember(\$__cache_key, \$__cache_ttl, function() use (\$content) { return \$content; }); } } cacheFragmentEnd(); ?>";
    });
}
```

3. **Utilizzare il Fragment Caching nei Template**

```blade
{{-- In resources/views/components/navigation.blade.php --}}
@cache('navigation_'.app()->getLocale(), 3600)
    <nav>
        {{-- Contenuto complesso della navigazione --}}
        @foreach($menuItems as $item)
            <a href="{{ $item->url }}">{{ $item->title }}</a>
        @endforeach
    </nav>
@endcache

{{-- In resources/views/components/footer.blade.php --}}
@cache('footer_'.app()->getLocale(), 3600)
    <footer>
        {{-- Contenuto complesso del footer --}}
    </footer>
@endcache
```

4. **Implementare Invalidazione Selettiva della Cache**

```php
// In Modules\Cms\Models\MenuItem.php
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected static function boot()
    {
        parent::boot();
        
        static::saved(function () {
            // Invalida solo la cache della navigazione quando un elemento del menu cambia
            Cache::forget('fragment_navigation_'.app()->getLocale());
        });
        
        static::deleted(function () {
            Cache::forget('fragment_navigation_'.app()->getLocale());
        });
    }
}
```

5. **Aggiungere Supporto per Versioning della Cache**

```php
// Modifica FragmentCache.php
public static function remember(string $key, int $ttl, callable $callback)
{
    $versionKey = "version_{$key}";
    $version = Cache::get($versionKey, 1);
    
    $cacheKey = "fragment_{$key}_v{$version}";
    
    if (config('app.debug') && request()->has('no-cache')) {
        return $callback();
    }
    
    return Cache::remember($cacheKey, $ttl, $callback);
}

public static function invalidate(string $key)
{
    $versionKey = "version_{$key}";
    $version = Cache::get($versionKey, 1);
    
    // Incrementa la versione invece di eliminare la cache
    Cache::forever($versionKey, $version + 1);
}
```

6. **Misurare i Miglioramenti**

```php
// Crea un middleware per misurare il tempo di rendering
namespace Modules\Cms\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class MeasureRenderTime
{
    public function handle($request, Closure $next)
    {
        $start = microtime(true);
        
        $response = $next($request);
        
        $time = microtime(true) - $start;
        
        if ($request->has('debug-time')) {
            $response->setContent($response->getContent() . "<!-- Render time: {$time}s -->");
        }
        
        Log::info("Render time for {$request->path()}: {$time}s");
        
        return $response;
    }
}
```

## 2. Query Inefficienti per Contenuti Multilingua

### Problema
Il modulo Cms esegue query inefficienti per recuperare contenuti multilingua, spesso con join multipli o query separate per ogni lingua.

### Impatto
- Performance degradate per siti multilingua
- Carico eccessivo sul database
- Scalabilità limitata con l'aumento dei contenuti

### Soluzione Passo-Passo

1. **Implementare JSON Columns per Traduzioni**

```php
// Modifica della migrazione
Schema::create('contents', function (Blueprint $table) {
    $table->id();
    $table->string('type');
    $table->json('title');
    $table->json('slug');
    $table->json('content');
    $table->boolean('published')->default(false);
    $table->timestamps();
    
    // Indice per ricerche efficienti
    $table->index('type');
    $table->index('published');
});
```

2. **Creare un Trait per Gestire le Traduzioni**

```php
// In Modules\Cms\Traits\HasTranslations.php
namespace Modules\Cms\Traits;

trait HasTranslations
{
    public function getTranslation($key, $locale = null, $fallback = true)
    {
        $locale = $locale ?: app()->getLocale();
        
        $value = $this->getAttributeValue($key);
        
        if (!is_array($value) && !is_object($value)) {
            return $value;
        }
        
        $value = (array) $value;
        
        if (isset($value[$locale])) {
            return $value[$locale];
        }
        
        if ($fallback && config('app.fallback_locale')) {
            return $value[config('app.fallback_locale')] ?? null;
        }
        
        return null;
    }
    
    public function setTranslation($key, $locale, $value)
    {
        $translations = $this->getAttributeValue($key) ?: [];
        
        if (!is_array($translations) && !is_object($translations)) {
            $translations = [];
        }
        
        $translations = (array) $translations;
        $translations[$locale] = $value;
        
        $this->attributes[$key] = json_encode($translations);
        
        return $this;
    }
}
```

3. **Implementare il Trait nei Modelli**

```php
// In Modules\Cms\Models\Content.php
namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Cms\Traits\HasTranslations;

class Content extends Model
{
    use HasTranslations;
    
    protected $casts = [
        'title' => 'array',
        'slug' => 'array',
        'content' => 'array',
    ];
    
    protected $fillable = [
        'type', 'title', 'slug', 'content', 'published'
    ];
    
    public function getTitleAttribute($value)
    {
        return json_decode($value, true);
    }
    
    public function getSlugAttribute($value)
    {
        return json_decode($value, true);
    }
    
    public function getContentAttribute($value)
    {
        return json_decode($value, true);
    }
}
```

4. **Ottimizzare le Query per Ricerche Multilingua**

```php
// Crea un nuovo scope per ricerche efficienti
// In Modules\Cms\Models\Content.php

public function scopeWhereTranslationLike($query, $key, $value, $locale = null)
{
    $locale = $locale ?: app()->getLocale();
    
    return $query->where(function ($q) use ($key, $value, $locale) {
        // Cerca nella lingua corrente
        $q->whereRaw("JSON_EXTRACT({$key}, '$.{$locale}') LIKE ?", ["%{$value}%"]);
        
        // Se non trova nella lingua corrente, cerca nella lingua di fallback
        if ($locale !== config('app.fallback_locale')) {
            $q->orWhereRaw("JSON_EXTRACT({$key}, '$.".config('app.fallback_locale')."') LIKE ?", ["%{$value}%"]);
        }
    });
}
```

5. **Creare Indici per JSON Columns**

```php
// Aggiungi alla migrazione
$table->rawIndex("(json_extract(title, '$.it'))", 'contents_title_it_index');
$table->rawIndex("(json_extract(title, '$.en'))", 'contents_title_en_index');
$table->rawIndex("(json_extract(slug, '$.it'))", 'contents_slug_it_index');
$table->rawIndex("(json_extract(slug, '$.en'))", 'contents_slug_en_index');
```

6. **Implementare un Repository Ottimizzato**

```php
// In Modules\Cms\Repositories\ContentRepository.php
namespace Modules\Cms\Repositories;

use Modules\Cms\Models\Content;

class ContentRepository
{
    public function findBySlug($slug, $type = null, $locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        
        $query = Content::where('published', true);
        
        if ($type) {
            $query->where('type', $type);
        }
        
        // Utilizza JSON_EXTRACT per query efficiente
        return $query->whereRaw("JSON_EXTRACT(slug, '$.{$locale}') = ?", [$slug])
            ->orWhereRaw("JSON_EXTRACT(slug, '$.".config('app.fallback_locale')."') = ?", [$slug])
            ->first();
    }
    
    public function search($term, $type = null, $locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        
        $query = Content::where('published', true);
        
        if ($type) {
            $query->where('type', $type);
        }
        
        return $query->where(function ($q) use ($term, $locale) {
            $q->whereTranslationLike('title', $term, $locale)
              ->orWhereTranslationLike('content', $term, $locale);
        })->paginate(15);
    }
}
```

## 3. Caricamento Lento di Media e Assets

### Problema
Il modulo Cms carica tutti i media e gli assets in modo sincrono, causando tempi di caricamento pagina elevati.

### Impatto
- Tempi di caricamento pagina elevati
- First Contentful Paint (FCP) ritardato
- Esperienze utente degradate su connessioni lente

### Soluzione Passo-Passo

1. **Implementare Lazy Loading per Immagini**

```html
<!-- Prima -->
<img src="/storage/media/large-image.jpg" alt="Description">

<!-- Dopo -->
<img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 3 2'%3E%3C/svg%3E" 
     data-src="/storage/media/large-image.jpg" 
     alt="Description" 
     class="lazyload">
```

2. **Creare un Helper per Generare Tag Immagine Ottimizzati**

```php
// In Modules\Cms\Helpers\MediaHelper.php
namespace Modules\Cms\Helpers;

class MediaHelper
{
    public static function image($path, $alt = '', $options = [])
    {
        $lazy = $options['lazy'] ?? true;
        $class = $options['class'] ?? '';
        $width = $options['width'] ?? null;
        $height = $options['height'] ?? null;
        
        $class .= $lazy ? ' lazyload' : '';
        
        $attributes = '';
        if ($width) $attributes .= " width=\"{$width}\"";
        if ($height) $attributes .= " height=\"{$height}\"";
        
        if ($lazy) {
            return "<img src=\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 3 2'%3E%3C/svg%3E\" data-src=\"{$path}\" alt=\"{$alt}\" class=\"{$class}\"{$attributes}>";
        }
        
        return "<img src=\"{$path}\" alt=\"{$alt}\" class=\"{$class}\"{$attributes}>";
    }
}
```

3. **Creare una Blade Directive per Immagini Ottimizzate**

```php
// In CmsServiceProvider.php
use Illuminate\Support\Facades\Blade;
use Modules\Cms\Helpers\MediaHelper;

public function boot()
{
    // ...
    Blade::directive('image', function ($expression) {
        return "<?php echo MediaHelper::image({$expression}); ?>";
    });
}
```

4. **Implementare Generazione di Srcset per Immagini Responsive**

```php
// Estendi MediaHelper.php
public static function responsiveImage($path, $alt = '', $options = [])
{
    $lazy = $options['lazy'] ?? true;
    $class = $options['class'] ?? '';
    $sizes = $options['sizes'] ?? '100vw';
    
    $class .= $lazy ? ' lazyload' : '';
    
    // Genera varianti dell'immagine
    $srcset = self::generateSrcset($path);
    
    if ($lazy) {
        return "<img src=\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 3 2'%3E%3C/svg%3E\" data-srcset=\"{$srcset}\" data-sizes=\"{$sizes}\" data-src=\"{$path}\" alt=\"{$alt}\" class=\"{$class}\">";
    }
    
    return "<img src=\"{$path}\" srcset=\"{$srcset}\" sizes=\"{$sizes}\" alt=\"{$alt}\" class=\"{$class}\">";
}

protected static function generateSrcset($path)
{
    $widths = [320, 640, 960, 1280, 1920];
    $srcset = [];
    
    foreach ($widths as $width) {
        $resizedPath = self::getResizedImagePath($path, $width);
        $srcset[] = "{$resizedPath} {$width}w";
    }
    
    return implode(', ', $srcset);
}

protected static function getResizedImagePath($path, $width)
{
    // Logica per generare o recuperare l'immagine ridimensionata
    // Esempio: /storage/media/image.jpg -> /storage/media/image-320w.jpg
    $pathInfo = pathinfo($path);
    return "{$pathInfo['dirname']}/{$pathInfo['filename']}-{$width}w.{$pathInfo['extension']}";
}
```

5. **Aggiungere Script per Lazy Loading**

```html
<!-- In layouts/app.blade.php -->
<script src="https://cdn.jsdelivr.net/npm/lazysizes@5.3.2/lazysizes.min.js" async></script>
```

6. **Implementare Preloading per Risorse Critiche**

```php
// Crea un helper per gestire il preloading
namespace Modules\Cms\Helpers;

class PreloadHelper
{
    protected static $preloads = [];
    
    public static function add($url, $as = 'image', $media = null)
    {
        self::$preloads[] = [
            'url' => $url,
            'as' => $as,
            'media' => $media,
        ];
    }
    
    public static function render()
    {
        $html = '';
        
        foreach (self::$preloads as $preload) {
            $media = $preload['media'] ? " media=\"{$preload['media']}\"" : '';
            $html .= "<link rel=\"preload\" href=\"{$preload['url']}\" as=\"{$preload['as']}\"{$media}>\n";
        }
        
        return $html;
    }
}
```

7. **Utilizzare il Preloading nel Layout**

```blade
{{-- In layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {!! PreloadHelper::render() !!}
    
    {{-- Altri meta tag e CSS --}}
</head>
<body>
    {{-- Contenuto della pagina --}}
</body>
</html>
```

## 4. Gestione Inefficiente delle Revisioni dei Contenuti

### Problema
Il modulo Cms memorizza tutte le revisioni dei contenuti nella stessa tabella dei contenuti principali, causando un aumento delle dimensioni della tabella e query più lente.

### Impatto
- Performance degradate con l'aumentare dei contenuti
- Backup e manutenzione database più complessi
- Query più lente per i contenuti attuali

### Soluzione Passo-Passo

1. **Separare le Tabelle per Contenuti e Revisioni**

```php
// Crea una nuova migrazione
php artisan make:migration create_content_revisions_table

// Implementazione
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentRevisionsTable extends Migration
{
    public function up()
    {
        Schema::create('content_revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')->constrained()->onDelete('cascade');
            $table->string('type');
            $table->json('title');
            $table->json('slug');
            $table->json('content');
            $table->unsignedInteger('version');
            $table->string('created_by');
            $table->text('change_summary')->nullable();
            $table->timestamps();
            
            // Indici per query efficienti
            $table->index(['content_id', 'version']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('content_revisions');
    }
}
```

2. **Creare un Modello per le Revisioni**

```php
// In Modules\Cms\Models\ContentRevision.php
namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Cms\Traits\HasTranslations;

class ContentRevision extends Model
{
    use HasTranslations;
    
    protected $casts = [
        'title' => 'array',
        'slug' => 'array',
        'content' => 'array',
    ];
    
    protected $fillable = [
        'content_id', 'type', 'title', 'slug', 'content', 'version', 'created_by', 'change_summary'
    ];
    
    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}
```

3. **Aggiungere Relazione nel Modello Content**

```php
// In Modules\Cms\Models\Content.php
public function revisions()
{
    return $this->hasMany(ContentRevision::class)->orderBy('version', 'desc');
}

public function latestRevision()
{
    return $this->hasOne(ContentRevision::class)->latest('version');
}
```

4. **Implementare un Observer per Gestire le Revisioni**

```php
// In Modules\Cms\Observers\ContentObserver.php
namespace Modules\Cms\Observers;

use Modules\Cms\Models\Content;
use Modules\Cms\Models\ContentRevision;

class ContentObserver
{
    public function saving(Content $content)
    {
        // Se il contenuto esiste già, crea una nuova revisione
        if ($content->exists) {
            $latestRevision = $content->latestRevision;
            $version = $latestRevision ? $latestRevision->version + 1 : 1;
            
            ContentRevision::create([
                'content_id' => $content->id,
                'type' => $content->type,
                'title' => $content->title,
                'slug' => $content->slug,
                'content' => $content->content,
                'version' => $version,
                'created_by' => auth()->user()->name ?? 'System',
                'change_summary' => request('change_summary'),
            ]);
        }
    }
    
    public function created(Content $content)
    {
        // Crea la prima revisione
        ContentRevision::create([
            'content_id' => $content->id,
            'type' => $content->type,
            'title' => $content->title,
            'slug' => $content->slug,
            'content' => $content->content,
            'version' => 1,
            'created_by' => auth()->user()->name ?? 'System',
            'change_summary' => 'Initial version',
        ]);
    }
}
```

5. **Registrare l'Observer**

```php
// In CmsServiceProvider.php
use Modules\Cms\Models\Content;
use Modules\Cms\Observers\ContentObserver;

public function boot()
{
    // ...
    Content::observe(ContentObserver::class);
}
```

6. **Implementare un Repository per Gestire le Revisioni**

```php
// In Modules\Cms\Repositories\ContentRevisionRepository.php
namespace Modules\Cms\Repositories;

use Modules\Cms\Models\Content;
use Modules\Cms\Models\ContentRevision;

class ContentRevisionRepository
{
    public function getRevisions($contentId, $perPage = 15)
    {
        return ContentRevision::where('content_id', $contentId)
            ->orderBy('version', 'desc')
            ->paginate($perPage);
    }
    
    public function getRevision($contentId, $version)
    {
        return ContentRevision::where('content_id', $contentId)
            ->where('version', $version)
            ->first();
    }
    
    public function restoreRevision($contentId, $version)
    {
        $revision = $this->getRevision($contentId, $version);
        
        if (!$revision) {
            return false;
        }
        
        $content = Content::find($contentId);
        
        if (!$content) {
            return false;
        }
        
        $content->title = $revision->title;
        $content->slug = $revision->slug;
        $content->content = $revision->content;
        $content->save();
        
        return true;
    }
    
    public function compareRevisions($contentId, $versionA, $versionB)
    {
        $revisionA = $this->getRevision($contentId, $versionA);
        $revisionB = $this->getRevision($contentId, $versionB);
        
        if (!$revisionA || !$revisionB) {
            return null;
        }
        
        // Implementa la logica di confronto
        // ...
        
        return [
            'title' => $this->compareField($revisionA->title, $revisionB->title),
            'slug' => $this->compareField($revisionA->slug, $revisionB->slug),
            'content' => $this->compareField($revisionA->content, $revisionB->content),
        ];
    }
    
    protected function compareField($a, $b)
    {
        // Implementa la logica di confronto per campi specifici
        // ...
    }
}
```

## 5. Indicizzazione Inefficiente per Ricerca Full-Text

### Problema
Il modulo Cms utilizza query LIKE per la ricerca full-text, che diventano inefficienti con l'aumentare dei contenuti.

### Impatto
- Ricerche lente su grandi volumi di contenuti
- Utilizzo elevato di CPU per query di ricerca
- Risultati di ricerca di bassa qualità

### Soluzione Passo-Passo

1. **Implementare Full-Text Search con MySQL**

```php
// Aggiorna la migrazione per contents
Schema::table('contents', function (Blueprint $table) {
    // Aggiungi indici FULLTEXT
    $table->fullText(['title', 'content']);
});
```

2. **Creare un Trait per Supportare Full-Text Search**

```php
// In Modules\Cms\Traits\SupportsFullTextSearch.php
namespace Modules\Cms\Traits;

trait SupportsFullTextSearch
{
    public function scopeSearch($query, $term)
    {
        $columns = implode(',', $this->searchable);
        
        return $query->whereRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE)", [$term]);
    }
}
```

3. **Implementare il Trait nel Modello Content**

```php
// In Modules\Cms\Models\Content.php
use Modules\Cms\Traits\SupportsFullTextSearch;

class Content extends Model
{
    use HasTranslations, SupportsFullTextSearch;
    
    protected $searchable = [
        'title', 'content'
    ];
    
    // ...
}
```

4. **Ottimizzare per Ricerca Multilingua**

```php
// Estendi il trait SupportsFullTextSearch
public function scopeSearchInLocale($query, $term, $locale = null)
{
    $locale = $locale ?: app()->getLocale();
    
    // Per ogni colonna searchable, estrai il valore nella lingua corrente
    $searchConditions = [];
    
    foreach ($this->searchable as $column) {
        $searchConditions[] = "JSON_EXTRACT({$column}, '$.{$locale}')";
    }
    
    $columns = implode(',', $searchConditions);
    
    return $query->whereRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE)", [$term]);
}
```

5. **Implementare un Servizio di Ricerca Avanzato**

```php
// In Modules\Cms\Services\SearchService.php
namespace Modules\Cms\Services;

use Modules\Cms\Models\Content;

class SearchService
{
    public function search($term, $options = [])
    {
        $type = $options['type'] ?? null;
        $locale = $options['locale'] ?? app()->getLocale();
        $perPage = $options['perPage'] ?? 15;
        
        $query = Content::where('published', true);
        
        if ($type) {
            $query->where('type', $type);
        }
        
        // Utilizza la ricerca full-text
        $query->searchInLocale($term, $locale);
        
        return $query->paginate($perPage);
    }
    
    public function searchWithHighlighting($term, $options = [])
    {
        $results = $this->search($term, $options);
        
        // Aggiungi highlighting ai risultati
        foreach ($results as $result) {
            $result->highlightedTitle = $this->highlight($result->getTranslation('title', $options['locale'] ?? app()->getLocale()), $term);
            $result->highlightedContent = $this->highlight($result->getTranslation('content', $options['locale'] ?? app()->getLocale()), $term);
        }
        
        return $results;
    }
    
    protected function highlight($text, $term)
    {
        return preg_replace("/($term)/i", '<mark>$1</mark>', $text);
    }
}
```

6. **Creare un Controller per la Ricerca**

```php
// In Modules\Cms\Http\Controllers\SearchController.php
namespace Modules\Cms\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Cms\Services\SearchService;

class SearchController extends Controller
{
    protected $searchService;
    
    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }
    
    public function index(Request $request)
    {
        $term = $request->input('q');
        
        if (empty($term)) {
            return view('cms::search.index');
        }
        
        $results = $this->searchService->searchWithHighlighting($term, [
            'type' => $request->input('type'),
            'locale' => app()->getLocale(),
            'perPage' => 15,
        ]);
        
        return view('cms::search.results', compact('results', 'term'));
    }
}
```

## Conclusione

Implementando queste soluzioni, il modulo Cms potrà superare i principali colli di bottiglia e migliorare significativamente le performance dell'applicazione. È consigliabile implementare le soluzioni in modo incrementale, misurando l'impatto di ciascuna modifica per garantire miglioramenti effettivi.

## Collegamenti
- [Roadmap Principale](./roadmap.md)
- [Convenzioni Namespace Filament](./convenzioni-namespace-filament.md)
- [Best Practices](../Xot/docs/BEST-PRACTICES.md)
- [Struttura Moduli](../Xot/docs/MODULE_STRUCTURE.md)

## Collegamenti tra versioni di BOTTLENECKS.md
* [BOTTLENECKS.md](laravel/Modules/Xot/docs/BOTTLENECKS.md)
* [BOTTLENECKS.md](laravel/Modules/User/docs/BOTTLENECKS.md)
* [BOTTLENECKS.md](laravel/Modules/Media/docs/BOTTLENECKS.md)
* [BOTTLENECKS.md](laravel/Modules/Cms/docs/BOTTLENECKS.md)


## Collegamenti tra versioni di bottlenecks.md
* [bottlenecks.md](../../../../bashscripts/docs/bottlenecks.md)
* [bottlenecks.md](../../Chart/docs/bottlenecks.md)
* [bottlenecks.md](../../Chart/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Gdpr/docs/bottlenecks.md)
* [bottlenecks.md](../../Gdpr/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Xot/docs/bottlenecks.md)
* [bottlenecks.md](../../Xot/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Xot/docs/roadmap/bottlenecks.md)
* [bottlenecks.md](../../Dental/docs/bottlenecks.md)
* [bottlenecks.md](../../User/docs/bottlenecks.md)
* [bottlenecks.md](../../User/docs/roadmap/bottlenecks.md)
* [bottlenecks.md](../../UI/docs/bottlenecks.md)
* [bottlenecks.md](../../UI/docs/roadmap/bottlenecks.md)
* [bottlenecks.md](../../Lang/docs/bottlenecks.md)
* [bottlenecks.md](../../Lang/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Job/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Media/docs/bottlenecks.md)
* [bottlenecks.md](../../Media/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Activity/docs/bottlenecks.md)
* [bottlenecks.md](../../Patient/docs/roadmap/bottlenecks.md)

