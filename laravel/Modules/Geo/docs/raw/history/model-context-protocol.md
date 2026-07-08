# Model Context Protocol (MCP) Implementation Guide

## Overview
Model Context Protocol (MCP) is a powerful pattern for managing model context and interactions across different services. This guide explains how to implement MCP in Cursor, WindSurf, and Trae, with practical examples in PHP.

## Table of Contents
1. [Basic MCP Structure](#basic-mcp-structure)
2. [Implementation in PHP](#implementation-in-php)
3. [Database Integration](#database-integration)
4. [Service Integration](#service-integration)
5. [Advanced Features](#advanced-features)

## Basic MCP Structure

### Core Components
```php
namespace App\MCP;

interface ModelContextInterface
{
    public function getContext(): array;
    public function setContext(array $context): void;
    public function withContext(array $context): self;
}

trait ModelContextTrait
{
    protected array $context = [];

    public function getContext(): array
    {
        return $this->context;
    }

    public function setContext(array $context): void
    {
        $this->context = $context;
    }

    public function withContext(array $context): self
    {
        $clone = clone $this;
        $clone->setContext($context);
        return $clone;
    }
}
```

## Implementation in PHP

### 1. Model Implementation
```php
namespace App\Models;

use App\MCP\ModelContextInterface;
use App\MCP\ModelContextTrait;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements ModelContextInterface
{
    use ModelContextTrait;

    protected $fillable = ['name', 'email'];

    public function scopeWithUserContext($query, array $context)
    {
        return $query->where('context->user_id', $context['user_id'] ?? null);
    }

    public function getContextualData()
    {
        return [
            'user' => $this->toArray(),
            'context' => $this->getContext(),
            'permissions' => $this->context['permissions'] ?? [],
        ];
    }
}
```

### 2. Service Layer Integration
```php
namespace App\Services;

class UserService
{
    public function getUserWithContext(int $userId, array $context)
    {
        return User::query()
            ->withUserContext($context)
            ->find($userId)
            ->withContext($context);
    }

    public function updateUserWithContext(User $user, array $data)
    {
        $context = $user->getContext();
        
        if (!$this->hasPermission($context, 'update_user')) {
            throw new UnauthorizedException();
        }

        $user->update($data);
        return $user->fresh()->withContext($context);
    }

    protected function hasPermission(array $context, string $permission): bool
    {
        return in_array($permission, $context['permissions'] ?? []);
    }
}
```

## Database Integration

### 1. MySQL Query Builder with MCP
```php
namespace App\MCP\Database;

class MCPQueryBuilder
{
    protected $context;
    protected $connection;

    public function __construct($connection, array $context = [])
    {
        $this->connection = $connection;
        $this->context = $context;
    }

    public function select(string $table, array $columns = ['*'])
    {
        $query = $this->connection->table($table)->select($columns);
        
        // Apply context filters
        if (isset($this->context['tenant_id'])) {
            $query->where('tenant_id', $this->context['tenant_id']);
        }

        if (isset($this->context['user_id'])) {
            $query->where(function($q) {
                $q->where('user_id', $this->context['user_id'])
                  ->orWhereJsonContains('shared_with', $this->context['user_id']);
            });
        }

        return $query;
    }

    public function insert(string $table, array $data)
    {
        // Automatically inject context data
        $data = array_merge($data, [
            'tenant_id' => $this->context['tenant_id'] ?? null,
            'created_by' => $this->context['user_id'] ?? null,
        ]);

        return $this->connection->table($table)->insert($data);
    }
}
```

### 2. Usage Example
```php
$context = [
    'tenant_id' => 1,
    'user_id' => 123,
    'permissions' => ['read', 'write'],
];

$queryBuilder = new MCPQueryBuilder($db, $context);

// Automatically applies tenant and user context
$users = $queryBuilder->select('users')
    ->where('status', 'active')
    ->get();
```

## Service Integration

### 1. RESTful API Service with MCP
```php
namespace App\MCP\Services;

class MCPApiService
{
    protected $context;
    protected $client;

    public function __construct(array $context = [])
    {
        $this->context = $context;
        $this->client = new \GuzzleHttp\Client([
            'headers' => $this->getContextHeaders(),
        ]);
    }

    protected function getContextHeaders(): array
    {
        return [
            'X-Tenant-ID' => $this->context['tenant_id'] ?? null,
            'X-User-ID' => $this->context['user_id'] ?? null,
            'Authorization' => $this->context['token'] ?? null,
        ];
    }

    public function request(string $method, string $url, array $options = [])
    {
        // Inject context into request
        $options['query'] = array_merge(
            $options['query'] ?? [],
            ['context' => json_encode($this->context)]
        );

        return $this->client->request($method, $url, $options);
    }
}
```

### 2. Cache Service with MCP
```php
namespace App\MCP\Services;

class MCPCacheService
{
    protected $context;
    protected $cache;

    public function __construct($cache, array $context = [])
    {
        $this->cache = $cache;
        $this->context = $context;
    }

    public function get(string $key)
    {
        $contextKey = $this->getContextualKey($key);
        return $this->cache->get($contextKey);
    }

    public function set(string $key, $value, $ttl = null)
    {
        $contextKey = $this->getContextualKey($key);
        return $this->cache->set($contextKey, $value, $ttl);
    }

    protected function getContextualKey(string $key): string
    {
        $contextHash = md5(json_encode([
            'tenant' => $this->context['tenant_id'] ?? null,
            'user' => $this->context['user_id'] ?? null,
        ]));

        return "{$contextHash}:{$key}";
    }
}
```

## Advanced Features

### 1. Context Propagation
```php
namespace App\MCP\Events;

class MCPEventDispatcher
{
    protected $context;
    protected $dispatcher;

    public function __construct($dispatcher, array $context = [])
    {
        $this->dispatcher = $dispatcher;
        $this->context = $context;
    }

    public function dispatch($event)
    {
        // Inject context into event
        if (method_exists($event, 'withContext')) {
            $event = $event->withContext($this->context);
        }

        return $this->dispatcher->dispatch($event);
    }
}
```

### 2. Middleware Integration
```php
namespace App\MCP\Middleware;

class MCPContextMiddleware
{
    public function handle($request, $next)
    {
        $context = [
            'tenant_id' => $request->header('X-Tenant-ID'),
            'user_id' => auth()->id(),
            'permissions' => auth()->user()->permissions ?? [],
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ];

        // Attach context to request
        $request->merge(['mcp_context' => $context]);

        return $next($request);
    }
}
```

## Benefits of MCP

1. **Consistent Context Management**
   - Automatic tenant isolation
   - User-specific data access
   - Permission-based filtering

2. **Improved Security**
   - Automatic context validation
   - Consistent access control
   - Data isolation

3. **Better Maintainability**
   - Centralized context management
   - Reusable context logic
   - Clear separation of concerns

4. **Enhanced Scalability**
   - Easy to add new context parameters
   - Consistent across services
   - Simplified microservices integration

## Best Practices

1. Always validate context before use
2. Use immutable context objects when possible
3. Include relevant metadata in context
4. Document context requirements
5. Implement context propagation
6. Use context in logging and monitoring
7. Regular context security audits

## Integration Examples

### 1. Laravel Integration
```php
// config/mcp.php
return [
    'context_providers' => [
        App\MCP\Providers\TenantContextProvider::class,
        App\MCP\Providers\UserContextProvider::class,
    ],
];
```

### 2. Cursor Integration
```php
// .cursor/mcp.json
{
    "contextProviders": [
        "tenant",
        "user",
        "permissions"
    ],
    "contextValidation": true,
    "contextPropagation": true
}
```

### 3. WindSurf Integration
```php
// windsurf.config.js
module.exports = {
    mcp: {
        enabled: true,
        providers: ['tenant', 'user'],
        validation: true,
        propagation: true
    }
};
```

### 4. Trae Integration
```php
// trae.config.php
return [
    'mcp' => [
        'enabled' => true,
        'providers' => [
            \App\MCP\Providers\TenantProvider::class,
            \App\MCP\Providers\UserProvider::class,
        ],
        'validation' => true,
        'propagation' => true,
    ],
];
```
