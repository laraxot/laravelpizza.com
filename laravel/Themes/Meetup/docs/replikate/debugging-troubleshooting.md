# Task: Systematic Debugging and Troubleshooting

## Objective
Provide a structured, efficient approach to identifying, diagnosing, and resolving issues in the LaravelPizza Meetup theme with minimal context waste and maximum accuracy.

## Pre-Task Requirements

### 1. Context Gathering (Mandatory)
Before attempting any fix, systematically gather information:

```
1. Read error messages/logs completely
2. Identify the exact file and line number
3. Check git status to see recent changes
4. Review related documentation
5. Examine similar working code patterns
```

### 2. Information Collection Checklist
- [ ] Full error stack trace captured
- [ ] Browser console errors checked
- [ ] Laravel logs reviewed (storage/logs/laravel.log)
- [ ] PHP syntax verified (php -l)
- [ ] Recent git commits reviewed
- [ ] Related documentation read
- [ ] Similar working patterns identified

## Common Issue Categories & Solutions

### Category 1: Filament/Widget Errors

#### Issue: "Class not found" or "Method not found"
**Symptoms:**
```
Error: Class 'Filament\Forms\Components\Grid' not found
Error: Call to undefined method XotBaseWidget::disableLiveUpdates()
```

**Diagnostic Steps:**
1. Check import statements - use correct Filament namespaces
2. Verify method exists in parent class
3. Check if extending XotBase* classes correctly
4. Review Filament version compatibility

**Common Fixes:**
```php
// ❌ WRONG
use Filament\Forms\Components\Grid;

// ✅ CORRECT - No Grid import needed
'name_grid' => Grid::make(2)->schema([...])

// ❌ WRONG - method doesn't exist
$this->disableLiveUpdates();

// ✅ CORRECT - remove non-existent method
```

#### Issue: Label/Translation Problems
**Symptoms:**
```
Translation key not found: gdpr::register.fields.first_name.label
```

**Diagnostic Steps:**
1. Check if using `->label()` (FORBIDDEN)
2. Verify translation file exists
3. Check translation key format
4. Review LangServiceProvider configuration

**Common Fixes:**
```php
// ❌ WRONG - never use ->label()
TextInput::make('first_name')
    ->label(__('gdpr::register.fields.first_name'))

// ✅ CORRECT - AutoLabelAction handles it
TextInput::make('first_name')
```

### Category 2: Database/Model Errors

#### Issue: "property_exists() on Eloquent model"
**Symptoms:**
```
Error: property_exists() cannot be used on Eloquent models
```

**Diagnostic Steps:**
1. Search for `property_exists()` usage
2. Check if target is Eloquent model
3. Verify attribute access pattern

**Common Fixes:**
```php
// ❌ WRONG
if (property_exists($user, 'email')) { ... }

// ✅ CORRECT
if ($user->hasAttribute('email')) { ... }
// or
if (isset($user->email)) { ... }
// or
if ($user->isFillable('email')) { ... }
```

#### Issue: Many-to-Many Relation Errors
**Symptoms:**
```
Error: belongsToMany() should not be used directly
```

**Diagnostic Steps:**
1. Check relation method definitions
2. Verify RelationX trait is included
3. Review pivot class configuration

**Common Fixes:**
```php
// ❌ WRONG
public function events() {
    return $this->belongsToMany(Event::class);
}

// ✅ CORRECT
public function events() {
    return $this->belongsToManyX(Event::class);
}
```

### Category 3: Frontend/Asset Errors

#### Issue: CSS/JS changes not visible
**Symptoms:**
```
Changes to app.css or app.js not showing in browser
```

**Diagnostic Steps:**
1. Check if ran `npm run build`
2. Check if ran `npm run copy`
3. Verify working directory is correct
4. Check browser cache

**Common Fixes:**
```bash
# Always run from theme directory
cd laravel/Themes/Meetup/
npm run build
npm run copy
# Then verify with hard refresh (Ctrl+Shift+R)
```

#### Issue: Inline SVG in Blade
**Symptoms:**
```
SVG not rendering or styling incorrectly
```

**Diagnostic Steps:**
1. Check for inline SVG markup in Blade
2. Verify SVG file exists in resources/svg
3. Check icon component usage

**Common Fixes:**
```blade
{{-- ❌ WRONG - inline SVG --}}
<svg class="h-8 w-8">...</svg>

{{-- ✅ CORRECT - use icon component --}}
<x-filament::icon icon="meetup-logo" class="h-8 w-8" />
```

### Category 4: Translation/Localization Errors

#### Issue: Missing translations or wrong language
**Symptoms:**
```
Translation key showing instead of text
Wrong language content in translation file
```

