# Cross Database Relations Issue - belongsToManyX SQLite Problem

## Problema Identificato

<<<<<<< .merge_file_yzjT7V
**Errore**: `SQLSTATE[HY000]: General error: 1 no such table: healthcare_app_data.customer_user`

**Contesto**: Il trait `HasTenants` utilizza `belongsToManyX` per creare relazioni cross-database tra User (healthcare_app_user) e Customer (healthcare_app_data).
=======
<<<<<<< HEAD
**Errore**: `SQLSTATE[HY000]: General error: 1 no such table: app_data.customer_user`

**Contesto**: Il trait `HasTenants` utilizza `belongsToManyX` per creare relazioni cross-database tra User (app_user) e Customer (app_data).
=======
**Errore**: `SQLSTATE[HY000]: General error: 1 no such table: ptvx_data.customer_user`

**Contesto**: Il trait `HasTenants` utilizza `belongsToManyX` per creare relazioni cross-database tra User (ptvx_user) e Customer (ptvx_data).
>>>>>>> f04e1ab44 (refactor: update project references from Quaeris to PTVX)
>>>>>>> .merge_file_zDNzTc

## Analisi del Trait HasTenants

### Codice Problematico
```php
// In HasTenants.php, riga 62
return $this->belongsToManyX($tenant_class);
```

### Flusso di Esecuzione
1. `User::tenants()` chiama `belongsToManyX(Customer::class)`
<<<<<<< .merge_file_yzjT7V
2. `belongsToManyX` rileva che User è in `healthcare_app_user` e Customer è in `healthcare_app_data`
3. Cerca la tabella pivot `CustomerUser` nel database `healthcare_app_data`
4. Aggiunge il prefisso database: `healthcare_app_data.customer_user`
=======
<<<<<<< HEAD
2. `belongsToManyX` rileva che User è in `app_user` e Customer è in `app_data`
3. Cerca la tabella pivot `CustomerUser` nel database `app_data`
4. Aggiunge il prefisso database: `app_data.customer_user`
=======
2. `belongsToManyX` rileva che User è in `ptvx_user` e Customer è in `ptvx_data`
3. Cerca la tabella pivot `CustomerUser` nel database `ptvx_data`
4. Aggiunge il prefisso database: `ptvx_data.customer_user`
>>>>>>> f04e1ab44 (refactor: update project references from Quaeris to PTVX)
>>>>>>> .merge_file_zDNzTc
5. SQLite non riconosce questa sintassi e fallisce

## Architettura Multi-Tenant

### Separazione Database
<<<<<<< .merge_file_yzjT7V
- **User Database**: `healthcare_app_user` - Gestione utenti e autenticazione
- **Tenant Databases**: `healthcare_app_data` - Dati specifici per customer/tenant
=======
<<<<<<< HEAD
- **User Database**: `app_user` - Gestione utenti e autenticazione
- **Tenant Databases**: `app_data` - Dati specifici per customer/tenant
=======
- **User Database**: `ptvx_user` - Gestione utenti e autenticazione
- **Tenant Databases**: `ptvx_data` - Dati specifici per customer/tenant
>>>>>>> f04e1ab44 (refactor: update project references from Quaeris to PTVX)
>>>>>>> .merge_file_zDNzTc
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
<<<<<<< .merge_file_yzjT7V
- **healthcare_app Module**: Customer-User relationships
=======
<<<<<<< HEAD
- **ExternalProject Module**: Customer-User relationships
=======
- **ModuloEsempio Module**: Customer-User relationships
>>>>>>> f04e1ab44 (refactor: update project references from Quaeris to PTVX)
>>>>>>> .merge_file_zDNzTc
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
<<<<<<< .merge_file_yzjT7V
use Modules\healthcare_app\Models\Customer;
=======
<<<<<<< HEAD
use Modules\ExternalProject\Models\Customer;
=======
use Modules\ModuloEsempio\Models\Customer;
>>>>>>> f04e1ab44 (refactor: update project references from Quaeris to PTVX)
>>>>>>> .merge_file_zDNzTc
$user = User::with('tenants')->find('0199690d-481a-7101-ac17-7518b3959314');
// Verifica che la query sia corretta
```

## Riferimenti Correlati

<<<<<<< .merge_file_yzjT7V
- [healthcare_app Customer User Table Issue](../../healthcare_app/docs/customer_user_table_issue.md)
=======
<<<<<<< HEAD
- [ExternalProject Customer User Table Issue](../../quaeris/docs/customer_user_table_issue.md)
=======
- [ModuloEsempio Customer User Table Issue](../../ptvx/docs/customer_user_table_issue.md)
>>>>>>> f04e1ab44 (refactor: update project references from Quaeris to PTVX)
>>>>>>> .merge_file_zDNzTc
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
<<<<<<< .merge_file_yzjT7V
\$tenants = \$user->getTenants(app('filament')->getPanel('healthcare_app::admin'));
=======
\$tenants = \$user->getTenants(app('filament')->getPanel('ptvx::admin'));
>>>>>>> .merge_file_zDNzTc
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
