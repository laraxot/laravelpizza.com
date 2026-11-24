---
title: "Pest e' il formato e il runner dei test applicativi"
type: decision
status: accepted
created: 2026-11-23
updated: 2026-11-23
decision-makers: [team Laraxot]
issues: []
qmd: "0003 pest as test runner formato"
---

# Pest è il formato e il runner dei test applicativi

## Contesto

Il progetto Laravel è composto da moduli e temi con suite che devono essere
eseguibili dal runner Pest del root. Le classi PHPUnit autonome e i bootstrap
impliciti dei moduli rendono difficile sapere quale `TestCase` e quale
applicazione stiano realmente usando i test.

## Driver della decisione

- sintassi leggibile per comportamento e dataset;
- un runner standard (`vendor/bin/pest`);
- binding esplicito del `TestCase` in ogni file;
- compatibilità con PHPStan e con lo scratch database;
- test collocati nel modulo o tema owner.

## Alternative scartate

- introdurre nuove classi `PHPUnit\Framework\TestCase` come formato principale;
- affidarsi a un `Pest.php` di modulo caricato implicitamente dal runner root;
- collocare nuovi test in `laravel/tests/` indipendentemente dall'owner.

## Decisione

I nuovi test sono file Pest con `test()` o `it()` e, quando serve,
`uses(TestCase::class)` nello stesso file. PHPUnit resta una dipendenza
tecnica interna di Pest e le sue assertion pubbliche possono essere usate
come supporto, ma non si introducono suite PHPUnit autonome.

## Conseguenze

- Buono: il comando e il contesto di esecuzione sono espliciti.
- Buono: i test restano vicino al codice del modulo/tema.
- Cattivo: i test storici non conformi richiedono migrazione separata e non vanno riscritti alla cieca.

## Conferma

- ogni nuovo file di test deve legare esplicitamente il `TestCase` se usa l'applicazione;
- la suite viene lanciata con `vendor/bin/pest` nel contesto `laravel/`;
- riferimenti: [Pest TestCase binding](pest-testcase-binding-per-file.md) e
  [architecture tests](architecture-tests-pest-arch.md).
