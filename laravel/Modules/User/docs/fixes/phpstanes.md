# Correzioni PHPStan nel Modulo User

## Team.php
### Problema 1: Metodo Mancante
Il modello `Team` implementava l'interfaccia `TeamContract` ma mancava l'implementazione del metodo `addUser`.

### Soluzione 1
È stato aggiunto il metodo `addUser` che permette di aggiungere un utente al team con un ruolo specifico.

### Problema 2: Incompatibilità di Metodi
Sono stati rilevati problemi di compatibilità tra i metodi del modello `Team` e quelli definiti nell'interfaccia `TeamContract`:
- `hasUser()`
- `addUser()`
- `removeUser()`
- `userHasPermission()`
- `getPermissionsFor()`

### Soluzione 2
È necessario allineare le firme dei metodi con quelle definite nell'interfaccia. Le modifiche richieste sono:
1. Utilizzare solo i metodi garantiti dalle interfacce `UserContract` e `ModelContract`
2. Assicurarsi che i tipi di ritorno corrispondano esattamente
3. Assicurarsi che i parametri corrispondano esattamente

### Problema 3: Accesso alle Proprietà
Il modello `Team` accede direttamente a proprietà che potrebbero non essere disponibili attraverso l'interfaccia `UserContract`.

### Soluzione 3
È necessario:
1. Utilizzare il metodo `getKey()` invece di accedere direttamente a `id`
2. Utilizzare i metodi delle relazioni invece di accedere direttamente alle proprietà
3. Implementare controlli di tipo più robusti

### Collegamenti Bidirezionali
- [Documentazione Generale PHPStan](/docs/phpstan/PHPSTAN_LEVEL10_LINEE_GUIDA.md)
- [Contratti del Modulo User](/docs/modules/user/contracts.md)
- [Best Practices per i Modelli](/docs/modules/user/models.md)
- [Interfacce e Contratti](/docs/modules/xot/contracts.md) 

## Collegamenti tra versioni di phpstan_fixes.md
* [phpstan_fixes.md](../../../Xot/docs/phpstan_fixes.md)
* [phpstan_fixes.md](../../../User/docs/phpstan_fixes.md)
* [phpstan_fixes.md](../../../User/docs/fixes/phpstan_fixes.md)
* [phpstan_fixes.md](../../../Activity/docs/phpstan_fixes.md)

