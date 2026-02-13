# Performance Guidelines - Xot Module

## 🎯 Purpose

This document provides performance guidelines for the Xot module and modules that extend it. Xot serves as the foundation for all other modules, so performance optimizations here have a cascading effect across the entire platform.

## 🚀 Database Optimization

### 1. Eager Loading Patterns
**Problem**: N+1 queries when accessing relationships
```php
// ❌ ANTI-PATTERN
public function getTableColumns(): array
{
    return [
        TextColumn::make('user.name'), // N+1 query
        TextColumn::make('user.email'), // Another N+1 query
    ];
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function getTableColumns(): array
{
    return [
        TextColumn::make('user.name'), // Uses eager loading
        TextColumn::make('user.email'), // Uses eager loading
    ];
}

// Ensure eager loading in the query
public function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()->with('user');
}
```

### 2. Query Optimization
**Problem**: Inefficient database queries
```php
// ❌ ANTI-PATTERN
public function getData(): Collection
{
    return Model::all()->filter(function ($item) {
        return $item->status === 'active';
    });
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function getData(): Collection
{
    return Model::where('status', 'active')->get();
}
```

### 3. Chunked Processing
**Problem**: Memory exhaustion with large datasets
```php
// ❌ ANTI-PATTERN
public function processAllRecords(): void
{
    $records = Model::all(); // Loads everything into memory
    foreach ($records as $record) {
        $this->processRecord($record);
    }
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function processAllRecords(): void
{
    Model::chunk(1000, function ($records) {
        foreach ($records as $record) {
            $this->processRecord($record);
        }
    });
}
```

## 💾 Caching Strategies

### 1. Widget Data Caching
**Problem**: Expensive calculations on every widget render
```php
// ❌ ANTI-PATTERN
public function getData(): array
{
    // Expensive calculation every time
    $data = $this->calculateExpensiveData();
    return $data;
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function getData(): array
{
    $cacheKey = "widget_data_{$this->getWidgetId()}";

    return Cache::remember($cacheKey, 300, function () {
        return $this->calculateExpensiveData();
    });
}
```

### 2. Form Schema Caching
**Problem**: Complex form schemas calculated on every render
```php
// ❌ ANTI-PATTERN
public function getFormSchema(): array
{
    // Complex form building every time
    return $this->buildComplexFormSchema();
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function getFormSchema(): array
{
    $cacheKey = "form_schema_{$this->getFormType()}";

    return Cache::remember($cacheKey, 3600, function () {
        return $this->buildComplexFormSchema();
    });
}
```

### 3. Table Column Caching
**Problem**: Table columns calculated on every render
```php
// ❌ ANTI-PATTERN
public function getTableColumns(): array
{
    // Complex column building every time
    return $this->buildComplexTableColumns();
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function getTableColumns(): array
{
    $cacheKey = "table_columns_{$this->getTableType()}";

    return Cache::remember($cacheKey, 3600, function () {
        return $this->buildComplexTableColumns();
    });
}
```

## 🔄 Memory Management

### 1. Lazy Loading
**Problem**: Loading unnecessary data
```php
// ❌ ANTI-PATTERN
public function getData(): Collection
{
    return Model::with(['relation1', 'relation2', 'relation3'])->get();
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function getData(): Collection
{
    return Model::with(['relation1'])->get(); // Only load what's needed
}
```

### 2. Memory-Efficient Iteration
**Problem**: Loading large datasets into memory
```php
// ❌ ANTI-PATTERN
public function processAllRecords(): void
{
    $records = Model::all();
    foreach ($records as $record) {
        $this->processRecord($record);
    }
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function processAllRecords(): void
{
    Model::lazy()->each(function ($record) {
        $this->processRecord($record);
    });
}
```

### 3. Cursor Iteration
**Problem**: Very large datasets causing memory issues
```php
// ❌ ANTI-PATTERN
public function processAllRecords(): void
{
    $records = Model::all();
    foreach ($records as $record) {
        $this->processRecord($record);
    }
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function processAllRecords(): void
{
    foreach (Model::cursor() as $record) {
        $this->processRecord($record);
    }
}
```

## ⚡ Background Processing

