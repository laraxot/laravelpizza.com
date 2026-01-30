# Linee Guida per la Risoluzione dei Conflitti Git

## Panoramica

Questo documento definisce le linee guida standard per la risoluzione dei conflitti Git nel progetto. Seguire queste regole garantisce coerenza, tracciabilità e qualità del codice.

## Regole Fondamentali

1. **Un conflitto alla volta**: Risolvere sempre un conflitto alla volta, mai in blocco
2. **Studio della documentazione**: Prima di risolvere un conflitto, studiare la documentazione più vicina al file
3. **Focus sullo scopo funzionale**: Concentrarsi sullo scopo del codice, non solo sulla sintassi
4. **Aggiornamento documentazione**: Aggiornare la documentazione prima/durante/dopo la risoluzione
5. **Collegamenti bidirezionali**: Mantenere aggiornati i collegamenti tra docs root e docs locali

## Procedura Standard

1. **Identificazione**: Individuare i file con marker di conflitto
2. **Analisi**: Studiare la documentazione locale e nella root
3. **Documentazione**: Aggiornare la documentazione locale con la soluzione proposta
4. **Implementazione**: Risolvere il conflitto mantenendo la versione più coerente
5. **Test**: Verificare che la soluzione funzioni correttamente
6. **Aggiornamento docs root**: Aggiornare i collegamenti nella documentazione root

## Strumenti Utili


## Collegamenti ad Altri Documenti

- [Convenzioni di Naming](./convenzioni-naming-campi.md)
- [Struttura Moduli](./implementazione/struttura_moduli.md)
- [Regole Documentazione](./regole-documentazione.md)

# Risoluzione Conflitti Git

> **Nota**: Per una versione più aggiornata e dettagliata di questa documentazione, consulta [Git Subtree Conflicts in Bashscripts](../bashscripts/docs/git_subtree_conflicts.md)

## Collegamenti tra versioni di risoluzione_conflitti_git.md
* [git_subtree_conflicts.md](../bashscripts/docs/git_subtree_conflicts.md)
* [risoluzione_conflitti_git.md](risoluzione_conflitti_git.md)

## [AGGIORNAMENTO 2024-xx-xx] Risoluzione conflitto in Modules/Tenant/app/Models/Tenant.php

- **Descrizione**: Conflitto tra due versioni delle relazioni `patients()` e `appointments()`, una puntava ai moduli `Patient` e `Dental`, l'altra a `<nome progetto>`.
- **Soluzione**: È stata mantenuta la versione che utilizza i moduli `Patient` e `Dental` per garantire la separazione delle responsabilità e la compatibilità con PHPStan livello 10.
- **Motivazione**: Modularità, chiarezza architetturale e riduzione delle dipendenze non necessarie.
- **Dettagli e motivazioni**: Vedi la [documentazione locale del modulo Tenant](../../laravel/Modules/Tenant/docs/risoluzione_conflitti.md).
