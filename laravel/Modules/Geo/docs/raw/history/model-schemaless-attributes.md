# Schemaless Attributes with `spatie/laravel-schemaless-attributes`

This document outlines the usage, benefits, and considerations for integrating the `spatie/laravel-schemaless-attributes` package into our Laravel Eloquent models. This package provides a flexible way to store arbitrary JSON data within a single database column, offering NoSQL-like capabilities within a relational database context.

## 🎯 Purpose

To allow developers to add flexible, schemaless attributes to Eloquent models, enabling the storage of dynamic and unstructured data without requiring schema migrations for every new data point.

## ✨ Key Features

*   **Flexible Data Storage:** Store any key-value pairs within a designated JSON column on your model's database table.
*   **Dynamic Access:** Attributes can be accessed like regular object properties (`$model->extra_attributes->name`) or array keys (`$model->extra_attributes['name']`).
*   **Dot Notation:** Supports dot notation for getting and setting nested values (`$model->extra_attributes->get('rey.side')`).
*   **Default Values:** The `get()` method allows specifying a default value if an attribute does not exist.
*   **Batch Updates:** The `set()` method allows updating multiple values at once.
*   **Attribute Removal:** The `forget()` method enables deleting specific keys and their values.
*   **Querying:** Provides a `modelScope()` to retrieve models based on the values within their schemaless attributes, supporting single attributes, multiple attributes, and nested attributes with custom operators.

## 🛠️ Integration Guide

### 1. Database Column

Ensure your database table has a JSON column to store the schemaless attributes.

```php
// In a migration file
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('your_table_name', function (Blueprint $table) {
            $table->json('extra_attributes')->nullable();
            // Or using the helper:
            // $table->schemalessAttributes('extra_attributes');
        });
    }

    public function down(): void
    {
        Schema::table('your_table_name', function (Blueprint $table) {
            $table->dropColumn('extra_attributes');
        });
    }
};
```

### 2. Model Setup

#### For a Single Schemaless Attribute Column

Cast the designated column to `Spatie\SchemalessAttributes\Casts\SchemalessAttributes::class` in your model's `$casts` property.

```php
// In your Eloquent Model
use Illuminate\Database\Eloquent\Model;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

class YourModel extends Model
{
    protected $casts = [
        'extra_attributes' => SchemalessAttributes::class,
    ];

    // Optional: Define a scope for easier querying
    public function scopeWithExtraAttributes(): SchemalessAttributes
    {
        return $this->extra_attributes;
    }
}
```

#### For Multiple Schemaless Attribute Columns

Use the `Spatie\SchemalessAttributes\SchemalessAttributesTrait` and define the column names in the `$schemalessAttributes` protected property.

```php
// In your Eloquent Model
use Illuminate\Database\Eloquent\Model;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;

class YourModel extends Model
{
    use SchemalessAttributesTrait;

    protected array $schemalessAttributes = [
        'extra_attributes',
        'another_schemaless_column',
    ];

    // Optional: Define scopes for easier querying
    public function scopeWithExtraAttributes(): SchemalessAttributes
    {
        return $this->extra_attributes;
    }

    public function scopeWithAnotherSchemalessColumn(): SchemalessAttributes
    {
        return $this->another_schemaless_column;
    }
}
```

### 3. Querying Models

Use the defined scopes (e.g., `withExtraAttributes()`) to query models based on their schemaless attributes.

```php
use App\Models\YourModel;

// Query a single attribute
YourModel::query()->withExtraAttributes()->where('name', 'John Doe')->get();

// Query multiple attributes
YourModel::query()->withExtraAttributes()->where([
    'name' => 'John Doe',
    'age' => 30,
])->get();

// Query nested attributes (using dot notation for the key)
YourModel::query()->withExtraAttributes()->where('address.city', 'New York')->get();

// Custom operators
YourModel::query()->withExtraAttributes()->where('age', '>', 25)->get();
```

## ✅ Benefits

*   **Flexibility:** Easily store dynamic and unstructured data without modifying the database schema.
*   **Simplified Data Management:** Centralizes related, but varied, data within a single model attribute.
*   **Eloquent Integration:** Seamlessly integrates with Laravel's Eloquent ORM, allowing familiar access and querying patterns.
*   **Rapid Prototyping:** Quickly add new data points without upfront database changes.

## ⚠️ Caveats and Project Guidelines

While `spatie/laravel-schemaless-attributes` offers great flexibility, it's crucial to understand its limitations and adhere to project-specific guidelines for its usage:

1.  **Database Requirement:** Requires a database that supports JSON columns (e.g., MySQL 5.7+, PostgreSQL).
2.  **Query Performance:**
    *   For frequently queried or critical data, a dedicated relational column is generally more performant.
    *   Complex queries on deeply nested schemaless attributes might have performance implications, especially with large datasets.
    *   Consider indexing JSON columns where supported by the database, but be aware that this might not always match the performance of B-tree indexes on regular columns.
3.  **Type Safety and Validation:**
    *   Data stored in schemaless attributes is dynamic, which reduces strict type safety compared to explicitly defined model attributes.
    *   Always implement robust validation when reading from or writing to schemaless attributes, especially for user-provided data. PHPStan will have limited ability to infer types within these attributes.
    *   **Guideline:** Avoid storing business-critical, highly structured, or frequently aggregated data in schemaless attributes unless absolutely necessary and performance implications are thoroughly tested and understood.
4.  **Readability and Maintainability:** Over-reliance on schemaless attributes can reduce code readability and make it harder to understand the expected data structure without extensive documentation or runtime inspection.
5.  **Schema Evolution:** While flexible, major structural changes to the data within schemaless attributes might still require data migration scripts.

### Project-Specific Usage Recommendation:

Use `spatie/laravel-schemaless-attributes` for:
*   **Metadata:** Storing arbitrary metadata that is not core to the business logic and doesn't require complex querying or strict validation.
*   **User Preferences:** Flexible storage of user-specific settings or preferences.
*   **External API Responses:** Caching parts of external API responses that are dynamic and not fully consumed by the application's core logic.
*   **Rapid Prototyping:** For initial development phases where the exact structure of certain data points is still evolving, with the understanding that these might be refactored into dedicated columns later if they become critical.

**Avoid** using `spatie/laravel-schemaless-attributes` for:
*   Core business logic data that is frequently queried, filtered, or used in reports.
*   Data that requires strict type enforcement or complex database constraints.
*   Data that needs to be efficiently indexed for performance-critical operations.

By adhering to these guidelines, we can leverage the flexibility of schemaless attributes while maintaining the robustness and performance of our relational database.