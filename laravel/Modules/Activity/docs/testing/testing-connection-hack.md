# Activity Model: Testing Connection Hack

## Cosa

Nel modello `Activity` (che estende `SpatieActivity`) è presente un override in `__construct()`:

```php
if (app()->environment('testing')) {
    $this->connection = config('database.default');
}
```

## Perché è una cagata (anti-pattern)

1. **Comportamento dipendente dall'ambiente**: Il modello si comporta diversamente in test vs produzione. In prod usa `activitylog.database_connection` (o `activity`), in test usa `database.default`.

2. **I test non rispecchiano la produzione**: Se in produzione Activity scrive sulla connessione `activity`, i test dovrebbero fare lo stesso. Questo hack nasconde problemi di configurazione.

3. **Fix corretto sarebbe**: Configurare correttamente la connessione `activity` in `.env.testing` e in `TenantServiceProvider::registerDB()` per l'ambiente testing, così che `activity` punti allo stesso DB del default.

4. **Magic/implicito**: Gli sviluppatori potrebbero non sapere che Activity usa una connessione diversa in test.

## Perché è stato introdotto

- I test Activity fallivano perché la connessione `activity` non era disponibile o configurata diversamente in testing.
- `TenantServiceProvider::registerDB()` aggiunge le connessioni modulari a runtime, ma in alcuni setup di test (es. SQLite, single-DB) la connessione `activity` può non esistere o puntare altrove.
- Soluzione rapida: in test usare sempre `database.default`.

## Quando rimuoverlo

Rimuovere questo hack quando:

1. `.env.testing` e `TenantServiceProvider` garantiscono che `activity` esista e punti al DB di test.
2. Tutti i test Activity passano senza questo override.
3. `$connectionsToTransact` nel TestCase include `activity` e il rollback funziona correttamente.

## Collegamenti

- [basemodel-connection-why-activity-not-null](../basemodel-connection-why-activity-not-null.md)
- [testing-testcase-database-connection-fix](../testing-testcase-database-connection-fix.md)
- [database-config-standard](../../../../.cursor/rules/database-config-standard.mdc)
