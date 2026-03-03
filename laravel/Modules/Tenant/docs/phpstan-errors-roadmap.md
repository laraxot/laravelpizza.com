# PHPStan Level 10 Errors Roadmap - Tenant Module

**Modulo**: Tenant  
**Livello PHPStan**: 10  
**Status**: 🧘 **AGGIORNATO CON ERRORI ATTUALI**

---

## 📊 Errori Identificati

### Totale Errori: 500+ (stimato)

**Nota critica**: La maggior parte degli errori (90%+) provengono dai test in `Modules/Tenant/Tests/*`. Il codice principale ha pochi errori.

#### File più impattati (top)

1. **`Modules/Tenant/Tests/Feature/TenantBusinessLogicTest.php`**: 161
2. **`Modules/Tenant/Tests/Unit/SushiToJsonTraitTest.php`**: 144
3. **`Modules/Tenant/Tests/Unit/SushiToJsonTraitPestTest.php`**: 78
4. **`Modules/Tenant/Tests/Integration/SushiToJsonIntegrationTest.php`**: 67
5. **`Modules/Tenant/Tests/Performance/SushiToJsonPerformanceTest.php`**: 17
6. **`Modules/Tenant/Tests/Pest.php`**: 17

---

## 🧠 Analisi Errori

### Pattern Principali (dati reali dall'ultimo run)

1. **`method.nonObject`** (molto frequente)
   - Tipicamente chiamate a metodi su variabili tipizzate `mixed` / `array` / `object` non garantito.
2. **`property.nonObject`** / **`property.notFound`**
   - Accesso a proprietà su `mixed` oppure su oggetti non garantiti.
3. **`offsetAccess.nonOffsetAccessible`**
   - Uso di `$x['key']` dove `$x` non è certamente array/ArrayAccess.
4. **`argument.type`**
   - Parametri passati con tipo troppo largo / `mixed`.

Questi pattern sono coerenti con una base test “legacy” scritta prima dell'attuale set di regole (Pest-only, no RefreshDatabase, type safety).

---

## 📋 Piano di Correzione

### Fase 0: Allineamento filosofia e vincoli

- I test devono essere **Pest-first**.
- Il sito funziona: se un test fallisce perché “manca qualcosa”, va corretto il test.
- Non usare mai `RefreshDatabase`.

### Fase 1: Riduzione massiva errori in `Modules/Tenant/Tests/*`

- Ridurre `mixed` nei test con type narrowing (es. `Assert::isArray`, `Assert::isInstanceOf`).
- Rimuovere assunzioni non tipizzate su response/array.
- Normalizzare fixtures e helper dei test (DRY + KISS).

### Fase 2: Consolidamento Pest

- Garantire che i test siano Pest (se restano test class-based, convertire).
- Allineare `Modules/Tenant/Tests/Pest.php` al bootstrap di progetto.

### Fase 3: Quality gates + commit

1. `./vendor/bin/phpstan analyse Modules/Tenant --no-progress`
2. `./vendor/bin/phpmd Modules/Tenant text cleancode,codesize,controversial,design,naming,unusedcode`
3. `./vendor/bin/phpinsights -n Modules/Tenant`
4. Commit (fix-forward)

### Fase 1: GetTenantConfigArrayAction.php

**File**: `Tenant/app/Actions/Config/GetTenantConfigArrayAction.php`

**Problema**:

```php
/** @var array<string, mixed> $dataArray */
return $data;
```

**Soluzione**:

```php
$dataArray = $data;
Assert::isArray($dataArray);
/** @var array<string, mixed> $dataArray */
return $dataArray;
```

**Nota**: Se `$data` è `array<mixed>`, potrebbe essere necessario convertire chiavi a string.

### Fase 2: SushiToJson.php

**File**: `Tenant/app/Models/Traits/SushiToJson.php`

**Problema**: PHPDoc `@var $rows` su variabile inesistente (3 occorrenze).

**Soluzione**: Rimuovere PHPDoc o correggere contesto per ogni occorrenza.

---

## ✅ Checklist Implementazione

- [ ] Ridurre errori in `Modules/Tenant/Tests/Feature/TenantBusinessLogicTest.php`
- [ ] Ridurre errori in `Modules/Tenant/Tests/Unit/SushiToJsonTraitTest.php`
- [ ] Ridurre errori in `Modules/Tenant/Tests/Unit/SushiToJsonTraitPestTest.php`
- [ ] Ridurre errori in `Modules/Tenant/Tests/Integration/SushiToJsonIntegrationTest.php`
- [ ] Verificare PHPStan livello 10
- [ ] Verificare PHPMD
- [ ] Verificare PHPInsights
- [ ] Verificare lint
- [ ] Documentare pattern applicati
- [ ] Commit modifiche

---

**Status**: 🧘 **IN ANALISI**

**
