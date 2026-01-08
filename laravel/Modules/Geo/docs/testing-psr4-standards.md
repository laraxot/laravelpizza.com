# Standard PSR-4 per i Test in Laraxot <nome progetto>

## Panoramica

Tutti i file di test nei moduli Laraxot devono rispettare rigorosamente lo standard PSR-4 per l'autoloading. Questo documento definisce le regole e best practices per garantire la conformità.

## Configurazione Autoload

### Struttura Standard nei Moduli

Ogni modulo deve avere la seguente configurazione nel `composer.json`:

```json
{
    "autoload-dev": {
        "psr-4": {
            "Modules\\{ModuleName}\\Tests\\": "tests/"
        }
    }
}
```

### Esempi per i Moduli Principali

#### Modulo Xot
```json
"autoload": {
    "psr-4": {
        "Modules\\Xot\\Tests\\": "tests/"
    }
}
```

#### Modulo <nome modulo>
```json
"autoload-dev": {
    "psr-4": {
        "Modules\\<nome modulo>\\Tests\\": "tests/"
    }
}
```

## Regole di Namespace

### Struttura Obbligatoria

Tutti i file di test DEVONO seguire questa struttura:

```php
<?php

declare(strict_types=1);

namespace Modules\{ModuleName}\Tests\{SubNamespace};

// Imports...

/**
 * Documentazione della classe.
 */
class TestClassName extends BaseClass
{
    // Implementazione...
}
```

### Mapping Directory → Namespace

| Directory | Namespace |
|-----------|-----------|
| `tests/Unit/` | `Modules\{ModuleName}\Tests\Unit` |
| `tests/Feature/` | `Modules\{ModuleName}\Tests\Feature` |
| `tests/Integration/` | `Modules\{ModuleName}\Tests\Integration` |

## Casi d'Uso Comuni

### Test con Classi Helper

✅ **CORRETTO**:

```php
<?php

declare(strict_types=1);

namespace Modules\<nome modulo>\Tests\Unit;

use Modules\<nome modulo>\Models\BaseModel;

/**
 * Concrete implementation of BaseModel for testing purposes.
 */
class TestableBaseModel extends BaseModel
{
    protected $table = 'test_models';
    
    /** @var list<string> */
    protected $fillable = ['name', 'description'];
}

describe('BaseModel Tests', function () {
    // Test implementation...
});
```

### Test con Mock Classes

✅ **CORRETTO**:

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Modules\Xot\Contracts\ExtraContract;
use Illuminate\Database\Eloquent\Model;

/**
 * Helper class for testing HasExtraTrait functionality.
 */
class TestExtra extends Model implements ExtraContract 
{
    protected $table = 'test_extras';
    
    /** @var list<string> */
    protected $fillable = ['model_id', 'model_type', 'extra_attributes'];
    
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'extra_attributes' => 'collection',
        ];
    }
    
    /**
     * Get the parent model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function model()
    {
        return $this->morphTo();
    }
}
```

## Violazioni Comuni e Soluzioni

### Problema 1: Classe senza Namespace

❌ **ERRORE**:
```php
<?php
declare(strict_types=1);
// Missing namespace!

class TestHelper extends Model 
{
    // ...
}
```

✅ **SOLUZIONE**:
```php
<?php
declare(strict_types=1);

namespace Modules\<nome modulo>\Tests\Unit;

/**
 * Helper class for testing.
 */
class TestHelper extends Model 
{
    // ...
}
```

### Problema 2: Namespace Errato

❌ **ERRORE**:
```php
namespace App\Tests\Unit; // Wrong namespace!
```

✅ **SOLUZIONE**:
```php
namespace Modules\<nome modulo>\Tests\Unit; // Correct module namespace
```

## Verifica della Conformità

### Comandi di Controllo

```bash
# Verifica autoload PSR-4 (deve essere eseguito dalla root Laravel)
cd ../laravel
composer dump-autoload

# Controlla errori di namespace con PHPStan
./vendor/bin/phpstan analyze Modules/*/tests/ --level=9

# Test specifico per modulo
./vendor/bin/phpstan analyze Modules/<nome modulo>/tests/ --level=9
```

### Messaggi di Errore Tipici

Quando PSR-4 non è rispettato, si vedono errori come:

```
Class TestExtra located in ./Modules/Xot/tests/Unit/HasExtraTraitTest.php 
does not comply with psr-4 autoloading standard 
(rule: Modules\Xot\Tests\ => ./Modules/Xot/tests). Skipping.
```

## Best Practices

1. **Namespace Obbligatorio**: Ogni classe deve avere il namespace appropriato
2. **Documentazione**: PHPDoc completo per tutte le classi helper
3. **Tipizzazione**: Type hints espliciti per proprietà e metodi
4. **Naming Consistente**: Nomi descrittivi per classi di test
5. **Strict Types**: Sempre utilizzare `declare(strict_types=1);`

## Struttura Raccomandata per i Test

```
Modules/
└── {ModuleName}/
    └── tests/
        ├── Feature/
        │   ├── Api/
        │   └── Web/
        └── Unit/
            ├── Models/
            ├── Services/
            └── Traits/
```

## Checklist di Verifica

Prima di committare file di test:

- [ ] Namespace corretto dichiarato
- [ ] Classi helper nel namespace appropriato
- [ ] PHPDoc completo per tutte le classi
- [ ] Type hints espliciti
- [ ] `declare(strict_types=1);` presente
- [ ] `composer dump-autoload` eseguito senza errori
- [ ] PHPStan livello 9 passa senza errori

## Collegamenti ai Moduli

- [Testing PSR-4 Compliance - Modulo Xot](../Modules/Xot/docs/testing-psr4-compliance.md)
- [Testing Guide - Modulo <nome modulo>](../Modules/<nome modulo>/docs/testing.md)

---

*Ultimo aggiornamento: 2025-01-06*
*Standard: PSR-4, PHPStan livello 9+, Laraxot conventions*

