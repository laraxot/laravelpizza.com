# 🛠️ Filament 5.x Core Migration Guide

This guide outlines the mandatory steps for upgrading Laraxot modules to Filament 5.x.

## 📌 Core Principles

1.  **Always Extend XotBase**: Never extend Filament classes directly. Use `XotBaseResource`, `XotBasePage`, `XotBaseWidget`, etc.
2.  **Schema instead of Form**: Use `schema()` for defining components in actions and widgets.
3.  **Strict Typing**: Ensure all `getFormSchema`, `getTableColumns`, and `getInfolistSchema` methods have strict return types.
4.  **No property_exists()**: Never use `property_exists()` on models; use `isset()` or `SafeAttributeCastAction`.

## ⚙️ Upgrade Steps

### 1. Requirements Check
- Update `composer.json` to require PHP 8.2+ and Laravel 11.28+.
- Update Filament dependencies to `^5.0`.

### 2. Asset Management (Tailwind v4)
- Install `@tailwindcss/vite` and update `vite.config.js`.
- Use the new `@import "tailwindcss";` syntax in your CSS files.
- Refer to the [Meetup Theme Guide](../../../Themes/Meetup/docs/03-development/01-filament-5-installation-guide.md) for detailed asset instructions.

### 3. Translation Keys
Ensure all resources have the following keys in their language files:
- `navigation`
- `label`
- `plural_label`
- `fields`
- `actions`

## 🧪 Verification Checklist

- [ ] PHPStan Level 10 passes on the module.
- [ ] PHPMD complexity is within limits (< 10).
- [ ] `npm run build` generates valid manifest.
- [ ] No `property_exists()` calls remaining.
