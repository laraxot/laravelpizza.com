---
title: "ADR — mixed solo come ultima spiaggia"
type: decision
module: Xot
status: accepted
tags: [adr, phpstan, typing, mixed]
created: 2026-11-24
updated: 2026-11-24
---

# ADR: mixed solo come ultima spiaggia

Superseded da [0015-mixed-solo-come-ultima-spiaggia](0015-mixed-solo-come-ultima-spiaggia.md): stessa decisione, riscritta con l'elenco dei due casi ammessi, la scala dei tipi da provare prima e la conferma misurabile. Questo testo resta per la storia; il narrowing con `assert()` nativo che indica qui è vietato dalle regole del progetto (ammesso solo `Webmozart\Assert\Assert`).

## Contesto

Nel codice applicativo mixed non e' un tipo di comodo per chiudere un errore
PHPStan. Si usa solo come ultima spiaggia, quando il confine esterno o dinamico
non consente una tipizzazione piu' precisa e dopo aver verificato che non esista
un contratto, un DTO, un generic o un narrowing locale migliore.

## Driver della decisione

La piattaforma integra Filament, Laravel e payload esterni dinamici: alcuni
confini possono restare realmente aperti. Rendere tutto mixed, pero', sposta
gli errori dal controllo statico al runtime e indebolisce i contratti tra
moduli.

## Alternative scartate

- Usare mixed per chiudere rapidamente una segnalazione PHPStan: nasconde la
  causa e indebolisce l'analisi successiva.
- Aggiungere baseline o ignoreErrors globali: rende verde il gate senza
  correggere il contratto.
- Convertire ogni payload dinamico in un DTO: sarebbe sovra-ingegneria quando
  il valore resta confinato a un adapter o a un confine esterno.

## Decisione

Prima di introdurre mixed occorre:

1. risalire alla sorgente del valore e tipizzarla alla produzione;
2. restringere il tipo con is_*, assert() o un contratto esplicito al confine;
3. riusare i tipi gia' presenti nel modulo e nei contratti condivisi;
4. documentare nel codice il limite inevitabile e il punto in cui il valore viene
   nuovamente validato.

Un mixed esistente va sostituito quando la sorgente diventa conoscibile. Non si
introducono baseline o ignoreErrors per mascherare il problema.

## Conseguenze

- PHPStan resta utile come guardia sui flussi interni.
- Le API dinamiche richiedono un adapter o un narrowing vicino al confine.
- Un mixed nuovo deve citare questo ADR nel docblock della classe o del metodo.

## Conferma

Verificare il rispetto della decisione con PHPStan a livello massimo, una
revisione dei diff e la ricerca periodica di mixed nei file applicativi:

    rg -n '\bmixed\b' Modules/*/app -g '*.php'

@see Modules/Xot/docs/code-quality.md
@see Modules/Xot/docs/adr/0005-owner-local-documentation.md
