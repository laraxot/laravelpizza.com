# {ThemeName} Theme

> **Filament Version**: Admin panels and Filament resources in this theme target **Filament v5** (see Second Brain `docs/wiki/memories/filament-version-policy.md` and `docs/filament-version.md`).

## Overview

{Brief description of the theme's purpose and visual identity}

## Architecture

- **Views**: `Themes/{ThemeName}/resources/views/`
- **Assets**: `Themes/{ThemeName}/resources/`
- **Config**: `Themes/{ThemeName}/config/`

## Components

| Component | Path | Purpose |
|-----------|------|---------|
| {ComponentName} | `views/components/{name}.blade.php` | {purpose} |

## Build Pipeline

```bash
cd laravel/Themes/{ThemeName}
npm install
npm run build
npm run copy  # Copy assets to public
```

## Dependencies

- **CSS**: Tailwind CSS v4
- **JS**: Alpine.js, Livewire
- **PHP**: Filament v5, Laraxot UI module

## Development Workflow

### GSD (Get Shit Done)

For theme development, use the GSD workflow:

1. **Discuss**: `GSD discuss phase N` — Clarify UI/UX decisions
2. **Plan**: `GSD plan phase N` — Create atomic task plans
3. **Execute**: `GSD execute phase N` — Implement with atomic commits
4. **Verify**: `GSD verify N` — Visual inspection + automated checks

For quick fixes: `GSD quick "{ThemeName}: description"`

### Quality Gates

After every change:
- [ ] `npm run build` succeeds
- [ ] `npm run copy` publishes assets correctly
- [ ] Vite pipeline completes without errors
- [ ] Visual regression check (if applicable)
- [ ] Responsive design verified
- [ ] Accessibility standards met

## Documentation

- [GSD Methodology](../../docs/project/gsd-methodology.md)
- [UI Components](../../laravel/Modules/UI/docs/components.md)
- [AGENTS.md](../../AGENTS.md)

## Roadmap

See `.planning/ROADMAP.md` for phases that affect this theme.

## Changelog

See git history: `git log --oneline laravel/Themes/{ThemeName}/`
