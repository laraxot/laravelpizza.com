# Roadmap Modulo Activity

## 🎯 Visione
Evolvere il sistema di audit trail e logging verso un'analisi proattiva (AI-driven) e una visualizzazione dei dati granulare ed efficiente, mantenendo la conformità nativa a PHPStan Level 10.

## 🏗️ Fasi di Sviluppo

### Fase 1: Qualità e Pulizia (In Corso)
- [x] PHPStan Level 10 Compliance (Modulo di Riferimento).
- [ ] Rimozione sistematica dei file duplicati e obsoleti.
- [ ] Automazione delle GitHub Actions per il controllo qualità.
- [ ] Consolidamento della guida agli eventi di dominio.

### Fase 2: Enterprise UI (Pianificato)
- [ ] Implementazione del **Cluster Observability** per Filament:
    - Risorsa per gli Activity Logs.
    - Dashboard di performance.
    - Pagina di Security Audit.

### Fase 3: Analytics Evolute e AI (Futuro)
- [ ] **AI Anomaly Detection**: Identificazione automatica di pattern anomali o accessi sospetti.
- [ ] Integrazione con strumenti di analisi per monitoraggio proattivo delle operazioni critiche.

## ✅ Checklist Qualità
- [x] PHPStan Level 10.
- [ ] Copertura Test (Pest) > 90%.
- [ ] Documentazione centralizzata in `docs/`.
- [ ] Zero Static Access (dove possibile).
- [x] Migrazioni activity_log allineate a XotBaseMigration (vedi [standard migrazioni](../Xot/docs/migrations-consolidated.md)).
