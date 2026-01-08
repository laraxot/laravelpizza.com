# Actions Block

Il blocco Actions è utilizzato per creare gruppi di pulsanti o link di azione, con supporto per diversi stili e tipi di pulsanti.

## Struttura

```php
[
    'type' => 'actions',
    'data' => [
        'items' => [           // Array di azioni
            [
                'label' => 'string',  // Testo del pulsante
                'url' => 'string',    // URL di destinazione
                'type' => 'string',   // Tipo di pulsante (primary/secondary/outline/link)
            ],
            // ... altre azioni
        ]
    ]
]
```

## Campi

| Campo | Tipo | Descrizione | Obbligatorio |
|-------|------|-------------|--------------|
| items | array | Array di azioni | Sì |
| items.*.label | string | Testo visualizzato sul pulsante | Sì |
| items.*.url | string | URL di destinazione | Sì |
| items.*.type | string | Stile del pulsante | Sì |

## Tipi di Pulsanti

Il blocco supporta quattro tipi di pulsanti:

- `primary`: Pulsante principale con sfondo colorato
- `secondary`: Pulsante secondario con stile meno prominente
- `outline`: Pulsante con bordo e sfondo trasparente
- `link`: Link testuale senza sfondo

## Esempio di Utilizzo

```php
use Modules\Cms\Filament\Blocks\ActionsBlock;

// In un form Filament
Builder::make('content')
    ->blocks([
        ActionsBlock::make(),
    ])
```

## Best Practices

1. **Layout**:
   - Limitare il numero di azioni (max 3-4 per gruppo)
   - Organizzare le azioni in ordine di importanza
   - Mantenere una gerarchia visiva chiara

2. **Etichette**:
   - Utilizzare verbi d'azione
   - Mantenere etichette brevi e chiare
   - Evitare termini generici come "Clicca qui"

3. **Tipi**:
   - Usare `primary` per l'azione principale
   - Usare `secondary` per azioni alternative
   - Usare `outline` per azioni meno importanti
   - Usare `link` per azioni contestuali

4. **Accessibilità**:
   - Assicurare contrasto sufficiente
   - Fornire feedback visivo all'hover
   - Mantenere dimensioni minime per il touch

## Funzionalità

- Riordinamento delle azioni
- Collassamento degli elementi
- Clonazione di azioni esistenti
- Configurazione predefinita

## Collegamenti

- [Documentazione Filament Forms](../filament-forms.md)
- [UI Components](../ui/components.md)
- [Best Practices UX](../ui/ux-guidelines.md)
- [Accessibilità](../ui/accessibility.md) 
