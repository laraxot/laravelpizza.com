# NavigationBlock

## Introduzione
Il NavigationBlock è un componente Filament che permette di gestire la navigazione del sito attraverso l'interfaccia amministrativa. È progettato per essere flessibile, accessibile e completamente personalizzabile.

## Struttura

### Schema del Blocco
```php
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;

class NavigationBlock
{
    public static function make(string $context = 'form'): Block
    {
        return Block::make('navigation')
            ->label('Menu di Navigazione')
            ->schema([
                Repeater::make('items')
                    ->label('Voci del Menu')
                    ->schema([
                        TextInput::make('label')
                            ->label('Etichetta')
                            ->required(),
                        TextInput::make('url')
                            ->label('URL')
                            ->required(),
                        Select::make('target')
                            ->label('Target')
                            ->options([
                                '_self' => 'Stessa Finestra',
                                '_blank' => 'Nuova Finestra',
                            ])
                            ->default('_self'),
                        Toggle::make('is_active')
                            ->label('Attivo')
                            ->default(true),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['label'] ?? null),
            ]);
    }
}
```

### Output JSON
```json
{
    "type": "navigation",
    "data": {
        "items": [
            {
                "label": "Home",
                "url": "/",
                "target": "_self",
                "is_active": true
            },
            {
                "label": "Chi Siamo",
                "url": "/chi-siamo",
                "target": "_self",
                "is_active": true
            }
        ]
    }
}
```

## Componenti

### 1. Voci del Menu (`items`)
- **Etichetta**: Nome visualizzato
- **URL**: Link di destinazione
- **Target**: Apertura nella stessa finestra o nuova
- **Attivo**: Toggle per mostrare/nascondere

## Utilizzo

### 1. Creazione nel PageContent
```php
use Modules\Cms\Models\PageContent;

PageContent::create([
    'name' => 'Header',
    'slug' => 'main-header',
    'blocks' => [
        'type' => 'navigation',
        'data' => [
            // Configurazione
        ]
    ]
]);
```

### 2. Rendering
```php
// In una vista Blade
{!! $_theme->showPageContent('main-header') !!}
```

## Best Practices

### 1. Struttura Menu
- Massimo 7 voci nel menu principale
- Massimo 2 livelli di profondità
- Etichette chiare e concise
- URL SEO-friendly

### 2. Mobile
- Menu hamburger per dispositivi piccoli
- Breakpoint appropriato per il contenuto
- Touch target sufficientemente grandi
- Feedback visivo per le interazioni

### 3. Performance
- Ottimizzazione immagini logo
- Lazy loading appropriato
- Cache efficiente
- Minimizzazione DOM

## Accessibilità

### 1. Markup
- Struttura semantica
- ARIA labels appropriati
- Focus management
- Keyboard navigation

### 2. Visualizzazione
- Contrasto sufficiente
- Dimensioni testo leggibili
- Spaziatura adeguata
- Stati hover/focus visibili

## Personalizzazione

### 1. Stili
```css
/* Esempio di personalizzazione */
.navigation-block {
    --primary-color: theme('colors.primary.600');
    --text-color: theme('colors.gray.900');
}
```

### 2. Comportamento
```js
// Esempio di personalizzazione JavaScript
Alpine.data('navigation', () => ({
    // Configurazione custom
}))
```

## Links
- [Documentazione Filament Forms](../../../docs/filament-forms.md)
- [Gestione Contenuti](../../../docs/content-management.md)
- [Best Practices UI](../../../docs/ui-best-practices.md)
- [Sistema di Blocchi (root)](../../../docs/blocks-system.md)
- [Collegamenti alla documentazione principale](../../../docs/collegamenti-documentazione.md)

## Note
- La configurazione è salvata in JSON per versionamento
- Supporto multilingua integrato
- Cache automatica dei contenuti
- Backup incluso nel versionamento 
