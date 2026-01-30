# Regole di Ricerca e Gestione Contenuti

## Struttura dei Componenti

### Percorsi Base
- Tema Base: `/laravel/Themes/One/resources/views/components/`
- Moduli UI: `/laravel/Modules/UI/resources/views/components/`
- Moduli Specifici: `/laravel/Modules/{Modulo}/resources/views/components/`

### Best Practices per la Ricerca
- Utilizzare sempre percorsi in minuscolo
- Seguire la gerarchia: tema base -> moduli UI -> moduli specifici
- Verificare la presenza di override nei moduli

## Gestione dei Contenuti

### Struttura dei Dati
- Sezioni: `/laravel/config/local/<nome progetto>/database/content/sections/`
- Blocchi: `/laravel/config/local/<nome progetto>/database/content/blocks/`
- Pagine: `/laravel/config/local/<nome progetto>/database/content/pages/`

### Organizzazione Multilingua
- Ogni contenuto ha una cartella per lingua
- Struttura: `{lingua}/{contenuto}.json`
- Supporto per metadati e traduzioni

### Preview delle Sezioni

#### Struttura della Preview
- Utilizzare `ViewEntry` per la visualizzazione personalizzata
- Percorso vista: `resources/views/sections/preview.blade.php`
- Passare i dati necessari: `blocks` e `section`

#### Componenti della Preview
```php
ViewEntry::make('preview')
    ->translateLabel()
    ->view('cms::sections.preview', [
        'blocks' => $this->record->content_blocks,
        'section' => $this->record,
    ])
```

#### Gestione Multilingua
- Recuperare la lingua corrente: `app()->getLocale()`
- Filtrare le traduzioni per lingua
- Mostrare contenuti nella lingua corretta

#### Best Practices
- Utilizzare classi Tailwind per lo styling
- Implementare gestione errori per contenuti mancanti
- Supportare HTML nei contenuti
- Ordinare i blocchi per `order`

### Performance
- Utilizzare eager loading per le relazioni
- Cache dei contenuti statici
- Ottimizzazione delle query

### Manutenzione
- Documentare le modifiche
- Versionare i contenuti
- Backup regolari
- Verifica integrità dati

## Struttura dei File di Traduzione

### Percorsi
- Cartella principale: `/laravel/Modules/{Modulo}/lang/`
- Cartella resources: `/laravel/Modules/{Modulo}/resources/lang/`

### Formato
```php
return [
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta',
            'tooltip' => 'Descrizione',
        ],
    ],
    'actions' => [
        'action_name' => [
            'label' => 'Etichetta',
            'tooltip' => 'Descrizione',
            'icon' => 'heroicon-o-icon',
            'color' => 'primary',
        ],
    ],
];
```

### Best Practices
- Mantenere coerenza tra le lingue
- Utilizzare chiavi descrittive
- Documentare le traduzioni
- Verificare la completezza

## Gerarchia dei Componenti

1. **Tema Base (One)**
   - Percorso: `/laravel/Themes/One/`
   - Componenti principali in `components/sections/`
   - Layout base in `components/layouts/`
   - Blocchi in `components/blocks/`
   - **ATTENZIONE**: Usare sempre minuscole per le cartelle:
     - `database` non `Database`
     - `resources` non `Resources`
     - `config` non `Config`

2. **Contenuti**
   - Percorso: `/laravel/config/local/<nome progetto>/database/content/`
   - Struttura:
     - `sections/`: Sezioni numerate (1.json, 2.json)
     - `blocks/`: Blocchi riutilizzabili (navigation.json, actions.json)
     - `pages/`: Contenuti specifici delle pagine
   - **ATTENZIONE**: I contenuti sono separati dalla presentazione

3. **Moduli UI**
   - Percorso: `/laravel/Modules/UI/`
   - Estensioni dei componenti base
   - Personalizzazioni specifiche
   - **ATTENZIONE**: Usare sempre minuscole per le cartelle

4. **Moduli Specifici**
   - Percorso: `/laravel/Modules/[NomeModulo]/`
   - Implementazioni specifiche
   - Dipendenze e configurazioni
   - **ATTENZIONE**: Usare sempre minuscole per le cartelle

## Gestione dei Contenuti

### Struttura dei Dati
1. **Sezioni**
   - File numerati: `1.json`, `2.json`
   - ID univoco per ogni sezione
   - Attributi e blocchi
   - Supporto multilingua

2. **Blocchi**
   - File nominati: `navigation.json`, `actions.json`
   - Riutilizzabili tra sezioni
   - Struttura standardizzata
   - Supporto multilingua

