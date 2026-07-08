The `SchedaTrait`, used by models like `IndennitaResponsabilita`, currently has numerous accessors (`get*Attribute`) that calculate values and then persist them back to the database using `$this->update(['field' => $value])`. This pattern has several drawbacks:

1.  **Write-on-Read Side Effect:** Every time these attributes are accessed and not cached (or `refresh` is requested), a database write operation occurs, which can be inefficient and lead to unexpected behavior.
2.  **Activity Log Issues:** This pattern has been identified as causing "Duplicate Entry" errors with the Activity Log package due to model serialization.
3.  **Schema Bloat:** If new calculated fields are frequently added, it can lead to table bloat with many potentially nullable or derived columns.

To improve the handling of these calculated, dynamic attributes, and in line with your prompt regarding `spatie/laravel-schemaless-attributes`, I recommend refactoring these calculated attributes to use a schemaless JSON column.

**Implementation Plan (High-Level):**

1.  **Migration:** Add a `JSON` column (e.g., `calculated_data`) to the `schede` table (used by `BaseScheda`).
2.  **Model Integration:** Integrate `spatie/laravel-schemaless-attributes` into `BaseScheda` (or `XotBaseModel` if appropriate for all models) using the `SchemalessAttributesTrait` and casting the `calculated_data` column.
3.  **Accessor Refactoring:** Modify all `get*Attribute` methods within `SchedaTrait` (and potentially other traits/models) that currently perform `$this->update(['field' => $value])`. Instead of updating a direct column, they will update the corresponding key within the `calculated_data` schemaless attribute.
4.  **Data Migration (if needed):** If existing calculated values are stored in individual columns, a data migration might be needed to move them into the new JSON column.
5.  **Remove Individual Columns:** Once values are migrated, the individual columns for these calculated attributes can be removed from the database via migrations.

This refactoring will make the data storage for dynamic attributes more flexible, reduce write-on-read side effects, and potentially resolve conflicts with packages like Activity Log.

**Do you confirm to proceed with this refactoring?** This is a significant change to the core model behavior.