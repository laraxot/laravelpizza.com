# PHPStan Level 10 Errors Roadmap - User Module

**Data**: 2026-01-09  
**Modulo**: User  
**Livello PHPStan**: 10  
**Status**: 🧘 **IN ANALISI**

---

## 📊 Errori Identificati

### Totale Errori: 5

1. **`app/Actions/Socialite/CreateUserAction.php`** (Linea 67)
   - **Errore**: `Variable $refreshedUser in PHPDoc tag @var does not exist`
   - **Tipo**: `varTag.variableNotFound`

2. **`app/Filament/Resources/PermissionResource/Pages/ListPermissions.php`** (Linea 113)
   - **Errore**: `Variable $options in PHPDoc tag @var does not exist`
   - **Tipo**: `varTag.variableNotFound`

3. **`app/Filament/Widgets/EditUserWidget.php`** (Linee 129, 169, 176, 195)
   - **Errore**: `Method getFormSchema() should return array<int|string, Component> but returns mixed` (linea 129)
   - **Errore**: `Variable $result in PHPDoc tag @var does not exist` (linea 129)
   - **Errore**: `Method getFormModel() should return Model but returns mixed` (linee 169, 195)
   - **Errore**: `Variable $user in PHPDoc tag @var does not exist` (linee 169, 176)
   - **Tipo**: `return.type` + `varTag.variableNotFound`

4. **`app/Filament/Widgets/PasswordExpiredWidget.php`** (Linea 69)
   - **Errore**: `Variable $result in PHPDoc tag @var does not exist`
   - **Tipo**: `varTag.variableNotFound`

5. **`app/Filament/Widgets/RegistrationWidget.php`** (Linee 77, 94)
   - **Errore**: `Method getFormModel() should return Model but returns mixed` (linee 77, 94)
   - **Errore**: `Variable $model in PHPDoc tag @var does not exist` (linee 77, 94)
   - **Tipo**: `return.type` + `varTag.variableNotFound`

6. **`app/Http/Livewire/Auth/Passwords/Confirm.php`** (Linea 41)
   - **Errore**: `Method render() should return View|string but returns mixed`
   - **Tipo**: `return.type`

---

## 🧠 Analisi Errori

### Pattern 1: varTag.variableNotFound
**Problema**: PHPDoc `@var` referenzia variabili che non esistono nel contesto.

**Causa**: 
- PHPDoc posizionato prima della definizione variabile
- Variabile definita in closure/scope diverso
- PHPDoc su variabile che viene ridefinita

**Soluzione**: 
- Spostare PHPDoc dopo la definizione variabile
- Usare type narrowing con `Webmozart\Assert\Assert`
- Rimuovere PHPDoc non necessari se il tipo è già dedotto

### Pattern 2: return.type in Widgets
**Problema**: Metodi che ritornano `mixed` invece del tipo dichiarato.

**Causa**:
- Metodi che ritornano valori da `getFormSchema()` senza type narrowing
- Metodi che ritornano modelli senza type narrowing

**Soluzione**:
- Aggiungere type narrowing con Assert
- Usare PHPDoc corretto dopo type narrowing

---

## 📋 Piano di Correzione

### Fase 1: CreateUserAction.php

**File**: `User/app/Actions/Socialite/CreateUserAction.php`

**Problema**: PHPDoc `@var $refreshedUser` su variabile inesistente.

**Soluzione**: Rimuovere PHPDoc o correggere contesto.

### Fase 2: ListPermissions.php

**File**: `User/app/Filament/Resources/PermissionResource/Pages/ListPermissions.php`

**Problema**: PHPDoc `@var $options` su variabile inesistente.

**Soluzione**: Rimuovere PHPDoc o correggere contesto.

### Fase 3: EditUserWidget.php

**File**: `User/app/Filament/Widgets/EditUserWidget.php`

**Problema**:
```php
/** @var array<int|string, Component> $result */
return $schema;
```

**Soluzione**:
```php
$result = $schema;
Assert::isArray($result);
/** @var array<int|string, Component> $result */
return $result;
```

**Problema** (getFormModel):
```php
/** @var Model $user */
return $this->getRecord();
```

**Soluzione**:
```php
$user = $this->getRecord();
Assert::isInstanceOf($user, Model::class);
/** @var Model $user */
return $user;
```

### Fase 4: PasswordExpiredWidget.php

**File**: `User/app/Filament/Widgets/PasswordExpiredWidget.php`

**Problema**: PHPDoc `@var $result` su variabile inesistente.

**Soluzione**: Rimuovere PHPDoc o correggere contesto.

### Fase 5: RegistrationWidget.php

**File**: `User/app/Filament/Widgets/RegistrationWidget.php`

**Problema**: Metodo `getFormModel()` ritorna `mixed`.

**Soluzione**: Aggiungere type narrowing con Assert.

### Fase 6: Confirm.php

**File**: `User/app/Http/Livewire/Auth/Passwords/Confirm.php`

**Problema**: Metodo `render()` ritorna `mixed`.

**Soluzione**: Aggiungere type narrowing con Assert.

---

## ✅ Checklist Implementazione

- [ ] Correggere `CreateUserAction.php` - varTag
- [ ] Correggere `ListPermissions.php` - varTag
- [ ] Correggere `EditUserWidget.php` - return.type + varTag (4 errori)
- [ ] Correggere `PasswordExpiredWidget.php` - varTag
- [ ] Correggere `RegistrationWidget.php` - return.type + varTag (2 errori)
- [ ] Correggere `Confirm.php` - return.type
- [ ] Verificare PHPStan livello 10
- [ ] Verificare PHPMD
- [ ] Verificare PHPInsights
- [ ] Verificare lint
- [ ] Documentare pattern applicati
- [ ] Commit modifiche

---

**Status**: 🧘 **IN ANALISI**

**Ultimo aggiornamento**: 2026-01-09
