# Header Block

## Panoramica
Il blocco header è un componente generico e riutilizzabile che può essere utilizzato per creare diverse tipologie di header. È progettato per essere flessibile e adattabile a diversi contesti e stili.

## Struttura

```php
namespace Modules\Cms\Filament\Blocks;

class HeaderBlock extends Block
{
    public function getSchema(): array
    {
        return [
            Select::make('type')
                ->options([
                    'simple' => 'Semplice',
                    'with_search' => 'Con Ricerca',
                    'with_mega_menu' => 'Con Mega Menu',
                    'centered' => 'Centrato',
                    'with_banner' => 'Con Banner',
                ])
                ->required()
                ->label('Tipo Header'),

            FileUpload::make('logo')
                ->image()
                ->directory('logos')
                ->label('Logo'),

            TextInput::make('logo_text')
                ->label('Testo Logo'),

            ColorPicker::make('background_color')
                ->default('#ffffff')
                ->label('Colore Sfondo'),

            ColorPicker::make('text_color')
                ->default('#000000')
                ->label('Colore Testo'),

            Repeater::make('navigation')
                ->schema([
                    TextInput::make('label')
                        ->required()
                        ->label('Etichetta'),
                    TextInput::make('url')
                        ->required()
                        ->label('URL'),
                    Select::make('type')
                        ->options([
                            'link' => 'Link',
                            'button' => 'Bottone',
                            'dropdown' => 'Menu a Tendina',
                        ])
                        ->required()
                        ->label('Tipo'),
                    Repeater::make('children')
                        ->schema([
                            TextInput::make('label')
                                ->required()
                                ->label('Etichetta'),
                            TextInput::make('url')
                                ->required()
                                ->label('URL'),
                        ])
                        ->visible(fn (Get $get) => $get('type') === 'dropdown')
                        ->collapsible()
                        ->label('Sottomenu'),
                ])
                ->collapsible()
                ->label('Navigazione'),

            Repeater::make('actions')
                ->schema([
                    TextInput::make('label')
                        ->required()
                        ->label('Etichetta'),
                    TextInput::make('url')
                        ->required()
                        ->label('URL'),
                    Select::make('style')
                        ->options([
                            'primary' => 'Primario',
                            'secondary' => 'Secondario',
                            'outline' => 'Outline',
                            'link' => 'Link',
                        ])
                        ->required()
                        ->label('Stile'),
                    Select::make('icon')
                        ->options([
                            'search' => 'Ricerca',
                            'user' => 'Utente',
                            'cart' => 'Carrello',
                            'menu' => 'Menu',
                        ])
                        ->label('Icona'),
                ])
                ->collapsible()
                ->label('Azioni'),

            Toggle::make('is_sticky')
                ->label('Header Fisso'),

            Toggle::make('show_search')
                ->label('Mostra Ricerca'),

            Toggle::make('show_language_switcher')
                ->label('Mostra Selettore Lingua'),
        ];
    }
}
```

## Varianti

### Header Semplice
```php
[
    'type' => 'simple',
    'logo' => '/storage/logos/logo.svg',
    'navigation' => [
        ['label' => 'Home', 'url' => '/', 'type' => 'link'],
        ['label' => 'Chi Siamo', 'url' => '/about', 'type' => 'link'],
        ['label' => 'Contatti', 'url' => '/contact', 'type' => 'button'],
    ],
]
```

### Header con Mega Menu
```php
[
    'type' => 'with_mega_menu',
    'logo' => '/storage/logos/logo.svg',
    'navigation' => [
        [
            'label' => 'Prodotti',
            'type' => 'dropdown',
            'children' => [
                ['label' => 'Categoria 1', 'url' => '/products/cat1'],
                ['label' => 'Categoria 2', 'url' => '/products/cat2'],
            ],
        ],
    ],
]
```

## Best Practices

1. **Responsive Design**
   - Header deve adattarsi a tutti i dispositivi
   - Menu mobile con hamburger
   - Logo responsive

2. **Performance**
   - Lazy loading per immagini
   - Ottimizzazione SVG
   - Caching appropriato

3. **Accessibilità**
   - ARIA labels per la navigazione
   - Focus visibile per la tastiera
   - Skip links per il contenuto

4. **SEO**
   - Struttura semantica
   - Link descrittivi
   - Markup schema.org

## Collegamenti

- [Documentazione Blocchi](content-blocks.md)
- [Gestione Navigazione](../navigation.md)
- [Best Practices UI](../../UI/docs/best-practices.md)
- [Accessibilità](../../UI/docs/accessibility.md) 
