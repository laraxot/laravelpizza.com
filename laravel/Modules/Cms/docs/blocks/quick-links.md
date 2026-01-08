# Quick Links Block

Il blocco Quick Links è utilizzato per creare gruppi di link rapidi, con supporto per target personalizzati. Può essere utilizzato in qualsiasi contesto, come footer, sidebar, o sezioni di navigazione.

## Struttura

```php
[
    'type' => 'quick_links',
    'data' => [
        'title' => 'string',    // Titolo della sezione
        'links' => [            // Array di link
            [
                'label' => 'string', // Testo del link
                'url' => 'string',   // URL di destinazione
                'target' => 'string' // Target del link (_self/_blank)
            ],
            // ... altri link
        ]
    ]
]
```

## Campi

| Campo | Tipo | Descrizione | Obbligatorio | Default |
|-------|------|-------------|--------------|---------|
| title | string | Titolo della sezione | Sì | - |
| links | array | Array di link | Sì | [] |
| links.*.label | string | Testo del link | Sì | - |
| links.*.url | string | URL di destinazione | Sì | - |
| links.*.target | string | Target del link | No | _self |

## Esempio di Utilizzo

```php
use Modules\Cms\Filament\Blocks\QuickLinksBlock;

// In qualsiasi builder di contenuto
Builder::make('content')
    ->blocks([
        QuickLinksBlock::make(),
    ])
```

## Contesti di Utilizzo

Il blocco può essere utilizzato in vari contesti:

1. **Footer**:
   - Link utili
   - Risorse rapide
   - Collegamenti importanti

2. **Sidebar**:
   - Menu contestuale
   - Link correlati
   - Navigazione secondaria

3. **Header**:
   - Menu utility
   - Link di servizio
   - Accessi rapidi

4. **Contenuto**:
   - Collegamenti tematici
   - Risorse correlate
   - Call-to-action multiple

## Best Practices

1. **Organizzazione**:
   - Raggruppare link correlati
   - Limitare il numero di link (5-7 max)
   - Mantenere una gerarchia chiara

2. **Etichette**:
   - Testi brevi e descrittivi
   - Verbi d'azione quando appropriato
   - Evitare termini generici

3. **URL**:
   - Verificare i link regolarmente
   - Utilizzare URL assoluti per link esterni
   - Considerare il target appropriato

4. **Accessibilità**:
   - Contrasto sufficiente
   - Focus visibile
   - Markup semantico

## Funzionalità

1. **Gestione Link**:
   - Interfaccia collassabile
   - Ordinamento flessibile
   - Target personalizzabile

2. **Presentazione**:
   - Layout responsive
   - Stili contestuali
   - Stati interattivi

## SEO

1. **Link**:
   - Anchor text descrittivi
   - URL semantici
   - Relazioni appropriate

2. **Struttura**:
   - Markup HTML valido
   - Gerarchia logica
   - Navigazione chiara

## Collegamenti

- [Documentazione Filament Forms](../filament-forms.md)
- [UI Components](../ui/components.md)
- [Best Practices Navigation](../ui/navigation-guidelines.md)
- [Accessibilità](../ui/accessibility.md) 
