# Dependency Intelligence - Theme Meetup

Aggiornato il 2026-03-02 da dipendenze `package.json` tema + runtime PHP da `composer show`.

## Frontend toolchain (`devDependencies`)

| Package | Constraint |
|---|---|
| `@tailwindcss/forms` | `^0.5.10` |
| `@tailwindcss/typography` | `^0.5.19` |
| `@tailwindcss/vite` | `^4.1.18` |
| `@tailwindplus/elements` | `^1.0.14` |
| `@types/node` | `^24.10.1` |
| `alpinejs` | `^3.15.0` |
| `autoprefixer` | `^10.4.22` |
| `axios` | `^1.11.0` |
| `concurrently` | `^9.0.1` |
| `daisyui` | `^5.1.22` |
| `laravel-vite-plugin` | `^2.0.1` |
| `playwright` | `^1.58.1` |
| `postcss` | `^8.5.6` |
| `postcss-import` | `^16.1.1` |
| `postcss-nesting` | `^13.0.2` |
| `prettier` | `^3.7.3` |
| `tailwindcss` | `^4.1.18` |
| `typescript` | `~5.8.3` |
| `vite` | `^7.3.1` |

## PHP runtime dependencies that drive theme rendering

- `laravel/framework`: `v12.52.0`
- `laravel/folio`: `v1.1.12`
- `livewire/livewire`: `v4.1.4`
- `livewire/volt`: `v1.10.2`
- `mcamara/laravel-localization`: `v2.3.0`
- `calebporzio/sushi`: `v2.5.3`
- `filament/filament`: `v5.2.1`

## Chaos monkey focus points

- Build break: `vite`/Tailwind toolchain mismatch.
- Runtime break: Folio page resolves but block view namespace non valido (`pub_theme::` obbligatorio).
- i18n break: URL localizzate non propagate in payload Alpine.

## Deep Study References

- [Composer packages study](../../../../docs/architecture/composer-packages-study.md)
- [Composer packages full inventory](../../../../docs/architecture/composer-packages-full-inventory.md)
