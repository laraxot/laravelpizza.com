# Struttura Database - Modulo DbForge

## Panoramica

Il modulo DbForge gestisce la struttura del database attraverso migrazioni, modelli e servizi dedicati. Questo documento descrive la struttura del database e le relazioni tra le entità.

## Tabelle Principali

### dbforge_operations

Tabella per tracciare le operazioni di database management.

```sql
CREATE TABLE dbforge_operations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    operation_type VARCHAR(50) NOT NULL,
    table_name VARCHAR(255) NULL,
    operation_data JSON NULL,
    status ENUM('pending', 'running', 'completed', 'failed') NOT NULL,
    error_message TEXT NULL,
    created_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    completed_at TIMESTAMP NULL,
    
    INDEX idx_operation_type (operation_type),
    INDEX idx_status (status),
    INDEX idx_created_by (created_by),
    INDEX idx_created_at (created_at)
);
```

### dbforge_backups

Tabella per gestire i backup del database.

```sql
CREATE TABLE dbforge_backups (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    backup_name VARCHAR(255) NOT NULL,
    backup_path VARCHAR(500) NOT NULL,
    backup_size BIGINT UNSIGNED NOT NULL,
    backup_type ENUM('full', 'incremental', 'selective') NOT NULL,
    status ENUM('pending', 'running', 'completed', 'failed') NOT NULL,
    retention_days INT UNSIGNED NOT NULL DEFAULT 30,
    created_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    completed_at TIMESTAMP NULL,
    
    INDEX idx_backup_type (backup_type),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at),
    INDEX idx_retention_days (retention_days)
);
```

### dbforge_migrations

Tabella per gestire le migrazioni personalizzate.

```sql
CREATE TABLE dbforge_migrations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    migration_name VARCHAR(255) NOT NULL,
    migration_file VARCHAR(500) NOT NULL,
    batch INT UNSIGNED NOT NULL,
    status ENUM('pending', 'running', 'completed', 'failed', 'rolled_back') NOT NULL,
    execution_time INT UNSIGNED NULL,
    error_message TEXT NULL,
    created_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    executed_at TIMESTAMP NULL,
    
    UNIQUE KEY uk_migration_name (migration_name),
    INDEX idx_batch (batch),
    INDEX idx_status (status),
    INDEX idx_created_by (created_by)
);
```

### dbforge_query_logs

Tabella per loggare le query eseguite (opzionale).

```sql
CREATE TABLE dbforge_query_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    query_sql TEXT NOT NULL,
    query_time DECIMAL(10,4) NOT NULL,
    rows_affected INT UNSIGNED NULL,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    created_at TIMESTAMP NULL,
    
    INDEX idx_query_time (query_time),
    INDEX idx_user_id (user_id),
    INDEX idx_created_at (created_at)
);
```

### dbforge_schemas

Tabella per memorizzare informazioni sullo schema del database.

```sql
CREATE TABLE dbforge_schemas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    table_name VARCHAR(255) NOT NULL,
    schema_data JSON NOT NULL,
    version INT UNSIGNED NOT NULL DEFAULT 1,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    created_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    UNIQUE KEY uk_table_version (table_name, version),
    INDEX idx_table_name (table_name),
    INDEX idx_is_active (is_active),
    INDEX idx_created_by (created_by)
);
```

## Relazioni

### Relazioni con Modulo User

```sql
-- Relazione con la tabella users per tracciare chi ha eseguito le operazioni
ALTER TABLE dbforge_operations 
ADD CONSTRAINT fk_dbforge_operations_created_by 
FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL;

ALTER TABLE dbforge_backups 
ADD CONSTRAINT fk_dbforge_backups_created_by 
FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL;

ALTER TABLE dbforge_migrations 
ADD CONSTRAINT fk_dbforge_migrations_created_by 
FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL;

ALTER TABLE dbforge_query_logs 
ADD CONSTRAINT fk_dbforge_query_logs_user_id 
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL;

ALTER TABLE dbforge_schemas 
ADD CONSTRAINT fk_dbforge_schemas_created_by 
FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL;
```

