# Best Practices per le Migration

## Struttura e Naming

1. **Path Corretto**:
   - ✅ `/var/www/html/<nome progetto>/laravel/Modules/Patient/database/migrations/`
   - ❌ `/var/www/html/<nome progetto>/Modules/Patient/Database/Migrations/`

2. **Convenzioni di Naming**:
   - Timestamp: `YYYY_MM_DD_HHMMSS`
   - Nome: `create_{table_name}_table.php` o `add_{column_name}_to_{table_name}_table.php`
   - Esempio: `2025_05_15_000001_create_doctor_registration_workflows_table.php`

## Best Practices

1. **Base Migration**:
   ```php
   use Modules\Xot\Database\Migrations\XotBaseMigration;
   
   return new class extends XotBaseMigration
   {
       protected string $table = 'table_name';
   }
   ```

2. **Timestamps e Soft Delete**:
   ```php
   $this->updateTimestamps($table, true);
   ```

3. **Foreign Keys**:
   ```php
   $table->foreign('doctor_id')
       ->references('id')
       ->on('doctors')
       ->onDelete('cascade');
   ```

4. **Indexes**:
   ```php
   $table->index('doctor_id');
   $table->index('status');
   ```

5. **UUID**:
   ```php
   $table->uuid('id')->primary();
   ```

6. **Nullable**:
   ```php
   $table->string('status')->nullable();
   ```

## Errori Comuni

1. **Errore**: Path errato
   - ❌ `/var/www/html/<nome progetto>/Modules/Patient/Database/Migrations/`
   - ✅ `/var/www/html/<nome progetto>/laravel/Modules/Patient/database/migrations/`

2. **Errore**: Non estende XotBaseMigration
   - ❌ `extends Migration`
   - ✅ `extends XotBaseMigration`

3. **Errore**: Timestamps non standardizzati
   - ❌ `$table->timestamps();`
   - ✅ `$this->updateTimestamps($table, true);`

4. **Errore**: Foreign key mancante
   - ❌ `$table->uuid('doctor_id');`
   - ✅ `$table->foreign('doctor_id')->references('id')->on('doctors');`

5. **Errore**: Index mancante
   - ❌ `$table->string('status');`
   - ✅ `$table->string('status')->index();`

## Regole Fondamentali

1. **Idempotenza**:
   ```php
   if (!$this->hasColumn('certifications')) {
       $table->json('certifications')->nullable();
   }
   ```

2. **Tipi di Dati**:
   - Usare `uuid()` per ID
   - Usare `string()` per testo
   - Usare `timestamp()` per date
   - Usare `json()` per dati strutturati

3. **Struttura Classe**:
   ```php
   class extends XotBaseMigration
   {
       protected string $table = 'table_name';
       
       public function up(): void
       {
           $this->tableCreate(function (Blueprint $table): void {
               // ...
           });
       }
   }
   ```

## Collegamenti

- [Struttura del Progetto](../project-structure.md)
- [Convenzioni di Codice](../xot/coding-standards.md)
- [Best Practices](../xot/best-practices.md) 
