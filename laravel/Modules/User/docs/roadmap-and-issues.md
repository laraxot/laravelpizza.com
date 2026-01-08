# User Module - Roadmap, Issues & Optimization

**Modulo**: User (Authentication, Authorization, Profiles)  
**Data Analisi**: 1 Ottobre 2025  
**Maintainer**: Team FixCity  
**Status PHPStan**: ⚠️ 95 errori (Level 9)

---

## 📊 STATO ATTUALE

### Completezza Funzionale: 85%

| Area | Completezza | Note |
|------|-------------|------|
| Authentication | 100% | Login, Register, Password Reset |
| Authorization | 90% | Spatie Permissions integrato |
| Profiles | 80% | Base implementato |
| Teams | 70% | Appena aggiunto |
| Tenants | 70% | Appena aggiunto |
| API Tokens | 60% | Sanctum parziale |
| Social Login | 0% | Da implementare |

---

## 🔴 ERRORI PHPSTAN DA CORREGGERE (95)

### Categorizzazione Errori

| Categoria | Count | Priorità |
|-----------|-------|----------|
| Property Access Issues | ~50 | ALTA |
| Type Safety Issues | ~30 | ALTA |
| Method Call Issues | ~15 | MEDIA |

### Errore Critico Risolto ✅

#### BaseUser.php - Syntax Error (RISOLTO)
**File**: `app/Models/BaseUser.php:377-419`  
**Problema**: Blocchi di codice orfani causavano 7 errori sintassi  
**Soluzione**: Rimosso codice orfano  
**Impatto**: Sbloccata tutta l'analisi PHPStan

### Miglioramento Implementato ✅

#### BaseUser.php - Teams & Tenants Support
**File**: `app/Models/BaseUser.php`  
**Aggiunto**:
- `teams()`: BelongsToMany relationship
- `currentTeam()`: BelongsTo relationship
- `isCurrentTeam()`: Helper method
- `tenants()`: BelongsToMany relationship
- `getTenants()`: Filament integration
- `canAccessTenant()`: Authorization

**Impatto**: Multi-tenancy completo

---

### Errori Rimanenti da Correggere

#### Pattern #1: Generic Model Property Access (~50 errori)
```php
// ❌ PROBLEMA
$user->name;  // PHPStan: Model non ha property $name garantita

// ✅ SOLUZIONE 1: Type hint
use Modules\User\Contracts\UserContract;
/** @var UserContract $user */
$user = auth()->user();

// ✅ SOLUZIONE 2: Safe getter
use Modules\Xot\Actions\Model\SafeAttributeCastAction;
$name = SafeAttributeCastAction::getString($user, 'name', 'Guest');
```

**Tempo Fix**: 3-4 ore  
**Priorità**: ALTA

---

#### Pattern #2: Return Type Precision (~30 errori)
```php
// ❌ PROBLEMA
public function getRole()  // No return type
{
    return $this->roles()->first();  // PHPStan non sa cosa ritorna
}

// ✅ SOLUZIONE
public function getRole(): ?Role
{
    return $this->roles()->first();
}
```

**Tempo Fix**: 2-3 ore  
**Priorità**: ALTA

---

#### Pattern #3: Method Existence (~15 errori)
```php
// ❌ PROBLEMA
if (method_exists($user, 'getTeams')) {
    $teams = $user->getTeams();  // PHPStan: method non garantito
}

// ✅ SOLUZIONE: Usa contract/interface
if ($user instanceof HasTeamsContract) {
    $teams = $user->getTeams();
}
```

**Tempo Fix**: 1-2 ore  
**Priorità**: MEDIA

---

## ⚡ PERFORMANCE ISSUES

### Issue #1: Uso Diretto DB:: invece di Eloquent

**Files con DB::**:
- `app/Actions/User/UpdateUserAction.php`
- `app/Actions/Socialite/LogoutUserAction.php`
- `app/Actions/Socialite/RegisterOauthUserAction.php`
- `app/Http/Controllers/Api/LogoutController.php`
- `app/Filament/Widgets/Auth/RegisterWidget.php`

**Problema**: Bypass ORM = no caching, no events, no type safety

**Soluzione**: Convertire a Eloquent
```php
// ❌ ERRATO
DB::table('users')->where('email', $email)->first();

// ✅ CORRETTO
User::query()->where('email', $email)->first();
```

**Tempo Fix**: 2-3 ore  
**Gain**: Type safety + Events + Caching

---

### Issue #2: Passwords Hashing in Setter

**File**: `app/Models/BaseUser.php:489-499`

```php
public function setPasswordAttribute(?string $value): void
{
    if ($value === null) {
        return;
    }
    if (strlen($value) < 32) {  // ⚠️ Magic number
        $this->attributes['password'] = Hash::make($value);
        return;
    }
    $this->attributes['password'] = $value;
}
```

**Issues**:
- Magic number 32 (length hashed password)
- Potrebbe hashare password già hashata in edge cases

