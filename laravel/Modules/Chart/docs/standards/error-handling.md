# Gestione Errori

## Errori Comuni e Soluzioni

### 1. Errori di Migrazione

#### Colonna Duplicata
```sql
SQLSTATE[42S21]: Column already exists: 1060 Duplicate column name 'email'
```

**Causa**: Tentativo di aggiungere una colonna già esistente nella tabella.

**Soluzione**:
1. Verificare sempre l'esistenza della colonna:
```php
if (!$this->hasColumn($table, 'email')) {
    $this->tableUpdate($table, function (Blueprint $table) {
        $table->string('email');
    });
}
```

2. Usare `tableUpdate()` invece di `table()`:
```php
$this->tableUpdate('users', function (Blueprint $table) {
    // modifiche
});
```

#### Tabella Mancante
```sql
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'database.table' doesn't exist
```

**Causa**: Tentativo di accedere a una tabella non creata.

**Soluzione**:
1. Creare la migration per la tabella:
```php
$this->tableCreate('table_name', function (Blueprint $table) {
    $table->id();
    // altre colonne
});
```

2. Eseguire le migrazioni in ordine corretto.

### 2. Errori di Validazione

#### Email Duplicata
```sql
SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'email@example.com'
```

**Causa**: Tentativo di inserire un'email già esistente.

**Soluzione**:
1. Aggiungere unique index:
```php
$this->tableUpdate('users', function (Blueprint $table) {
    $table->unique('email');
});
```

2. Validare prima dell'inserimento:
```php
$validator = Validator::make($data, [
    'email' => 'required|email|unique:users,email'
]);
```

### 3. Errori di Modello

#### Colonna Mancante
```sql
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'column_name'
```

**Causa**: Tentativo di accedere a una colonna non esistente.

**Soluzione**:
1. Aggiungere la colonna alla tabella base:
```php
$this->tableUpdate('users', function (Blueprint $table) {
    if (!$this->hasColumn($table, 'column_name')) {
        $table->string('column_name');
    }
});
```

2. Verificare che la colonna sia presente nel modello.

## Checklist di Verifica

### Prima di Creare una Migration
- [ ] La tabella base esiste
- [ ] Le colonne non sono duplicate
- [ ] Uso di `tableUpdate()` e `hasColumn()`
- [ ] Unique indexes per campi unici

### Prima di Modificare un Modello
- [ ] Tutte le colonne sono nella tabella base
- [ ] Validazione implementata
- [ ] Test di integrazione

### Prima di Eseguire le Migrazioni
- [ ] Backup del database
- [ ] Test in ambiente di sviluppo
- [ ] Verifica ordine migrazioni 
