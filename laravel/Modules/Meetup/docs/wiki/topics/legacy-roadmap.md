---
title: "Topic legacy-roadmap"
type: digest
status: active
qmd: "digest ceiling 100 legacy-roadmap"
---

# Topic legacy-roadmap

Sintesi automatica di 3 documenti (chiave `legacy-roadmap`).

## Roadmap Modulo Meetup - [DATE]

_Fonte: `roadmap/legacy/legacy-roadmap-old-a.md`_

# Roadmap Modulo Meetup - [DATE]

**Modulo**: Meetup (Core Business Logic)
**Scopo**: Core business logic per piattaforma meetup LaravelPizza - gestione eventi, registrazioni RSVP, calendario, profili speaker, community.
**Stato Generale**: 60%
**PHPStan Level 10**: 0 errori (0 suppressioni inline in app/)
**File PHP**: 21 in app/
**Test Files**: 0
**Documentazione**: 126 docs

---

## Tasks

| # | Task | File | Priorita' | % |
|---|------|------|-----------|---|
| 1 | Creare test suite completa | [task-creare-test-suite.md](task-creare-test-suite.md) | Critica | 0% |
| 2 | Implementare sistema eventi completo | [task-sistema-eventi.md](task-sistema-eventi.md) | Alta | 40% |
| 3 | Implementare registrazione RSVP | [task-registrazione-rsvp.md](task-registrazione-rsvp.md) | Alta | 20% |
| 4 | Implementare profili speaker | [task-profili-speaker.md](task-profili-speaker.md) | Media | 10% |
| 5 | Integrazione calendario | [task-integrazione-calendario.md](task-integrazione-calendario.md) | Media | 0% |

---

## Note

- Modulo pulito (0 suppressioni PHPStan) ma piccolo (21 file PHP)
- ZERO test: priorita' critica
- E' il modulo business core - necessita piu' sviluppo
- Deve integrarsi con tema Meetup per frontend

## Meetup Module - Event Management Roadmap

_Fonte: `roadmap/legacy/legacy-roadmap-old-b.md`_

# Meetup Module - Event Management Roadmap

**Status**: 🟡 In Progress (75% Completato)
**Priorità**: Alta
**Obiettivo**: 100% completamento con calendar widget, registration e analytics

---

## 📊 Stato Attuale

### Completamento Globale: **75%**

| Componente | Completamento | Stato |
|-----------|--------------|-------|
| Event Creation & Management | 100% | ✅ |
| Event Status Tracking | 100% | ✅ |
| Attendee Management | 100% | ✅ |
| Location Tracking | 100% | ✅ |
| Event Metadata Support | 100% | ✅ |
| Event Sourcing Capabilities | 100% | ✅ |
| Filament Integration | 100% | ✅ |
| Event Registration System | 70% | 🔄 |
| Calendar Widget | 0% | ❌ |
| Event Reminders | 0% | ❌ |
| Event Analytics | 0% | ❌ |
| PHPStan Level 10 | N/A | 🟡 |
| Test Coverage | N/A | ❌ |

---

## Roadmap Meetup

_Fonte: `roadmap/legacy-roadmap.md`_

# Roadmap Meetup

Roadmap operativo del module **Meetup**, suddiviso in file tematici.

## Indice

- 00-index
- 01-current-state
- 02-goals
- 03-workstreams
- 04-milestones
- 05-risks

## Regola

Aggiornare prima i file in `docs/roadmap/`, poi questo indice se cambia la struttura.
