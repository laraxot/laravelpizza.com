---
type: overview
module: Cms
sources:
  - ../../../docs/content-blocks-system.md
  - ../../../docs/folio-routing-locale.md
  - ../../../docs/business-logic-overview.md
confidence: high
updated: 2026-04-15
---

# Cms Module — Overview

> **Ruolo**: Gestione contenuti frontend con routing Folio, blocchi JSON e supporto multilingua.

## Responsabilità del Modulo

Il modulo Cms è il layer di **content management** del frontend:

- Gestisce `Page` con struttura gerarchica (parent/child) e slug per locale
- Espone le pagine tramite routing Folio (file-based, con prefisso locale)
- Definisce blocchi di contenuto JSON editabili via Filament Builder
- Gestisce `Menu`, `Section`, `Conf` per navigazione e configurazione

## Entità Core

| Modello | Scopo |
|---------|-------|
| `Page` | Pagina con slug, status, content_blocks per locale, meta SEO |
| `Section` | Sezione modulare riutilizzabile |
| `Menu` | Navigazione dinamica con visibilità per ruolo |
| `Conf` | Configurazione system-wide |

## Content Blocks System

Le pagine memorizzano il contenuto come array JSON nel campo `content_blocks.{locale}`:

```json
{
  "type": "hero",
  "data": {
    "view": "pub_theme::components.blocks.hero.main",
    "title": "Titolo pagina",
    "subtitle": "Sottotitolo",
    "cta_text": "Scopri di più",
    "cta_link": "/servizi"
  }
}
```

### Tipi di blocco principali

| Tipo | View namespace | Scopo |
|------|---------------|-------|
| `hero` | `blocks.hero.*` | Header pagina con CTA |
| `feature_sections` | `blocks.feature_sections.*` | Sezioni feature con icone |
| `widget` | `blocks.widget.*` | Widget Filament embedded |
| `landing-page` | `blocks.landing.*` | Layout completo landing |
| `text` | `blocks.text.*` | Rich text WYSIWYG |
| `image` | `blocks.image.*` | Media responsivo |
| `form` | `blocks.form.*` | Form dinamici |

### Rendering pipeline

1. `Page` carica il JSON da `content_blocks.{locale}`
2. `BlockData::collect()` processa l'array
3. `BlockData::__construct()` valida che la view esista (`view()->exists($view)`)
4. Ogni blocco viene renderizzato dalla view specificata in `data.view`
5. Le view risiedono in `Themes/{pub_theme}/resources/views/components/blocks/`

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

### Integrazione Filament Builder

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
    ])
```

## Folio Routing con Locale

Il routing frontend è **file-based** tramite Laravel Folio + Volt:

- `FolioVoltServiceProvider` registra le pagine con prefisso locale (`->uri($locale)`)
- Tutte le route derivano dalla struttura di file in `Themes/{Theme}/resources/views/pages/` e `Modules/{Module}/resources/views/pages/`
- **Regola critica**: tutti i link interni devono usare `LaravelLocalization::localizeUrl($path)`

```
/it/servizi    → pages/servizi.blade.php  (locale = it)
/en/services   → pages/services.blade.php (locale = en)
```

### Struttura URL

```
/{locale}/{slug}          → pagine Folio
/{locale}/admin/**        → Filament panel
```

## Multi-Language

- Contenuto per locale: `content_blocks.it`, `content_blocks.en`
- Slug unico per locale per evitare conflitti URL
- Locale predefinito richiesto prima delle traduzioni
- Redirect automatico per traduzioni mancanti
- Meta tag SEO per locale: `meta_description.{locale}`

## Regole Operative

1. Le view dei blocchi DEVONO esistere — `BlockData` lancia eccezione se mancanti
2. Usare `snake_case` per le proprietà nei `data` dei blocchi
3. I file JSON di seed stanno in `config/local/<progetto>/database/content/pages/`
4. I template Blade stanno in `Themes/{pub_theme}/resources/views/components/blocks/{category}/`
5. Non mettere logica complessa nei template — delegare ai widget Filament

## Cross-References

- [[../../../../../../laravel/Modules/Xot/docs/wiki/overviews/xot-module|Xot Module]] — base XotBaseModel usato da Page, Section, Menu
- [[../../../../../../laravel/Themes/Sixteen/docs/wiki/index|Sixteen Theme]] — view dei blocchi per Design Comuni
- [[../../../../../../laravel/Themes/TwentyOne/docs/wiki/index|TwentyOne Theme]] — view dei blocchi per tema cinematografico
- [[../../../../../../laravel/Modules/Lang/docs/wiki/index|Lang Module]] — gestione traduzioni e locale

## Raw Sources Prioritari

- `docs/content-blocks-system.md` — schema JSON, BlockData, Filament Builder config
- `docs/folio-routing-locale.md` — FolioVoltServiceProvider, locale prefix, link rules
- `docs/business-logic-overview.md` — modelli core, business rules, testing strategy
- `docs/page-content-management.md` — gestione CRUD pagine
- `docs/homepage-management.md` — gestione homepage speciale
- `docs/folio-routing-system.md` — dettagli sistema routing
