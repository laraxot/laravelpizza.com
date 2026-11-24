---
title: "Story: Bootstrap provider registry — composer.json driven"
type: story
status: accepted
created: 2026-11-23
updated: 2026-11-23
epic: "Xot bootstrap"
issues:
  - "https://github.com/laraxot/module_xot_fila5/issues/ADR-0009"
discussions: []
related:
  - docs/wiki/rules/module-providers-manifest.md
  - docs/wiki/memories/module-providers-manifest-not-manual-register.md
---

# Story: Bootstrap provider registry — composer.json driven

## Descrizione

Implementare il registry dei service provider basato su `composer.json` come SSoT (ADR 0009). Il file `bootstrap/providers.php` deve contenere solo `AppServiceProvider::class` e i provider dei moduli nwidart vengono scoperti automaticamente tramite la chiave `extra.laravel.providers` nei rispettivi `composer.json` e il comando `package:discover`.

## Obiettivo

- Eliminare la manutenzione manuale di `bootstrap/providers.php`
- Auto-discovery dei provider all'aggiunta di nuovi moduli/temi
- Audit script per verificare la coerenza `composer.json` ↔ provider caricati

## Scope

- In scope: `bootstrap/providers.php`, `XotBaseServiceProvider::registerModuleProviders()`, audit script
- Out of scope: migrazione dei provider legacy già registrati in `config/app.php` (già allineati)

## Conferma

- [ ] `bootstrap/providers.php` contiene solo `AppServiceProvider::class` (già fatto)
- [ ] `XotBaseServiceProvider` registra i provider leggendo `extra.laravel.providers` da ogni modulo/tema
- [ ] Audit script `bashscripts/tools/audit-module-provider-manifest.sh` passa per tutti i moduli/temi
- [ ] Test: `vendor/bin/pest Modules/Xot/tests/Unit/Bootstrap/ProvidersRegistryTest.php` passa
- [ ] ADR 0009 creato e linkato nell'indice `README.md` del modulo Xot (già fatto)

## GitHub (tracciamento)

- Issue: https://github.com/laraxot/module_xot_fila5/issues/ADR-0009