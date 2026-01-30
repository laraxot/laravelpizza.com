# Standard Migrazioni

## Regole Fondamentali

1. **Estensione Corretta**
   - Tutte le migrazioni DEVONO estendere `XotBaseMigration`
   - Usare SEMPRE anonymous class: `return new class extends XotBaseMigration { ... }`
   - NON implementare mai il metodo `down()`

2. **Gestione Colonne**
   - Usare SEMPRE `tableUpdate()` per modifiche alla tabella
   - Verificare SEMPRE l'esistenza delle colonne prima di aggiungerle
   - Esempio:
   ```php
   if (!$this->hasColumn($table, 'column_name')) {
       $this->tableUpdate($table, function (Blueprint $table) {
           $table->string('column_name');
       });
   }
   ```

3. **Single Table Inheritance (STI)**
   - Tutte le colonne dei modelli specializzati DEVONO essere nella tabella base
   - La colonna `type` va aggiunta SOLO nella migration della tabella base
   - NON duplicare colonne nelle migration dei modelli specializzati

4. **Validazione Unicità**
   - Validare SEMPRE l'unicità dell'email prima della creazione
   - Usare unique indexes nella tabella base

## Regola sulla Proprietà $connection

- La proprietà `$connection` nelle migrazioni che estendono XotBaseMigration deve essere dichiarata come `protected ?string $connection = 'mysql';` (o altro valore appropriato), mai solo `string`.

## Errori Comuni

1. **Colonne Duplicate**
   - ❌ Aggiungere colonne già presenti nella tabella base
   - ✅ Verificare sempre con `hasColumn()` prima di aggiungere

2. **Colonne Mancanti**
   - ❌ Omettere colonne necessarie nella tabella base
   - ✅ Documentare tutte le colonne richieste

3. **Tabelle Mancanti**
   - ❌ Non creare tabelle necessarie
   - ✅ Creare migration per ogni tabella usata

4. **Errori di Unicità**
   - ❌ Non validare l'unicità dell'email
   - ✅ Implementare validazione e unique index

## Template Migration

```php
<?php

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    public function up() {
        $this->tableUpdate('table_name', function (Blueprint $table) {
            if (!$this->hasColumn($table, 'column_name')) {
                $table->string('column_name');
            }
        });
    }
};
```

## Checklist Pre-Migration

- [ ] La migration estende `XotBaseMigration`
- [ ] Uso di anonymous class
- [ ] Verifica esistenza colonne con `hasColumn()`
- [ ] Uso di `tableUpdate()`
- [ ] Documentazione aggiornata
- [ ] Test di integrazione 
