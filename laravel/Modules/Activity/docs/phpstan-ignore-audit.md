---
title: "Audit @phpstan-ignore — Activity"
type: report
created: '2026-09-01'
qmd: "audit phpstan ignore activity hassnapshots trait unused debito soppresso"
---

# Audit `@phpstan-ignore` — Activity

Un solo hit reale in `app/`: `app/Traits/HasSnapshots.php:7`, `trait.unused`. (Il
secondo match di `grep -rn "@phpstan-ignore"` è un falso positivo: una stringa
regex letterale in `tools/convert-pest-to-assert.php`, non una soppressione.)

## Verdetto: rimosso, non motivato

`HasSnapshots` era un trait placeholder vuoto (solo un commento "can be extended"),
zero consumer in tutto `Modules/` (verificato con grep). Non è un caso analogo a
`Xot/app/Traits/EnumIntegerTrait.php` (API di piattaforma pubblicata, motivazione
scritta accanto all'ignore): qui non c'era nessuna motivazione, solo codice morto.

Storia del file, utile a chi lo ritrova una terza volta: cancellato in `696303d6`
("drop empty traits kept alive by a phpstan-ignore", story 5.16). Ripristinato
brevemente lo stesso giorno da un altro agente con un'implementazione vera
(`getPaginator`/`setPaginator`), che introduceva però una dipendenza da una
property `$paginator` inesistente nelle classi del dominio — dead code diverso,
stessi zero consumer, 2 errori PHPStan reali documentati in
`docs/chat/hassnapshots-due-errori-per-chi-lo-possiede.md`. Poi tornato di nuovo
alla forma vuota originale nel commit `eed19a96` (31 agosto 2026, autore locale
`Marco Xot`, messaggio ".", 12 inserzioni — firma della reimportazione
laraxot/master, non una modifica intenzionale).

Rimosso di nuovo oggi, stessa diagnosi di `696303d6`. Se ricompare una quarta
volta, la causa è a monte (storia condivisa `laraxot/dev` mai sistemata), non
questo file — vedi story `5.27-laraxot-master-pollution-ricorrente`.
