# API Documentation - Modulo DbForge

## Panoramica

Il modulo DbForge fornisce un'API REST completa per la gestione e manipolazione del database. Tutti gli endpoint richiedono autenticazione e autorizzazione appropriata.

## Autenticazione

Tutti gli endpoint richiedono autenticazione tramite Bearer Token:

```
Authorization: Bearer {token}
```

## Endpoints

### Database Operations

#### Lista Tabelle

```http
GET /api/dbforge/tables
```

**Parametri Query:**
- `search` (string, opzionale): Ricerca per nome tabella
- `per_page` (integer, opzionale): Numero di risultati per pagina (default: 15)
- `page` (integer, opzionale): Numero di pagina (default: 1)

**Risposta di Successo (200):**
```json
{
    "data": [
        {
            "id": 1,
            "name": "users",
            "engine": "InnoDB",
            "rows": 1250,
            "data_length": 1048576,
            "index_length": 524288,
            "created_at": "2024-01-15T10:30:00Z",
            "updated_at": "2024-01-15T10:30:00Z"
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 5,
        "per_page": 15,
        "total": 75
    }
}
```

#### Dettagli Tabella

```http
GET /api/dbforge/tables/{table_name}
```

**Parametri Path:**
- `table_name` (string, required): Nome della tabella

**Risposta di Successo (200):**
```json
{
    "data": {
        "name": "users",
        "engine": "InnoDB",
        "collation": "utf8mb4_unicode_ci",
        "rows": 1250,
        "data_length": 1048576,
        "index_length": 524288,
        "columns": [
            {
                "name": "id",
                "type": "bigint unsigned",
                "nullable": false,
                "default": null,
                "key": "PRI",
                "extra": "auto_increment"
            },
            {
                "name": "name",
                "type": "varchar(255)",
                "nullable": false,
                "default": null,
                "key": "",
                "extra": ""
            }
        ],
        "indexes": [
            {
                "name": "PRIMARY",
                "type": "BTREE",
                "columns": ["id"]
            }
        ]
    }
}
```

#### Crea Tabella

```http
POST /api/dbforge/tables
```

**Body:**
```json
{
    "table_name": "new_table",
    "engine": "InnoDB",
    "collation": "utf8mb4_unicode_ci",
    "columns": [
        {
            "name": "id",
            "type": "bigint unsigned",
            "nullable": false,
            "auto_increment": true,
            "primary_key": true
        },
        {
            "name": "name",
            "type": "varchar(255)",
            "nullable": false
        },
        {
            "name": "email",
            "type": "varchar(255)",
            "nullable": false,
            "unique": true
        },
        {
            "name": "created_at",
            "type": "timestamp",
            "nullable": true,
            "default": "CURRENT_TIMESTAMP"
        }
    ],
    "indexes": [
        {
            "name": "idx_name",
            "type": "BTREE",
            "columns": ["name"]
        }
    ]
}
```

**Risposta di Successo (201):**
```json
{
    "data": {
        "table_name": "new_table",
        "status": "created",
        "operation_id": 123,
        "message": "Table created successfully"
    }
}
```

#### Modifica Tabella

```http
PUT /api/dbforge/tables/{table_name}
```

**Parametri Path:**
- `table_name` (string, required): Nome della tabella

**Body:**
```json
{
    "columns": [
        {
            "action": "add",
            "name": "new_column",
            "type": "varchar(100)",
            "nullable": true
        },
        {
            "action": "modify",
            "name": "existing_column",
            "type": "varchar(255)",
            "nullable": false
        },
        {
            "action": "drop",
            "name": "old_column"
        }
    ],
    "indexes": [
        {
            "action": "add",
            "name": "idx_new_column",
            "type": "BTREE",
            "columns": ["new_column"]
        }
    ]
}
```

**Risposta di Successo (200):**
```json
{
    "data": {
        "table_name": "modified_table",
        "status": "updated",
        "operation_id": 124,
        "message": "Table modified successfully"
    }
}
```

