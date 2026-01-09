# PHPStan Level 10 Errors Roadmap - UI Module

**Data**: 2026-01-09  
**Modulo**: UI  
**Livello PHPStan**: 10  
**Status**: 🧘 **IN ANALISI**

---

## 📊 Errori Identificati

### Totale Errori: 3

1. **`app/Filament/Forms/Components/IconPicker.php`** (Linea 40)
   - **Errore**: `Variable $packsOptions in PHPDoc tag @var does not exist`
   - **Tipo**: `varTag.variableNotFound`

2. **`app/Filament/Tables/Columns/IconStateColumn.php`** (Linea 76)
   - **Errore**: `Variable $states in PHPDoc tag @var does not exist`
   - **Tipo**: `varTag.variableNotFound`

3. **`app/Filament/Tables/Columns/SelectStateColumn.php`** (Linea 31)
   - **Errore**: `Variable $result in PHPDoc tag @var does not exist`
   - **Tipo**: `varTag.variableNotFound`

4. **`app/Filament/Widgets/UserCalendarWidget.php`** (Linee 57, 73)
   - **Errore**: `Method fetchEvents() should return array<int, array<string, mixed>> but returns mixed` (linea 57)
   - **Errore**: `Variable $result in PHPDoc tag @var does not exist` (linee 57, 73)
   - **Tipo**: `return.type` + `varTag.variableNotFound`

---

## 🧠 Analisi Errori

### Pattern: varTag.variableNotFound
**Problema**: PHPDoc `@var` referenzia variabili che non esistono nel contesto.

**Causa**: 
- PHPDoc posizionato prima della definizione variabile
- Variabile definita in closure/scope diverso
- PHPDoc su variabile che viene ridefinita

**Soluzione**: 
- Spostare PHPDoc dopo la definizione variabile
- Usare type narrowing con `Webmozart\Assert\Assert`
- Rimuovere PHPDoc non necessari se il tipo è già dedotto

---

## 📋 Piano di Correzione

### Fase 1: IconPicker.php

**File**: `UI/app/Filament/Forms/Components/IconPicker.php`

**Problema**:
```php
->options(function () use ($packs): array {
    /** @var array<string, string> $packsOptions */
    return $packs;
})
```

**Soluzione**:
```php
->options(function () use ($packs): array {
    Assert::isArray($packs);
    /** @var array<string, string> $packs */
    return $packs;
})
```

### Fase 2: IconStateColumn.php

**File**: `UI/app/Filament/Tables/Columns/IconStateColumn.php`

**Problema**: PHPDoc `@var $states` su variabile inesistente.

**Soluzione**: Rimuovere PHPDoc o correggere contesto.

### Fase 3: SelectStateColumn.php

**File**: `UI/app/Filament/Tables/Columns/SelectStateColumn.php`

**Problema**: PHPDoc `@var $result` su variabile inesistente.

**Soluzione**: Rimuovere PHPDoc o correggere contesto.

### Fase 4: UserCalendarWidget.php

**File**: `UI/app/Filament/Widgets/UserCalendarWidget.php`

**Problema**: Metodo `fetchEvents()` ritorna `mixed` invece di `array<int, array<string, mixed>>`.

**Soluzione**: Aggiungere type narrowing con Assert.

---

## ✅ Checklist Implementazione

- [ ] Correggere `IconPicker.php` - varTag
- [ ] Correggere `IconStateColumn.php` - varTag
- [ ] Correggere `SelectStateColumn.php` - varTag
- [ ] Correggere `UserCalendarWidget.php` - return.type + varTag
- [ ] Verificare PHPStan livello 10
- [ ] Verificare PHPMD
- [ ] Verificare PHPInsights
- [ ] Verificare lint
- [ ] Documentare pattern applicati
- [ ] Commit modifiche

---

**Status**: 🧘 **IN ANALISI**

**Ultimo aggiornamento**: 2026-01-09
