# PHPStan Level 10 Roadmap - Xot Module

**Data**: 2026-01-30
**Status**: 🟡 In Progress
**Errori Totali**: 80 (approx)

## Errori Identificati

### Migrations
- [ ] `database/migrations/2024_09_24_111828_create_pulse_aggregates_table.php:15` - Call to an undefined method Modules\Xot\Database\Migrations\XotBaseMigration@anonymous::shouldRun().
- [ ] `database/migrations/2024_09_24_111828_create_pulse_entries_table.php:15` - Call to an undefined method Modules\Xot\Database\Migrations\XotBaseMigration@anonymous::shouldRun().
- [ ] `database/migrations/2024_09_24_111828_create_pulse_values_table.php:15` - Call to an undefined method Modules\Xot\Database\Migrations\XotBaseMigration@anonymous::shouldRun().

### Tests
- [ ] `tests/CreatesApplication.php:27` - Function realpath is unsafe to use.
- [ ] `tests/Feature/ModuleBusinessLogicTest.php:25` - Call to an undefined method PHPUnit\Framework\TestCase::assertDatabaseHas().
- [ ] `tests/Feature/ModuleBusinessLogicTest.php:34` - Access to an undefined property Modules\Xot\Models\Module::$slug.
- [ ] `tests/Feature/ModuleBusinessLogicTest.php:35` - Access to an undefined property Modules\Xot\Models\Module::$version.
- [ ] `tests/Feature/ModuleBusinessLogicTest.php:36` - Access to an undefined property Modules\Xot\Models\Module::$enabled.
- [ ] `tests/Feature/ModuleBusinessLogicTest.php:41` - Cannot call method create() on mixed.
- [ ] `tests/Feature/ModuleBusinessLogicTest.php:44` - Cannot call method update() on mixed.
- [ ] `tests/Feature/ModuleBusinessLogicTest.php:47` - Cannot access property $enabled on mixed.
- [ ] `tests/Feature/ModuleBusinessLogicTest.php:50` - Cannot call method update() on mixed.
- [ ] `tests/Feature/ModuleBusinessLogicTest.php:130` - Cannot call method isEnabled() on mixed.

## Prossimi Passi
- [ ] Fix `shouldRun` in Migrations (verify `XotBaseMigration`)
- [ ] Fix `CreatesApplication.php` unsafe functions
- [ ] Fix Tests errors (add type hints, assertions)