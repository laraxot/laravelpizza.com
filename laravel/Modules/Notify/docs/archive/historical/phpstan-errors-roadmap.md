# PHPStan Level 10 Errors Roadmap - Notify Module

**Modulo**: Notify  
**Livello PHPStan**: 10  
**Status**: 🧘 **IN ANALISI**

---

## 📊 Errori Identificati

### Totale Errori: 4

1. **`app/Factories/TelegramActionFactory.php`** (Linea 63)
   - **Errore**: `Method create() should return TelegramProviderActionInterface but returns mixed`
   - **Tipo**: `return.type`
   - **Errore**: `Variable $instance in PHPDoc tag @var does not exist`
   - **Tipo**: `varTag.variableNotFound`

2. **`app/Factories/WhatsAppActionFactory.php`** (Linea 68)
   - **Errore**: `Method create() should return WhatsAppProviderActionInterface but returns mixed`
   - **Tipo**: `return.type`
   - **Errore**: `Variable $instance in PHPDoc tag @var does not exist`
   - **Tipo**: `varTag.variableNotFound`

3. **`app/Models/NotificationTemplate.php`** (Linea 262)
   - **Errore**: `Method getGrapesJSData() should return array<string, mixed> but returns array`
   - **Tipo**: `return.type`
   - **Errore**: `Variable $data in PHPDoc tag @var does not exist`
   - **Tipo**: `varTag.variableNotFound`

4. **`app/Notifications/GenericNotification.php`** (Linea 154)
   - **Errore**: `Method should return string but returns mixed`
   - **Tipo**: `return.type`
   - **Errore**: `Variable $fullName in PHPDoc tag @var does not exist`
   - **Tipo**: `varTag.variableNotFound`

---

## 🧠 Analisi Errori

### Pattern 1: varTag.variableNotFound in Factory
**Problema**: PHPDoc `@var` su variabile `$instance` che non esiste nel contesto.

**Causa**: 
- PHPDoc posizionato prima della definizione variabile
- `app()` ritorna `mixed`, quindi serve type narrowing

**Soluzione**: 
- Spostare PHPDoc dopo `app()` e usare type narrowing
- Usare `Webmozart\Assert\Assert` per validazione

### Pattern 2: return.type in Factory
**Problema**: `app()` ritorna `mixed`, ma il metodo dichiara un tipo specifico.

**Soluzione**:
- Usare type narrowing con Assert
- Aggiungere PHPDoc corretto dopo `app()`

### Pattern 3: return.type in Models
**Problema**: Metodi che ritornano `array` senza specificare shape.

**Soluzione**:
- Aggiungere type narrowing con Assert
- Specificare shape array con PHPDoc

---

## ⚔️ Litigata Interna e Vincitore

### 👹 Voce A - Pragmatica (Ignorare Type Narrowing)
**Argomenti**:
- `app()` è sicuro se la classe esiste
- Meno codice verboso
- PHPStan può inferire da `is_subclass_of` check

**Contro**:
- Perde type safety esplicita
- Non segue best practices PHPStan L10
- `app()` ritorna sempre `mixed`

### 🦸 Voce B - Tecnica (Type Narrowing Completo)
**Argomenti**:
- Type safety esplicita
- PHPStan L10 compliance
- Codice più chiaro e manutenibile
- Prevenzione errori runtime

**Contro**:
- Richiede più lavoro
- Potrebbe sembrare verboso

### 🏆 VINCITORE: Voce B - Type Narrowing Completo

**Motivazione**:
1. **Type Safety**: PHPStan L10 richiede type safety esplicita
2. **Best Practices**: Type narrowing con Assert è pattern standard
3. **Manutenibilità**: Codice più chiaro per sviluppatori futuri
4. **Prevenzione**: Evita errori runtime con `app()`

---

## 📋 Piano di Correzione

### Fase 1: TelegramActionFactory.php

**File**: `Notify/app/Factories/TelegramActionFactory.php`

**Problema**:
```php
/** @var TelegramProviderActionInterface $instance */
return app($className);
```

**Soluzione**:
```php
$instance = app($className);
Assert::isInstanceOf($instance, TelegramProviderActionInterface::class);
/** @var TelegramProviderActionInterface $instance */
return $instance;
```

### Fase 2: WhatsAppActionFactory.php

**File**: `Notify/app/Factories/WhatsAppActionFactory.php`

**Problema**: Stesso pattern di TelegramActionFactory.

**Soluzione**: Applicare stesso pattern.

### Fase 3: NotificationTemplate.php

**File**: `Notify/app/Models/NotificationTemplate.php`

**Problema**: Metodo `getGrapesJSData()` ritorna `array` senza shape.

**Soluzione**: Aggiungere type narrowing e PHPDoc corretto.

### Fase 4: GenericNotification.php

**File**: `Notify/app/Notifications/GenericNotification.php`

**Problema**: Metodo ritorna `mixed` invece di `string`.

**Soluzione**: Aggiungere type narrowing con Assert.

---

## ✅ Checklist Implementazione

- [ ] Correggere `TelegramActionFactory.php` - return.type + varTag
- [ ] Correggere `WhatsAppActionFactory.php` - return.type + varTag
- [ ] Correggere `NotificationTemplate.php` - return.type + varTag
- [ ] Correggere `GenericNotification.php` - return.type + varTag
- [ ] Verificare PHPStan livello 10
- [ ] Verificare PHPMD
- [ ] Verificare PHPInsights
- [ ] Verificare lint
- [ ] Documentare pattern applicati
- [ ] Commit modifiche

---

**Status**: 🧘 **IN ANALISI**

**Ultimo aggiornamento**: 2026-01-09
