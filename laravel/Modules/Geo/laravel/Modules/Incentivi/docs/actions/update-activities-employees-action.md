# UpdateActivitiesEmployeesAction

## Overview
The `UpdateActivitiesEmployeesAction` is responsible for updating the calculated incentive amounts for employees assigned to a specific Activity or Project.

## Purpose
Each employee assigned to an activity has a "Percentuale Attività Dipendente" (Employee Activity Percentage), which represents their share of that activity's incentive pool. This action recalculates the absolute Euro amount for each employee whenever the activity's total amount changes.

## Logic
1.  **Determine Record Type:** Handles both `Project` and `Activity` models.
2.  **Get Base Amount:**
    *   For `Project`: Uses `importo_totale`.
    *   For `Activity`: Uses `importo`.
3.  **Iterate Employees:** Loops through all employees attached to the record.
4.  **Calculate Share:**
    *   Retrieves the `percentuale_attivita_dipendente` from the pivot table.
    *   Calculates `importo_attivita_dipendente = base_amount * (percentage / 100)`.
5.  **Update Pivot:** Updates the `importo_attivita_dipendente` field in the pivot table.

## Usage
Invoked when an activity's amount is finalized or when a project's total is updated to ensure all employee shares are synchronized.

```php
app(UpdateActivitiesEmployeesAction::class)->execute($activity);
```

## Dependencies
- `Illuminate\Database\Eloquent\Model`
- `Spatie\QueueableAction\QueueableAction`
