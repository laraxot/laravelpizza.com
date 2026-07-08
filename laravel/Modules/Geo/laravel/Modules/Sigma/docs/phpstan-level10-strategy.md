# Strategia Risoluzione PHPStan Level 10 - Modulo Sigma

> **Data**: Gennaio 2025  
> **Status**: 🚧 In Lavorazione  
> **Errori Totali**: 1017  
> **Priorità**: Alta

## 📊 Executive Summary

Il modulo Sigma presenta **1017 errori PHPStan livello 10**, principalmente legati a:
- Tipizzazione `mixed` non risolta (circa 60% degli errori)
- Problemi con generics nelle relazioni Eloquent (covarianza template types)
- Trait complessi con metodi dinamici (`FunctionExtra`, `MassExtra`)
- Accesso a proprietà dinamiche non tipizzate

## 🎯 Pattern di Errori Identificati

### 1. Generics nelle Relazioni Eloquent (Covarianza Template Types)

**Errore Tipico**:
```
Method Modules\Sigma\Models\Dipt00f::anag() should return 
Illuminate\Database\Eloquent\Relations\HasOne<Modules\Sigma\Models\Anag, static(Modules\Sigma\Models\Dipt00f)> 
but returns 
Illuminate\Database\Eloquent\Relations\HasOne<Modules\Sigma\Models\Anag, $this(Modules\Sigma\Models\Dipt00f)>.
```

**Causa**: PHPStan non supporta la covarianza dei template types `TDeclaringModel` nelle relazioni Eloquent.

**Soluzione**:
```php
// ❌ ERRATO
/**
 * @return HasOne<Anag, static>
 */
public function anag(): HasOne
{
    return $this->hasOne(Anag::class, 'matr', 'dtmatr');
}

// ✅ CORRETTO
/**
 * @return HasOne<Anag, Dipt00f>
 */
public function anag(): HasOne
{
    /** @var HasOne<Anag, Dipt00f> $relation */
    $relation = $this->hasOne(Anag::class, 'matr', 'dtmatr');
    
    return $relation;
}
```

**File Affetti**: `Dipt00f.php`, `Qua00f.php`, `Rep00f.php`, e altri modelli con relazioni.

### 2. Binary Operations su Mixed

**Errore Tipico**:
```
Binary operation "." between '<br/>ente: ' and mixed results in an error.
```

**Causa**: Variabili non tipizzate utilizzate in concatenazioni di stringhe.

**Soluzione**:
```php
// ❌ ERRATO
echo '<br/>ente: '.$this->ente;

// ✅ CORRETTO
echo '<br/>ente: '.(string) $this->ente;
// Oppure meglio ancora:
\Log::error('Messaggio', ['ente' => (string) $this->ente]);
```

**File Affetti**: `Dipt00f.php`, `FunctionExtra.php`, `MassExtra.php`, `Qua00k1.php`, `Qua03f.php`, `Sto00f.php`.

### 3. Property Access su Mixed

**Errore Tipico**:
```
Cannot access property $st2kas on Illuminate\Database\Eloquent\Model.
Access to an undefined property Modules\Sigma\Models\Repart::$created_by.
```

**Causa**: PHPStan non riconosce le proprietà dinamiche dei modelli Eloquent o proprietà mancanti.

**Soluzione**:
```php
// ❌ ERRATO
$sto00f = $this->anag->sto00f()->first();
return (string) $sto00f->st2kas;

// ✅ CORRETTO
/** @var Sto00f|null $sto00f */
$sto00f = $this->anag->sto00f()->first();
if ($sto00f === null) {
    return '---';
}

$st2kas = $sto00f->st2kas ?? null;
return $st2kas !== null ? (string) $st2kas : '---';
```

**File Affetti**: `Dipt00f.php`, `Rep00f.php`, `RepartPolicy.php`, `Qua00f.php`.

### 4. Trait Complessi con Metodi Dinamici

**Errore Tipico**:
```
Cannot call method whereRaw() on mixed.
Cannot access property $tot on Illuminate\Database\Eloquent\Model|null.
Variable $date_min might not be defined.
```

**Causa**: `FunctionExtra.php` e `MassExtra.php` sono trait complessi che utilizzano metodi dinamici e variabili non sempre definite.

**Strategia**:
1. **Refactoring Graduale**: Suddividere i metodi complessi in metodi più piccoli e tipizzati
2. **Type Guards**: Aggiungere controlli di tipo espliciti prima dell'uso
3. **PHPDoc Completo**: Documentare tutti i parametri e valori di ritorno

**File Affetti**: `FunctionExtra.php` (circa 400 errori), `MassExtra.php` (circa 200 errori).

### 5. Return Types Mancanti o Errati

**Errore Tipico**:
```
Method Modules\Sigma\Models\Qua00f::posizioniEconomicheOfYearCollection() should return 
Illuminate\Support\Collection<string, array<string, mixed>> 
but returns 
Illuminate\Support\Collection<string, non-empty-array<'anno'|'disci1'|...>>.
```

**Causa**: Return types troppo specifici o mancanti.

**Soluzione**:
```php
// ✅ CORRETTO
/**
 * @return Collection<string, array<string, mixed>>
 */
public function posizioniEconomicheOfYearCollection(array $params): Collection
{
    // Implementazione...
}
```

**File Affetti**: `Qua00f.php`, `FunctionExtra.php`, `WebService.php`.

### 6. Problemi con Policy

**Errore Tipico**:
```
Cannot access property $perm_type on mixed.
Access to an undefined property Modules\Sigma\Models\Repart::$created_by.
```

**Causa**: `UserContract` non ha la proprietà `perm` tipizzata correttamente.

