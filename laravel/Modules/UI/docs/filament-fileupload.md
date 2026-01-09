# FileUpload Component in Filament

## Metodi Disponibili

### Configurazione Base
```php
FileUpload::make('document')
    // Non usare ->label() - Le label sono gestite dal LangServiceProvider
    ->disk('public')
    ->directory('documents')
    ->acceptedFileTypes(['application/pdf'])
    ->maxSize(10240)
```

### UI/UX
```php
FileUpload::make('document')
    ->downloadable()
    ->previewable()
    ->imagePreviewHeight('250')
    ->panelLayout('integrated')
    ->panelAspectRatio('16:9')
    ->loadingIndicatorPosition('right')
    ->removeUploadedFileButtonPosition('right')
    ->uploadProgressIndicatorPosition('right')
```

## ⚠️ Errori Comuni

### 1. Uso di prefixIcon
❌ **NON FARE**:
```php
FileUpload::make('document')
    ->prefixIcon('heroicon-o-document') // Questo metodo non esiste!
```

✅ **FARE**:
```php
FileUpload::make('document')
    ->buttonIcon('heroicon-o-document') // Usa buttonIcon per l'icona del pulsante
```

### 2. Uso di label()
❌ **NON FARE**:
```php
FileUpload::make('document')
    ->label('Documento') // Non usare label() direttamente
```

✅ **FARE**:
```php
// Usa il file di traduzione invece
// lang/it/resource.php
return [
    'fields' => [
        'document' => [
            'label' => 'Documento',
            'placeholder' => 'Carica un documento',
            'help' => 'Formato PDF, max 10MB',
        ],
    ],
];
```

## Best Practices

1. **Sicurezza**
   - Limita sempre i tipi di file accettati
   - Imposta una dimensione massima appropriata
   - Usa directory specifiche per tipo di file
   - Implementa validazione server-side

2. **Performance**
   - Ottimizza le dimensioni dei file
   - Usa disk appropriati per lo storage
   - Implementa gestione errori
   - Fornisci feedback di progresso

3. **UX**
   - Usa icone appropriate
   - Fornisci preview quando possibile
   - Mostra messaggi di errore chiari
   - Implementa drag & drop

4. **Manutenibilità**
   - Usa costanti per configurazioni comuni
   - Centralizza la logica di upload
   - Documenta requisiti specifici
   - Segui le convenzioni di naming

## Collegamenti
- [Translation System](../../Lang/docs/translation-system.md)
- [Form Components](../../Patient/docs/filament-form-components.md)
- [Best Practices](../../Xot/docs/filament-best-practices.md)

## Vedi Anche
- [Filament File Upload](https://filamentphp.com/docs/forms/fields/file-upload)
- [Laravel File Storage](https://laravel.com/docs/filesystem)
# FileUpload Component in Filament

## Metodi Disponibili

### Configurazione Base
```php
FileUpload::make('document')
    // Non usare ->label() - Le label sono gestite dal LangServiceProvider
    ->disk('public')
    ->directory('documents')
    ->acceptedFileTypes(['application/pdf'])
    ->maxSize(10240)
```

### UI/UX
```php
FileUpload::make('document')
    ->downloadable()
    ->previewable()
    ->imagePreviewHeight('250')
    ->panelLayout('integrated')
    ->panelAspectRatio('16:9')
    ->loadingIndicatorPosition('right')
    ->removeUploadedFileButtonPosition('right')
    ->uploadProgressIndicatorPosition('right')
```

## ⚠️ Errori Comuni

### 1. Uso di prefixIcon
❌ **NON FARE**:
```php
FileUpload::make('document')
    ->prefixIcon('heroicon-o-document') // Questo metodo non esiste!
```

✅ **FARE**:
```php
FileUpload::make('document')
    ->buttonIcon('heroicon-o-document') // Usa buttonIcon per l'icona del pulsante
```

### 2. Uso di label()
❌ **NON FARE**:
```php
FileUpload::make('document')
    ->label('Documento') // Non usare label() direttamente
```

✅ **FARE**:
```php
// Usa il file di traduzione invece
// lang/it/resource.php
return [
    'fields' => [
        'document' => [
            'label' => 'Documento',
            'placeholder' => 'Carica un documento',
            'help' => 'Formato PDF, max 10MB',
        ],
    ],
];
```

## Best Practices

1. **Sicurezza**
   - Limita sempre i tipi di file accettati
   - Imposta una dimensione massima appropriata
   - Usa directory specifiche per tipo di file
   - Implementa validazione server-side

2. **Performance**
   - Ottimizza le dimensioni dei file
   - Usa disk appropriati per lo storage
   - Implementa gestione errori
   - Fornisci feedback di progresso

3. **UX**
   - Usa icone appropriate
   - Fornisci preview quando possibile
   - Mostra messaggi di errore chiari
   - Implementa drag & drop

4. **Manutenibilità**
   - Usa costanti per configurazioni comuni
   - Centralizza la logica di upload
   - Documenta requisiti specifici
   - Segui le convenzioni di naming

## Collegamenti
- [Translation System](../../Lang/project_docs/translation-system.md)
- [Form Components](../../Patient/project_docs/filament-form-components.md)
- [Best Practices](../../Xot/project_docs/filament-best-practices.md)

## Vedi Anche
- [Filament File Upload](https://filamentphp.com/project_docs/forms/fields/file-upload)
- [Laravel File Storage](https://laravel.com/project_docs/filesystem)
