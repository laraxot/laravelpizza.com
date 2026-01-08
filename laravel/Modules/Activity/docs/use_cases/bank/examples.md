# Esempi Pratici - Use Case Bancario

## Approccio Tradizionale (CRUD)
### Deposito
```php
$account = Account::find($accountId);
$account->balance += 100;
$account->save();
```

## Event Sourcing con Projectors/Eventsauce
### Comando: DepositMoney
```php
$command = new DepositMoney(
    accountUuid: $account->uuid,
    amount: 100.0
);
```

### Evento: MoneyDeposited
```php
$event = new MoneyDeposited(
    accountUuid: $account->uuid,
    amount: 100.0
);
```

### Query: Proiezione saldo
```php
$balance = AccountBalanceProjection::forAccount($account->uuid);
```

### Fallback su activitylog
```php
activity()
    ->causedBy($user)
    ->performedOn($account)
    ->withProperties(['amount' => 100])
    ->log('MoneyDeposited fallback');
```

### Rollback (Event Sourcing)
- Riprodurre tutti gli eventi fino al punto desiderato
- Applicare snapshot periodici per velocizzare il replay 
