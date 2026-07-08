# API Reference dei Server MCP

## Panoramica

Questa documentazione fornisce una reference completa delle API esposte dai server MCP (Model Context Protocol) utilizzati nei progetti Laravel, seguendo le regole di sviluppo e le convenzioni di codice stabilite per i progetti base_predict_fila5_mono.

## Server Sequential Thinking

### Endpoint: `/api/v1/sequential-thinking`

#### Metodo: `POST`

#### Parametri di Richiesta

| Nome | Tipo | Descrizione | Obbligatorio |
|------|------|-------------|--------------|
| `thought` | `string` | Il pensiero corrente | Sì |
| `thoughtNumber` | `int` | Il numero del pensiero nella sequenza | Sì |
| `totalThoughts` | `int` | Il numero totale di pensieri stimati | Sì |
| `nextThoughtNeeded` | `bool` | Se è necessario un altro pensiero | Sì |
| `isRevision` | `bool` | Se questo pensiero rivede un pensiero precedente | No |
| `revisesThought` | `int` | Quale pensiero viene riconsiderato | No |
| `branchFromThought` | `int` | Punto di diramazione del pensiero | No |
| `branchId` | `string` | Identificatore del ramo corrente | No |
| `needsMoreThoughts` | `bool` | Se sono necessari più pensieri | No |

#### Risposta

```json
{
  "thought": "string",
  "thoughtNumber": 2,
  "totalThoughts": 5,
  "nextThoughtNeeded": true,
  "isRevision": false,
  "revisesThought": null,
  "branchFromThought": null,
  "branchId": null,
  "needsMoreThoughts": false
}
```

#### Esempio di Utilizzo

```php
$response = Http::post('http://localhost:3000/api/v1/sequential-thinking', [
    'thought' => 'Analisi del problema di performance nel database',
    'thoughtNumber' => 1,
    'totalThoughts' => 5,
    'nextThoughtNeeded' => true
]);

$result = $response->json();
```

### Endpoint: `/api/v1/analyze`

#### Metodo: `POST`

#### Parametri di Richiesta

| Nome | Tipo | Descrizione | Obbligatorio |
|------|------|-------------|--------------|
| `text` | `string` | Il testo da analizzare | Sì |
| `aspects` | `array<string>` | Gli aspetti da analizzare | Sì |

#### Risposta

```json
{
  "readability": {
    "score": 85,
    "level": "advanced"
  },
  "seo": {
    "score": 78,
    "suggestions": [
      "Aggiungere più parole chiave",
      "Migliorare i meta tag"
    ]
  },
  "sentiment": {
    "value": "positive",
    "score": 0.75
  },
  "keywords": [
    "performance",
    "database",
    "ottimizzazione"
  ]
}
```

#### Esempio di Utilizzo

```php
$response = Http::post('http://localhost:3000/api/v1/analyze', [
    'text' => 'Questo è un testo di esempio per l\'analisi',
    'aspects' => ['readability', 'seo', 'sentiment', 'keywords']
]);

$result = $response->json();
```

## Server Memory

### Endpoint: `/api/v1/store`

#### Metodo: `POST`

#### Parametri di Richiesta

| Nome | Tipo | Descrizione | Obbligatorio |
|------|------|-------------|--------------|
| `key` | `string` | La chiave dell'informazione | Sì |
| `value` | `mixed` | Il valore dell'informazione | Sì |
| `ttl` | `int` | Tempo di vita in secondi | No |

#### Risposta

```json
{
  "success": true
}
```

#### Esempio di Utilizzo

```php
$response = Http::post('http://localhost:3001/api/v1/store', [
    'key' => 'user_preferences_123',
    'value' => [
        'theme' => 'dark',
        'language' => 'it',
        'notifications' => true
    ],
    'ttl' => 3600
]);

$success = $response->json('success');
```

### Endpoint: `/api/v1/retrieve`

#### Metodo: `GET`

#### Parametri di Richiesta

| Nome | Tipo | Descrizione | Obbligatorio |
|------|------|-------------|--------------|
| `key` | `string` | La chiave dell'informazione | Sì |

#### Risposta

```json
{
  "value": {
    "theme": "dark",
    "language": "it",
    "notifications": true
  }
}
```

