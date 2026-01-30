# Best Practices - Modulo DbForge

## Principi Generali

### Sicurezza

1. **Validazione Input**: Sempre validare tutti gli input prima di eseguire operazioni sul database
2. **Prepared Statements**: Utilizzare sempre prepared statements per prevenire SQL injection
3. **Principio del Minor Privilege**: Utilizzare account database con privilegi minimi necessari
4. **Audit Logging**: Registrare tutte le operazioni critiche per tracciabilità

### Performance

1. **Indici Ottimizzati**: Creare indici appropriati per le query più frequenti
2. **Query Optimization**: Analizzare e ottimizzare le query lente
3. **Connection Pooling**: Utilizzare connection pooling per applicazioni ad alto traffico
4. **Caching**: Implementare cache per query ripetitive

### Manutenibilità

1. **Documentazione**: Documentare sempre le migrazioni e le modifiche al database
2. **Versioning**: Utilizzare versioning per tutte le modifiche al database
3. **Testing**: Testare sempre le migrazioni in ambiente di sviluppo
4. **Backup**: Eseguire backup prima di modifiche critiche

## Struttura del Codice

### Service Layer

```php
// Esempio di Service per operazioni database
class DatabaseService
{
    public function createTable(string $tableName, array $columns): bool
    {
        try {
            DB::beginTransaction();
            
            // Validazione input
            $this->validateTableName($tableName);
            $this->validateColumns($columns);
            
            // Creazione tabella
            Schema::create($tableName, function (Blueprint $table) use ($columns) {
                foreach ($columns as $column) {
                    $this->addColumn($table, $column);
                }
            });
            
            DB::commit();
            
            // Log dell'operazione
            Log::info("Table {$tableName} created successfully");
            
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to create table {$tableName}: " . $e->getMessage());
            throw $e;
        }
    }
}
```

### Controller Pattern

```php
// Esempio di Controller per operazioni database
class DatabaseController extends Controller
{
    public function __construct(
        private DatabaseService $databaseService,
        private DatabaseValidator $validator
    ) {}
    
    public function createTable(Request $request)
    {
        // Validazione input
        $validated = $this->validator->validateCreateTable($request);
        
        // Autorizzazione
        $this->authorize('dbforge.manage');
        
        try {
            $result = $this->databaseService->createTable(
                $validated['table_name'],
                $validated['columns']
            );
            
            return response()->json([
                'success' => true,
                'message' => 'Table created successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create table',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
```

## Gestione delle Migrazioni

### Struttura Migrazione

```php
// Esempio di migrazione personalizzata
class CreateCustomTableMigration extends Migration
{
    public function up()
    {
        Schema::create('custom_table', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
            
            // Indici per performance
            $table->index('name');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('custom_table');
    }
}
```

### Best Practices per Migrazioni

1. **Sempre implementare down()**: Permette rollback sicuro
2. **Utilizzare indici appropriati**: Per query frequenti
3. **Validare dati esistenti**: Prima di modifiche strutturali
4. **Testare rollback**: Verificare che il rollback funzioni correttamente

## Gestione degli Errori

### Error Handling Pattern

```php
// Esempio di gestione errori
class DatabaseException extends Exception
{
    public function __construct(
        string $message,
        private string $operation,
        private array $context = []
    ) {
        parent::__construct($message);
    }
    
    public function getOperation(): string
    {
        return $this->operation;
    }
    
    public function getContext(): array
    {
        return $this->context;
    }
}

// Utilizzo
try {
    $this->databaseService->performOperation($data);
} catch (DatabaseException $e) {
    Log::error("Database operation failed", [
        'operation' => $e->getOperation(),
        'context' => $e->getContext(),
        'error' => $e->getMessage()
    ]);
    
    throw new HttpException(500, 'Database operation failed');
}
```

## Testing

### Test Unitari

