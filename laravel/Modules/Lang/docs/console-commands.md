# Console Commands - Lang Module

## Panoramica
Il modulo Lang fornisce comandi console per la gestione delle traduzioni, inclusa conversione tra formati e ricerca di traduzioni mancanti.

## Comandi Disponibili

### ConvertTranslations
Converte file di traduzione tra formato PHP e JSON.

#### Funzionalità
- Conversione da PHP a JSON
- Conversione da JSON a PHP
- Gestione di traduzioni annidate
- Supporto per strutture complesse

#### Type Safety Implementata
```php
/**
 * @param array<string, mixed> $array
 * @param string $prefix
 * @return array<string, string>
 */
protected function flattenArray(array $array, string $prefix = ''): array
{
    $result = [];
    
    foreach ($array as $key => $value) {
        Assert::string($key, 'Le chiavi degli array devono essere stringhe');
        $newKey = $prefix ? "{$prefix}.{$key}" : $key;
        
        if (is_array($value)) {
            /** @var array<string, mixed> $value */
            $result = array_merge($result, $this->flattenArray($value, $newKey));
        } else {
            Assert::string($value, 'I valori delle traduzioni devono essere stringhe');
            $result[$newKey] = $value;
        }
    }
    
    return $result;
}
```

### FindMissingTranslations
Trova traduzioni mancanti o vuote nel sistema.

#### Funzionalità
- Scansione ricorsiva dei file PHP
- Rilevamento di chiavi vuote o null
- Conteggio delle occorrenze
- Report dettagliato

#### Type Safety Implementata
```php
/**
 * @param array<string, mixed> $array
 * @param string $namespace
 * @param string $file
 * @param string $parentKey
 * @return array<int, array<string, string|int>>
 */
protected function checkArrayForMissing(array $array, string $namespace, string $file, string $parentKey = ''): array
{
    $missing = [];
    
    foreach ($array as $key => $value) {
        Assert::string($key, 'Le chiavi delle traduzioni devono essere stringhe');
        $currentKey = $parentKey ? "{$parentKey}.{$key}" : $key;
        
        if (is_array($value)) {
            /** @var array<string, mixed> $value */
            $missing = array_merge(
                $missing,
                $this->checkArrayForMissing($value, $namespace, $file, $currentKey)
            );
        } elseif ($value === '' || $value === null) {
            $missing[] = [
                'key' => $namespace . '.' . $currentKey,
                'file' => $file,
                'occurrences' => $this->findOccurrences($namespace . '.' . $currentKey)
            ];
        }
    }
    
    return $missing;
}
```

## Principi di Implementazione

### Type Safety
- Uso di `declare(strict_types=1);` in tutti i file
- Type hints espliciti per tutti i parametri
- Gestione corretta dei tipi `mixed` con type casting
- Assertions per validazione runtime

### Gestione Array
- Type hints specifici per array associativi
- Commenti PHPDoc per type casting quando necessario
- Validazione delle chiavi come stringhe
- Gestione sicura degli array annidati

### Error Handling
- Assertions per validazione dei tipi
- Gestione graceful degli errori
- Messaggi di errore informativi
- Logging appropriato

## Esempi di Utilizzo

### Conversione Traduzioni
```bash
# Converti da PHP a JSON
php artisan lang:convert-php-to-json it

# Converti da JSON a PHP
php artisan lang:convert-json-to-php it
```

### Ricerca Traduzioni Mancanti
```bash
# Trova traduzioni mancanti
php artisan lang:find-missing it
```

## Best Practices

1. **Type Hints**: Utilizzare sempre type hints espliciti
2. **Mixed Types**: Gestire sempre i tipi `mixed` con type casting
3. **Assertions**: Validare i tipi con assertions appropriate
4. **Documentation**: Documentare sempre i parametri e return types

## Collegamenti Correlati

- [Translation System](./translation-system.md)
- [Lang Module Architecture](./architecture.md)
- [PHPStan Corrections](../../../docs/phpstan-fixes.md)

## Note di Sviluppo

### Correzioni PHPStan Implementate
- Aggiunti type hints specifici per array mixed
- Implementati commenti PHPDoc per type casting
- Migliorata gestione degli array annidati
- Aggiunta validazione aggiuntiva per array

### Architettura
- Comandi estendono `Illuminate\Console\Command`
- Utilizzo di assertions per validazione
- Separazione delle responsabilità per ogni comando
- Gestione appropriata degli errori
