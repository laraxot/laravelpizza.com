# Task: Spostamento Widget Violante

**Modulo**: User  
**Fase**: 1 - Correzione Violazioni Architetturali  
**Priorità**: Critica  
**Stima**: 2-3 ore

## Obiettivo

<<<<<<< .merge_file_k9YHn2
Spostare `UserTypeRegistrationsChartWidget` dal modulo User al modulo appropriato (es. healthcare_app). User non può dipendere da moduli business specifici.
=======
<<<<<<< HEAD
Spostare `UserTypeRegistrationsChartWidget` dal modulo User al modulo appropriato (es. ExternalProject). User non può dipendere da moduli business specifici.
=======
Spostare `UserTypeRegistrationsChartWidget` dal modulo User al modulo appropriato (es. ModuloEsempio). User non può dipendere da moduli business specifici.
>>>>>>> f04e1ab44 (refactor: update project references from Quaeris to PTVX)
>>>>>>> .merge_file_hk8a2J

## Sottotask

- [ ] Identificare widget `UserTypeRegistrationsChartWidget` e sue dipendenze
<<<<<<< .merge_file_k9YHn2
- [ ] Analizzare dove collocarlo (healthcare_app o altro modulo)
=======
<<<<<<< HEAD
- [ ] Analizzare dove collocarlo (ExternalProject o altro modulo)
=======
- [ ] Analizzare dove collocarlo (ModuloEsempio o altro modulo)
>>>>>>> f04e1ab44 (refactor: update project references from Quaeris to PTVX)
>>>>>>> .merge_file_hk8a2J
- [ ] Spostare widget e aggiornare namespace
- [ ] Rimuovere file originale da User
- [ ] Verificare con script controllo dipendenze
- [ ] Test di regressione
- [ ] Aggiornare documentazione

## Dipendenze

Nessuna.

## Collegamenti

- [Roadmap User](../roadmap.md)
- [Indice task User](tasks-index.md)
- [Modular Architecture Dependency Rules](../../cms/docs/modular-architecture-dependency-rules.md)