**Diagnostic Steps:**
1. Check translation file exists
2. Verify translation key format
3. Check content is in target language (not English)
4. Verify all 6 languages have keys

**Common Fixes:**
```php
// ❌ WRONG - English in Italian file
// lang/it/register.php
'already_registered' => 'Already have an account?',

// ✅ CORRECT - Italian content
'already_registered' => 'Hai già un account?',
```

### Category 5: Routing/Page Errors

#### Issue: 404 or page not found
**Symptoms:**
```
404 Not Found on /it/pages/about
```

**Diagnostic Steps:**
1. Check if page file exists in resources/views/pages
2. Verify JSON content file exists
3. Check Folio routing configuration
4. Review URL mapping

**Common Fixes:**
```blade
{{-- Correct pattern --}}
{{-- resources/views/pages/[slug].blade.php --}}
<x-page side="content" :slug="$slug" />

{{-- JSON file --}}
{{-- config/local/laravelpizza/database/content/pages/about.json --}}
```

## Debugging Workflow

### Step 1: Error Isolation
1. Capture full error message
2. Identify exact location (file:line)
3. Check git diff for recent changes
4. Isolate the problematic code

### Step 2: Pattern Analysis
1. Search for similar working code
2. Review documentation for patterns
3. Check existing rules and constraints
4. Identify violation or missing requirement

### Step 3: Root Cause Identification
1. Use PHPStan Level 10 for code analysis
2. Check syntax with `php -l`
3. Review logs for additional context
4. Test with minimal reproduction case

### Step 4: Solution Implementation
1. Apply fix following Laraxot patterns
2. Update related documentation
3. Run tests and validation
4. Verify fix doesn't break other functionality

### Step 5: Documentation Update
1. Document the issue and solution
2. Update relevant docs
3. Share learning with team
4. Update memories if new pattern

## Quality Assurance Checklist

### Before Committing
- [ ] PHPStan Level 10 passes
- [ ] All syntax checks pass
- [ ] Translation files complete for all 6 languages
- [ ] No `->label()` usage
- [ ] No `property_exists()` on models
- [ ] No inline SVG in Blade
- [ ] All URLs use `LaravelLocalization::localizeUrl()`
- [ ] Documentation updated
- [ ] Lock files cleaned up

### After Fixing
- [ ] Test on multiple browsers
- [ ] Test on mobile and desktop
- [ ] Test in all 6 languages
- [ ] Verify accessibility (keyboard navigation)
- [ ] Check console for errors
- [ ] Verify WCAG compliance if UI change

## Common Pitfalls to Avoid

1. **Skipping documentation review** - Always read relevant docs first
2. **Assuming without verification** - Verify before applying patterns
3. **Forgetting translations** - Check all 6 languages
4. **Breaking established rules** - Follow Laraxot patterns strictly
5. **Not testing thoroughly** - Test comprehensively before committing
6. **Forgetting to update docs** - Documentation is mandatory
7. **Ignoring lock file protocol** - Create .lock before modifying

## Advanced Debugging Techniques

### PHPStan Analysis
```bash
# Analyze specific file
./vendor/bin/phpstan analyse path/to/file.php --memory-limit=-1

# Analyze entire module
./vendor/bin/phpstan analyse Modules/Gdpr/ --memory-limit=-1
```

### Log Analysis
```bash
# Tail Laravel logs
tail -f storage/logs/laravel.log

# Search for specific errors
grep "Error" storage/logs/laravel.log

# Check recent errors
tail -100 storage/logs/laravel.log | grep -i error
```

### Git Debugging
```bash
# Check what changed recently
git log --oneline -10

# See diff for specific file
git diff HEAD path/to/file.php

# Check when issue was introduced
git blame path/to/file.php
```

### Browser Debugging
- Use browser DevTools Console
- Check Network tab for failed requests
- Use React/Vue DevTools if applicable
- Test with different browsers
- Test in Incognito mode

## Escalation Protocol

If unable to resolve issue after systematic debugging:

1. **Document all attempts**: What you tried, results, errors
2. **Provide complete context**: Code snippets, error messages, logs
3. **Share research**: Documentation read, patterns examined
4. **Propose hypotheses**: Likely causes and potential solutions
5. **Request specific guidance**: Ask targeted questions

## Success Metrics

- Issue resolved on first attempt: 95%+
- No new issues introduced: 99%+
- Documentation updated: 100%
- Learning captured: 100%
- Time to resolution: <15 minutes for common issues

---

**Last Updated**: 2026-02-09  
**Status**: 🚀 ACTIVE  
**Purpose**: Systematic approach to debugging LaravelPizza Meetup theme