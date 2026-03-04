# Componente FileUpload

## Collegamenti Bidirezionali
- [Best Practices UI](../best-practices.md)
- [Errori Comuni UI](../filament-components-errors.md)
- [Form Schema Rules](../form-schema-rules.md)

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
- `imagePreviewHeight(string $height)`: Imposta l'altezza dell'anteprima
- `loadingIndicatorPosition(string $position)`: Posizione dell'indicatore di caricamento
- `removeUploadedFileButtonPosition(string $position)`: Posizione del pulsante di rimozione
- `uploadButtonPosition(string $position)`: Posizione del pulsante di upload
- `uploadProgressIndicatorPosition(string $position)`: Posizione dell'indicatore di progresso
- `buttonLabel(string $label)`: Etichetta del pulsante di upload

### ❌ Metodi Non Supportati
- `icon()`: Non esiste per FileUpload
- `prefixIcon()`: Non esiste per FileUpload

## Esempio di Implementazione Corretta

```php
use Filament\Forms\Components\FileUpload;

FileUpload::make('certifications')
    ->placeholder(trans("$prefix.fields.certifications.placeholder"))
    ->helperText(trans("$prefix.fields.certifications.help"))
    ->buttonLabel(trans("$prefix.fields.certifications.button_label"))
    ->multiple()
    ->directory('doctors/certifications')
    ->acceptedFileTypes(['application/pdf'])
    ->maxSize(10240)
    ->columnSpanFull()
```

## Note Importanti

1. Il metodo `icon()` non è supportato per FileUpload
2. Per personalizzare l'aspetto visivo, usare i metodi di visualizzazione supportati
3. Per aggiungere icone, considerare l'uso di altri componenti o soluzioni CSS
4. Consultare sempre la documentazione ufficiale di Filament per i metodi supportati

## Collegamenti Correlati

- [Documentazione Filament Forms](https://filamentphp.com/docs/3.x/forms/fields/file-upload)
- [Best Practices Forms](../forms/best-practices.md)
- [Errori Comuni](../filament-components-errors.md)
## Collegamenti tra versioni di file-upload.md
* [file-upload.md](../components/file-upload.md)
