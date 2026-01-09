# Blocchi

## Panoramica
I blocchi sono componenti modulari e riutilizzabili che possono essere utilizzati in qualsiasi parte di una pagina (header, content, footer, sidebar). Questa documentazione fornisce una panoramica del sistema dei blocchi e collegamenti alla documentazione dettagliata nei rispettivi moduli.

## Principi Fondamentali

1. **Indipendenza dal Contesto**
   - I blocchi sono indipendenti dalla loro posizione nella pagina
   - Lo stesso blocco può essere utilizzato in contesti diversi
   - La posizione è determinata dall'uso, non dall'implementazione

2. **Riusabilità**
   - I blocchi sono generici e riutilizzabili
   - La personalizzazione avviene tramite configurazione
   - Nessuna logica specifica per il contesto

3. **Composabilità**
   - I blocchi possono essere combinati liberamente
   - L'ordine e la disposizione sono flessibili
   - La struttura della pagina è definita dalla composizione

## Moduli con Blocchi

### Modulo CMS
Il modulo CMS fornisce l'implementazione base dei blocchi:
- [Documentazione Blocchi](../laravel/Modules/Cms/docs/blocks/content-blocks.md)
- [Gestione Contenuti](../laravel/Modules/Cms/docs/content-storage.md)
- [Implementazione Filament](../laravel/Modules/Cms/docs/filament-resources.md)

### Modulo UI
Il modulo UI fornisce i componenti visuali:
- [Componenti UI](../laravel/Modules/UI/docs/components/README.md)
- [Best Practices UI](../laravel/Modules/UI/docs/best-practices.md)
- [Temi e Stili](../laravel/Modules/UI/docs/themes/README.md)

### Modulo Xot
Il modulo Xot fornisce le funzionalità base:
- [Architettura Blocchi](../laravel/Modules/Xot/docs/blocks/README.md)
- [Convenzioni di Codice](../laravel/Modules/Xot/docs/code-standards.md)
- [Best Practices](../laravel/Modules/Xot/docs/BEST-PRACTICES.md)

## Categorie di Blocchi

### Blocchi di Layout
- Navigation
- Logo
- Actions
- Container
- Grid
- Columns

### Blocchi di Contenuto
- Rich Text
- Hero
- Features
- Stats
- Testimonials
- Gallery

### Blocchi Interattivi
- Contact Form
- Newsletter
- Social Links
- Maps
- Search
- Calendar

## Utilizzo dei Blocchi

### In Header
```php
@foreach($header_blocks as $block)
    @include($block->view, ['data' => $block->data])
@endforeach
```

### Nel Contenuto
```php
@foreach($content_blocks as $block)
    @include($block->view, ['data' => $block->data])
@endforeach
```

### In Footer
```php
@foreach($footer_blocks as $block)
    @include($block->view, ['data' => $block->data])
@endforeach
```

### In Sidebar
```php
@foreach($sidebar_blocks as $block)
    @include($block->view, ['data' => $block->data])
@endforeach
```

## Best Practices

1. **Design**
   - Mantenere i blocchi generici
   - Evitare dipendenze dal contesto
   - Utilizzare configurazioni per personalizzare

2. **Implementazione**
   - Separare logica e presentazione
   - Mantenere la coerenza nel codice
   - Documentare ogni blocco

3. **Performance**
   - Lazy loading delle risorse
   - Caching appropriato
   - Ottimizzazione delle immagini

4. **Accessibilità**
   - ARIA labels
   - Contrasto appropriato
   - Supporto tastiera

## Collegamenti Utili

- [Documentazione Frontend](frontend.md)
- [Gestione Pagine](pages.md)
- [Configurazione](configuration.md)
- [Sviluppo](development.md)

## Note
Questa documentazione è collegata bidirezionalmente con la documentazione specifica dei moduli. Per dettagli implementativi, consultare la documentazione del modulo appropriato.

## Gestione delle Route nei Blocchi

### Problema
Quando si utilizzano route dinamiche nei blocchi, è importante considerare che:
1. I blocchi possono essere utilizzati in contesti diversi
2. Le route devono essere risolte correttamente nel contesto dell'applicazione
3. I dati dei blocchi possono provenire da diverse fonti (JSON, database, ecc.)

### Soluzione
Per gestire correttamente le route nei blocchi, seguire queste linee guida:

1. **Nei file JSON di configurazione**:
   ```json
   {
     "cta_link": "register",  // Nome della route senza helper
     "cta_route_params": []   // Parametri opzionali per la route
   }
   ```

2. **Nel template del blocco**:
   ```php
   <a href="{{ route($data['cta_link'], $data['cta_route_params'] ?? []) }}">
     {{ $data['cta_text'] }}
   </a>
   ```

3. **Best Practices**:
   - Non utilizzare direttamente l'helper `route()` nei file JSON
   - Passare il nome della route come stringa
   - Utilizzare parametri opzionali per le route
   - Documentare le route disponibili per ogni blocco

4. **Esempio di Implementazione**:
   ```php
   // Nel controller o nel servizio che prepara i dati
   $blockData = [
     'cta_link' => 'register',
     'cta_route_params' => [],
     'cta_text' => 'Registrati'
   ];
   ```

5. **Validazione**:
   - Verificare che la route esista prima di utilizzarla
   - Fornire un fallback per route non valide
   - Loggare eventuali errori di route

## Collegamenti tra versioni di blocks.md
* [blocks.md](../../../Xot/docs/blocks.md)
* [blocks.md](../../../User/docs/blocks.md)
* [blocks.md](../../../UI/docs/blocks.md)
* [blocks.md](../../../Cms/docs/blocks.md)
* [blocks.md](../../../../Themes/One/docs/blocks.md)
* [blocks.md](../../../../Themes/One/docs/components/blocks.md)
