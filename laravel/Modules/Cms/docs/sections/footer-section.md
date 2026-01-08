# Footer Section

## Struttura

### 1. Blade Template
```blade
{{-- Themes/One/resources/views/components/sections/footer.blade.php --}}
<footer {{ $attributes->merge(['class' => 'bg-gray-900 text-white']) }}>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @foreach($blocks as $block)
            <x-dynamic-component
                :component="'cms::blocks.' . $block->type"
                :data="$block->data"
            />
        @endforeach
    </div>
</footer>
```

### 2. JSON Configuration
```json
{
    "name": {
        "it": "Footer Principale",
        "en": "Main Footer"
    },
    "slug": "footer",
    "blocks": [
        {
            "type": "hero",
            "data": {
                // Hero block data
            }
        },
        {
            "type": "newsletter",
            "data": {
                // Newsletter block data
            }
        }
    ]
}
```

## Blocchi Dinamici

Il footer ora utilizza blocchi dinamici, che possono essere configurati dall'amministratore.

### Selezionare Blocchi in Admin
```php
// SectionResource.php
'footer' => Forms\Components\Section::make('Footer')
    ->schema([
        SectionBuilder::make('footer')->context('footer')->columnSpanFull(),
    ]),
```

## Implementazione Filament

### Blocks Directory
```
Cms/app/Filament/Blocks/Footer/
├── HeroBlock.php
├── NewsletterBlock.php
└── ...
```

### Block Schema Example
```php
class HeroBlock extends Block
{
    public static function getBlockSchema(): array
    {
        return [
            'title' => TextInput::make('title')
                ->translateLabel()
                ->required(),
            'subtitle' => TextInput::make('subtitle')
                ->translateLabel()
                ->required(),
        ];
    }
}
```

## Best Practices

### 1. Accessibilità
- Struttura semantica
- ARIA landmarks
- Skip links
- Focus management

### 2. Responsive Design
- Grid system flessibile
- Breakpoints consistenti
- Mobile-first approach
- Stack appropriato

### 3. Performance
- Lazy loading immagini
- Ottimizzazione assets
- Minificazione CSS/JS
- Cache efficiente

### 4. SEO
- Schema.org markup
- Links descrittivi
- Sitemap inclusion
- Metadata appropriati

## Gestione Blocchi
Il footer è una sezione **generica** che consente di inserire e ordinare **qualsiasi** blocco disponibile nel sistema tramite `PageContentBuilder`.

Per dettagli su configurazione e template, consulta: [Documentazione Sezione Footer](../sections/footer-section.md)

## Collegamenti
- [Gestione Blocchi](../blocks/README.md)
- [Componenti UI](../components/README.md)
- [Documentazione Root](../../../../docs/sections.md) 
