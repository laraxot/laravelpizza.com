# PHPStan Corrections Summary - Modulo User

**Data**: 2025-01-22  
**Status**: In Progress  
**Versione**: 1.0.0

## 📊 Stato Attuale

### Errori Corretti

1. **AuthenticationLogResource.php**
   - ✅ Tipizzato array `$data` con shape type per `login_from` e `login_until`
   - ✅ Corretto controllo `isset()` e `!== null` con type narrowing

2. **ViewAuthenticationLog.php**
   - ✅ Aggiunto import `Safe\json_encode` per sicurezza
   - ✅ Tipizzato `$record` come `AuthenticationLog` invece di `mixed`
   - ✅ Corretto accesso a `$authenticatable->exists` con `method_exists()` check
   - ✅ Tipizzato `$state` in `formatStateUsing` per `json_encode`

3. **ClientResource.php**
   - ✅ Aggiunto PHPDoc per `GetAllOwnersRelationshipUseCase` e `SaveOwnershipRelationUseCase`
   - ✅ Tipizzato `$useCase` per evitare errori "unknown class"

4. **ListClients.php**
   - ✅ Tipizzato `$record` come `Client` in tutte le closure
   - ✅ Aggiunto type hints espliciti per `description()`, `tooltip()` callbacks

## 🔍 Pattern di Correzione Applicati

### Pattern 1: Array Shape Types

```php
// ❌ PRIMA
->query(function (Builder $query, array $data): Builder {
    if (isset($data['login_from']) && $data['login_from'] !== null) {
        // PHPStan: mixed type
    }
});

// ✅ DOPO
->query(function (Builder $query, array $data): Builder {
    /** @var array{login_from?: \DateTimeInterface|string|null, login_until?: \DateTimeInterface|string|null} $data */
    if (isset($data['login_from']) && $data['login_from'] !== null) {
        /** @var \DateTimeInterface|string $date */
        $date = $data['login_from'];
        // Type narrowing corretto
    }
});
```

### Pattern 2: Model Type Narrowing

```php
// ❌ PRIMA
->url(function (mixed $state, ?Model $record): ?string {
    $authenticatable = $record->authenticatable; // PHPStan: mixed
    if ($authenticatable->exists) { // PHPStan: property access on mixed
    }
});

// ✅ DOPO
->url(function (mixed $state, ?Model $record): ?string {
    if (! $record instanceof AuthenticationLog) {
        return null;
    }
    $authenticatable = $record->authenticatable;
    if ($authenticatable !== null && method_exists($authenticatable, 'exists') && $authenticatable->exists) {
        // Type narrowing corretto
    }
});
```

### Pattern 3: Safe Functions

```php
// ❌ PRIMA
->formatStateUsing(fn ($state) => $state ? json_encode($state, ...) : '');

// ✅ DOPO
->formatStateUsing(function (mixed $state): string {
    if ($state === null || $state === []) {
        return 'No location data';
    }
    /** @var array<string, mixed> $state */
    return json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
});
```

### Pattern 4: External Package Classes

```php
// ❌ PRIMA
->options(function (): Collection {
    return app(GetAllOwnersRelationshipUseCase::class)->execute();
});

// ✅ DOPO
->options(function (): Collection {
    /** @var GetAllOwnersRelationshipUseCase $useCase */
    $useCase = app(GetAllOwnersRelationshipUseCase::class);
    return $useCase->execute();
});
```

### Pattern 5: Record Typing in Closures

```php
// ❌ PRIMA
->description(fn ($record) => $record->personal_access_client ? '...' : '...');

// ✅ DOPO
->description(function (Client $record): string {
    return $record->personal_access_client ? '...' : '...';
});
```

## 📋 Errori da Risolvere

### Priorità Alta

1. **OauthAccessTokenResource.php**
   - Errori di tipo e namespace

2. **ClientHeader Widget**
   - Proprietà `$client` non inizializzata correttamente

3. **View Pages Infolist**
   - Array senza chiavi stringhe in `getInfolistSchema()`

### Priorità Media

4. **OauthPersonalAccessClient**
   - Estende classe sconosciuta

5. **Passport Client**
   - Return type mismatch

6. **Migration Cache**
   - Type hints per `Cache::forget()` e `Cache::store()`

## 🎯 Obiettivo

**Zero errori PHPStan Level 10 nel modulo User**

## 📚 Riferimenti

- [PHPStan Furious Debate](./phpstan-furious-debate-2025.md)
- [PHPStan Errors Philosophy](./phpstan-errors-philosophy.md)
- [Filament 4 Actions Namespace](./filament-4-actions-namespace.md)

---

*"Ogni errore corretto è un passo verso la perfezione. Continuiamo con determinazione."*