**Soluzione**:
```php
// ✅ CORRETTO
public function before(UserContract $user): ?bool
{
    if (! isset($user->perm)) {
        return null;
    }
    
    // Usare type assertion più specifica
    /** @var object{perm_type: int} $perm */
    $perm = $user->perm;
    if ($perm->perm_type < 5) {
        return null;
    }
    
    return true;
}
```

**File Affetti**: `RepartPolicy.php`.

## 📋 Piano di Lavoro Prioritizzato

### Fase 1: Fix Critici (2-3 giorni)
**Priorità**: Alta  
**Obiettivo**: Ridurre errori da 1017 a ~800

1. **Fix Generics Relazioni** (circa 50 errori)
   - `Dipt00f.php`: `anag()`, `turn01l1()`, `qua00f()`
   - `Qua00f.php`: tutte le relazioni
   - `Rep00f.php`: tutte le relazioni

2. **Fix Binary Operations** (circa 100 errori)
   - `Dipt00f.php`: accessor `getAssunzioneAttribute()`, `getDimissioneAttribute()`
   - `Qua00k1.php`: metodi con date
   - `Qua03f.php`: metodi con date
   - `Sto00f.php`: metodi con date

3. **Fix Property Access** (circa 50 errori)
   - `Dipt00f.php`: accesso a `Sto00f` properties
   - `Rep00f.php`: accesso a proprietà dinamiche
   - `RepartPolicy.php`: accesso a `$user->perm`

### Fase 2: Refactoring Trait Complessi (5-7 giorni)
**Priorità**: Media  
**Obiettivo**: Ridurre errori da ~800 a ~400

1. **FunctionExtra.php** (circa 400 errori)
   - Suddividere metodi complessi
   - Aggiungere type guards
   - Tipizzare parametri e return types

2. **MassExtra.php** (circa 200 errori)
   - Stessa strategia di `FunctionExtra.php`

### Fase 3: Fix Residui (3-4 giorni)
**Priorità**: Bassa  
**Obiettivo**: Ridurre errori da ~400 a 0

1. **Fix Return Types** (circa 100 errori)
   - `Qua00f.php`: metodi collection
   - `WebService.php`: return types
   - Altri file con return types mancanti

2. **Fix Variabili Non Definite** (circa 50 errori)
   - `FunctionExtra.php`: variabili `$date_min`, `$date_max`, `$anno`
   - Aggiungere inizializzazione esplicita

3. **Fix Offset Access** (circa 50 errori)
   - Tipizzare array access
   - Aggiungere controlli di esistenza

## 🛠️ Strategie di Risoluzione

### Strategia 1: Type Assertions

Per proprietà dinamiche Eloquent:
```php
/** @var Sto00f $sto00f */
$sto00f = $this->anag->sto00f()->first();
```

### Strategia 2: Null Coalescing

Per proprietà opzionali:
```php
$st2kas = $sto00f->st2kas ?? null;
return $st2kas !== null ? (string) $st2kas : '---';
```

### Strategia 3: Type Guards

Per variabili che potrebbero non essere definite:
```php
if (! isset($date_min)) {
    throw new \InvalidArgumentException('date_min is required');
}
```

### Strategia 4: Explicit Casting

Per operazioni binarie:
```php
echo '<br/>ente: '.(string) $this->ente;
$date = Carbon::createFromFormat('Ymd H:i', (string) $this->asz2kd.' 00:00');
```

### Strategia 5: PHPDoc Completo

Per metodi complessi:
```php
/**
 * @param array<string, mixed> $params
 * @return Collection<string, array<string, mixed>>
 */
public function posizioniEconomicheOfYearCollection(array $params): Collection
```

## 📈 Metriche di Progresso

| Fase | Errori Iniziali | Errori Target | Status |
|------|----------------|---------------|--------|
| Iniziale | 1017 | - | ✅ |
| Fase 1 | 1017 | ~800 | 🚧 In corso |
| Fase 2 | ~800 | ~400 | ⏳ Pending |
| Fase 3 | ~400 | 0 | ⏳ Pending |

## 🔗 File Correlati

- [Comprehensive Analysis](./comprehensive-analysis.md) - Analisi completa modulo
- [Quality Improvements](./quality-improvements.md) - Piano miglioramenti qualità
- [Analysis Report](./analysis-report.md) - Report PHPStan/PHPMD completo

## 📝 Note Implementative

### Ignorare Errori PHPStan (Ultima Risorsa)

Solo per casi estremi dove la tipizzazione è impossibile:
```php
/** @phpstan-ignore-next-line */
$result = $complexDynamicMethod();
```

### Baseline PHPStan

Considerare l'uso di `phpstan-baseline.neon` per errori legacy che richiedono refactoring maggiore, ma solo dopo aver tentato tutte le strategie di fix.

## ✅ Checklist Fix Critici

- [x] Fix generics `Dipt00f::anag()` e `turn01l1()`
- [x] Fix binary operations in `Dipt00f::getAssunzioneAttribute()`
- [ ] Fix generics in `Qua00f.php`
- [ ] Fix generics in `Rep00f.php`
- [ ] Fix `RepartPolicy.php` property access
- [ ] Fix date operations in `Qua00k1.php`, `Qua03f.php`, `Sto00f.php`

## 🎯 Obiettivo Finale

Ridurre gli errori PHPStan livello 10 da **1017 a 0** mantenendo la funzionalità esistente e migliorando la qualità del codice attraverso:
- Tipizzazione rigorosa
- PHPDoc completo
- Refactoring graduale dei trait complessi
- Best practices Laravel/Eloquent

