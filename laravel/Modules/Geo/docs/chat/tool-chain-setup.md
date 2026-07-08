# Tool Chain Setup: Type Checking, Metrics, Quality & Visual Testing

## Rationale: Multi-Layer Quality Assurance

Static analysis tools form a defensive perimeter:
- **Type safety:** phpstan catches type mismatches before runtime
- **Code metrics:** phpmd detects complexity, maintainability issues
- **Quality scoring:** phpinsights aggregates violations into actionable insights
- **Visual regression:** puppeteer/playwright catch UI breakage without manual testing

This stack enables atomic commits with confidence—each commit passes all gates.

## Tool Selection Philosophy

### Why phpstan (not just Psalm)?
- **Semantic understanding:** Tracks variable flow, type narrowing, generics
- **Level-based strictness:** Start at level 0, raise to 9 as codebase hardens
- **Composer global:** Shared across projects, minimal overhead
- **Laravel integration:** Works with facades, helpers, container injection

### Why phpmd (not just Mess Detector)?
- **Fine-grained rules:** Cyclomatic complexity, NPATH, naming violations
- **Ruleset customization:** docs/phpmd.ruleset.xml tailors severity per codebase area
- **Bash integration:** Runs in CI/pre-commit, no Composer dependency bloat

### Why phpinsights (with caveat)?
- **Holistic scoring:** Aggregates phpstan, phpmd, coding standards into 0-100 score
- **Human-readable reports:** "Security: 92/100", "Performance: 87/100"
- **Version conflict:** Requires php_codesniffer ^4.0, root composer.json locks ^3.13.4
- **Deferred strategy:** Install globally only after understanding existing standards

### Why puppeteer + playwright?
- **Headless browsers:** Catch CSS/layout breakage, JavaScript errors, async issues
- **Screenshot diffing:** Detect visual regressions in navigation, forms, modals
- **Cross-browser:** Puppeteer (Chromium), Playwright (Chromium/Firefox/WebKit)
- **Monorepo scale:** Pre-commit hooks can run visual tests on changed components

## Installation & Configuration

### phpstan (✓ DONE)
```bash
composer global require phpstan/phpstan:^2.1
```
- Global location: ~/.composer/vendor/bin/phpstan
- Config: laravel/phpstan.neon (created by init, customized per project)
- Usage: `phpstan analyse laravel/app`
- Level strategy: Start at 5, incrementally raise to 9

### phpmd (✓ VERIFIED)
```bash
# Already available system-wide
which phpmd  # /usr/local/bin/phpmd
```
- Ruleset: docs/phpmd.ruleset.xml (custom, per codebase)
- Usage: `phpmd laravel xml docs/phpmd.ruleset.xml`
- Pre-commit integration: bashscripts/hooks/pre-commit-phpmd.sh

### phpinsights (⏸ DEFERRED)
- **Issue:** Version conflict with php_codesniffer (^4.0 vs ^3.13.4)
- **Strategy:** Install globally ONLY after:
  1. Decision: Upgrade root composer.json to ^4.0 (breaking change)
  2. OR: Run phpinsights in separate Docker container (isolated env)
  3. OR: Document conflict + maintain manual integration
- **Current:** phpstan + phpmd cover type + metrics layers; phpinsights adds polish later

### puppeteer (✓ DONE)
```bash
npm install -g puppeteer
```
- Global location: ~/.nvm/versions/node/vX.X.X/lib/node_modules/puppeteer
- Usage: Node.js or bash wrapper for headless Chrome automation
- Pre-commit: bashscripts/hooks/pre-commit-visual.sh

### playwright (🔄 NEXT)
```bash
npm install -g playwright
```
- Cross-browser headless: Chromium, Firefox, WebKit
- Usage: Node.js automation or CLI `npx playwright test`
- Visual regression: Screenshot diffing plugin available

## Why This Stack in Monorepo?

**Problem:** 50+ modules + 3 themes → no unified quality gate

**Solution:**
1. **Pre-commit enforcement:** Type, metrics, visual checks before branch push
2. **CI/CD gating:** GitHub Actions runs full suite on PR
3. **Agent autonomy:** AI agents (phpstan, phpmd) validate own changes before commit
4. **Atomic trail:** git log shows only quality-vetted commits

## Configuration Files (to Create)

1. **laravel/phpstan.neon**
   - Includes: Laravel/Eloquent extensions
   - Level: 5 (transitional, raises to 9)
   - Ignores: Known legacy type issues in specific modules

2. **docs/phpmd.ruleset.xml**
   - Complexity threshold: Cyclomatic complexity < 15
   - Naming: follow PSR-12
   - Unused code: flag but don't fail

3. **bashscripts/hooks/pre-commit-phpstan.sh**
   - Runs on changed .php files
   - Stops push if violations detected

4. **bashscripts/hooks/pre-commit-visual.sh**
   - Runs puppeteer screenshot diffs
   - Compares with baseline in docs/visual-baselines/

## References

- [[file_locking_pattern]] - Atomic file modifications during tool execution
- [[context_compaction_strategy]] - Token optimization when tools generate large output
- GitHub issue #3 - Tool chain integration and configuration decisions
- bashscripts/tools/ - File lock manager, pre-commit orchestration