#### Elimina Tabella

```http
DELETE /api/dbforge/tables/{table_name}
```

**Parametri Path:**
- `table_name` (string, required): Nome della tabella

**Parametri Query:**
- `force` (boolean, opzionale): Forza eliminazione anche se ci sono dati (default: false)

**Risposta di Successo (200):**
```json
{
    "data": {
        "table_name": "deleted_table",
        "status": "deleted",
        "operation_id": 125,
        "message": "Table deleted successfully"
    }
}
```

### Migration Operations

#### Lista Migrazioni

```http
GET /api/dbforge/migrations
```

**Parametri Query:**
- `status` (string, opzionale): Filtra per status (pending, running, completed, failed, rolled_back)
- `batch` (integer, opzionale): Filtra per batch
- `per_page` (integer, opzionale): Numero di risultati per pagina (default: 15)
- `page` (integer, opzionale): Numero di pagina (default: 1)

**Risposta di Successo (200):**
```json
{
    "data": [
        {
            "id": 1,
            "migration_name": "create_users_table",
            "migration_file": "2024_01_15_103000_create_users_table.php",
            "batch": 1,
            "status": "completed",
            "execution_time": 150,
            "created_by": 1,
            "created_at": "2024-01-15T10:30:00Z",
            "executed_at": "2024-01-15T10:30:05Z"
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 3,
        "per_page": 15,
        "total": 45
    }
}
```

#### Esegui Migrazione

```http
POST /api/dbforge/migrations
```

**Body:**
```json
{
    "migration_name": "create_custom_table",
    "migration_file": "2024_01_15_110000_create_custom_table.php",
    "batch": 2,
    "migration_content": "<?php\n\nuse Illuminate\\Database\\Migrations\\Migration;\nuse Illuminate\\Database\\Schema\\Blueprint;\nuse Illuminate\\Support\\Facades\\Schema;\n\nclass CreateCustomTable extends Migration\n{\n    public function up()\n    {\n        Schema::create('custom_table', function (Blueprint $table) {\n            $table->id();\n            $table->string('name');\n            $table->timestamps();\n        });\n    }\n\n    public function down()\n    {\n        Schema::dropIfExists('custom_table');\n    }\n}"
}
```

**Risposta di Successo (201):**
```json
{
    "data": {
        "migration_name": "create_custom_table",
        "status": "completed",
        "operation_id": 126,
        "execution_time": 200,
        "message": "Migration executed successfully"
    }
}
```

#### Rollback Migrazione

```http
DELETE /api/dbforge/migrations/{migration_id}
```

**Parametri Path:**
- `migration_id` (integer, required): ID della migrazione

**Risposta di Successo (200):**
```json
{
    "data": {
        "migration_name": "create_custom_table",
        "status": "rolled_back",
        "operation_id": 127,
        "message": "Migration rolled back successfully"
    }
}
```

### Query Operations

#### Esegui Query Personalizzata

```http
POST /api/dbforge/query
```

**Body:**
```json
{
    "query": "SELECT * FROM users WHERE created_at > ?",
    "parameters": ["2024-01-01"],
    "timeout": 30
}
```

**Risposta di Successo (200):**
```json
{
    "data": {
        "query": "SELECT * FROM users WHERE created_at > ?",
        "parameters": ["2024-01-01"],
        "result": [
            {
                "id": 1,
                "name": "John Doe",
                "email": "john@example.com",
                "created_at": "2024-01-15T10:30:00Z"
            }
        ],
        "execution_time": 0.015,
        "rows_affected": 1
    }
}
```

#### Log delle Query

```http
GET /api/dbforge/query/log
```

**Parametri Query:**
- `user_id` (integer, opzionale): Filtra per utente
- `min_time` (decimal, opzionale): Query con tempo minimo di esecuzione
- `date_from` (date, opzionale): Data inizio filtro
- `date_to` (date, opzionale): Data fine filtro
- `per_page` (integer, opzionale): Numero di risultati per pagina (default: 15)
- `page` (integer, opzionale): Numero di pagina (default: 1)

