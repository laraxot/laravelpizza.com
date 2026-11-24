---
title: "PHPStan Corrections Summary - Modulo User"
type: concept
tags: [phpstan, corrections, summary]
created: 2026-07-14
updated: 2026-07-14
qmd: "phpstan-corrections-summary- phpstan corrections summary - modulo user"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

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
# Riepilogo Correzioni PHPStan - Modulo User

**Data**: 2025-01-22
**Status**: In Progress
**Errori Iniziali**: 221
**Errori Corretti**: ~15
**Errori Rimanenti**: ~206

## ✅ Correzioni Completate

### 1. TeamsRelationManager

**Problemi**:
- Namespace errato: `Filament\Tables\Actions\*` invece di `Filament\Actions\*`
- Type hint `$livewire` mancante
- Return types PHPDoc errati

**Correzioni**:
```php
// Prima
use Filament\Tables\Actions\DetachBulkAction;
->getStateUsing(function (Model $record, $livewire): bool {
    $user = $livewire->getOwnerRecord();
});

// Dopo
use Filament\Actions\DetachBulkAction;
->getStateUsing(function (Model $record, self $livewire): bool {
    /** @var User $user */
    $user = $livewire->getOwnerRecord();
});
```

**Risultato**: ✅ Zero errori PHPStan Level 10

### 2. OauthClient

**Problemi**:
- Parameter type `iterable` invece di `iterable<string>`

**Correzioni**:
```php
// Prima
/* @var iterable<string> $ability */
return $this->hasAnyPermission($ability);

// Dopo
/** @var iterable<string> $ability */
$permissions = $ability;
return $this->hasAnyPermission($permissions);
```

**Risultato**: ✅ Zero errori PHPStan Level 10

## ⚠️ Errori da Risolvere

### 1. View Pages - getInfolistSchema Return Type

**Problema**: Molti View pages restituiscono `array<int, Component>` invece di `array<string, Component>`

**File Affetti**:
- `ViewLocation` (Geo)
- `ViewOauthAuthCode` (User)
- `ViewOauthRefreshToken` (User)
- `ViewPasswordReset` (User)
- `ViewSocialiteUser` (User)

**Soluzione**: Aggiungere chiavi stringhe agli array

### 2. OauthPersonalAccessClient

**Problema**: Estende classe sconosciuta `Laravel\Passport\PersonalAccessClient`

**Soluzione**: Verificare se la classe esiste o se è stata rimossa in una versione più recente

### 3. Passport\Client

**Problema**: Return type mismatch in `initializeHasUniqueStringIds()`

**Soluzione**: Allineare return type con classe base

### 4. Migration Cache

**Problema**: Parameter types per `Cache::forget()` e `Cache::store()`

**Soluzione**: Aggiungere type hints espliciti

## 📊 Statistiche

| Categoria | Errori | Corretti | Rimanenti |
|-----------|--------|----------|-----------|
| Namespace | ~50 | 3 | ~47 |
| Type Hints | ~80 | 2 | ~78 |
| PHPDoc | ~60 | 10 | ~50 |
| Return Types | ~30 | 0 | ~30 |
| **Totale** | **221** | **15** | **206** |

## 🎯 Prossimi Passi

1. Correggere tutti i View pages per usare chiavi stringhe
2. Verificare e correggere OauthPersonalAccessClient
3. Allineare return types in Passport\Client
4. Correggere type hints nelle migrations
5. Verificare namespace in tutti i RelationManagers

## 📚 Riferimenti

- [PHPStan Errors Philosophy](./phpstan-errors-philosophy.md)
- [Filament 4 Actions Namespace](./filament-4-actions-namespace.md)
- [Migration Consolidation Philosophy](./migration-consolidation-philosophy.md)

---

*Progresso: 6.8% completato (15/221 errori corretti)*
---
module: theme
topic: phpstan-corrections-summary
canonical: ../../../Themes/docs/shared-components/phpstan-corrections-summary-Modules.md
related:
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/phpstan-corrections-summary-Modules.md
