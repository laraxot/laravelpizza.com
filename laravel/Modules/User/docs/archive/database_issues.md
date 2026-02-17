# Database Issues in User Module

## Missing `doctor_team` Table

**Issue**: An `Internal Server Error` was encountered due to the missing `doctor_team` table when fetching team data for a user in the `BaseUser` model.

**Resolution**: A migration file `2025_05_16_000001_create_doctor_team_table.php` was created to establish the relationship between users (doctors) and teams. The migration was run to apply the changes to the database.

**Latest Update (Conflict Resolution)**: Identified a conflict with the migration for `doctor_team` table. The table appears to exist in the database, but migrations are marked as pending. Updated the migration file to check for table existence before creation and attempted to run the migration again on 2025-05-16.

**Latest Update (Migration Analysis and Rules)**: Analyzed the changes made to the migration file for `doctor_team` table on 2025-05-16. Updated the project rules in `.mdc` files to reflect the use of `XotBaseMigration` and the importance of checking for table existence before creation. Also updated other migration files for consistency.

**Latest Update (Migration Status and Table Check)**: After updating migration files and rules on 2025-05-16, checked the migration status and verified if the `doctor_team` table exists in the database to resolve the `Internal Server Error`.

**Latest Update (User Modification)**: The user has updated the migration file for `doctor_team` table on 2025-05-16 to include a composite primary key using `$table->primary(['user_id', 'team_id']);` for enhanced data integrity in the pivot table. The migration was attempted again to resolve the `Internal Server Error`.

**Latest Update (Corrected Migration Structure)**: Updated the migration files for `doctor_team` table on 2025-05-16 to use the correct structure with `tableCreate` and `tableUpdate` methods from `XotBaseMigration`. Also updated project rules in `.mdc` files to enforce this convention. Attempted migration again to resolve the `Internal Server Error`.

**Related Documentation**:
- [User Module Overview](../INDEX.md)
- [Team Management](./TEAM_MANAGEMENT.md)
- [BaseUser Model](./BaseUser.md)
- [Database Structure](../DATABASE_STRUCTURE.md)
- [Migration Guidelines](../../../../docs/collegamenti-documentazione.md)
