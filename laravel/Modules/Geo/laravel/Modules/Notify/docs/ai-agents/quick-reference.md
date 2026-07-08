# Quick Reference & Super Mucca

Guida per Claude: quick reference, workflow, risorse.

## Quick Reference

### Creating a New Model

```php
namespace Modules\YourModule\Models;
class YourModel extends BaseModel
{
    protected $fillable = ['field1', 'field2'];
    protected function casts(): array {
        return array_merge(parent::casts(), ['custom_date' => 'datetime']);
    }
}
```

### Creating a Filament Resource

```php
class PostResource extends XotBaseResource
{
    public function getFormSchema(): array {
        return [TextInput::make('title')];
    }
}
```

### Creating Resource Pages

```php
class ListPosts extends XotBaseListRecords
{
    protected static string $resource = PostResource::class;
}
```

## Super Mucca Methodology

1. **Understand Context**: Logic, Philosophy, Zen, Business Logic, Purpose
2. **Documentation Management**: docs/ è la memoria, aggiornare continuamente
3. **Development Process**: Analyze → Update docs → Implement → Verify → Refine → Update docs
4. **Script Organization**: bashscripts/ subfolders
5. **Blocked Files**: Usare MCP servers

## Additional Resources

**Core:**
- [Composer Merge Plugin](../../laravel/docs/composer-merge-plugin.md)
- [MCP Servers](../../laravel/Modules/Xot/docs/mcp-servers.md)
- [PHPStan Journey](../../laravel/PHPSTAN_JOURNEY.md)

**LimeSurvey & Charts:**
- [LimeSurvey Deep Dive](../../laravel/Modules/Limesurvey/docs/limesurvey-deep-dive-architecture.md)
- [Professional Charts Guide](../../laravel/Modules/Chart/docs/filament-charts-professional-guide.md)
- [JpGraph Reference](../../laravel/Modules/Chart/docs/jpgraph-4-4-3-reference.md)
- [PDF Generation](../../laravel/Modules/Quaeris/docs/pdf-generation-with-charts.md)

## Collegamenti

- [Architecture Principles](./architecture-principles.md)
- [Critical Rules](./critical-rules.md)
- [Indice CLAUDE](./index.md)
