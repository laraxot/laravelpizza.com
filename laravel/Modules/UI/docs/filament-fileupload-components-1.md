# Componenti FileUpload in Filament

## Errore Comune: prefixIcon
Il metodo `prefixIcon()` non esiste nel componente FileUpload di Filament. Questo è un errore comune quando si confondono i componenti TextInput (che hanno il metodo prefixIcon) con i componenti FileUpload.

### ❌ Errato
```php
Forms\Components\FileUpload::make('certifications')
    ->prefixIcon('heroicon-o-document-text') // Questo metodo non esiste!
    ->label('Certificazioni');
```

### ✅ Corretto
```php
Forms\Components\FileUpload::make('certifications')
    ->label('Certificazioni')
    ->icon('heroicon-o-document-text') // Usare icon() invece di prefixIcon()
    ->buttonLabel('Carica certificazioni')
    ->disk('public')
    ->directory('certifications')
    ->acceptedFileTypes(['application/pdf'])
    ->maxSize(10240);
```

## Metodi Disponibili per FileUpload

### Metodi Base
- `make(string $name)`: Crea una nuova istanza del componente
- `label(string $label)`: Imposta la label del componente
- `icon(string $icon)`: Imposta l'icona del pulsante di upload
- `buttonLabel(string $label)`: Imposta il testo del pulsante di upload
- `disk(string $disk)`: Imposta il disco di storage
- `directory(string $directory)`: Imposta la directory di destinazione
- `acceptedFileTypes(array $types)`: Imposta i tipi di file accettati
- `maxSize(int $size)`: Imposta la dimensione massima del file in KB

### Best Practices

1. **UI/UX**
   - Usare icone appropriate per il tipo di file
   - Fornire feedback visivo durante l'upload
   - Mostrare preview dei file quando possibile
   - Implementare validazione client-side

2. **Sicurezza**
   - Limitare i tipi di file accettati
   - Impostare una dimensione massima ragionevole
   - Validare i file lato server
   - Usare nomi file sicuri

3. **Performance**
   - Ottimizzare la dimensione dei file
   - Implementare upload asincroni
   - Gestire correttamente gli errori
   - Fornire feedback di progresso

## Collegamenti
- [README](../../Patient/docs/README.md)
- [Filament Resources](../../Patient/docs/filament-resources.md)
- [Form Components](../../Patient/docs/filament-form-components.md)

## Vedi Anche
- [Filament FileUpload Documentation](https://filamentphp.com/docs/forms/fields#file-upload)
- [Best Practices](../../Xot/docs/filament-best-practices.md)