### 1. Heavy Operations
**Problem**: Blocking operations in widgets/pages
```php
// ❌ ANTI-PATTERN
public function getData(): array
{
    // Heavy operation blocking the request
    $result = $this->performHeavyOperation();
    return $result;
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function getData(): array
{
    // Check if data is already being processed
    if (Cache::has("processing_{$this->getJobId()}")) {
        return ['status' => 'processing'];
    }

    // Dispatch job for heavy operation
    ProcessHeavyDataJob::dispatch($this->getJobId());

    return ['status' => 'queued'];
}
```

### 2. Batch Processing
**Problem**: Processing large datasets synchronously
```php
// ❌ ANTI-PATTERN
public function processAllRecords(): void
{
    $records = Model::all();
    foreach ($records as $record) {
        $this->processRecord($record);
    }
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function processAllRecords(): void
{
    $chunkSize = 1000;
    $totalRecords = Model::count();
    $totalChunks = ceil($totalRecords / $chunkSize);

    for ($chunk = 0; $chunk < $totalChunks; $chunk++) {
        ProcessRecordsChunkJob::dispatch($chunk, $chunkSize);
    }
}
```

## 🎯 Frontend Optimization

### 1. Lazy Loading Components
**Problem**: Loading all components at once
```php
// ❌ ANTI-PATTERN
public function getFormSchema(): array
{
    return [
        // All fields loaded at once
        TextInput::make('field1'),
        TextInput::make('field2'),
        TextInput::make('field3'),
        // ... many more fields
    ];
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function getFormSchema(): array
{
    $fields = $this->getBasicFields();

    if ($this->showAdvancedFields) {
        $fields = array_merge($fields, $this->getAdvancedFields());
    }

    return $fields;
}
```

### 2. Conditional Rendering
**Problem**: Rendering unnecessary components
```php
// ❌ ANTI-PATTERN
public function getTableColumns(): array
{
    return [
        TextColumn::make('id'),
        TextColumn::make('name'),
        TextColumn::make('email'),
        TextColumn::make('admin_field'), // Always rendered
    ];
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function getTableColumns(): array
{
    $columns = [
        TextColumn::make('id'),
        TextColumn::make('name'),
        TextColumn::make('email'),
    ];

    if (auth()->user()->isAdmin()) {
        $columns[] = TextColumn::make('admin_field');
    }

    return $columns;
}
```

## 📊 Monitoring and Metrics

### 1. Performance Monitoring
```php
// ✅ PERFORMANCE MONITORING
public function getData(): array
{
    $startTime = microtime(true);

    $data = $this->calculateData();

    $endTime = microtime(true);
    $executionTime = $endTime - $startTime;

    if ($executionTime > 1.0) {
        Log::warning('Slow operation detected', [
            'method' => __METHOD__,
            'execution_time' => $executionTime,
        ]);
    }

    return $data;
}
```

### 2. Memory Usage Monitoring
```php
// ✅ MEMORY MONITORING
public function processData(): void
{
    $startMemory = memory_get_usage();

    $this->performOperation();

    $endMemory = memory_get_usage();
    $memoryUsed = $endMemory - $startMemory;

    if ($memoryUsed > 50 * 1024 * 1024) { // 50MB
        Log::warning('High memory usage detected', [
            'method' => __METHOD__,
            'memory_used' => $memoryUsed,
        ]);
    }
}
```

## 🚀 Best Practices Summary

### Database
- ✅ Use eager loading for relationships
- ✅ Optimize queries with proper where clauses
- ✅ Use chunked processing for large datasets
- ✅ Implement proper database indexing

### Caching
- ✅ Cache expensive calculations
- ✅ Use appropriate cache TTL
- ✅ Implement cache invalidation strategies
- ✅ Monitor cache hit rates

### Memory
- ✅ Use lazy loading when possible
- ✅ Process data in chunks
- ✅ Monitor memory usage
- ✅ Implement proper cleanup

### Background Processing
- ✅ Move heavy operations to jobs
- ✅ Use batch processing for large datasets
- ✅ Implement proper job queuing
- ✅ Monitor job performance

### Frontend
- ✅ Implement lazy loading
- ✅ Use conditional rendering
- ✅ Optimize component loading
- ✅ Monitor render performance

## 📚 Related Documentation

- [Code Quality Standards](./CODE_QUALITY_STANDARDS.md)
- [Common Anti-Patterns](./COMMON_ANTI_PATTERNS.md)
- [Testing Guidelines](./testing-guidelines.md)

This document provides comprehensive performance guidelines for maintaining optimal performance across the Xot module and modules that extend it.
# Performance Guidelines - Xot Module

