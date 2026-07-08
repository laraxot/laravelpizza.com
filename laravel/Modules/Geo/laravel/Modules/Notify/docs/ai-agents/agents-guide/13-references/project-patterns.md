# Action Pattern (CRITICAL)

PTVX uses Spatie QueueableAction for business logic.

```php
// CORRECT - Spatie QueueableAction + app() resolution
app(CreateClientAction::class)->execute($data);

// WRONG - constructor DI is forbidden in Actions
public function __construct(private readonly DatabaseManager $db) {}

// WRONG - method must be named execute()
app(MyAction::class)->createPersonalAccessClient();
```

## Key Guidelines

- **Short array syntax (CRITICAL)**: **ALWAYS** `[]` — **NEVER** `array()` in any PHP file.
- **Packages**: Add to `Modules/{Module}/composer.json`, then run `composer go` from `laravel/`.
- **Git Rules**: 
  - NEVER `git remote set-url` — only project owner does this.
  - Git goes forward only — never restore old versions.
  - Every error fix: git commit + GitHub issue + GitHub discussion.

## Session Best Practices

- GitHub Projects CLI needs `read:project` scope: `gh project list --owner provtv` may fail.
- For PHPMD use PHAR only: `bash laravel/tools/phpmd.sh ...` (never composer package).
- Never use `RefreshDatabase`, `migrate:fresh`, or `migrate --force` in tests.
- Central discussion for shared agent learning: `https://github.com/provtv/base_ptv_fila5_mono/discussions/18`

---
[Back to index](../index.md)
