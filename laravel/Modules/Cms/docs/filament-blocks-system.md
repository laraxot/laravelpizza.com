# Sistema Filament Blocks - Modulo CMS

## Panoramica
Il modulo CMS implementa un sistema avanzato di gestione contenuti basato su Filament Builder Blocks, che permette la creazione dinamica di pagine web attraverso un'interfaccia amministrativa intuitiva.

## Architettura del Sistema

### 1. PageResource
**File**: `Modules/Cms/app/Filament/Resources/PageResource.php`

**Caratteristiche**:
- Estende `LangBaseResource` per supporto multilingua
- Utilizza `PageContentBuilder` per i blocchi di contenuto
- Gestisce tre sezioni principali: Content, Sidebar, Footer

### 2. PageContentBuilder
**File**: `Modules/Cms/app/Filament/Fields/PageContentBuilder.php`

**Funzionalità**:
- Scansiona automaticamente tutti i blocchi disponibili
- Genera dinamicamente l'interfaccia Filament Builder
- Supporta contesti diversi (form, display, etc.)

## Sistema di Blocchi

### Struttura Blocchi
Ogni blocco è definito in `Modules/UI/app/Filament/Blocks/` e implementa:

```php
class Hero
{
    public static function make(
        string $name = 'hero',
        string $context = 'form',
    ): Block {
        return Block::make($name)
            ->schema([
                TextInput::make('title'),
                RichEditor::make('text'),
                FileUpload::make('background'),
                // Altri campi...
            ]);
    }
}
```

### Blocchi Disponibili
- **Hero**: Blocchi hero con titolo, testo, immagine, CTA
- **Title**: Titoli con formattazione
- **Image**: Gestione immagini con Spatie Media Library
- **Paragraph**: Testi formattati
- **Navigation**: Menu di navigazione
- **Slider**: Caroselli di contenuti
- **Contact**: Form di contatto
- **Video**: Gestione video con Spatie Media Library

## Storage dei Contenuti

### Struttura JSON
I contenuti sono salvati in file JSON con struttura:

```json
{
    "id": "1",
    "title": {
        "it": "Titolo in italiano",
        "en": "Title in English"
    },
    "slug": "page-slug",
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "data": {
                    "title": "Titolo Hero",
                    "text": "Testo del hero",
                    "background": "path/to/image.jpg"
                }
            }
        ]
    }
}
```

### Percorso Storage
**Base**: `config/local/<directory progetto>/database/content/pages/`

**File**: `{slug}.json` (es. `home.json`, `about.json`)

## Integrazione Frontend

### Componente Volt
La homepage utilizza:
```blade
@volt('home')
    <div>
        <x-page side="content" slug="home" :type="auth()->user()?->type?->value" />
    </div>
@endvolt
```

### Componente CMS
`<x-page>` carica dinamicamente:
- Contenuto dal JSON corrispondente
- Blocchi renderizzati tramite view specifiche
- Localizzazione basata sulla lingua corrente

## Gestione Blocchi

### Auto-Discovery
Il sistema scopre automaticamente i blocchi tramite:
1. **Scan Directory**: `Modules/*/app/Filament/Blocks/*.php`
2. **Reflection**: Analisi delle classi per metadati
3. **Registration**: Registrazione automatica in Filament

### Context Support
Ogni blocco supporta diversi contesti:
- **form**: Interfaccia di editing
- **display**: Rendering frontend
- **preview**: Anteprima in backoffice

## Best Practices

### 1. Creazione Blocchi
- Mantenere interfacce semplici e intuitive
- Utilizzare validazione robusta per i campi
- Supportare localizzazione completa
- Implementare preview quando possibile

### 2. Gestione Contenuti
- Struttura JSON coerente e validata
- Versioning dei contenuti
- Backup automatici
- Cache intelligente per performance

### 3. Performance
- Lazy loading per blocchi pesanti
- Ottimizzazione immagini
- Cache contenuti JSON
- CDN per assets statici

## Testing Strategy

### Test CMS (Content Management)
- **CRUD Operations**: Creazione, lettura, aggiornamento, eliminazione pagine
- **Block Management**: Gestione blocchi e configurazioni
- **Validation**: Validazione dati e business rules
- **Integration**: Integrazione con Filament e frontend

### Test <main module> (Frontend Integration)
- **Rendering**: Visualizzazione corretta dei contenuti
- **Performance**: Tempi di caricamento e ottimizzazioni
- **SEO**: Meta tags e struttura semantica
- **Responsiveness**: Adattamento a diversi dispositivi

## Responsabilità Moduli

### Modulo CMS
- **Content Management**: Gestione completa dei contenuti
- **Block System**: Definizione e configurazione blocchi
- **Filament Integration**: Interfaccia amministrativa
- **Content Storage**: Gestione JSON e database

### Modulo <main module>
- **Frontend Logic**: Rendering e logica business
- **Volt Components**: State management e interazioni
- **CMS Integration**: Coordinamento con sistema contenuti

### Modulo UI
- **Block Components**: Implementazione blocchi
- **View Templates**: Template per rendering
- **Block Actions**: Azioni per gestione blocchi

## Collegamenti
- [Modulo <main module>](../<main module>/docs/homepage-architecture.md)
- [Modulo UI](../UI/docs/blocks-system.md)
- [Filament Builder](https://filamentphp.com/docs/3.x/forms/fields/builder)
- [Laravel Folio](../../docs/folio-routing.md)

*Ultimo aggiornamento: Dicembre 2024*












