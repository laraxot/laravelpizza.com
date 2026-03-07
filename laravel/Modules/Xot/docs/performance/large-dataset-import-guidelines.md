# Large Dataset Import Optimization Guidelines

## Overview
This document provides guidelines for optimizing large dataset imports across the Laraxot modular architecture. Based on Chris Rumpel's research in "laravel-import-million-rows" and industry best practices, these patterns ensure efficient handling of large data volumes while maintaining system stability.

## Core Principles

### 1. Memory Management
- Process datasets in chunks to prevent memory exhaustion
- Use generators for file processing to avoid loading entire files
- Implement proper garbage collection between operations
- Monitor memory usage during operations

### 2. Performance Optimization
- Use raw database operations instead of Eloquent for bulk inserts
- Disable framework overhead during bulk operations
- Implement queue-based processing for heavy operations
- Use transactions appropriately for data consistency

### 3. Data Integrity
- Validate data before bulk operations
- Implement error handling for partial failures
- Maintain audit trails for all operations
- Use appropriate transaction boundaries

## Implementation Patterns

### Chunked Processing
```php
// Process data in chunks to manage memory
foreach (array_chunk($largeDataset, 500) as $chunk) {
    // Process chunk
    $this->processChunk($chunk);
    
    // Allow garbage collection
    unset($chunk);
    gc_collect_cycles();
}
```

### Raw Database Operations
```php
// Use raw insert for bulk operations
DB::table('table_name')->insert($data);

// Instead of Eloquent which triggers events
// Model::create($data); // Avoid for bulk operations
```

### Framework Overhead Management
```php
// Temporarily disable overhead during bulk operations
$originalDispatcher = DB::connection()->getEventDispatcher();
DB::connection()->unsetEventDispatcher();

try {
    // Bulk operations
    $this->performBulkOperation();
} finally {
    // Restore original state
    DB::connection()->setEventDispatcher($originalDispatcher);
}
```

## Module-Specific Considerations

### healthcare_app Module
- Optimize survey contact imports
- Implement JSON payload persistence
- Use queue-based processing for contact operations

### User Module  
- Optimize user bulk operations
- Consider data privacy regulations (GDPR)

### Media Module
- Optimize file bulk operations
- Consider storage limitations

### Activity Module
- Optimize activity log bulk operations
- Consider audit requirements

## Queue Integration

For large operations, use Laravel's queue system:

```php
// Break large operations into smaller jobs
$batch = Bus::batch([
    new ProcessChunkJob($chunk1),
    new ProcessChunkJob($chunk2),
    // ... more chunks
])->then(function (Batch $batch) {
    // Handle completion
})->catch(function (Batch $batch, Throwable $e) {
    // Handle failures
})->dispatch();
```

## Performance Monitoring

Implement monitoring for large operations:

```php
$start = microtime(true);
$memoryStart = memory_get_usage(true);

// Perform operation
$result = $this->performOperation($data);

$end = microtime(true);
$memoryEnd = memory_get_usage(true);

Log::info('Operation completed', [
    'duration' => $end - $start,
    'memory_used' => $memoryEnd - $memoryStart,
    'records_processed' => count($data),
    'result' => $result
]);
```

## Error Handling and Recovery

Implement robust error handling for partial failures:

```php
public function processLargeDataset(array $data): array
{
    $results = [
        'processed' => 0,
        'failed' => 0,
        'errors' => []
    ];
    
    foreach (array_chunk($data, 100) as $index => $chunk) {
        try {
            $this->processChunk($chunk);
            $results['processed'] += count($chunk);
        } catch (\Exception $e) {
            $results['failed'] += count($chunk);
            $results['errors'][] = [
                'chunk' => $index,
                'error' => $e->getMessage()
            ];
            // Continue with other chunks
        }
    }
    
    return $results;
}
```

## References

- Chris Rumpel: laravel-import-million-rows
- Laravel documentation on collections and queues
- Database-specific bulk insert documentation
- PHP memory management best practices

These guidelines should be applied consistently across all modules that handle large datasets to ensure system-wide performance and stability.