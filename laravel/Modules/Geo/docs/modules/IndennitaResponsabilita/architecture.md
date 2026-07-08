# Architettura del modulo `IndennitaResponsabilita`

## Panoramica
Il modulo `IndennitaResponsabilita` implementa la logica di calcolo e gestione delle indennità di responsabilità per i dipendenti. L'architettura è pensata per:

- **Modularità**: separare le responsabilità in layer ben distinti.
- **Riutilizzabilità**: condividere logica comune tramite traits e scope Eloquent.
- **Manutenibilità**: documentare regole, pattern e convenzioni (DRY + KISS).

## Struttura dei file

```
laravel/
 └─ Modules/
     └─ IndennitaResponsabilita/
         ├─ app/
         │   └─ Models/
         │       ├─ Traits/
         │       │   ├─ Relationships/
         │       │   │   └─ EnteMatrRelationship.php
         │       │   └─ Scopes/
         │       │       └─ CommonScope.php
         │       └─ IndennitaResponsabilita.php
         ├─ Http/
         │   └─ Controllers/
         ├─ Resources/
         │   └─ Views/
         ├─ database/
         │   └─ migrations/
         └─ docs/
             └─ concepts/
                 ├─ relationship-patterns.md
                 └─ architecture-overview.md
```

## Principi chiave

| Principio | Descrizione | Implementazione |
|-----------|-------------|-----------------|
| **DRY + KISS** | Evitare duplicazioni e mantenere il codice semplice. | Centralizzare logiche di relazione (`qua00f*`, `rep00f*`) in traits e scope. |
| **Single Source of Truth** | Tutti i nomi di campi e regole devono trovarsi in un unico punto. | Interfacce `SigmaEnteMatrFields` e `SigmaDateRangeFields` definiscono i contratti. |
| **Explicit over Implicit** | I metodi devono avere nomi auto‑descrittivi. | `qua00fDateRange()` invece di `qua00fRetribuzioneDateRange()`. |
| **Separazione delle preoccupazioni** | Logica di accesso dati, business rule e presentazione sono separati. | Model → Trait → Scope → Controller/Action. |

## Documentazione correlata

- `docs/wiki/concepts/relationship-patterns.md` – schemi di relazione tra modelli.
- `docs/wiki/rules/00-TRIGGER_MAP.md` – mappa dei trigger di evento.
- `docs/wiki/how-to/github-issue-agent-discipline.md` – disciplina degli issue‑agent.

## Regole di naming dei metodi di relazione

1. **Preferire suffissi descrittivi** (`DateRange`, `ByYear`, `Simple`).  
2. **Evitare ridondanze** (`Retribuzione` è implicito quando si lavora con `qua00f`).  
3. **Consistenza di caso**: usare `camelCase` per metodi pubblici, `snake_case` solo per proprietà.

## Buone pratiche di refactoring

- **Rimuovere duplicate** di `whereRaw` usando scope o traits.  
- **Evitare proprietà “magic”**: usa metodi getter/setter con naming chiaro.  
- **Documentare ogni nuovo scope/trait** in `docs/wiki/relationship-patterns.md`.  

---  

*Document updated on 2025‑11‑03.*  