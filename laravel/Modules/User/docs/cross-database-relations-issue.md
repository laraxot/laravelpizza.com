# Cross Database Relations Issue - belongsToManyX SQLite Problem

## Problema Identificato

**Errore**: `SQLSTATE[HY000]: General error: 1 no such table: quaeris_data.customer_user`

**Contesto**: Il trait `HasTenants` utilizza `belongsToManyX` per creare relazioni cross-database tra User (quaeris_user) e Customer (quaeris_data).

## Analisi del Trait HasTenants

### Codice Problematico
```php
// In HasTenants.php, riga 62
return $this->belongsToManyX($tenant_class);
```

### Flusso di Esecuzione
1. `User::tenants()` chiama `belongsToManyX(Customer::class)`
2. `belongsToManyX` rileva che User è in `quaeris_user` e Customer è in `quaeris_data`
3. Cerca la tabella pivot `CustomerUser` nel database `quaeris_data`
4. Aggiunge il prefisso database: `quaeris_data.customer_user`
5. SQLite non riconosce questa sintassi e fallisce

## Architettura Multi-Tenant

### Separazione Database
- **User Database**: `quaeris_user` - Gestione utenti e autenticazione
- **Tenant Databases**: `quaeris_data` - Dati specifici per customer/tenant
- **Pivot Tables**: Nel database del tenant per isolamento dati

### Filosofia Laraxot
- **Modularity**: Ogni modulo ha il proprio database
- **Isolation**: Dati tenant separati per sicurezza
- **Flexibility**: Relazioni cross-module per funzionalità avanzate

## Soluzioni Proposte

### Soluzione 1: Fix belongsToManyX per SQLite
```php
// In RelationX.php
if ($pivotDbName !== $dbName || $relatedDbName !== $dbName) {
    $driver = config('database.connections.' . $pivot->getConnection()->getName() . '.driver');
    if ($driver !== 'sqlite') {
        $table = $pivotDbName . '.' . $table;
    }
}
```

### Soluzione 2: Configurazione Database Unificata
Unificare le connessioni database per moduli correlati.

### Soluzione 3: Relazioni Esplicite
Sostituire `belongsToManyX` con relazioni `belongsToMany` esplicite per cross-database.

## Impact Analysis

### Moduli Affetti
- **User Module**: Trait HasTenants
- **Quaeris Module**: Customer-User relationships
- **Altri Moduli**: Qualsiasi relazione cross-database

### Funzionalità Compromesse
- Selezione tenant nel pannello admin
- Gestione utenti multi-tenant
- Accesso ai dati customer-specific

## Test Cases

### Test 1: Verifica Relazione Base
```php
use Modules\User\Models\User;
$user = User::find('0199690d-481a-7101-ac17-7518b3959314');
$tenants = $user->tenants; // Dovrebbe funzionare senza errori
```

### Test 2: Verifica Cross-Database Query
```php
use Modules\User\Models\User;
use Modules\Quaeris\Models\Customer;
$user = User::with('tenants')->find('0199690d-481a-7101-ac17-7518b3959314');
// Verifica che la query sia corretta
```

## Riferimenti Correlati

- [Quaeris Customer User Table Issue](../../Quaeris/docs/customer_user_table_issue.md)
- [Traits Complete Guide](./traits-complete-guide.md)
- [Jetstream vs Laraxot Philosophy](./jetstream-vs-laraxot-philosophy.md)
- [Database Errors](./database-errors.md)

## Implementazione Fix

### Correzione Applicata
Modificato il trait `RelationX` per gestire correttamente SQLite nelle relazioni cross-database:

```php
// In RelationX.php - Fix per SQLite
if ($pivotDbName !== $dbName || $relatedDbName !== $dbName) {
    $pivotDriver = $pivot->getConnection()->getDriverName();
    // Solo per driver non-SQLite aggiungere prefisso database
    if ($pivotDriver !== 'sqlite') {
        $table = $pivotDbName . '.' . $table;
    }
}
```

### Test di Regressione Completati
```bash
# Test HasTenants trait
php artisan tinker --execute="
use Modules\User\Models\User;
\$user = User::find('0199690d-481a-7101-ac17-7518b3959314');
\$tenants = \$user->tenants; // ✅ Funziona
echo 'HasTenants works! Count: ' . \$tenants->count();
"

# Test getTenants method
php artisan tinker --execute="
use Modules\User\Models\User;
\$user = User::find('0199690d-481a-7101-ac17-7518b3959314');
\$tenants = \$user->getTenants(app('filament')->getPanel('quaeris::admin'));
echo 'getTenants works! Count: ' . count(\$tenants); // ✅ Funziona
"
```

## Status

- [x] Problema identificato
- [x] Analisi architetturale completata
- [x] Soluzioni proposte
- [x] Implementazione fix
- [x] Test di regressione
- [x] Documentazione aggiornata
