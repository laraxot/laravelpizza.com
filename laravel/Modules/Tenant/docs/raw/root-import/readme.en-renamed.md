# Tenant

The **Tenant** module enables multi-tenancy in the Laraxot modular monolith: it resolves the current tenant (domain / path / context), isolates configuration and data, and provides the foundation to run multiple organizations on a single installation.

## What you get

- **Reliable tenant resolution**
- **Data isolation** (depending on the project strategy)
- **Integration with authentication and permissions**
- **Extensible structure**: each project can customize behavior without forking

## Quickstart

This repository is a modular monorepo: the module already lives in `laravel/Modules/Tenant`.

- **Enable the module**
  - `php artisan module:enable Tenant`
- **Run global migrations**
  - `php artisan migrate`

## Documentation (entrypoint)

- `docs/README.md`
- `docs/00-index.md`
- `docs/module-tenant.md`
- `docs/configuration.md`
- `docs/architecture-rules.md`
- `docs/testing.md`

## Contributing

- Document fixes and decisions in `docs/` (avoid duplicates, use relative links).
- Keep project quality standards (PHPStan at the project max level).

## License

MIT. See the `LICENSE` file at the project root.
