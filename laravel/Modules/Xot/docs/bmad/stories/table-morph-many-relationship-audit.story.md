---
title: "Audit delle relazioni su tabelle polimorfiche condivise"
type: story
module: Xot
status: review
created: 2026-11-05
updated: 2026-11-05
tags: [bmad, eloquent, relationships, polymorphism]
qmd: "tableMorphMany morphToManyX id_tbl tbl shared logs relationship audit modules themes"
related:
  - ../../wiki/rules/model-methods-to-traits.md
  - ../../../app/Models/Traits/RelationX.php
---
# Audit delle relazioni su tabelle polimorfiche condivise

## Contesto

Per relazioni di log basate su `id_tbl` + `tbl`, l'helper owner è
`tableMorphMany()`. `morphToManyX()` rappresenta invece una relazione many-to-many
con tabella pivot e nome morph; sostituirli cambierebbe cardinalità e schema.

## Criteri di accettazione

- [x] Scansionare Modules e Themes per il pattern manuale `hasMany(MyLog::class,
  'id_tbl', 'id')->where('tbl', $this->getTable())` e varianti equivalenti.
- [x] Verificare implementazioni e tipi restituiti da `tableMorphMany()` e
  `morphToManyX()`.
- [x] Registrare il contratto nella regola owner Xot.
- [x] Non modificare relazioni già corrette o file con lock attivo.

## Esito

Nessun pattern manuale residuo trovato. Cinque relazioni `MyLog` già usano
`tableMorphMany()` in Performance e IndennitaResponsabilita; un filtro aggiuntivo
su `note` è specifico del dominio e va mantenuto. Nessuna relazione di questo
tipo rilevata nei temi.
