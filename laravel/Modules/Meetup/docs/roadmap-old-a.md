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
