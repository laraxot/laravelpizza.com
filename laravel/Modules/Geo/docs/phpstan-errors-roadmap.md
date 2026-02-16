# PHPStan Level Max Errors Roadmap - Geo Module

**Modulo**: Geo
**Livello PHPStan**: max (Level 10)
**Status**: 🚧 **REGRESSION DETECTED** (was 0 errors, now 8)

---

## 📊 Errori Identificati

### Totale Errori: 8

**TUTTI gli errori sono di tipo `return.type`** - Type narrowing necessario

### Breakdown per File:

1. **GetAddressFromBingMapsAction.php** (1 errore - Line 185)
   - **Errore**: `extractLocationFromResponse()` dovrebbe ritornare `array<string, mixed>` ma ritorna `array`
   - **Causa**: Type hint generico, PHPStan non può inferire la shape
   - **Priorità**: MEDIA

2. **UpdateCoordinatesResult.php** (1 errore - Line 79)
   - **Errore**: `getErrorMessages()` dovrebbe ritornare `array<int, string>` ma ritorna `array<mixed>`
   - **Causa**: Array values non tipizzati correttamente
   - **Priorità**: MEDIA

3. **ComuneJson.php** (4 errori - Lines 97, 133, 165, 393)
   - **Errore 1 (Line 97)**: `byRegion()` dovrebbe ritornare `Collection<int, array{...}>` ma ritorna `mixed`
   - **Errore 2 (Line 133)**: `byProvince()` dovrebbe ritornare `Collection<int, array{...}>` ma ritorna `mixed`
   - **Errore 3 (Line 165)**: `searchByName()` dovrebbe ritornare `Collection<int, array{...}>` ma ritorna `mixed`
   - **Errore 4 (Line 393)**: `getGerarchia()` dovrebbe ritornare `array{...}|null` ma ritorna `mixed`
   - **Causa**: Metodi che ritornano valori da cache/configurazione senza type narrowing
   - **Priorità**: ALTA (modello core geografico)

4. **GeoDataService.php** (1 errore - Line 235)
   - **Errore**: `loadData()` dovrebbe ritornare `Collection<int, array<string, mixed>>` ma ritorna `Collection<int, mixed>`
   - **Causa**: Collection generics non preservati
   - **Priorità**: ALTA (service centrale)

5. **GeoDataValidator.php** (1 errore - Line 90)
   - **Errore**: `getErrors()` dovrebbe ritornare `array<string, array<int, string>>` ma ritorna `array`
   - **Causa**: Nested array shape non specificata
   - **Priorità**: MEDIA

---

## 🧠 Analisi Approfondita

### Pattern 1: Array Shape Non Specificata

**Problema**: PHPStan richiede array shapes specifiche, non solo `array`.

**Esempio Tipico**:
```php
// ❌ SBAGLIATO
public function getData(): array
{
    return $this->data;  // PHPStan: "ritorna array" non "array<string, mixed>"
}

// ✅ CORRETTO
public function getData(): array
{
    $data = $this->data;
    Assert::isArray($data);
    /** @var array<string, mixed> $data */
    return $data;
}
```

### Pattern 2: Collection Generics Persi

**Problema**: Collection methods perdono type information durante chain.

**Esempio Tipico**:
```php
// ❌ SBAGLIATO
public function getItems(): Collection
{
    return collect($this->items)->filter(...);  // Ritorna Collection<int, mixed>
}

// ✅ CORRETTO
public function getItems(): Collection
{
    $items = collect($this->items)->filter(...);
    Assert::isInstanceOf($items, Collection::class);
    /** @var Collection<int, array{id: int, name: string}> $items */
    return $items;
}
```

### Pattern 3: Mixed dalla Cache/Config

**Problema**: `config()`, `cache()->get()`, etc. ritornano `mixed`.

**Esempio Tipico**:
```php
// ❌ SBAGLIATO
public function getRegions(): Collection
{
    return cache()->get('regions');  // Ritorna mixed
}

// ✅ CORRETTO
public function getRegions(): Collection
{
    $regions = cache()->get('regions');
    Assert::isInstanceOf($regions, Collection::class);
    /** @var Collection<int, array{nome: string, codice: string}> $regions */
    return $regions;
}
```

---

## ⚔️ Litigata Interna e Vincitore

### 👹 Voce A - Pragmatica (Fix Veloce)

**Argomenti**:
- Sono solo 8 errori di tipo, non bug reali
- Il codice funziona, è solo PHPStan troppo rigido
- Aggiungiamo `@phpstan-ignore` e via

**Contro**:
- Type safety è importante per prevenire bug
- Nascondere errori crea debito tecnico
- Altri sviluppatori potrebbero introdurre nuovi bug

### 🦸 Voce B - Rigorosa (Type Safety Completa)

