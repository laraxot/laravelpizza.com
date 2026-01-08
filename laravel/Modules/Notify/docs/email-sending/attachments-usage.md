# Utilizzo Corretto degli Allegati nelle Email Spatie

Questa documentazione descrive come utilizzare correttamente il metodo `addAttachments()` nella classe `SpatieEmail` del modulo Notify.

## Formato degli Allegati

Il metodo `addAttachments()` accetta un array di array, dove ogni array interno rappresenta un singolo allegato con le relative proprietà.

### Formato Corretto

```php
// Formato corretto - un array di array di allegati
$attachments = [
    [
        'path' => '/var/www/html/_bases/base_techplanner_fila3_mono/public_html/images/avatars/default-3.svg',
        'path' => '/var/www/html/saluteora/public_html/images/avatars/default-3.svg',
        'path' => '/var/www/html/_bases/base_techplanner_fila3_mono/public_html/images/avatars/default-3.svg',
        'as' => 'logo.svg',  // Opzionale: nome del file da mostrare nell'email
        'mime' => 'image/svg+xml',  // Opzionale: MIME type del file
    ],
    // Eventualmente altri allegati...
    [
        'path' => '/var/www/html/_bases/base_techplanner_fila3_mono/public_html/documents/terms.pdf',
        'path' => '/var/www/html/saluteora/public_html/documents/terms.pdf',
        'path' => '/var/www/html/_bases/base_techplanner_fila3_mono/public_html/documents/terms.pdf',
        'as' => 'termini.pdf',
        'mime' => 'application/pdf',
    ],
];
```

## Implementazione nella Classe SpatieEmail

La classe `SpatieEmail` utilizza la classe `Illuminate\Mail\Mailables\Attachment` di Laravel per gestire gli allegati in modo robusto:

```php
/**
 * Add attachments to the email
 *
 * @param array<int, array<string, string>> $attachments Array of attachment data
 * @return self
 */
public function addAttachments(array $attachments): self
{
    $attachmentObjects = [];
    
    foreach ($attachments as $item) {
        if (!isset($item['path']) || !file_exists($item['path'])) {
            continue;
        }
        
        $attachment = Attachment::fromPath($item['path']);
        
        if (isset($item['as'])) {
            $attachment = $attachment->as($item['as']);
        }
        
        if (isset($item['mime'])) {
            $attachment = $attachment->withMime($item['mime']);
        }
        
        $attachmentObjects[] = $attachment;
    }
    
    $this->customAttachments = $attachmentObjects;
    
    return $this;
}

/**
 * Get the attachments for the message.
 *
 * @return array<int, \Illuminate\Mail\Mailables\Attachment>
 */
public function attachments(): array
{
    return $this->customAttachments;
}
```

## Esempio di Utilizzo Completo

```php
// Creazione di un array di allegati
$attachments = [
    [
        'path' => 'modules/notify/resources/assets/images/logo.png',
        'as' => 'logo.png',
        'mime' => 'image/png',
    ],
];

// Invio email con allegati
Mail::to($recipient)
    ->locale('it')
    ->send((new SpatieEmail($user, 'email_template_slug'))
    ->addAttachments($attachments));
```

## Opzioni Disponibili per gli Allegati

Ogni allegato deve contenere i seguenti parametri:

- `path`: Percorso al file da allegare (può essere percorso relativo o assoluto)
- `as`: Nome del file che apparirà nell'email
- `mime`: Tipo MIME del file (es. 'image/png', 'application/pdf', ecc.)

## Note Aggiuntive

- Assicurarsi che i file specificati nei percorsi esistano
- Per allegati di grandi dimensioni, considerare l'utilizzo di un job in coda
- Verificare che i tipi MIME siano corretti per evitare problemi di visualizzazione nei client email

## Collegamenti alla Documentazione Correlata

- [EMAIL_LAYOUTS_BEST_PRACTICES.md](../mail-templates/EMAIL_LAYOUTS_BEST_PRACTICES.md)
- [SPATIE_MAIL_TEMPLATES_STRUCTURE.md](../mail-templates/SPATIE_MAIL_TEMPLATES_STRUCTURE.md)
- [EMAIL_TROUBLESHOOTING.md](./EMAIL_TROUBLESHOOTING.md)
