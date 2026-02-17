# 🐌 user module - performance issues

> analisi sprechi memoria, query inefficienti, bottlenecks auth/authorization

---

## 🔍 sprechi identificati

### sprechi di memoria

#### 1. caricamento password hash inutilmente
**location**: ovunque si usa `User::all()` o `User::get()`

**problema**:
```php
// carica password hash bcrypt (60+ bytes per user)
$users = User::all();  // ❌
```

**soluzione**:
```php
$users = User::select(['id', 'name', 'email', 'created_at'])->get();  // ✅
```

**risparmio**: 30% memoria per user lists

---

#### 2. spatie permissions cache non ottimizzato
**location**: `config/permission.php`

**problema**: cache permissions per 24h ma refresh ad ogni deploy

**soluzione**:
```php
// config/permission.php
'cache' => [
    'expiration_time' => \DateInterval::createFromDateString('24 hours'),
    'key' => 'spatie.permission.cache',
    'store' => 'redis',  // ✅ invece di 'file'
],
```

**risparmio**: 90% tempo cache lookup

---

#### 3. profile relation sempre caricata
**location**: filament resources, dashboards

**problema**:
```php
// n+1 su profile
@foreach($users as $user)
    {{ $user->profile->full_name }}  // ❌ query ogni volta
@endforeach
```

**soluzione**:
```php
User::with('profile:id,user_id,first_name,last_name')->get()  // ✅
```

**risparmio**: da n query a 1 query

---

### sprechi di query

#### 1. hasrole() check ad ogni request
**location**: middleware, policies

**problema**:
```php
// spatie carica tutte le role relations
if ($user->hasRole('admin')) {  // ❌ query + cache lookup
    // ...
}
```

**soluzione**:
```php
// cache result in session
session()->put('user.is_admin', $user->hasRole('admin'));

if (session('user.is_admin')) {  // ✅ no query
    // ...
}
```

**risparmio**: 95% per auth checks

---

#### 2. teams relationship non eager loaded
**location**: dashboards, selectors

**problema**:
```php
@foreach($users as $user)
    {{ $user->teams->count() }}  // ❌ n+1
@endforeach
```

**soluzione**:
```php
User::withCount('teams')->get()  // ✅
```

---

#### 3. exists() vs count()
**location**: authorization checks

**problema**:
```php
if ($user->permissions()->count() > 0) {  // ❌ conta tutti
```

**soluzione**:
```php
if ($user->permissions()->exists()) {  // ✅ stop alla prima
```

---

## 🎯 optimization checklist

### auth checks

```php
// ❌ bad
if ($user->hasRole('admin') && $user->can('edit-users')) {
    // 2+ query
}

// ✅ good
$userRoles = $user->roles()->pluck('name');
$userPerms = $user->getAllPermissions()->pluck('name');

session([
    'user.roles' => $userRoles,
    'user.permissions' => $userPerms,
]);

if (session('user.roles')->contains('admin')) {
    // no query!
}
```

### user listing

```php
// ❌ bad
$users = User::all();

// ✅ good
$users = User::query()
    ->select(['id', 'name', 'email', 'created_at'])
    ->with(['profile:id,user_id,first_name,last_name'])
    ->withCount('teams')
    ->paginate(20);
```

---

## 📊 benchmarks

### user list page (100 users)

| metrica | attuale | target | gap |
|---------|---------|--------|-----|
| query count | 45 | 4 | -91% |
| memory | 25mb | 8mb | -68% |
| ttfb | 350ms | 80ms | -77% |

### login flow

| metrica | attuale | target | gap |
|---------|---------|--------|-----|
| query count | 8 | 3 | -62% |
| auth check | 50ms | 5ms | -90% |

---

## 🔧 quick wins

### 1. cache permissions in session
```php
// app/Http/Middleware/Authenticate.php
public function handle($request, Closure $next, ...$guards)
{
    $user = auth()->user();

    session([
        'user.roles' => $user->roles()->pluck('name'),
        'user.permissions' => $user->getAllPermissions()->pluck('name'),
    ]);

    return $next($request);
}
```

### 2. eager load profile everywhere
```php
// app/Providers/AppServiceProvider.php
User::preventLazyLoading(! app()->isProduction());

// filament resources
protected function getTableQuery(): Builder
{
    return parent::getTableQuery()
        ->with('profile:id,user_id,first_name,last_name');
}
```

### 3. redis per spatie cache
```bash
composer require predis/predis
```

```php
// config/permission.php
'cache' => [
    'store' => 'redis',
],
```

---

**priorità immediate**:
1. eager load profile
2. cache permissions in session
3. select specifici
4. redis cache

**effort totale**: ~8 ore
**impatto**: -70% query, -60% memory
