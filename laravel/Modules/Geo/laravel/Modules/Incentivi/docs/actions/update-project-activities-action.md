# UpdateProjectActivitiesAction

## Overview
The `UpdateProjectActivitiesAction` is a comprehensive action that synchronizes all activities and their assigned employees when a project's incentive component changes.

## Purpose
When a `Project` updates its `componente_incentivante` (usually 80% of the total fund), that amount must be distributed across all its `Activities` according to their defined `quota_percentuale`. Subsequently, each activity's amount must be further distributed to the employees.

## Logic
1.  **Validate Project:** Ensures the record is a valid `Project` instance.
2.  **Iterate Activities:** Loops through all activities associated with the project.
3.  **Calculate Activity Amount:**
    *   Retrieves `quota_percentuale` from the activity.
    *   Calculates `importo_attivita = project->componente_incentivante * (activity_percentage / 100)`.
    *   Updates the `Activity` record.
4.  **Update Employee Shares:** For each employee in the current activity:
    *   Retrieves `percentuale_attivita_dipendente` from the pivot.
    *   Calculates `importo_attivita_dipendente = importo_attivita * (employee_percentage / 100)`.
    *   Updates the pivot table.

## Usage
Called when the project's total fund or its distribution percentages are modified, ensuring a full cascade of updates from Project -> Activities -> Employees.

```php
app(UpdateProjectActivitiesAction::class)->execute($project);
```

## Dependencies
- `Modules\Incentivi\Models\Project`
- `Modules\Incentivi\Models\Activity`
- `Spatie\QueueableAction\QueueableAction`
