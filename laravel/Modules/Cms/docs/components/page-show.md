# Componente Livewire Page/Show

## Descrizione
Il componente `x-page.show` è un componente Livewire che sostituisce la funzione `$_theme->showPageContent()` per visualizzare il contenuto delle pagine. Questo componente fornisce un modo più moderno e flessibile per rendere i contenuti delle pagine, sfruttando la potenza di Livewire.

## Vantaggi
- **Performance migliorate**: Caricamento asincrono dei contenuti
- **Reattività**: Aggiornamenti dinamici della pagina senza necessità di ricaricare
- **Riusabilità**: Componente standardizzato per tutte le pagine
- **Manutenibilità**: Separazione delle responsabilità tra logica e presentazione

## Utilizzo

### Sintassi di base
```blade
<x-page.show slug="home" />
```

### Parametri
| Parametro | Tipo     | Obbligatorio | Descrizione                               |
|-----------|----------|--------------|-------------------------------------------|
| slug      | string   | Sì           | Lo slug della pagina da visualizzare      |
| theme     | string   | No           | Il tema da utilizzare (opzionale)         |
| cache     | boolean  | No           | Se abilitare la cache (default: true)     |

### Esempio completo
```blade
<x-page.show 
    slug="chi-siamo" 
    :theme="$currentTheme" 
    :cache="false" 
/>
```

## Implementazione

### File principali
- **Livewire Component**: `Modules/Cms/app/Http/Livewire/Page/Show.php`
- **View**: `Modules/Cms/resources/views/livewire/page/show.blade.php`

### Componente Blade
Per utilizzare il componente nei file Blade, è necessario registrarlo in `AppServiceProvider` o in un service provider dedicato:

```php
// In un service provider
Blade::component('page.show', \Modules\Cms\Http\Livewire\Page\Show::class);
```

### Conversione dalla versione precedente

#### Vecchio metodo
```blade
{!! $_theme->showPageContent('home') !!}
```

#### Nuovo metodo
```blade
<x-page.show slug="home" />
```

## Integrazione con altri componenti
Il componente Page/Show può essere facilmente integrato con altri componenti Livewire o Blade:

```blade
<div class="container">
    <x-page.show slug="home" />
    
    <x-page.comments :page-id="$pageId" />
</div>
```

## Debugging
Per visualizzare informazioni di debug sul caricamento della pagina, è possibile passare il parametro `debug`:

```blade
<x-page.show slug="home" :debug="true" />
```

## Collegamenti
- [Documentazione Livewire](https://laravel-livewire.com/docs)
- [Gestione Pagine CMS](/Modules/Cms/docs/content.md) 
