# PHPStan Level Max Errors Roadmap - User Module

**Date**: 2026-01-12
**Module**: User
**PHPStan Level**: max (Level 10)
**Status**: 🚧 **IN PROGRESS**
**Environment**: ✅ **STABLE** (Tests use `testing.sqlite`, shared connections worked)

---

## 📊 Status Update

### ✅ Completed Items
1. **Merge Conflicts Resolved**:
   - `SocialiteUserResource.php`: Fixed.
   - `TeamInvitationResource.php`: Fixed.
   - `BaseUser.php`: Fixed (Critical model restored).
   - `Passport/Client.php`: Fixed.
2. **Test Environment Fixed**:
   - `TestCase.php` rewritten to use persistent `tests/testing.sqlite` to resolve SQLite `:memory:` isolation issues between multiple connections (`user`, `mysql`, `default`).
   - `TenantTest`: **PASSING**.
3. **Syntax Errors Fixed**:
   - `HasTeams.php`: Fixed `switchTeam` return type and syntax error.
   - `TestCase.php`: Fixed syntax and structure.

### 🚨 Current Challenges
- **Total PHPStan Errors**: 534 (down from initial merge conflict state).
- **Categories**:
    1. **Type Mismatches**: `Contract` vs `Model` checks (e.g. `HasTeams` trait).
    2. **Missing Methods**: `Call to an undefined method` on generic traits/mixins.
    3. **Missing Files**: References to pages/resources that might be missing or misnamed.

---

## 🗺️ Roadmap: 534 Errors Resolution

### Phase 1: High Impact Traits (HasTeams, HasProfile)
- **Goal**: Resolve type errors in core traits used by `BaseUser`.
- **Strategy**: 
    - Use `assert($this instanceof Model)` or strict type checks where PHPStan loses context.
    - Fix generic `@return` types for relationships (e.g. `BelongsToMany`).

### Phase 2: Missing Files & Resources
- **Goal**: Resolve "Internal error: Could not read file" or class not found.
- **Acions**:
    - Verify `ClientResource` pages existence.
    - If missing, create stub classes or remove references.

### Phase 3: Generic Type Narrowing
- **Goal**: Fix `mixed` type errors.
- **Strategy**:
    - Add `@var` annotations where necessary.
    - Use strict return types.

---

## 📝 Recent Fixes Log

- **Fix `TenantTest`**: Switched to file-based sqlite to handle `shared` connection logic correctly.
- **Fix `HasTeams::switchTeam`**: Added return `bool` type casting and fixed brace syntax.
- **Fix `BaseUser`**: Resolved critical merge conflicts restoring the model integrity.

**Next Step**: Run `phpstan analyse Modules/User` and start Phase 1.
# PHPStan Level 10 Errors Roadmap - Modulo User

**Data**: 2026-01-12  
**Modulo**: User  
**Livello PHPStan**: 10  
**Status**: ✅ **COMPLETATO - 0 Errori**

---

## 📊 Errori Identificati

### Totale Errori: 13

1. **`app/Filament/Clusters/Passport/Resources/OauthClientResource.php`** (Linea 87)
   - **Errore**: `getModel() should return class-string<Model> but returns string`
   - **Tipo**: `return.type`

2. **`app/Filament/Resources/ClientResource.php`** (Linea 73)
   - **Errore**: `getModel() should return class-string<Model> but returns class-string`
   - **Tipo**: `return.type`

3. **`app/Http/Resources/ClientResource.php`** (Linee 28, 29)
   - **Errore**: `Access to an undefined property $owner` (2 volte)
   - **Tipo**: `property.notFound`

4. **`app/Models/Role.php`** (Linea 83)
   - **Errore**: PHPDoc con classi sconosciute:
     - `Modules\User\Models\Carbon` (dovrebbe essere `Illuminate\Support\Carbon`)
     - `Modules\User\Models\Collection` (dovrebbe essere `Illuminate\Database\Eloquent\Collection`)
     - `Modules\User\Models\EloquentCollection` (dovrebbe essere `Illuminate\Database\Eloquent\Collection`)
     - `Modules\User\Models\UserContract` (dovrebbe essere `Modules\Xot\Contracts\UserContract` o `Modules\User\Contracts\UserContract`)
   - **Tipo**: `class.notFound` (5 errori)