**Argomenti**:
- Type safety previene bug runtime
- PHPStan Level 10 è uno standard da mantenere
- Documentare i fix aiuta altri sviluppatori/agenti
- Assert + PHPDoc corretti migliorano intellisense

**Contro**:
- Richiede più tempo
- Potrebbe sembrare verboso
- Necessita testing per verificare fix

### 🧘 Voce C - Architettonica (Processo Continuo)

**Argomenti**:
- Il problema non è il codice, è il processo
- Serve CI/CD con PHPStan check
- Documentare pattern per evitare regressioni
- Creare helpers per type narrowing comuni

**Contro**:
- Implementare CI/CD richiede setup
- Pattern potrebbero non coprire tutti i casi

### 🏆 VINCITORE: Voce B + C (Type Safety + Processo)

**Motivazione**:
1. **Correttezza**: Fixare gli 8 errori con type narrowing corretto
2. **Documentazione**: Aggiornare compliance status + creare questa roadmap
3. **Pattern**: Documentare pattern per evitare regressioni future
4. **Testing**: Validare ogni fix con phpstan + tests
5. **Processo**: Suggerire CI/CD check (senza implementarlo ora)

---

## 📋 Piano di Correzione

### 🎯 Strategia Generale

Per ogni errore, applichiamo questo pattern:
1. Leggere il codice attuale
2. Identificare dove il type viene perso
3. Aggiungere Assert per type narrowing
4. Aggiungere PHPDoc per array shapes/generics complessi
5. Verificare con PHPStan
6. Testing manuale/automatico

### Fase 1: GeoDataService.php (PRIORITÀ ALTA)

**File**: `Geo/app/Services/GeoDataService.php`
**Line**: 235
**Errore**: `loadData()` ritorna `Collection<int, mixed>` invece di `Collection<int, array<string, mixed>>`

**Soluzione**:
```php
public function loadData(): Collection
{
    $data = collect($this->source)->map(function ($item) {
        // Ensure each item is array<string, mixed>
        Assert::isArray($item);
        /** @var array<string, mixed> $item */
        return $item;
    });

    /** @var Collection<int, array<string, mixed>> $data */
    return $data;
}
```

### Fase 2: ComuneJson.php (PRIORITÀ ALTA - 4 errori)

**File**: `Geo/app/Models/ComuneJson.php`
**Lines**: 97, 133, 165, 393

**Problema Comune**: Metodi che leggono da cache/config ritornano `mixed`

**Soluzione Tipo per `byRegion()`** (Line 97):
```php
public function byRegion(string $regionCode): Collection
{
    $data = cache()->get("comuni.region.{$regionCode}");
    Assert::isInstanceOf($data, Collection::class);

    /**
     * @var Collection<int, array{
     *   nome: string,
     *   codice: string,
     *   regione: array{codice: string, nome: string},
     *   provincia: array{codice: string, nome: string},
     *   cap: array<int, string>,
     *   codiceCatastale: string,
     *   popolazione: int
     * }> $data
     */
    return $data;
}
```

**Ripetere pattern per**:
- `byProvince()` (Line 133)
- `searchByName()` (Line 165)
- `getGerarchia()` (Line 393) - ritorna `array{...}|null`

### Fase 3: GetAddressFromBingMapsAction.php (MEDIA)

**File**: `Geo/app/Actions/Bing/GetAddressFromBingMapsAction.php`
**Line**: 185
**Errore**: `extractLocationFromResponse()` ritorna `array` invece di `array<string, mixed>`

**Soluzione**:
```php
private function extractLocationFromResponse(array $response): array
{
    $location = $response['resourceSets'][0]['resources'][0]['point']['coordinates'] ?? [];
    Assert::isArray($location);

    /** @var array<string, mixed> $location */
    return $location;
}
```

### Fase 4: UpdateCoordinatesResult.php (MEDIA)

**File**: `Geo/app/Datas/UpdateCoordinatesResult.php`
**Line**: 79
**Errore**: `getErrorMessages()` ritorna `array<mixed>` invece di `array<int, string>`

**Soluzione**:
```php
public function getErrorMessages(): array
{
    $errors = array_values(array_filter($this->errors, 'is_string'));
    Assert::allString($errors);

    /** @var array<int, string> $errors */
    return $errors;
}
```

### Fase 5: GeoDataValidator.php (MEDIA)

**File**: `Geo/app/Services/GeoDataValidator.php`
**Line**: 90
**Errore**: `getErrors()` ritorna `array` invece di `array<string, array<int, string>>`

**Soluzione**:
```php
public function getErrors(): array
{
    $errors = $this->errors;
    Assert::isArray($errors);

    // Ensure each value is array<int, string>
    foreach ($errors as $key => $value) {
        Assert::string($key);
        Assert::isArray($value);
        Assert::allString($value);
    }

    /** @var array<string, array<int, string>> $errors */
    return $errors;
}
```

---

