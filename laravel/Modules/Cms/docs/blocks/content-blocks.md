# Blocchi di Contenuto

## Panoramica
I blocchi sono componenti riutilizzabili che permettono di costruire qualsiasi sezione di una pagina in modo modulare. Ogni blocco è progettato per essere indipendente dal contesto in cui viene utilizzato (header, content, footer, sidebar) e completamente personalizzabile.

## Principi di Design

1. **Indipendenza dal Contesto**
   - I blocchi non devono assumere una posizione specifica nella pagina
   - Lo stesso blocco può essere usato in header, content, footer o sidebar
   - La posizione è determinata da dove viene inserito, non dalla sua implementazione

2. **Riusabilità**
   - Ogni blocco deve essere generico e riutilizzabile
   - La personalizzazione avviene tramite configurazione
   - I blocchi non devono contenere logica specifica per un contesto

3. **Composabilità**
   - I blocchi possono essere combinati liberamente
   - L'ordine e la disposizione sono flessibili
   - La struttura della pagina è determinata dalla composizione dei blocchi

## Tipi di Blocchi

### Blocchi di Layout
```php
class NavigationBlock extends Block
{
    public function getSchema(): array
    {
        return [
            Repeater::make('items')
                ->schema([
                    TextInput::make('label')
                        ->required()
                        ->label('Etichetta'),
                    TextInput::make('url')
                        ->required()
                        ->label('URL'),
                    Select::make('target')
                        ->options([
                            '_self' => 'Stessa finestra',
                            '_blank' => 'Nuova finestra'
                        ])
                        ->label('Target')
                ])
                ->collapsible()
                ->label('Voci di menu')
        ];
    }
}
```

### Blocchi di Contenuto
```php
class RichTextBlock extends Block
{
    public function getSchema(): array
    {
        return [
            RichEditor::make('content')
                ->required()
                ->label('Contenuto'),
            Select::make('style')
                ->options([
                    'normal' => 'Normale',
                    'featured' => 'In evidenza',
                    'boxed' => 'Con bordo'
                ])
                ->label('Stile')
        ];
    }
}
```

### Blocchi Interattivi
```php
class ContactBlock extends Block
{
    public function getSchema(): array
    {
        return [
            TextInput::make('title')
                ->required()
                ->label('Titolo'),
            Textarea::make('description')
                ->label('Descrizione'),
            TextInput::make('email')
                ->email()
                ->required()
                ->label('Email'),
            TextInput::make('phone')
                ->tel()
                ->label('Telefono'),
            TextInput::make('address')
                ->label('Indirizzo')
        ];
    }
}
```

### Blocchi Social
```php
class SocialBlock extends Block
{
    public function getSchema(): array
    {
        return [
            TextInput::make('title')
                ->label('Titolo'),
            Repeater::make('links')
                ->schema([
                    Select::make('platform')
                        ->options([
                            'facebook' => 'Facebook',
                            'twitter' => 'Twitter',
                            'instagram' => 'Instagram',
                            'linkedin' => 'LinkedIn'
                        ])
                        ->required()
                        ->label('Piattaforma'),
                    TextInput::make('url')
                        ->url()
                        ->required()
                        ->label('URL'),
                    TextInput::make('icon')
                        ->label('Icona')
                ])
                ->collapsible()
                ->label('Link Social')
        ];
    }
}
```

## Utilizzo dei Blocchi

### In Header
```php
// resources/views/layouts/header.blade.php
<header>
    @foreach($header_blocks as $block)
        @include($block->view, ['data' => $block->data])
    @endforeach
</header>
```

### Nel Contenuto
```php
// resources/views/pages/show.blade.php
<main>
    @foreach($content_blocks as $block)
        @include($block->view, ['data' => $block->data])
    @endforeach
</main>
```

### In Footer
```php
// resources/views/layouts/footer.blade.php
<footer>
    @foreach($footer_blocks as $block)
        @include($block->view, ['data' => $block->data])
    @endforeach
</footer>
```

### In Sidebar
```php
// resources/views/layouts/sidebar.blade.php
<aside>
    @foreach($sidebar_blocks as $block)
        @include($block->view, ['data' => $block->data])
    @endforeach
</aside>
```

## Best Practices

1. **Design dei Blocchi**
   - Mantenere i blocchi generici e riutilizzabili
   - Evitare dipendenze dal contesto
   - Utilizzare configurazioni per personalizzare l'aspetto

2. **Organizzazione del Codice**
   - Un file per blocco
   - Separare logica e presentazione
   - Mantenere la coerenza nelle convenzioni di naming

3. **Performance**
   - Lazy loading delle risorse
   - Caching appropriato
   - Ottimizzazione delle immagini

4. **Accessibilità**
   - ARIA labels
   - Contrasto appropriato
   - Supporto tastiera

## Collegamenti

- [Documentazione Filament](../filament-resources.md)
- [Gestione Contenuti](../content-storage.md)
- [Best Practices UI](../../UI/docs/best-practices.md)
- [Documentazione Blocchi](../../Xot/docs/blocks.md) 
