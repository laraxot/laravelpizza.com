# Fasi di Sviluppo del Modulo Activity

## Fase 1 · Qualità e pulizia (in corso)

- PHPStan Level 10 come standard di riferimento per l’intero modulo.
- Rimozione graduale di file duplicati e obsoleti.
- Consolidamento della guida agli eventi di dominio e delle convenzioni di logging.
- Automazione nelle GitHub Actions per eseguire i controlli di qualità del modulo.

## Fase 2 · Enterprise UI (pianificata)

- Creazione di un **Cluster Observability** in Filament:
  - risorse per consultare gli activity log;
  - dashboard di performance e throughput;
  - pagina di security audit.
- Filtri avanzati per tipo di evento, modulo, utente, tenant.

## Fase 3 · Analytics evolute e AI (futura)

- Introduzione di **AI Anomaly Detection** sugli stream di attività.
- Integrazione con strumenti di analisi per monitoraggio proattivo delle operazioni critiche.
- Possibili notifiche automatiche verso il modulo Notify in caso di pattern sospetti.

Criteri di accettazione: [acceptance-criteria.md](acceptance-criteria.md). Metriche: [metrics.md](metrics.md).