## ✅ Checklist Implementazione

### Fase 1: GeoDataService
- [ ] Leggere codice attuale (line 235)
- [ ] Implementare type narrowing con Assert
- [ ] Aggiungere PHPDoc per Collection generics
- [ ] Verificare PHPStan: `./vendor/bin/phpstan analyse Geo/app/Services/GeoDataService.php`
- [ ] Testing manuale: verificare che loadData() funzioni correttamente

### Fase 2: ComuneJson
- [ ] byRegion() (line 97) - Assert + PHPDoc
- [ ] byProvince() (line 133) - Assert + PHPDoc
- [ ] searchByName() (line 165) - Assert + PHPDoc
- [ ] getGerarchia() (line 393) - Assert + PHPDoc
- [ ] Verificare PHPStan: `./vendor/bin/phpstan analyse Geo/app/Models/ComuneJson.php`
- [ ] Testing: verificare queries geografiche

### Fase 3-5: Altri File
- [ ] GetAddressFromBingMapsAction.php (line 185)
- [ ] UpdateCoordinatesResult.php (line 79)
- [ ] GeoDataValidator.php (line 90)
- [ ] Verificare PHPStan per ogni file
- [ ] Testing: verificare funzionalità

### Validazione Finale
- [ ] PHPStan: `./vendor/bin/phpstan analyse Modules/Geo --memory-limit=-1`
- [ ] PHPMD: `./vendor/bin/phpmd Modules/Geo text codesize,unusedcode`
- [ ] PHPInsights: `./vendor/bin/phpinsights analyse Modules/Geo`
- [ ] Pint: `./vendor/bin/pint Modules/Geo --dirty`
- [ ] Tests: `php artisan test --filter=Geo`

### Documentazione
- [ ] Aggiornare `phpstan-compliance-status.md`
- [ ] Documentare pattern in questo file
- [ ] Creare `type-narrowing-patterns.md` per futuri sviluppatori
- [ ] Commit con messaggio dettagliato

---

## 🎯 Obiettivi Finali

1. ✅ **Zero Errori PHPStan Level Max** - Ritorno a compliance completa
2. ✅ **Type Safety Documentata** - Pattern chiari per mantenere compliance
3. ✅ **Process Improvement** - Roadmap come guida per evitare regressioni
4. ✅ **Testing Completo** - Funzionalità geografiche verificate
5. ✅ **Documentation Updated** - Compliance status aggiornato

---

## 📚 Pattern e Best Practices

### Type Narrowing con Webmozart Assert

**Installazione**:
```bash
composer require webmozart/assert
```

**Import**:
```php
use Webmozart\Assert\Assert;
```

**Pattern Comuni**:
```php
// Array
Assert::isArray($data);

// Collection
Assert::isInstanceOf($data, Collection::class);

// String array
Assert::allString($array);

// Nullable
if ($data === null) {
    return null;
}
Assert::isArray($data);
```

### PHPDoc per Generics Complessi

**Collection**:
```php
/** @var Collection<int, array{id: int, name: string}> $items */
```

**Array Multidimensionale**:
```php
/** @var array<string, array<int, string>> $errors */
```

### Evitare `mixed` Ritornato da Helpers

**Cache**:
```php
$data = cache()->get('key');  // mixed
Assert::isArray($data);       // now array
```

**Config**:
```php
$config = config('app.key');  // mixed
Assert::string($config);      // now string
```

---

## 🔗 Collegamenti

- [PHPStan Level 10 Documentation](https://phpstan.org/blog/phpstan-1-0-0-released)
- [Webmozart Assert](https://github.com/webmozart/assert)
- [Laravel Collections Type Safety](https://laravel.com/docs/11.x/collections)
- [Compliance Status](./phpstan-compliance-status.md) (da aggiornare)

---

## 💡 Note per Sviluppatori/Agenti

### Quando Aggiungi Nuovo Codice Geo

1. **Sempre tipizzare array shapes** - Non usare solo `array`
2. **Collection generics** - Specifica cosa contiene
3. **Assert dopo mixed sources** - Cache, config, DB queries
4. **PHPStan before commit** - Verifica compliance
5. **Aggiorna questa roadmap** - Se trovi nuovi pattern

### Quando Trovi Nuovi Errori

1. **Categorizza** - return.type, param.type, property.type?
2. **Identifica Pattern** - È un problema ricorrente?
3. **Documenta Soluzione** - Aggiungi esempio in questa roadmap
4. **Fix + Test** - Implementa e verifica
5. **Update Compliance Status** - Mantieni docs aggiornati

---

**Status**: 🚧 **IN PROGRESS**

**Priorità Assoluta**: Ripristinare compliance PHPStan Level Max (0 errori)

**Ultimo aggiornamento**: [DATE]

**Autore**: Claude Code (Sonnet 4.5)

**Revisione**: Required after all fixes implemented
