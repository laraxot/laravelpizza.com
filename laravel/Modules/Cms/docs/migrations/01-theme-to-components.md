# Migrazione da ThemeComposer a Componenti Blade

## Panoramica

Questo documento descrive il processo di migrazione dal sistema basato su ThemeComposer (`$_theme->showPageContent()`) a un sistema moderno basato su componenti Blade.

## Struttura dei File

```
laravel/Modules/Cms/
├── View/
│   ├── Components/
│   │   └── Page.php           # Nuovo componente Page
│   └── Composers/
│       └── ThemeComposer.php  # Composer esistente
├── resources/
│   └── views/
│       └── components/
│           └── page.blade.php # Template del nuovo componente
└── Providers/
    └── CmsServiceProvider.php # Registrazione componente
```

## Passi della Migrazione

### 1. Creazione del Componente Page

```php
// laravel/Modules/Cms/View/Components/Page.php

namespace Modules\Cms\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Modules\Cms\View\Composers\ThemeComposer;

class Page extends Component
{
    public function __construct(
        public string $slug,
        protected ThemeComposer $theme
    ) {}

    public function render(): View
    {
        $content = $this->theme->showPageContent($this->slug);
        return view('cms::components.page', [
            'content' => $content
        ]);
    }
}
```

### 2. Creazione del Template

```blade
{{-- laravel/Modules/Cms/resources/views/components/page.blade.php --}}
<div>
    {{ $content }}
</div>
```

### 3. Registrazione del Componente

```php
// laravel/Modules/Cms/Providers/CmsServiceProvider.php

public function boot(): void
{
    // ... altro codice ...

    $this->loadViewComponentsAs('cms', [
        \Modules\Cms\View\Components\Page::class,
    ]);
}
```

### 4. Migrazione delle Viste

#### Prima
```blade
{{-- Themes/One/resources/views/pages/index.blade.php --}}
<x-layouts.marketing>
    <div>
        {!! $_theme->showPageContent('home') !!}
    </div>
</x-layouts.marketing>
```

#### Dopo
```blade
{{-- Themes/One/resources/views/pages/index.blade.php --}}
<x-layouts.marketing>
    <div>
        <x-page slug="home" />
    </div>
</x-layouts.marketing>
```

## Comandi per la Migrazione

```bash
# 1. Crea le directory necessarie
mkdir -p laravel/Modules/Cms/View/Components
mkdir -p laravel/Modules/Cms/resources/views/components

# 2. Crea i file
touch laravel/Modules/Cms/View/Components/Page.php
touch laravel/Modules/Cms/resources/views/components/page.blade.php

# 3. Imposta i permessi corretti
chmod 644 laravel/Modules/Cms/View/Components/Page.php
chmod 644 laravel/Modules/Cms/resources/views/components/page.blade.php
```

## Verifica della Migrazione

1. **Test del Componente**:
```php
// laravel/Modules/Cms/Tests/Unit/Components/PageTest.php

namespace Modules\Cms\Tests\Unit\Components;

use Tests\TestCase;
use Modules\Cms\View\Components\Page;
use Modules\Cms\View\Composers\ThemeComposer;

class PageTest extends TestCase
{
    public function test_it_renders_page_content()
    {
        $theme = $this->mock(ThemeComposer::class);
        $theme->shouldReceive('showPageContent')
            ->with('home')
            ->once()
            ->andReturn('Test Content');

        $component = new Page('home', $theme);
        $view = $component->render();

        $this->assertStringContainsString('Test Content', $view->render());
    }
}
```

2. **Test di Integrazione**:
```php
// laravel/Modules/Cms/Tests/Feature/PageComponentTest.php

namespace Modules\Cms\Tests\Feature;

use Tests\TestCase;

class PageComponentTest extends TestCase
{
    public function test_page_component_renders_correctly()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200)
                ->assertSee('home-content');
    }
}
```

## File da Modificare

1. **Viste dei Temi**:
   - `Themes/*/resources/views/pages/index.blade.php`
   - `Themes/*/resources/views/pages/pages/[slug].blade.php`
   - Altri file che usano `$_theme->showPageContent()`

2. **File di Layout**:
   - `Themes/*/resources/views/layouts/marketing.blade.php`
   - Altri layout che potrebbero usare il ThemeComposer

## Deprecazione Graduale

1. **Fase 1 - Marcatura come Deprecated**:
```php
// laravel/Modules/Cms/View/Composers/ThemeComposer.php

/**
 * @deprecated Use <x-page /> component instead
 */
public function showPageContent(string $slug): Renderable
{
    trigger_deprecation('cms', '2.0', 'Use <x-page /> component instead.');
    // ... resto del codice
}
```

2. **Fase 2 - Log delle Chiamate**:
```php
public function showPageContent(string $slug): Renderable
{
    \Log::warning('Deprecated method showPageContent called', [
        'slug' => $slug,
        'trace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)
    ]);
    // ... resto del codice
}
```

## Rollback Plan

In caso di problemi, è possibile tornare temporaneamente al vecchio sistema:

1. **Disattivare il Componente**:
```php
// CmsServiceProvider.php
public function boot(): void
{
    if (config('cms.use_legacy_theme_composer', false)) {
        return;
    }
    
    $this->loadViewComponentsAs('cms', [
        Page::class,
    ]);
}
```

2. **Ripristinare le Viste Originali**:
```bash
git checkout -- Themes/*/resources/views/pages/
```

## Note sulla Compatibilità

- Il componente mantiene la stessa funzionalità del ThemeComposer
- Non sono necessarie modifiche al database
- I contenuti delle pagine rimangono invariati
- La cache esistente rimane valida

## Riferimenti

- [Laravel Components Documentation](https://laravel.com/docs/blade#components)
- [Best Practices per il Rendering delle Pagine](best-practices/page-rendering.md)
- [Architettura del CMS](../architecture.md)

---
@see Themes/One/resources/views/pages/index.blade.php
@see Modules/Cms/View/Composers/ThemeComposer.php 
