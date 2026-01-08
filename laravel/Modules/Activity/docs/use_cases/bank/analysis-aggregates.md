# Analisi di Larabank Aggregates

## Panoramica

Larabank Aggregates è un'implementazione di un sistema bancario semplificato che utilizza il pattern Event Sourcing con un approccio basato sugli aggregati. Questo repository dimostra come gestire le transazioni bancarie utilizzando aggregati per garantire la consistenza dei dati.

## Architettura

### Componenti Principali

1. **Aggregati**
   - `BankAccount`: Rappresenta un conto bancario con il suo saldo corrente
   - Gestisce la logica di business per prelievi, depositi e trasferimenti
   - Mantiene lo stato corrente basandosi sugli eventi applicati

2. **Eventi**
   - `AccountCreated`: Emesso quando viene creato un nuovo conto
   - `MoneyAdded`: Emesso quando viene depositato denaro
   - `MoneySubtracted`: Emesso quando viene prelevato denaro
   - `MoneyTransferred`: Emesso quando avviene un trasferimento tra conti

3. **Repository**
   - `BankAccountRepository`: Gestisce il salvataggio e il recupero degli aggregati
   - Si occupa della persistenza e del recupero dello stato degli aggregati

## Flusso di Dati

1. **Creazione di un Conto**
   ```php
   $account = BankAccount::createAccount('1234567890', 'Mario Rossi');
   $this->repository->save($account);
   ```

2. **Deposito**
   ```php
   $account = $this->repository->get($accountId);
   $account->addMoney(1000);
   $this->repository->save($account);
   ```

3. **Prelievo**
   ```php
   $account = $this->repository->get($accountId);
   $account->subtractMoney(500);
   $this->repository->save($account);
   ```

4. **Trasferimento**
   ```php
   $sourceAccount = $this->repository->get($sourceAccountId);
   $destinationAccount = $this->repository->get($destinationAccountId);
   
   $sourceAccount->transferMoney($destinationAccount, 1000);
   
   $this->repository->save($sourceAccount);
   $this->repository->save($destinationAccount);
   ```

## Vantaggi

1. **Consistenza Forte**: Gli aggregati garantiscono che le regole di business vengano rispettate
2. **Tracciabilità**: Tutte le modifiche sono registrate come eventi
3. **Performance**: Le operazioni avvengono in memoria e vengono salvate in batch
4. **Semplice da Testare**: La logica di business è isolata e facilmente testabile

## Limitazioni

1. **Concorrenza**: Gestione esplicita della concorrenza necessaria
2. **Complessità**: Maggiore complessità rispetto ad approcci tradizionali
3. **Learning Curve**: Richiede familiarità con i concetti di DDD e Event Sourcing

## Esempio di Codice

### BankAccount Aggregate

```php
class BankAccount extends AggregateRoot
{
    private string $accountNumber;
    private string $accountHolder;
    private int $balance = 0;
    private bool $isClosed = false;

    public static function createAccount(string $accountNumber, string $accountHolder): self
    {
        $account = new static($accountNumber);
        $account->recordThat(new AccountCreated($accountNumber, $accountHolder));
        return $account;
    }

    public function addMoney(int $amount): void
    {
        if ($this->isClosed) {
            throw new CannotDepositOnClosedAccount($this->accountNumber);
        }

        if ($amount <= 0) {
            throw new InvalidDepositAmount($amount);
        }

        $this->recordThat(new MoneyAdded($this->accountNumber, $amount));
    }

    // Altri metodi...
}
```

### Test di Esempio

```php
/** @test */
public function it_can_deposit_money()
{
    $account = BankAccount::createAccount('1234567890', 'Mario Rossi');
    $account->addMoney(1000);
    
    $this->assertEquals(1000, $account->getBalance());
}

/** @test */
public function it_cannot_deposit_negative_amount()
{
    $account = BankAccount::createAccount('1234567890', 'Mario Rossi');
    
    $this->expectException(InvalidDepositAmount::class);
    $account->addMoney(-100);
}
```

## Considerazioni sull'Implementazione

1. **Gestione della Concorrenza**:
   - Utilizza il versionamento degli aggregati per rilevare conflitti
   - Implementa meccanismi di ritry in caso di conflitti

2. **Ottimizzazione delle Prestazioni**:
   - Cache degli aggregati in memoria
   - Salvataggio in batch degli eventi

3. **Manutenzione**:
   - Documentazione dettagliata per ogni metodo
   - Test completi per garantire la correttezza

## Conclusione

L'approccio basato sugli aggregati offre un buon equilibrio tra consistenza dei dati e prestazioni. È particolarmente adatto per domini complessi con regole di business articolate.
