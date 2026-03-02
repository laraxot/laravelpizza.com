# Regole Fondamentali per i Metodi Filament - Aggiornamento

## Tipizzazione Corretta degli Array - Distinzione per Contesto

Nei metodi Filament, la tipizzazione degli array dipende dal contesto di utilizzo:

### Contesti in Cui Usare Array Indicizzati (Senza Chiavi)

Per questi metodi, usare array indicizzati è la pratica corretta:

```php
// ✅ CORRETTO
public function getTableColumns(): array
{
    return [
        TextColumn::make('name'),
        TextColumn::make('email'),
    ];  // Array indicizzato senza chiavi stringa
}

public function getTableActions(): array
{
    return [
        ViewAction::make(),
        EditAction::make(),
    ];  // Array indicizzato senza chiavi stringa
}

public function getTableFilters(): array
{
    return [
        SelectFilter::make('status'),
        Filter::make('created_at'),
    ];  // Array indicizzato senza chiavi stringa
}
```

### Contesti in Cui Usare Array Associativi con Chiavi Stringa

Per `getFormSchema()` nei **widget senza modello**, le chiavi stringa sono **necessarie** per il corretto binding con `statePath('data')`:

```php
// ✅ CORRETTO per widget senza modello
public function getFormSchema(): array
{
    return [
        'email' => TextInput::make('email')->email()->required(),  // Chiave stringa necessaria
        'password' => TextInput::make('password')->password()->required(),  // Chiave stringa necessaria
        'remember' => Checkbox::make('remember'),  // Chiave stringa necessaria
    ];
}
```

Questo perché il sistema `initXotBaseWidget()` usa `array_keys($this->getFormSchema())` per inizializzare correttamente `$this->data` come `['email' => null, 'password' => null, 'remember' => null]`.

### Contesti in Cui Usare Array Indicizzati (Per Form Schema)

Per `getFormSchema()` nei **resource e pagine** (dove non viene usato `statePath('data')` nello stesso modo), usare array indicizzati è la pratica corretta:

```php
// ✅ CORRETTO per resource/pagine
public static function getFormSchema(): array
{
    return [
        TextInput::make('email')->email()->required(),
        TextInput::make('password')->password()->required(),
    ];  // Array indicizzato senza chiavi stringa
}
```

## Motivo Tecnico per i Widget

L'uso di chiavi stringa in `getFormSchema()` per i widget è necessario perché:
- Il sistema usa `array_keys()` per ottenere i nomi dei campi
- Questi nomi diventano le chiavi in `$this->data`
- Queste chiavi sono richieste dal binding di Livewire con `statePath('data')`

## Eloquent Magic Properties

**Regola Critica**: Mai usare `property_exists()` con modelli Eloquent. Usare sempre `isset()`, `hasAttribute()`, `isFillable()` o `Schema::hasColumn()` invece.

```php
// ❌ SBAGLIATO
if (property_exists($model, 'name')) { }

// ✅ CORRETTO
if (isset($model->name)) { }
```
