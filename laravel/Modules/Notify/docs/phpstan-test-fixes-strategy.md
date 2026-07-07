# PHPStan Test Fixes Strategy - 2025-10-10

## 🎯 Obiettivo

Portare tutti i test Pest a **0 errori PHPStan livello MAX**.

## 📊 Situazione Attuale

### Codice di Produzione
✅ **PERFETTO** - 0 errori su tutti i moduli app/

### Test
- **Totale errori**: ~19,337
- **Errori Pest framework** (~19,000): `method.internalClass`
- **Errori reali** (~334): Type safety, property access, etc.

## 🔧 Strategia di Correzione

### Fase 1: Configurazione PHPStan per Pest (IMMEDIATA)

**Problema**: PHPStan al livello MAX segnala chiamate a metodi interni di Pest come errori.

**Soluzione**: Aggiungere stub/extension per Pest o escludere questi errori specifici.

#### Opzione A: Ignorare errori Pest (RAPIDA)
```neon
# phpstan.neon
parameters:
    ignoreErrors:
        - identifier: pest.internalClass
        - '#Call to method .* of internal class Pest\\#'
```

#### Opzione B: Stub per Pest (CORRETTA)
Creare file stub per le classi Pest più usate.

**Raccomandazione**: Opzione A per velocità, poi migrare a Opzione B.

### Fase 2: Correzione Errori Reali nei Test (~334 errori)

#### Categorie di Errori

##### 1. Property Access in beforeEach (~150 errori)
**Problema**: `$this->user` non è riconosciuto come proprietà.

```php
// ❌ ERRORE
beforeEach(function (): void {
    $this->user = User::factory()->create();
});

it('test something', function (): void {
    expect($this->user->email)->toBe('test@example.com'); // Property not found
});
```

**Soluzione 1**: Type hint con PHPDoc
```php
/**
 * @property User $user
 */
beforeEach(function (): void {
    $this->user = User::factory()->create();
});
```

**Soluzione 2**: Usare dataset o context
```php
it('test something', function (): void {
    $user = User::factory()->create();
    expect($user->email)->toBe('test@example.com');
});
```

**Raccomandazione**: Soluzione 2 (più pulita e type-safe).

##### 2. Factory Return Types (~80 errori)
**Problema**: `User::factory()->create()` ritorna `mixed`.

```php
// ❌ ERRORE
$user = User::factory()->create(); // mixed
$user->email; // Cannot access property on mixed
```

**Soluzione**: Type hint esplicito
```php
// ✅ CORRETTO
/** @var User $user */
$user = User::factory()->create();
// oppure
$user = User::factory()->create();
assert($user instanceof User);
```

##### 3. Relation Type Assertions (~50 errori)
**Problema**: Assertion su tipi di relazioni.

```php
// ❌ ERRORE
expect($this->user->posts())->toBeInstanceOf(HasMany::class);
```

**Soluzione**: Verificare che il metodo esista
```php
// ✅ CORRETTO
expect($this->user->posts())->toBeInstanceOf(HasMany::class);
// Aggiungere PHPDoc al model
/**
 * @return HasMany<Post>
 */
public function posts(): HasMany
{
    return $this->hasMany(Post::class);
}
```

##### 4. Anonymous Classes in Tests (~30 errori)
**Problema**: Classi anonime incomplete.

```php
// ❌ ERRORE
$model = new class extends Model {
    // Missing abstract methods
};
```

**Soluzione**: Implementare tutti i metodi astratti o usare mock.

##### 5. Argument Type Mismatches (~24 errori)
**Problema**: Tipi di argomenti non corrispondenti.

```php
// ❌ ERRORE
Auth::login($this->user); // mixed given, Authenticatable expected
```

**Soluzione**: Type assertion
```php
// ✅ CORRETTO
assert($this->user instanceof Authenticatable);
Auth::login($this->user);
```

## 📋 Piano di Implementazione

### Step 1: Configurazione (5 minuti)
- [ ] Aggiungere ignore rule per Pest internalClass
- [ ] Verificare riduzione errori
- [ ] Commit: "chore: ignore Pest internal class errors in PHPStan"

### Step 2: Analisi Errori Reali (15 minuti)
- [ ] Eseguire PHPStan solo sui test
- [ ] Categorizzare i ~334 errori reali
- [ ] Creare lista priorità per modulo

