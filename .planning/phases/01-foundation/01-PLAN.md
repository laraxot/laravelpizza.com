---
phase: 01-foundation
plan: 01
type: execute
wave: 1
depends_on: []
files_modified:
  - laravel/phpunit.xml
  - laravel/composer.json
  - laravel/phpstan.neon
autonomous: true
requirements: []
must_haves:
  truths:
    - "PCOV is installed and configured as the coverage driver"
    - "PHPStan runs at level 10 with proper module scanning"
    - "Test conventions are enforced (DatabaseTransactions, strict types)"
    - "Coverage command works end-to-end"
  artifacts:
    - path: "laravel/phpunit.xml"
      provides: "Test configuration with coverage settings"
    - path: "laravel/composer.json"
      provides: "PCOV dependency"
    - path: "laravel/phpstan.neon"
      provides: "PHPStan level 10 configuration"
  key_links:
    - from: "laravel/phpunit.xml"
      to: "coverage"
      via: "Xdebug or PCOV driver"
      pattern: "processIsolation.*coverage"
    - from: "composer.json"
      to: "pcov"
      via: "require-dev"
      pattern: "pcov.*:"
---

<objective>
Establish test infrastructure, coverage tools, and quality gates before writing module tests.

Purpose: Enable 100% code coverage tracking and type safety validation across the modular codebase.
Output: Configured PCOV coverage driver, PHPStan level 10, and verified test execution pipeline.
</objective>

<execution_context>
@./.opencode/get-shit-done/workflows/execute-plan.md
@./.opencode/get-shit-done/templates/summary.md
</execution_context>

<context>
@./.planning/PROJECT.md

# Existing infrastructure (read for reference):
- phpunit.xml: Already configured with module test directories
- phpstan.neon: Already at level 10, excludes tests and vendor
- Tests exist in: Modules/User/tests/, Modules/Xot/tests/, Modules/Job/tests/, etc.
</context>

<tasks>

<task type="auto">
  <name>Task 1: Verify PCOV installation and add if needed</name>
  <files>laravel/composer.json</files>
  <action>
    Check if PCOV is already a dependency in composer.json.
    If not present, add "pcov/pecl-coverage": "^1.0" to require-dev.
    Run: composer update --dev pcov/pecl-coverage --working-dir=laravel
  </action>
  <verify>
    <automated>php -m | grep -i pcov</automated>
  </verify>
  <done>PCOV extension loaded in PHP</done>
</task>

<task type="auto">
  <name>Task 2: Configure phpunit.xml for PCOV coverage</name>
  <files>laravel/phpunit.xml</files>
  <action>
    Ensure phpunit.xml has proper coverage configuration:
    - Add <coverage> section with <driver name="phpdbg"/> or PCOV
    - Ensure testsuites correctly point to Modules/*/tests/
    - Verify processIsolation is enabled for coverage accuracy
    The existing config already has modules test directories - verify they're correct.
  </action>
  <verify>
    <automated>./vendor/bin/phpunit --version && ./vendor/bin/phpunit --list-suites</automated>
  </verify>
  <done>PHPUnit configured with coverage driver</done>
</task>

<task type="auto">
  <name>Task 3: Verify PHPStan level 10 configuration</name>
  <files>laravel/phpstan.neon</files>
  <action>
    Review existing phpstan.neon:
    - Level is already 10 ✓
    - Paths include Modules/
    - Exclude tests/* and vendor/*
    - Bootstrap files are configured
    
    Ensure modules have their own phpstan.neon.dist files that include the base config.
    Run a quick PHPStan check on a single module to verify.
  </action>
  <verify>
    <automated>cd laravel && ./vendor/bin/phpstan analyse Modules/User/Models --memory-limit=512M 2>&1 | head -30</automated>
  </verify>
  <done>PHPStan runs at level 10 without errors</done>
</task>

<task type="auto">
  <name>Task 4: Enforce test conventions in existing tests</name>
  <files>laravel/Modules/*/tests/Pest.php</files>
  <action>
    Verify all test files follow conventions from PROJECT.md:
    - Every test file uses: uses(TestCase::class, DatabaseTransactions::class)
    - No protected function in test files (use global functions)
    - declare(strict_types=1) at top
    
    Check and fix Pest.php bootstrap files in existing modules.
  </action>
  <verify>
    <automated>cd laravel && ./vendor/bin/pest --filter="test_" 2>&1 | tail -20</automoped>
  </verify>
  <done>Test conventions verified in existing tests</done>
</task>

<task type="auto">
  <name>Task 5: Verify coverage works end-to-end</name>
  <files>laravel/phpunit.xml</files>
  <action>
    Run a test with coverage to verify the full pipeline works:
    1. Run: cd laravel && ./vendor/bin/pest --coverage Modules/User/tests/
    2. Verify coverage output is generated
    3. Verify the command completes without errors
    
    This validates PCOV is working with PHPUnit/Pest.
  </action>
  <verify>
    <automated>cd laravel && ./vendor/bin/pest Modules/User/tests/Feature --coverage 2>&1 | tail -40</automated>
  </verify>
  <done>Coverage command runs and produces output</done>
</task>

</tasks>

<verification>
- PCOV extension loaded in PHP
- PHPUnit configured with coverage driver
- PHPStan level 10 analyzes modules without errors
- Test conventions followed in existing test files
- Coverage command produces output
</verification>

<success_criteria>
1. `php -m | grep pcov` returns pcov
2. `./vendor/bin/pest --coverage` runs without errors
3. `./vendor/bin/phpstan analyse Modules/User` passes at level 10
4. Existing tests in Modules/*/tests/ use DatabaseTransactions trait
</success_criteria>

<output>
After completion, create `.planning/phases/01-foundation/01-01-SUMMARY.md`
</output>
