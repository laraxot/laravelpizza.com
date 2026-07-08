# Rector Laravel Workflow per Modulo Sigma

> **File**: `Modules/Sigma/docs/development/rector-workflow.md`  
> **Ultimo aggiornamento**: Gennaio 2025  
> **Status**: ✅ Active  
> **Riferimento**: [Rector Laravel Rules Reference](../../Xot/docs/development/rector-laravel-rules-reference.md)

## 🎯 Panoramica

Questo documento descrive il workflow completo per utilizzare **Rector Laravel** con i plugin appropriati per il refactoring automatico del modulo Sigma.

## 📋 Configurazione

### File: `Modules/Sigma/rector.php`

La configurazione include:
- **Laravel Set List**: Regole specifiche Laravel 10.0
- **Code Quality**: Miglioramenti qualità codice
- **PHP 8.3**: Compatibilità PHP 8.3
- **Skip Rules**: File complessi che richiedono refactoring manuale

## 🔄 Workflow Completo

### Fase 1: Dry Run Completo

**Obiettivo**: Preview di tutte le modifiche proposte

```bash
# Dry run completo modulo Sigma
cd laravel
./vendor/bin/rector process Modules/Sigma/app \
    --dry-run \
    --config=Modules/Sigma/rector.php \
    > Modules/Sigma/docs/rector-dry-run.txt

# Analizza risultati
cat Modules/Sigma/docs/rector-dry-run.txt | grep -E "would change|would be added" | wc -l
```

### Fase 2: Applicazione Incrementale

**Obiettivo**: Applicare modifiche su piccoli gruppi di file

#### Step 1: File Modelli Base

```bash
# Applica su modelli base
./vendor/bin/rector process Modules/Sigma/app/Models/Scheda.php \
    --config=Modules/Sigma/rector.php

# Verifica PHPStan dopo
./vendor/bin/phpstan analyse Modules/Sigma/app/Models/Scheda.php --level=10
```

#### Step 2: File già Fixati

```bash
# Applica su file già parzialmente fixati
./vendor/bin/rector process Modules/Sigma/app/Models/Rep00f.php \
    --config=Modules/Sigma/rector.php

./vendor/bin/rector process Modules/Sigma/app/Models/Qua00k1.php \
    --config=Modules/Sigma/rector.php

./vendor/bin/rector process Modules/Sigma/app/Models/Qua03f.php \
    --config=Modules/Sigma/rector.php

./vendor/bin/rector process Modules/Sigma/app/Models/Asz00k1.php \
    --config=Modules/Sigma/rector.php

./vendor/bin/rector process Modules/Sigma/app/Models/Dipt00f.php \
    --config=Modules/Sigma/rector.php
```

#### Step 3: Altri Modelli

```bash
# Applica su altri modelli
./vendor/bin/rector process Modules/Sigma/app/Models/Sto00f.php \
    --config=Modules/Sigma/rector.php

./vendor/bin/rector process Modules/Sigma/app/Models/Anag.php \
    --config=Modules/Sigma/rector.php

./vendor/bin/rector process Modules/Sigma/app/Models/Qua00f.php \
    --config=Modules/Sigma/rector.php
```

### Fase 3: Verifica PHPStan

**Obiettivo**: Verificare che Rector non introduca nuovi errori

```bash
# Verifica PHPStan dopo ogni applicazione
./vendor/bin/phpstan analyse Modules/Sigma --level=10 --memory-limit=2G
```

## 🎯 Pattern di Refactoring Attesi

### Pattern 1: String Helpers

**Prima**:
```php
if (str_contains($string, 'needle')) {
    $result = str_replace('old', 'new', $string);
}
```

**Dopo** (con Rector):
```php
use Illuminate\Support\Str;

if (Str::contains($string, 'needle')) {
    $result = Str::replace('old', 'new', $string);
}
```

### Pattern 2: Array Helpers

**Prima**:
```php
$value = array_get($array, 'key', 'default');
```

**Dopo** (con Rector):
```php
use Illuminate\Support\Arr;

$value = Arr::get($array, 'key', 'default');
```

### Pattern 3: Early Return

**Prima**:
```php
public function check($value)
{
    if ($value !== null) {
        if ($value > 0) {
            return true;
        }
    }
    return false;
}
```

**Dopo** (con Rector):
```php
public function check($value): bool
{
    if ($value === null) {
        return false;
    }
    
    if ($value <= 0) {
        return false;
    }
    
    return true;
}
```

### Pattern 4: Type Hints

**Prima**:
```php
public function process($data, $options = null)
{
    // ...
}
```

**Dopo** (con Rector):
```php
public function process(array $data, ?array $options = null): void
{
    // ...
}
```

## 📊 Script Automatizzato

```bash
#!/bin/bash
# scripts/rector-sigma-workflow.sh

MODULE="Sigma"
MODULE_PATH="Modules/$MODULE/app"
RECTOR_CONFIG="Modules/$MODULE/rector.php"

echo "=== Rector Workflow for $MODULE Module ==="
echo ""

# Step 1: Dry run
echo "Step 1: Dry Run..."
./vendor/bin/rector process "$MODULE_PATH" \
    --dry-run \
    --config="$RECTOR_CONFIG" \
    > "Modules/$MODULE/docs/rector-dry-run-$(date +%Y%m%d).txt"

echo "✅ Dry run complete. Review: Modules/$MODULE/docs/rector-dry-run-*.txt"
echo ""

# Step 2: Apply to specific files
echo "Step 2: Apply to Fixed Files..."
FIXED_FILES=(
    "Models/Rep00f.php"
    "Models/Qua00k1.php"
    "Models/Qua03f.php"
    "Models/Asz00k1.php"
    "Models/Dipt00f.php"
)

for file in "${FIXED_FILES[@]}"; do
    echo "Processing: $file"
    ./vendor/bin/rector process "$MODULE_PATH/$file" \
        --config="$RECTOR_CONFIG"
    
    # Verify PHPStan
    echo "Verifying PHPStan..."
    ./vendor/bin/phpstan analyse "$MODULE_PATH/$file" --level=10 --no-progress
done

echo ""
echo "✅ Rector workflow complete"
```

## 🚨 Note Importanti

### File da Non Modificare

1. **FunctionExtra.php**: Richiede refactoring manuale completo (~300 errori)
2. **MassExtra.php**: Richiede refactoring manuale completo (~300 errori)

### Best Practices

1. **Sempre dry-run prima**: Verifica modifiche prima di applicarle
2. **Commit incrementali**: Applica su piccoli gruppi di file
3. **Verifica PHPStan dopo**: Assicurati che non introduca errori
4. **Test dopo modifiche**: Esegui test per verificare funzionalità

## 🔗 Collegamenti Correlati

- [Rector Laravel Rules Reference](../../Xot/docs/development/rector-laravel-rules-reference.md)
- [Mago Workflow](./mago-workflow.md)
- [PHPStan Level 10 Strategy](./phpstan-level10-strategy.md)

---

**Ultimo aggiornamento**: Gennaio 2025  
**Versione**: 1.0  
**Status**: ✅ Active

