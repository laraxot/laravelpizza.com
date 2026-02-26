# Modulo Performance

## Descrizione

Il modulo Performance gestisce le valutazioni delle performance e la distribuzione dei fondi incentivanti per i dipendenti. Implementa algoritmi di calcolo complessi per la quota teorica, la quota effettiva e la ridistribuzione dei resti.

## Documentazione Specifica

Il modulo Performance mantiene documentazione dettagliata nelle seguenti aree:

- [Struttura e Funzionamento Generale](/var/www/html/_bases/base_ptvx_fila3_mono/laravel/Modules/Performance/project_docs/readme.md)
- [Struttura e Funzionamento Generale](/var/www/html/_bases/base_ptvx_fila3_mono/laravel/Modules/Performance/project_docs/README.md)
- [Modelli](/var/www/html/_bases/base_ptvx_fila3_mono/laravel/Modules/Performance/project_docs/models.md)
- [Flusso di Calcolo Performance Organizzativa](/var/www/html/_bases/base_ptvx_fila3_mono/laravel/Modules/Performance/project_docs/organizzativa-flow.md)
- [Modelli Performance Organizzativa](/var/www/html/_bases/base_ptvx_fila3_mono/laravel/Modules/Performance/project_docs/organizzativa-models.md)
- [Raccomandazioni PHPStan](/var/www/html/_bases/base_ptvx_fila3_mono/laravel/Modules/Performance/project_docs/organizzativa-phpstan-recommendations.md)
- [Raw SQL vs Eloquent](/var/www/html/_bases/base_ptvx_fila3_mono/laravel/Modules/Performance/project_docs/raw-vs-eloquent.md)
- [Redistribuzione Resti per Valutatore](/var/www/html/_bases/base_ptvx_fila3_mono/laravel/Modules/Performance/project_docs/redistribuire-resti-per-valutatore.md)
- [Convenzioni del Modulo](/var/www/html/_bases/base_ptvx_fila3_mono/laravel/Modules/Performance/project_docs/convenzioni-modulo.md)

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

- [Convenzioni di Namespace](/var/www/html/_bases/base_ptvx_fila3_mono/laravel/Modules/Xot/project_docs/NAMESPACE-CONVENTIONS.md)
- [Convenzioni di Naming](/var/www/html/_bases/base_ptvx_fila3_mono/laravel/Modules/Xot/project_docs/naming-conventions.md)
- [Guide PHPStan Livello 9](/var/www/html/_bases/base_ptvx_fila3_mono/laravel/Modules/Xot/project_docs/PHPSTAN-LEVEL9-GUIDE.md)
- [QueueableActions](/var/www/html/_bases/base_ptvx_fila3_mono/laravel/Modules/Xot/project_docs/queueable-actions.md)
