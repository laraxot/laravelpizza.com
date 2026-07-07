# 🔧 PHPMD Convenzioni Laraxot

**Scope**: Tutti i moduli FixCity (Laraxot PTVX)  
**Ultimo Aggiornamento**: 2026-06-19  
**Stato**: ✅ Attivo

---

## 📦 Installazione

```bash
# PHPMD è già in require-dev
./vendor/bin/phpmd --version
```

---

## 🎯 Utilizzo

### Analisi singolo modulo
```bash
./vendor/bin/phpmd Modules/Tenant text phpmd.xml
./vendor/bin/phpmd Modules/UI text phpmd.xml
```

### Analisi con ruleset modulo specifico
```bash
./vendor/bin/phpmd Modules/Tenant xml Modules/Tenant/phpmd.ruleset.xml
```

### Analisi completa
```bash
./vendor/bin/phpmd Modules text phpmd.xml --suffixes php
```

---

## 📊 Regole Configurate

### Code Size Limits (Soglie Laraxot)

| Regola | Soglia | Note |
|--------|--------|------|
| CyclomaticComplexity | 13 | Max per metodo |
| NPathComplexity | 800 | Max path complessità |
| ExcessiveMethodLength | 150 linee | Max lunghezza metodo |
| TooManyMethods | 30 | Max metodi per classe |
| CouplingBetweenObjects | 20 | Max dipendenze |

### Naming Rules (Eccezioni Laraxot)

**Variabili corte permesse**:
- `id`, `q`, `w`, `i`, `j`, `v`, `e`, `f`, `fp`
- `as`, `to`, `io`, `ip`, `os`, `at`, `by`, `db`, `dt`
- `up`, `in`, `on`, `go`, `no`, `ok`, `or`, `be`, `do`
- `if`, `it`, `of`, `we`

**CamelCasePropertyName escluso** per:
- `$fillable`, `$guarded`, `$casts`, `$appends`
- Proprietà Eloquent standard

### Ruleset Globale Esclusioni

| Pattern | Motivo |
|---------|--------|
| `*/Providers/*` | ServiceProvider hanno coupling alto per design |
| `*/tests/*` | Test hanno complessità diversa |
| `*/database/factories/*` | Factory usano variabili corte |
| `*/database/seeders/*` | Seeders hanno metodi lunghi |
| `*/lang/*` | File traduzione non codice |
| `*/resources/views/*` | Blade templates |

---

## 📁 Struttura Configurazione

```
laravel/
├── phpmd.xml                    # Configurazione globale
├── Modules/
│   ├── Tenant/
│   │   └── phpmd.ruleset.xml   # Override modulo
│   ├── UI/
│   └── ...
```

### Override per Modulo

Ogni modulo può avere `phpmd.ruleset.xml` per sovrascrivere regole specifiche:

```xml
<ruleset name="Tenant phpmd ruleset">
    <description>Tenant module — allineato a Comment con soglie Laraxot.</description>
    
    <!-- Esclusioni specifiche modulo -->
    <exclude-pattern>*/GetTenantNameAction.php</exclude-pattern>
    
    <!-- Import ruleset globale -->
    <rule ref="../../phpmd.xml"/>
</ruleset>
```

---

## 🔍 Integrazione Workflow

### Pre-commit Check
```bash
#!/bin/bash
# .git/hooks/pre-commit

files=$(git diff --cached --name-only --diff-filter=ACM | grep "\.php$")
if [ -n "$files" ]; then
    ./vendor/bin/phpmd $files text phpmd.xml
fi
```

### CI/CD Pipeline
```yaml
# .github/workflows/quality.yml
- name: PHPMD Analysis
  run: ./vendor/bin/phpmd Modules text phpmd.xml --suffixes php
```

---

## 📝 Convenzioni Specifiche

### 1. **No StaticAccess Rule**
Permesso per Laravel Facades:
- `Auth::`, `Cache::`, `Config::`, `DB::`
- `File::`, `Hash::`, `Log::`, `Route::`
- `Schema::`, `Session::`, `Storage::`, `Validator::`

### 2. **CamelCasePropertyName**
Escluso per proprietà Eloquent:
```php
protected $fillable = [];      // OK
protected $guarded = [];       // OK
protected $casts = [];         // OK
protected $appends = [];       // OK
```

### 3. **ShortVariable**
Permesso in contesti specifici:
```php
// OK: Variabili di loop
foreach ($items as $i => $v) { }

// OK: Id, chiavi
$id, $key, $fp (file pointer)

// OK: Coordinate
$x, $y, $lat, $lng
```

### 4. **ExcessiveParameterList**
Laravel esclusioni:
- Form Request constructors
- Action constructors (dependency injection)
- Event constructors

---

## ✅ Quality Gates

| Livello | Soglia | Azione |
|---------|--------|--------|
| 🟢 OK | 0 violazioni | Passa CI |
| 🟡 Warning | 1-5 violazioni | Review richiesta |
| 🔴 Block | >5 violazioni | Block merge |

---

## 📚 Riferimenti

- **PHPMD Docs**: https://phpmd.org/documentation.html
- **Rules Reference**: https://phpmd.org/rules/index.html
- **Laravel & PHPMD**: https://laravel-news.com/working-with-phpmd
- **Convenzioni Laraxot**: `docs/wiki/rules/phpmd-conventions.md`

---

## ⚠️ Known Issues

### PHPMD 2.5.0 + PHP 8.4 Compatibility

**Problema**: PHPMD 2.5.0 ha errori di compatibilità con PHP 8.4/Symfony DI:
```
Fatal error: Declaration of PDepend\DependencyInjection\PdependExtension::load(...) 
must be compatible with Symfony\Component\DependencyInjection\Extension\ExtensionInterface::load(...): void
```

**Soluzione temporanea**:
- Usare PHPStan come strumento principale (già configurato, 0 errori)
- PHPMD verrà aggiornato quando disponibile versione compatibile con PHP 8.4
- Alternative: `composer require --dev phpmd/phpmd:dev-master` (sperimentale)

**Stato**: In attesa di PHPMD 2.6.0+ con supporto PHP 8.4

---

**Last Update**: 2026-06-19  
**Maintainer**: Laraxot Quality Team
