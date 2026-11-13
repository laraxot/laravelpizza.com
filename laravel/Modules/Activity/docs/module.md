---
title: "Activity Module — Doctrine"
type: doctrine
tags: [activity, audit, event-sourcing, module-doctrine]
created: 2026-09-05
updated: 2026-09-05
qmd: "Activity module doctrine BMAD analysis purpose religion philosophy policy why zen gap enhancements split merge"
related:
  - "../../Xot/docs/module.md"
  - "../../Tenant/docs/module.md"
<<<<<<< .merge_file_PUUCj1
---

# Activity Module — Doctrine

## Scope (Scopo)

Activity traccia attività e audit log con event sourcing, snapshotting. È il registratore infinito che cattura ogni azione significativa.

## Religion (Religione)

**"Ogni azione è registrata, ogni modifica è tracciata."** La convinzione non negoziabile è che il sistema non mente mai: tutto è loggato, tutto è ricostruibile, tutto è verificabile.

## Philosophy (Filosofia)

- **Spatie Activity Log**: tracciamento tradizionale
- **Spatie Event Sourcing**: eventi di dominio
- **CQRS-lite**: stato ricostruibile da eventi
- **Snapshotting**: ottimizzazione ricostruzione
- **Retention policies**: configurabili

## Policy (Politica)

- Ogni azione significativa loggata
- Contesto sufficiente catturato
- Supporto per logging tradizionale e event sourcing
- Snapshots periodici
- Retention configurabile

## Why (Perché)

Activity è una preoccupazione trasversale troppo complessa per essere distribuita. Un modulo dedicato garantisce coerenza.

## Zen

*"Un registratore infinito. Ogni azione catturata, ogni momento ricostruibile."*

## Gap

- Test integrazione event sourcing limitati
- Policies assenti
- Best practices per logging vs event sourcing
- Logiche di configurazione disperse
- Meccanismi archiviazione mancanti

## Add

- Policies per log attività
- Test integrazione workflow completi
- Servizi analisi (trend)
- Archiviazione automatica
- Dashboard interattiva

## Split/Merge

**Mantenere come-is.** Le preoccupazioni (activity, event sourcing) sono interconnesse. Separare sarebbe controproducente.

## Future Enhancements
=======
status: draft
---
>>>>>>> .merge_file_i4HZDQ

1. **Real-time audit dashboard**: visualizzazione live
2. **Compliance reporting**: report automatici
3. **Anomaly detection**: identificazione attività sospette
4. **Audit query API**: API per query
5. **Data retention automation**: archiviazione/eliminazione automatica
6. **User behavior analytics**: pattern di utilizzo
