---
title: "Il TestCase Pest si lega nel file di test che lo usa"
type: decision
status: accepted
created: 2026-11-23
updated: 2026-11-23
decision-makers: [team Laraxot]
issues: []
qmd: "0007 local pest testcase binding lega"
---

# Il TestCase Pest si lega nel file di test che lo usa

## Contesto

Il runner root non carica automaticamente il `Pest.php` del modulo, mentre il
runner locale puo' caricarlo. Un binding globale per cartella quindi produce
test che funzionano in un contesto e falliscono o ricevono un doppio binding
nell'altro.

## Driver della decisione

- stesso risultato con runner root e runner di modulo;
- bootstrap applicativo esplicito e leggibile;
- isolamento fra moduli e temi;
- diagnosi PHPStan piu' affidabile sui metodi del TestCase.

## Alternative scartate

- `uses(TestCase::class)->in(...)` nel `Pest.php` del modulo;
- binding di tutti i moduli da `laravel/tests/Pest.php`;
- test che dipendono implicitamente da un bootstrap non visibile nel file.

## Decisione

Ogni file Pest che usa l'applicazione o helper del proprio `TestCase` dichiara
nel file `uses(Modules\\<M>\\Tests\\TestCase::class)`. Il `Pest.php` del modulo
contiene solo helper ed estensioni condivise; non registra un `TestCase` per
cartella.

## Conseguenze

- Buono: il contesto di ogni test e' locale e riproducibile.
- Buono: i test possono essere eseguiti dal root senza dipendenze implicite.
- Cattivo: molti file devono dichiarare una riga aggiuntiva; e' un costo
  intenzionale in cambio della prevedibilita'.

## Conferma

- [`0034-pest-testcase-binding-per-file.md`](0034-pest-testcase-binding-per-file.md) (superseded da questo ADR) conserva le misure del 2026-11-19 come evidenza storica;
- `ModulePestBootstrapDoesNotBindTestCaseTest` impedisce il ritorno al binding
  globale;
- un test applicativo senza `uses(...)` viene corretto prima del merge.
