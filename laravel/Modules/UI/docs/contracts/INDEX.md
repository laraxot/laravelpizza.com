---
<<<<<<< .merge_file_OiQuGO
<<<<<<< HEAD
=======
>>>>>>> .merge_file_Kwovhu
title: "INDEX — UI"
type: index
status: active
created: 2026-11-23
updated: 2026-11-23
decision-makers: []
---

<!-- File: docs/contracts/INDEX.md · formato MADR breve. -->

# <!-- Titolo: indice operativo UI -->

Elenco operativo dei contract comportamentali del modulo UI.

| Operazione | Contract | Classe | Invarianti |
|---|---|---|---|
| — | Nessun contract comportamentale audit-ato nel modulo UI. | — | — |

<<<<<<< .merge_file_OiQuGO
(End of file - total 16 lines)
=======
title: "INDEX contratti — UI"
type: index
owner: UI
updated: 2026-11-24
qmd: "UI contract INDEX backlog Action presentazione"
---

# INDEX contratti — UI

| Operazione | Contract | Classe | Invarianti | Copertura | Comando |
|---|---|---|---|---|---|
| — | Nessun contract formale (vedi [README](README.md)) | — | — | — | — |

Verifica: `rg -n "group\('UI-" laravel/Modules/UI/tests` (2026-11-24): nessun risultato, coerente con l'assenza di contract.

## Backlog contract

Action da rivalutare per prime se cambiano comportamento (nessuna oggi è ad alto rischio in scrittura; `laravel/Modules/UI/app/Actions/`):

- `GetUserDataAction.php`: espone ruolo e permessi dell'utente corrente (dati personali) all'interfaccia; contract `presentation` o `Action` se la superficie cresce.
- `Block/ResolveLocalizedBlockDataAction.php`: delega a `Modules\Cms\Actions\ResolveLocalizedBlockDataAction` se esiste (confine tra moduli).
- `Panel/ApplyCalendarToPanelAction.php`: docblock "temporaneamente disabilitato" per la migrazione Filament; da non documentare finché il comportamento non è stabile.

Totale Action in `app/Actions`: 6 file `.php` (`Block/GetAllBlocksAction`, `Block/ResolveLocalizedBlockDataAction`, `Datetime/GetDaysMappingAction`, `GetUserDataAction`, `Icon/GetAllIconsAction`, `Panel/ApplyCalendarToPanelAction`). Contract formali: 0.
>>>>>>> laraxot/dev
=======
(End of file - total 16 lines)
>>>>>>> .merge_file_Kwovhu