## Modelli Eloquent

### DbForgeOperation

```php
<?php

namespace Modules\DbForge\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DbForgeOperation extends Model
{
    use HasFactory;

    protected $table = 'dbforge_operations';

    protected $fillable = [
        'operation_type',
        'table_name',
        'operation_data',
        'status',
        'error_message',
        'created_by',
        'completed_at'
    ];

    protected $casts = [
        'operation_data' => 'array',
        'completed_at' => 'datetime'
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
}
```

### DbForgeBackup

```php
<?php

namespace Modules\DbForge\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DbForgeBackup extends Model
{
    use HasFactory;

    protected $table = 'dbforge_backups';

    protected $fillable = [
        'backup_name',
        'backup_path',
        'backup_size',
        'backup_type',
        'status',
        'retention_days',
        'created_by',
        'completed_at'
    ];

    protected $casts = [
        'completed_at' => 'datetime'
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeFull($query)
    {
        return $query->where('backup_type', 'full');
    }

    public function scopeIncremental($query)
    {
        return $query->where('backup_type', 'incremental');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
```

### DbForgeMigration

```php
<?php

namespace Modules\DbForge\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DbForgeMigration extends Model
{
    use HasFactory;

    protected $table = 'dbforge_migrations';

    protected $fillable = [
        'migration_name',
        'migration_file',
        'batch',
        'status',
        'execution_time',
        'error_message',
        'created_by',
        'executed_at'
    ];

    protected $casts = [
        'executed_at' => 'datetime'
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
}
```

## Migrazioni

