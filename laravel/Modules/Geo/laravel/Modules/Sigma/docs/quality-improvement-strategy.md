# Quality Improvement Strategy 2025 - Sigma Module

> **Data**: Novembre 2025  
> **Status**: 🚧 In Lavorazione  
> **Principio Guida**: "Studia, Documenta, Ragiona, Poi Fai"

## 📊 Situazione Attuale

### Errori Identificati

- **PHPStan Level 10**: 991 errori
- **PHPMD**: 100+ code smells
- **PHP Insights**: Non eseguibile (composer.lock mancante)
- **Rector**: Non ancora eseguito

### Pattern Critici Identificati

1. **FunctionExtra.php**: Uso di `extract()` che crea variabili dinamiche
2. **Accessor con Persistenza**: Pattern complesso ma necessario per business logic
3. **Generics Eloquent**: Problemi con covarianza template types
4. **Mixed Types**: Variabili non tipizzate in operazioni binarie
5. **Dynamic Properties**: Accesso a proprietà Eloquent non tipizzate

## 🎯 Strategia di Miglioramento

### Fase 1: Documentazione e Analisi (COMPLETATA)

✅ **Studiato**:
- Repository rector-laravel e pattern automatici
- Documentazione esistente Sigma module
- Business logic e architettura Delegation Cascade Pattern
- Pattern Accessor con Persistenza

✅ **Documentato**:
- Nuova struttura CLAUDE.md DRY+KISS
- Pattern corretti per accessor
- Strategia PHPStan Level 10

### Fase 2: Fix Sistematici (IN CORSO)

#### 2.1 Fix FunctionExtra.php (Priorità Alta)

**Problema**: Uso di `extract()` crea variabili dinamiche non tracciabili da PHPStan.

**Soluzione**: Refactoring per eliminare `extract()`:

```php
// ❌ ERRATO
public static function getCoalesceDateRangeByArray(array $params): string
{
    extract($params);
    // PHPStan non può tracciare $date_min, $date_max, ecc.
}

// ✅ CORRETTO
public static function getCoalesceDateRangeByArray(array $params): string
{
    $date_min = $params['date_min'] ?? null;
    $date_max = $params['date_max'] ?? null;
    $from_field = $params['from_field'] ?? self::$from_field;
    $to_field = $params['to_field'] ?? self::$to_field;
    
    // PHPStan può ora tracciare tutte le variabili
}
```

**File Affetti**: `FunctionExtra.php` (circa 400 errori)

#### 2.2 Fix Generics Eloquent (Priorità Alta)

**Problema**: PHPStan non supporta covarianza template types `TDeclaringModel`.

**Soluzione**: Type assertions esplicite:

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

**File Affetti**: `Dipt00f.php`, `Qua00f.php`, `Rep00f.php`

#### 2.3 Fix Mixed Types (Priorità Media)

**Problema**: Variabili non tipizzate in operazioni binarie.

**Soluzione**: Type casting esplicito:

```php
// ❌ ERRATO
echo '<br/>ente: '.$this->ente;

// ✅ CORRETTO
echo '<br/>ente: '.(string) $this->ente;
```

**File Affetti**: `Dipt00f.php`, `Qua00k1.php`, `Qua03f.php`, `Sto00f.php`

### Fase 3: Rector Automatic Fixes

**Dopo** aver studiato rector-laravel, identificare le regole applicabili:

```bash
# Regole potenzialmente utili
- LaravelCodeQuality\Rector\MethodCall\RedirectRouteToToRouteHelperRector
- LaravelCodeQuality\Rector\StaticCall\DispatchToHelperRector  
- LaravelCodeQuality\Rector\Class_\PropertyTypeDeclarationRector
- LaravelCodeQuality\Rector\MethodCall\RemoveRedundantDefaultArgumentValueRector
```

**Approccio**:
1. Eseguire dry-run per vedere quali fix sono automatici
2. Applicare solo fix che non rompono business logic
3. Verificare con test esistenti

### Fase 4: PHPMD Code Smells

**Problemi Identificati**:
- UnusedLocalVariable
- StaticAccess
- CamelCaseVariableName
- CyclomaticComplexity
- NPathComplexity
- ExcessiveMethodLength

