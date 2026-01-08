# Pattern: Actions che chiamano altre Actions

**Data**: 2025-01-18  
**Modulo**: Notify  
**Status**: ✅ Pattern consolidato

## Principio Fondamentale

Quando un'Action chiama un'altra Action, utilizzare **sempre** `app(ActionClass::class)->execute()` **dentro** il metodo `execute()`, **non** dependency injection nel costruttore.

## Filosofia

### Perché `app()` e non Dependency Injection?

1. **KISS (Keep It Simple, Stupid)**
   - Pattern più semplice e diretto
   - Meno codice boilerplate
   - Nessun costruttore necessario per chiamate semplici

2. **Coerenza Architetturale**
   - Pattern standard nel codebase Laraxot
   - Vedi: `UpdateCoordinatesAction`, `SendMailByRecordsAction`
   - Stesso pattern usato ovunque

3. **Stateless Design**
   - Le Actions sono utility stateless
   - Non hanno stato interno da mantenere
   - Ogni chiamata è indipendente

4. **Serializzazione Queue**
   - Quando un'Action viene accodata, la DI nel costruttore complica la serializzazione
   - `app()` risolve al momento dell'esecuzione, non alla creazione

5. **Flessibilità**
   - Permette binding dinamici del container
   - Facilita testing con mock
   - Meno accoppiamento rigido

## Pattern Corretto

### ✅ CORRETTO - Usare `app()` dentro `execute()`

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Actions;

use Modules\Notify\Actions\SMS\NormalizePhoneNumberAction;
use Spatie\QueueableAction\QueueableAction;

class SendRecordsNotificationBulkAction
{
    use QueueableAction;

    public function execute(Collection $records, string $templateSlug, array $channels): SendNotificationBulkResultData
    {
        // Chiama altre Actions usando app() dentro execute()
        $normalizedPhone = app(NormalizePhoneNumberAction::class)->execute($phone);
        
        // Logica business...
    }
}
```

### ❌ ERRATO - Dependency Injection nel costruttore (eccessiva)

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Actions;

use Modules\Notify\Actions\SMS\NormalizePhoneNumberAction;
use Spatie\QueueableAction\QueueableAction;

class SendRecordsNotificationBulkAction
{
    use QueueableAction;

    public function __construct(
        private readonly NormalizePhoneNumberAction $normalizePhoneAction, // ❌ Eccessiva complessità
    ) {
    }

    public function execute(Collection $records, string $templateSlug, array $channels): SendNotificationBulkResultData
    {
        // Usa la proprietà iniettata
        $normalizedPhone = $this->normalizePhoneAction->execute($phone); // ❌ Pattern non necessario
    }
}
```

## Esempi dal Codebase

### UpdateCoordinatesAction (Geo Module)

```php
class UpdateCoordinatesAction
{
    use QueueableAction;

    public function execute(Collection $models, string $addressAttribute = 'full_address'): UpdateCoordinatesResult
    {
        // ✅ Pattern corretto: app() dentro execute()
        $geocodingAction = app(GetAddressDataFromFullAddressAction::class);
        
        // Usa l'action...
    }
}
```

### SendMailByRecordsAction (Xot Module)

```php
class SendMailByRecordsAction
{
    use QueueableAction;

    public function execute(Collection $records, string $mail_class): bool
    {
        foreach ($records as $record) {
            // ✅ Pattern corretto: app() dentro execute()
            app(SendMailByRecordAction::class)->execute($record, $mail_class);
        }
        
        return true;
    }
}
```

## Quando Usare Dependency Injection

La dependency injection nel costruttore è appropriata quando:

1. **Dipendenza complessa con stato**
   - Repository con connessioni persistenti
   - Service con configurazione complessa
   - Client API con autenticazione

2. **Mocking nei test**
   - Se serve mockare specificamente per testing
   - Tuttavia, `app()` supporta binding per mocking

3. **Configurazione runtime**
   - Dipendenze che cambiano in base a configurazione
   - Provider che richiedono setup complesso

**NOTA**: Per semplici Actions che chiamano altre Actions, `app()` è sempre la scelta migliore.

## Vantaggi del Pattern `app()`

### 1. Semplicità
- Nessun costruttore necessario
- Codice più pulito e leggibile
- Meno righe di codice

### 2. Coerenza
- Pattern unico in tutto il codebase
- Facile da riconoscere e seguire
- Riduce complessità cognitiva

### 3. Testabilità
- `app()` può essere mockato facilmente
- Binding container per test
- Nessuna configurazione extra

### 4. Queue Compatibility
- Nessun problema di serializzazione
- Risoluzione al momento dell'esecuzione
- Compatibile con esecuzione asincrona

## Anti-Pattern da Evitare

### ❌ Dependency Injection Eccessiva

```php
// ❌ NON necessario per semplici chiamate tra Actions
public function __construct(
    private readonly NormalizePhoneNumberAction $normalizePhoneAction,
    private readonly SomeOtherAction $someOtherAction,
) {}
```

### ❌ Chiamate Statiche

```php
// ❌ MAI usare metodi statici
NormalizePhoneNumberAction::execute($phone);
```

### ❌ Istanziamento Diretto

```php
// ❌ MAI istanziare direttamente
$action = new NormalizePhoneNumberAction();
$result = $action->execute($phone);
```

## Checklist

Prima di aggiungere dependency injection nel costruttore per chiamare altre Actions:

- [ ] È davvero necessario? O posso usare `app()`?
- [ ] La dipendenza ha stato complesso?
- [ ] Devo configurare qualcosa prima dell'uso?
- [ ] Se la risposta è "no", usa `app()` dentro `execute()`

## Documentazione Correlata

- [Queueable Actions Pattern](../Geo/docs/architectural-philosophy.md#action-architecture-pattern)
- [Action Execution Pattern](../../Xot/docs/action-execution-pattern.md)
- [Spatie QueueableAction Documentation](../../../docs/patterns/queueable-actions.md)

---

**Filosofia**: "La semplicità è la massima sofisticazione" - Leonardo da Vinci  
**Principio**: KISS > DI quando non necessaria  
**Pattern**: `app(Action::class)->execute()` dentro `execute()`
