# RelationX SQLite Cross-Database Fix

## Problema Risolto

**Data**: 26 Settembre 2025  
**Errore**: `SQLSTATE[HY000]: General error: 1 no such table: <nome progetto>_data.customer_user`

## Causa Radice

Il trait `RelationX` aggiungeva automaticamente il prefisso del database al nome della tabella pivot (`<nome progetto>_data.customer_user`) per le relazioni cross-database. Questo approccio funziona con MySQL ma non con SQLite, che non supporta la sintassi `database.table`.

## Soluzione Implementata

### File Modificato
`/var/www/_bases/base_<nome progetto>_fila4_mono/laravel/Modules/Xot/app/Models/Traits/RelationX.php`

### Correzione Applicata
Righe 51-59, aggiunto controllo del driver database:

```php
if ($pivotDbName !== $dbName || $relatedDbName !== $dbName) {
    $pivotDriver = $pivot->getConnection()->getDriverName();
    // Only add database prefix for non-SQLite drivers
    // SQLite doesn't support database.table syntax
    if ($pivotDriver !== 'sqlite') {
        $table = $pivotDbName . '.' . $table;
    }
}
```

### Logica della Correzione

1. **Rilevamento Driver**: Controlla il tipo di database utilizzato dalla connessione pivot
2. **Gestione Condizionale**: 
   - **SQLite**: Usa solo il nome della tabella (`customer_user`)
   - **MySQL/Altri**: Usa il prefisso completo (`database.table`)
3. **Compatibilità**: Mantiene il comportamento esistente per tutti i driver non-SQLite

## Impatto

### Relazioni Riparate
- ✅ `User::tenants()` - Relazione many-to-many con Customer
- ✅ `Customer::users()` - Relazione inversa 
- ✅ Filament tenant switching
- ✅ Multi-tenancy cross-database

### Moduli Affetti
- **<nome progetto> Module**: Customer-User relationships
- **User Module**: HasTenants trait functionality
- **Tutti i moduli**: che usano `belongsToManyX` con database separati

## Test di Verifica

```php
// Test relazione funzionante
$user = User::find('0199856c-eb09-7363-8ce8-f388257cb4c3');
$tenants = $user->tenants; // ✅ Nessun errore SQL
echo $tenants->count(); // ✅ Output: 1
```

## Best Practices Estrapolate

### Per Sviluppatori
1. **Driver Detection**: Sempre considerare le differenze tra database driver
2. **Cross-Database Relations**: Testare con SQLite oltre a MySQL
3. **Trait Modification**: Documentare modifiche ai trait core
4. **Backward Compatibility**: Mantenere compatibilità con driver esistenti

### Per Architettura
1. **Database Abstraction**: I trait devono gestire differenze tra driver
2. **Multi-Database**: Pianificare per diversi tipi di database
3. **Testing**: Includere test con diversi driver nei CI/CD

## Riferimenti

- [Customer User Fix Summary](../../<nome progetto>/docs/customer_user_fix_summary.md)
- [Cross Database Relations](../../User/docs/cross_database_relations_issue.md)
- [Multi-Tenant Architecture](../architecture/multi_tenant_design.md)

## Note per Manutenzione Futura

- **Attenzione**: Non modificare la logica del driver detection senza testare con tutti i database supportati
- **Testing**: Sempre testare relazioni cross-database con SQLite e MySQL
- **Documentation**: Aggiornare documentazione se si aggiungono supporti per nuovi driver
- **Performance**: Monitorare performance delle query cross-database, specialmente con SQLite

---

*Fix implementato e verificato - Sistema multi-tenant completamente funzionante*