## 🎯 Purpose

This document provides performance guidelines for the Xot module and modules that extend it. Xot serves as the foundation for all other modules, so performance optimizations here have a cascading effect across the entire platform.

## 🚀 Database Optimization

### 1. Eager Loading Patterns
**Problem**: N+1 queries when accessing relationships
```php
// ❌ ANTI-PATTERN
public function getTableColumns(): array
{
    return [
        TextColumn::make('user.name'), // N+1 query
        TextColumn::make('user.email'), // Another N+1 query
    ];
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function getTableColumns(): array
{
    return [
        TextColumn::make('user.name'), // Uses eager loading
        TextColumn::make('user.email'), // Uses eager loading
    ];
}

// Ensure eager loading in the query
public function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()->with('user');
}
```

### 2. Query Optimization
**Problem**: Inefficient database queries
```php
// ❌ ANTI-PATTERN
public function getData(): Collection
{
    return Model::all()->filter(function ($item) {
        return $item->status === 'active';
    });
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function getData(): Collection
{
    return Model::where('status', 'active')->get();
}
```

### 3. Chunked Processing
**Problem**: Memory exhaustion with large datasets
```php
// ❌ ANTI-PATTERN
public function processAllRecords(): void
{
    $records = Model::all(); // Loads everything into memory
    foreach ($records as $record) {
        $this->processRecord($record);
    }
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function processAllRecords(): void
{
    Model::chunk(1000, function ($records) {
        foreach ($records as $record) {
            $this->processRecord($record);
        }
    });
}
```

## 💾 Caching Strategies

### 1. Widget Data Caching
**Problem**: Expensive calculations on every widget render
```php
// ❌ ANTI-PATTERN
public function getData(): array
{
    // Expensive calculation every time
    $data = $this->calculateExpensiveData();
    return $data;
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function getData(): array
{
    $cacheKey = "widget_data_{$this->getWidgetId()}";

    return Cache::remember($cacheKey, 300, function () {
        return $this->calculateExpensiveData();
    });
}
```

### 2. Form Schema Caching
**Problem**: Complex form schemas calculated on every render
```php
// ❌ ANTI-PATTERN
public function getFormSchema(): array
{
    // Complex form building every time
    return $this->buildComplexFormSchema();
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function getFormSchema(): array
{
    $cacheKey = "form_schema_{$this->getFormType()}";

    return Cache::remember($cacheKey, 3600, function () {
        return $this->buildComplexFormSchema();
    });
}
```

### 3. Table Column Caching
**Problem**: Table columns calculated on every render
```php
// ❌ ANTI-PATTERN
public function getTableColumns(): array
{
    // Complex column building every time
    return $this->buildComplexTableColumns();
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function getTableColumns(): array
{
    $cacheKey = "table_columns_{$this->getTableType()}";

    return Cache::remember($cacheKey, 3600, function () {
        return $this->buildComplexTableColumns();
    });
}
```

## 🔄 Memory Management

### 1. Lazy Loading
**Problem**: Loading unnecessary data
```php
// ❌ ANTI-PATTERN
public function getData(): Collection
{
    return Model::with(['relation1', 'relation2', 'relation3'])->get();
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function getData(): Collection
{
    return Model::with(['relation1'])->get(); // Only load what's needed
}
```

### 2. Memory-Efficient Iteration
**Problem**: Loading large datasets into memory
```php
// ❌ ANTI-PATTERN
public function processAllRecords(): void
{
    $records = Model::all();
    foreach ($records as $record) {
        $this->processRecord($record);
    }
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function processAllRecords(): void
{
    Model::lazy()->each(function ($record) {
        $this->processRecord($record);
    });
}
```

### 3. Cursor Iteration
**Problem**: Very large datasets causing memory issues
```php
// ❌ ANTI-PATTERN
public function processAllRecords(): void
{
    $records = Model::all();
    foreach ($records as $record) {
        $this->processRecord($record);
    }
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function processAllRecords(): void
{
    foreach (Model::cursor() as $record) {
        $this->processRecord($record);
    }
}
```

## ⚡ Background Processing

### 1. Heavy Operations
**Problem**: Blocking operations in widgets/pages
```php
// ❌ ANTI-PATTERN
public function getData(): array
{
    // Heavy operation blocking the request
    $result = $this->performHeavyOperation();
    return $result;
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function getData(): array
{
    // Check if data is already being processed
    if (Cache::has("processing_{$this->getJobId()}")) {
        return ['status' => 'processing'];
    }

    // Dispatch job for heavy operation
    ProcessHeavyDataJob::dispatch($this->getJobId());

    return ['status' => 'queued'];
}
```

