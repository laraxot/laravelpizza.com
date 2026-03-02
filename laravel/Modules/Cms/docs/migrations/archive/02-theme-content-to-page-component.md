# Migrazione da $_theme->showPageContent() a <x-page> Component

## Panoramica

Questa guida documenta il processo di migrazione dal vecchio metodo `$_theme->showPageContent()` e `$_theme->showPageSidebarContent()` al nuovo componente Blade `<x-page>` con supporto per sezioni di contenuto specifiche.

## Motivazione della Migrazione

Il vecchio approccio utilizzando `$_theme->showPageContent()` presentava diverse limitazioni:

1. **Accoppiamento stretto**: Dipendenza diretta dal ThemeComposer
2. **Flessibilità limitata**: Impossibilità di specificare quali parti del contenuto visualizzare
3. **Difficoltà nei test**: Complesso da testare in isolamento
4. **Obsolescenza**: Approccio non allineato con le moderne pratiche di Laravel

Il nuovo componente `<x-page>` risolve questi problemi offrendo:

1. **Disaccoppiamento**: Indipendenza dal ThemeComposer
2. **Maggiore flessibilità**: Possibilità di specificare sezioni di contenuto specifiche
3. **Facilità di test**: Componente isolabile e testabile
4. **Modernità**: Allineamento con le best practices di Laravel e l'approccio a componenti

## Guida alla Migrazione

### 1. Identificare i Punti di Utilizzo

Cerca tutte le occorrenze del vecchio pattern nei file Blade:

```bash
# Cerca showPageContent
grep -r "showPageContent" --include="*.blade.php" /var/www/html/_bases/base_predict_fila3_mono/laravel

# Cerca showPageSidebarContent
grep -r "showPageSidebarContent" --include="*.blade.php" /var/www/html/_bases/base_predict_fila3_mono/laravel
```

### 2. Pattern di Migrazione

#### Pattern Principali da Sostituire:

| Vecchio Pattern | Nuovo Pattern |
|----------------|---------------|
| `{{ $_theme->showPageContent('articles') }}` | `<x-page side="content" slug="articles" />` |
| `{{ $_theme->showPageSidebarContent('articles') }}` | `<x-page side="sidebar" slug="articles" />` |
| `{!! $_theme->showPageContent('home') !!}` | `<x-page side="content" slug="home" />` |

### 3. Parametri del Nuovo Componente

Il componente `<x-page>` supporta i seguenti parametri:

| Parametro | Descrizione | Valori Possibili | Default |
|-----------|-------------|------------------|---------|
| `slug` | Identificatore della pagina | Qualsiasi slug valido | (Richiesto) |
| `side` | Sezione di contenuto da visualizzare | `content`, `sidebar`, `header`, `footer` | `content` |
| `lazy` | Caricamento lazy del contenuto | `true`, `false` | `false` |
| `debug` | Mostra informazioni di debug | `true`, `false` | `false` |
| `cache` | Abilita la cache del contenuto | `true`, `false` | `true` |

### 4. Esempi di Migrazione

#### Esempio 1: Contenuto Principale

**Prima:**
```blade
<div class="main-content">
    {{ $_theme->showPageContent('articles') }}
</div>
```

**Dopo:**
```blade
<div class="main-content">
    <x-page side="content" slug="articles" />
</div>
```

#### Esempio 2: Sidebar

**Prima:**
```blade
<aside class="sidebar">
    {{ $_theme->showPageSidebarContent('articles') }}
</aside>
```

**Dopo:**
```blade
<aside class="sidebar">
    <x-page side="sidebar" slug="articles" />
</aside>
```

#### Esempio 3: Layout Completo con Condizioni

**Prima:**
```blade
@if(!empty($page->sidebar_blocks))
    <div class="grid grid-cols-1 lg:grid-cols-[21.25rem,1fr] gap-4">
        <div class="space-y-6">
            {{ $_theme->showPageSidebarContent($page->slug) }}
        </div>
        {{ $_theme->showPageContent($page->slug) }}
    </div>
@else
    <div>
        {{ $_theme->showPageContent($page->slug) }}
    </div>
@endif
```

