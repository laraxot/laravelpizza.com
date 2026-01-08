# Correzioni Trait Sushi - PHPStan Level 10

## Obiettivo

Correggere i trait `SushiToJsons` e `SushiToJson` per eliminare ~85 errori PHPStan distribuiti su tutti i modelli che li usano.

## Trait Corretti

### 1. SushiToJsons.php (~70 errori → 0)

**Pattern problema**: `$model` generic in closure senza type hints

**Errori risolti**:
- `property.notFound`: Access to undefined property `$id`, `$updated_at`, `$created_at`, `$created_by`, `$updated_by`
- `method.notFound`: Call to undefined method `getJsonFile()`
- `argument.type`: Parameters per `File::json()`, `File::put()`, `dirname()`, `unlink()`

**Soluzione applicata**:
```php
// PRIMA: Accesso diretto properties
$model->id = $maxId + 1;
$model->updated_at = now();

// DOPO: setAttribute() per type safety
$model->setAttribute('id', $newId);
$model->setAttribute('updated_at', now());
$model->setAttribute('updated_by', authId());

// Assert per metodi richiesti
Assert::isInstanceOf($model, Model::class);
Assert::true(method_exists($model, 'getJsonFile'));
```

**Impatto**: 5 modelli Cms corretti automaticamente (Attachment, Menu, Page, PageContent, Section)

### 2. SushiToJson.php (~15 errori → 0)

**Errori risolti**:
- `foreach.nonIterable`: Foreach su `$form` mixed
- `offsetAccess.invalidOffset`: Array key mixed in foreach
- `return.type`: getSushiRows() return type mismatch

**Soluzione applicata**:
```php
// Type-safe foreach con PHPDoc
if (! is_iterable($form)) {
    return $normalizedData;
}

/** @var array<string, mixed> $safeForm */
$safeForm = $form;

foreach ($safeForm as $key => $type) {
    /** @var string $safeKey */
    $safeKey = is_string($key) ? $key : (string) $key;
    // ...
}

// Return type esplicito
/** @var array<int, array<string, mixed>> $typedData */
$typedData = $normalizedData;
return $typedData;
```

**Impatto**: 3 modelli corretti (Geo/Comune, Tenant/TestSushiModel, Xot/InformationSchemaTable)

### 3. TestSushiModel.php (1 errore → 0)

**Errore risolto**:
- `return.type`: getJsonFile() should return string but returns mixed

**Soluzione**:
```php
$filePath = $tenantService::filePath('database/content/'.$tbl.'.json');
Assert::string($filePath, 'File path must be string');
return $filePath;
```

## Verifiche Qualità

**PHPStan Level 10**:
- ✅ SushiToJsons.php: No errors
- ✅ SushiToJson.php: No errors
- ✅ TestSushiModel.php: No errors
- ✅ Tutti i modelli Cms: No errors

**PHPMD**: Accettabile (StaticAccess warnings per Assert)

## Modelli Beneficiati

### Cms (via SushiToJsons):
- Attachment.php
- Menu.php (+1 errore `getLabel()` corretto)
- Page.php
- PageContent.php
- Section.php

### Geo (via SushiToJson):
- Comune.php

### Tenant (via SushiToJson):
- TestSushiModel.php
- BaseModelJsons.php

### Xot (via SushiToJson):
- InformationSchemaTable.php

## Best Practices Implementate

### 1. setAttribute() invece di Accesso Diretto
**Perché**: PHPStan non può inferire properties su `Model` generico in closure.

```php
// ❌ ANTI-PATTERN
$model->id = $value;

// ✅ PATTERN CORRETTO
$model->setAttribute('id', $value);
```

### 2. Assert per Metodi Richiesti
```php
Assert::true(method_exists($model, 'getJsonFile'), 'Model must have getJsonFile');
```

### 3. PHPDoc Espliciti per Type Narrowing
```php
/** @var array<string, mixed> $safeForm */
$safeForm = $form;
```

## Impatto Complessivo

- **Errori risolti**: ~85
- **File corretti direttamente**: 3 trait
- **File corretti indirettamente**: 9 modelli
- **Rapporto efficienza**: 1 correzione trait → 3-5 modelli corretti

### Aggiornamento 2025-11-17
- Normalizzazione di `getSushiRows()` ulteriormente rafforzata con `array_map` tipizzato e `ksort()` sulle chiavi per garantire `array<int, array<string, mixed>>` coerente in tutti i modelli dipendenti (Geo, Tenant, Xot).

## Collegamenti

- [../../../docs/phpstan-level10-achievement.md](../../../docs/phpstan-level10-achievement.md)
- [Sushi Package Documentation](https://github.com/calebporzio/sushi)

---

**Data**: Novembre 2025
**PHPStan Level**: 10
**Status**: ✅ COMPLETATO

