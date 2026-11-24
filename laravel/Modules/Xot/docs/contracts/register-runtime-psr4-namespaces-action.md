---
title: "RegisterRuntimePsr4NamespacesAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Composer\\RegisterRuntimePsr4NamespacesAction"
qmd: "RegisterRuntimePsr4NamespacesAction PSR-4 runtime temi Sixteen TwentyOne Two seeders composer ClassLoader addPsr4"
---

# RegisterRuntimePsr4NamespacesAction

Registra a runtime i namespace PSR-4 di temi e seeders che restano fuori da `composer.json`.

Codice: `app/Actions/Composer/RegisterRuntimePsr4NamespacesAction.php:15-44`.

## Input

- `ClassLoader $loader` (solo per `execute`): loader Composer su cui registrare.
- Nessun input per `namespaces()`, che è statica e legge `base_path()`.

## Output

`execute`: `void`. `namespaces()`: `array<string, string|list<string>>` con cinque prefissi fissi.

## Invarianti

- `COMPOSER-PSR4-INV-1`: `namespaces()` restituisce sempre la stessa mappa fissa di cinque prefissi, con percorsi derivati da `base_path()` (righe 20-31). Test: nessun test comportamentale; citato solo in tests/Arch/scope.php.
- `COMPOSER-PSR4-INV-2`: `execute` registra con `addPsr4` solo i percorsi che sono directory esistenti (`is_dir`); i percorsi mancanti sono saltati (righe 38-42). Test: Nessun test dedicato.

## Effetti collaterali

Modifica in memoria del `ClassLoader` passato (`addPsr4`). Nessuna scrittura su disco: non tocca `composer.json` né l'autoload generato.

## Errori

Nessuna eccezione propria.

## Non fa

- Non legge né scrive `composer.json`.
- Non rimuove prefissi già registrati: `addPsr4` li affianca.
- Non applica la registrazione da sola: il chiamante deve passare il loader.
