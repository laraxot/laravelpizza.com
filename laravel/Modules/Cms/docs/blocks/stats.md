# Stats Block

Il blocco Stats è utilizzato per visualizzare statistiche e metriche chiave in una griglia di numeri con etichette.

## Struttura

```php
[
    'type' => 'stats',
    'data' => [
        'title' => 'string',    // Titolo della sezione
        'stats' => [            // Array di statistiche
            [
                'number' => 'string', // Valore numerico
                'label' => 'string',  // Etichetta descrittiva
            ],
            // ... altre statistiche
        ]
    ]
]
```

## Campi

| Campo | Tipo | Descrizione | Obbligatorio |
|-------|------|-------------|--------------|
| title | string | Titolo della sezione | Sì |
| stats | array | Array di statistiche | Sì |
| stats.*.number | string | Valore numerico della statistica | Sì |
| stats.*.label | string | Etichetta descrittiva della statistica | Sì |

## Esempio di Utilizzo

```php
use Modules\Cms\Filament\Blocks\StatsBlock;

// In un form Filament
Builder::make('content')
    ->blocks([
        StatsBlock::make(),
    ])
```

## Best Practices

1. **Numeri**:
   - Utilizzare formati leggibili (es. "1K" invece di "1000")
   - Mantenere la coerenza nel formato dei numeri
   - Utilizzare il simbolo "+" per indicare "più di" (es. "1000+")

2. **Etichette**:
   - Mantenere etichette brevi e chiare
   - Utilizzare termini facilmente comprensibili
   - Evitare abbreviazioni ambigue

3. **Layout**:
   - Utilizzare 3-6 statistiche per riga
   - Organizzare le statistiche in ordine di importanza
   - Mantenere un bilanciamento visivo

4. **Presentazione**:
   - Utilizzare numeri significativi
   - Evitare statistiche ridondanti
   - Aggiornare regolarmente i dati

## Limitazioni

- Massimo 6 statistiche per blocco
- Layout a griglia fissa (3 colonne)
- Non supporta descrizioni estese

## Collegamenti

- [Documentazione Filament Forms](../filament-forms.md)
- [Gestione Contenuti](../content.md)
- [UI Components](../ui/components.md)
- [Data Visualization](../ui/data-visualization.md) 
