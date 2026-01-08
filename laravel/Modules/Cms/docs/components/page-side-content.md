# Componente Page con Supporto per Sezioni di Contenuto

## Introduzione

Il componente `<x-page>` con il parametro `side` rappresenta un'evoluzione significativa rispetto al precedente metodo `$_theme->showPageContent()`. Questo componente permette di visualizzare sezioni specifiche del contenuto di una pagina, offrendo maggiore flessibilità e controllo sul rendering.

## Sintassi Base

```blade
<x-page side="content" slug="articles" />
```

## Parametri

| Parametro | Descrizione | Valori Possibili | Default |
|-----------|-------------|------------------|---------|
| `slug` | Identificatore della pagina | Qualsiasi slug valido | (Richiesto) |
| `side` | Sezione di contenuto da visualizzare | `content`, `sidebar`, `header`, `footer` | `content` |
| `lazy` | Caricamento lazy del contenuto | `true`, `false` | `false` |
| `debug` | Mostra informazioni di debug | `true`, `false` | `false` |
| `cache` | Abilita la cache del contenuto | `true`, `false` | `true` |

## Sezioni di Contenuto (side)

Il parametro `side` permette di specificare quale sezione del contenuto della pagina visualizzare:

### content

La sezione principale del contenuto della pagina.

```blade
<x-page side="content" slug="articles" />
```

### sidebar

La barra laterale della pagina, tipicamente contenente widget, menu secondari o contenuti correlati.

```blade
<x-page side="sidebar" slug="articles" />
```

### header

L'intestazione specifica della pagina, che può includere titoli, breadcrumb o immagini di copertina.

```blade
<x-page side="header" slug="articles" />
```

### footer

Il piè di pagina specifico della pagina, che può includere informazioni aggiuntive, link correlati o call-to-action.

```blade
<x-page side="footer" slug="articles" />
```

## Esempi di Utilizzo

### Layout Completo con Tutte le Sezioni

```blade
<div class="page-container">
    <header class="page-header">
        <x-page side="header" slug="articles" />
    </header>
    
    <div class="page-body">
        <main class="page-content">
            <x-page side="content" slug="articles" />
        </main>
        
        <aside class="page-sidebar">
            <x-page side="sidebar" slug="articles" />
        </aside>
    </div>
    
    <footer class="page-footer">
        <x-page side="footer" slug="articles" />
    </footer>
</div>
```

### Layout con Sidebar Condizionale

```blade
<div class="page-container">
    <main class="page-content">
        <x-page side="content" slug="articles" />
    </main>
    
    @if($showSidebar)
        <aside class="page-sidebar">
            <x-page side="sidebar" slug="articles" />
        </aside>
    @endif
</div>
```

### Caricamento Lazy per Contenuti Pesanti

```blade
<div class="page-container">
    <main class="page-content">
        <x-page side="content" slug="articles" />
    </main>
    
    <aside class="page-sidebar">
        <x-page side="sidebar" slug="articles" lazy />
    </aside>
</div>
```

## Personalizzazione Avanzata

### Template Personalizzati

È possibile specificare un template personalizzato per il rendering del contenuto:

```blade
<x-page side="content" slug="articles" template="custom-template" />
```

### Debug Mode

Per visualizzare informazioni di debug durante lo sviluppo:

```blade
<x-page side="content" slug="articles" :debug="true" />
```

### Disabilitazione della Cache

Per i contenuti che cambiano frequentemente, è possibile disabilitare la cache:

```blade
<x-page side="content" slug="articles" :cache="false" />
```

## Migrazione dal Vecchio Pattern

### Vecchio Pattern

```blade
{{ $_theme->showPageContent('articles') }}
```

### Nuovo Pattern

```blade
<x-page side="content" slug="articles" />
```

Per una guida completa alla migrazione, consultare il documento [Migrazione da $_theme->showPageContent() a <x-page> Component](../migrations/02_theme_content_to_page_component.md).

## Implementazione Interna

Il componente `<x-page>` utilizza internamente il pattern repository per recuperare i contenuti della pagina dal database o da altre fonti di dati, e il pattern decorator per applicare trasformazioni e formattazioni al contenuto prima del rendering.

## Best Practices

1. **Utilizzare sempre il parametro `side`**: Anche se il valore predefinito è `content`, è consigliabile specificarlo sempre per maggiore chiarezza.
2. **Abilitare il caricamento lazy per contenuti secondari**: Utilizzare il parametro `lazy` per contenuti non critici come sidebar o footer.
3. **Considerare la cache**: Per contenuti che cambiano raramente, mantenere la cache abilitata per migliori prestazioni.
4. **Utilizzare template personalizzati con moderazione**: I template personalizzati dovrebbero essere utilizzati solo quando necessario per evitare duplicazione del codice.

## Risoluzione dei Problemi

### Contenuto Non Visualizzato

Se il contenuto non viene visualizzato:

1. Verificare che lo slug sia corretto e che la pagina esista nel database.
2. Controllare che la sezione specificata (`side`) contenga effettivamente del contenuto.
3. Provare a disabilitare la cache con `:cache="false"` per vedere se il problema è legato alla cache.
4. Abilitare il debug con `:debug="true"` per visualizzare informazioni aggiuntive.

### Prestazioni Scadenti

Se si riscontrano problemi di prestazioni:

1. Utilizzare il caricamento lazy per contenuti non critici.
2. Verificare che la cache sia abilitata per contenuti che cambiano raramente.
3. Considerare l'ottimizzazione del database e delle query utilizzate per recuperare i contenuti.

## Conclusione

Il componente `<x-page>` con il parametro `side` rappresenta un significativo miglioramento rispetto al vecchio metodo `$_theme->showPageContent()`, offrendo maggiore flessibilità, controllo e prestazioni. Si raccomanda di utilizzare questo nuovo approccio in tutti i nuovi sviluppi e di migrare gradualmente il codice esistente.

## Riferimenti

- [Migrazione da $_theme->showPageContent() a <x-page> Component](../migrations/02_theme_content_to_page_component.md)
- [Componente Page Show](page-show.md)
- [Best Practices per il Rendering delle Pagine](../best-practices/page-rendering.md)