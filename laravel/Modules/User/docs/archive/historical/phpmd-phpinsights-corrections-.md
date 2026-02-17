# PHPMD e PHP Insights Corrections - 2025-01-22

## Obiettivo
Correggere warning PHPMD e PHP Insights nel modulo User, mantenendo PHPStan a 0 errori.

## Correzioni Implementate

### Variabili Inutilizzate
1. ✅ **TeamPermissionResource.php**: Rimosse `$userClass` e `$teamClass` non utilizzate
2. ✅ **RolesRelationManager.php**: Rimossa `$xotData` non utilizzata

### Naming Conventions (CamelCase)
1. ✅ **CreateProfile.php**:
   - `$user_data` → `$userData`
   - `$user_class` → `$userClass`
2. ✅ **ListProfiles.php**: Rimossa `$user_class` non utilizzata

### Parametri Non Utilizzati
1. ✅ **ViewOauthRefreshToken.php**: `$state` → `$_state` (prefisso `_` per parametri non utilizzati)
2. ✅ **TeamsRelationManager.php**: `$record` → `$_record` (prefisso `_` per parametri non utilizzati)
3. ✅ **CreateRole.php** e **EditRole.php**: Già usano `$_permission` (corretto)

### Import Mancanti
1. ✅ **SendOtpAction.php**: Aggiunto `use RuntimeException;` e rimosso backslash da `\RuntimeException`
2. ✅ **BaseEditUser.php**: Aggiunto `use InvalidArgumentException;` e rimosso backslash da `\InvalidArgumentException`
3. ✅ **EditUser.php**: Aggiunto `use InvalidArgumentException;` e rimosso backslash da `\InvalidArgumentException`

## Pattern Applicati

### Parametri Non Utilizzati
```php
// ✅ CORRETTO: Prefisso _ per parametri non utilizzati
->url(function (mixed $_state, $record): ?string {
    // $_state non utilizzato, ma richiesto dalla signature
})

// ❌ ERRATO: Parametro senza prefisso _ quando non utilizzato
->url(function (mixed $state, $record): ?string {
    // $state non utilizzato - PHPMD warning
})
```

### Import Espliciti
```php
// ✅ CORRETTO: Import esplicito
use RuntimeException;
use InvalidArgumentException;

throw new RuntimeException('Error message');
throw new InvalidArgumentException('Error message');

// ❌ ERRATO: FQCN con backslash (PHPMD non riconosce l'import)
throw new \RuntimeException('Error message');
throw new \InvalidArgumentException('Error message');
```

### Naming CamelCase
```php
// ✅ CORRETTO: camelCase
$userData = Arr::except($data, ['user']);
$userClass = XotData::make()->getUserClass();

// ❌ ERRATO: snake_case
$user_data = Arr::except($data, ['user']);
$user_class = XotData::make()->getUserClass();
```

## Warning PHPMD Accettabili

I seguenti warning sono accettabili e non richiedono correzione immediata:

1. **CyclomaticComplexity** (11-12, threshold 10): Metodi complessi ma necessari per la logica di business
2. **ExcessiveMethodLength** (128 linee, threshold 100): Metodi lunghi ma ben strutturati
3. **LongVariable** (`$persistsFiltersInSession`): Nome descrittivo e chiaro
4. **UnusedFormalParameter** con prefisso `_`: Parametri richiesti dalla signature ma non utilizzati (es. `$_permission`, `$_state`, `$_record`)

## Risultati

### PHPStan
- ✅ **0 errori** (livello 10)

### PHPMD
- ✅ **0 errori critici** (solo warning accettabili)
- ✅ Variabili inutilizzate rimosse
- ✅ Naming conventions corrette
- ✅ Import espliciti aggiunti

### PHP Insights
- ✅ Code: Solo warning minori (unused parameters con prefisso `_` sono accettabili)
- ✅ Style: Nessun problema critico

## Lezioni Apprese

1. **Import Espliciti**: Usare sempre `use` statements invece di FQCN con backslash per migliorare la leggibilità e permettere a PHPMD di riconoscerli
2. **Parametri Non Utilizzati**: Prefisso `_` per parametri richiesti dalla signature ma non utilizzati
3. **Naming Conventions**: Sempre camelCase per variabili PHP
4. **Variabili Inutilizzate**: Rimuovere sempre variabili non utilizzate per mantenere il codice pulito

## Collegamenti

- [Resources Corrections Summary](./resources-corrections-summary-2025-01-22.md)
- [Quality Tools Report](./quality-tools-report.md)
- [PHPStan Complete Success](./phpstan-complete-success.md)
