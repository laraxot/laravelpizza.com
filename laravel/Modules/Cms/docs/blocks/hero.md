# Hero Block

Il blocco Hero è un componente di primo impatto utilizzato tipicamente nella parte superiore delle pagine per catturare l'attenzione dell'utente.

## Struttura

```php
[
    'type' => 'hero',
    'data' => [
        'title' => 'string',         // Titolo principale
        'subtitle' => 'string',      // Sottotitolo o descrizione
        'image' => 'string',         // Percorso dell'immagine di sfondo
        'cta_text' => 'string',      // Testo del pulsante Call-to-Action
        'cta_link' => 'string',      // Link del pulsante
        'background_color' => 'string', // Colore di sfondo (hex)
        'text_color' => 'string',    // Colore del testo (hex)
        'cta_color' => 'string',     // Colore del pulsante (hex)
    ]
]
```

## Campi

| Campo | Tipo | Descrizione | Obbligatorio |
|-------|------|-------------|--------------|
| title | string | Titolo principale del blocco | Sì |
| subtitle | string | Testo descrittivo o sottotitolo | Sì |
| image | string | URL o percorso dell'immagine di sfondo | Sì |
| cta_text | string | Testo del pulsante di chiamata all'azione | Sì |
| cta_link | string | URL di destinazione del pulsante | Sì |
| background_color | string | Colore di sfondo in formato hex | No |
| text_color | string | Colore del testo in formato hex | No |
| cta_color | string | Colore del pulsante in formato hex | No |

## Esempio di Utilizzo

```php
use Modules\Cms\Filament\Blocks\HeroBlock;

// In un form Filament
Builder::make('content')
    ->blocks([
        HeroBlock::make(),
    ])
```

## Best Practices

1. **Immagini**:
   - Utilizzare immagini ottimizzate per il web
   - Dimensioni consigliate: 1920x1080px
   - Formato: JPG o WebP per foto, PNG per grafiche

2. **Testi**:
   - Titolo: max 60 caratteri
   - Sottotitolo: max 160 caratteri
   - CTA: max 20 caratteri

3. **Contrasto**:
   - Assicurarsi che il testo sia leggibile sull'immagine di sfondo
   - Utilizzare colori che rispettino le linee guida WCAG per l'accessibilità

## Collegamenti

- [Documentazione Filament Forms](../filament-forms.md)
- [Gestione Contenuti](../content.md)
- [Best Practices UI](../ui/best-practices.md)
- [Accessibilità](../ui/accessibility.md) 
