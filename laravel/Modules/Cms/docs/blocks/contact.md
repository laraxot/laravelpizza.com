# Contact Block

Il blocco Contact è utilizzato per visualizzare informazioni di contatto, con supporto per mappa e vari canali di comunicazione. Può essere utilizzato in qualsiasi contesto che richieda la presentazione di dettagli di contatto.

## Struttura

```php
[
    'type' => 'contact',
    'data' => [
        'title' => 'string',       // Titolo della sezione
        'description' => 'string', // Descrizione o testo introduttivo
        'email' => 'string',      // Indirizzo email
        'phone' => 'string',      // Numero di telefono
        'address' => 'string',    // Indirizzo fisico
        'map_url' => 'string'     // URL della mappa (opzionale)
    ]
]
```

## Campi

| Campo | Tipo | Descrizione | Obbligatorio |
|-------|------|-------------|--------------|
| title | string | Titolo della sezione | Sì |
| description | string | Testo descrittivo | Sì |
| email | string | Email di contatto | Sì |
| phone | string | Numero di telefono | Sì |
| address | string | Indirizzo completo | Sì |
| map_url | string | Link alla mappa | No |

## Esempio di Utilizzo

```php
use Modules\Cms\Filament\Blocks\ContactBlock;

// In qualsiasi builder di contenuto
Builder::make('content')
    ->blocks([
        ContactBlock::make(),
    ])
```

## Contesti di Utilizzo

Il blocco può essere utilizzato in vari contesti:

1. **Pagina Contatti**:
   - Sezione principale
   - Informazioni complete
   - Mappa interattiva

2. **Footer**:
   - Contatti essenziali
   - Versione compatta
   - Quick reference

3. **Sidebar**:
   - Widget di contatto
   - Supporto clienti
   - Call center

4. **Location Page**:
   - Dettagli sede
   - Come raggiungerci
   - Orari e disponibilità

## Best Practices

1. **Contenuto**:
   - Informazioni aggiornate
   - Formato coerente
   - Priorità visiva

2. **Presentazione**:
   - Layout chiaro
   - Icone intuitive
   - Spacing appropriato

3. **Interazione**:
   - Link cliccabili
   - Tel: protocol
   - Mailto: protocol

4. **Accessibilità**:
   - Markup semantico
   - ARIA labels
   - Focus states

## Implementazione

1. **Validazione**:
   - Email valida
   - Telefono formattato
   - Indirizzo verificabile

2. **Mappa**:
   - Provider supportati
   - Responsive embed
   - Performance ottimizzata

## SEO e Microdata

1. **Schema.org**:
   - LocalBusiness markup
   - PostalAddress
   - ContactPoint

2. **NAP Consistency**:
   - Nome
   - Indirizzo
   - Telefono

## Collegamenti

- [Documentazione Filament Forms](../filament-forms.md)
- [UI Components](../ui/components.md)
- [Maps Integration](../integrations/maps.md)
- [Schema.org Guidelines](../seo/schema-org.md) 
