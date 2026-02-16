# Gestione Conversioni JSON nelle Migrazioni

## Problema Comune
Quando si converte una colonna da `text` a `json`, è necessario gestire correttamente i dati esistenti per evitare errori di formato JSON non valido.

## Soluzione Corretta

### 1. Backup Dati
```php
// Prima di modificare la colonna
$records = DB::table('mail_templates')->get();
$backup = [];
foreach ($records as $record) {
    $backup[] = [
        'id' => $record->id,
        'subject' => $record->subject
    ];
}
```

### 2. Conversione Sicura
```php
public function up()
{
    // 1. Creare colonna temporanea
    Schema::table('mail_templates', function (Blueprint $table) {
        $table->json('subject_new')->nullable();
    });

    // 2. Convertire dati
    DB::table('mail_templates')->orderBy('id')->each(function ($record) {
        $newValue = [
            'label' => $record->subject,
            'variables' => []
        ];
        
        DB::table('mail_templates')
            ->where('id', $record->id)
            ->update(['subject_new' => json_encode($newValue)]);
    });

    // 3. Rimuovere vecchia colonna
    Schema::table('mail_templates', function (Blueprint $table) {
        $table->dropColumn('subject');
    });

    // 4. Rinominare nuova colonna
    Schema::table('mail_templates', function (Blueprint $table) {
        $table->renameColumn('subject_new', 'subject');
    });
}
```

### 3. Rollback Sicuro
```php
public function down()
{
    // 1. Creare colonna temporanea
    Schema::table('mail_templates', function (Blueprint $table) {
        $table->text('subject_old')->nullable();
    });

    // 2. Convertire dati
    DB::table('mail_templates')->orderBy('id')->each(function ($record) {
        $oldValue = json_decode($record->subject, true)['label'] ?? '';
        
        DB::table('mail_templates')
            ->where('id', $record->id)
            ->update(['subject_old' => $oldValue]);
    });

    // 3. Rimuovere colonna JSON
    Schema::table('mail_templates', function (Blueprint $table) {
        $table->dropColumn('subject');
    });

    // 4. Rinominare colonna temporanea
    Schema::table('mail_templates', function (Blueprint $table) {
        $table->renameColumn('subject_old', 'subject');
    });
}
```

## Best Practices

### 1. Validazione JSON
```php
private function isValidJson($string) {
    json_decode($string);
    return json_last_error() === JSON_ERROR_NONE;
}
```

### 2. Gestione Errori
```php
try {
    // Operazioni di migrazione
} catch (QueryException $e) {
    // Log dell'errore
    Log::error('Errore migrazione: ' . $e->getMessage());
    
    // Rollback automatico
    $this->down();
    
    throw $e;
}
```

### 3. Backup Automatico
```php
private function backupTable($tableName)
{
    $backup = DB::table($tableName)->get();
    $filename = storage_path("backups/{$tableName}_" . date('Y-m-d_His') . '.json');
    
    File::put($filename, json_encode($backup));
    
    return $filename;
}
```

## Regole Importanti

1. **Mai Convertire Direttamente**
   - Non convertire mai direttamente da text a json
   - Usare sempre una colonna temporanea
   - Validare i dati prima della conversione

2. **Backup Sempre**
   - Fare backup prima di ogni modifica
   - Verificare il backup
   - Mantenere i backup per un periodo

3. **Test in Ambiente**
   - Testare in ambiente di sviluppo
   - Verificare con dati reali
   - Simulare rollback

4. **Gestione Errori**
   - Implementare try/catch
   - Logging dettagliato
   - Rollback automatico in caso di errore

## Esempi di Implementazione

### 1. Migrazione Base
```php
class ConvertSubjectToJson extends Migration
{
    public function up()
    {
        // Backup
        $backupFile = $this->backupTable('mail_templates');
        
        try {
            // Implementazione conversione
            $this->convertColumnToJson('mail_templates', 'subject');
        } catch (Exception $e) {
            // Rollback in caso di errore
            $this->restoreFromBackup($backupFile);
            throw $e;
        }
    }
}
```

### 2. Helper Methods
```php
private function convertColumnToJson($table, $column)
{
    // 1. Colonna temporanea
    Schema::table($table, function (Blueprint $table) use ($column) {
        $table->json("{$column}_new")->nullable();
    });

    // 2. Conversione dati
    DB::table($table)->orderBy('id')->each(function ($record) use ($table, $column) {
        $newValue = $this->convertToJsonFormat($record->$column);
        
        DB::table($table)
            ->where('id', $record->id)
            ->update(["{$column}_new" => json_encode($newValue)]);
    });

    // 3. Swap colonne
    Schema::table($table, function (Blueprint $table) use ($column) {
        $table->dropColumn($column);
        $table->renameColumn("{$column}_new", $column);
    });
}
```

## Note di Implementazione

### 1. Performance
- Usare chunk per grandi tabelle
- Ottimizzare query
- Gestire indici

### 2. Sicurezza
- Validare input
- Sanitizzare output
- Gestire permessi

### 3. Manutenzione
- Documentare modifiche
- Versionare backup
- Monitorare performance

## Collegamenti
- [Laravel Migrations](https://laravel.com/docs/migrations)
- [MySQL JSON](https://dev.mysql.com/doc/refman/8.0/en/json.html)
- [PostgreSQL JSON](https://www.postgresql.org/docs/current/datatype-json.html) 
