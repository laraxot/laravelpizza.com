---
title: "Tenant — architettura BMAD"
type: architecture
status: active
module: Tenant
created: 2026-09-28
updated: 2026-09-28
qmd: "Tenant architettura confini componenti PHP Laravel Filament"
---
tags: [docs, tenant, bmad]
# Tenant — architettura

## Scopo osservato

Multi-tenancy e contesto organizzativo. Scheda derivata da `module.json`, struttura `app/` e conteggi del repository; non sostituisce decisioni architetturali non ancora approvate.

## Inventario verificato

- PHP in `app/`: 53 file.
- Test PHP in `tests/`: 50 file.
- Aree applicative: `Enums`, `Http`, `Filament`, `Services`, `Contracts`, `Models`, `Console`, `Actions`, `Providers`, `View`.
- Persistenza: `database/factories`, `database/migrations`, `database/seeders` presenti.

## Confini

Il modulo espone risorse, azioni e contratti verso i consumatori; la logica di dominio deve restare nelle Action e nei modelli del modulo. Le dipendenze verso Xot, User, Tenant e UI vanno verificate tramite namespace/import reali prima di ogni estensione.

## Decisioni da confermare

1. API pubblica e invarianti.
2. Flussi che richiedono transazioni, autorizzazione e audit.
3. Copertura Pest rappresentativa.
4. Integrazioni esterne obbligatorie od opzionali.

## Gate

PHPStan level max con `laravel/phpstan.neon` immutabile, Pint, Pest nello scope e verifica dei marker di merge. Ogni modifica deve avere lock e story BMAD.

