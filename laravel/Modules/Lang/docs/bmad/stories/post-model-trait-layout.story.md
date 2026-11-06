---
title: "Allineare i trait Eloquent del modello Post"
type: story
module: Lang
status: in-progress
created: 2026-11-05
updated: 2026-11-05
tags: [bmad, eloquent, accessor, mutators, relationships]
qmd: "Lang PostMutators PostRelations trait directories Mutators Relationships accessor twin getTxt"
related:
  - ../../../../Xot/docs/wiki/rules/model-methods-to-traits.md
  - ../../../../Xot/docs/wiki/rules/accessor-twin-method.md
---
# Allineare i trait Eloquent del modello Post

## Obiettivo

Tenere accessor e setter in `Models/Traits/Mutators`, relazioni in
`Models/Traits/Relationships`, e assicurare che ogni accessor deleghi a un
gemello pubblico chiamabile senza argomenti obbligatori.

## Criteri di accettazione

- [ ] Spostare `PostMutators` e `PostRelations` nei rispettivi owner folder e aggiornare la composizione.
- [ ] Mantenere il contratto accessor: `$value` tipizzato, delega esplicita, helper dello stesso file.
- [ ] `getTxt()` senza argomenti deve produrre il valore raw del modello normalizzato a stringa vuota quando assente.
- [ ] Lint, Pint, PHPStan e Pest `PostTest` verdi.
- [ ] Aggiornare inventario/stato BMAD e indicizzare con QMD.

## Finding

Il comando `xot:check-accessor-twins --module=Lang --fail-on-missing` ha individuato
`PostMutators::getTxtAttribute()` che passava `$value` a un gemello con parametro
obbligatorio. La regola di progetto richiede che `getTxt()` sia autonomamente
invocabile. Il trait era inoltre nella cartella generica `Traits/`, fuori dalle
cartelle owner dedicate.
