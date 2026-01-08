# Feature Sections Block

Il blocco Feature Sections è utilizzato per presentare le caratteristiche principali di un servizio o prodotto in una griglia di sezioni con icone.

## Struttura

```php
[
    'type' => 'feature_sections',
    'data' => [
        'title' => 'string',      // Titolo della sezione
        'sections' => [           // Array di sezioni
            [
                'title' => 'string',       // Titolo della feature
                'description' => 'string', // Descrizione della feature
                'icon' => 'string',       // Nome dell'icona Heroicon
            ],
            // ... altre sezioni
        ]
    ]
]
```

## Campi

| Campo | Tipo | Descrizione | Obbligatorio |
|-------|------|-------------|--------------|
| title | string | Titolo principale della sezione | Sì |
| sections | array | Array di sezioni caratteristiche | Sì |
| sections.*.title | string | Titolo della singola feature | Sì |
| sections.*.description | string | Descrizione della feature | Sì |
| sections.*.icon | string | Nome dell'icona Heroicon | Sì |

## Icone Disponibili

Il componente utilizza le icone di Heroicons in stile outline:

- `heroicon-o-shield-check`: Scudo
- `heroicon-o-heart`: Cuore
- `heroicon-o-hand-raised`: Mano
- `heroicon-o-star`: Stella
- `heroicon-o-lightbulb`: Lampadina
- `heroicon-o-academic-cap`: Laurea
- `heroicon-o-clock`: Orologio
- `heroicon-o-chart-bar`: Grafico
- `heroicon-o-cog`: Ingranaggio
- `heroicon-o-users`: Utenti

## Esempio di Utilizzo

```php
use Modules\Cms\Filament\Blocks\FeatureSectionsBlock;

// In un form Filament
Builder::make('content')
    ->blocks([
        FeatureSectionsBlock::make(),
    ])
```

## Best Practices

1. **Contenuto**:
   - Titoli concisi (max 30 caratteri)
   - Descrizioni chiare e brevi (max 120 caratteri)
   - Utilizzare icone pertinenti al contenuto

2. **Layout**:
   - Mantenere un numero pari di sezioni (3, 6 o 9)
   - Bilanciare la lunghezza dei contenuti tra le sezioni
   - Mantenere una coerenza visiva nelle icone

3. **UX**:
   - Organizzare le feature in ordine di importanza
   - Utilizzare un linguaggio chiaro e diretto
   - Mantenere una coerenza nel tono comunicativo

## Collegamenti

- [Documentazione Filament Forms](../filament-forms.md)
- [Gestione Contenuti](../content.md)
- [UI Components](../ui/components.md)
- [Heroicons](https://heroicons.com/) 