**Risposta di Successo (200):**
```json
{
    "data": [
        {
            "id": 1,
            "query_sql": "SELECT * FROM users WHERE email = ?",
            "query_time": 0.025,
            "rows_affected": 1,
            "user_id": 1,
            "ip_address": "192.168.1.100",
            "user_agent": "Mozilla/5.0...",
            "created_at": "2024-01-15T10:30:00Z"
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 10,
        "per_page": 15,
        "total": 150
    }
}
```

### Backup Operations

#### Lista Backup

```http
GET /api/dbforge/backups
```

**Parametri Query:**
- `type` (string, opzionale): Filtra per tipo (full, incremental, selective)
- `status` (string, opzionale): Filtra per status (pending, running, completed, failed)
- `per_page` (integer, opzionale): Numero di risultati per pagina (default: 15)
- `page` (integer, opzionale): Numero di pagina (default: 1)

**Risposta di Successo (200):**
```json
{
    "data": [
        {
            "id": 1,
            "backup_name": "backup_2024_01_15_120000",
            "backup_path": "/storage/backups/backup_2024_01_15_120000.sql",
            "backup_size": 10485760,
            "backup_type": "full",
            "status": "completed",
            "retention_days": 30,
            "created_by": 1,
            "created_at": "2024-01-15T12:00:00Z",
            "completed_at": "2024-01-15T12:05:00Z"
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 2,
        "per_page": 15,
        "total": 25
    }
}
```

#### Crea Backup

```http
POST /api/dbforge/backups
```

**Body:**
```json
{
    "backup_name": "manual_backup_2024_01_15",
    "backup_type": "full",
    "retention_days": 30,
    "include_data": true,
    "include_structure": true
}
```

**Risposta di Successo (201):**
```json
{
    "data": {
        "backup_name": "manual_backup_2024_01_15",
        "status": "pending",
        "operation_id": 128,
        "message": "Backup started successfully"
    }
}
```

#### Download Backup

```http
GET /api/dbforge/backups/{backup_id}/download
```

**Parametri Path:**
- `backup_id` (integer, required): ID del backup

**Risposta di Successo (200):**
```
Content-Type: application/octet-stream
Content-Disposition: attachment; filename="backup_2024_01_15_120000.sql"

[Contenuto del file di backup]
```

#### Elimina Backup

```http
DELETE /api/dbforge/backups/{backup_id}
```

**Parametri Path:**
- `backup_id` (integer, required): ID del backup

**Risposta di Successo (200):**
```json
{
    "data": {
        "backup_name": "deleted_backup",
        "status": "deleted",
        "operation_id": 129,
        "message": "Backup deleted successfully"
    }
}
```

## Errori

### Errori Comuni

#### 400 Bad Request
```json
{
    "error": "Validation failed",
    "message": "The given data was invalid.",
    "errors": {
        "table_name": ["The table name field is required."],
        "columns": ["At least one column is required."]
    }
}
```

#### 401 Unauthorized
```json
{
    "error": "Unauthenticated",
    "message": "User not authenticated"
}
```

#### 403 Forbidden
```json
{
    "error": "Insufficient permissions",
    "message": "User does not have permission to perform this operation"
}
```

#### 404 Not Found
```json
{
    "error": "Resource not found",
    "message": "Table 'non_existent_table' not found"
}
```

#### 422 Unprocessable Entity
```json
{
    "error": "Operation failed",
    "message": "Cannot drop table 'users' - foreign key constraint exists",
    "details": {
        "constraint": "fk_posts_user_id",
        "referenced_table": "posts"
    }
}
```

#### 500 Internal Server Error
```json
{
    "error": "Database operation failed",
    "message": "Connection timeout",
    "details": {
        "operation": "create_table",
        "table_name": "new_table"
    }
}
```

