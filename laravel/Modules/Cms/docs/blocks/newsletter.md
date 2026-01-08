# Newsletter Block

Il blocco Newsletter è utilizzato per creare form di iscrizione alla newsletter, con supporto per messaggi personalizzati e feedback utente. Può essere utilizzato in qualsiasi contesto, dal footer a sezioni dedicate della pagina.

## Struttura

```php
[
    'type' => 'newsletter',
    'data' => [
        'title' => 'string',           // Titolo della sezione
        'description' => 'string',     // Descrizione o testo promozionale
        'button_text' => 'string',     // Testo del pulsante
        'placeholder' => 'string',     // Placeholder del campo email
        'success_message' => 'string', // Messaggio di successo
        'error_message' => 'string'    // Messaggio di errore
    ]
]
```

## Campi

| Campo | Tipo | Descrizione | Obbligatorio |
|-------|------|-------------|--------------|
| title | string | Titolo della sezione | Sì |
| description | string | Testo descrittivo | Sì |
| button_text | string | Testo del pulsante | Sì |
| placeholder | string | Placeholder del campo email | Sì |
| success_message | string | Messaggio di successo | Sì |
| error_message | string | Messaggio di errore | Sì |

## Esempio di Utilizzo

```php
use Modules\Cms\Filament\Blocks\NewsletterBlock;

// In qualsiasi builder di contenuto
Builder::make('content')
    ->blocks([
        NewsletterBlock::make(),
    ])
```

## Contesti di Utilizzo

Il blocco può essere utilizzato in vari contesti:

1. **Footer**:
   - Form di iscrizione standard
   - Integrazione con altri contenuti
   - Versione compatta

2. **Sidebar**:
   - Form contestuale
   - Promozione mirata
   - Widget informativo

3. **Fine Articolo**:
   - Call-to-action post contenuto
   - Engagement dei lettori
   - Conversione contestuale

4. **Landing Page**:
   - Form principale
   - Lead generation
   - Conversione primaria

## Best Practices

1. **Contenuto**:
   - Value proposition chiara
   - Benefici evidenti
   - Call-to-action efficace

2. **UX**:
   - Form semplice
   - Feedback immediato
   - Errori chiari

3. **Design**:
   - Layout pulito
   - Contrasto appropriato
   - Spazio bianco sufficiente

4. **Conversione**:
   - A/B testing
   - Analytics integrati
   - Ottimizzazione continua

## GDPR Compliance

1. **Consenso**:
   - Opt-in esplicito
   - Privacy policy
   - Gestione dati

2. **Trasparenza**:
   - Scopo chiaro
   - Frequenza comunicazioni
   - Diritti utente

## Integrazione

1. **Email Marketing**:
   - Provider supportati
   - API integration
   - Automazioni

2. **Analytics**:
   - Tracking conversioni
   - Metriche chiave
   - Report personalizzati

## Collegamenti

- [Documentazione Filament Forms](../filament-forms.md)
- [UI Components](../ui/components.md)
- [Marketing Guidelines](../marketing/email-guidelines.md)
- [GDPR Compliance](../legal/gdpr.md) 
