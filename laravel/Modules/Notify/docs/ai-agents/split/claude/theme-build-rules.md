=== theme build rules ===

## CRITICAL: Theme Build Process

**NEVER FORGET THIS RULE**: After ANY modification to CSS, JavaScript, or Tailwind configuration files in a theme, you MUST run the build commands from the theme directory:

### Required Commands (ALWAYS):
```bash
cd /var/www/html/_bases/base_fixcity_fila5_mono/laravel/Themes/Sixteen
npm run build
npm run copy
```

### When to Run:
- After modifying `tailwind.config.js`
- After modifying `resources/css/app.css` 
- After modifying any JavaScript files
- After adding new Tailwind classes to Blade files
- After ANY frontend changes

### Why This Is Critical:
- The Laravel application reads compiled assets from the theme's `resources/dist/` directory
- Without `npm run build`, Tailwind won't compile new classes or changes
- Without `npm run copy`, the changes won't be available to the main Laravel application
- Users will NOT see any frontend changes without these steps

### Remember:
- Changes to CSS/JS are INVISIBLE until built and copied
- Always build from the specific theme directory (`Themes/Sixteen/`)
- Both commands are required - build compiles, copy deploys

This is a fundamental rule that must NEVER be forgotten when working with themes.


---

## Cross-References

- ← [CLAUDE Index](INDEX.md) — All Laravel Boost guidelines
- ← [Main AI Docs Index](../INDEX.md) — Master index
- ← [../../../../docs/CLAUDE.md](../../../../docs/../../../../docs/CLAUDE.md) — Original source

