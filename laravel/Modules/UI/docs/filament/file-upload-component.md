# Componente FileUpload in Filament

## Limitazioni e Metodi Disponibili

### Metodi NON supportati

Il componente `FileUpload` di Filament **non supporta** i seguenti metodi:

- ❌ `icon()` - Non disponibile per FileUpload
- ❌ `hint()` - Usare `helperText()` invece
- ❌ `prefixIcon()` - Non disponibile per FileUpload
- ❌ `uploadButtonLabel()` - Usare `buttonLabel()` invece

### Metodi Supportati

Il componente `FileUpload` supporta i seguenti metodi:

```php
Forms\Components\FileUpload::make('field_name')
    ->label('Etichetta')
    ->helperText('Testo di aiuto')
    ->disk('public')
    ->directory('path/to/directory')
    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
    ->maxSize(5120) // KB
    ->downloadable()
    ->previewable()
    ->imagePreviewHeight('100')
    ->loadingIndicatorPosition('left')
    ->removeUploadedFileButtonPosition('right')
    ->uploadButtonPosition('left')
    ->uploadProgressIndicatorPosition('left')
    ->columnSpanFull()
```

## Come Aggiungere un'Icona (Alternativa)

Se è necessario associare un'icona a un campo di caricamento file, utilizzare una delle seguenti alternative:

### Opzione 1: Usare Section con un'icona

```php
Forms\Components\Section::make('Documenti')
    ->icon('heroicon-o-document-text')
    ->schema([
        Forms\Components\FileUpload::make('health_card')
            // configurazione del file upload
    ])
```

### Opzione 2: Aggiungere un'icona manualmente nel template

```blade
<div class="flex items-center">
    <x-filament::icon name="heroicon-o-document-text" class="mr-2 h-5 w-5" />
    {{ $getLabel() }}
</div>
```

## Errori Comuni

Un errore comune è tentare di utilizzare il metodo `icon()` direttamente sul componente `FileUpload`:

```php
// ❌ QUESTO CAUSERÀ UN ERRORE
Forms\Components\FileUpload::make('document')
    ->icon('heroicon-o-document-text') // BadMethodCallException: Method Filament\Forms\Components\FileUpload::icon does not exist
```

## Riferimenti

- [Documentazione Filament FileUpload](https://filamentphp.com/docs/3.x/forms/fields/file-upload)
- [API Components Filament](../UI/docs/filament/components-api.md)

> **NOTA**: Questa documentazione segue la regola di centralizzare tutte le documentazioni UI nel modulo UI con collegamenti bidirezionali dagli altri moduli.
