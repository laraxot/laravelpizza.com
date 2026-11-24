---
<<<<<<< .merge_file_J7kdB9
<<<<<<< .merge_file_7iZyKM
<<<<<<< .merge_file_bHBgIx
title: "Activity — BMAD Setup Guide"
=======
=======
>>>>>>> .merge_file_2mUGPb
=======
>>>>>>> .merge_file_Db0DgN
<<<<<<< HEAD
title: "Activity: BMAD Setup Guide"
=======
<<<<<<< HEAD
title: "Activity — BMAD Setup Guide"
=======
title: "Activity: BMAD Setup Guide"
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_J7kdB9
<<<<<<< .merge_file_7iZyKM
>>>>>>> .merge_file_npZoSW
=======
>>>>>>> .merge_file_2mUGPb
=======
>>>>>>> .merge_file_Db0DgN
description: "Setup e configurazione BMAD per il modulo Activity"
module: "Activity"
alias: "activity"
documentation_date: "2026-05-27"
bmad_version: "6.2.0"
<<<<<<< .merge_file_J7kdB9
<<<<<<< .merge_file_7iZyKM
<<<<<<< .merge_file_bHBgIx
---

# Activity — BMAD Setup Guide
=======
=======
>>>>>>> .merge_file_2mUGPb
=======
>>>>>>> .merge_file_Db0DgN
<<<<<<< HEAD
type: note
=======
<<<<<<< HEAD
<<<<<<< HEAD
---

# Activity — BMAD Setup Guide
=======
<<<<<<< .merge_file_J7kdB9
<<<<<<< .merge_file_7iZyKM
type: note
>>>>>>> laraxot/dev
=======
type: note
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> .merge_file_npZoSW
=======
type: note
>>>>>>> laraxot/dev
=======
type: note
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> .merge_file_2mUGPb
=======
type: note
>>>>>>> laraxot/dev
=======
type: note
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> .merge_file_Db0DgN
status: draft
updated: 2026-10-07
tags: [docs, activity, bmad]
qmd: "activity   bmad setup guide activity"
---

# Activity: BMAD Setup Guide

## Scopo

Rendere ripetibile e verificabile l'uso del BMAD Method per il modulo Activity.

## Cosa è "BMAD" qui (Business Logic)

In questo modulo, BMAD serve a:
- **Tracciare ogni decisione**: ogni azione utente viene registrata
- **Abilitare il debug**: ricostruire sequenza di eventi
- **Supportare il code review**: chi ha fatto cosa e quando
- **Abilitare il retrospective**: analisi di cosa è andato bene

## Best Practices (Pratiche Giuste)

- Documentare prima di implementare: PRD prima di codice
- Estendere XotBase: modelli da `XotBaseModel`
- Actions, non Services: logica in `Actions/`
- PHPStan Level 10: nessun ignoreErrors
- Traduzioni dai file: mai hardcoded

<<<<<<< .merge_file_J7kdB9
<<<<<<< .merge_file_7iZyKM
<<<<<<< .merge_file_bHBgIx
## Bad Practices (Pratiche Sbagliate — Mai Fare)
=======
<<<<<<< HEAD
## Bad Practices (Pratiche Sbagliate: Mai Fare)
=======
<<<<<<< HEAD
<<<<<<< HEAD
## Bad Practices (Pratiche Sbagliate — Mai Fare)
=======
## Bad Practices (Pratiche Sbagliate: Mai Fare)
>>>>>>> laraxot/dev
=======
## Bad Practices (Pratiche Sbagliate: Mai Fare)
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> .merge_file_npZoSW
=======
=======
>>>>>>> .merge_file_Db0DgN
<<<<<<< HEAD
## Bad Practices (Pratiche Sbagliate: Mai Fare)
=======
<<<<<<< HEAD
<<<<<<< HEAD
## Bad Practices (Pratiche Sbagliate — Mai Fare)
=======
## Bad Practices (Pratiche Sbagliate: Mai Fare)
>>>>>>> laraxot/dev
=======
## Bad Practices (Pratiche Sbagliate: Mai Fare)
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_J7kdB9
>>>>>>> .merge_file_2mUGPb
=======
>>>>>>> .merge_file_Db0DgN

- Mai estendere Filament direttamente
- Mai silenziare PHPStan
- Mai hardcode label
- Mai creare Services
- Mai modificare `phpstan.neon`

## False Friends (Falsi Amici)

| Termine | Sembra Significare | In Realtà Significa |
|---|---|---|
| **Action** | Funzione generica | Classe con `execute()` che estende `QueueableAction` |
<<<<<<< .merge_file_J7kdB9
<<<<<<< .merge_file_7iZyKM
<<<<<<< .merge_file_bHBgIx
| **Service** | Servizio generico | **Vietato** in Xot — usare `Actions` |
=======
=======
>>>>>>> .merge_file_2mUGPb
=======
>>>>>>> .merge_file_Db0DgN
<<<<<<< HEAD
| **Service** | Servizio generico | **Vietato** in Xot: usare `Actions` |
=======
<<<<<<< HEAD
<<<<<<< HEAD
| **Service** | Servizio generico | **Vietato** in Xot — usare `Actions` |
=======
| **Service** | Servizio generico | **Vietato** in Xot: usare `Actions` |
>>>>>>> laraxot/dev
=======
| **Service** | Servizio generico | **Vietato** in Xot: usare `Actions` |
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_J7kdB9
<<<<<<< .merge_file_7iZyKM
>>>>>>> .merge_file_npZoSW
=======
>>>>>>> .merge_file_2mUGPb
=======
>>>>>>> .merge_file_Db0DgN
| **Module/Modulo** | Pacchetto generico | Modulo con `module.json`, `XotBaseServiceProvider` |
| **Resource** | Risorsa generica | `XotBaseResource` con `form()`, `table()` |

## Struttura Directory (Canonical)

- **`_bmad/`**: moduli/agent/skills + configurazione
- **`_bmad-output/`**: artefatti generati
- **`docs/bmad/`**: questa documentazione

---

<<<<<<< .merge_file_J7kdB9
<<<<<<< .merge_file_7iZyKM
<<<<<<< .merge_file_bHBgIx
*Activity · BMAD Setup Guide · data 2026-05-27*
=======
=======
>>>>>>> .merge_file_2mUGPb
=======
>>>>>>> .merge_file_Db0DgN
<<<<<<< HEAD
*Activity · BMAD Setup Guide · data 2026-05-27*
=======
<<<<<<< HEAD
*Activity · BMAD Setup Guide · data 2026-05-27*
=======
*Activity · BMAD Setup Guide · data 2026-05-27*
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_J7kdB9
<<<<<<< .merge_file_7iZyKM
>>>>>>> .merge_file_npZoSW
=======
>>>>>>> .merge_file_2mUGPb
=======
>>>>>>> .merge_file_Db0DgN
