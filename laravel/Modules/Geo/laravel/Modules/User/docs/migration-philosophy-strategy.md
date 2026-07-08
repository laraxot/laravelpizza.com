# Laraxot Migration Philosophy & Strategy

## Core Principles

### 1. ONE Migration Per Table Rule
- Each table must have exactly ONE migration responsible for its creation
- Multiple migrations creating the same table violates Laraxot philosophy
- Subsequent changes should extend existing tables using `tableUpdate()`

### 2. DRY (Don't Repeat Yourself)
- Avoid duplicating table structure definitions
- Use centralized patterns for common operations
- Leverage base migration classes for consistency

### 3. Safe Schema Operations
- Always check for existence before operations
- Use `hasColumn()`, `hasTable()`, `hasIndex()` methods
- Implement defensive programming practices

## Migration Patterns

### Initial Table Creation (XotBaseMigration)
```php
return new class extends XotBaseMigration {
    protected string $table_name = 'teams';

    public function up(): void
    {
        $this->tableCreate(static function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->nullable()->index();
            $table->string('name');
            $table->timestamps();
        });
    }
};
```

### Schema Updates (XotBaseMigration with tableUpdate)
```php
return new class extends XotBaseMigration {
    protected string $table_name = 'teams';

    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            if (!$this->hasColumn('owner_id')) {
                $table->uuid('owner_id')->nullable()->after('id');
            }
        });
    }
};
```

### Specific Column Additions (Standard Migration)
```php
return new class extends Migration {
    public function up(): void
    {
        Schema::connection('user')->table('teams', function (Blueprint $table): void {
            if (!Schema::connection('user')->hasColumn('teams', 'owner_id')) {
                $table->uuid('owner_id')->nullable()->after('id');
            }
        });
    }
};
```

## Migration File Naming Convention
- Use descriptive names: `YYYY_MM_DD_HHMMSS_create_table_name_table.php`
- For updates: `YYYY_MM_DD_HHMMSS_add_column_to_table.php`
- For structural changes: `YYYY_MM_DD_HHMMSS_modify_table_structure.php`

## Migration Structure
1. First migration: Use `tableCreate()` for initial table structure
2. Subsequent migrations: Use `tableUpdate()` or standard migration with checks
3. Always include proper down() methods for rollbacks
4. Use connection-specific schema operations when needed

## Quality Checks
- Verify no duplicate table creation migrations exist
- Ensure all migrations have proper existence checks
- Test rollback and forward migration capabilities
- Validate against database constraints and relationships

## Migration Workflow
1. Analyze existing table structure
2. Determine if table already exists
3. If new table: create single migration with `tableCreate()`
4. If existing table: create migration with `tableUpdate()` or standard checks
5. Test thoroughly in development environment
6. Document changes in module documentation

This philosophy ensures maintainable, consistent, and DRY database schema management across the Laraxot framework.
