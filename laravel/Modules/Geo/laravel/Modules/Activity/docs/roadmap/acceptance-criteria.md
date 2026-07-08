# Criteri di accettazione Modulo Activity

Criteri verificabili per le fasi della roadmap Activity (audit trail e observability).

---

## Fase 1 · Qualità e pulizia (in corso)

- [ ] PHPStan Level 10 su tutto il modulo; nessun errore.
- [ ] Inventario file obsoleti/duplicati completato; rimozione pianificata o eseguita secondo documento di cleanup.
- [ ] GitHub Actions (o CI) eseguono analisi PHPStan sul modulo Activity e falliscono in caso di errori.
- [ ] Guida agli eventi di dominio (quali eventi si loggano, convenzioni di naming) documentata in `docs/`.
- [ ] Migrazioni `activity_log` (o equivalenti) allineate a XotBaseMigration; riferimento a [Xot migrations-consolidated](../Xot/docs/migrations-consolidated.md) verificato.

## Fase 2 · Enterprise UI (pianificata)

- [ ] Cluster Observability in Filament: risorsa per consultare gli activity log con filtri (tipo, modulo, utente, tenant, intervallo date).
- [ ] Dashboard di performance (throughput eventi, latenza scrittura) almeno in ambiente admin.
- [ ] Pagina Security Audit (accessi, azioni sensibili) con export o link a dettaglio.

## Fase 3 · Analytics e AI (futura)

- [ ] Integrazione AI Anomaly Detection: identificazione pattern anomali sugli stream di attività (configurabile, non obbligatoria).
- [ ] Integrazione con strumenti di analisi esterni o notifiche verso modulo Notify in caso di eventi sospetti; documentata in `docs/`.

---

Metriche: [metrics.md](metrics.md). Dipendenze: [dependencies.md](dependencies.md).
