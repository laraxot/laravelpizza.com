---
title: "Laravel 13 Theme Zero Composer Audit"
module: "Zero"
type: source
created: "2026-05-05"
updated: "2026-05-05"
qmd: "Theme Zero, Laravel 13, composer audit, theme dependencies"
related:
  - "../index.md"
---

# Laravel 13 Theme Zero Composer Audit

## Summary

Theme Zero currently has a minimal `composer.json` with package metadata only. It does not declare PHP runtime dependencies or PSR-4 autoload rules.

This means the Laravel 13 Composer migration should not add `Themes/*/composer.json` to the root merge plugin just to be complete. Theme composer files should join root Composer resolution only after a theme declares PHP dependencies that must be resolved with the application.

## Current Theme Composer

`laravel/Themes/Zero/composer.json` declares:

- `name`: `laraxot/theme_zero`
- `type`: `project`
- `minimum-stability`: `dev`
- `prefer-stable`: `true`

It does not declare:

- `require`
- `require-dev`
- `autoload`
- `extra.laravel.providers`

## Rule

During the Laravel 13 upgrade:

- keep Theme Zero Composer out of root merge unless it gains PHP dependencies;
- continue documenting theme-specific upgrade effects in `laravel/Themes/Zero/docs/wiki`;
- handle frontend dependencies through the theme package manager files, not Composer, unless PHP integration is added.

## References

- Root upgrade plan: `../../../../../docs/wiki/concepts/laravel13-modular-composer-upgrade-plan.md`
- Story: `../../../../../_bmad-output/implementation-artifacts/13-1-laravel13-modular-composer-upgrade.md`