3. **Pagine**
   - Contenuti specifici
   - Struttura personalizzata
   - Supporto multilingua
   - Versionamento

### Best Practices

1. **Modifica dei Contenuti**
   - Modificare i file JSON invece del codice
   - Mantenere la struttura coerente
   - Aggiornare tutte le traduzioni
   - Versionare i contenuti

2. **Struttura dei Dati**
   - Usare ID numerici per le sezioni
   - Organizzare i blocchi per lingua
   - Mantenere la coerenza tra sezioni
   - Documentare le modifiche

3. **Performance**
   - Cache dei contenuti
   - Lazy loading dei blocchi
   - Ottimizzazione delle query
   - Minificazione dei JSON

4. **Manutenzione**
   - Testare le traduzioni
   - Verificare la coerenza
   - Aggiornare la documentazione
   - Monitorare le performance

## Gestione dei Blocchi

### Struttura dei Blocchi
1. **Logo Block**
   - View: `pub_theme::components.blocks.logo`
   - Dati:
     ```json
     {
         "view": "pub_theme::components.blocks.logo",
         "src": "/images/logo.svg",
         "alt": "Logo il progetto",
         "width": 150,
         "height": 32
     }
     ```

2. **Navigation Block**
   - View: `pub_theme::components.blocks.navigation`
   - Dati:
     ```json
     {
         "view": "pub_theme::components.blocks.navigation",
         "items": [
             {
                 "label": "Home",
                 "url": "/",
                 "type": "link"
             }
         ],
         "alignment": "start",
         "orientation": "horizontal"
     }
     ```

3. **Actions Block**
   - View: `pub_theme::components.blocks.actions`
   - Dati:
     ```json
     {
         "view": "pub_theme::components.blocks.actions",
         "items": [
             {
                 "label": "Area Pazienti",
                 "url": "/area-pazienti",
                 "type": "button",
                 "variant": "primary"
             }
         ]
     }
     ```

### Best Practices per i Blocchi

1. **Struttura dei Dati**
   - Mantenere una struttura coerente
   - Usare valori di default appropriati
   - Documentare tutti i campi disponibili

2. **Rendering**
   - Usare `@include($block->view, $block->data)`
   - Gestire i valori mancanti
   - Supportare temi dark/light

3. **Stili**
   - Usare classi Tailwind
   - Supportare responsive design
   - Mantenere la coerenza visiva

4. **Accessibilità**
   - Fornire testi alternati
   - Supportare navigazione da tastiera
   - Mantenere contrasto adeguato

## Convenzioni di Naming

### Cartelle
- Usare sempre minuscole
- Usare trattini per spazi: `my-folder`
- Esempi corretti:
  - `database` non `Database`
  - `resources` non `Resources`
  - `config` non `Config`

### File
- Usare minuscole per i nomi
- Usare underscore per spazi: `my_file.php`
- Esempi corretti:
  - `header.blade.php` non `Header.blade.php`
  - `theme_service.php` non `ThemeService.php`

### Namespace
- Usare PascalCase per i namespace
- Usare PascalCase per le classi
- Esempi corretti:
  - `Theme\One\Providers\ThemeServiceProvider`
  - `Theme\One\Components\Header`

### File JSON
- Usare numeri per le sezioni: `1.json`, `2.json`
- Usare nomi descrittivi per i blocchi
- Mantenere la struttura coerente

## Best Practices Generali

1. **Struttura**
   - Mantenere la coerenza nelle maiuscole/minuscole
   - Seguire le convenzioni di naming
   - Verificare i percorsi prima di ogni modifica

2. **Documentazione**
   - Usare sempre minuscole nei percorsi
   - Mantenere la coerenza con la struttura
   - Aggiornare la documentazione quando si modifica la struttura

3. **Sviluppo**
   - Verificare i percorsi prima di ogni commit
   - Mantenere la coerenza tra ambienti
   - Testare su sistemi case-sensitive

4. **Modifiche al Tema**
   - Modificare sempre i componenti nel tema base
   - Non duplicare componenti tra moduli
   - Mantenere la coerenza visiva

5. **Estensioni**
   - Usare i componenti base come punto di partenza
   - Estendere solo quando necessario
   - Documentare le modifiche 
## Collegamenti tra versioni di search.md
* [search.md](docs/rules/search.md)
* [search.md](laravel/Modules/Xot/docs/features/search.md)
* [search.md](laravel/Modules/Xot/docs/rules/search.md)

