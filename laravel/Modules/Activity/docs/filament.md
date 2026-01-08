https://laraveldaily.com/post/filament-activity-logs-three-packages-comparison-review

---

[Link risorsa originale _docs]
https://laraveldaily.com/post/filament-activity-logs-three-packages-comparison-review

# Filament nel Modulo Activity

## Riferimenti
- [Confronto tra pacchetti di activity log](https://laraveldaily.com/post/filament-activity-logs-three-packages-comparison-review)

## Documentazione

1. [Errori Comuni](filament-errors.md) - Documentazione degli errori comuni e delle loro soluzioni
2. [Struttura delle Risorse](structure.md#filament-resources) - Come sono strutturate le risorse Filament
3. [Best Practices](filament-errors.md#best-practices) - Best practices per lo sviluppo con Filament

## Risorse

- ActivityResource - Gestione delle attività degli utenti
- SnapshotResource - Gestione degli snapshot di stato
- ActivityLogResource - Log dettagliati delle attività

## Widgets

- ActivityOverviewWidget - Panoramica generale delle attività
- RecentActivitiesWidget - Attività recenti
- ActivityStatsWidget - Statistiche delle attività

## Note Importanti

- Seguire sempre le best practices documentate
- Consultare la documentazione degli errori prima di fare modifiche
- Mantenere aggiornata la documentazione con nuovi errori o soluzioni
- Assicurarsi che tutte le modifiche siano compatibili con PHPStan livello 10
- Documentare eventuali breaking changes
- Mantenere la retrocompatibilità quando possibile

## Integrazione Filament + Event Sourcing

- Le dashboard Filament possono consumare proiezioni generate da projectors event sourcing
- È possibile mostrare sia dati da activity_log che da viste aggregate/event sourced
- Consigliato separare resource Filament legacy e resource basate su proiezioni
- Vedi [ACTIVITY_EVENT_SOURCING_BEST_PRACTICES.mdc](../../.cursor/rules/ACTIVITY_EVENT_SOURCING_BEST_PRACTICES.mdc)
