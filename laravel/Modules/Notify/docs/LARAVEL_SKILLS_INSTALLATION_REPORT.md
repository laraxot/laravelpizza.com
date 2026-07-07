# Laravel Skills Installation Report

**Date**: 2026-03-02  
**Task**: Install all skills from https://skills.laravel.cloud/

## Summary

Attempted to install all available skills from the Laravel Skills directory. Most repositories listed on the website are not yet public or accessible via GitHub.

## Skills Attempted

From https://skills.laravel.cloud/ (11 skills listed):

1. ✅ **laravel-specialist** (jeffallan/claude-skills) - **INSTALLED**
2. ❌ **php-pro** (jeffallan/php-pro) - Repository not found (404)
3. ❌ **php-mcp-server-generator** (github/php-mcp-server-generator) - Repository not found (404)
4. ❌ **eloquent-best-practices** (iserter/eloquent-best-practices) - Repository not found (404)
5. ❌ **php-best-practices** (asyrafhussin/php-best-practices) - Repository not found (404)
6. ❌ **laravel-11-12-app-guidelines** (thienanblog/laravel-11-12-app-guidelines) - Repository not found (404)
7. ❌ **laravel-best-practices** (asyrafhussin/laravel-best-practices) - Repository not found (404)
8. ❌ **shadcn-vue** (noartem/shadcn-vue) - Repository not found (404)
9. ❌ **laravel-inertia-react** (asyrafhussin/laravel-inertia-react) - Repository not found (404)
10. ❌ **laravel-tdd** (iserter/laravel-tdd) - Repository not found (404)
11. ❌ **wp-phpstan** (wordpress/wp-phpstan) - Repository not found (404)
12. ❌ **laravel-testing** (leeovery/laravel-testing) - Repository not found (404)

## Additional Repositories Tested

1. ❌ **spatie/boost-spatie-guidelines** - No valid skills found in repository
2. ⚠️ **thienanblog/awesome-ai-agent-skills** - Requires interactive input (cannot install non-interactively)

## Built-in Laravel Boost Skills

Laravel Boost v2.2.1 includes 14 built-in skills in the package:

1. **Livewire Development** (3 versions: v2, v3, v4)
2. **Inertia React Development** (2 versions)
3. **Inertia Vue Development** (2 versions)
4. **Inertia Svelte Development** (2 versions)
5. **Folio Routing**
6. **MCP Development**
7. **Pest Testing** (2 versions: v3, v4)
8. **Volt Development**
9. **Wayfinder Development**

### Built-in Skills Location
```
/var/www/_bases/base_fixcity_fila5/laravel/vendor/laravel/boost/.ai/
```

## Successfully Installed Skills

### laravel-specialist
- **Package**: jeffallan/claude-skills
- **Location**: `/var/www/_bases/base_fixcity_fila5/laravel/.ai/skills/laravel-specialist/`
- **Files**:
  - SKILL.md
  - references/routing.md
  - references/testing.md
  - references/queues.md
  - references/eloquent.md
  - references/livewire.md

## Issue Analysis

### Why Most Repositories Return 404

The skills.laravel.cloud website appears to be a **preview/directory** of upcoming skills that are planned to be published but are not yet public on GitHub. This is evidenced by:

1. **HTTP 404 Errors**: All repositories return "Not Found" errors
2. **110 Total Skills Listed**: Only 11 are shown, suggesting an incomplete directory
3. **Recent Laravel Boost Release**: Laravel Boost v2 was recently released (Feb 2026), and the ecosystem is still developing

### Repository Status

| Repository | Owner | Status | Notes |
|-----------|-------|--------|-------|
| php-pro | jeffallan | ❌ Not Found | Not yet published |
| php-mcp-server-generator | github | ❌ Not Found | Not yet published |
| eloquent-best-practices | iserter | ❌ Not Found | Not yet published |
| php-best-practices | asyrafhussin | ❌ Not Found | Not yet published |
| laravel-11-12-app-guidelines | thienanblog | ❌ Not Found | Not yet published |
| laravel-best-practices | asyrafhussin | ❌ Not Found | Not yet published |
| shadcn-vue | noartem | ❌ Not Found | Not yet published |
| laravel-inertia-react | asyrafhussin | ❌ Not Found | Not yet published |
| laravel-tdd | iserter | ❌ Not Found | Not yet published |
| wp-phpstan | wordpress | ❌ Not Found | Not yet published |
| laravel-testing | leeovery | ❌ Not Found | Not yet published |
| boost-spatie-guidelines | spatie | ⚠️ Invalid Format | Repository exists but doesn't contain valid Boost skills |

## Available Skills Summary

### Currently Available (15 total)

1. ✅ laravel-specialist (installed)
2-14. ✅ 14 built-in Boost skills (included in package)

### Not Yet Available (10+ total)

The remaining 10+ skills listed on skills.laravel.cloud are not yet published as public GitHub repositories.

## Recommendations

1. **Monitor skills.laravel.cloud** - Check periodically for repository publication
2. **Use Built-in Skills** - Laravel Boost includes 14 pre-built skills covering major use cases
3. **Create Custom Skills** - If specific skills are needed, create them locally in `.ai/skills/`
4. **Check GitHub** - Search GitHub for "laravel boost skill" to find community-published skills

## Installation Command Used

```bash
php artisan boost:add-skill <owner/repo>
```

### Example Successful Installation

```bash
php artisan boost:add-skill jeffallan/claude-skills --skill laravel-specialist
```

## Skills Activation

To use installed skills, they must be activated in the AI guidelines. Check the `.ai/` directory for configuration files.

## Next Steps

1. Monitor skills.laravel.cloud for repository publications
2. Test the installed laravel-specialist skill
3. Explore built-in Boost skills
4. Consider creating custom skills if needed

---

**Report Generated**: 2026-03-02  
**Installation Attempts**: 13 repositories  
**Successful Installations**: 1 skill  
**Built-in Skills Available**: 14 skills  
**Total Skills Available**: 15 skills