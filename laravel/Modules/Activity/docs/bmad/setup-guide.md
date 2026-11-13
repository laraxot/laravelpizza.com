---
<<<<<<< .merge_file_xtuaax
title: "Activity — BMAD Setup Guide"
=======
title: "Activity: BMAD Setup Guide"
>>>>>>> .merge_file_WSoz6o
description: "Setup e configurazione BMAD per il modulo Activity"
module: "Activity"
alias: "activity"
documentation_date: "2026-05-27"
bmad_version: "6.2.0"
<<<<<<< .merge_file_xtuaax
---

# Activity — BMAD Setup Guide
=======
type: note
status: draft
updated: 2026-10-07
tags: [docs, activity, bmad]
qmd: "activity   bmad setup guide activity"
---

# Activity: BMAD Setup Guide
>>>>>>> .merge_file_WSoz6o

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

<<<<<<< .merge_file_xtuaax
## Bad Practices (Pratiche Sbagliate — Mai Fare)
=======
## Bad Practices (Pratiche Sbagliate: Mai Fare)
>>>>>>> .merge_file_WSoz6o

- Mai estendere Filament direttamente
- Mai silenziare PHPStan
- Mai hardcode label
- Mai creare Services
- Mai modificare `phpstan.neon`

## False Friends (Falsi Amici)

| Termine | Sembra Significare | In Realtà Significa |
|---|---|---|
| **Action** | Funzione generica | Classe con `execute()` che estende `QueueableAction` |
<<<<<<< .merge_file_xtuaax
| **Service** | Servizio generico | **Vietato** in Xot — usare `Actions` |
=======
| **Service** | Servizio generico | **Vietato** in Xot: usare `Actions` |
>>>>>>> .merge_file_WSoz6o
| **Module/Modulo** | Pacchetto generico | Modulo con `module.json`, `XotBaseServiceProvider` |
| **Resource** | Risorsa generica | `XotBaseResource` con `form()`, `table()` |

## Struttura Directory (Canonical)

- **`_bmad/`**: moduli/agent/skills + configurazione
- **`_bmad-output/`**: artefatti generati
- **`docs/bmad/`**: questa documentazione

---

*Activity · BMAD Setup Guide · data 2026-05-27*