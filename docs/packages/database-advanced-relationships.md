# Relazioni Avanzate e Database - Laraxot PTVX

L'architettura database utilizza librerie specializzate per gestire la complessità dei dati senza compromettere le performance.

## 1. Relazioni Profonde (staudenmeir/eloquent-has-many-deep)
Permette di definire relazioni `HasManyThrough` con livelli illimitati e supporta relazioni molti-a-molti.
- **Utilizzo**: Da usare quando si deve accedere a dati distanti più di 2 tabelle senza scrivere query RAW.
- **Esempio**: Un Tenant che ha molti Commenti attraverso Progetti e Task.

## 2. Liste di Adiacenza e CTE (staudenmeir/laravel-adjacency-list)
Gestione di strutture gerarchiche (parent/child) nello stesso modello usando Recursive Common Table Expressions (CTEs).
- **Utilizzo**: Categorie nidificate, Organigrammi, Alberi di risposte.
- **Metodi Chiave**: `->ancestors()`, `->descendants()`, `->parent()`, `->children()`.

## 3. Caching dei Modelli (genealabs/laravel-model-caching)
Caching automatico a livello di query Eloquent per ridurre il carico sul database MySQL.
- **Configurazione**: Gestita tramite il trait `QueryCacheable`.
- **Regola**: Il sistema invalida automaticamente la cache al salvataggio (create/update/delete).

## 4. Attributi Schemaless (spatie/laravel-schemaless-attributes)
Gestione di campi extra in una colonna JSON (`extra_attributes`).
- **Vantaggio**: Permette di aggiungere campi "on-the-fly" senza modificare la migrazione della tabella per ogni piccola variazione di requisiti.
- **Pattern**:
  ```php
  $model->extra_attributes->set('color', 'red');
  $model->save();
  ```