#### Esempio di Utilizzo

```php
$response = Http::get('http://localhost:3001/api/v1/retrieve', [
    'key' => 'user_preferences_123'
]);

$value = $response->json('value');
```

### Endpoint: `/api/v1/delete`

#### Metodo: `DELETE`

#### Parametri di Richiesta

| Nome | Tipo | Descrizione | Obbligatorio |
|------|------|-------------|--------------|
| `key` | `string` | La chiave dell'informazione | Sì |

#### Risposta

```json
{
  "success": true
}
```

#### Esempio di Utilizzo

```php
$response = Http::delete('http://localhost:3001/api/v1/delete', [
    'key' => 'user_preferences_123'
]);

$success = $response->json('success');
```

## Server Fetch

### Endpoint: `/api/v1/get`

#### Metodo: `POST`

#### Parametri di Richiesta

| Nome | Tipo | Descrizione | Obbligatorio |
|------|------|-------------|--------------|
| `url` | `string` | L'URL della richiesta | Sì |
| `headers` | `object` | Le intestazioni della richiesta | No |
| `timeout` | `int` | Timeout in secondi | No |

#### Risposta

```json
{
  "status": 200,
  "headers": {
    "content-type": "application/json"
  },
  "body": "..."
}
```

#### Esempio di Utilizzo

```php
$response = Http::post('http://localhost:3002/api/v1/get', [
    'url' => 'https://api.example.com/data',
    'headers' => [
        'Authorization' => 'Bearer token123',
        'Accept' => 'application/json'
    ],
    'timeout' => 30
]);

$result = $response->json();
```

### Endpoint: `/api/v1/post`

#### Metodo: `POST`

#### Parametri di Richiesta

| Nome | Tipo | Descrizione | Obbligatorio |
|------|------|-------------|--------------|
| `url` | `string` | L'URL della richiesta | Sì |
| `body` | `mixed` | Il corpo della richiesta | No |
| `headers` | `object` | Le intestazioni della richiesta | No |
| `timeout` | `int` | Timeout in secondi | No |

#### Risposta

```json
{
  "status": 201,
  "headers": {
    "content-type": "application/json"
  },
  "body": "..."
}
```

#### Esempio di Utilizzo

```php
$response = Http::post('http://localhost:3002/api/v1/post', [
    'url' => 'https://api.example.com/data',
    'body' => [
        'name' => 'John Doe',
        'email' => 'john@example.com'
    ],
    'headers' => [
        'Authorization' => 'Bearer token123',
        'Content-Type' => 'application/json'
    ],
    'timeout' => 30
]);

$result = $response->json();
```

## Server Filesystem

### Endpoint: `/api/v1/read`

#### Metodo: `GET`

#### Parametri di Richiesta

| Nome | Tipo | Descrizione | Obbligatorio |
|------|------|-------------|--------------|
| `path` | `string` | Il percorso del file | Sì |

#### Risposta

```json
{
  "content": "Contenuto del file..."
}
```

#### Esempio di Utilizzo

```php
$response = Http::get('http://localhost:3003/api/v1/read', [
    'path' => '/path/to/file.txt'
]);

$content = $response->json('content');
```

### Endpoint: `/api/v1/write`

#### Metodo: `POST`

#### Parametri di Richiesta

| Nome | Tipo | Descrizione | Obbligatorio |
|------|------|-------------|--------------|
| `path` | `string` | Il percorso del file | Sì |
| `content` | `string` | Il contenuto da scrivere | Sì |

#### Risposta

```json
{
  "success": true
}
```

#### Esempio di Utilizzo

```php
$response = Http::post('http://localhost:3003/api/v1/write', [
    'path' => '/path/to/file.txt',
    'content' => 'Nuovo contenuto del file'
]);

$success = $response->json('success');
```

### Endpoint: `/api/v1/list`

#### Metodo: `GET`

#### Parametri di Richiesta

| Nome | Tipo | Descrizione | Obbligatorio |
|------|------|-------------|--------------|
| `path` | `string` | Il percorso della directory | Sì |

#### Risposta

