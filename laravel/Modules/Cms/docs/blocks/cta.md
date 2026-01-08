# CTA Block

Il blocco CTA (Call-to-Action) è utilizzato per creare sezioni di chiamata all'azione che guidano l'utente verso una specifica azione.

## Struttura

```php
[
    'type' => 'cta',
    'data' => [
        'title' => 'string',        // Titolo della CTA
        'description' => 'string',  // Descrizione della CTA
        'button_text' => 'string',  // Testo del pulsante
        'button_link' => 'string',  // URL di destinazione
    ]
]
```

## Campi

| Campo | Tipo | Descrizione | Obbligatorio |
|-------|------|-------------|--------------|
| title | string | Titolo della chiamata all'azione | Sì |
| description | string | Testo descrittivo che spiega l'azione | Sì |
| button_text | string | Testo visualizzato sul pulsante | Sì |
| button_link | string | URL di destinazione del pulsante | Sì |

## Esempio di Utilizzo

```php
use Modules\Cms\Filament\Blocks\CtaBlock;

// In un form Filament
Builder::make('content')
    ->blocks([
        CtaBlock::make(),
    ])
```

## Best Practices

1. **Titoli**:
   - Utilizzare verbi d'azione
   - Mantenere titoli concisi (max 50 caratteri)
   - Comunicare il valore per l'utente

2. **Descrizioni**:
   - Spiegare chiaramente il beneficio
   - Mantenere un tono persuasivo ma non aggressivo
   - Utilizzare un linguaggio diretto

3. **Pulsanti**:
   - Testo chiaro e orientato all'azione
   - Massimo 20-25 caratteri
   - Utilizzare verbi imperativi

4. **Link**:
   - Utilizzare URL assoluti
   - Verificare la validità dei link
   - Considerare il tracking UTM

## Posizionamento

Il blocco CTA può essere utilizzato in diverse posizioni:
- Fine della pagina
- Dopo una sezione di contenuto importante
- In una sidebar
- Come interruzione naturale del contenuto

## Best Practices UX

1. **Visibilità**:
   - Mantenere il CTA visibile e accessibile
   - Utilizzare colori contrastanti
   - Assicurare spazio bianco sufficiente

2. **Responsività**:
   - Adattare il layout su dispositivi mobili
   - Mantenere i pulsanti facilmente toccabili
   - Ottimizzare la leggibilità del testo

3. **Performance**:
   - Evitare redirect non necessari
   - Ottimizzare il tempo di caricamento
   - Monitorare il tasso di conversione

## Collegamenti

- [Documentazione Filament Forms](../filament-forms.md)
- [Gestione Contenuti](../content.md)
- [UI Components](../ui/components.md)
- [Best Practices UX](../ui/ux-guidelines.md) 
