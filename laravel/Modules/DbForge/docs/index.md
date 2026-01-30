# DbForge Module Documentation

## Overview
The DbForge module provides advanced database management and schema manipulation tools for the Laraxot system. It offers a comprehensive interface for database operations, migrations, and schema management with enhanced capabilities beyond Laravel's built-in tools.

## Key Features
- **Database Management**: Create, modify, and delete databases
- **Schema Builder**: Visual and code-based schema creation
- **Migration Tools**: Advanced migration generation and management
- **Query Builder**: Enhanced query building capabilities
- **Performance Monitoring**: Database performance analysis and optimization
- **Backup/Restore**: Database backup and restoration tools

## Architecture
The module follows the Laraxot architecture principles:
- Extends Xot base classes
- Uses Filament for admin interface
- Implements proper service providers
- Follows DRY/KISS principles

## Core Components

### Models
- `DatabaseSchema` - Database schema representation
- `MigrationRecord` - Migration tracking and management
- `TableInfo` - Table structure information
- `ColumnInfo` - Column structure information

### Resources
- `DatabaseResource` - Database management interface
- `MigrationResource` - Migration management resource
- `TableResource` - Table management interface
- `SchemaResource` - Schema management resource

### Services
- `DbForgeService` - Core database operations
- `SchemaBuilder` - Database schema building
- `MigrationGenerator` - Migration code generation
- `QueryBuilder` - Enhanced query building
- `PerformanceAnalyzer` - Database performance analysis

## Implementation Guide

### Basic Usage
```php
// Database operations
$dbForgeService = app(DbForgeService::class);

// Create a database
$dbForgeService->createDatabase('new_database');

// Get table information
$tableInfo = $dbForgeService->getTableInfo('users');

// Generate migration
$migrationCode = $dbForgeService->generateMigration('create_posts_table');
```

### Schema Operations
```php
// Using the schema builder
$schemaBuilder = app(SchemaBuilder::class);

// Create a table
$schemaBuilder->createTable('posts', [
    'id' => ['type' => 'integer', 'primary' => true, 'autoIncrement' => true],
    'title' => ['type' => 'string', 'length' => 255, 'nullable' => false],
    'content' => ['type' => 'text', 'nullable' => true],
    'created_at' => ['type' => 'timestamp', 'nullable' => true],
]);
```

## Database Support
- **MySQL**: Full support with advanced features
- **PostgreSQL**: Advanced PostgreSQL features
- **SQLite**: Lightweight database support
- **SQL Server**: Microsoft SQL Server integration
- **MongoDB**: NoSQL database support

## Advanced Features

### Query Builder Extensions
- **Join Operations**: Complex join operations with multiple tables
- **Aggregation Functions**: COUNT, SUM, AVG, MAX, MIN operations
- **Subqueries**: Nested query support
- **Raw Expressions**: Custom SQL expressions

### Migration Management
- **Rollback Operations**: Safe rollback of migrations
- **Dependency Tracking**: Migration dependency management
- **Batch Processing**: Process multiple migrations together
- **Dry Run**: Test migrations without executing

### Performance Tools
- **Query Analysis**: Analyze query performance and execution plans
- **Index Optimization**: Suggest and create optimal indexes
- **Database Profiling**: Monitor database performance metrics
- **Slow Query Detection**: Identify and optimize slow queries

## Security Considerations
1. **SQL Injection Prevention**: All queries properly sanitized
2. **Access Control**: Role-based access to database operations
3. **Connection Security**: Secure database connection handling
4. **Audit Logging**: Track all database modifications

## Best Practices
1. **Backup First**: Always backup before schema modifications
2. **Test Migrations**: Test migrations in development environment first
3. **Performance Testing**: Analyze performance impact of schema changes
4. **Data Validation**: Validate data integrity after schema changes
5. **Documentation**: Document all database changes and migrations

## Related Modules
- [Xot Module](../Xot/docs/index.md) - Core base classes
- [User Module](../User/docs/README.md) - User authentication and management
- [Activity Module](../Activity/docs/index.md) - Activity logging

## Troubleshooting
Common issues and solutions:
- Migration conflicts and dependencies
- Database connection issues
- Schema validation errors
- Performance problems with large datasets