```json
{
  "files": [
    {
      "name": "file1.txt",
      "type": "file",
      "size": 1024
    },
    {
      "name": "dir1",
      "type": "directory",
      "children": 5
    }
  ]
}
```

#### Esempio di Utilizzo

```php
$response = Http::get('http://localhost:3003/api/v1/list', [
    'path' => '/path/to/directory'
]);

$files = $response->json('files');
```

## Server MySQL

### Endpoint: `/api/v1/query`

#### Metodo: `POST`

#### Parametri di Richiesta

| Nome | Tipo | Descrizione | Obbligatorio |
|------|------|-------------|--------------|
| `query` | `string` | La query SQL | Sì |
| `params` | `array` | I parametri della query | No |

#### Risposta

```json
{
  "results": [
    {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com"
    },
    {
      "id": 2,
      "name": "Jane Smith",
      "email": "jane@example.com"
    }
  ],
  "affectedRows": 2
}
```

#### Esempio di Utilizzo

```php
$response = Http::post('http://localhost:3007/api/v1/query', [
    'query' => 'SELECT * FROM users WHERE id = ?',
    'params' => [1]
]);

$results = $response->json('results');
```

### Endpoint: `/api/v1/table-structure`

#### Metodo: `GET`

#### Parametri di Richiesta

| Nome | Tipo | Descrizione | Obbligatorio |
|------|------|-------------|--------------|
| `table` | `string` | Il nome della tabella | Sì |

#### Risposta

```json
{
  "structure": [
    {
      "Field": "id",
      "Type": "int(11)",
      "Null": "NO",
      "Key": "PRI",
      "Default": null,
      "Extra": "auto_increment"
    },
    {
      "Field": "name",
      "Type": "varchar(255)",
      "Null": "NO",
      "Key": "",
      "Default": null,
      "Extra": ""
    },
    {
      "Field": "email",
      "Type": "varchar(255)",
      "Null": "NO",
      "Key": "UNI",
      "Default": null,
      "Extra": ""
    }
  ]
}
```

#### Esempio di Utilizzo

```php
$response = Http::get('http://localhost:3007/api/v1/table-structure', [
    'table' => 'users'
]);

$structure = $response->json('structure');
```

### Endpoint: `/api/v1/tables`

#### Metodo: `GET`

#### Parametri di Richiesta

Nessun parametro richiesto.

#### Risposta

```json
{
  "tables": [
    "users",
    "posts",
    "comments"
  ]
}
```

#### Esempio di Utilizzo

```php
$response = Http::get('http://localhost:3007/api/v1/tables');

$tables = $response->json('tables');
```

## Server Redis

### Endpoint: `/api/v1/set`

#### Metodo: `POST`

#### Parametri di Richiesta

| Nome | Tipo | Descrizione | Obbligatorio |
|------|------|-------------|--------------|
| `key` | `string` | La chiave del valore | Sì |
| `value` | `mixed` | Il valore da memorizzare | Sì |
| `ttl` | `int` | Tempo di vita in secondi | No |

#### Risposta

```json
{
  "success": true
}
```

#### Esempio di Utilizzo

```php
$response = Http::post('http://localhost:3004/api/v1/set', [
    'key' => 'cache_key',
    'value' => [
        'data' => 'cached data'
    ],
    'ttl' => 3600
]);

$success = $response->json('success');
```

### Endpoint: `/api/v1/get`

#### Metodo: `GET`

#### Parametri di Richiesta

| Nome | Tipo | Descrizione | Obbligatorio |
|------|------|-------------|--------------|
| `key` | `string` | La chiave del valore | Sì |

#### Risposta

```json
{
  "value": {
    "data": "cached data"
  }
}
```

#### Esempio di Utilizzo

```php
$response = Http::get('http://localhost:3004/api/v1/get', [
    'key' => 'cache_key'
]);

$value = $response->json('value');
```

### Endpoint: `/api/v1/delete`

#### Metodo: `DELETE`

#### Parametri di Richiesta

| Nome | Tipo | Descrizione | Obbligatorio |
|------|------|-------------|--------------|
| `key` | `string` | La chiave del valore | Sì |

#### Risposta

```json
{
  "success": true
}
```

#### Esempio di Utilizzo

