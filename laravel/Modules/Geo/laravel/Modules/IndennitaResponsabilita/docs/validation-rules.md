# Validation Rules - Indennità Responsabilità

This document outlines the custom validation rules implemented in the `IndennitaResponsabilita` module to ensure data integrity and compliance with institutional business requirements.

## Minimum Positive Ratings (Cross-Field Validation)

### Description
To prevent insufficient or empty evaluations, a mandatory check ensures that at least two distinct performance criteria are evaluated with a score greater than zero.

### Requirement Source
This rule is derived from the official evaluation legend displayed on the `Compila` page:
> "Devono ricorrere almeno 2 dei 5 criteri"

### Implementation Details
- **Location**: `Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages\CompilaIndennitaResponsabilita::save()`
- **Logic**:
    1. Retrieve all editable criteria for the current year.
    2. Count how many of these criteria in the form state have a value strictly greater than 0.
    3. If the count is less than 2, the system:
        - Sends a danger notification to the user.
        - Throws a `ValidationException`, preventing data persistence.
- **Constant**: `self::MIN_POSITIVE_RATINGS = 2`

### Error Messages
- **Notification**: "Attenzione: come indicato nella legenda, è necessario compilare almeno 2 criteri con punteggio superiore a 0."
- **Form Error**: "Almeno 2 criteri devono avere un punteggio superiore a 0."

---
**Zen**: Validate at the source, comply with the legend, protect data quality.