```php
// Esempio di test unitario
class DatabaseServiceTest extends TestCase
{
    public function test_create_table_with_valid_data()
    {
        $service = new DatabaseService();
        $tableName = 'test_table';
        $columns = [
            ['name' => 'id', 'type' => 'integer', 'primary' => true],
            ['name' => 'name', 'type' => 'string', 'length' => 255]
        ];
        
        $result = $service->createTable($tableName, $columns);
        
        $this->assertTrue($result);
        $this->assertTrue(Schema::hasTable($tableName));
    }
    
    public function test_create_table_with_invalid_name_throws_exception()
    {
        $this->expectException(DatabaseException::class);
        
        $service = new DatabaseService();
        $service->createTable('invalid-table-name', []);
    }
}
```

### Test di Integrazione

```php
// Esempio di test di integrazione
class DatabaseControllerTest extends TestCase
{
    public function test_create_table_endpoint_requires_authentication()
    {
        $response = $this->postJson('/api/dbforge/tables', []);
        
        $response->assertStatus(401);
    }
    
    public function test_create_table_endpoint_validates_input()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $response = $this->postJson('/api/dbforge/tables', [
            'table_name' => '',
            'columns' => []
        ]);
        
        $response->assertStatus(422);
    }
}
```

## Configurazione

### Environment Variables

```env

# Database Forge Configuration
DBFORGE_DEBUG=false
DBFORGE_BACKUP_ENABLED=true
DBFORGE_BACKUP_RETENTION_DAYS=30
DBFORGE_QUERY_LOG_ENABLED=true
DBFORGE_MAX_QUERY_TIME=30
```

### Configurazione Cache

```php
// config/dbforge.php
return [
    'cache' => [
        'enabled' => env('DBFORGE_CACHE_ENABLED', true),
        'ttl' => env('DBFORGE_CACHE_TTL', 3600),
    ],
    'backup' => [
        'enabled' => env('DBFORGE_BACKUP_ENABLED', true),
        'retention_days' => env('DBFORGE_BACKUP_RETENTION_DAYS', 30),
    ],
    'query_log' => [
        'enabled' => env('DBFORGE_QUERY_LOG_ENABLED', false),
        'max_time' => env('DBFORGE_MAX_QUERY_TIME', 30),
    ],
];
```

## Monitoraggio

### Metriche Importanti

1. **Query Performance**: Tempo di esecuzione delle query
2. **Connection Pool**: Utilizzo delle connessioni database
3. **Error Rate**: Tasso di errori nelle operazioni database
4. **Backup Status**: Stato dei backup automatici

### Logging

```php
// Esempio di logging strutturato
Log::channel('dbforge')->info('Database operation completed', [
    'operation' => 'create_table',
    'table_name' => $tableName,
    'duration_ms' => $duration,
    'user_id' => auth()->id(),
    'ip_address' => request()->ip(),
]);
```

## Sicurezza Avanzata

### Input Sanitization

```php
// Esempio di sanitizzazione input
class DatabaseInputSanitizer
{
    public function sanitizeTableName(string $tableName): string
    {
        // Rimuovi caratteri pericolosi
        $sanitized = preg_replace('/[^a-zA-Z0-9_]/', '', $tableName);
        
        // Verifica che non inizi con numero
        if (is_numeric($sanitized[0])) {
            throw new DatabaseException('Table name cannot start with a number');
        }
        
        return $sanitized;
    }
    
    public function sanitizeColumnName(string $columnName): string
    {
        return preg_replace('/[^a-zA-Z0-9_]/', '', $columnName);
    }
}
```

### Rate Limiting

```php
// Esempio di rate limiting per operazioni critiche
Route::middleware(['auth', 'throttle:10,1'])->group(function () {
    Route::post('/api/dbforge/tables', [DatabaseController::class, 'createTable']);
    Route::delete('/api/dbforge/tables/{table}', [DatabaseController::class, 'deleteTable']);
});
```

## Conclusione

Seguire queste best practices garantisce:

- **Sicurezza**: Protezione da attacchi e vulnerabilità
- **Performance**: Ottimizzazione delle operazioni database
- **Manutenibilità**: Codice pulito e ben documentato
- **Affidabilità**: Gestione robusta degli errori