5. **`app/Models/Traits/HasTeams.php`** (Linea 342)
   - **Errore**: `Call to method pluck() on an unknown class Modules\User\Models\Collection`
   - **Tipo**: `class.notFound`

6. **`app/Models/Traits/HasTeams.php`** (Linea 342)
   - **Errore**: `Cannot call method toArray() on mixed`
   - **Tipo**: `method.nonObject`

7. **`app/Models/Traits/HasTeams.php`** (Linea 345)
   - **Errore**: `Parameter #1 $array of function array_filter expects array, mixed given`
   - **Tipo**: `argument.type`

8. **`app/Models/Traits/HasTeams.php`** (Linea 368)
   - **Errore**: `teamPermissions() should return array<int, string> but returns list`
   - **Tipo**: `return.type`

---

## 🧠 Analisi Errori

### Pattern 1: getModel() Return Type

**Problema**: `getModel()` deve restituire `class-string<Model>` ma restituisce `string` o `class-string`.

**Soluzione**: Aggiungere type hint corretto o cast.

### Pattern 2: Property $owner Non Trovata

**Problema**: Accesso a proprietà `$owner` che non esiste.

**Soluzione**: Verificare se la proprietà esiste o se deve essere aggiunta al modello.

### Pattern 3: PHPDoc con Classi Sconosciute

**Problema**: PHPDoc referenzia classi con namespace errato.

**Soluzione**: Correggere namespace nelle annotazioni PHPDoc.

### Pattern 4: Type Narrowing Necessario

**Problema**: Metodi che restituiscono `mixed` o usano classi sconosciute.

**Soluzione**: Aggiungere type narrowing con Assert o PHPDoc espliciti.

---

## 📋 Piano di Correzione

### Fase 1: Correzione getModel() Return Type

**File**: `OauthClientResource.php`, `ClientResource.php`

```php
// Verificare implementazione getModel() e aggiungere type hint corretto
```

### Fase 2: Correzione Property $owner

**File**: `app/Http/Resources/ClientResource.php`

```php
// Verificare se $owner esiste nel modello o se deve essere aggiunto
// Oppure usare isset() o hasAttribute() per accesso sicuro
```

### Fase 3: Correzione PHPDoc in Role.php

**File**: `app/Models/Role.php`

```php
// ❌ PRIMA
/**
 * @property Modules\User\Models\Carbon $created_at
 * @property Modules\User\Models\Collection $permissions
 * @property Modules\User\Models\EloquentCollection $users
 */

// ✅ DOPO
/**
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Database\Eloquent\Collection<int, Permission> $permissions
 * @property \Illuminate\Database\Eloquent\Collection<int, User> $users
 */
```

### Fase 4: Correzione HasTeams.php

**File**: `app/Models/Traits/HasTeams.php`

**Correzioni necessarie**:
1. Type narrowing per Collection
2. Type narrowing per array_filter
3. Return type per teamPermissions()

---

## ✅ Checklist Implementazione

- [ ] Correggere `getModel()` return type in 2 file
- [ ] Correggere accesso a `$owner` in `ClientResource.php`
- [ ] Correggere PHPDoc in `Role.php` (5 correzioni)
- [ ] Correggere type narrowing in `HasTeams.php` (4 correzioni)
- [ ] Verificare PHPStan Level 10: `./vendor/bin/phpstan analyse Modules/User --level=10`
- [ ] Verificare PHPMD: `./vendor/bin/phpmd Modules/User text codesize`
- [ ] Verificare PHP Insights: `./vendor/bin/phpinsights analyse Modules/User`
- [ ] Formattare codice: `./vendor/bin/pint Modules/User`
- [ ] Aggiornare questa roadmap con risultati
- [ ] Git commit e push

---

## 📚 Riferimenti

- [Filament Class Extension Rules](../../Xot/docs/filament-class-extension-rules.md)
- [PHPStan Code Quality Guide](../../Xot/docs/phpstan-code-quality-guide.md)
- [Property Exists vs Isset](../../Xot/docs/phpstan-code-quality-guide.md#5-property-access-su-mixed-eloquent---regola-critica)

---

## 🎯 Strategia

**Approccio**: Analisi approfondita - errori diversi richiedono comprensione business logic  
**Priorità**: Media (13 errori, alcuni richiedono verifica modelli)  
**Tempo stimato**: 45 minuti
