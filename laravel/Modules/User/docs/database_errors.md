# Database Errors in User Module

## Missing `doctor_team` Table

**Error Description:** An `Internal Server Error` was encountered due to the missing `doctor_team` table in the database. This table is necessary for the many-to-many relationship between users (doctors) and teams as defined in the `BaseUser` model. The error occurs when trying to fetch all teams for a user via the `allTeams()` method.

**Resolution:** A migration was created to add the `doctor_team` pivot table. The migration file `2025_05_17_000001_create_doctor_team_table.php` defines the structure for this table with foreign keys to `users` and `teams` tables.

## Error: Missing Model Class in Migration

**Error Message**: `Target class [\Modules\User\Models\DoctorTeam] does not exist.`

**Context**: This error occurred during the execution of `php artisan migrate` when the migration attempted to reference a model class that does not exist in the project.

**Resolution**: 
- Initially attempted to use standard Laravel `Illuminate\Database\Migrations\Migration` class to avoid the error.
- As per user's correction, updated migration files to correctly use `XotBaseMigration` with `tableCreate` and `tableUpdate` methods, which is the intended approach for this project.

**Steps Taken**:
1. Modified the migration files `2025_05_16_000001_create_doctor_team_table.php` and `2025_05_17_000001_create_doctor_team_table.php` to extend `XotBaseMigration`.
2. Used `tableCreate` and `tableUpdate` methods for table creation and updates.
3. Added composite primary keys to the `doctor_team` pivot table for better data integrity in previous attempts.

**Additional Notes**:
- This issue highlights the importance of ensuring that migration files follow the project's custom migration patterns using `XotBaseMigration`.
- Documentation and rules have been updated to reflect the correct usage of `XotBaseMigration` with its specific methods.

**Related Documentation:**
- [BaseUser Model](../app/Models/BaseUser.php)
- [Teams Relationship](../app/Models/Team.php)
- [Migration File](../database/migrations/2025_05_17_000001_create_doctor_team_table.php)
- [Root Documentation](../../../docs/collegamenti-documentazione.md)
- [Xot Module Database Guidelines](../../../Modules/Xot/docs/DATABASE_GUIDELINES.md)
