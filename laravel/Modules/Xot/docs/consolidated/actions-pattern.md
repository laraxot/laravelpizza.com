# Pattern Corretto per Actions in Laraxot

## Principio Fondamentale
Tutte le Actions in Laraxot seguono il pattern **Spatie QueueableAction** e devono essere eseguite tramite il container Laravel.

## Struttura Action Corretta

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Cast;

use Spatie\QueueableAction\QueueableAction;

/**
 * Action per la conversione sicura di valori in stringa.
 */
class SafeStringCastAction
{
    use QueueableAction; // OBBLIGATORIO

    /**
     * Esegue la conversione sicura a string.
     *
     * @param mixed $value Il valore da convertire
     * @return string Il valore convertito
     */
    public function execute(mixed $value): string // OBBLIGATORIO
    {
        if (is_string($value)) {
            return $value;
        }

        if (is_null($value)) {
            return '';
        }

        if (is_bool($value)) {
            return $value ? '1' : '0';
        }

        if (is_scalar($value)) {
            return (string) $value;
        }

        return '';
    }
}
```

## Pattern di Utilizzo Corretto

### ✅ DO - Utilizzo Corretto

```php
// Pattern 1: Container + execute()
$result = app(SafeStringCastAction::class)->execute($value);

// Pattern 2: Dependency Injection
public function process(Request $request, SafeStringCastAction $action)
{
    $result = $action->execute($request->input('value'));
    return response()->json(['result' => $result]);
}

// Pattern 3: In Widget/Component
$safeStringCastAction = app(SafeStringCastAction::class);
$currentPassword = $safeStringCastAction->execute($this->data['current_password'] ?? '');
```

### ❌ DON'T - Pattern Errato

```php
// ❌ MAI fare questo - chiamata statica
$result = SafeStringCastAction::cast($value);

// ❌ MAI fare questo - istanziazione diretta
$action = new SafeStringCastAction();
$result = $action->cast($value);

// ❌ MAI fare questo - metodo statico
$result = SafeStringCastAction::execute($value);

// ❌ MAI fare questo - chiamata diretta
$action = new SafeStringCastAction();
$result = $action->execute($value); // Non bypassare il container
```

## Errori Comuni e Soluzioni

### Errore 1: Confusione con Helper Classes
```php
// ❌ ERRATO - Trattare Action come helper statico
$result = SafeStringCastAction::cast($value);

// ✅ CORRETTO - Usare container + execute
$result = app(SafeStringCastAction::class)->execute($value);
```

### Errore 2: Bypass del Container
```php
// ❌ ERRATO - Istanziazione diretta
$action = new SafeStringCastAction();

// ✅ CORRETTO - Usare container
$action = app(SafeStringCastAction::class);
```

### Errore 3: Metodi Statici nelle Actions
```php
// ❌ ERRATO - Metodo statico in Action
class SafeStringCastAction
{
    public static function cast(mixed $value): string
    {
        // ...
    }
}

// ✅ CORRETTO - Metodo execute() di istanza
class SafeStringCastAction
{
    use QueueableAction;

    public function execute(mixed $value): string
    {
        // ...
    }
}
```

## Checklist Pre-Implementazione

Prima di usare qualsiasi Action, verificare SEMPRE:

- [ ] L'Action usa `use QueueableAction`
- [ ] L'Action ha metodo `execute()` (non statico)
- [ ] Uso `app(ActionClass::class)->execute()`
- [ ] NON uso `ActionClass::metodo()` (statico)
- [ ] NON uso `new ActionClass()` (diretta)
- [ ] NON bypasso il container Laravel

## Validazione Automatica

Eseguire questi controlli prima di ogni commit:

```bash

# Cerca usi errati di metodi statici nelle Actions
grep -r "Action::" Modules/ --include="*.php" | grep -v "use\|namespace"

# Cerca chiamate dirette senza container
grep -r "new.*Action" Modules/ --include="*.php"

# Cerca metodi statici nelle Actions
grep -r "public static function" Modules/ --include="*.php" | grep "Action"
```

## Vantaggi del Pattern Corretto

1. **Dependency Injection**: Le Actions possono ricevere dipendenze tramite container
2. **Testabilità**: Facile da testare con mock e dependency injection
3. **Queueable**: Le Actions possono essere accodate per esecuzione asincrona
4. **Consistenza**: Pattern uniforme in tutto il progetto
5. **Manutenibilità**: Codice più pulito e organizzato

## Esempi di Actions Disponibili

### Cast Actions
- `SafeStringCastAction` - Conversione sicura a string
- `SafeFloatCastAction` - Conversione sicura a float
- `SafeIntCastAction` - Conversione sicura a int

### String Actions
- `NormalizeDriverNameAction` - Normalizzazione nomi driver

### Geo Actions
- `GetDistanceExpressionAction` - Calcolo espressioni SQL distanza

## Documentazione Correlata

- [DRY Actions Rules](../.cursor/rules/DRY-actions-rules.md)
- [Action Execution Pattern](../.cursor/rules/action-execution-pattern.md)
- [Spatie QueueableAction Documentation](https://github.com/spatie/laravel-queueable-action)

