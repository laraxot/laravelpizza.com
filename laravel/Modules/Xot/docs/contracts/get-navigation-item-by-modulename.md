---
title: "GetNavigationItemByModulename — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Filament\\GetNavigationItemByModulename"
qmd: "GetNavigationItemByModulename voce navigazione singolo modulo config mancante eccezione hasRole cache duplicato"
---

# GetNavigationItemByModulename

Costruisce la voce di navigazione Filament di un singolo modulo. Lancia se la config manca.

Codice: `app/Actions/Filament/GetNavigationItemByModulename.php:26-178`.

## Input

- `string $module`.

## Output

`NavigationItem`.

## Invarianti

- `FIL-NAVONE-INV-1`: se `config.php` manca lancia `\Exception` (righe 43-46). Diverso da `GetModulesNavigationItems`, che salta. Test: nessuno; tests/Arch/debt.php cita la classe.
- `FIL-NAVONE-INV-2`: visibile solo con ruolo `{modulo}::admin` per l'utente autenticato (righe 92-104). Test: Nessun test dedicato.
- `FIL-NAVONE-INV-3`: un `config.php` che non restituisce array fa fallire `Assert::isArray` (riga 51). Test: Nessun test dedicato.

## Effetti collaterali

Lettura di `config.php`. `getCachedModuleConfigs` scrive in cache.

## Errori

`\Exception` per config mancante; `Assert` per tipi non validi; nessun try attorno a `File::getRequire`.

## Non fa

- Il blocco con `$userRoles` (righe 64-79) è commentato e non attivo.
- Codice duplicato con `GetModulesNavigationItems`.
- Icona di default `question-mark` in `execute`, `cube` in `getCachedModuleConfigs`.
