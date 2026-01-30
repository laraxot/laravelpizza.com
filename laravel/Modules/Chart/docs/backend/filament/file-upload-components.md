# Componenti FileUpload in Filament

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

## Componenti Disponibili
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

## ⚠️ Errori Comuni

### 1. Uso errato di prefixIcon
❌ **NON FARE**:
```php
FileUpload::make('document')
    ->prefixIcon('heroicon-o-document') // ❌ Questo metodo non esiste per FileUpload
```

✅ **FARE**:
```php
FileUpload::make('document')
    ->icon('heroicon-o-document') // ✅ Usare icon() invece di prefixIcon()
```

## Metodi Disponibili per FileUpload

### Metodi di Base
- `make(string $name)`: Crea un nuovo componente FileUpload
- `label(string|array $label)`: Imposta l'etichetta del campo
- `placeholder(string $placeholder)`: Imposta il testo placeholder
- `helperText(string $text)`: Aggiunge un testo di aiuto sotto il campo

### Metodi di Configurazione File
- `disk(string $disk)`: Imposta il disco di storage
- `directory(string $directory)`: Imposta la directory di upload
- `acceptedFileTypes(array $types)`: Definisce i tipi di file accettati
- `maxSize(int $size)`: Imposta la dimensione massima in KB
- `minSize(int $size)`: Imposta la dimensione minima in KB

### Metodi di Visualizzazione
- `icon(string $icon)`: Imposta l'icona del componente
- `downloadable()`: Abilita il download dei file
- `previewable()`: Abilita l'anteprima dei file
- `imagePreviewHeight(string $height)`: Imposta l'altezza dell'anteprima
- `loadingIndicatorPosition(string $position)`: Posizione dell'indicatore di caricamento
- `removeUploadedFileButtonPosition(string $position)`: Posizione del pulsante di rimozione
- `uploadButtonPosition(string $position)`: Posizione del pulsante di upload
- `uploadProgressIndicatorPosition(string $position)`: Posizione dell'indicatore di progresso

### Metodi di Layout
- `columnSpanFull()`: Occupa l'intera larghezza
- `columnSpan(int|string|array $span)`: Imposta lo span della colonna
- `extraAttributes(array $attributes)`: Aggiunge attributi HTML personalizzati

## Esempio Completo

```php
FileUpload::make('document')
    ->label('Documento')
    ->placeholder('Carica il tuo documento')
    ->helperText('Formati accettati: PDF, JPG, PNG')
    ->disk('public')
    ->directory('documents')
    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
    ->maxSize(5120)
    ->icon('heroicon-o-document')
    ->downloadable()
    ->previewable()
    ->imagePreviewHeight('100')
    ->loadingIndicatorPosition('left')
    ->removeUploadedFileButtonPosition('right')
    ->uploadButtonPosition('left')
    ->uploadProgressIndicatorPosition('left')
    ->columnSpanFull()
    ->extraAttributes(['class' => 'bg-blue-50/30'])
```

## Best Practices

1. **Validazione**:
   - Specificare sempre i tipi di file accettati
   - Impostare limiti di dimensione appropriati
   - Utilizzare helperText per guidare l'utente

2. **Visualizzazione**:
   - Usare `icon()` invece di `prefixIcon()`
   - Configurare le posizioni degli indicatori per una migliore UX
   - Abilitare preview e download quando appropriato

3. **Storage**:
   - Specificare sempre il disco di storage
   - Organizzare i file in directory appropriate
   - Considerare la sicurezza nella configurazione

## Note Importanti

1. `FileUpload` non supporta `prefixIcon` perché è progettato per gestire file invece di testo
2. Usare `icon()` per aggiungere icone al componente
3. La preview è automaticamente abilitata per le immagini
4. Il download è disabilitato di default per sicurezza

## Configurazione Corretta dei Componenti FileUpload

### Metodi Supportati

I componenti `FileUpload` di Filament supportano i seguenti metodi di configurazione:

```php
Forms\Components\FileUpload::make('nome_campo')
    ->label('Etichetta del campo')
    ->disk('public')                                // Disco di storage
    ->directory('percorso/cartella')                // Directory di destinazione
    ->acceptedFileTypes(['mime/types'])             // Tipi di file accettati
    ->maxSize(5120)                                 // Dimensione massima in KB
    ->required()                                    // Campo obbligatorio
    ->downloadable()                                // Permette il download
    ->previewable()                                 // Permette l'anteprima
    ->imagePreviewHeight('100')                     // Altezza anteprima immagine
    ->loadingIndicatorPosition('left')              // Posizione indicatore caricamento
    ->removeUploadedFileButtonPosition('right')     // Posizione pulsante rimozione (CORRETTO)
    ->uploadButtonPosition('left')                  // Posizione pulsante upload
    ->uploadProgressIndicatorPosition('left')       // Posizione indicatore progresso
    ->columnSpanFull()                              // Occupa tutta la larghezza
```

### Metodi NON Supportati

⚠️ **IMPORTANTE**: I seguenti metodi **NON** sono supportati dai componenti `FileUpload`:

- `prefixIcon()` - Questo metodo non è disponibile per i componenti `FileUpload`
- `suffixIcon()` - Questo metodo non è disponibile per i componenti `FileUpload`
- `removeButtonPosition()` - Questo metodo non esiste, usare invece `removeUploadedFileButtonPosition()`
- `extraAttributes()` - Questo metodo potrebbe non funzionare come previsto con i componenti `FileUpload`

Questi metodi sono supportati solo dai componenti di input di testo come `TextInput`.

## Esempio Corretto

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
    ->removeButtonPosition('right')
    ->uploadButtonPosition('left')
    ->uploadProgressIndicatorPosition('left')
    ->columnSpanFull()
```

## Alternativa per Icone

Se desideri aggiungere un'icona al componente di caricamento file, puoi utilizzare l'approccio seguente:

```php
Forms\Components\Section::make('Documenti')
    ->icon('heroicon-o-document-text')
    ->schema([
        Forms\Components\FileUpload::make('health_card')
            ->label('Tessera sanitaria, STP o ENI')
            // altre configurazioni...
    ])
```

## Gestione dei File Caricati

I file caricati tramite i componenti `FileUpload` vengono salvati nel disco specificato (di default `public`) e il percorso relativo viene memorizzato nel database.

Per accedere ai file caricati:

```php
// Nel controller o nel modello
$filePath = $model->health_card;
$fullUrl = Storage::disk('public')->url($filePath);
```

## Collegamenti Bidirezionali

- [Documentazione Filament Forms](https://filamentphp.com/docs/3.x/forms/fields/file-upload)
- [Gestione Upload in il progetto](../upload-management.md)
- [Convenzioni di Naming](../convenzioni-naming-campi.md)
