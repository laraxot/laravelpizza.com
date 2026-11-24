---
title: "GetModulesNavigationItems — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Filament\\GetModulesNavigationItems"
qmd: "GetModulesNavigationItems voci navigazione moduli sidebar config icona navigation_sort hasRole admin cache getCachedModuleConfigs"
---

# GetModulesNavigationItems

Costruisce le voci di navigazione Filament per i moduli abilitati al tenant, e una variante cache dei dati di configurazione.

Codice: `app/Actions/Filament/GetModulesNavigationItems.php:26-177`.

## Input

- Nessun input per `execute()`. `getCachedModuleConfigs()` legge gli stessi moduli.

## Output

`execute`: `array<int, NavigationItem>`. `getCachedModuleConfigs`: `array` con `module`, `module_low`, `icon`, `sort`.

## Invarianti

- `FIL-NAVMOD-INV-1`: un modulo senza `config.php` leggibile o con config non array viene saltato senza errore (righe 48-68). Test: tests/Unit/XotExecuteCoverage50Test.php:665 (assertNotEmpty).
- `FIL-NAVMOD-INV-2`: la voce è visibile solo per un utente autenticato con ruolo `{modulo}::admin` (righe 87-102). Test: Nessun test dedicato.
- `FIL-NAVMOD-INV-3`: `getCachedModuleConfigs` usa una cache di 10 minuti con chiave derivata dall'elenco moduli; icona di default `heroicon-o-cube` (righe 116-176). Test: Nessun test dedicato.

## Effetti collaterali

Lettura di `config.php` di ogni modulo a ogni chiamata di `execute`. `getCachedModuleConfigs` scrive in cache Laravel. Nessun evento.

## Errori

Errori di configurazione sono saltati; errori di `GetTenantModulesAction` si propagano.

## Non fa

- Codice identico a `GetNavigationItemByModulename::getCachedModuleConfigs`: duplicazione.
- Icona di default diversa tra `execute` (question-mark) e `getCachedModuleConfigs` (cube).
