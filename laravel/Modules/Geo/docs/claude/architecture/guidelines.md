# PTVX Architecture Guidelines

## Core Principles

### 1. Modular Architecture
- PTVX è un sistema modulare monolitico basato su Laravel
- Il modulo **PTV** funziona come core/base
- Moduli specifici (es. IndennitaResponsabilita) estendono classi PTV quando disponibili

### 2. Extension Pattern
```php
// Modulo specifico estende classe PTV
class ListMyLogs extends PtvListMyLogs
{
    protected static string $resource = MyLogResource::class;
    // Eredita logica comune, senza duplicazione
}
```

### 3. DRY Principle
- Non duplicare logica che esiste in PTV
- Centralizzare funzionalità comuni nel modulo appropriato
- Riutilizzare attraverso ereditarietà, non copia-incolla

### 4. KISS Principle
- Mantenere il codice semplice e leggibile
- Evitare complessità non necessaria
- Strutture chiare e prevedibili

## Development Workflow

### Before Writing Code
1. Verificare se esiste già una classe PTV da estendere
2. Controllare pattern esistenti nel modulo
3. Consultare documentazione del modulo

### After Writing Code
1. PHPStan Level 10: `./vendor/bin/phpstan analyze`
2. PHPMD: `./vendor/bin/phpmd Modules/ModuleName text cleancode,codesize,controversial,design,naming,unusedcode`
3. PHPInsights: `./vendor/bin/phpinsights analyse Modules/ModuleName --no-interaction --min-quality=80`
4. Commit e push solo se tutti i controlli passano

## Common Patterns

### Resource Pattern
```php
class MyResource extends XotBaseResource  // ✅ Corretto
{
    protected static ?string $model = MyModel::class;
    
    public static function getFormSchema(): array  // ✅ Nella Resource
    {
        return [...];
    }
    
    // ❌ MAI getTableColumns() nella Resource
}
```

### Page Pattern
```php
class ListMy extends XotBaseListRecords  // ✅ Corretto
{
    protected static string $resource = MyResource::class;
    
    public function getTableColumns(): array  // ✅ Nella List page
    {
        return [...];
    }
}
```

### Action Pattern
```php
class MyAction  // ✅ Corretto
{
    use QueueableAction;
    
    public function execute(MyData $data): MyModel
    {
        // Logica pura, testabile
    }
}
```

## Code Quality Standards

### PHPStan Level 10
- Strict typing everywhere
- No mixed types without checks
- Proper generic type annotations
- All methods have return types

### Filament v4 Compatibility
- Use TextColumn::make()->badge() instead of BadgeColumn
- Grid/Section need columnSpanFull() for full width
- unique() has ignoreRecord=true by default

### Translation Management
- All labels via LangServiceProvider
- No hardcoded strings
- Translation keys in snake_case

## Testing Requirements

### Test Structure
- Use Pest for BDD-style tests
- Test both success and failure cases
- Mock external dependencies
- Test Actions and Resource logic

### Coverage
- Minimum 80% code quality
- Feature tests for user workflows
- Unit tests for business logic