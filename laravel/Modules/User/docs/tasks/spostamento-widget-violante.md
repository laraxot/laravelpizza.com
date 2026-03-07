# Task: Spostamento Widget Violante

**Modulo**: User  
**Fase**: 1 - Correzione Violazioni Architetturali  
**Priorità**: Critica  
**Stima**: 2-3 ore

## Obiettivo

Spostare `UserTypeRegistrationsChartWidget` dal modulo User al modulo appropriato (es. healthcare_app). User non può dipendere da moduli business specifici.

## Sottotask

- [ ] Identificare widget `UserTypeRegistrationsChartWidget` e sue dipendenze
- [ ] Analizzare dove collocarlo (healthcare_app o altro modulo)
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
