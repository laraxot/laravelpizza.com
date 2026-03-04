# PHPStan Level 10 - Roadmap Modulo Geo

## Stato Attuale
- **Data**: 9 Gennaio 2026
- **Modulo**: Geo
- **Errori Trovati**: 13 errori
- **Livello PHPStan**: 10
- **Stato**: Non conforme

## Errori Identificati

### 1. File: `app/Actions/GetCoordinatesByAddressAction.php`
- **Linea 117**: `Variable $response in PHPDoc tag @var does not exist.`
  - **Tipo**: `varTag.variableNotFound`
  - **Descrizione**: Commento PHPDoc con variabile non esistente

### 2. File: `app/Datas/UpdateCoordinatesResult.php`
- **Linea 75**: `Method ...::getErrorMessages() should return array<int, string> but returns array<mixed>.`
  - **Tipo**: `return.type`
  - **Descrizione**: Tipo di ritorno incorretto
- **Linea 75**: `Variable $errorMessages in PHPDoc tag @var does not exist.`
  - **Tipo**: `varTag.variableNotFound`
  - **Descrizione**: Commento PHPDoc con variabile non esistente

### 3. File: `app/Models/ComuneJson.php`
- **Linea 79**: `Method ...::byRegion() should return ...Collection<int, array{...}> but returns mixed.`
- **Linea 88**: `Method ...::byProvincia() should return ...Collection<int, array{...}> but returns mixed.`
- **Linea 97**: `Method ...::byRegione() should return ...Collection<int, array{...}> but returns mixed.`
- **Linea 106**: `Method ...::byProvinciaRegione() should return ...Collection<int, array{...}> but returns mixed.`
  - **Tipo**: `return.type`
  - **Descrizione**: Metodi che non restituiscono il tipo corretto

### 4. File: `app/Services/GeoDataValidator.php`
- **Linea 88**: `Method ...::getErrors() should return array<int, string> but returns array<mixed>.`
  - **Tipo**: `return.type`
  - **Descrizione**: Tipo di ritorno incorretto

### 5. File: `app/Services/GeoService.php`
- **Linea 45**: `Method ...::getCoordinates() should return array{lat: float, lng: float}|null but returns mixed.`
- **Linea 57**: `Method ...::reverseGeocode() should return string|null but returns mixed.`
- **Linea 81**: `Method ...::getAddress() should return array<string, mixed>|null but returns mixed.`
  - **Tipo**: `return.type`
  - **Descrizione**: Metodi che non restituiscono i tipi corretti

## Pattern di Errori Identificati

### Pattern 1: PHPDoc Variable Not Found
**Descrizione**: Uso di commenti PHPDoc `@var $variablename` che fanno riferimento a variabili inesistenti nel contesto.
**File interessati**: 
- `app/Actions/GetCoordinatesByAddressAction.php`
- `app/Datas/UpdateCoordinatesResult.php`

**Soluzione**:
- Rimuovere commenti PHPDoc con variabili inesistenti
- Controllare attentamente il contesto dove vengono usati i commenti PHPDoc

### Pattern 2: Tipi di Ritorno Non Specificati o Errati
**Descrizione**: Metodi che dichiarano di restituire un tipo specifico ma in realtà restituiscono `mixed`.
**File interessati**:
- `app/Datas/UpdateCoordinatesResult.php`
- `app/Models/ComuneJson.php`
- `app/Services/GeoDataValidator.php`
- `app/Services/GeoService.php`

**Soluzione**:
- Correggere la logica per restituire il tipo dichiarato
- Aggiungere tipizzazione esplicita dove necessario
- Usare casting appropriati con Safe Cast Actions

## Piano di Correzione

### Fase 1: Correzione Errori PHPDoc Variable Not Found

#### Task 1.1: File `app/Actions/GetCoordinatesByAddressAction.php`
- **Analisi**: Trovare commento PHPDoc con `@var $response` alla linea 117
- **Correzione**: Rimuovere commento PHPDoc o correggere contesto variabile

#### Task 1.2: File `app/Datas/UpdateCoordinatesResult.php`
- **Analisi**: Trovare commento PHPDoc con `@var $errorMessages` alla linea 75
- **Correzione**: Rimuovere commento PHPDoc o correggere contesto variabile

### Fase 2: Correzione Errori Tipi di Ritorno

#### Task 2.1: File `app/Datas/UpdateCoordinatesResult.php`
- **Analisi**: Metodo `getErrorMessages()` deve ritornare `array<int, string>`
- **Correzione**: Aggiustare logica per garantire tipo corretto

#### Task 2.2: File `app/Services/GeoDataValidator.php`
- **Analisi**: Metodo `getErrors()` deve ritornare `array<int, string>`
- **Correzione**: Aggiustare logica per garantire tipo corretto

#### Task 2.3: File `app/Models/ComuneJson.php`
- **Analisi**: 4 metodi che devono ritornare `Collection<int, array{...}>` 
- **Correzione**: Aggiustare logica per garantire tipo corretto

#### Task 2.4: File `app/Services/GeoService.php`
- **Analisi**: 3 metodi con tipi di ritorno specifici
- **Correzione**: Aggiustare logica per garantire tipi corretti

## Implementazione Correzioni

### Correzione Pattern 1: PHPDoc Variable Not Found

Per ogni file con errori di tipo `varTag.variableNotFound`:
1. Identificare il commento PHPDoc problematico
2. Verificare se la variabile esiste nel contesto
3. Se la variabile non esiste, rimuovere il commento PHPDoc
4. Se la variabile esiste ma ha nome diverso, correggere il commento PHPDoc
5. Se il commento non è necessario, rimuoverlo

### Correzione Pattern 2: Tipi di Ritorno

Per ogni metodo con tipo di ritorno errato:
1. Analizzare la logica di ritorno del metodo
2. Identificare dove viene restituito `mixed` invece del tipo corretto
3. Aggiungere casting appropriati se necessario
4. Assicurarsi che tutte le vie di uscita del metodo rispettino il tipo dichiarato
5. Usare Safe Cast Actions dove appropriato per garantire type safety

## Best Practices da Applicare

1. **Type Safety**: Usare sempre casting espliciti con Safe Cast Actions
2. **PHPDoc Corretti**: Solo commenti PHPDoc con variabili esistenti
3. **Return Type Checking**: Verificare che tutti i return rispettino il tipo dichiarato
4. **Assert Usage**: Usare Webmozart Assert per validare i dati in uscita
5. **DRY + KISS**: Mantenere semplicità senza ripetere logica

## Test Post-Correzione

Dopo ogni correzione modulo:
1. Eseguire PHPStan Level 10 sul modulo Geo
2. Verificare che tutti i 13 errori siano risolti
3. Eseguire test funzionali per assicurare che le correzioni non abbiano introdotto regressioni
4. Controllare con PHPMD e PHPInsights
5. Fare commit delle correzioni

## Successo di questa Implementazione

✅ **0 errori PHPStan Level 10** nel modulo Geo
✅ **Type safety garantita** per tutte le operazioni geografiche
✅ **Documentazione aggiornata** con pattern di correzione
✅ **Logica funzionale mantenuta** senza regressioni