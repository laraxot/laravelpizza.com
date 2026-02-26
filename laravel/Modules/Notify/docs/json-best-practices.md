# Best Practices per Migrazioni JSON

## Introduzione

Questo documento definisce le best practices per la gestione delle migrazioni che coinvolgono campi JSON in Laravel.

## Regole Fondamentali

### 1. Struttura Migrazione

```php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Modules\Xot\Database\Migrations\XotBaseMigration;

class MigrateJsonField extends XotBaseMigration
{
    public function up(): void
    {
        // Fase 1: Backup
        $this->backupData();
        
        // Fase 2: Aggiungi colonna temporanea
        $this->addTemporaryColumn();
        
        // Fase 3: Converti dati
        $this->convertData();
        
        // Fase 4: Verifica dati
        $this->validateData();
        
        // Fase 5: Rimuovi vecchia colonna
        $this->removeOldColumn();
    }
    
    protected function backupData(): void
    {
        // Implementazione backup
    }
    
    protected function addTemporaryColumn(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            $table->json('new_column')->nullable()->after('old_column');
        });
    }
    
    protected function convertData(): void
    {
        // Implementazione conversione
    }
    
    protected function validateData(): void
    {
        // Implementazione validazione
    }
    
    protected function removeOldColumn(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            $table->dropColumn('old_column');
            $table->renameColumn('new_column', 'old_column');
        });
    }
}
```

### 2. Validazione Dati

```php
protected function validateJsonData($data): array
{
    // Caso 1: Stringa semplice
    if (is_string($data)) {
        return ['default' => $data];
    }
    
    // Caso 2: Array
    if (is_array($data)) {
        return $data;
    }
    
    // Caso 3: JSON string
    if (is_string($data) && json_decode($data) !== null) {
        return json_decode($data, true);
    }
    
    // Caso 4: Valore non valido
    return ['default' => ''];
}
```

### 3. Gestione Errori

```php
protected function handleMigrationError(\Exception $e): void
{
    // Log errore
    Log::error('Errore migrazione JSON', [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
    
    // Rollback
    $this->rollback();
    
    // Notifica
    $this->notifyError($e);
}
```

## Pattern da Evitare

### 1. ❌ Modifica Diretta
```php
// NON FARE QUESTO
$table->json('column')->change();
```

### 2. ❌ Nessuna Validazione
```php
// NON FARE QUESTO
DB::table('table')->update(['column' => json_encode($data)]);
```

### 3. ❌ Nessun Backup
```php
// NON FARE QUESTO
$table->dropColumn('old_column');
```

## Pattern da Seguire

### 1. ✅ Migrazione in Fasi
```php
// FARE QUESTO
$this->tableUpdate(function (Blueprint $table): void {
    $table->json('new_column')->nullable();
});

$this->convertData();

$this->tableUpdate(function (Blueprint $table): void {
    $table->dropColumn('old_column');
    $table->renameColumn('new_column', 'old_column');
});
```

### 2. ✅ Validazione Completa
```php
// FARE QUESTO
protected function validateAndConvert($data): array
{
    try {
        return $this->validateJsonData($data);
    } catch (\Exception $e) {
        Log::warning('Errore validazione JSON', [
            'data' => $data,
            'error' => $e->getMessage()
        ]);
        return ['default' => ''];
    }
}
```

### 3. ✅ Backup e Rollback
```php
// FARE QUESTO
protected function backup(): void
{
    $this->backupData = DB::table('table')
        ->select('id', 'column')
        ->get()
        ->toArray();
}

protected function rollback(): void
{
    if ($this->backupData) {
        foreach ($this->backupData as $record) {
            DB::table('table')
                ->where('id', $record->id)
                ->update(['column' => $record->column]);
        }
    }
}
```

## Checklist Pre-Migrazione

1. [ ] Backup dati esistenti
2. [ ] Verifica struttura dati
3. [ ] Test in ambiente di sviluppo
4. [ ] Piano di rollback
5. [ ] Documentazione modifiche

## Checklist Post-Migrazione

1. [ ] Verifica integrità dati
2. [ ] Test funzionalità
3. [ ] Aggiorna documentazione
4. [ ] Monitora errori
5. [ ] Pulizia backup

## Collegamenti Correlati

- [Documentazione Migrazioni](./MIGRATION_RULES.md)
- [Gestione Errori](./ERROR_HANDLING.md)
- [Best Practices Database](./DATABASE_BEST_PRACTICES.md)

## Note Importanti

1. Testare sempre in ambiente di sviluppo
2. Mantenere backup fino a verifica completa
3. Documentare tutte le modifiche
4. Implementare logging dettagliato

## Supporto

Per supporto tecnico:
- Email: support@example.com
- Documentazione: https://docs.example.com
- Repository: https://github.com/organization/notify 
