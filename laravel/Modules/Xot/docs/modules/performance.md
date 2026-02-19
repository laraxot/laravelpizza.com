# Modulo Performance

## Descrizione

Il modulo Performance gestisce le valutazioni delle performance e la distribuzione dei fondi incentivanti per i dipendenti. Implementa algoritmi di calcolo complessi per la quota teorica, la quota effettiva e la ridistribuzione dei resti.

## Documentazione Specifica

Il modulo Performance mantiene documentazione dettagliata nelle seguenti aree:

- [Struttura e Funzionamento Generale](../performance/docs/readme.md)
- [Struttura e Funzionamento Generale](../performance/docs/readme.md)
- [Modelli](../performance/docs/models.md)
- [Flusso di Calcolo Performance Organizzativa](../performance/docs/organizzativa-flow.md)
- [Modelli Performance Organizzativa](../performance/docs/organizzativa-models.md)
- [Raccomandazioni PHPStan](../performance/docs/organizzativa-phpstan-recommendations.md)
- [Raw SQL vs Eloquent](../performance/docs/raw-vs-eloquent.md)
- [Redistribuzione Resti per Valutatore](../performance/docs/redistribuire-resti-per-valutatore.md)
- [Convenzioni del Modulo](../performance/docs/convenzioni-modulo.md)

## Risorse Filament

Il modulo implementa diverse risorse Filament per la gestione delle performance:

- PerformanceFondoResource: Gestione del fondo incentivante
- OrganizzativaResource: Gestione della performance organizzativa

## Recenti Aggiornamenti

### Maggio 2025
- Implementata nuova strategia di ridistribuzione dei resti basata sul valutatore_id
- Migliorata la documentazione per convenzioni di naming e implementazione
- Analisi di compatibilità con PHPStan livello 9-10

## Collegamenti alle Linee Guida Generali

- [Convenzioni di Namespace](../xot/docs/namespace-conventions.md)
- [Convenzioni di Naming](../xot/docs/naming-conventions.md)
- [Guide PHPStan Livello 9](../xot/docs/phpstan-level9-guide.md)
- [QueueableActions](../xot/docs/queueable-actions.md)
