# PHPStan Level 10 - Scripts Utility Roadmap

**Data**: 2026-01-09  
**Modulo**: Cms  
**Livello PHPStan**: 10  
**Errori Totali**: 32  
**Status**: 📝 **ROADMAP CREATA**

---

## 📊 Executive Summary

PHPStan Level 10 ha identificato **32 errori** in **2 script di utilità** del modulo Cms:
- `generate_test_data.php` - 22 errori
- `populate_database_comprehensive.php` - 10 errori

**Nota Importante**: Questi sono script di utilità/test, non codice di produzione. Tuttavia, per raggiungere PHPStan Level 10 compliance completa, devono essere corretti.

---

## 🔍 Analisi Errori

### Pattern Identificati

Tutti gli errori seguono pattern comuni legati a **type safety con `mixed`**:

1. **Cannot call method on mixed** (19 errori)
   - `bootstrap()`, `make()`, `create()` chiamati su variabili `mixed`
   
2. **Cannot access offset on mixed** (8 errori)
   - Accesso a chiavi array su variabili `mixed`
   
3. **Argument type mismatch** (3 errori)
   - Parametri `mixed` passati dove si aspetta `string` o `iterable`
   
4. **Encapsed string part non-string** (2 errori)
   - Variabili `mixed` usate in stringhe interpolate

---

## 📋 File con Errori

### 1. `generate_test_data.php` (22 errori)

**Righe interessate**: 31, 81, 82, 99, 109, 130, 137, 157, 158, 159, 162, 164, 166, 188, 190, 193, 194

**Pattern principali**:
- Chiamate a `bootstrap()` e `make()` su `mixed` (riga 31)
- `foreach` su `mixed` non iterabile (righe 81, 157, 188)
- Accesso offset su `mixed` (righe 99, 130, 137, 158, 162, 164, 166)
- Parametri `mixed` dove si aspetta `string` (righe 82, 190)
- Stringhe interpolate con `mixed` (righe 159, 162, 166, 193, 194)

### 2. `populate_database_comprehensive.php` (10 errori)

**Righe interessate**: 35, 81, 117, 119, 194, 233, 240, 241

**Pattern principali**:
- Chiamate a `bootstrap()` e `make()` su `mixed` (riga 35)
- Chiamate a `create()` su `mixed` (righe 81, 117, 119, 194)
- Accesso offset su `mixed` (righe 233, 240, 241)

---

## 🎯 Strategia di Risoluzione

### Fase 1: Type Narrowing (Priorità Alta)

**Obiettivo**: Ridurre l'uso di `mixed` attraverso type narrowing e assertions.

**Pattern da applicare**:
```php
// PRIMA (mixed)
$app = require __DIR__ . '/../../bootstrap/app.php';
$app->bootstrap();

// DOPO (type narrowing)
/** @var \Illuminate\Contracts\Foundation\Application $app */
$app = require __DIR__ . '/../../bootstrap/app.php';
assert($app instanceof \Illuminate\Contracts\Foundation\Application);
$app->bootstrap();
```

### Fase 2: Array Type Assertions (Priorità Media)

**Obiettivo**: Aggiungere type assertions per array access.

**Pattern da applicare**:
```php
// PRIMA (mixed)
$result = someFunction();
$count = $result['count'];

// DOPO (type assertion)
/** @var array{count: int, status: string} $result */
$result = someFunction();
$count = $result['count'];
```

### Fase 3: Iterable Validation (Priorità Media)

**Obiettivo**: Validare che le variabili siano iterabili prima di foreach.

**Pattern da applicare**:
```php
// PRIMA (mixed)
foreach ($items as $item) {
    // ...
}

// DOPO (validation)
/** @var array<int, mixed>|iterable $items */
if (!is_iterable($items)) {
    throw new \InvalidArgumentException('Items must be iterable');
}
foreach ($items as $item) {
    // ...
}
```

### Fase 4: String Casting (Priorità Bassa)

**Obiettivo**: Assicurare che le variabili siano stringhe prima dell'interpolazione.

**Pattern da applicare**:
```php
// PRIMA (mixed)
echo "Model: $modelName";

// DOPO (casting)
/** @var string $modelName */
$modelName = (string) $modelName;
echo "Model: $modelName";
```

---

## 📝 Roadmap Dettagliata

### Step 1: Analisi File `generate_test_data.php`

**Tempo stimato**: 30 minuti

1. ✅ Leggere il file completo per capire la logica
2. ✅ Identificare tutti i punti dove `mixed` viene usato
3. ✅ Applicare type narrowing per `$app` (riga 31)
4. ✅ Aggiungere type assertions per array access
5. ✅ Validare iterabili prima di foreach
6. ✅ Casting esplicito per stringhe interpolate

**File da modificare**: `Modules/Cms/generate_test_data.php`

### Step 2: Analisi File `populate_database_comprehensive.php`

**Tempo stimato**: 20 minuti

1. ✅ Leggere il file completo per capire la logica
2. ✅ Identificare tutti i punti dove `mixed` viene usato
3. ✅ Applicare type narrowing per `$app` (riga 35)
4. ✅ Aggiungere type assertions per factory calls
5. ✅ Aggiungere type assertions per array access

