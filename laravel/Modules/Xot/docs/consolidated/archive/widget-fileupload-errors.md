# Widget FileUpload Errors - Troubleshooting Guide

## Errore: "foreach() argument must be of type array|object, string given"

### Sintomi
- Errore durante il caricamento di pagine con widget che contengono FileUpload
- Stack trace che punta a `Filament\Forms\Components\BaseFileUpload::getUploadedFiles`
- Si verifica tipicamente quando si caricano dati esistenti dal database

### Causa Radice
Filament si aspetta che i componenti `FileUpload` ricevano array di file, ma quando i dati vengono caricati dal database tramite `model->toArray()`, i campi file upload possono essere stringhe (percorsi file).

### Scenario Tipico
1. Widget carica dati esistenti con `$model->toArray()`
2. Campi file upload nel database sono stringhe: `"file.pdf"`
3. Filament riceve stringhe invece di array: `["file.pdf"]`
4. Errore durante l'iterazione con `foreach()`

## Soluzioni

### Soluzione A: Correzione nel Widget (Raccomandato)

Nel metodo che popola i dati del form (es. `getFormFill()`, `mount()`):

```php
public function getFormFill(): array
{
    $model = $this->getFormModel();
    
    if ($model->exists) {
        $data = $model->toArray();
        
        // Converti campi file upload da stringhe ad array
        $attachments = $model::$attachments ?? [];
        foreach ($attachments as $attachment) {
            if (isset($data[$attachment]) && is_string($data[$attachment])) {
                $data[$attachment] = [$data[$attachment]];
            }
        }
        
        return $data;
    }
    
    return [];
}
```

### Soluzione B: Correzione nel Resource Schema

Nel metodo che definisce lo schema degli allegati:

```php
Forms\Components\FileUpload::make($attachment)
    ->formatStateUsing(function ($state, $set) use ($attachment) {
        if (is_string($state)) {
            $sessionFiles = [$state];
        } elseif (is_array($state)) {
            $sessionFiles = $state;
        } else {
            $sessionFiles = [];
        }
        
        $set($attachment, $sessionFiles);
        return $sessionFiles;
    })
```

### Soluzione C: Uso di Accessors nel Model

Definire accessors nel modello per gestire automaticamente la conversione:

```php
// Nel modello
public function getHealthCardAttribute($value)
{
    if (is_string($value)) {
        return [$value];
    }
    return $value;
}

protected function casts(): array
{
    return [
        'health_card' => 'array',
        'identity_document' => 'array',
        // Altri campi file...
    ];
}
```

## Pattern di Prevenzione

### 1. Controllo Tipo Dinamico

```php
private function ensureFileFieldsAreArrays(array $data, array $fileFields): array
{
    foreach ($fileFields as $field) {
        if (isset($data[$field]) && is_string($data[$field])) {
            $data[$field] = [$data[$field]];
        }
    }
    return $data;
}
```

### 2. Trait per Widget con FileUpload

```php
trait HandlesFileUploadFields
{
    protected function normalizeFileUploadFields(array $data, ?array $fileFields = null): array
    {
        $fileFields = $fileFields ?? $this->getFileUploadFields();
        
        foreach ($fileFields as $field) {
            if (isset($data[$field]) && is_string($data[$field])) {
                $data[$field] = [$data[$field]];
            }
        }
        
        return $data;
    }
    
    protected function getFileUploadFields(): array
    {
        $model = $this->getFormModel();
        return property_exists($model, 'attachments') ? $model::$attachments : [];
    }
}
```

### 3. Helper per Modelli

```php
// In BaseModel o trait condiviso
public function getFileUploadFieldsAsArrays(array $fields = null): array
{
    $fields = $fields ?? static::$attachments ?? [];
    $data = $this->toArray();
    
    foreach ($fields as $field) {
        if (isset($data[$field]) && is_string($data[$field])) {
            $data[$field] = [$data[$field]];
        }
    }
    
    return $data;
}
```

## Debug e Diagnostica

### Controllo Rapido

```php
// Aggiungi questo al widget per debug
public function mount()
{
    $data = $this->getFormFill();
    
    foreach (['health_card', 'identity_document'] as $field) {
        if (isset($data[$field])) {
            Log::info("Field {$field} type: " . gettype($data[$field]));
            Log::info("Field {$field} value: " . json_encode($data[$field]));
        }
    }
    
    $this->form->fill($data);
}
```

### Verifica Database

```sql
-- Controlla come sono salvati i campi nel database
SELECT health_card, identity_document, isee_certificate 
FROM users 
WHERE id = 'specific-user-id';
```

### Verifica Modello

```php
// Nel tinker
$user = User::find('user-id');
var_dump($user->health_card); // Dovrebbe essere string o null
var_dump($user->toArray()['health_card']); // Controlla il tipo dopo toArray()
```

## Test di Regressione

### Test Unitario

```php
public function test_file_upload_fields_are_converted_to_arrays()
{
    $user = User::factory()->create([
        'health_card' => 'session-uploads/test.pdf',
        'identity_document' => 'session-uploads/doc.pdf',
    ]);
    
    $widget = new RegistrationWidget();
    $widget->type = 'patient';
    // Setup del widget...
    
    $data = $widget->getFormFill();
    
    $this->assertIsArray($data['health_card']);
    $this->assertIsArray($data['identity_document']);
    $this->assertEquals(['session-uploads/test.pdf'], $data['health_card']);
}
```

### Test di Integrazione

```php
public function test_registration_widget_loads_without_errors_for_existing_user()
{
    $user = User::factory()->create([
        'health_card' => 'session-uploads/test.pdf',
    ]);
    
    $response = $this->get("/auth/patient/register?email={$user->email}&token={$user->remember_token}");
    
    $response->assertStatus(200);
    // Non dovrebbe esserci errore foreach()
}
```

## Riferimenti

- [Filament FileUpload Documentation](https://filamentphp.com/project_docs/forms/fields/file-upload)
- [Laravel Eloquent Accessors](https://laravel.com/project_docs/eloquent-accessors)
- [Livewire File Uploads](https://livewire.laravel.com/project_docs/file-uploads)

## Casi Correlati

Questo pattern si applica anche a:
- Upload multipli che diventano stringhe JSON
- Campi che memorizzano array ma vengono serializzati come stringhe
- Widget che caricano dati da relazioni con upload file
- Form che ripopolano campi da sessioni interrotte

---

**Tipo**: Troubleshooting Guide  
**Modulo**: Xot (Base)  
**Applicabilità**: Tutti i widget con FileUpload che caricano dati esistenti  
**Aggiornato**: 2025-01-07 