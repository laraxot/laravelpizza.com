# PHPStan Corrections - Cms Module - Gennaio 2025

**Modulo**: Cms
**Errori Risolti**: 8

---

## 🔧 Correzioni Implementate

### 1. HasBlocks Trait - DataCollection::make() Non Esiste

**File**: `Modules/Cms/app/Models/Traits/HasBlocks.php`

**Problema**: `DataCollection::make()` non esiste, deve usare `BlockData::collection()`

**Errore PHPStan**:
```
Call to an undefined static method Spatie\LaravelData\DataCollection::make().
```

**Soluzione**:
```php
// ❌ SBAGLIATO
return DataCollection::make([]);

// ✅ CORRETTO
return BlockData::collection([]);
```

**Pattern Applicato**: Usare sempre `DataClass::collection()` invece di `DataCollection::make()`

---

### 2. Section Component - BlockData Type Non Trovato

**File**: `Modules/Cms/app/View/Components/Section.php`

**Problema**: Tipo `BlockData` non importato nella property

**Errore PHPStan**:
```
Property Modules\Cms\View\Components\Section::$blocks has unknown class Modules\Cms\View\Components\BlockData as its type.
```

**Soluzione**:
```php
use Modules\Cms\Datas\BlockData;

/** @var DataCollection<BlockData> */
public DataCollection $blocks;
```

---

### 3. XotComposer - Unknown User Class

**File**: `Modules/Cms/app/Http/View/Composers/XotComposer.php`

**Problema**: Riferimento a `App\Models\User` che non esiste

**Errore PHPStan**:
```
Call to method profile() on an unknown class App\Models\User.
```

**Soluzione**:
```php
use Modules\Xot\Contracts\UserContract;

if (! ($user instanceof UserContract)) {
    return;
}

/** @var \Illuminate\Database\Eloquent\Relations\HasOne $profileRelation */
$profileRelation = $user->profile();
```

**Pattern Applicato**: Verificare sempre che l'utente implementi `UserContract` prima di chiamare metodi specifici

---

### 4. VerifyComponent - Metodi Email Verification Mancanti

**File**: `Modules/Cms/app/Http/Volt/VerifyComponent.php`

**Problema**: Metodi `hasVerifiedEmail()` e `sendEmailVerificationNotification()` non definiti in `UserContract`

**Errore PHPStan**:
```
Call to an undefined method Modules\Xot\Contracts\UserContract::hasVerifiedEmail().
Call to an undefined method Modules\Xot\Contracts\UserContract::sendEmailVerificationNotification().
```

**Soluzione**: Aggiunti metodi a `UserContract`:
```php
/**
 * Determine if the user has verified their email address.
 */
public function hasVerifiedEmail(): bool;

/**
 * Send the email verification notification.
 */
public function sendEmailVerificationNotification(): void;
```

**File Modificato**: `Modules/Xot/app/Contracts/UserContract.php`

---

## 📚 Riferimenti

- [PHPStan Code Quality Guide](../../Xot/docs/phpstan_code_quality_guide.md)
- [Cms Module README](./README.md)
- [DataCollection Best Practices](../../Xot/docs/spatie-data-best-practices.md)

---

*Ultimo aggiornamento: 2025-01-10*
