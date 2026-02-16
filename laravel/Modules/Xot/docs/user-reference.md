# Pattern per Riferimenti User - Laraxot

**Obiettivo**: Standardizzare i riferimenti a User nel sistema Laraxot
**Problema**: PHPStan segnala errori su `App\Models\User` che non esiste

---

## 🚨 Problema

PHPStan segnala errori quando trova riferimenti a `App\Models\User` che **non esiste** nel sistema Laraxot.

**Pattern SBAGLIATO**:
```php
// ❌ SBAGLIATO - App\Models\User non esiste
use App\Models\User;
$user = User::find($id);
```

---

## ✅ Pattern Corretti

### 1. Per Ottenere la Classe User

**Usa `XotData::make()->getUserClass()`**:
```php
use Modules\Xot\Datas\XotData;

$userClass = XotData::make()->getUserClass();
// Restituisce: 'Modules\User\Models\BaseUser' o classe configurata
```

**Pattern**: Sempre usare `XotData` per ottenere la classe User corretta dal config.

---

### 2. Per Ottenere Istanza User da Request

**Usa `$request->user()` con type hint `UserContract`**:
```php
use Modules\Xot\Contracts\UserContract;
use Illuminate\Http\Request;

$user = $request->user();
if ($user instanceof UserContract) {
    // Usa $user
    $lang = $user->lang ?? app()->getLocale();
}
```

**Pattern**: Verificare sempre `instanceof UserContract` prima di accedere a proprietà specifiche.

---

### 3. Per Ottenere User da Auth Facade

**Usa `Auth::user()` con type hint `UserContract`**:
```php
use Modules\Xot\Contracts\UserContract;
use Illuminate\Support\Facades\Auth;

$user = Auth::user();
if ($user instanceof UserContract) {
    // Usa $user
    $profile = $user->profile()->first();
}
```

**Pattern**: `Auth::user()` può restituire `null` o `Authenticatable`, verificare sempre `UserContract`.

---

### 4. Per Type Hint in Metodi

**Usa `UserContract` invece di classe concreta**:
```php
use Modules\Xot\Contracts\UserContract;

public function processUser(UserContract $user): void
{
    // $user è sempre UserContract
    $profile = $user->profile()->first();
}
```

**Pattern**: Nei parametri di metodi, usare sempre `UserContract` per type safety.

---

### 5. Per PHPDoc Type Hints

**Usa `UserContract` nei PHPDoc**:
```php
use Modules\Xot\Contracts\UserContract;

/**
 * @param UserContract|null $user
 * @return void
 */
public function setUser(?UserContract $user): void
{
    // ...
}
```

**Pattern**: Nei PHPDoc, usare `UserContract` invece di classi concrete.

---

## 📋 Esempi Pratici

### Middleware - Accesso User

```php
use Modules\Xot\Contracts\UserContract;
use Illuminate\Http\Request;

public function handle(Request $request, Closure $next): Response
{
    $user = $request->user();

    // ✅ CORRETTO - Verifica UserContract
    if ($user instanceof UserContract) {
        $lang = $user->lang ?? app()->getLocale();
    }

    return $next($request);
}
```

### Service Provider - Accesso User

```php
use Modules\Xot\Contracts\UserContract;
use Illuminate\Database\Eloquent\Model;

public function registerLang(): void
{
    $user = request()->user();
    $lang = app()->getLocale();

    // ✅ CORRETTO - Verifica Model e UserContract
    if ($user instanceof Model && $user instanceof UserContract) {
        $userLang = $user->getAttribute('lang');
        if (is_string($userLang) && $userLang !== '') {
            $lang = $userLang;
        }
    }
}
```

### Accesso Proprietà User

```php
use Modules\Xot\Contracts\UserContract;

$user = $request->user();
if ($user instanceof UserContract) {
    // ✅ CORRETTO - Accesso sicuro a proprietà
    $userId = $user->id;
    $userEmail = $user->email;
    $userLang = $user->lang ?? null;
}
```

---

## 🔧 Correzioni Comuni

### Errore: Access to property $id on unknown class App\Models\User

**Causa**: PHPStan non riconosce `App\Models\User`

**Soluzione**:
```php
// ❌ PRIMA
$userId = $request->user()?->id;

// ✅ DOPO
use Modules\Xot\Contracts\UserContract;

$user = $request->user();
if ($user instanceof UserContract) {
    $userId = $user->id;
}
```

### Errore: Call to method profile() on unknown class App\Models\User

**Causa**: PHPStan non riconosce `App\Models\User`

**Soluzione**:
```php
// ❌ PRIMA
$profile = $user->profile();

// ✅ DOPO
use Modules\Xot\Contracts\UserContract;

if ($user instanceof UserContract) {
    $profile = $user->profile();
}
```

---

## 📚 Riferimenti

- [UserContract Documentation](./contracts.md)
- [XotData Documentation](./xotdata-pattern.md)
- [PHPStan Code Quality Guide](./phpstan_code_quality_guide.md)

---

## ✅ Checklist

- [ ] Non usare mai `App\Models\User`
- [ ] Usare `XotData::make()->getUserClass()` per ottenere classe User
- [ ] Verificare sempre `instanceof UserContract` prima di accedere proprietà
- [ ] Usare `UserContract` nei type hints e PHPDoc
- [ ] Verificare PHPStan Level 10 dopo correzioni

---

*Ultimo aggiornamento: [DATE]*
