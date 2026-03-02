# Regola: Connessioni Database - Modulo Activity

## Principio

- **database.php**: NON aggiungere 'activity' (TenantServiceProvider la crea a runtime)
- **Modelli**: DEVONO avere `protected $connection = 'activity'`

## Perché

TenantServiceProvider crea la connessione 'activity' per ogni modulo (getSnakeName). La connessione punta allo stesso DB del default, con eventuali override via env. I modelli devono dichiararla per DatabaseTransactions e coerenza.

## Modelli che usano la connessione 'activity'

- StoredEvent, Activity, Snapshot, BaseModel (Activity), BaseActivity (Xot)

## Modelli - pattern obbligatorio

```php
/** @var string */
protected $connection = 'activity';
```

## Anti-pattern: $connection = null

**MAI** usare `protected $connection = null` nel modulo Activity. Null = connessione default (mysql), rompe coerenza e DatabaseTransactions. Vedi [basemodel-connection-why-activity-not-null](basemodel-connection-why-activity-not-null.md).

## .env.testing - NO variabili DB_*_ACTIVITY

NON usare DB_DATABASE_ACTIVITY, DB_USERNAME_ACTIVITY, DB_PASSWORD_ACTIVITY in .env.testing. TenantServiceProvider usa fallback dal default. Vedi [fix03](prompts/fix03.txt).

## Collegamenti

- [fix01](prompts/fix01.txt)
- [fix02](prompts/fix02.txt)
- [fix03](prompts/fix03.txt)
- [basemodel-connection-why-activity-not-null](basemodel-connection-why-activity-not-null.md)
- [testing-coverage-policy](testing-coverage-policy.md)
- [database-connections rule](../../../.cursor/rules/database-connections.mdc)
