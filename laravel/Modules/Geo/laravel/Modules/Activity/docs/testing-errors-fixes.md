# Activity Module - Errori di Test e Correzioni

## Obiettivo

Documentare gli errori trovati nei test del modulo Activity e le relative correzioni per raggiungere coverage 100%.

## Errori Risolti

### 1. ActivityLoggerTest getRecent - Isolamento Dati

**Problema**: Il test `ActivityLogger can get recent activities` falliva con:
```
Failed asserting that actual size 1 matches expected size 2.
```

**Causa**: La connessione `activity` non era inclusa in `$connectionsToTransact`. Le attività create dai test precedenti non venivano fatte rollback. `getRecent(5)` restituiva le 5 attività più recenti di TUTTO il database.

**Soluzione**: Aggiungere `'activity'` a `$connectionsToTransact` (fix 2). Aumentare il limit a `getRecent(10)` e aggiungere assert su `$recent->count()`.

### 2. TestCase - Connessione activity Mancante

**Problema**: Le attività non venivano fatte rollback tra i test.

**Causa**: `$connectionsToTransact` conteneva solo `['mysql', 'user']`. I modelli Activity usano `$connection = 'activity'`.

**Soluzione**: Aggiungere `'activity'` a `$connectionsToTransact` in TestCase.php.

**Regola**: Ogni connessione usata dai modelli DEVE essere in `$connectionsToTransact`.

### 3. Test Skipped - LoginListener e LogoutListener

**Problema**: 2 test skippati: "LoginListener/LogoutListener is not registered in EventServiceProvider".

**Azione**: Verificare EventServiceProvider e registrare i listener se necessario.

## Collegamenti

- [testing-coverage-policy](testing-coverage-policy.md)
