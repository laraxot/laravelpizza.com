# Best Practices per il Rendering delle Pagine

## Stato Attuale vs Best Practice

### Approccio Attuale
Attualmente, il rendering delle pagine viene gestito attraverso il ThemeComposer utilizzando la sintassi:

```blade
{!! $_theme->showPageContent('home') !!}
```

Questo approccio presenta diverse problematiche:

1. **Sicurezza**:
   - Utilizza `{!! !!}` per l'output non escaped
   - Rischio di XSS se il contenuto non è propriamente sanitizzato

2. **Manutenibilità**:
   - Dipendenza da una variabile globale `$_theme`
   - Difficoltà nel tracciare la provenienza e il comportamento del codice
   - Scarsa documentazione IDE

3. **Testing**:
   - Difficoltà nel mockare la variabile globale
   - Complessità nel testare in isolamento

### Approccio Raccomandato
Si consiglia di migrare verso un sistema basato su componenti Blade:

```blade
<x-page slug="home" />
```

#### Implementazione Raccomandata

1. **Definizione del Componente**:
```php
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

2. **Template del Componente**:
```blade
{{-- resources/views/components/page.blade.php --}}
<div>
    {{ $content }}
</div>
```

3. **Registrazione del Componente**:
```php
// Modules/Cms/Providers/CmsServiceProvider.php
public function boot(): void
{
    $this->loadViewComponentsAs('cms', [
        Page::class,
    ]);
}
```

## Vantaggi del Nuovo Approccio

1. **Sicurezza Migliorata**:
   - Escaping automatico dell'HTML
   - Migliore controllo sul contenuto renderizzato
   - Prevenzione automatica XSS

2. **Manutenibilità**:
   - Codice più organizzato e modulare
   - Migliore separazione delle responsabilità
   - Facilità di estensione e modifica

3. **Developer Experience**:
   - Supporto IDE completo
   - Autocompletamento
   - Type-hinting
   - Documentazione inline

4. **Performance**:
   - Caching automatico dei componenti
   - Ottimizzazione del rendering
   - Lazy loading facilitato

5. **Testing**:
   - Facilità di mock dei componenti
   - Test unitari semplificati
   - Migliore copertura del codice

## Piano di Migrazione

1. **Fase 1: Preparazione**
   - Creare il nuovo componente Page
   - Testarlo in ambiente di sviluppo
   - Documentare l'API del componente

2. **Fase 2: Implementazione Graduale**
   - Identificare tutte le occorrenze di `$_theme->showPageContent()`
   - Migrare gradualmente ogni occorrenza al nuovo componente
   - Verificare la compatibilità e il funzionamento

3. **Fase 3: Deprecazione**
   - Marcare `$_theme->showPageContent()` come deprecated
   - Aggiornare la documentazione
   - Pianificare la rimozione completa

## Esempi di Utilizzo

### Prima
```blade
<x-layouts.marketing>
    <div>
        {!! $_theme->showPageContent('home') !!}
    </div>
</x-layouts.marketing>
```

### Dopo
```blade
<x-layouts.marketing>
    <div>
        <x-page slug="home" />
    </div>
</x-layouts.marketing>
```

## Funzionalità Avanzate

Il nuovo componente può essere facilmente esteso per supportare:

1. **Caching**:
```php
public function render(): View
{
    $content = Cache::remember("page_{$this->slug}", 3600, function () {
        return $this->theme->showPageContent($this->slug);
    });
    
    return view('cms::components.page', compact('content'));
}
```

2. **Lazy Loading**:
```blade
<x-page slug="home" lazy />
```

3. **Personalizzazione del Layout**:
```blade
<x-page 
    slug="home"
    :layout="$customLayout"
    :class="$additionalClasses"
/>
```

## File Correlati

- `laravel/Themes/One/resources/views/pages/index.blade.php`
- `laravel/Modules/Cms/View/Composers/ThemeComposer.php`
- `laravel/Modules/Cms/View/Components/Page.php` (nuovo)
- `laravel/Modules/Cms/resources/views/components/page.blade.php` (nuovo)

## Link alla Documentazione Generale

Per una documentazione più dettagliata sul sistema di gestione dei contenuti e dei temi, consultare:
- [Architettura del CMS](/docs/cms/architecture.md)
- [Sistema dei Temi](/docs/themes/overview.md)
- [Gestione dei Contenuti](/docs/content/management.md)

---
@see laravel/Themes/One/resources/views/pages/index.blade.php
@see laravel/docs/cms/components.md 
