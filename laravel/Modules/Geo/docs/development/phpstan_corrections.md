# Correzioni PHPStan nel Progetto Laravel-Xot

## Introduzione

Questo documento registra i problemi PHPStan rilevati nel progetto e le corrispondenti correzioni applicate. PHPStan è uno strumento di analisi statica per PHP che aiuta a identificare potenziali errori e problemi di tipo nel codice.

## Problemi Risolti (15 marzo 2024)

### 1. `XotData.php`

**Problema**: Il metodo `iAmSuperAdmin()` restituiva un tipo misto invece di un booleano.

**Correzione applicata**:
```php
/**
 * Verifica se l'utente autenticato è un super amministratore.
 */
public function iAmSuperAdmin(): bool
{
    $user = \Illuminate\Support\Facades\Auth::user();
    if (null === $user) {
        return false;
    }

    if (! method_exists($user, 'hasRole')) {
        return false;
    }

    // Utilizziamo un'asserzione per garantire che hasRole restituisca un booleano
    $result = $user->hasRole('super-admin');
    
    return $result === true;
}
```

### 2. `ExportXlsAction.php`

**Problemi**:
1. Casting non sicuro da misto a stringa
2. Tipo di parametro non compatibile per `$fields` in `ExportXlsByCollection::execute()`

**Correzioni applicate**:
```php
if (method_exists($resource, 'getXlsFields')) {
    $fields = $resource::getXlsFields($livewire->tableFilters);
    // Convertiamo tutti i valori a stringhe
    if (is_array($fields)) {
        $fields = array_map(fn ($field): string => (string) $field, $fields);
    } else {
        $fields = [];
    }
    Assert::isArray($fields);
}

return app(ExportXlsByCollection::class)->execute(
    $rows, 
    $filename, 
    $transKey, 
    array_values($fields)
);
```

### 3. `ExportXlsLazyAction.php`

**Problemi**:
1. Casting non sicuro da misto a stringa
2. Tipo di parametro potenzialmente incompatibile

**Correzioni applicate**:
```php
if (method_exists($resource, 'getXlsFields')) {
    $fields = $resource::getXlsFields($livewire->tableFilters);
    // Convertiamo tutti i valori a stringhe
    if (is_array($fields)) {
        $fields = array_map(fn ($field): string => (string) $field, $fields);
    } else {
        $fields = [];
    }
    Assert::isArray($fields);
}

$lazy = $livewire->getFilteredTableQuery();

if ($lazy->count() < 7) {
    // ...
    // Convertiamo l'array di campi in array<int|string, string>
    $stringFields = array_values($fields);
    
    return app(ExportXlsByQuery::class)->execute(
        $query, 
        $filename, 
        $stringFields, 
        null
    );
}
```

## Problemi in Attesa di Risoluzione

### 1. `ExportTreeXlsAction.php`

**Problemi**:
1. Linea 55: Casting non sicuro da misto a stringa
2. Linea 59: Tipo di parametro non compatibile per `$fields` in `ExportXlsByCollection::execute()`

**Soluzione proposta**:
```php
if (method_exists($resource, 'getXlsFields')) {
    $fields = $resource::getXlsFields($tableFilters);
    // Convertiamo tutti i valori a stringhe
    if (is_array($fields)) {
        $fields = array_map(fn ($field): string => (string) $field, $fields);
    } else {
        $fields = [];
    }
    Assert::isArray($fields);
}

return app(ExportXlsByCollection::class)->execute(
    $rows, 
    $filename, 
    $transKey, 
    array_values($fields)
);
```

## Best Practices Implementate

1. **Dichiarazione esplicita dei tipi di ritorno**: Tutti i metodi includono dichiarazioni di tipo di ritorno esplicite (es. `: bool`, `: string`).

2. **Validazione dei tipi di array prima dell'elaborazione**: Utilizzo di controlli `is_array()` prima di applicare funzioni come `array_map()`.

3. **Conversione esplicita a stringhe**: Utilizzo di `: string` nelle dichiarazioni di tipo per le funzioni di callback e del cast `(string)` per garantire il tipo corretto.

4. **Uso di array_values()**: Per garantire che gli array abbiano chiavi numeriche consecutive, importante per la compatibilità dei tipi in alcune funzioni.

5. **Utilizzo di Assert::isArray()**: Per verificare che le variabili siano effettivamente array prima di passarle a funzioni che richiedono array. 