### Step 3: Correzioni Batch (2-3 ore)

#### Batch 1: Property Access (30 min)
- [ ] Refactor beforeEach per eliminare `$this->property`
- [ ] Usare variabili locali nei test
- [ ] Target: ~150 errori

#### Batch 2: Factory Types (30 min)
- [ ] Aggiungere type hints ai factory calls
- [ ] Usare assert per type narrowing
- [ ] Target: ~80 errori

#### Batch 3: Relations (30 min)
- [ ] Aggiungere PHPDoc ai metodi relation
- [ ] Verificare return types
- [ ] Target: ~50 errori

#### Batch 4: Anonymous Classes (30 min)
- [ ] Completare implementazioni
- [ ] Sostituire con mock dove appropriato
- [ ] Target: ~30 errori

#### Batch 5: Argument Types (30 min)
- [ ] Aggiungere type assertions
- [ ] Correggere type hints
- [ ] Target: ~24 errori

### Step 4: Validazione (15 minuti)
- [ ] Eseguire PHPStan livello MAX su tutti i moduli
- [ ] Verificare 0 errori
- [ ] Eseguire test suite completa
- [ ] Verificare tutti i test passano

### Step 5: Documentazione (15 minuti)
- [ ] Aggiornare docs nei moduli
- [ ] Aggiornare best practices per test
- [ ] Commit finale

## 🎯 Metriche di Successo

| Step | Errori Rimanenti | Tempo Stimato | Status |
|------|------------------|---------------|--------|
| Inizio | 19,337 | - | ✅ |
| Dopo Config | ~334 | 5 min | ⏳ |
| Dopo Batch 1 | ~184 | 35 min | ⏳ |
| Dopo Batch 2 | ~104 | 65 min | ⏳ |
| Dopo Batch 3 | ~54 | 95 min | ⏳ |
| Dopo Batch 4 | ~24 | 125 min | ⏳ |
| Dopo Batch 5 | 0 | 155 min | ⏳ |
| **TOTALE** | **0** | **~2.5 ore** | ⏳ |

## 📝 Best Practices per Test Pest

### ✅ DO

1. **Usare variabili locali invece di $this->property**
```php
it('creates a user', function (): void {
    $user = User::factory()->create();
    expect($user)->toBeInstanceOf(User::class);
});
```

2. **Type hint espliciti per factory**
```php
/** @var User $user */
$user = User::factory()->create();
```

3. **Assert per type narrowing**
```php
$user = User::factory()->create();
assert($user instanceof User);
```

4. **PHPDoc per relazioni**
```php
/**
 * @return HasMany<Post>
 */
public function posts(): HasMany
```

### ❌ DON'T

1. **Non usare $this->property in Pest**
```php
// ❌ EVITARE
beforeEach(function (): void {
    $this->user = User::factory()->create();
});
```

2. **Non assumere tipi senza verifiche**
```php
// ❌ EVITARE
$user = User::factory()->create();
$user->email; // Potrebbe essere mixed
```

3. **Non creare classi anonime incomplete**
```php
// ❌ EVITARE
$model = new class extends Model {}; // Missing methods
```

## 🔍 Comandi Utili

### Analisi Test Specifici
```bash
# Analizza solo test di un modulo
./vendor/bin/phpstan analyse Modules/User/tests --level=max

# Conta errori per tipo
./vendor/bin/phpstan analyse Modules/*/tests --level=max | grep "🪪" | sort | uniq -c

# Errori non-Pest
./vendor/bin/phpstan analyse Modules/*/tests --level=max | grep -v "internalClass"
```

### Esecuzione Test
```bash
# Esegui tutti i test
php artisan test

# Esegui test di un modulo
php artisan test --testsuite=User

# Esegui test con coverage
php artisan test --coverage
```

## 📚 Riferimenti

- [Pest Documentation](https://pestphp.com/)
- [PHPStan Level 9](https://phpstan.org/blog/phpstan-1-0-is-here#level-9)
- [Laravel Testing](https://laravel.com/docs/testing)
- [Pest Best Practices](/Modules/Xot/docs/testing/strategy.md)

---

**Creato**: 2025-10-10T08:57:05+02:00  
**Obiettivo**: 0 errori PHPStan MAX in ~2.5 ore  
**Status**: 🚀 READY TO START