**Strategia**:
1. Refactoring graduale dei metodi complessi
2. Eliminazione variabili non utilizzate
3. Conversione static access a dependency injection
4. Suddivisione metodi troppo lunghi

## 🛠️ Piano di Implementazione

### Settimana 1: FunctionExtra Refactoring

**Obiettivo**: Ridurre errori da 991 a ~700

1. **Eliminare `extract()`** da tutti i metodi
2. **Tipizzare parametri** e return types
3. **Aggiungere type guards** per variabili dinamiche
4. **Testare** con dataset reali

### Settimana 2: Generics e Mixed Types

**Obiettivo**: Ridurre errori da ~700 a ~400

1. **Fix generics** in relazioni Eloquent
2. **Fix binary operations** con type casting
3. **Fix property access** con type assertions
4. **Verificare** con PHPStan Level 10

### Settimana 3: Rector e PHPMD

**Obiettivo**: Ridurre errori da ~400 a ~200

1. **Eseguire Rector** con regole selezionate
2. **Fix PHPMD code smells**
3. **Refactoring metodi complessi**
4. **Test di regressione** completo

### Settimana 4: Pulizia Finale

**Obiettivo**: Ridurre errori da ~200 a 0

1. **Fix errori residui**
2. **PHP Insights** (dopo fix composer.lock)
3. **Documentazione aggiornata**
4. **Code review** finale

## 📈 Metriche di Successo

| Settimana | PHPStan Errori | PHPMD Violazioni | Status |
|-----------|----------------|------------------|--------|
| Iniziale | 991 | 100+ | 🚧 |
| Settimana 1 | ~700 | ~80 | ⏳ |
| Settimana 2 | ~400 | ~50 | ⏳ |
| Settimana 3 | ~200 | ~20 | ⏳ |
| Settimana 4 | 0 | 0 | ⏳ |

## 🔧 Tool e Configurazioni

### PHPStan Configuration

```neon
# phpstan.neon per Sigma
parameters:
    level: 10
    paths:
        - Modules/Sigma/app
    excludePaths:
        - Modules/Sigma/app/Models/Traits/Extras/FunctionExtra.php # Temporaneo
    checkMissingIterableValueType: false
```

### Rector Configuration

```php
// rector.php per Sigma
return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/Modules/Sigma/app',
    ])
    ->withSets([
        LaravelSetList::LARAVEL_CODE_QUALITY,
    ]);
```

### PHPMD Configuration

```xml
<!-- phpmd.ruleset.xml per Sigma -->
<ruleset name="Sigma Custom Rules">
    <rule ref="rulesets/cleancode.xml">
        <exclude name="StaticAccess"/>
    </rule>
    <rule ref="rulesets/codesize.xml/CyclomaticComplexity">
        <properties>
            <property name="reportLevel" value="15"/>
        </properties>
    </rule>
</ruleset>
```

## 📝 Documentazione da Aggiornare

- [ ] `phpstan-level10-strategy.md` - Aggiornare progresso
- [ ] `accessor-pattern-correct.md` - Verificare pattern
- [ ] `architecture.md` - Aggiornare pattern risolti
- [ ] `business-logic.md` - Documentare fix applicati
- [ ] `module-dependencies.md` - Verificare impatti

## 🎯 Obiettivo Finale

**Sigma Module con Quality Level Enterprise**:
- ✅ PHPStan Level 10: 0 errori
- ✅ PHPMD: 0 violazioni critiche
- ✅ PHP Insights: Score > 90%
- ✅ Rector: Fix automatici applicati
- ✅ Business Logic: Intatta e migliorata
- ✅ Performance: Mantenuta o migliorata

---

**Creato**: 2025-11-24  
**Autore**: Analisi Strategica Quality Improvement  
**Status**: 🚧 IMPLEMENTAZIONE IN CORSO

**Vedi anche**:
- [PHPStan Level 10 Strategy](./phpstan-level10-strategy.md)
- [Accessor Pattern Correct](./accessor-pattern-correct.md)  
- [Architecture](./architecture.md)
- [Business Logic](./business-logic.md)