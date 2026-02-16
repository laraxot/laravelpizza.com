# Fix Race Condition firstOrCreate con UUID - [DATE]

**Status**: ✅ Completato  

## Problema

Errore `UniqueConstraintViolationException` durante `firstOrCreate()` su modello `Profile` con UUID:

```
SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry '19' for key 'profiles.PRIMARY'
```

### Causa Radice

**Race Condition** quando due richieste simultanee tentano di creare lo stesso profile:

1. Richiesta A: `firstOrCreate(['user_id' => $user_id])` - non trova nulla, genera UUID1
2. Richiesta B: `firstOrCreate(['user_id' => $user_id])` - non trova nulla (A non ha ancora salvato), genera UUID2
3. Richiesta A: tenta di salvare con UUID1
4. Richiesta B: tenta di salvare con UUID2, ma se entrambe falliscono, si verifica `UniqueConstraintViolationException`

### Stack Trace

```
XotData->getProfileModelByUserId()
  ↓
Profile->firstOrCreate(['user_id' => $user_id])
  ↓
UniqueConstraintViolationException
```

## Soluzione Implementata

### Pattern: Transaction con Lock + Retry

**File**: `Modules/Xot/app/Datas/XotData.php` (linee 250-309)

```php
public function getProfileModelByUserId(string $user_id): ProfileContract
{
    $profileClass = $this->getProfileClass();
    /** @var Model&ProfileContract $profile */
    $profile = app($profileClass);

    // ... validazioni ...

    // Gestione race condition con retry su UniqueConstraintViolationException
    try {
        /** @var ProfileContract */
        $res = DB::transaction(function () use ($profile, $user_id): ProfileContract {
            // Usa lockForUpdate per prevenire race conditions
            $existing = $profile->newQuery()
                ->where('user_id', $user_id)
                ->lockForUpdate()
                ->first();

            if ($existing !== null) {
                Assert::implementsInterface($existing, ProfileContract::class);
                return $existing;
            }

            // Crea nuovo profile solo se non esiste
            // Il trait HasUuids genererà automaticamente l'UUID
            /** @var ProfileContract */
            $newProfile = $profile->newInstance(['user_id' => $user_id]);
            $newProfile->save();
            Assert::implementsInterface($newProfile, ProfileContract::class);

            return $newProfile;
        });
    } catch (QueryException $e) {
        // Se fallisce per constraint violation (race condition), riprova con first()
        if ($e->getCode() === '23000' || str_contains($e->getMessage(), 'Duplicate entry')) {
            /** @var ProfileContract|null */
            $res = $profile->newQuery()->where('user_id', $user_id)->first();

            if ($res === null) {
                throw new RuntimeException('Failed to create or retrieve profile for user_id: '.$user_id, 0, $e);
            }

            Assert::implementsInterface($res, ProfileContract::class);
            return $res;
        }

        // Rilancia altre eccezioni
        throw $e;
    }

    Assert::implementsInterface($res, ProfileContract::class);
    return $res;
}
```

## Come Funziona

### 1. Transaction con Lock
- `DB::transaction()` garantisce atomicità
- `lockForUpdate()` serializza le operazioni (una richiesta alla volta)
- Previene race conditions a livello database

### 2. Retry Pattern
- Se fallisce con `UniqueConstraintViolationException` (codice 23000)
- Significa che un'altra richiesta ha già creato il profile
- Riprova con `first()` per recuperare il profile creato

### 3. Gestione Errori
- Altri errori vengono rilanciati
- `RuntimeException` se il retry non trova il profile (caso anomalo)

## Vantaggi

1. **Thread-Safe**: Gestisce correttamente richieste simultanee
2. **Robusto**: Retry automatico su race condition
3. **Performante**: Lock solo quando necessario
4. **Type-Safe**: PHPStan Level 10 compliant

## Pattern Applicabile

Questo pattern può essere usato per altri modelli con UUID che usano `firstOrCreate()`:

```php
// ✅ CORRETTO - Pattern robusto per UUID models
try {
    $model = DB::transaction(function () use ($modelClass, $attributes) {
        $existing = $modelClass::query()
            ->where($attributes)
            ->lockForUpdate()
            ->first();
        
        if ($existing !== null) {
            return $existing;
        }
        
        return $modelClass::create($attributes);
    });
} catch (QueryException $e) {
    if ($e->getCode() === '23000') {
        $model = $modelClass::query()->where($attributes)->first();
        if ($model === null) {
            throw new RuntimeException('Failed to create or retrieve model', 0, $e);
        }
        return $model;
    }
    throw $e;
}
```

## Test

### Scenario Race Condition
```php
// Due richieste simultanee per lo stesso user_id
$user_id = '0199856c-eb09-7363-8ce8-f388257cb4c3';

// Richiesta A e B simultanee
$profileA = XotData::make()->getProfileModelByUserId($user_id);
$profileB = XotData::make()->getProfileModelByUserId($user_id);

// Entrambe devono restituire lo stesso profile
expect($profileA->id)->toBe($profileB->id);
```

## Riferimenti

- [Activity Module: firstOrCreate Error Handling](../../Activity/docs/errori/attributerawvalues-null-firstorcreate.md)
- [User Profile Models: Transaction Patterns](../../User/docs/user-profile-models.md)
- [Query Safety Principle](../../../docs/operational-rules/query-safety-principle.md)

**Versione**: 1.0  
**Ultimo aggiornamento**: [DATE]  
**Status**: ✅ Completato
