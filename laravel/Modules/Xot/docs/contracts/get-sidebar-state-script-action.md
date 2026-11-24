---
title: "GetSidebarStateScriptAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Filament\\GetSidebarStateScriptAction"
qmd: "GetSidebarStateScriptAction script sidebar Filament localStorage collapsed_groups null primo accesso"
---

# GetSidebarStateScriptAction

Restituisce lo snippet JavaScript che inizializza lo stato dei gruppi della sidebar Filament nel localStorage.

Codice: `app/Actions/Filament/GetSidebarStateScriptAction.php:18-40`.

## Input

- Nessuno.

## Output

`string`: blocco `<script>`.

## Invarianti

- `FIL-SIDEBAR-INV-1`: lo script scrive `[]` nella chiave `filament:sidebar:collapsed_groups` solo se manca o vale `null` (righe 28-31); le preferenze salvate non sono toccate. Test: Nessun test dedicato.
- `FIL-SIDEBAR-INV-2`: un errore di accesso a localStorage è ignorato (righe 32-35). Test: Nessun test dedicato.

## Effetti collaterali

Nessuno lato server: lo script è eseguito dal browser.

## Errori

Nessuna eccezione lato server.

## Non fa

- Dipende dalla chiave interna dello store `sidebar` di Filament 5.10.3 (citata nel docblock).
