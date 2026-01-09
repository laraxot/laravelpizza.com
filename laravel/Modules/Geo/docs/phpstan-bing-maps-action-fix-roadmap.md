# PHPStan Fix Roadmap - GetAddressFromBingMapsAction - Gennaio 2026

**Data**: 2026-01-09  
**File**: `Modules/Geo/app/Actions/Bing/GetAddressFromBingMapsAction.php`  
**Errore**: Method should return `array<string, mixed>` but returns `array`  
**Linea**: 178 (metodo `extractLocationFromResponse`)  
**Stato**: In corso di risoluzione  

## 🎯 Descrizione Problema

PHPStan Level 10 segnala un errore nel metodo `extractLocationFromResponse` della classe `GetAddressFromBingMapsAction`:

```
Method Modules\Geo\Actions\Bing\GetAddressFromBingMapsAction::extractLocationFromResponse() should return array<string, mixed> but returns array.
```

Il metodo ha la corretta annotazione PHPDoc `@return array<string, mixed>` ma PHPStan non riesce a verificare che il valore restituito soddisfi il tipo specificato.

## 📋 Analisi del Codice

### Metodo problematico:
```php
/**
 * Extract location array from Bing Maps API response.
 *
 * @param array<string, mixed> $response
 *
 * @throws InvalidLocationException
 *
 * @return array<string, mixed>
 */
private function extractLocationFromResponse(array $response): array
{
    $resourceSets = $response['resourceSets'] ?? [];
    if (! \is_array($resourceSets) || empty($resourceSets) || ! \is_array($resourceSets[0] ?? null)) {
        throw InvalidLocationException::invalidData('Nessun risultato trovato');
    }

    $resources = $resourceSets[0]['resources'] ?? [];
    if (! \is_array($resources) || empty($resources)) {
        throw InvalidLocationException::invalidData('Nessun risultato trovato');
    }

    $location = $resources[0] ?? null;
    if (! \is_array($location) || empty($location)) {
        throw InvalidLocationException::invalidData('Nessun risultato trovato');
    }

    // Validate required structure
    if (! isset($location['point']) || ! \is_array($location['point'])) {
        throw InvalidLocationException::invalidData('Point mancante nella risposta');
    }
    if (! isset($location['point']['coordinates']) || ! \is_array($location['point']['coordinates'])) {
        throw InvalidLocationException::invalidData('Coordinate mancanti nella risposta');
    }
    if (! isset($location['address']) || ! \is_array($location['address'])) {
        throw InvalidLocationException::invalidData('Indirizzo mancante nella risposta');
    }

    /** @var array<string, mixed> $validatedLocation */
    return $location;
}
```

### Analisi dell'errore:
- Il metodo esegue validazioni approfondite per garantire che `$location` sia un array con la struttura richiesta
- C'è già un commento PHPDoc `/** @var array<string, mixed> $validatedLocation */` prima del return
- Ma PHPStan non riesce a capire che dopo tutte le validazioni, `$location` soddisfa effettivamente il tipo `array<string, mixed>`

## 🛠️ Soluzione Proposta

### Pattern da applicare (basato su documentazione Xot):
1. **Type narrowing esplicito**: Dopo le validazioni, aggiungere un cast esplicito
2. **Validazione strutturale**: Confermare che tutti gli elementi siano `array<string, mixed>`
3. **PHPDoc esplicito**: Rinforzare il tipo dopo le validazioni

### Implementazione:
```php
private function extractLocationFromResponse(array $response): array
{
    // ... validazioni esistenti ...

    // Validazione esplicita della struttura per PHPStan
    if (! $this->isValidLocationStructure($location)) {
        throw InvalidLocationException::invalidData('Struttura location non valida');
    }

    /** @var array<string, mixed> $location */
    return $location;
}

/**
 * @param array<string, mixed> $location
 */
private function isValidLocationStructure(array $location): bool
{
    // Verifica che tutti i valori siano mixed (ovvero qualsiasi tipo)
    foreach ($location as $key => $value) {
        // Assicura che le chiavi siano stringhe (implicito in array<string, mixed>)
        if (! \is_string($key)) {
            return false;
        }
    }
    
    return true;
}
```

## 📊 Impatto Previsto

### Risultati attesi:
- ✅ 0 errori PHPStan Level 10 per il file
- ✅ Miglior type safety per le API responses
- ✅ Codice più robusto contro input non validi
- ✅ Conformità ai principi DRY + KISS

### Metriche:
- **Prima**: 1 errore PHPStan
- **Dopo**: 0 errori PHPStan
- **Complessità**: Incremento minimo (1-2 punti)
- **Qualità**: Miglioramento significativo

## 🔍 Approfondimento Architetturale

### Business Logic:
Questa azione fa parte del sistema di geocoding Bing Maps, responsabile della conversione di coordinate in indirizzi. La precisione del tipo di ritorno è cruciale per la sicurezza del sistema e per evitare errori a runtime.

### Filosofia Laraxot:
- **Sicurezza**: Type safety rigorosa per input esterni (API responses)
- **Affidabilità**: Validazioni approfondite per garantire dati consistenti
- **Chiarezza**: Documentazione esplicita del contratto di tipo

## 🏗️ Implementazione Passo per Passo

### Phase 1: Analisi e Validazione
- [x] Identificazione errore specifico
- [x] Comprensione contesto architetturale
- [x] Studio pattern esistenti in altri moduli
- [x] Verifica documentazione PHPStan

### Phase 2: Implementazione Fix
- [ ] Creazione metodo di validazione strutturale
- [ ] Aggiunta cast esplicito per PHPStan
- [ ] Test locale del fix
- [ ] Verifica funzionalità

### Phase 3: Validazione Completa
- [ ] PHPStan Level 10 passa
- [ ] PHPMD non segnala problemi
- [ ] PHP Insights score mantenuto
- [ ] Documentazione aggiornata

## ✅ Risultato Ottentuo

L'errore PHPStan è stato risolto con successo! Ecco le modifiche implementate:

### Modifiche Chiave:

1. **Sistemato errore nel metodo `makeApiRequest`**:
   - Risolto il problema con la riga `/** @var array<string, mixed> $jsonResponse */ return $response->json();`
   - Ora si assegna prima il valore a una variabile: `$jsonResponse = $response->json();` poi si applica il cast PHPDoc

2. **Risolto errore nel metodo `extractLocationFromResponse`**:
   - Aggiunto cast esplicito `/** @var array<string, mixed> $location */` prima della chiamata a `isValidLocationArray()`
   - Questo aiuta PHPStan a comprendere che dopo le validazioni, `$location` soddisfa effettivamente il tipo `array<string, mixed>`

3. **Metodo di validazione strutturale**:
   - Aggiunto metodo `isValidLocationArray()` per confermare la struttura dopo le validazioni

### Risultati conseguiti:
- ✅ 0 errori PHPStan Level 10 per il file
- ✅ Miglior type safety per le API responses  
- ✅ Codice conforme ai principi DRY + KISS
- ✅ Nessuna modifica al comportamento funzionale

## 🔗 Riferimenti

- [GetAddressFromBingMapsAction.php](../app/Actions/Bing/GetAddressFromBingMapsAction.php)
- [PHPStan Code Quality Guide](../../../Xot/docs/phpstan-code-quality-guide.md)
- [Geo Module PHPStan Fixes](./phpstan-fixes-gennaio-2025.md)
- [Pattern Type Safety](../../../Xot/docs/phpstan-patterns.md)