### 2. Batch Processing
**Problem**: Processing large datasets synchronously
```php
// ❌ ANTI-PATTERN
public function processAllRecords(): void
{
    $records = Model::all();
    foreach ($records as $record) {
        $this->processRecord($record);
    }
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function processAllRecords(): void
{
    $chunkSize = 1000;
    $totalRecords = Model::count();
    $totalChunks = ceil($totalRecords / $chunkSize);

    for ($chunk = 0; $chunk < $totalChunks; $chunk++) {
        ProcessRecordsChunkJob::dispatch($chunk, $chunkSize);
    }
}
```

## 🎯 Frontend Optimization

### 1. Lazy Loading Components
**Problem**: Loading all components at once
```php
// ❌ ANTI-PATTERN
public function getFormSchema(): array
{
    return [
        // All fields loaded at once
        TextInput::make('field1'),
        TextInput::make('field2'),
        TextInput::make('field3'),
        // ... many more fields
    ];
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function getFormSchema(): array
{
    $fields = $this->getBasicFields();

    if ($this->showAdvancedFields) {
        $fields = array_merge($fields, $this->getAdvancedFields());
    }

    return $fields;
}
```

### 2. Conditional Rendering
**Problem**: Rendering unnecessary components
```php
// ❌ ANTI-PATTERN
public function getTableColumns(): array
{
    return [
        TextColumn::make('id'),
        TextColumn::make('name'),
        TextColumn::make('email'),
        TextColumn::make('admin_field'), // Always rendered
    ];
}
```

**Solution**:
```php
// ✅ OPTIMIZED PATTERN
public function getTableColumns(): array
{
    $columns = [
        TextColumn::make('id'),
        TextColumn::make('name'),
        TextColumn::make('email'),
    ];

    if (auth()->user()->isAdmin()) {
        $columns[] = TextColumn::make('admin_field');
    }

    return $columns;
}
```

## 📊 Monitoring and Metrics

### 1. Performance Monitoring
```php
// ✅ PERFORMANCE MONITORING
public function getData(): array
{
    $startTime = microtime(true);

    $data = $this->calculateData();

    $endTime = microtime(true);
    $executionTime = $endTime - $startTime;

    if ($executionTime > 1.0) {
        Log::warning('Slow operation detected', [
            'method' => __METHOD__,
            'execution_time' => $executionTime,
        ]);
    }

    return $data;
}
```

### 2. Memory Usage Monitoring
```php
// ✅ MEMORY MONITORING
public function processData(): void
{
    $startMemory = memory_get_usage();

    $this->performOperation();

    $endMemory = memory_get_usage();
    $memoryUsed = $endMemory - $startMemory;

    if ($memoryUsed > 50 * 1024 * 1024) { // 50MB
        Log::warning('High memory usage detected', [
            'method' => __METHOD__,
            'memory_used' => $memoryUsed,
        ]);
    }
}
```

## 🚀 Best Practices Summary

### Database
- ✅ Use eager loading for relationships
- ✅ Optimize queries with proper where clauses
- ✅ Use chunked processing for large datasets
- ✅ Implement proper database indexing

### Caching
- ✅ Cache expensive calculations
- ✅ Use appropriate cache TTL
- ✅ Implement cache invalidation strategies
- ✅ Monitor cache hit rates

### Memory
- ✅ Use lazy loading when possible
- ✅ Process data in chunks
- ✅ Monitor memory usage
- ✅ Implement proper cleanup

### Background Processing
- ✅ Move heavy operations to jobs
- ✅ Use batch processing for large datasets
- ✅ Implement proper job queuing
- ✅ Monitor job performance

### Frontend
- ✅ Implement lazy loading
- ✅ Use conditional rendering
- ✅ Optimize component loading
- ✅ Monitor render performance

## 📚 Related Documentation

- [Code Quality Standards](./CODE_QUALITY_STANDARDS.md)
- [Common Anti-Patterns](./COMMON_ANTI_PATTERNS.md)
- [Testing Guidelines](./testing-guidelines.md)

This document provides comprehensive performance guidelines for maintaining optimal performance across the Xot module and modules that extend it.
