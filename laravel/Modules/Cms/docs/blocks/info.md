# Info Block

Il blocco Info è utilizzato per visualizzare informazioni generali e branding, con supporto per logo, descrizione e copyright. Può essere utilizzato in qualsiasi contesto che richieda la presentazione di informazioni istituzionali.

## Struttura

```php
[
    'type' => 'info',
    'data' => [
        'title' => 'string',       // Titolo della sezione
        'description' => 'string', // Descrizione HTML
        'logo' => 'string',       // Percorso del logo
        'copyright' => 'string'   // Testo copyright
    ]
]
```

## Campi

| Campo | Tipo | Descrizione | Obbligatorio |
|-------|------|-------------|--------------|
| title | string | Titolo della sezione | Sì |
| description | string | Descrizione formattata in HTML | Sì |
| logo | string | Percorso dell'immagine del logo | Sì |
| copyright | string | Testo del copyright | Sì |

## Esempio di Utilizzo

```php
use Modules\Cms\Filament\Blocks\InfoBlock;

// In qualsiasi builder di contenuto
Builder::make('content')
    ->blocks([
        InfoBlock::make(),
    ])
```

## Contesti di Utilizzo

Il blocco può essere utilizzato in vari contesti:

1. **Footer**:
   - Informazioni aziendali
   - Copyright e disclaimer
   - Branding istituzionale

2. **About Us**:
   - Presentazione aziendale
   - Storia e valori
   - Mission statement

3. **Sidebar**:
   - Profilo organizzazione
   - Informazioni legali
   - Crediti e riconoscimenti

4. **Landing Page**:
   - Sezione istituzionale
   - Trust signals
   - Brand identity

## Best Practices

1. **Contenuto**:
   - Testo chiaro e conciso
   - Informazioni essenziali
   - Tono istituzionale

2. **Logo**:
   - Immagine ottimizzata
   - Dimensioni appropriate
   - Versioni per diversi contesti

3. **Layout**:
   - Gerarchia visiva
   - Spazio bianco
   - Allineamento preciso

4. **Branding**:
   - Coerenza visiva
   - Identità aziendale
   - Professionalità

## Implementazione

1. **Logo**:
   - Formati supportati
   - Responsive design
   - Retina ready

2. **Testo**:
   - Formattazione HTML
   - Tipografia coerente
   - Leggibilità

## SEO e Microdata

1. **Schema.org**:
   - Organization markup
   - Logo markup
   - Copyright markup

2. **Accessibilità**:
   - Alt text
   - ARIA labels
   - Semantic HTML

## Collegamenti

- [Documentazione Filament Forms](../filament-forms.md)
- [UI Components](../ui/components.md)
- [Branding Guidelines](../design/branding.md)
- [Legal Requirements](../legal/requirements.md) 