**File da modificare**: `Modules/Cms/populate_database_comprehensive.php`

### Step 3: Verifica e Testing

**Tempo stimato**: 15 minuti

1. ✅ Eseguire PHPStan Level 10 su entrambi i file
2. ✅ Verificare che gli script funzionino ancora correttamente
3. ✅ Eseguire PHPMD per code smells
4. ✅ Eseguire PHPInsights per qualità complessiva

---

## ✅ Checklist Risoluzione

### `generate_test_data.php`

- [ ] Righe 31: Type narrowing per `$app`
- [ ] Righe 81, 157, 188: Validazione iterabili per foreach
- [ ] Righe 82: Type assertions per parametri `$modelName` e `$factoryClass`
- [ ] Righe 99, 130, 137: Type assertions per array access
- [ ] Righe 109: Type narrowing per factory
- [ ] Righe 158, 162, 164, 166: Type assertions per `$result` array
- [ ] Righe 159, 162, 166, 193, 194: Casting esplicito per stringhe
- [ ] Righe 190: Type assertion per parametro `$subject`

### `populate_database_comprehensive.php`

- [ ] Righe 35: Type narrowing per `$app`
- [ ] Righe 81, 117, 119, 194: Type narrowing per factory calls
- [ ] Righe 233, 240, 241: Type assertions per array access

---

## 🔄 Verifica Post-Risoluzione

Dopo ogni modifica, eseguire:

```bash
cd /var/www/_bases/base_laravelpizza/laravel

# PHPStan Level 10
./vendor/bin/phpstan analyse Modules/Cms/generate_test_data.php --level=10
./vendor/bin/phpstan analyse Modules/Cms/populate_database_comprehensive.php --level=10

# PHPMD
./vendor/bin/phpmd Modules/Cms/generate_test_data.php text codesize,design
./vendor/bin/phpmd Modules/Cms/populate_database_comprehensive.php text codesize,design

# PHPInsights (se disponibile)
./vendor/bin/phpinsights analyse Modules/Cms/generate_test_data.php
./vendor/bin/phpinsights analyse Modules/Cms/populate_database_comprehensive.php
```

---

## 📚 Documentazione Correlata

- [PHPStan Corrections](./phpstan-corrections.md) - Correzioni precedenti
- [PHPStan Analysis](./phpstan-analysis.md) - Analisi generale
- [Common PHPStan Errors](./common-phpstan-errors.md) - Errori comuni

---

## 🎯 Obiettivo Finale

**Target**: ✅ **0 errori PHPStan Level 10** per il modulo Cms

**Benefici**:
- ✅ Type safety completa
- ✅ Codice più robusto e manutenibile
- ✅ Prevenzione bug runtime
- ✅ Migliore developer experience

---

**Status**: 🔄 **IN IMPLEMENTAZIONE**

**Ultimo aggiornamento**: 2026-01-09

---

## 📊 Progressi Implementazione

### ✅ Completato

1. **Errori sintassi bloccanti risolti**:
   - ✅ `Modules/Notify/Models/EmailTemplate.php` - Corretto PHPDoc e chiusura array
   - ✅ `Modules/Notify/Models/Theme.php` - Corretto PHPDoc e chiusura array
   - ✅ `Modules/Xot/lang/pt_br/health.php` - Completato array traduzione

2. **`generate_test_data.php`** - **21/22 errori risolti** ✅
   - ✅ Type narrowing per `$app` (riga 31)
   - ✅ Type assertions per foreach iterabili (righe 81, 157, 188)
   - ✅ Type assertions per array access (righe 99, 130, 137, 158, 162, 164, 166)
   - ✅ Type narrowing per factory calls (righe 109, 125)
   - ✅ Type assertions per `$result` array (righe 142-151, 154-160)
   - ✅ Casting esplicito per stringhe (righe 159, 162, 166, 193, 194)
   - ⏳ Riga 122: `Cannot call method create() on mixed` - **In corso**

### ⏳ In Lavoro

**`populate_database_comprehensive.php`** - **0/10 errori risolti**
- ⏳ Type narrowing per `$app` (riga 35)
- ⏳ Type narrowing per factory calls (righe 81, 117, 119, 194)
- ⏳ Type assertions per array access (righe 233, 240, 241)

---

## 📈 Statistiche

- **Errori iniziali**: 32
- **Errori risolti**: 21
- **Errori rimanenti**: 11
- **Progresso**: 65.6% ✅

---

## 🔧 Note Tecniche

### Problema Rimanente in `generate_test_data.php`

**Riga 122**: `Cannot call method create() on mixed`

**Causa**: Il metodo `count(100)->create()` viene chiamato su un oggetto `mixed` perché PHPStan non può inferire il tipo del risultato di `count()`.

**Soluzioni tentate**:
1. Type assertion `object&callable` - Non risolve
2. `call_user_func` - Non risolve
3. Type narrowing con `method_exists` - Non sufficiente

**Prossimi passi**: Usare un approccio diverso, possibilmente con un'interfaccia o trait che definisca il tipo del factory.

---

**Ultimo aggiornamento**: 2026-01-09
