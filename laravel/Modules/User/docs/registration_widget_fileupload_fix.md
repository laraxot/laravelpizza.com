# RegistrationWidget FileUpload Fix

## Problema Risolto

Il `RegistrationWidget` mostrava l'errore `foreach() argument must be of type array|object, string given` durante il caricamento dei dati del form per utenti esistenti con file allegati.

## Causa del Problema

Il widget utilizzava il metodo `getFormFill()` per popolare il form con i dati esistenti dell'utente. Tuttavia, quando un utente aveva già dei file allegati salvati nel database:

1. I file venivano salvati come **stringhe** (percorsi dei file) nel database
2. Filament FileUpload si aspetta **array** di percorsi file
3. Questo mismatch causava l'errore quando Filament tentava di iterare sui file

## Codice Prima della Correzione

```php
public function getFormFill(): array
{
    $model = $this->getFormModel();
    
    if ($model->exists) {
        return $model->toArray(); // ❌ PROBLEMA: file salvati come stringhe
    }
    
    // resto del metodo...
}
```

## Codice Dopo la Correzione

```php
public function getFormFill(): array
{
    $model = $this->getFormModel();
    
    if ($model->exists) {
        try {
            $data = $model->toArray();
            
            // CORREZIONE BUG: Converti i campi file upload da stringhe ad array per Filament
            $attachments = [];
            try {
                $reflection = new \ReflectionClass($model);
                if ($reflection->hasProperty('attachments')) {
                    $property = $reflection->getProperty('attachments');
                    if ($property->isStatic()) {
                        /** @phpstan-ignore-next-line */
                        $attachments = $model::$attachments ?? [];
                    }
                }
            } catch (\ReflectionException $e) {
                // Se la proprietà non esiste, continua con array vuoto
            }
            
            foreach ($attachments as $attachment) {
                if (isset($data[$attachment]) && is_string($data[$attachment])) {
                    // Converte stringa singola in array per compatibilità Filament
                    $data[$attachment] = [$data[$attachment]];
                }
            }
            
            return $data;
        } catch (\Exception $e) {
            // Fallback per problemi con enum
            Log::warning("Errore in toArray() per modello {$this->model}: " . $e->getMessage());
            
            $attributes = $model->getAttributes();
            
            // Applica la stessa conversione anche agli attributi
            $attachments = [];
            try {
                $reflection = new \ReflectionClass($model);
                if ($reflection->hasProperty('attachments')) {
                    $property = $reflection->getProperty('attachments');
                    if ($property->isStatic()) {
                        /** @phpstan-ignore-next-line */
                        $attachments = $model::$attachments ?? [];
                    }
                }
            } catch (\ReflectionException $e) {
                // Se la proprietà non esiste, continua con array vuoto
            }
            
            foreach ($attachments as $attachment) {
                if (isset($attributes[$attachment]) && is_string($attributes[$attachment])) {
                    $attributes[$attachment] = [$attributes[$attachment]];
                }
            }
            
            return $attributes;
        }
    }
    
    // resto del metodo...
}
```

## Logica della Correzione

### 1. Identificazione Sicura degli Attachments

Invece di accedere direttamente a `$model::$attachments` (che causa errori PHPStan), uso la reflection per verificare se la proprietà esiste:

```php
$attachments = [];
try {
    $reflection = new \ReflectionClass($model);
    if ($reflection->hasProperty('attachments')) {
        $property = $reflection->getProperty('attachments');
        if ($property->isStatic()) {
            /** @phpstan-ignore-next-line */
            $attachments = $model::$attachments ?? [];
        }
    }
} catch (\ReflectionException $e) {
    // Se la proprietà non esiste, continua con array vuoto
}
```

### 2. Conversione Type-Safe

Per ogni campo attachment, verifico se è una stringa e la converto in array:

```php
foreach ($attachments as $attachment) {
    if (isset($data[$attachment]) && is_string($data[$attachment])) {
        // Converte stringa singola in array per compatibilità Filament
        $data[$attachment] = [$data[$attachment]];
    }
}
```

### 3. Gestione del Fallback

La stessa logica viene applicata anche nel caso di fallback quando `toArray()` fallisce.

## Vantaggi della Soluzione

1. **Type Safety**: Usa reflection per accesso sicuro alle proprietà statiche
2. **Backward Compatibility**: Gestisce sia stringhe che array esistenti
3. **Graceful Fallback**: Funziona anche se la proprietà `$attachments` non esiste
4. **PHPStan Compliant**: Evita errori di analisi statica

## Scenario di Test

### Before (Errore)
```php
// Dati nel database
$user->health_card = 'session-uploads/xyz/file.pdf';  // Stringa

// getFormFill() restituisce
['health_card' => 'session-uploads/xyz/file.pdf']

// Filament FileUpload cerca di iterare
foreach($state as $file) {  // ❌ ERRORE: $state è stringa, non array
    // ...
}
```

### After (Funziona)
```php
// Dati nel database
$user->health_card = 'session-uploads/xyz/file.pdf';  // Stringa

// getFormFill() restituisce (dopo correzione)
['health_card' => ['session-uploads/xyz/file.pdf']]  // Array!

// Filament FileUpload può iterare correttamente
foreach($state as $file) {  // ✅ OK: $state è array
    // ...
}
```

## Impact su Altri Componenti

Questa correzione è compatibile con:

1. **Nuovi upload**: FileUpload continua a funzionare normalmente
2. **Form validation**: Le regole di validazione rimangono invariate  
3. **Salvataggio**: I file vengono ancora salvati come stringhe nel database
4. **Altri widget**: Non impatta widget che non gestiscono file

## Testing

Per testare la correzione:

1. **Crea un utente** con file allegati
2. **Salva i file** tramite il wizard di registrazione
3. **Torna indietro** ai dati salvati (usando email + token)
4. **Verifica** che i file vengano caricati correttamente nel form
5. **Continua** il wizard senza errori

## Monitoraggio

Aggiungere logging per monitorare la conversione:

```php
Log::debug("Converting file upload field", [
    'attachment' => $attachment,
    'original_type' => gettype($data[$attachment]),
    'converted_type' => 'array',
    'session_id' => session()->getId()
]);
```

## Best Practice Future

Per evitare simili problemi in futuro:

1. **Consistency**: Mantenere i tipi di dati consistenti tra database e form
2. **Testing**: Testare sempre il reload di dati esistenti
3. **Type Checking**: Usare type checking difensivo nei callback
4. **Documentation**: Documentare i tipi di dati attesi per ogni campo

## Riferimenti

- [Problema principale: docs/fileupload-foreach-error-fix.md](../../../docs/fileupload-foreach-error-fix.md)
- [Correzione XotBaseResource: Modules/Xot/docs/fileupload-components.md](../../Xot/docs/fileupload-components.md)
- [Registration Widget base: registration-widget.md](./registration-widget.md)

