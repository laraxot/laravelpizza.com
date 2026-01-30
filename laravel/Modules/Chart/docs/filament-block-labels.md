# Filament Block Label Guidelines

> Questo documento è un collegamento alla documentazione principale sulle convenzioni per le etichette nei Filament Blocks.

## Collegamenti

- [Convenzioni Namespace per Filament](../laravel/Modules/Cms/docs/convenzioni-namespace-filament.md) - Include le regole per le traduzioni nei Blocks Filament
- [Traduzioni nei Blocks](../laravel/Modules/Cms/docs/blocks/footer.md#label-translation) - Esempio di implementazione

## Regola Fondamentale

Non devono essere presenti chiamate a `->label()` all'interno dei Blocks Filament; tutte le etichette vengono caricate tramite il LangServiceProvider e i file di traduzione del modulo.

Per maggiori dettagli e best practices, consultare la documentazione completa nel modulo Cms.
