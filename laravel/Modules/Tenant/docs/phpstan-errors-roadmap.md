# PHPStan Level 10 Errors Roadmap - Tenant Module

**Data**: 2026-01-09  
**Modulo**: Tenant  
**Livello PHPStan**: 10  
**Status**: 🧘 **IN ANALISI**

---

## 📊 Errori Identificati

### Totale Errori: 2

1. **`app/Actions/Config/GetTenantConfigArrayAction.php`** (Linea 34)
   - **Errore**: `Method execute() should return array<string, mixed> but returns array<mixed>`
   - **Tipo**: `return.type`
   - **Errore**: `Variable $dataArray in PHPDoc tag @var does not exist`
   - **Tipo**: `varTag.variableNotFound`

2. **`app/Models/Traits/SushiToJson.php`** (Linea 122)
   - **Errore**: `Variable $rows in PHPDoc tag @var does not exist` (3 occorrenze in contesti diversi)
   - **Tipo**: `varTag.variableNotFound`

---

## 🧠 Analisi Errori

### Pattern 1: return.type
**Problema**: Metodo che ritorna `array<mixed>` invece di `array<string, mixed>`.

**Causa**:
- Array senza chiavi string esplicite
- Array creato da `array_values()` che perde chiavi

**Soluzione**:
- Assicurarsi che le chiavi siano string
- Usare `array_combine()` se necessario
- Aggiungere type narrowing con Assert

### Pattern 2: varTag.variableNotFound
**Problema**: PHPDoc `@var` referenzia variabili che non esistono nel contesto.

**Causa**: 
- PHPDoc posizionato prima della definizione variabile
- Variabile definita in closure/scope diverso

**Soluzione**: 
- Spostare PHPDoc dopo la definizione variabile
- Usare type narrowing con `Webmozart\Assert\Assert`

---

## 📋 Piano di Correzione

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

- [ ] Correggere `GetTenantConfigArrayAction.php` - return.type + varTag
- [ ] Correggere `SushiToJson.php` - varTag (3 occorrenze)
- [ ] Verificare PHPStan livello 10
- [ ] Verificare PHPMD
- [ ] Verificare PHPInsights
- [ ] Verificare lint
- [ ] Documentare pattern applicati
- [ ] Commit modifiche

---

**Status**: 🧘 **IN ANALISI**

**Ultimo aggiornamento**: 2026-01-09
