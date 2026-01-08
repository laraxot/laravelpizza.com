# CI Quality Pipeline (Staged, Safe-By-Default)

This pipeline defines a staged adoption of linters/scanners across the monorepo. All jobs run in report/dry-run mode initially. Enforce gates only after manual review.

## Stage 0 (Advisory Only)
- phpstan (level 9) — pass/fail (already 0 errors)
- pint (test) — advisory
- php-cs-fixer (dry-run) — advisory
- phpmd (report) — advisory
- psalm (info) — advisory
- markdownlint (report) — advisory
- actionlint (report) — advisory
- gitleaks (report) — advisory

## Stage 1 (Incremental Enforcement)
- Enable fail on pint/php-cs-fixer for specific paths once reviewed.
- Enable fail on phpmd rules that have been addressed.

## Tools and Suggested Invocations

### PHP (Composer-installed or vendor binaries)
```bash
# phpstan (already configured via laravel/phpstan.neon)
./vendor/bin/phpstan analyse Modules --level=9 --memory-limit=-1

# pint
./vendor/bin/pint --test

# php-cs-fixer
./vendor/bin/php-cs-fixer fix --dry-run --diff

# phpmd (report)
./vendor/bin/phpmd Modules text cleancode,codesize,design,naming,unusedcode --ignore-violations-on-exit

# psalm (informational)
./vendor/bin/psalm --no-cache --no-diff --output-format=text
```

### GitHub Actions (actionlint)
```bash
# Containerized (no install)
docker run --rm -v "$PWD":/repo -w /repo ghcr.io/rhysd/actionlint:latest -color
```

### Markdown (markdownlint-cli)
```bash
# npx (no install in repo)
npx --yes markdownlint-cli "**/*.md" --ignore "**/node_modules/**"
```

### Secrets (gitleaks)
```bash
docker run --rm -v "$PWD":/path zricethezav/gitleaks:latest detect --no-git --source=/path --report-format=json --report-path=/path/build/gitleaks.json || true
```

## Gradual Path Enforcement
- Define include globs per module/theme (e.g., `Modules/User/**`), then expand.
- Track rule suppressions in module/theme `quality-tools.md` with rationale and a review date.

## Artifacts
- Store reports in CI artifacts (e.g., `build/`), not in `docs/` folders.

## Responsibilities
- Module owners review advisory reports, fix low-risk issues first (formatting, naming), validate flows, then enable enforcement.
- Theme owners verify visual parity after any formatting changes.
