# Homepage Architecture & Management

## Architettura Homepage

### Filament Builder Blocks System
La homepage utilizza il sistema **Filament Builder Blocks** per gestione dinamica contenuti:

```php
// Homepage Blade Template
/Themes/One/resources/views/pages/index.blade.php

<x-layouts.marketing>
    <div>
        <x-page side="content" slug="home" :type="auth()->user()?->type?->value" />
    </div>
</x-layouts.marketing>
```

```json
// Homepage JSON Content  
/config/local/<directory progetto>/database/content/pages/home.json

{
    "type": "landing-page",
    "data": {
        "view": "pub_theme::components.blocks.hero.landing-page",
        "title": "<slogan> per Gestanti",
        "subtitle": "Programma di prevenzione e cura",
        "cta_text": "INIZIA ORA",
        "cta_link": "{{ route('register') }}"
    }
}
```

### Flusso di Rendering
1. **Folio Route** → `/Themes/One/resources/views/pages/index.blade.php`
2. **Page Component** → `<x-page slug="home">`
3. **JSON Loading** → `/config/local/<directory progetto>/database/content/pages/home.json`
4. **Blocks Rendering** → `Modules\UI\View\Components\Render\Blocks`
5. **View Resolution** → Template Blade specifico del blocco

## Tipi di Blocchi Disponibili

### Hero Block
```json
{
    "type": "hero",
    "data": {
        "view": "ui::components.blocks.hero.simple",
        "title": "Benvenuta su <slogan>",
        "subtitle": "Programma di prevenzione",
        "image": "/img/hero-bg.jpg",
        "cta_text": "INIZIA ORA",
        "cta_link": "{{ route('register') }}"
    }
}
```

### Feature Sections
```json
{
    "type": "feature_sections",
    "data": {
        "view": "ui::components.blocks.features.grid",
        "title": "Perché Scegliere il Nostro Programma",
        "features": [
            {
                "title": "Prevenzione",
                "description": "Controlli preventivi gratuiti",
                "icon": "health"
            }
        ]
    }
}
```

### Stats Block
```json
{
    "type": "stats",
    "data": {
        "view": "ui::components.blocks.stats.simple",
        "stats": [
            {"label": "Gestanti seguite", "value": "1000+"},
            {"label": "Centri attivi", "value": "50+"}
        ]
    }
}
```

## Gestione Contenuti

### Modifica JSON via Backend
- Accesso via Filament admin panel
- Interfaccia Builder per aggiungere/modificare blocchi
- Preview real-time delle modifiche

### Struttura Multilingua
```json
{
    "content_blocks": {
        "it": [
            {"type": "hero", "data": {...}},
            {"type": "features", "data": {...}}
        ],
        "en": [
            {"type": "hero", "data": {...}},
            {"type": "features", "data": {...}}
        ]
    }
}
```

### Pattern di Personalizzazione
1. **Content-only**: Modificare solo i dati JSON
2. **Template**: Creare nuove viste Blade per blocchi
3. **Blocks**: Creare nuovi tipi di blocchi custom

## Testing Strategy

### Modulo CMS Tests
- Test rendering blocchi
- Test caricamento JSON
- Test PageContentBuilder

### Modulo <main module> Tests  
- Test integrazione frontend
- Test logica business specifica
- Test tipi utente (patient, doctor, admin)

### Test Example
```php
// tests/Feature/HomepageTest.php
test('homepage renders with hero block', function () {
    $response = $this->get('/');
    
    $response->assertOk()
        ->assertSee('<slogan> per Gestanti')
        ->assertSee('INIZIA ORA');
});
```

## Best Practices

### Sviluppo Blocchi
- Nome classe: `[Nome]Block.php` (es. `HeroBlock.php`)
- Vista: `[modulo]::components.blocks.[tipo].[versione]`
- Estendere `XotBaseBlock` per consistenza

### JSON Management
- Sempre array per lingua: `"it": []`
- Campo `type` obbligatorio
- Campo `data.view` per template specifico
- Supporto Laravel Blade syntax: `{{ route() }}`

### Regole Importanti
- **NEVER** modificare JSON in produzione direttamente
- **ALWAYS** usare backend Filament per contenuti
- **ALWAYS** supportare multilingua
- **NEVER** hardcodare contenuti nelle Blade