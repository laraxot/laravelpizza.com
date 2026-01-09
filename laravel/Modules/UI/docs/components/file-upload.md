# Componente FileUpload

## Collegamenti Bidirezionali
- [Errori Comuni FileUpload](../filament-components-errors.md#1-fileupload-uso-errato-di-prefixicon)
- [Best Practices UI](../../best-practices.md)
- [Implementazione Corretta](../../examples/correct-implementation.md)

## Metodi Supportati

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

## Esempio di Implementazione Corretta

```php
Forms\Components\FileUpload::make('document')
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

## Collegamenti Correlati

- [Documentazione Filament Forms](https://filamentphp.com/docs/3.x/forms/fields/file-upload)
- [Gestione Upload in il progetto](../../../docs/upload-management.md)
- [Convenzioni di Naming](../../../docs/convenzioni-naming-campi.md)
## Collegamenti tra versioni di file-upload.md
* [file-upload.md](../filament-components/file-upload.md)