**Soluzione**:
```php
public function setPasswordAttribute(?string $value): void
{
    if ($value === null || $value === '') {
        return;
    }
    
    // Skip if already hashed (bcrypt/argon2 length)
    if (Str::startsWith($value, ['$2y$', '$2a$', '$argon'])) {
        $this->attributes['password'] = $value;
        return;
    }
    
    $this->attributes['password'] = Hash::make($value);
}
```

**Tempo Fix**: 20 minuti

---

### Issue #3: Eager Loading Mancante

**File**: `app/Models/BaseUser.php`

**Problema**: Relations non eager loaded by default

**Soluzione**: Aggiungere strategic eager loading
```php
protected $with = ['profile'];  // Sempre necessario

// O scope specifici:
public function scopeWithFullData($query)
{
    return $query->with(['profile', 'teams', 'tenants', 'roles', 'permissions']);
}
```

**Tempo Fix**: 30 minuti

---

## 💾 MEMORY WASTE

### Issue #1: Sessions Not Cleaned
**Problema**: Session table cresce senza cleanup

**Soluzione**: Configurare session cleanup automatico
```php
// config/session.php
'lottery' => [2, 100],  // 2% chance di cleanup

// O cron job:
php artisan session:gc
```

---

### Issue #2: Failed Jobs Accumulation
**Problema**: Failed jobs table cresce

**Soluzione**: Policy di retention
```bash
php artisan queue:prune-failed --hours=48
```

---

## 🎯 ROADMAP

### IMMEDIATE (2 Ottobre 2025)

**Obiettivo**: 0 errori PHPStan

- [ ] Correggere property access issues (3h)
- [ ] Migliorare return types (2h)
- [ ] Fix method existence checks (1h)
- [ ] Cleanup PHPStan suppressions

**Totale**: ~6 ore  
**Risultato**: ✅ 0 errori PHPStan Level 9

---

### BREVE TERMINE (Prossime 2 Settimane)

- [ ] **Convert DB:: to Eloquent** (3h)
  - UpdateUserAction
  - Socialite Actions
  - Controllers

- [ ] **Improve Password Handling** (30 min)
  - Fix magic numbers
  - Better hash detection

- [ ] **Add Eager Loading** (1h)
  - Configure $with
  - Add useful scopes

- [ ] **Write Tests** (12h)
  - BaseUser tests
  - Authentication tests
  - Authorization tests
  - Team/Tenant tests

---

### MEDIO TERMINE (Prossimo Mese)

- [ ] **Social Login Integration** (1 settimana)
  - Google OAuth
  - Facebook OAuth
  - GitHub OAuth

- [ ] **API Token Management** (3 giorni)
  - Sanctum full integration
  - Token scopes
  - Token expiration

- [ ] **Advanced Permissions** (3 giorni)
  - Custom permissions
  - Team-based permissions
  - Tenant-based permissions

- [ ] **User Activity Tracking** (2 giorni)
  - Login history complete
  - Activity log enhanced
  - Security alerts

---

### LUNGO TERMINE (Q1 2026)

- [ ] **2FA Enhancement**
  - TOTP support
  - SMS verification
  - Backup codes

- [ ] **Session Management**
  - Multiple devices
  - Session revocation
  - Security dashboard

- [ ] **User Analytics**
  - Activity metrics
  - Engagement tracking
  - Churn prediction

---

## 📋 CHECKLIST OTTIMIZZAZIONI

### Database
- [ ] Add indexes on foreign keys
- [ ] Optimize users table
- [ ] Clean old sessions
- [ ] Partition large tables

### Queries
- [ ] Eliminate DB:: usage
- [ ] Add eager loading defaults
- [ ] Use query scopes
- [ ] Implement caching

### Security
- [ ] Rate limiting login
- [ ] Brute force protection
- [ ] Password strength validation
- [ ] Audit log complete

### Code Quality
- [ ] Fix 95 PHPStan errors
- [ ] Test coverage 80%+
- [ ] Remove deprecated code
- [ ] Update documentation

---

## 🔧 MIGLIORAMENTI SUGGERITI

### Architettura
1. **Separare BaseUser** in traits più piccoli
   - AuthenticationTrait
   - AuthorizationTrait
   - ProfileTrait
   - TeamsTrait

2. **Implementare DTOs** per user data
   - UserData (Spatie Laravel Data)
   - ProfileData
   - TeamData

3. **Event Sourcing** per audit completo
   - UserCreated
   - UserUpdated
   - RoleAssigned
   - PermissionGranted

---

## 🔗 Collegamenti

- [← User Module README](./README.md)
- [← PHPStan Fixes 2025-10-01](./phpstan-fixes-2025-10-01.md)
- [← Project Roadmap](../../../docs/project-analysis-and-roadmap.md)
- [← Root Documentation](../../../docs/index.md)

---

**Status**: ⚠️ 95 ERRORI DA CORREGGERE  
**Priorità**: 🟡 ALTA  
**Timeline**: 2 Ottobre 2025  
**Effort**: ~6 ore → 100% CLEAN



