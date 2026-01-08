# Traduzioni del Modulo Media

## Panoramica

Il modulo Media gestisce la traduzione di tutti i componenti relativi alla gestione dei file multimediali, inclusi allegati, schemi di documenti e azioni correlate.

## File di Traduzione

### attachments_schema.php

Gestisce le traduzioni per gli schemi di allegati utilizzati in diversi contesti dell'applicazione.

#### Struttura

```php
'fields' => [
    'invoice' => [
        'label' => 'Fattura',
        'placeholder' => 'Carica la fattura',
        'helper_text' => 'Formati supportati: PDF, JPG, PNG. Dimensione massima: 10MB',
        'description' => 'Documento fiscale per la prestazione sanitaria',
    ],
    // Altri tipi di documenti...
],
'validation' => [
    'file_required' => 'Il file è obbligatorio',
    // Altri messaggi di validazione...
],
'messages' => [
    'upload_success' => 'File caricato con successo',
    // Altri messaggi...
],
```

#### Tipi di Documenti Supportati

- **invoice**: Fatture e documenti fiscali
- **medical_report**: Referti medici
- **prescription**: Prescrizioni mediche
- **certificate**: Certificati medici
- **consent_form**: Moduli di consenso informato
- **xray_image**: Immagini radiografiche
- **treatment_plan**: Piani di trattamento
- **medical_history**: Storia clinica

### attachment.php

Gestisce le traduzioni per la gestione generale degli allegati.

### media.php

Gestisce le traduzioni per la gestione dei media.

### media_convert.php

Gestisce le traduzioni per la conversione dei media.

### medium.php

Gestisce le traduzioni per i singoli elementi media.

### temporary_upload.php

Gestisce le traduzioni per il caricamento temporaneo.

### actions.php

Gestisce le traduzioni per le azioni generali del modulo.

### add_attachment_action.php

Gestisce le traduzioni per l'azione di aggiunta allegati.

### icon_media.php

Gestisce le traduzioni per le icone dei media.

## Lingue Supportate

- **Italiano (it)**: Lingua principale
- **Inglese (en)**: Traduzioni complete
- **Tedesco (de)**: Traduzioni complete

## Convenzioni

1. **Struttura Espansa**: Tutti i campi utilizzano la struttura espansa con `label`, `placeholder`, `helper_text` e `description`
2. **Sintassi Array**: Utilizzo della sintassi breve `[]` invece di `array()`
3. **Strict Types**: Tutti i file includono `declare(strict_types=1);`
4. **Naming**: Chiavi in inglese, valori tradotti nella lingua target

## Utilizzo

### In Componenti Filament

```php
Forms\Components\FileUpload::make('invoice')
    ->label(__('media::attachments_schema.fields.invoice.label'))
    ->placeholder(__('media::attachments_schema.fields.invoice.placeholder'))
    ->helperText(__('media::attachments_schema.fields.invoice.helper_text'))
```

### In Validazione

```php
'file' => [
    'required' => __('media::attachments_schema.validation.file_required'),
    'mimes' => __('media::attachments_schema.validation.file_type_invalid'),
],
```

### In Messaggi

```php
Notification::make()
    ->title(__('media::attachments_schema.messages.upload_success'))
    ->success();
```

## Manutenzione

- Aggiornare le traduzioni quando si aggiungono nuovi tipi di documenti
- Mantenere coerenza tra le tre lingue
- Verificare che tutti i messaggi di errore siano tradotti
- Testare le traduzioni in tutti i contesti di utilizzo

## Collegamenti

- [Documentazione Generale Media](../structure.md)
- [Best Practice Traduzioni](../../../docs/translation-standards.md)
- [Convenzioni Laraxot](../../../docs/laraxot_conventions.md) 

