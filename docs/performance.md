# Modulo Performance

## Descrizione

Il modulo Performance gestisce le valutazioni delle performance e la distribuzione dei fondi incentivanti per i dipendenti. Implementa algoritmi di calcolo complessi per la quota teorica, la quota effettiva e la ridistribuzione dei resti.

## Documentazione Specifica

Il modulo Performance mantiene documentazione dettagliata nelle seguenti aree:

- [Struttura e Funzionamento Generale](laravel/modules/performance/project_docs/readme.md)
- [Struttura e Funzionamento Generale](laravel/modules/performance/project_docs/readme.md)
- [Modelli](laravel/modules/performance/project_docs/models.md)
- [Flusso di Calcolo Performance Organizzativa](laravel/modules/performance/project_docs/organizzativa-flow.md)
- [Modelli Performance Organizzativa](laravel/modules/performance/project_docs/organizzativa-models.md)
- [Raccomandazioni PHPStan](laravel/modules/performance/project_docs/organizzativa-phpstan-recommendations.md)
- [Raw SQL vs Eloquent](laravel/modules/performance/project_docs/raw-vs-eloquent.md)
- [Redistribuzione Resti per Valutatore](laravel/modules/performance/project_docs/redistribuire-resti-per-valutatore.md)
- [Convenzioni del Modulo](laravel/modules/performance/project_docs/convenzioni-modulo.md)

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

- [Convenzioni di Namespace](laravel/modules/xot/project_docs/namespace-conventions.md)
- [Convenzioni di Naming](laravel/modules/xot/project_docs/naming-conventions.md)
- [Guide PHPStan Livello 9](laravel/modules/xot/project_docs/phpstan-level9-guide.md)
- [QueueableActions](laravel/modules/xot/project_docs/queueable-actions.md)
