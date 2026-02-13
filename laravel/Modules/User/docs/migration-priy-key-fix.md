# Fix Primary Key Constraint - team_user Table

## Data
2025-01-15

## Problema Identificato

### Errore MySQL
```
SQLSTATE[42000]: Syntax error or access violation: 1171
All parts of a PRIMARY KEY must be NOT NULL;
if you need NULL in a key, use UNIQUE instead
```

### Causa Root
Nella migrazione `2023_01_01_000004_create_team_user_table.php`, la colonna `user_id` era definita come `nullable()` ma faceva parte della PRIMARY KEY composita `['team_id', 'user_id']`.

In MySQL, **tutte le colonne che fanno parte di una PRIMARY KEY devono essere NOT NULL**.

## Filosofia Laraxot per Tabelle Pivot

### Principio: Integrità Referenziale
Per una tabella pivot come `team_user`:
- Ogni record deve rappresentare una relazione **completa** tra team e user
- Entrambe le colonne (`team_id` e `user_id`) devono essere **obbligatorie**
- La PRIMARY KEY composita garantisce l'**unicità** della relazione

### Pattern Corretto
```php
// ✅ CORRETTO - Entrambe le colonne NOT NULL
$table->foreignId('team_id');        // NOT NULL (implicito)
$table->uuid('user_id');             // NOT NULL (esplicito)
$table->primary(['team_id', 'user_id']);
```

### Pattern Errato
```php
// ❌ ERRATO - user_id nullable ma parte della PRIMARY KEY
$table->foreignId('team_id');
$table->uuid('user_id')->nullable(); // ❌ INCOMPATIBILE CON PRIMARY KEY
$table->primary(['team_id', 'user_id']);
```

## Correzione Implementata

### File Modificato
`Modules/User/database/migrations/2023_01_01_000004_create_team_user_table.php`

### Modifica
```diff
- $table->uuid('user_id')->nullable();
+ $table->uuid('user_id'); // NOT NULL perché parte della PRIMARY KEY
```

## Motivazione Tecnica

### MySQL Constraint
MySQL non permette valori NULL in colonne che fanno parte di una PRIMARY KEY perché:
1. **Unicità**: NULL non può garantire unicità (più NULL sono considerati diversi)
2. **Integrità**: Una PRIMARY KEY deve identificare univocamente ogni riga
3. **Performance**: Gli indici su NULL hanno comportamento non deterministico

### Business Logic
In una relazione team-user:
- Un record senza `user_id` non ha senso logico
- Ogni relazione deve essere completa e identificabile
- La PRIMARY KEY composita previene duplicati

## Verifica Post-Correzione

### Test Migrazione
```bash
cd /home/ploi/sottana.net/laravel
php artisan migrate
```

### Risultato Atteso
```
✅ 2023_01_01_000004_create_team_user_table ................ DONE
```

### Verifica Struttura Tabella
```sql
DESCRIBE team_user;
-- team_id: bigint unsigned NOT NULL
-- user_id: char(36) NOT NULL
-- role: varchar(191) NULL
-- PRIMARY KEY (team_id, user_id)
```

## Prevenzione Futuri Errori

### Checklist Pre-Migrazione
- [ ] Verificare che colonne PRIMARY KEY siano NOT NULL
- [ ] Per tabelle pivot, entrambe le FK devono essere NOT NULL
- [ ] Testare migrazione in ambiente locale prima del commit
- [ ] Documentare scelte architetturali (nullable vs NOT NULL)

### Template Sicuro per Tabelle Pivot
```php
$this->tableCreate(static function (Blueprint $table): void {
    // FK NOT NULL per PRIMARY KEY composita
    $table->foreignId('parent_id');      // NOT NULL
    $table->uuid('child_id');             // NOT NULL (non nullable)

    // Campi opzionali possono essere nullable
    $table->string('role')->nullable();
    $table->timestamp('assigned_at')->nullable();

    // PRIMARY KEY composita
    $table->primary(['parent_id', 'child_id']);
});
```

## Collegamenti

- [Teams Migration Compliance](./teams-migration-laraxot-compliance.md)
- [Migration Best Practices](../../Xot/docs/migration-standards.md)
- [Primary Key Rules](../../../docs/development/migration_fixes_summary.md)

## Status

✅ **Fix implementato e testato**
✅ **Migrazione funzionante**
✅ **Documentazione aggiornata**

*Ultimo aggiornamento: 2025-01-15*
