# Paragraph Block

Il blocco Paragraph è un componente per la gestione di contenuti testuali formattati con un editor rich-text.

## Struttura

```php
[
    'type' => 'paragraph',
    'data' => [
        'content' => 'string', // Contenuto HTML formattato
    ]
]
```

## Campi

| Campo | Tipo | Descrizione | Obbligatorio |
|-------|------|-------------|--------------|
| content | string | Contenuto HTML con formattazione rich-text | Sì |

## Funzionalità Editor

L'editor rich-text include le seguenti funzionalità:

- Formattazione base (grassetto, corsivo, sottolineato, barrato)
- Link
- Liste ordinate e non ordinate
- Titoli (H2, H3, H4)
- Citazioni (blockquote)
- Annulla/Ripeti

## Esempio di Utilizzo

```php
use Modules\Cms\Filament\Blocks\ParagraphBlock;

// In un form Filament
Builder::make('content')
    ->blocks([
        ParagraphBlock::make(),
    ])
```

## Best Practices

1. **Struttura del Contenuto**:
   - Utilizzare i titoli in modo gerarchico (H2 > H3 > H4)
   - Mantenere paragrafi brevi e leggibili
   - Utilizzare liste per contenuti strutturati

2. **Formattazione**:
   - Non abusare del grassetto e del corsivo
   - Utilizzare le citazioni per evidenziare contenuti importanti
   - Mantenere una formattazione coerente

3. **Link**:
   - Utilizzare testi descrittivi per i link
   - Evitare "clicca qui" o testi generici
   - Verificare che i link siano funzionanti

4. **SEO e Accessibilità**:
   - Strutturare il contenuto in modo semantico
   - Utilizzare titoli descrittivi
   - Mantenere una gerarchia logica dei contenuti

## Collegamenti

- [Documentazione Filament Forms](../filament-forms.md)
- [Gestione Contenuti](../content.md)
- [Best Practices SEO](../best-practices/seo.md)
- [Accessibilità](../ui/accessibility.md) 
