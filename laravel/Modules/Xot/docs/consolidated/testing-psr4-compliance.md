# PSR-4 Compliance per Test - Modulo Xot

## Problema Identificato

I file di test che contengono classi helper devono rispettare lo standard PSR-4 per l'autoloading. Le classi definite nei file di test devono essere nel namespace appropriato.

## Regole PSR-4 per i Test

### Configurazione Autoload

Nel `composer.json` del modulo Xot:

```json
"autoload": {
    "psr-4": {
        "Modules\\Xot\\Tests\\": "tests/"
    }
}
```

### Struttura Corretta

✅ **CORRETTO**: Namespace appropriato per classi di test

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Modules\Xot\Models\Traits\HasExtraTrait;
use Modules\Xot\Contracts\ExtraContract;
use Illuminate\Database\Eloquent\Model;

/**
 * Helper class for testing HasExtraTrait.
 */
class TestExtra extends Model implements ExtraContract 
{
    protected $table = 'test_extras';
    
    /** @var list<string> */
    protected $fillable = ['model_id', 'model_type', 'extra_attributes'];
    
    protected function casts(): array
    {
        return [
            'extra_attributes' => 'collection',
        ];
    }
    
    public function model()
    {
        return $this->morphTo();
    }
}
```

### Errori Comuni da Evitare

❌ **ERRATO**: Classe senza namespace

```php
<?php

declare(strict_types=1);

// Manca il namespace!
use Modules\Xot\Models\Traits\HasExtraTrait;

class TestExtra extends Model // Viola PSR-4
{
    // ...
}
```

## Best Practices

1. **Namespace Obbligatorio**: Ogni classe nei file di test deve avere il namespace `Modules\Xot\Tests\{SubNamespace}`
2. **Documentazione**: Tutte le classi helper devono avere PHPDoc completo
3. **Tipizzazione**: Utilizzare type hints espliciti per proprietà e metodi
4. **Naming**: Nomi delle classi helper devono essere descrittivi e indicare il loro scopo

## Verifica della Conformità

```bash
# Verifica autoload PSR-4
composer dump-autoload

# Controlla errori di namespace
./vendor/bin/phpstan analyze tests/ --level=9
```

## Correzioni Applicate

### File: `tests/Unit/HasExtraTraitTest.php`

- **Problema**: Classe `TestExtra` senza namespace appropriato
- **Soluzione**: Aggiunto `namespace Modules\Xot\Tests\Unit;`
- **Miglioramenti**: 
  - Documentazione PHPDoc completa
  - Tipizzazione esplicita per proprietà `$fillable`
  - Type hints per metodi

## Collegamenti

- [Testing Guide - Modulo <nome modulo>](../../<nome modulo>/project_docs/testing.md)
- [PHPStan Configuration](./phpstan-configuration-fixes.md)
- [Best Practices](./best-practices-consolidated.md)

---

*Ultimo aggiornamento: 2025-01-06*
*Conformità: PSR-4, PHPStan livello 9+, Laraxot standards*