```php
$response = Http::delete('http://localhost:3004/api/v1/delete', [
    'key' => 'cache_key'
]);

$success = $response->json('success');
```

## Server Puppeteer

### Endpoint: `/api/v1/screenshot`

#### Metodo: `POST`

#### Parametri di Richiesta

| Nome | Tipo | Descrizione | Obbligatorio |
|------|------|-------------|--------------|
| `url` | `string` | L'URL della pagina | Sì |
| `outputPath` | `string` | Il percorso di output | Sì |
| `options` | `object` | Opzioni per lo screenshot | No |

#### Risposta

```json
{
  "screenshotPath": "/path/to/screenshot.png"
}
```

#### Esempio di Utilizzo

```php
$response = Http::post('http://localhost:3006/api/v1/screenshot', [
    'url' => 'https://example.com',
    'outputPath' => '/path/to/screenshot.png',
    'options' => [
        'fullPage' => true,
        'type' => 'png'
    ]
]);

$screenshotPath = $response->json('screenshotPath');
```

### Endpoint: `/api/v1/extract`

#### Metodo: `POST`

#### Parametri di Richiesta

| Nome | Tipo | Descrizione | Obbligatorio |
|------|------|-------------|--------------|
| `url` | `string` | L'URL della pagina | Sì |
| `selector` | `string` | Il selettore CSS | Sì |

#### Risposta

```json
{
  "content": "Contenuto estratto dalla pagina..."
}
```

#### Esempio di Utilizzo

```php
$response = Http::post('http://localhost:3006/api/v1/extract', [
    'url' => 'https://example.com',
    'selector' => '.main-content'
]);

$content = $response->json('content');
```

## Server Postgres

### Endpoint: `/api/v1/query`

#### Metodo: `POST`

#### Parametri di Richiesta

| Nome | Tipo | Descrizione | Obbligatorio |
|------|------|-------------|--------------|
| `query` | `string` | La query SQL | Sì |
| `params` | `array` | I parametri della query | No |

#### Risposta

```json
{
  "results": [
    {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com"
    },
    {
      "id": 2,
      "name": "Jane Smith",
      "email": "jane@example.com"
    }
  ],
  "rowCount": 2
}
```

#### Esempio di Utilizzo

```php
$response = Http::post('http://localhost:3005/api/v1/query', [
    'query' => 'SELECT * FROM users WHERE id = $1',
    'params' => [1]
]);

$results = $response->json('results');
```

### Endpoint: `/api/v1/analyze-query`

#### Metodo: `POST`

#### Parametri di Richiesta

| Nome | Tipo | Descrizione | Obbligatorio |
|------|------|-------------|--------------|
| `query` | `string` | La query SQL | Sì |
| `params` | `array` | I parametri della query | No |

#### Risposta

```json
{
  "plan": {
    "Node Type": "Seq Scan",
    "Relation Name": "users",
    "Alias": "users",
    "Startup Cost": 0.00,
    "Total Cost": 10.70,
    "Plan Rows": 70,
    "Plan Width": 266
  },
  "optimized_query": "SELECT * FROM users WHERE id = $1",
  "estimated_cost": 10.70,
  "recommendations": [
    "Aggiungere un indice sulla colonna id"
  ]
}
```

#### Esempio di Utilizzo

```php
$response = Http::post('http://localhost:3005/api/v1/analyze-query', [
    'query' => 'SELECT * FROM users WHERE id = $1',
    'params' => [1]
]);

$analysis = $response->json();
```

## Endpoint Health Check

Tutti i server MCP espongono un endpoint di health check per verificare lo stato del server.

### Endpoint: `/api/v1/health`

#### Metodo: `GET`

#### Parametri di Richiesta

Nessun parametro richiesto.

#### Risposta

```json
{
  "status": "ok",
  "version": "1.0.0",
  "uptime": 3600
}
```

#### Esempio di Utilizzo

```php
$response = Http::get('http://localhost:3000/api/v1/health');

$status = $response->json('status');
```

## Conclusione

Questa documentazione fornisce una reference completa delle API esposte dai server MCP utilizzati nei progetti Laravel. Per ulteriori informazioni e supporto, consultare la documentazione ufficiale dei server MCP o contattare il team di sviluppo.
