# Quality Tools: PHPMD, PHP-CS-Fixer, Laravel Pint, Psalm, PHPQA, actionlint, CodeRabbit

This guide standardizes how we study, run, and maintain code quality tools across modules and themes without breaking the site. Always use dry-run/report modes first and integrate changes incrementally.

## Principles
- Safety first: run in read-only or dry-run; commit in small batches.
- Per-module scope: prefer `Modules/<Module>` or `Themes/<Theme>` paths.
- Do not change phpstan.neon; treat PHPMD/CS/Pint/Psalm configs as additive.
- Keep docs updated in each module/theme with local deviations.

## Tools

### 1) PHPMD (PHP Mess Detector)
- Purpose: detect code smells and design issues.
- Study: gist (slayerfat), phpmd.org, JetBrains integration, PHPQA docs.
- Safe run (report only):
```bash
vendor/bin/phpmd Modules text cleancode,codesize,controversial,design,naming,unusedcode --ignore-violations-on-exit
```
- Narrow scope:
```bash
vendor/bin/phpmd Modules/User text cleancode,codesize --suffixes php
```
- Config: create `phpmd.xml.dist` at project root or per-module; document suppressions in module docs.

### 2) PHP-CS-Fixer
- Purpose: auto-fix style issues based on rulesets.
- Safe run:
```bash
vendor/bin/php-cs-fixer fix --dry-run --diff --using-cache=yes
```
- Apply only after review:
```bash
vendor/bin/php-cs-fixer fix --allow-risky=no
```
- Config: `.php-cs-fixer.dist.php` at root; module overrides optional (document).

### 3) Laravel Pint
- Purpose: opinionated formatter for Laravel.
- Safe run:
```bash
vendor/bin/pint --test
```
- Apply:
```bash
vendor/bin/pint
```
- Recommendation: prefer Pint for Laravel code, CS-Fixer for non-Laravel areas if needed.

### 4) Psalm
- Purpose: static analysis complementary to PHPStan.
- Safe run:
```bash
vendor/bin/psalm --no-cache --no-diff --output-format=text
```
- Narrow per-module:
```bash
vendor/bin/psalm --paths=Modules/User
```
- Config: `psalm.xml` with per-path baseline; update baselines sparingly.

### 5) PHPQA
- Purpose: orchestrator to run tools like PHPMD, PHPCS, PHPCPD, PDepend.
- Safe run:
```bash
vendor/bin/phpqa --analyzedDirs Modules --report --output build/phpqa --tools phpmd,phpcs,phpcpd --execution no-ansi
```
- Do not fail CI initially; turn on failure gates gradually.

### 6) actionlint
- Purpose: validate GitHub Actions workflows.
- Safe run:
```bash
actionlint -color
```
- Scope: `.github/workflows/*.yml`.

### 7) CodeRabbit (docs)
- Purpose: AI code review; use for PR guidance, not as authority.
- Ensure PRs include links to module/theme docs and acceptance criteria checklists.

## CI Recommendations
- Jobs:
  - phpstan (level 9), psalm (informational), pint test, cs-fixer dry-run, phpmd report, phpqa report, actionlint.
- Artifacts: store reports in CI artifacts, not in `docs/`.
- Gates: start as advisory; enforce gradually per module after manual review.

## Usage Workflow (Per Module)
1. Read module docs in `Modules/<Module>/docs/`.
2. Run phpstan (already 0 errors) to ensure baseline.
3. Run PHPMD (report), then Pint test, then CS-Fixer dry-run.
4. Fix the smallest, safest subset; re-run tests and manual smoke.
5. Update module docs: what rules were applied, what was deferred, links to issues.

## Documentation
- Each module/theme must have `quality-tools` page linking back here.
- Record deviations and suppressions with rationale and next review date.