### Creazione Tabelle

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDbForgeTables extends Migration
{
    public function up()
    {
        Schema::create('dbforge_operations', function (Blueprint $table) {
            $table->id();
            $table->string('operation_type', 50);
            $table->string('table_name')->nullable();
            $table->json('operation_data')->nullable();
            $table->enum('status', ['pending', 'running', 'completed', 'failed']);
            $table->text('error_message')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->timestamp('completed_at')->nullable();
            
            $table->index('operation_type');
            $table->index('status');
            $table->index('created_by');
            $table->index('created_at');
        });

        Schema::create('dbforge_backups', function (Blueprint $table) {
            $table->id();
            $table->string('backup_name');
            $table->string('backup_path', 500);
            $table->unsignedBigInteger('backup_size');
            $table->enum('backup_type', ['full', 'incremental', 'selective']);
            $table->enum('status', ['pending', 'running', 'completed', 'failed']);
            $table->unsignedInteger('retention_days')->default(30);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->timestamp('completed_at')->nullable();
            
            $table->index('backup_type');
            $table->index('status');
            $table->index('created_at');
            $table->index('retention_days');
        });

        Schema::create('dbforge_migrations', function (Blueprint $table) {
            $table->id();
            $table->string('migration_name')->unique();
            $table->string('migration_file', 500);
            $table->unsignedInteger('batch');
            $table->enum('status', ['pending', 'running', 'completed', 'failed', 'rolled_back']);
            $table->unsignedInteger('execution_time')->nullable();
            $table->text('error_message')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->timestamp('executed_at')->nullable();
            
            $table->index('batch');
            $table->index('status');
            $table->index('created_by');
        });

        Schema::create('dbforge_query_logs', function (Blueprint $table) {
            $table->id();
            $table->text('query_sql');
            $table->decimal('query_time', 10, 4);
            $table->unsignedInteger('rows_affected')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            
            $table->index('query_time');
            $table->index('user_id');
            $table->index('created_at');
        });

        Schema::create('dbforge_schemas', function (Blueprint $table) {
            $table->id();
            $table->string('table_name');
            $table->json('schema_data');
            $table->unsignedInteger('version')->default(1);
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            $table->unique(['table_name', 'version']);
            $table->index('table_name');
            $table->index('is_active');
            $table->index('created_by');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dbforge_schemas');
        Schema::dropIfExists('dbforge_query_logs');
        Schema::dropIfExists('dbforge_migrations');
        Schema::dropIfExists('dbforge_backups');
        Schema::dropIfExists('dbforge_operations');
    }
}
```

## Indici e Ottimizzazioni

### Indici per Performance

```sql
-- Indici aggiuntivi per ottimizzare le query più frequenti
CREATE INDEX idx_dbforge_operations_type_status ON dbforge_operations(operation_type, status);
CREATE INDEX idx_dbforge_backups_type_status ON dbforge_backups(backup_type, status);
CREATE INDEX idx_dbforge_migrations_batch_status ON dbforge_migrations(batch, status);
CREATE INDEX idx_dbforge_query_logs_time_user ON dbforge_query_logs(query_time, user_id);
```

### Partizionamento (per tabelle grandi)

```sql
-- Esempio di partizionamento per dbforge_query_logs (se necessario)
ALTER TABLE dbforge_query_logs 
PARTITION BY RANGE (YEAR(created_at)) (
    PARTITION p2023 VALUES LESS THAN (2024),
    PARTITION p2024 VALUES LESS THAN (2025),
    PARTITION p2025 VALUES LESS THAN (2026),
    PARTITION p_future VALUES LESS THAN MAXVALUE
);
```

## Backup e Manutenzione

### Procedure di Backup

```sql
-- Procedure per backup automatico
DELIMITER //
CREATE PROCEDURE CleanupOldBackups()
BEGIN
    DELETE FROM dbforge_backups 
    WHERE created_at < DATE_SUB(NOW(), INTERVAL retention_days DAY)
    AND status = 'completed';
END //
DELIMITER ;

-- Evento per eseguire la pulizia automaticamente
CREATE EVENT cleanup_backups_event
ON SCHEDULE EVERY 1 DAY
DO CALL CleanupOldBackups();
```

### Pulizia Log

```sql
-- Procedure per pulizia log vecchi
DELIMITER //
CREATE PROCEDURE CleanupOldQueryLogs()
BEGIN
    DELETE FROM dbforge_query_logs 
    WHERE created_at < DATE_SUB(NOW(), INTERVAL 90 DAY);
END //
DELIMITER ;

-- Evento per pulizia automatica
CREATE EVENT cleanup_query_logs_event
ON SCHEDULE EVERY 1 WEEK
DO CALL CleanupOldQueryLogs();
```

## Monitoraggio

### Query per Monitoraggio

```sql
-- Operazioni in corso
SELECT COUNT(*) as pending_operations 
FROM dbforge_operations 
WHERE status IN ('pending', 'running');

-- Backup recenti
SELECT backup_name, backup_size, created_at 
FROM dbforge_backups 
WHERE status = 'completed' 
ORDER BY created_at DESC 
LIMIT 10;

-- Query lente
SELECT query_sql, query_time, created_at 
FROM dbforge_query_logs 
WHERE query_time > 1.0 
ORDER BY query_time DESC 
LIMIT 20;

-- Errori recenti
SELECT operation_type, error_message, created_at 
FROM dbforge_operations 
WHERE status = 'failed' 
ORDER BY created_at DESC 
LIMIT 10;
```

## Sicurezza

### Permessi Database

```sql
-- Creazione utente con privilegi limitati per il modulo
CREATE USER 'dbforge_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT SELECT, INSERT, UPDATE, DELETE ON dbforge_operations TO 'dbforge_user'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON dbforge_backups TO 'dbforge_user'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON dbforge_migrations TO 'dbforge_user'@'localhost';
GRANT SELECT, INSERT ON dbforge_query_logs TO 'dbforge_user'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON dbforge_schemas TO 'dbforge_user'@'localhost';
```

Questa struttura del database fornisce una base solida per il modulo DbForge, con supporto per tracciamento, backup, migrazioni e monitoraggio delle operazioni di database management. 