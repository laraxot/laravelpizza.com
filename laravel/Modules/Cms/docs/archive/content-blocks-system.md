# Sistema Content Blocks - <main module>

## Panoramica

Il sistema Content Blocks di <main module> utilizza il Builder di Filament per creare pagine dinamiche composte da blocchi riutilizzabili. Ogni pagina è definita tramite file JSON che contengono la configurazione dei content_blocks.

## Struttura dei Content Blocks

### Schema JSON Base

```json
{
    "id": "unique_id",
    "title": {
        "it": "Titolo in italiano",
        "en": "Title in english"
    },
    "slug": "page-slug",
    "content": null,
    "content_blocks": {
        "it": [
            {
                "type": "block_type",
                "data": {
                    "view": "pub_theme::components.blocks.category.view_name",
                    "property1": "value1",
                    "property2": "value2"
                }
            }
        ],
        "en": [
            // Versione inglese dei blocchi
        ]
    },
    "sidebar_blocks": {
        "it": []
    },
    "footer_blocks": null,
    "created_at": "timestamp",
    "updated_at": "timestamp",
    "created_by": "user_id",
    "updated_by": "user_id"
}
```

## Tipi di Blocchi Disponibili

### 1. Hero Block
Blocco principale della pagina con titolo, sottotitolo, immagine e call-to-action.

```json
{
    "type": "hero",
    "data": {
        "view": "pub_theme::components.blocks.hero.view_name",
        "title": "Titolo principale",
        "subtitle": "Sottotitolo descrittivo",
        "image": "url_immagine",
        "cta_text": "Testo bottone",
        "cta_link": "{{ route('route_name') }}",
        "background_color": "bg-white",
        "text_color": "text-gray-900",
        "cta_color": "bg-indigo-600 hover:bg-indigo-700"
    }
}
```

### 2. Feature Sections Block
Sezioni con caratteristiche o FAQ organizzate.

```json
{
    "type": "feature_sections",
    "data": {
        "view": "pub_theme::components.blocks.feature_sections.view_name",
        "title": "Titolo sezione",
        "sections": [
            {
                "title": "Titolo elemento",
                "description": "Descrizione dettagliata",
                "icon": "nome_icona"
            }
        ]
    }
}
```

### 3. Widget Block
Blocco per includere widget Filament dinamici.

```json
{
    "type": "widget",
    "data": {
        "view": "pub_theme::components.blocks.widget.simple",
        "widget": "Modules\\ModuleName\\Filament\\Widgets\\WidgetClass"
    }
}
```

### 4. Landing Page Block
Blocco specializzato per landing page.

```json
{
    "type": "landing-page",
    "data": {
        "view": "pub_theme::components.blocks.hero.landing-page",
        "title": "Titolo landing",
        "subtitle": "Sottotitolo",
        "image": "url_immagine",
        "cta_text": "Call to action",
        "cta_link": "{{ route('register') }}",
        "background_color": "bg-white",
        "text_color": "text-gray-900",
        "cta_color": "bg-indigo-600 hover:bg-indigo-700"
    }
}
```

## Sistema di Rendering

### BlockData Class
La classe `BlockData` gestisce la validazione e il rendering dei blocchi:

```php
class BlockData extends Data implements Wireable
{
    public string $type;
    public array $data;
    public string $view;

    public function __construct(string $type, array $data) {
        $this->type = $type;
        $this->data = $data;
        $view = Arr::get($data, 'view', 'ui::empty');
        if (!view()->exists($view)) {
            throw new \Exception('view not found: ' . $view);
        }
        $this->view = $view;
    }
}
```

### Rendering Process
1. Il JSON viene caricato dal modello `Page`
2. I `content_blocks` vengono processati da `BlockData::collect()`
3. Ogni blocco viene renderizzato tramite la sua view specificata
4. Le view sono organizzate nel tema sotto `Themes/One/resources/views/components/blocks/`

## Convenzioni di Naming

### File JSON
- Posizionati in: `config/local/<directory progetto>/database/content/pages/`
- Naming: `kebab-case.json`

### View Blade
- Posizionate in: `Themes/One/resources/views/components/blocks/`
- Struttura: `category/view_name.blade.php`
- Namespace: `pub_theme::components.blocks.category.view_name`

### Proprietà Data
- Utilizzare `snake_case` per le proprietà nei data
- Mantenere coerenza con le convenzioni CSS (es: `background_color`, `text_color`)

## Best Practices

1. **Validazione View**: Ogni blocco DEVE specificare una view esistente
2. **Localizzazione**: Supportare sempre almeno italiano e inglese
3. **Riutilizzabilità**: Progettare blocchi per essere riutilizzabili tra pagine
4. **Fallback**: Prevedere sempre un fallback per view mancanti
5. **Performance**: Evitare logica complessa nei template, delegare ai widget

## Integrazione con Filament Builder

Il sistema utilizza il [Filament Builder](https://filamentphp.com/docs/3.x/forms/fields/builder) per la gestione dinamica dei blocchi nell'interfaccia admin.

### Configurazione Builder

```php
Builder::make('content_blocks')
    ->blocks([
        Builder\Block::make('hero')
            ->schema([
                TextInput::make('title')->required(),
                TextInput::make('subtitle'),
                FileUpload::make('image'),
                TextInput::make('cta_text'),
                TextInput::make('cta_link'),
            ]),
        Builder\Block::make('feature_sections')
            ->schema([
                TextInput::make('title'),
                Repeater::make('sections')
                    ->schema([
                        TextInput::make('title'),
                        Textarea::make('description'),
                        TextInput::make('icon'),
                    ]),
            ]),
    ])
```

## Troubleshooting

### View Not Found
Errore: `view not found: pub_theme::components.blocks.category.view_name`
- Verificare che il file blade esista nel percorso corretto
- Controllare la sintassi del namespace della view

### Missing Properties
Errore: Proprietà mancanti nel template
- Verificare che tutte le proprietà richieste siano presenti nel data del blocco
- Utilizzare il null coalescing operator `??` per valori opzionali

## Collegamenti
- [Filament Builder Documentation](https://filamentphp.com/docs/3.x/forms/fields/builder)
- [Architettura Content Blocks](./content_blocks_architecture.md)
- [Implementazione Register Disabled](./register_disabled_implementation.md)
- [BlockData Implementation](../app/Datas/BlockData.php)
- [Page Model](../app/Models/Page.php)
- [Theme Components](../../../Themes/One/resources/views/components/blocks/)

*Ultimo aggiornamento: gennaio 2025*
