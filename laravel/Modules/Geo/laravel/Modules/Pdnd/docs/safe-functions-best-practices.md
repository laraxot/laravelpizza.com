# Safe Functions Best Practices - Modulo Pdnd

## Libreria thecodingmachine/safe

Il modulo utilizza la libreria `thecodingmachine/safe` per gestire funzioni PHP che possono fallire silenziosamente ritornando `false` invece di lanciare eccezioni.

## Pattern Corretto

### ✅ Uso con Prefix \Safe\

**SEMPRE usare il prefix completo `\Safe\` invece di import function**:

```php
// ✅ CORRETTO
$cleaned = \Safe\preg_replace('/pattern/', 'replacement', $input);
$array = \Safe\json_decode($jsonString, true);
$json = \Safe\json_encode($data, JSON_PRETTY_PRINT);
$content = \Safe\file_get_contents($path);
```

### ❌ Pattern da Evitare

```php
// ❌ ERRATO - Import poi uso semplice
use function Safe\preg_replace;
use function Safe\json_decode;

$cleaned = preg_replace('/pattern/', 'replacement', $input);
$array = json_decode($jsonString, true);
```

## Motivazioni

1. **Esplicitezza**: Il prefix `\Safe\` rende immediatamente chiaro che si sta usando la versione sicura
2. **PHPStan**: PHPStan riconosce meglio il tipo di ritorno con prefix esplicito
3. **Consistenza**: Evita confusione tra funzioni native e safe
4. **Portabilità**: Non dipende da import specifici nel file

## Funzioni Safe Utilizzate nel Modulo

### 1. \Safe\preg_replace()

**Uso**: Sanitizzazione ID ANPR e risultati verifica

```php
// Sanitizzazione ID ANPR
$idAnprValue = $risultato['lista_soggetti'][0]['id_anpr'] ?? 'N/A';
$cleaned = \Safe\preg_replace('/[^\w\s-]/', '', (string) $idAnprValue);
$this->idAnpr = $cleaned;

// Sanitizzazione risultato verifica
$risultatoVerifica = $risposta['valore']->value ?? 'N/A';
$cleanedRisultato = \Safe\preg_replace('/[^\w\s-]/', '', (string) $risultatoVerifica);
$this->risultatoVerifica = $cleanedRisultato;
```

**Perché**: `preg_replace()` può ritornare `null` in caso di errore PCRE. La versione Safe lancia eccezione.

### 2. \Safe\json_decode()

**Uso**: Parsing response body da ANPR

```php
// Type casting preventivo + Safe function
$bodyStr = is_string($response['body'] ?? '') ? $response['body'] : '{}';

/** @var array<string, mixed> $responseArray */
$responseArray = \Safe\json_decode($bodyStr, true);
```

**Perché**: `json_decode()` può ritornare `null` per JSON malformato. La versione Safe lancia `JsonException`.

### 3. \Safe\json_encode()

**Uso**: Formattazione pretty-print di response JSON

```php
$decodedBody = \Safe\json_decode($responseBody, true);
if (is_array($decodedBody)) {
    $responseBody = \Safe\json_encode($decodedBody, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
```

**Perché**: `json_encode()` può ritornare `false` per dati non serializzabili. La versione Safe lancia `JsonException`.

## Type Casting con Safe Functions

### Pattern Completo

```php
// 1. Estrai valore da array mixed
$rawValue = $data['field'] ?? '';

// 2. Type casting esplicito
$stringValue = is_string($rawValue) ? $rawValue : '';

// 3. Safe function
$result = \Safe\preg_replace('/pattern/', 'replacement', $stringValue);

// 4. Assegnazione
$this->property = $result;
```

### Pattern Compatto (quando possibile)

```php
// Se il valore è già string-safe
$cleaned = \Safe\preg_replace('/[^\w\s-]/', '', (string) $idAnprValue);
$this->idAnpr = $cleaned;
```

## Gestione Errori

### Eccezioni Lanciate

Le Safe functions lanciano eccezioni specifiche:
- `\Safe\Exceptions\PcreException` per errori PCRE
- `\Safe\Exceptions\JsonException` per errori JSON
- `\Safe\Exceptions\FilesystemException` per errori file

### Catching Specifico

```php
use Safe\Exceptions\PcreException;
use Safe\Exceptions\JsonException;

try {
    $cleaned = \Safe\preg_replace('/pattern/', 'replacement', $input);
} catch (PcreException $e) {
    Log::error('Errore PCRE: ' . $e->getMessage());
    $cleaned = ''; // Fallback
}

try {
    $data = \Safe\json_decode($jsonString, true);
} catch (JsonException $e) {
    Log::error('JSON malformato: ' . $e->getMessage());
    $data = []; // Fallback
}
```

### Catching Generico

Nel modulo Pdnd, si usa catch generico `Exception` che cattura anche le Safe exceptions:

```php
try {
    $state = $pdndFormObj->getState();
    $cfValue = is_string($state['codiceFiscale'] ?? '') ? $state['codiceFiscale'] : '';
    $cleaned = \Safe\preg_replace('/[^\w\s-]/', '', $cfValue);
    // ...
} catch (Exception $e) {
    Log::error('Errore in send(): ' . $e->getMessage());
    $this->idAnpr = 'Errore imprevisto';
}
```

## Verifiche PHPStan

### Configurazione
PHPStan è configurato con l'estensione Safe:
```neon
includes:
    - ./vendor/thecodingmachine/phpstan-safe-rule/phpstan-safe-rule.neon
```

### Errori Rilevati
PHPStan segnala uso di funzioni unsafe con:
```
Function preg_replace is unsafe to use. It can return FALSE instead of 
throwing an exception. Please add 'use function Safe\preg_replace;' at 
the beginning of the file to use the variant provided by the 
'thecodingmachine/safe' library.
```

**Soluzione**: Usare `\Safe\preg_replace()` con prefix esplicito.

## Checklist Safe Functions

Prima di committare codice che usa funzioni potenzialmente unsafe:

- [ ] Identificare funzioni che possono ritornare `false` o `null`
- [ ] Sostituire con versione `\Safe\` equivalente
- [ ] Usare prefix `\Safe\` diretto (non `use function`)
- [ ] Aggiungere type casting preventivo per valori mixed
- [ ] Gestire eccezioni Safe nel catch generico
- [ ] Verificare con PHPStan livello 9

## Funzioni Comuni Safe vs Unsafe

| Unsafe | Safe | Eccezione |
|--------|------|-----------|
| `preg_replace()` | `\Safe\preg_replace()` | `PcreException` |
| `json_decode()` | `\Safe\json_decode()` | `JsonException` |
| `json_encode()` | `\Safe\json_encode()` | `JsonException` |
| `file_get_contents()` | `\Safe\file_get_contents()` | `FilesystemException` |
| `file_put_contents()` | `\Safe\file_put_contents()` | `FilesystemException` |
| `unlink()` | `\Safe\unlink()` | `FilesystemException` |

Vedi [documentazione completa Safe library](https://github.com/thecodingmachine/safe)

## Collegamenti
- [thecodingmachine/safe](https://github.com/thecodingmachine/safe)
- [PHPStan Safe Rule](https://github.com/thecodingmachine/phpstan-safe-rule)
- [Fix PHPStan Completi](./phpstan-complete-fixes.md)

*Ultimo aggiornamento: 1 Ottobre 2025*

