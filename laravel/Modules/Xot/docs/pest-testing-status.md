# Pest Testing - Stato Attuale e Roadmap

**Data**: 9 Gennaio 2026  
**Framework**: Pest PHP 3.8.4  
**Status**: 🔄 **IN CORREZIONE**

---

## 📊 Stato Attuale

### Test Esistenti
- **Totale file test**: 226 file
- **Moduli con test**: User, Cms, Activity, Tenant, Job, Geo, Notify, Media, Lang, UI, Gdpr, Seo
- **Test funzionanti**: Parziali (alcuni moduli hanno test che passano)

### Test Funzionanti
- ✅ **User/Unit/UserModelTest.php**: 21 test passati
- ✅ **User/Unit/UserModelTest.php**: Tutti i test passano correttamente

### Test con Errori
- ❌ **User/Unit/Models/Traits/HasTeamsTest.php**: 20 test falliti
  - Problema: `toHaveMethod()` non funziona correttamente
  - Problema: `belongsToTeam()` type hint non accetta int
  - Problema: Mock non configurato correttamente
- ❌ **Activity/tests/**: 144 test falliti
  - Problema: TestCase non trovato o configurato male
  - Problema: Database migrations non eseguite correttamente

---

## 🎯 Obiettivo: 100% Coverage

### Strategia
1. **Correggere test esistenti** (non creare cose mancanti)
2. **Adattare test al codice esistente** (il sito funziona)
3. **Aumentare coverage progressivamente**
4. **Verificare ogni file con PHPStan, PHPMD, PHPInsights**

### Priorità Moduli
1. **User** - Modulo core (priorità alta)
2. **Cms** - Modulo core (priorità alta)
3. **Xot** - Framework base (priorità alta)
4. **Activity** - Business logic (priorità media)
5. **Altri moduli** - Priorità media/bassa

---

## 🔧 Comandi Esecuzione

### Esecuzione Base
```bash
cd laravel

# Test singolo modulo
./vendor/bin/pest Modules/User/tests/

# Test specifico file
./vendor/bin/pest Modules/User/tests/Unit/UserModelTest.php

# Test con coverage
./vendor/bin/pest Modules/User/tests/ --coverage --min=100

# Test con output verboso
./vendor/bin/pest Modules/User/tests/ -vv
```

### Verifica Qualità
```bash
# PHPStan
./vendor/bin/phpstan analyse Modules/User --level=10

# PHPMD
./vendor/bin/phpmd Modules/User text codesize,design

# PHPInsights
./vendor/bin/phpinsights analyse Modules/User
```

---

## 📋 Errori Comuni e Soluzioni

### Errore 1: `toHaveMethod()` non funziona
**Problema**: `expect($object)->toHaveMethod('methodName')` fallisce

**Soluzione**: Usare `method_exists()` direttamente:
```php
// ❌ ERRATO
expect($this->user)->toHaveMethod('teams');

// ✅ CORRETTO
expect(method_exists($this->user, 'teams'))->toBeTrue();
```

### Errore 2: Type hint non accetta int
**Problema**: `belongsToTeam(int $teamId)` ma type hint richiede `TeamContract`

**Soluzione**: Modificare test per usare Team model o modificare type hint:
```php
// ❌ ERRATO (se type hint non accetta int)
$result = $this->user->belongsToTeam(5);

// ✅ CORRETTO (usare Team model)
$team = new Team();
$team->id = 5;
$result = $this->user->belongsToTeam($team);
```

### Errore 3: Mock non configurato
**Problema**: Mock non restituisce valori corretti

**Soluzione**: Configurare mock correttamente:
```php
// ✅ CORRETTO
$this->user = \Mockery::mock(MockUserWithTeams::class)->makePartial();
$this->user->shouldReceive('teams')
    ->andReturn(\Mockery::mock(BelongsToMany::class));
```

### Errore 4: TestCase non trovato
**Problema**: `TestCaseClassOrTraitNotFound`

**Soluzione**: Verificare che `Pest.php` del modulo estenda TestCase corretto:
```php
// ✅ CORRETTO
pest()->extend(TestCase::class)->in('Feature', 'Unit');
```

---

## 📝 Pattern di Correzione Test

### Pattern 1: Test con Mock
```php
beforeEach(function () {
    $this->user = \Mockery::mock(User::class)->makePartial();
    $this->user->shouldReceive('teams')
        ->andReturn(\Mockery::mock(BelongsToMany::class));
});

test('user has teams relationship', function () {
    expect($this->user->teams())->toBeInstanceOf(BelongsToMany::class);
});
```

### Pattern 2: Test con Factory
```php
test('user can be created', function () {
    $user = User::factory()->create();
    
    expect($user)->toBeInstanceOf(User::class)
        ->and($user->id)->not->toBeNull();
});
```

### Pattern 3: Test con Database
```php
test('user can be saved to database', function () {
    $user = User::factory()->make();
    $user->save();
    
    expect($user->exists)->toBeTrue()
        ->and(User::find($user->id))->not->toBeNull();
});
```

---

## 🎯 Roadmap Correzione

### Fase 1: Correzione Test Critici (In Corso)
- [x] Correggere `static function` in HasTeamsTest
- [ ] Correggere `toHaveMethod()` in HasTeamsTest
- [ ] Correggere type hint `belongsToTeam()` in HasTeamsTest
- [ ] Correggere TestCase Activity

### Fase 2: Verifica Test Funzionanti
- [ ] Verificare tutti i test User
- [ ] Verificare tutti i test Cms
- [ ] Verificare tutti i test Xot

### Fase 3: Coverage 100%
- [ ] Aumentare coverage User al 100%
- [ ] Aumentare coverage Cms al 100%
- [ ] Aumentare coverage Xot al 100%
- [ ] Aumentare coverage altri moduli al 100%

### Fase 4: Verifica Qualità
- [ ] PHPStan Level 10 su tutti i test
- [ ] PHPMD su tutti i test
- [ ] PHPInsights su tutti i test

---

## 📚 Documentazione Correlata

- [Pest Execution Guide](./pest-execution-guide.md) - Come eseguire Pest
- [Testing Rules](./testing-rules.md) - Regole fondamentali
- [Testing Best Practices](./testing-best-practices.md) - Best practices

---

**Ultimo aggiornamento**: 9 Gennaio 2026  
**Status**: 🔄 **IN CORREZIONE**
