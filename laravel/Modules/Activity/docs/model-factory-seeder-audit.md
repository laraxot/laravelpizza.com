# Model/Factory/Seeder Audit

Generated: 2025-08-22 16:20

## Coverage
- Models: Activity, Snapshot, StoredEvent
- Factories: present for all 3
- Seeders: `ActivityDatabaseSeeder.php` exists, but no direct model usage detected

## Missing
- Model-specific seeding for: Activity, Snapshot, StoredEvent (populate realistic samples)

## Candidates likely non-business-critical
- None. All three are infrastructural but used by activity tracking.

## Actions
- Add seeding inside `Modules/Activity/database/seeders/ActivityDatabaseSeeder.php`
- Keep factories updated with strict typing