## Rate Limiting

L'API implementa rate limiting per proteggere il sistema:

- **Operazioni di Lettura**: 1000 richieste per minuto per utente
- **Operazioni di Scrittura**: 100 richieste per minuto per utente
- **Operazioni Critiche**: 10 richieste per minuto per utente

### Headers di Rate Limiting

```
X-RateLimit-Limit: 1000
X-RateLimit-Remaining: 999
X-RateLimit-Reset: 1642248600
```

## Paginazione

Tutti gli endpoint che restituiscono liste supportano paginazione:

### Parametri di Paginazione

- `page`: Numero di pagina (default: 1)
- `per_page`: Elementi per pagina (default: 15, max: 100)

### Risposta Paginata

```json
{
    "data": [...],
    "meta": {
        "current_page": 1,
        "last_page": 5,
        "per_page": 15,
        "total": 75,
        "from": 1,
        "to": 15
    },
    "links": {
        "first": "https://api.example.com/dbforge/tables?page=1",
        "last": "https://api.example.com/dbforge/tables?page=5",
        "prev": null,
        "next": "https://api.example.com/dbforge/tables?page=2"
    }
}
```

## Filtri e Ricerca

### Filtri Supportati

- **Ricerca Testuale**: `search` - Ricerca nel nome della tabella
- **Filtri di Stato**: `status` - Filtra per stato dell'operazione
- **Filtri Temporali**: `date_from`, `date_to` - Filtra per intervallo di date
- **Filtri Numerici**: `min_time`, `max_time` - Filtra per valori numerici

### Esempi di Filtri

```http
GET /api/dbforge/tables?search=user&per_page=10
GET /api/dbforge/migrations?status=completed&date_from=2024-01-01
GET /api/dbforge/query/log?min_time=1.0&user_id=1
```

## Ordinamento

### Parametri di Ordinamento

- `sort_by`: Campo per ordinamento (default: created_at)
- `sort_order`: Direzione ordinamento (asc, desc, default: desc)

### Esempi di Ordinamento

```http
GET /api/dbforge/tables?sort_by=name&sort_order=asc
GET /api/dbforge/migrations?sort_by=execution_time&sort_order=desc
```

## Webhooks

Il modulo supporta webhooks per notificare eventi importanti:

### Eventi Supportati

- `table.created`: Tabella creata
- `table.updated`: Tabella modificata
- `table.deleted`: Tabella eliminata
- `migration.completed`: Migrazione completata
- `migration.failed`: Migrazione fallita
- `backup.completed`: Backup completato
- `backup.failed`: Backup fallito

### Configurazione Webhook

```json
{
    "webhook_url": "https://example.com/webhook",
    "events": ["table.created", "migration.completed"],
    "secret": "webhook_secret_key"
}
```

## SDK e Client Libraries

### PHP Client

```php
use Modules\DbForge\Client\DbForgeClient;

$client = new DbForgeClient('https://api.example.com', 'your-api-token');

// Lista tabelle
$tables = $client->tables()->list();

// Crea tabella
$result = $client->tables()->create([
    'table_name' => 'new_table',
    'columns' => [...]
]);
```

### JavaScript Client

```javascript
import { DbForgeClient } from '@laraxot/dbforge-client';

const client = new DbForgeClient('https://api.example.com', 'your-api-token');

// Lista tabelle
const tables = await client.tables.list();

// Crea tabella
const result = await client.tables.create({
    table_name: 'new_table',
    columns: [...]
});
```

## Supporto e Contatti

Per supporto tecnico o domande sull'API:

- **Documentazione**: `/docs/api`
- **Supporto**: support@example.com
- **Issues**: GitHub Issues
- **Chat**: Discord/Slack

## Changelog

### v1.0.0 (2024-01-15)
- Prima release dell'API
- Supporto per operazioni base su tabelle
- Supporto per migrazioni personalizzate
- Supporto per backup e restore
- Sistema di logging delle query 