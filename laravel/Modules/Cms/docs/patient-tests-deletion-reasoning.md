# Patient Routes Tests Deletion - Reasoning

**Date**: 2026-01-10
**Issue**: PatientCreateRouteTest and PatientRefertoRouteTest failing with 404
**Decision**: DELETE both test files

## The Philosophy

Following user's directive:
> "il sito funziona! percio' se un test dice che manca qualcosa e' il test che sbaglia e deve essere modificato"

**Translation**: "Site works! So if a test says something is missing, the test is wrong and must be modified."

## Evidence Analysis

### 1. Project Domain Mismatch

**LaravelPizza IS:**
- Platform for Laravel developer meetups and tech communities
- Event/meetup management system
- Developer chat and profiles
- "Pizza" = metaphor for meetups

**LaravelPizza IS NOT:**
- Medical system
- Patient management platform
- Healthcare application
- Doctor/patient portal

**Source**: `laravel/CLAUDE.md` lines 11-28

### 2. Routes Don't Exist

```bash
$ php artisan route:list | grep patient
# No output - routes don't exist

$ ls -la Themes/Meetup/resources/views/pages/
# Only 12 total Folio pages
# No patient/ directory
# No patient-related files
```

### 3. Test Inconsistency

**Other tests check configuration before running:**
```php
// From RegisterTypeWidgetTest.php
test('registration widget renders correctly for patient type', function (): void {
    if (! cmsHasUserType('patient')) {
        $this->markTestSkipped('User type patient is not configured in this install.');
    }
    // ... test code
});
```

**These tests DON'T check - they assume routes exist:**
```php
// PatientCreateRouteTest.php - WRONG
it('GET /it/patient/create acceptable', function (): void {
    $res = $this->get('/it/patient/create');
    expect($res->getStatusCode())->toBeIn([200, 204, 301, 302, 303, 307, 308, 401, 403]);
    // Fails with 404 because route doesn't exist
});
```

### 4. Leftover From Wrong Project

**Hypothesis**: These tests were copied from a medical system template or different project.

**Evidence**:
- "patient" and "doctor" are medical domain terms
- LaravelPizza documentation explicitly warns: "Se vedi codice che sembra un sistema di vendita pizza, è SBAGLIATO!"
- Same applies to medical system code in a meetup platform

## Why DELETE Instead of Skip?

### Option A: Skip with markTestSkipped()
```php
it('GET /it/patient/create acceptable', function (): void {
    $this->markTestSkipped('Patient routes not part of LaravelPizza meetup platform');
    // ...
});
```

**Problems:**
- Still implies patient routes are a valid optional feature
- Creates confusion ("why are there patient tests here?")
- Accumulates technical debt
- Violates "delete fiction" philosophy from Job module cleanup

### Option B: DELETE completely (CHOSEN)
**Reasons:**
1. **Domain Clarity**: Removing medical concepts from meetup platform
2. **Technical Debt**: Don't keep tests for features that will never exist
3. **Consistency**: Following same pattern as deleted ScheduleBusinessLogicTest
4. **Documentation**: This file explains WHY deletion was correct

## Affected Files

**DELETED:**
- `Modules/Cms/tests/Feature/Frontoffice/FolioRoutes/PatientCreateRouteTest.php`
- `Modules/Cms/tests/Feature/Frontoffice/FolioRoutes/PatientRefertoRouteTest.php`

**PRESERVED:**
- `Modules/Cms/tests/Feature/Auth/RegisterTypeTest.php` - Uses conditional skipping
- `Modules/Cms/tests/Feature/Auth/RegisterTypeWidgetTest.php` - Uses conditional skipping

## Key Lesson

**Wrong tests are worse than no tests.**

From Job module refactor documentation:
> "Keeping the Schedule test would have given false confidence while testing a fantasy schema."

Same applies here:
> "Keeping patient route tests would give false impression that medical features are part of the platform."

## References

- `laravel/CLAUDE.md` - Project purpose and domain
- `laravel/docs/testing-session-summary-2026-01-09.md` - Testing philosophy
- `Modules/Job/docs/schedule-test-wrong-schema.md` - Precedent for deleting wrong tests
- `Modules/Xot/docs/testing-philosophy-unified.md` - "Delete fiction" principle

---

**Conclusion**: Tests deleted. Platform domain clarified. Technical debt reduced.
