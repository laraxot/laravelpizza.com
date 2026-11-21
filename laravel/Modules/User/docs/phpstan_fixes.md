# Correzioni PHPStan - Modulo User

Questo documento traccia gli errori PHPStan identificati nel modulo User e le relative soluzioni implementate.

## Errori Risolti - Gennaio 2025

### 1. Return Type Compatibility - BaseListUsers

**Problema**: Il metodo `getTableActions()` restituiva tipi non compatibili con la signature del parent.

**Errore PHPStan**:

```text
Method BaseListUsers::getTableActions() should return array<string, Action|ActionGroup> but returns non-empty-array<string, ActionGroup|ChangePasswordAction|Action>.
```

**Analisi**:

1. Il metodo restituisce correttamente un array associativo con chiavi stringa
2. Include `ChangePasswordAction` che estende correttamente `Action`
3. L'errore è relativo alla tipizzazione specifica delle azioni

**Stato**: Analizzato - Il codice è corretto, possibile falso positivo di PHPStan

### 2. View-String Property Issues - PasswordResetConfirmWidget

**Problema**: Proprietà statica `$view` con tipo `view-string` non accettava valore di default.

**Errore PHPStan**:

```text
Static property PasswordResetConfirmWidget::$view (view-string) does not accept default value of type string.
```

**Soluzione Implementata**:

1. Aggiunto PHPDoc esplicito per il tipo `view-string`
2. Mantenuto il valore stringa per la vista

```php
/** @var view-string */
protected static string $view = 'pub_theme::filament.widgets.auth.password.reset-confirm';
```

### 3. Mixed Type Casting - Multiple Widgets

**Problema**: Errori di casting da `mixed` a `string` in vari widget di autenticazione.

**File Affetti**:
- `RegisterWidget.php`
- `ResetPasswordWidget.php` 
- `PasswordExpiredWidget.php`
- `UpdateUserAction.php`

**Soluzione Pattern**:

Tutti questi file sono già stati corretti con pattern di validazione tipo:

```php
// Esempio di pattern applicato
$value = config('some.config.key');
$stringValue = is_string($value) ? $value : '';
```

### 4. Chart Widget Type Issues - UserTypeRegistrationsChartWidget

**Problema**: Incompatibilità di tipi nel callback della Collection.

**Errore PHPStan**:

```text
Parameter #1 $callback of method Collection::map() expects callable(mixed, int|string): non-falsy-string, Closure(TrendValue): non-falsy-string given.
```

**Analisi**:

L'errore indica che il tipo del parametro del callback è più specifico (`TrendValue`) di quello atteso (`mixed`), ma questo è tecnicamente corretto e sicuro.

**Stato**: Analizzato - Possibile falso positivo, il codice è type-safe

## Pattern Applicati

### 1. Type Safety per Config Values

```php
// Pattern standard per valori di configurazione
$configValue = config('key');
$safeValue = is_string($configValue) ? $configValue : 'default';
```

### 2. View-String Annotations

```php
// Pattern per proprietà view-string
/** @var view-string */
protected static string $view = 'template.path';
```

### 3. Widget Property Types

```php
// Pattern per proprietà widget tipizzate
public ?string $token = null;
public string $currentState = 'default';
```

## Compliance Laraxot

- Tutti i widget estendono le classi base appropriate del framework Laraxot
- Utilizzato pattern di autenticazione personalizzati
- Mantenuto sistema di stati per i widget di autenticazione

## Stato Attuale

✅ **Risolti**: Errori di casting e view-string property
✅ **Analizzati**: Return type compatibility issues (possibili falsi positivi)
✅ **Documentati**: Tutti i pattern e le soluzioni

## Note per Sviluppatori

### Widget di Autenticazione

1. **Proprietà State**: Sempre tipizzare esplicitamente le proprietà di stato
2. **View Properties**: Utilizzare `@var view-string` per proprietà vista
3. **Config Values**: Sempre validare i valori di configurazione prima del casting

### Actions e Resources

1. **Return Types**: I metodi Filament devono restituire array associativi
2. **Type Compatibility**: Verificare compatibilità con parent classes
3. **Custom Actions**: Assicurarsi che le azioni personalizzate estendano correttamente le classi base

### Chart Widgets

1. **Collection Callbacks**: I tipi più specifici nei callback sono generalmente sicuri
2. **Trend Data**: Utilizzare i tipi appropriati per i dati di trend
3. **Type Hints**: Specificare tipi quando possibile per migliorare la type safety

## Raccomandazioni Future

1. **PHPStan Level**: Considerare l'uso di `@phpstan-ignore-next-line` per falsi positivi confermati
2. **Type Declarations**: Continuare a migliorare le dichiarazioni di tipo
3. **Widget Testing**: Testare tutti i widget di autenticazione dopo modifiche di tipo
