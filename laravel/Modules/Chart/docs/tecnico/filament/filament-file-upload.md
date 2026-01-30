# Filament FileUpload Component - Best Practices

## Introduzione

Questo documento descrive le best practices per l'utilizzo del componente `FileUpload` in Filament all'interno del progetto il progetto. Il componente `FileUpload` è utilizzato per gestire il caricamento di file come documenti, immagini e altri tipi di file.

## Versione di Filament

Questo documento è specifico per **Filament 4.3.14**, la versione attualmente utilizzata nel progetto il progetto. I metodi e le opzioni disponibili possono variare in versioni diverse.

## Configurazione Corretta

### Metodi Supportati

```php
Forms\Components\FileUpload::make('document')
    ->label('Documento')                        // Etichetta del campo
    ->disk('public')                            // Specifica il disco di storage
    ->directory('documents/category')           // Specifica la directory di destinazione
    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])  // Limita i tipi di file
    ->maxSize(5120)                             // Limita la dimensione (in KB)
    ->downloadable()                            // Permette il download
    ->previewable()                             // Permette l'anteprima
    ->imagePreviewHeight('100')                 // Altezza anteprima immagine
    ->panelLayout('compact')                    // Layout del pannello (compact, integrated)
    ->panelAspectRatio('16:9')                  // Rapporto aspetto del pannello
    ->columnSpanFull()                          // Occupa tutta la larghezza
```

### Metodi di Posizionamento Corretti

```php
// Metodi corretti per il posizionamento dei pulsanti e indicatori
Forms\Components\FileUpload::make('document')
    ->loadingIndicatorPosition('left')          // Posizione indicatore caricamento
    ->removeUploadedFileButtonPosition('right') // Posizione pulsante rimozione (CORRETTO)
    ->uploadButtonPosition('left')              // Posizione pulsante upload
    ->uploadProgressIndicatorPosition('left')   // Posizione indicatore progresso
```

### Metodi NON Supportati

⚠️ **IMPORTANTE**: I seguenti metodi **NON** sono supportati dai componenti `FileUpload` e causeranno errori se utilizzati:

- `prefixIcon()` - Questo metodo non è disponibile per i componenti `FileUpload`
- `suffixIcon()` - Questo metodo non è disponibile per i componenti `FileUpload`
- `removeButtonPosition()` - Questo metodo non esiste, usare invece `removeUploadedFileButtonPosition()`
- `extraAttributes()` - Questo metodo potrebbe non funzionare come previsto con i componenti `FileUpload`

Utilizzare questi metodi causerà errori come:
- `Method Filament\Forms\Components\FileUpload::prefixIcon does not exist`
- `Method Filament\Forms\Components\FileUpload::removeButtonPosition does not exist`
- `Method Filament\Forms\Components\FileUpload::suffixIcon does not exist`

## Esempi di Implementazione

### Esempio Base

```php
Forms\Components\FileUpload::make('document')
    ->label('Documento')
    ->disk('public')
    ->directory('documents')
    ->required()
```

### Esempio Completo

```php
Forms\Components\FileUpload::make('health_card')
    ->label('Tessera sanitaria, STP o ENI')
    ->disk('public')
    ->directory('documents/health-cards')
    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
    ->maxSize(5120)
    ->required()
    ->downloadable()
    ->previewable()
    ->imagePreviewHeight('100')
    ->loadingIndicatorPosition('left')
    ->removeUploadedFileButtonPosition('right') // CORRETTO: usare removeUploadedFileButtonPosition
    ->uploadButtonPosition('left')
    ->uploadProgressIndicatorPosition('left')
    ->columnSpanFull()
```

## Gestione dei File Caricati

### Accesso ai File Caricati

I file caricati vengono salvati nel percorso specificato e il loro percorso relativo viene memorizzato nel database. Per accedere al file:

```php
// Nel controller o nel modello
$filePath = Storage::disk('public')->path($model->document);
```

### Validazione Lato Server

Oltre alla validazione lato client, è importante implementare anche la validazione lato server:

```php
public static function getFormSchema(): array
{
    return [
        FileUpload::make('document')
            ->disk('public')
            ->directory('documents')
            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
            ->maxSize(5120)
            ->rules([
                'mimes:pdf,jpg,jpeg,png',
                'max:5120', // 5MB
            ])
    ];
}
```

## Personalizzazione dell'Interfaccia

### Stile Personalizzato

Per personalizzare l'aspetto del componente FileUpload, utilizzare le classi CSS di Tailwind:

```php
Forms\Components\FileUpload::make('document')
    ->label('Documento')
    ->panelLayout('compact') // Layout compatto
    ->panelAspectRatio('16:9') // Rapporto aspetto del pannello
    ->imageResizeMode('cover') // Modalità ridimensionamento immagine
```

## Troubleshooting

### Errori Comuni

1. **Method does not exist**: Verificare di utilizzare solo i metodi supportati dal componente FileUpload.
   - Errore: `Method Filament\Forms\Components\FileUpload::prefixIcon does not exist`
   - Errore: `Method Filament\Forms\Components\FileUpload::removeButtonPosition does not exist`
   - Soluzione: Consultare la documentazione ufficiale per i metodi supportati

2. **Permessi di scrittura**: Assicurarsi che la directory di destinazione sia scrivibile.
   - Errore: `Unable to create directory`
   - Soluzione: Verificare i permessi della directory e che il percorso esista

3. **Dimensione massima file**: Verificare che la configurazione PHP (`upload_max_filesize` e `post_max_size`) consenta il caricamento di file della dimensione desiderata.
   - Errore: `The uploaded file exceeds the upload_max_filesize directive in php.ini`
   - Soluzione: Aumentare i limiti in php.ini o ridurre la dimensione massima del file

### Soluzioni

- Utilizzare solo i metodi documentati nella [documentazione ufficiale di Filament](https://filamentphp.com/docs/forms/fields/file-upload).
- Consultare la [lista completa dei metodi disponibili](https://filamentphp.com/docs/3.x/forms/fields/file-upload#available-methods) per il componente FileUpload.
- Testare il caricamento con file di piccole dimensioni prima di passare a file più grandi.
- Verificare i log di Laravel per messaggi di errore dettagliati.

## Compatibilità tra Versioni

### Filament 4.x

In Filament 4.x, il componente FileUpload ha subito diverse modifiche rispetto alle versioni precedenti:

- Alcuni metodi sono stati rinominati per maggiore chiarezza (es. `removeButtonPosition` → `removeUploadedFileButtonPosition`)
- Nuove opzioni per la personalizzazione dell'interfaccia
- Miglior supporto per l'anteprima di file non immagine

### Aggiornamenti di Versione

Quando si aggiorna Filament, è importante verificare la documentazione ufficiale per eventuali modifiche ai metodi supportati. Alcuni metodi potrebbero essere stati rinominati, deprecati o rimossi.

## Conclusioni

Il componente FileUpload di Filament è potente e flessibile, ma richiede una configurazione corretta. Seguendo queste best practices, è possibile evitare errori comuni e offrire un'esperienza utente ottimale per il caricamento dei file.

## Riferimenti

- [Documentazione ufficiale Filament FileUpload](https://filamentphp.com/docs/forms/fields/file-upload)
- [Laravel File Storage](https://laravel.com/docs/filesystem)

## Gestione Traduzioni
- Le traduzioni sono gestite tramite LangServiceProvider
- NON usare ->label(), ->placeholder(), ->helperText()
- Definire le traduzioni nei file di lingua del modulo

## Struttura Traduzioni
```php
// resources/lang/it/upload.php
return [
    'fields' => [
        'document' => [
            'label' => 'Documento',
            'placeholder' => 'Carica il tuo documento',
            'helper_text' => 'Formati accettati: PDF, JPG, PNG',
        ],
        'health_card' => [
            'label' => 'Tessera sanitaria, STP o ENI',
            'placeholder' => 'Carica la tua tessera sanitaria',
            'helper_text' => 'Formati accettati: PDF, JPG, PNG',
        ],
    ],
];
```

## Implementazione
```php
// ❌ NON FARE:
->label('Documento')
->placeholder('Carica il tuo documento')

// ✅ FARE:
// Le traduzioni sono gestite automaticamente tramite LangServiceProvider
// Definire nei file di lingua come mostrato sopra
```

## Componenti
1. **FileUpload**
   - Upload singolo file
   - Validazione formati
   - Preview immagine

2. **MultipleFileUpload**
   - Upload multiplo file
   - Drag & drop
   - Progress bar

3. **ImageUpload**
   - Upload immagini
   - Preview
   - Cropping

## Best Practices
1. **Validazione**
   - Definire formati accettati
   - Impostare dimensione massima
   - Validare mime type

2. **Storage**
   - Usare disk appropriato
   - Organizzare in cartelle
   - Gestire permessi

3. **UI/UX**
   - Feedback visivo
   - Messaggi di errore
   - Preview file

## Note Tecniche
- Tutte le traduzioni sono gestite tramite LangServiceProvider
- Definire le traduzioni nei file di lingua del modulo
- NON usare metodi di traduzione diretti nei componenti
