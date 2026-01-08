# Analisi di Larabank Projectors

## Panoramica

Larabank Projectors è un'implementazione di un sistema bancario che utilizza il pattern Event Sourcing con un approccio basato su proiettori. Questo approccio separa chiaramente la scrittura degli eventi dalla loro proiezione in viste leggibili, seguendo il principio di responsabilità singola.

## Architettura

### Componenti Principali

1. **Modelli**
   - `Account`: Modello Eloquent che rappresenta la vista corrente di un conto
   - `Transaction`: Modello Eloquent che registra le transazioni

2. **Eventi**
   - `AccountCreated`: Emesso alla creazione di un conto
   - `MoneyDeposited`: Emesso al deposito di denaro
   - `MoneyWithdrawn`: Emesso al prelievo di denaro
   - `MoneyTransferred`: Emesso al trasferimento di denaro

3. **Proiettori**
   - `AccountProjector`: Gestisce la proiezione degli eventi relativi ai conti
   - `TransactionProjector`: Gestisce la proiezione delle transazioni

4. **Reattori**
   - `SendThankYouEmail`: Invia email di conferma per determinate operazioni

## Flusso di Dati

1. **Creazione di un Conto**
   ```php
   event(new AccountCreated($accountUuid, 'Mario Rossi'));
   ```

2. **Deposito**
   ```php
   event(new MoneyDeposited($accountUuid, 1000, 'Deposito iniziale'));
   ```

3. **Prelievo**
   ```php
   event(new MoneyWithdrawn($accountUuid, 500, 'Prelievo contanti'));
   ```

4. **Trasferimento**
   ```php
   event(new MoneyTransferred($sourceUuid, $destinationUuid, 1000, 'Trasferimento'));
   ```

## Vantaggi

1. **Separazione delle Preoccupazioni**:
   - Scrittura (comandi) e lettura (query) sono separati
   - Ogni proiettore si occupa di una singola proiezione

2. **Flessibilità**:
   - Facile aggiungere nuove viste senza modificare la logica esistente
   - Possibilità di avere viste diverse per gli stessi dati

3. **Manutenibilità**:
   - Codice modulare e facile da testare
   - Meno accoppiamento tra i componenti

## Limitazioni

1. **Complessità**:
   - Maggiore complessità architetturale
   - Più componenti da gestire

2. **Consistenza Finale**:
   - Le proiezioni potrebbero non essere immediatamente aggiornate
   - Necessità di gestire la consistenza tra eventi e proiezioni

## Esempio di Codice

### Proiettore di Account

```php
class AccountProjector extends Projector
{
    public function onAccountCreated(AccountCreated $event)
    {
        Account::create([
            'uuid' => $event->accountUuid,
            'account_holder' => $event->accountHolder,
            'balance' => 0,
        ]);
    }

    public function onMoneyDeposited(MoneyDeposited $event)
    {
        $account = Account::where('uuid', $event->accountUuid)->firstOrFail();
        $account->balance += $event->amount;
        $account->save();
    }

    public function onMoneyWithdrawn(MoneyWithdrawn $event)
    {
        $account = Account::where('uuid', $event->accountUuid)->firstOrFail();
        $account->balance -= $event->amount;
        $account->save();
    }

    public function onMoneyTransferred(MoneyTransferred $event)
    {
        $source = Account::where('uuid', $event->sourceUuid)->firstOrFail();
        $destination = Account::where('uuid', $event->destinationUuid)->firstOrFail();

        DB::transaction(function () use ($source, $destination, $event) {
            $source->balance -= $event->amount;
            $destination->balance += $event->amount;

            $source->save();
            $destination->save();
        });
    }
}
```

### Reattore per l'Invio di Email

```php
class SendThankYouEmail extends Reactor
{
    public function onMoneyDeposited(MoneyDeposited $event)
    {
        $account = Account::where('uuid', $event->accountUuid)->first();
        
        if (! $account) {
            return;
        }

        Mail::to($account->email)->send(new DepositReceived(
            $account,
            $event->amount,
            $event->description
        ));
    }
}
```

### Test di Esempio

```php
/** @test */
public function it_can_project_an_account_creation()
{
    $uuid = Str::uuid();
    
    event(new AccountCreated($uuid, 'Mario Rossi'));
    
    $this->assertDatabaseHas('accounts', [
        'uuid' => $uuid,
        'account_holder' => 'Mario Rossi',
        'balance' => 0,
    ]);
}

/** @test */
public function it_can_project_a_deposit()
{
    $account = Account::factory()->create(['balance' => 0]);
    
    event(new MoneyDeposited($account->uuid, 1000, 'Deposito iniziale'));
    
    $this->assertDatabaseHas('accounts', [
        'uuid' => $account->uuid,
        'balance' => 1000,
    ]);
}
```

## Considerazioni sull'Implementazione

1. **Gestione degli Errori**:
   - Implementare meccanismi di riprova per le proiezioni fallite
   - Loggare gli errori per il debug

2. **Performance**:
   - Utilizzare il caricamento eager per le relazioni
   - Considerare l'uso di batch per operazioni multiple

3. **Manutenzione**:
   - Documentare chiaramente ogni proiettore e il suo scopo
   - Mantenere i proiettori piccoli e focalizzati

## Conclusione

L'approccio basato sui proiettori offre un'ottima separazione tra la scrittura e la lettura dei dati, rendendo il sistema più flessibile e manutenibile. È particolarmente adatto per applicazioni che richiedono viste multiple degli stessi dati o che hanno requisiti di lettura/scrittura molto diversi.
