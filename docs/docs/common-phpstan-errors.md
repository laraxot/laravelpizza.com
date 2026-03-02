# Common PHPStan Errors in Cms Module

## Duplicate Import Error

### Problem
File: `Modules/Cms/database/Factories/PageFactory.php`

Error: "Cannot use Webmozart\Assert\Assert as Assert because the name is already in use"

The file contains duplicate imports:
```php
use Webmozart\Assert\Assert;
use Webmozart\Assert\Assert;
use Webmozart\Assert\Assert;
```

### Solution
Remove duplicate imports, keeping only one:
```php
use Webmozart\Assert\Assert;
```

### Why This Happens
This error typically occurs when:
1. Multiple developers add the same import without checking existing ones
2. Merge conflicts result in duplicate lines
3. Copy-paste operations introduce duplicates
4. Automated refactoring tools don't properly deduplicate imports

### Prevention
1. Always run PHPStan before committing code
2. Use IDE features to organize imports automatically
3. Review code for duplicates during pull request reviews
4. Run code quality tools like PHP-CS-Fixer to normalize imports

### Business Impact
- Blocks the entire PHPStan analysis
- Prevents code quality checks from completing
- Can hide other important errors in the codebase
- Affects the overall quality gate in CI/CD pipelines
