---
title: "GetPanelsNavigationItems — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Filament\\GetPanelsNavigationItems"
qmd: "GetPanelsNavigationItems voci navigazione pannelli Filament canAccessPanel PanelModuleAdapter gruppo Modules"
---

# GetPanelsNavigationItems

Costruisce una voce di navigazione per ogni pannello Filament registrato.

Codice: `app/Actions/Filament/GetPanelsNavigationItems.php:17-48`.

## Input

- Nessun input.

## Output

`array<int, NavigationItem>`, una voce per pannello.

## Invarianti

- `FIL-NAVPANEL-INV-1`: una voce per ogni pannello restituito da `Filament::getPanels()` (righe 28-44). Test: Nessun test dedicato.
- `FIL-NAVPANEL-INV-2`: la voce è visibile solo se l'utente è autenticato e `canAccessPanel($panel)` è vero; utente nullo → non visibile (righe 38-42). Test: Nessun test dedicato.

## Effetti collaterali

Nessuno.

## Errori

Nessuna eccezione propria; se l'utente non ha `canAccessPanel` la valutazione della visibilità lancia `Error`.

## Non fa

- Presuppone che l'utente implementi `FilamentUser`.
- Icona, etichetta e ordinamento arrivano da `PanelModuleAdapter` (fuori perimetro).
