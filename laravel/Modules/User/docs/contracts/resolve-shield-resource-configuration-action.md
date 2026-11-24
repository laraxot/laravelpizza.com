---
title: "ResolveShieldResourceConfigurationAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Shield\\ResolveShieldResourceConfigurationAction"
qmd: "ResolveShieldResourceConfigurationAction shield_resource slug navigazione sort badge gruppo ricerca globale"
---

# ResolveShieldResourceConfigurationAction

Riassume la configurazione della risorsa Shield (slug, navigazione, ricerca globale) e verifica se la RoleResource è pubblicata. Codice: `app/Actions/Shield/ResolveShieldResourceConfigurationAction.php`.

## Input

- Nessuno.

## Output

- `array{slug: string, published: bool, navigation_registered: bool, navigation_sort: int, navigation_badge: bool, navigation_group: bool, globally_searchable: bool}`.

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SHIELD-RES-CFG-INV-1` | `slug` vale `'shield'` se la configurazione non è stringa. | `execute()` | nessuno |
| `SHIELD-RES-CFG-INV-2` | `published` è vero se il file `app/Filament/Resources/Shield/RoleResource.php` esiste. | `isResourcePublished()` | nessuno |
| `SHIELD-RES-CFG-INV-3` | `navigation_registered` non booleano vale `true`. | `execute()` | nessuno |

## Effetti collaterali

Nessuno: letture e controllo di esistenza file.

## Errori

- Nessuna eccezione propria.

## Non fa

- Il controllo di pubblicazione usa `app_path` e non `base_path` (confronta `ResolvePermissionsConfigurationAction`): da verificare il percorso reale.
- `isResourcePublished()` è duplicato in `ShieldUtilsAction`.
- Nessun chiamante in produzione trovato nel perimetro cercato.
