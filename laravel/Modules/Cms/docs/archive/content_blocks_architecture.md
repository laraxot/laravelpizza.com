# Architettura Content Blocks - <main module>

## Panoramica Architetturale

Il sistema Content Blocks di <main module> implementa un'architettura modulare basata su:

1. **Filament Builder** - Per la gestione dinamica dei blocchi nell'admin
2. **JSON Configuration** - Per la persistenza della struttura delle pagine
3. **Blade Components** - Per il rendering dei blocchi nel tema
4. **Spatie Laravel Data** - Per la validazione e tipizzazione dei dati

## Flusso di Dati

```
Admin Interface (Filament Builder)
         ↓
    JSON Storage (config/local/<directory progetto>/database/content/pages/)
         ↓
    Page Model (Modules/Cms/Models/Page.php)
         ↓
    BlockData Processing (Modules/Cms/Datas/BlockData.php)
         ↓
    Theme Rendering (Themes/One/resources/views/components/blocks/)
         ↓
    Final HTML Output
```

## Componenti Principali

### 1. Configurazione JSON
- **Posizione**: `config/local/<directory progetto>/database/content/pages/`
- **Formato**: Struttura multilingua con content_blocks, sidebar_blocks, footer_blocks
- **Validazione**: Ogni blocco deve specificare type, data e view valida

### 2. BlockData (Spatie Laravel Data)
```php
class BlockData extends Data implements Wireable
{
    public string $type;     // Tipo di blocco (hero, feature_sections, widget, etc.)
    public array $data;      // Dati specifici del blocco
    public string $view;     // Vista Blade da renderizzare
}
```

### 3. Sistema di View
- **Namespace**: `pub_theme::components.blocks.category.view_name`
- **Struttura**: Organizzate per categoria (hero, feature_sections, widget, etc.)
- **Fallback**: Vista di default per blocchi non trovati

## Integrazione con Filament

### Builder Configuration
Il sistema utilizza il Filament Builder per permettere la composizione dinamica delle pagine:

```php
Builder::make('content_blocks')
    ->blocks([
        Builder\Block::make('hero')
            ->schema([/* campi specifici */]),
        Builder\Block::make('feature_sections')  
            ->schema([/* campi specifici */]),
        // Altri blocchi...
    ])
```

### Vantaggi del Builder
- **Drag & Drop**: Riordinamento intuitivo dei blocchi
- **Validazione**: Controllo automatico dei dati inseriti
- **Preview**: Anteprima dei blocchi durante la modifica
- **Versioning**: Gestione delle versioni delle pagine

## Pattern di Estensibilità

### Aggiunta di Nuovi Blocchi
1. Creare la vista Blade in `Themes/One/resources/views/components/blocks/category/`
2. Aggiungere la configurazione nel Builder di Filament
3. Documentare il nuovo tipo di blocco
4. Testare il rendering e la validazione

### Personalizzazione per Tenant
- Ogni tenant può avere configurazioni JSON separate
- Le viste possono essere sovrascritte per tenant specifici
- Supporto per configurazioni multilingua

## Best Practices Architetturali

### 1. Separazione delle Responsabilità
- **JSON**: Solo configurazione e dati
- **BlockData**: Validazione e tipizzazione
- **Blade Views**: Solo presentazione
- **Filament Builder**: Solo interfaccia admin

### 2. Principi SOLID
- **Single Responsibility**: Ogni blocco ha un solo scopo
- **Open/Closed**: Estensibile senza modificare il core
- **Dependency Inversion**: Dipendenze tramite interfacce

### 3. Performance
- **Lazy Loading**: Caricamento on-demand delle viste
- **Caching**: Cache delle configurazioni JSON
- **Optimized Queries**: Query efficienti per il caricamento delle pagine

## Sicurezza

### Validazione Input
- Tutti i dati passano attraverso BlockData per la validazione
- Le viste sono controllate per esistenza prima del rendering
- Sanitizzazione automatica dei dati nelle viste Blade

### Controllo Accessi
- Integrazione con il sistema di permessi di Filament
- Controllo degli accessi basato sui ruoli utente
- Audit trail delle modifiche alle pagine

## Monitoraggio e Debug

### Logging
- Log degli errori di vista mancante
- Tracciamento delle modifiche ai content_blocks
- Performance monitoring per il rendering

### Debug Tools
- Dump dei dati BlockData per troubleshooting
- Visualizzazione della struttura JSON
- Validazione della sintassi delle viste

## Roadmap Futura

### Funzionalità Pianificate
1. **Block Templates**: Template predefiniti per blocchi comuni
2. **A/B Testing**: Supporto per test A/B sui blocchi
3. **Analytics Integration**: Tracciamento delle interazioni con i blocchi
4. **Advanced Caching**: Cache intelligente basata sui contenuti

### Miglioramenti Tecnici
1. **TypeScript Support**: Tipizzazione per l'interfaccia admin
2. **API REST**: Esposizione dei content_blocks via API
3. **GraphQL**: Query flessibili per i dati dei blocchi
4. **Real-time Collaboration**: Editing collaborativo delle pagine

## Collegamenti
- [Documentazione Sistema Content Blocks](./content_blocks_system.md)
- [Implementazione Register Disabled](./register_disabled_implementation.md)
- [Implementazione BlockData](../app/Datas/BlockData.php)
- [Configurazione Builder](../app/Filament/Resources/PageResource.php)
- [Theme Components](../../../Themes/One/resources/views/components/blocks/)

*Ultimo aggiornamento: gennaio 2025*