**Dopo:**
```blade
@if(!empty($page->sidebar_blocks))
    <div class="grid grid-cols-1 lg:grid-cols-[21.25rem,1fr] gap-4">
        <div class="space-y-6">
            <x-page side="sidebar" :slug="$page->slug" />
        </div>
        <x-page side="content" :slug="$page->slug" />
    </div>
@else
    <div>
        <x-page side="content" :slug="$page->slug" />
    </div>
@endif
```

### 5. File che Richiedono Migrazione

I seguenti file contengono ancora il vecchio pattern e devono essere aggiornati:

#### Temi:
- `laravel/Themes/TwentyOne/resources/views/home.blade.php`
- `laravel/Themes/TwentyOne/resources/views/pages/index.blade.php`
- `laravel/Themes/TwentyOne/resources/views/pages/pages/[slug].blade.php`
- `laravel/Themes/TwentyOne/resources/views/pages/show.blade.php`
- `laravel/Themes/Sixteen/resources/views/pages/pages/[slug].blade.php`
- `laravel/Themes/Sixteen/Resources_old*/views/pages/**/*.blade.php`

#### Moduli:
- `laravel/Modules/Blog/resources/views/articles/index.blade.php`
- `laravel/Modules/Blog/app/resources/views/articles/index.blade.php`
- `laravel/Modules/User/resources/views/pages/pages/[slug].blade.php`

### 6. Funzionalità Avanzate

Il componente `<x-page>` offre funzionalità avanzate non disponibili nel vecchio approccio:

#### Caricamento Lazy

```blade
<x-page side="content" slug="articles" lazy />
```

#### Debugging

```blade
<x-page side="content" slug="articles" :debug="true" />
```

#### Binding Dinamico dello Slug

```blade
<x-page side="content" :slug="$page->slug" />
```

### 7. Gestione della Retrocompatibilità

Per garantire una transizione graduale, i metodi `showPageContent()` e `showPageSidebarContent()` sono stati deprecati ma continuano a funzionare, generando un avviso di deprecazione nei log:

```php
/**
 * @deprecated Use <x-page side="content" /> component instead
 */
public function showPageContent(string $slug): Renderable
{
    trigger_deprecation('cms', '2.0', 'Use <x-page side="content" /> component instead.');
    // Implementazione esistente...
}

/**
 * @deprecated Use <x-page side="sidebar" /> component instead
 */
public function showPageSidebarContent(string $slug): Renderable
{
    trigger_deprecation('cms', '2.0', 'Use <x-page side="sidebar" /> component instead.');
    // Implementazione esistente...
}
```

## Vantaggi della Migrazione

1. **Codice più pulito e leggibile**: Sintassi dichiarativa dei componenti Blade
2. **Maggiore flessibilità**: Possibilità di specificare quale parte del contenuto visualizzare
3. **Migliore testabilità**: Componenti isolabili per test unitari
4. **Prestazioni migliori**: Supporto per caricamento lazy e caching
5. **Manutenibilità**: Allineamento con le moderne pratiche di Laravel
6. **Debug migliorato**: Informazioni di debug integrate nel componente

## Conclusione

La migrazione da `$_theme->showPageContent()` e `$_theme->showPageSidebarContent()` a `<x-page>` rappresenta un significativo miglioramento nell'architettura del progetto, allineandolo alle moderne pratiche di Laravel e offrendo maggiore flessibilità, manutenibilità e prestazioni.

Si raccomanda di completare questa migrazione in tutti i file del progetto per garantire coerenza e sfruttare appieno i vantaggi del nuovo approccio basato su componenti.

## Riferimenti

- [Documentazione Componenti Blade Laravel](https://laravel.com/docs/blade#components)
- [Componente Page](../components/page.md)
- [Best Practices per il Rendering delle Pagine](../best-practices/page-rendering.md)
