# PHPStan Level 10 Errors Roadmap - Job Module

**Modulo**: Job  
**Livello PHPStan**: 10  
**Status**: 🧘 **IN ANALISI**

---

## 📊 Errori Identificati

### Totale Errori: 3

1. **`ScheduleResource/Pages/CreateSchedule.php`** (Linea 34)
   - **Errore**: `Method getformSchema() should return array<Htmlable|string> but returns array`
   - **Tipo**: `return.type`
   - **Errore**: `Variable $typedRes in PHPDoc tag @var does not exist`
   - **Tipo**: `varTag.variableNotFound`

2. **`Filament/Tables/Columns/ScheduleOptions.php`** (Linea 28)
   - **Errore**: `Method getTags() should return array but returns mixed`
   - **Tipo**: `return.type`
   - **Errore**: `Variable $options in PHPDoc tag @var does not exist`
   - **Tipo**: `varTag.variableNotFound`

3. **`app/Services/ScheduleService.php`** (Linea 54)
   - **Errore**: `Variable $result in PHPDoc tag @var does not exist`
   - **Tipo**: `varTag.variableNotFound`

---

## 🧠 Analisi Errori

### Pattern 1: varTag.variableNotFound
**Problema**: PHPDoc `@var` referenzia variabili che non esistono nel contesto.

**Causa**: 
- PHPDoc posizionato dopo l'uso della variabile
- Variabile non definita nel contesto
- PHPDoc su variabile che viene ridefinita

**Soluzione**: 
- Rimuovere PHPDoc non necessari
- Spostare PHPDoc prima della definizione variabile
- Usare type narrowing con `Webmozart\Assert\Assert`

### Pattern 2: return.type
**Problema**: Metodi che dichiarano un tipo ma ritornano `mixed`.

**Causa**:
- Metodi che ritornano valori da cache/DB senza type narrowing
- Metodi che ritornano array senza specificare shape
- Metodi che ritornano Collection senza generics

**Soluzione**:
- Aggiungere type narrowing con Assert
- Specificare generics per Collections
- Usare Safe Cast Actions per type safety

---

## ⚔️ Litigata Interna e Vincitore

### 👹 Voce A - Pragmatica (Ignorare PHPDoc)
**Argomenti**:
- PHPDoc non necessari se il tipo è già dedotto
- Meno codice da mantenere
- PHPStan può inferire i tipi

**Contro**:
- Perde type safety esplicita
- Non segue best practices PHPStan L10
- Può nascondere problemi reali

### 🦸 Voce B - Tecnica (Correggere Tutto)
**Argomenti**:
- Type safety esplicita
- PHPStan L10 compliance
- Codice più chiaro e manutenibile
- Prevenzione errori runtime

**Contro**:
- Richiede più lavoro
- Potrebbe sembrare verboso

### 🏆 VINCITORE: Voce B - Correggere Tutto

**Motivazione**:
1. **Type Safety**: PHPStan L10 richiede type safety esplicita
2. **Best Practices**: PHPDoc corretti migliorano la qualità del codice
3. **Manutenibilità**: Codice più chiaro per sviluppatori futuri
4. **Prevenzione**: Evita errori runtime

---

## 📋 Piano di Correzione

### Fase 1: CreateSchedule.php

**File**: `Job/app/Filament/Resources/ScheduleResource/Pages/CreateSchedule.php`

**Problema**:
```php
/** @var array<Htmlable|string> $typedRes */
return $res;
```

**Soluzione**:
```php
$formSchema = $res;
Assert::isArray($formSchema);
/** @var array<Htmlable|string> $formSchema */
return $formSchema;
```

### Fase 2: ScheduleOptions.php

**File**: `Job/app/Filament/Tables/Columns/ScheduleOptions.php`

**Problema**:
```php
$options = $this->record->getOptions();
/** @var array<int|string, string> $options */
return $options;
```

**Soluzione**:
```php
$options = $this->record->getOptions();
Assert::isArray($options);
/** @var array<int|string, string> $options */
return $options;
```

### Fase 3: ScheduleService.php

**File**: `Job/app/Services/ScheduleService.php`

**Problema**: PHPDoc `@var $result` su variabile inesistente.

**Soluzione**: Rimuovere PHPDoc o correggere contesto.

---

## ✅ Checklist Implementazione

- [ ] Correggere `CreateSchedule.php` - return.type + varTag
- [ ] Correggere `ScheduleOptions.php` - return.type + varTag
- [ ] Correggere `ScheduleService.php` - varTag
- [ ] Verificare PHPStan livello 10
- [ ] Verificare PHPMD
- [ ] Verificare PHPInsights
- [ ] Verificare lint
- [ ] Documentare pattern applicati
- [ ] Commit modifiche

---

**Status**: 🧘 **IN ANALISI**

**Ultimo aggiornamento**: 2026-01-09
