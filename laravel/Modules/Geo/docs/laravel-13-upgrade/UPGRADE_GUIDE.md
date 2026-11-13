# Guida all'Upgrade Laravel 13

## Introduzione
Questo documento descrive la procedura e lo stato dell'upgrade del progetto Laraxot a Laravel 13. Il progetto utilizza un'architettura modulare basata su `nWidart/laravel-modules`, che richiede l'aggiornamento simultaneo del pacchetto alla versione 13.

## Requisiti di Sistema
- **PHP**: ^8.3 (Obbligatorio)
- **Composer**: Wikimedia Composer Merge Plugin abilitato

## Stato dell'Upgrade (2026-05-05)

### Root Project
- [x] PHP aggiornato a `^8.3` in `laravel/composer.json`.
- [x] `laravel/framework` aggiornato a `^13.0`.
- [x] `nwidart/laravel-modules` aggiornato a `^13.0`.
- [x] Configurazione `merge-plugin` verificata.

### Moduli (35 totali)
Tutti i moduli nella cartella `laravel/Modules/` sono stati aggiornati con:
- PHP ^8.3
- Laravel Framework ^13.0
- Laravel Modules ^13.0 (dove applicabile)
- Documentazione individuale in `docs/laravel-13-upgrade.md`.

### Temi (3 totali)
- [x] **Zero**: Aggiornato `composer.json` e documentazione.
- [x] **One**: Aggiornato `composer.json` e documentazione.
- [ ] **Three** (ex `Theme_One`, rinominato 2026-05-26): nessun `composer.json` trovato, solo documentazione di stile.

## Procedura Post-Aggiornamento
Una volta terminati gli aggiornamenti dei file, eseguire i seguenti comandi dalla directory `laravel/`:

```bash
# Sincronizzazione dipendenze
composer go

# Pulizia cache
php artisan optimize:clear

# Pubblicazione stub aggiornati
php artisan module:publish-stubs
```

## Quality Gates
Dopo l'aggiornamento, è necessario verificare l'integrità del codice con:
- `php artisan module:analyse` (o singolarmente nei moduli)
- `php artisan test`

## Riferimenti
- [Laravel Modules Documentation (v13)](https://laravelmodules.com/docs/13/getting-started/introduction)
- [nWidart/laravel-modules GitHub](https://github.com/nWidart/laravel-modules)
