# Risoluzione Problemi PHPStan

Questo documento fornisce soluzioni per i problemi comuni che si possono incontrare durante l'esecuzione di PHPStan nel progetto Laraxot.

## Errori Comuni e Soluzioni

### 1. Costanti PDO non definite

**Problema:**

```
Error thrown in /path/to/config/database.php on line XX while loading bootstrap file: Undefined constant PDO::MYSQL_ATTR_LOCAL_INFILE
```

**Soluzione:**

Modifica i file di configurazione del database per verificare se le costanti sono definite:

```php
'options' => extension_loaded('pdo_mysql') ? array_filter([
    PDO::ATTR_EMULATE_PREPARES => true,
    defined('PDO::MYSQL_ATTR_LOCAL_INFILE') ? PDO::MYSQL_ATTR_LOCAL_INFILE : null => true,
    defined('PDO::MYSQL_ATTR_USE_BUFFERED_QUERY') ? PDO::MYSQL_ATTR_USE_BUFFERED_QUERY : null => true,
]) : [],
```

In alternativa, crea un file di bootstrap per PHPStan che definisca queste costanti:

```php
// phpstan-bootstrap.php
<?php
if (!defined('PDO::MYSQL_ATTR_LOCAL_INFILE')) {
    define('PDO::MYSQL_ATTR_LOCAL_INFILE', 1);
}
if (!defined('PDO::MYSQL_ATTR_USE_BUFFERED_QUERY')) {
    define('PDO::MYSQL_ATTR_USE_BUFFERED_QUERY', 2);
}
```

E configura PHPStan per utilizzarlo:

```yaml
# phpstan.neon
parameters:
    bootstrapFiles:
        - phpstan-bootstrap.php
```

### 2. Problemi con i tipi misti (mixed)

**Problema:**

```
Cannot cast mixed to string/int
Parameter expects type X, mixed given
Cannot access property on mixed
```

**Soluzione:**

Utilizza controlli di tipo espliciti:

```php
// Invece di
$result = $value . "suffix";

// Usa
if (is_string($value) || is_numeric($value)) {
    $result = $value . "suffix";
} else {
    $result = "suffix";
}
```

### 3. Problemi con le relazioni Eloquent

**Problema:**

```
Method returns BelongsTo<Model, Profile> but returns BelongsTo<Model, $this(Profile)>
```

**Soluzione:**

Utilizza PHPDoc senza type-hint nel return:

```php
/**
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User>
 */
public function user()
{
    return $this->belongsTo(User::class);
}
```

### 4. Problemi con i percorsi dei file

**Problema:**

```
File not found in any extension: template.blade.php
```

**Soluzione:**

Configura i percorsi delle view in phpstan.neon:

```yaml
parameters:
    scanDirectories:
        - resources/views
        - Modules/*/resources/views
```

### 5. Problemi con le funzioni unsafe

**Problema:**

```
Function file_get_contents is unsafe to use
```

**Soluzione:**

Utilizza il pacchetto Safe:

```php
use function Safe\file_get_contents;

$content = file_get_contents($path);
```

## Configurazione Ottimale di PHPStan

Per una configurazione ottimale di PHPStan nel progetto Laraxot, utilizza il seguente file phpstan.neon:

```yaml
includes:
    - ./vendor/nunomaduro/larastan/extension.neon

parameters:
    level: 7
    paths:
        - Modules
    excludePaths:
        - */Tests/*
        - */tests/*
        - */vendor/*
        - */node_modules/*
    bootstrapFiles:
        - phpstan-bootstrap.php
    checkMissingIterableValueType: false
    checkGenericClassInNonGenericObjectType: false
    ignoreErrors:
        - '#PHPDoc tag @var#'
        - '#Call to an undefined method [a-zA-Z0-9\\_]+::newQuery\(\)#'
```

## Incrementare Gradualmente il Livello di PHPStan

Si consiglia di incrementare gradualmente il livello di PHPStan:

1. Inizia con il livello 0 e risolvi tutti gli errori
2. Passa al livello 1 e risolvi tutti gli errori
3. Continua fino al livello desiderato (7 o 8 raccomandati)

## Risorse Aggiuntive

Per ulteriori dettagli sulle soluzioni ai problemi di PHPStan, consulta:

- [Documentazione PHPStan](https://phpstan.org/user-guide/getting-started)
- [Modulo Xot - Documentazione PHPStan](../laravel/Modules/Xot/docs/PHPStan/PHPSTAN-SOLUTIONS.md)
- [Modulo Xot - Correzioni PDO](../laravel/Modules/Xot/docs/PHPStan/PDO_CONSTANTS_FIXES.md) 