# IndennitaResponsabilita Module - Architecture Overview

## Purpose
Manages liability allowances for public administration personnel with support for different categories and calculation rules.

## Architecture Pattern
Following PTVX architecture principles:
- Extends PTV base classes when available
- Uses XotBaseResource for all Resources
- Implements table methods only in List pages
- Uses QueueableAction for business logic

## Key Components

### Resources
- **ImportiCategoriaResource**: Manages import amounts by category
- **LettFResource**: Manages Letter F documents
- **LettIResource**: Manages Letter I documents
- **MyLogResource**: Activity logging (extends PTV)

### Pages
- **ListImportiCategorias**: List view for import categories
- **ListLettFs**: List view for Letter F
- **ListLettIs**: List view for Letter I
- **ListMyLogs**: List view for logs (extends PTV)

### Models
- **ImportiCategoria**: Import category amounts
- **LettF**: Letter F document data
- **LettI**: Letter I document data
- **MyLog**: Activity log entries
- **IndennitaResponsabilita**: Main entity
- **Rating**: Performance ratings

## Database Connections
Uses dedicated database connection `indennita_responsabilita` for data isolation.

## Key Features

### Import Management
- Category-based import amounts
- Year-based calculations
- Min/max value validation

### Document Management
- Letter F/I document tracking
- Period-based records
- Status management

### Activity Logging
- Complete audit trail
- Table and record tracking
- Action logging

## Integration Points

### PTV Module Dependencies
- MyLogResource extends PTV base class
- Shared logging functionality
- Common UI patterns

### External Systems
- Sigma database integration
- PDND platform support
- Email notifications

## Development Notes

### Form Schema Pattern
All Resources use associative array schema:
```php
return [
    'section_name' => Section::make()->schema([
        'field_name' => TextInput::make('field_name'),
    ]),
];
```

### Table Methods Pattern
Table methods implemented only in List pages:
```php
public function getTableColumns(): array
{
    return [
        TextColumn::make('field_name'),
    ];
}
```

### Action Pattern
Business logic in QueueableAction classes:
```php
class CalculateAllowanceAction
{
    use QueueableAction;
    
    public function execute(CalculationData $data): Allowance
    {
        // Calculation logic
    }
}
```