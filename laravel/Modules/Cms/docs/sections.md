# Sezioni 

## Indice
1. [Introduzione](#introduzione)
2. [Struttura delle Sezioni](#struttura-delle-sezioni)
3. [Gestione dei Contenuti](#gestione-dei-contenuti)
4. [Integrazione con i Blocchi](#integrazione-con-i-blocchi)
5. [Best Practices](#best-practices)

## Introduzione

Le sezioni sono i contenitori principali per i blocchi di contenuto . Ogni sezione rappresenta un'area specifica della pagina e può contenere uno o più blocchi.

## Struttura delle Sezioni

### Configurazione JSON
Le sezioni sono definite in file JSON nella directory `/laravel/config/local/<nome progetto>/database/content/sections/`. Ogni sezione ha questa struttura:

```json
{
    "id": "1",
    "name": "Nome Sezione",
    "slug": "slug-sezione",
    "blocks": {
        "it": [
            // Array di blocchi
        ]
    },
    "attributes": {
        "class": "classi-css",
        "id": "id-sezione",
        "style": {
            // Stili specifici
        }
    },
    "created_at": "timestamp",
    "updated_at": "timestamp",
    "created_by": "user-id",
    "updated_by": "user-id"
}
```

### Componenti Blade
Le sezioni sono renderizzate usando componenti Blade in `/laravel/Themes/One/resources/views/components/sections/`:

```blade
<!-- /components/sections/header.blade.php -->
<section {{ $attributes }}>
    @foreach($blocks as $block)
        <x-dynamic-component 
            :component="'blocks.'.$block['type']"
            :data="$block['data']"
        />
    @endforeach
</section>
```

## Gestione dei Contenuti

### Localizzazione
- Ogni sezione supporta più lingue
- I blocchi sono organizzati per lingua
- Le traduzioni sono gestite nei file JSON

### Stili e Attributi
- Classi CSS personalizzabili
- ID univoci per targeting
- Stili inline per personalizzazioni specifiche

## Integrazione con i Blocchi

### Esempio di Sezione Header
```json
{
    "id": "1",
    "name": "Header Principale",
    "blocks": {
        "it": [
            {
                "name": "Logo",
                "type": "logo",
                "data": {
                    "view": "pub_theme::components.blocks.logo",
                    "src": "patient::images/logo.svg"
                }
            },
            {
                "name": "Menu di Navigazione",
                "type": "navigation",
                "data": {
                    "view": "pub_theme::components.blocks.navigation",
                    "items": [
                        {
                            "label": "Home",
                            "url": "/"
                        }
                    ]
                }
            }
        ]
    },
    "attributes": {
        "class": "sticky top-0 z-50 bg-white",
        "id": "main-header"
    }
}
```

## Best Practices

### 1. Struttura delle Sezioni
- Mantenere le sezioni modulari
- Documentare tutti gli attributi
- Supportare la localizzazione

### 2. Performance
- Lazy loading per sezioni pesanti
- Caching dei contenuti statici
- Ottimizzazione delle risorse

### 3. Accessibilità
- Struttura semantica HTML
- Attributi ARIA appropriati
- Supporto per screen reader

### 4. Responsive Design
- Layout fluido
- Breakpoint consistenti
- Test su diversi dispositivi

## Collegamenti
- [Blocchi di Contenuto](./blocks.md)
- [Flusso Frontoffice](./frontoffice-flow.md)
- [Layout e Componenti](./struttura-layout-componenti-blade-<nome progetto>.md)
