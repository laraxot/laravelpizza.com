# Modulo Performance

## Descrizione

Il modulo Performance gestisce le valutazioni delle performance e la distribuzione dei fondi incentivanti per i dipendenti. Implementa algoritmi di calcolo complessi per la quota teorica, la quota effettiva e la ridistribuzione dei resti.

## Documentazione Specifica

Il modulo Performance mantiene documentazione dettagliata nelle seguenti aree:

- [Struttura e Funzionamento Generale](../Performance/docs/readme.md)
- [Struttura e Funzionamento Generale](../Performance/docs/README.md)
- [Modelli](../Performance/docs/models.md)
- [Flusso di Calcolo Performance Organizzativa](../Performance/docs/organizzativa-flow.md)
- [Modelli Performance Organizzativa](../Performance/docs/organizzativa-models.md)
- [Raccomandazioni PHPStan](../Performance/docs/organizzativa-phpstan-recommendations.md)
- [Raw SQL vs Eloquent](../Performance/docs/raw-vs-eloquent.md)
- [Redistribuzione Resti per Valutatore](../Performance/docs/redistribuire-resti-per-valutatore.md)
- [Convenzioni del Modulo](../Performance/docs/convenzioni-modulo.md)

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

- [Convenzioni di Namespace](../Xot/docs/NAMESPACE-CONVENTIONS.md)
- [Convenzioni di Naming](../Xot/docs/naming-conventions.md)
- [Guide PHPStan Livello 9](../Xot/docs/PHPSTAN-LEVEL9-GUIDE.md)
- [QueueableActions](../Xot/docs/queueable-actions.md)
