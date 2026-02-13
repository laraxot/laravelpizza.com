# Tenant

Il modulo **Tenant** abilita la multi-tenancy nel monolite modulare Laraxot: identifica il tenant (domain / path / contesto), isola configurazioni e dati, e fornisce le fondamenta per gestire più organizzazioni in un’unica installazione.

## Cosa ottieni (in pratica)

- **Tenant resolution affidabile**
- **Isolamento dei dati** (in base alla strategia del progetto)
- **Integrazione con autenticazione e permessi**
- **Struttura estendibile**: ogni progetto può personalizzare il comportamento senza fork

## Quickstart

Questo repository è un monorepo modulare: il modulo è già presente in `laravel/Modules/Tenant`.

- **Abilita il modulo**
  - `php artisan module:enable Tenant`
- **Esegui le migrazioni (globali)**
  - `php artisan migrate`

## Documentazione (entrypoint)

- `docs/README.md`
- `docs/00-index.md`
- `docs/module-tenant.md`
- `docs/configuration.md`
- `docs/architecture-rules.md`
- `docs/testing.md`

## Come contribuire

- Documenta fix e decisioni in `docs/` (evita duplicati, usa link relativi).
- Mantieni gli standard di qualità del progetto (PHPStan livello massimo).

## License

MIT. Vedi il file `LICENSE` nella root del progetto.
