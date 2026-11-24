---
issues: []
discussions: []
title: "Correzioni Trait Sushi - PHPStan Level 10"
module: "Tenant"
type: pattern
tags: [sushi, traits, phpstan, fixes]
created: 2026-07-14
updated: 2026-08-24
qmd: "sushi traits phpstan fixes"
related:
  - "./phpstan-corrections-january.md"
---
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

### Aggiornamento [DATE]
- Normalizzazione di `getSushiRows()` ulteriormente rafforzata con `array_map` tipizzato e `ksort()` sulle chiavi per garantire `array<int, array<string, mixed>>` coerente in tutti i modelli dipendenti (Geo, Tenant, Xot).

### `intValue` / `csvValue` restano mixed (2026-08-18)

`SushiToJson::intValue(mixed)` riceve `$row['id']` da JSON (`array<string, mixed>`) e `Model::getAttribute('id')`. `SushiToCsv::csvValue(mixed)` serializza celle da payload CSV/JSON. Non è un shortcut: è il bordo opaco. Sostituire con `SafeIntCastAction` cambierebbe i default (bool/array).

## SushiToCsv — League/CSV 9.27: `createFromPath()` è deprecato

Aggiornamento 2026-08-19. Con `league/csv` 9.28.0 installata, PHPStan riportava quattro
`staticMethod.deprecated` su `app/Models/Traits/SushiToCsv.php` — gli unici errori reali
rimasti nel modulo.

`AbstractCsv::createFromPath()` è deprecato dalla **9.27.0**, insieme a
`createFromString()`, `createFromStream()` e `createFromFileObject()`. Il sostituto unico è
`AbstractCsv::from()`, che accetta indifferentemente un path, un `SplFileInfo`, un
`SplFileObject` o una resource; per il contenuto in memoria resta `fromString()`.

```php
// prima
$reader = Reader::createFromPath($this->getCsvPath(), 'r');
$writer = Writer::createFromPath($model->getCsvPath(), 'w+');

// dopo — stessa firma ($filename, $mode, $context)
$reader = Reader::from($this->getCsvPath(), 'r');
$writer = Writer::from($model->getCsvPath(), 'w+');
```

Nessun cambiamento di comportamento: `createFromPath()` internamente faceva già
`new static(Stream::from($path, $open_mode, $context))`, che è il ramo `default` del `match`
dentro `from()`.

Il trait è consumato da `Modules\Sigma\Models\WebService` — il modulo `Sigma` ha una copia
di test del trait in `tests/TestTraits/TestSushiToCsv.php` che **non** è stata allineata:
se un giorno quella copia viene esercitata dal gate, riporterà le stesse deprecazioni.

Verifica: `./vendor/bin/phpstan analyse Modules/Tenant --no-progress --memory-limit=-1` →
0 errori reali (restano solo `typeCoverage.*`, che è una percentuale globale del progetto,
non un difetto del modulo).

## Collegamenti

- [../../../../docs/phpstan-level10-achievement.md](../../../../docs/phpstan-level10-achievement.md)
- [Sushi Package Documentation](https://github.com/calebporzio/sushi)
- [league/csv 9.27 — deprecazione dei costruttori nominati](https://csv.thephpleague.com/9.0/connections/instantiation/)

---

**PHPStan Level**: 10
**Status**: ✅ COMPLETATO

## Host reale vs Model nudo (famiglia A, 2026-08-24)

PHPStan analizza il trait nel contesto di chi lo `use`. Una fixture `extends Model`
riapre `property.notFound` sulle colonne dinamiche. La correzione è far estendere
l'host di produzione: `WebService`, `SocialProvider`, `BaseModelJsons`. Non si tipizza
la classe anonima e non si allarga la firma del trait.

## Boundary Eloquent dei lifecycle CSV (2026-08-24)

Le closure `creating` e `updating` del trait sono analizzate anche nel contesto di
ogni modello consumer. Proprietà come `id`, `created_at`, `updated_at`, `created_by`
e `updated_by` sono colonne Eloquent dinamiche: l'accesso diretto le faceva apparire
come proprietà PHP non dichiarate nei model anonimi e nelle fixture.

Il contratto corretto usa l'API Eloquent, senza modificare il payload persistito:

```php
$model->setAttribute('id', $maxId + 1);
$model->setAttribute('updated_at', now());
$model->setAttribute('updated_by', self::resolveAuthIdInt());
```

Questo risolve la dichiarazione nel trait owner una sola volta e quindi anche il
consumer `Modules\Sigma\Models\WebService`. La migrazione League CSV resta
`Reader::from()` / `Writer::from()`; header, sequenza delle righe e modalità di
apertura non cambiano.

### Gate riproducibili

```bash
./vendor/bin/phpstan analyse \
  Modules/Tenant/app/Models/Traits/SushiToCsv.php \
  Modules/Tenant/app/Models/Traits/SushiToJson.php \
  Modules/Tenant/app/Models/Traits/SushiToJsons.php \
  Modules/Tenant/app/Models/Traits/SushiToPhpArray.php \
  Modules/Tenant/app/Actions/Config/GetTenantConfigNamesAction.php \
  Modules/Tenant/tests/Unit/DomainModelTest.php --no-progress

./vendor/bin/phpstan analyse Modules/Sigma/app/Models/WebService.php --no-progress
```

Entrambi i gate terminano con zero errori. Il gate Tenant module-wide va comunque
eseguito separatamente: errori in test non posseduti non vanno mascherati né
duplicati nei trait.
