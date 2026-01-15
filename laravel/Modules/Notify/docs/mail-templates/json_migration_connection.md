# Connessione Database nelle Migrazioni JSON

## Importanza della Connessione Corretta

Quando si utilizzano migrazioni per convertire campi in formato JSON , è fondamentale considerare le seguenti regole:

1. **Uso esclusivo dei metodi XotBaseMigration**: 
   - `$this->hasColumn()` anziché `Schema::hasColumn()`
   - `$this->isColumnType()` anziché controlli diretti sul tipo
   - `$this->getColumnType()` per ottenere il tipo di colonna

2. **Transazioni e Connessioni**:
   - XotBaseMigration gestisce automaticamente la connessione corretta
   - Le operazioni DB devono rispettare questa connessione
   - Potrebbero esserci connessioni multiple in un ambiente multi-tenant

## Esempio di Implementazione Corretta

```php
// Verifica se la colonna esiste e non è di tipo JSON
if ($this->hasColumn('subject') && !$this->isColumnType('subject', 'json')) {
    // Crea colonna temporanea se non esiste
    if (!$this->hasColumn('subject_json')) {
        $table->json('subject_json')->nullable()->after('subject');
    }
    
    // Migrazione dati con chunking per performance
    if ($this->hasColumn('subject_json')) {
        DB::table('mail_templates')->chunkById(100, function ($records) {
            foreach ($records as $record) {
                // Converte in formato JSON con struttura multilingua
                if (!empty($record->subject)) {
                    DB::table('mail_templates')
                        ->where('id', $record->id)
                        ->update([
                            'subject_json' => json_encode(['it' => $record->subject])
                        ]);
                }
            }
        });
    }
    
    // Operazioni finali
    $table->dropColumn('subject');
    $table->renameColumn('subject_json', 'subject');
}
```

## Best Practices da Seguire

1. **Verifiche robuste**:
   - Controlla sempre l'esistenza delle colonne prima di operare
   - Verifica che il tipo sia quello atteso
   - Usa sempre controlli condizionali per evitare errori

2. **Migrazione sicura**:
   - Utilizza colonne temporanee per la migrazione
   - Chunking per evitare problemi di memoria
   - Verifica che la migrazione sia possibile

3. **Gestione errori**:
   - I metodi di XotBaseMigration gestiscono automaticamente gli errori
   - Non è necessario aggiungere try/catch personalizzati

## Documentazione Correlata

- [XotBaseMigration Best Practices](./XOTBASEMIGRATION_BEST_PRACTICES.md)
- [JSON Migration Fixes](./JSON_MIGRATION_FIXES.md)
- [Migration Structure](./MIGRATION_STRUCTURE.md)
- [Mail Template Migration Guide](../MAIL_TEMPLATE_MIGRATION_GUIDE.md)
