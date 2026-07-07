# Documentation standards

> Source: [IFLOW.md](../../bashscripts/ai/IFLOW.md) | [CLAUDE.md](../../CLAUDE.md)
> Back: [index](index.md)

## File naming conventions (CRITICAL)

All `.md` files MUST follow these rules (except `README.md`):

### 1. kebab-case

Use hyphens, not underscores or PascalCase:
```
CORRECT: model-architecture.md
WRONG:   model_architecture.md
WRONG:   ModelArchitecture.md
```

### 2. No dates in filenames

Never include dates in filenames:
```
CORRECT: dry-kiss-analysis.md
WRONG:   dry-kiss-analysis-2025-10-15.md
WRONG:   phpstan-fixes-january-2026.md
```

### 3. Lowercase only

`README.md` is the ONLY file allowed with uppercase:
```
CORRECT: phpstan-fixes.md, README.md
WRONG:   PHPSTAN_FIXES.md, PHPStan-Fixes.md
```

### 4. No duplicates

Do not use suffixes like `-duplicate`, `-backup`, `_backup`:
```
CORRECT: event-sourcing.md
WRONG:   event-sourcing-duplicate.md
WRONG:   event-sourcing-backup.md
```

## Documentation locations

| Location | Content |
|----------|---------|
| `docs/` | Project-level documentation |
| `laravel/Modules/{Module}/docs/` | Module-specific docs |
| `laravel/Themes/{Theme}/docs/` | Theme-specific docs |
| `bashscripts/docs/` | Bashscripts docs (centralized - NEVER subfolders inside bashscript subdirs) |
| `.agents/docs/` | AI agent shared docs (this directory) |
| `laravel/.mcp.json` | MCP configuration |
| `.github/workflows/` | GitHub workflows |

## Module docs required files

Every module must have:
- `docs/README.md` - Module overview, features, quick start
- PHPDoc blocks for all public methods

Optional but recommended:
- `docs/models/README.md` - Model documentation
- `docs/architecture.md` - Technical architecture
- `docs/configuration.md` - Configuration options
- `docs/integration.md` - Integration with other modules

## Translation file rules - navigation sections

When you find `.navigation` anywhere in a translation value, this is an **incomplete placeholder** that MUST be fixed:

```php
// WRONG - ".navigation" placeholder
'navigation' => [
    'label' => 'question chart.navigation',  // BAD
    'icon' => 'survey pdf.navigation',        // BAD
],

// CORRECT
'navigation' => [
    'name' => 'Grafici Domanda',
    'plural' => 'Grafici Domanda',
    'group' => ['name' => 'Survey'],
    'label' => 'Grafici Domanda',
    'icon' => 'heroicon-o-chart-bar',
],
```

## Cleanup tools

Scripts in `bashscripts/docs-cleanup/`:
```bash
# Analyze non-conformant files
./bashscripts/docs-cleanup/analyze-nonconformant-files.sh

# Preview renames (dry-run)
./bashscripts/docs-cleanup/rename-to-kebab-case.sh

# Actually rename
DRY_RUN=0 ./bashscripts/docs-cleanup/rename-to-kebab-case.sh
```
