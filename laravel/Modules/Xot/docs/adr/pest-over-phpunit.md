---
title: "ADR — Pest come formato e runner dei test applicativi"
type: decision
status: accepted
created: 2026-11-23
updated: 2026-11-24
decision-makers: [team Laraxot]
issues: []
---

# Pest come formato e runner dei test applicativi

## Contesto

Il progetto Laravel è composto da moduli e temi con suite che devono essere eseguibili dal runner Pest del root. I test
dei moduli devono funzionare con il bootstrap root, con il `TestCase` legato per file e con il database scratch. Le
classi PHPUnit autonome e i bootstrap impliciti dei moduli rendono difficile sapere quale `TestCase` e quale
applicazione stiano realmente usando i test.

## Driver della decisione

- Coerenza fra test locali, CI e runner root (`vendor/bin/pest`).
- Sintassi leggibile per comportamento e dataset, e supporto ai gruppi di contract.
- Binding esplicito del `TestCase` in ogni file, evitando il doppio bootstrap fra il `Pest.php` di modulo e quello root.
- Compatibilità con PHPStan e con lo scratch database.
- Test collocati nel modulo o tema owner.

## Alternative scartate

- Scrivere nuovi test come classi `PHPUnit\Framework\TestCase`, o usare `phpunit` direttamente come percorso principale.
- Affidarsi a un `Pest.php` di modulo caricato implicitamente dal runner root, o legare il TestCase globale con
  `uses()->in()` nei moduli.
- Collocare nuovi test in `laravel/tests/` indipendentemente dall'owner.

## Decisione

I nuovi test sono file Pest con `test()` o `it()` e lanciano `vendor/bin/pest` dal contesto `laravel/`; quando serve
l'applicazione, ogni file dichiara il proprio TestCase con `uses(TestCase::class)` nello stesso file, secondo
[pest-testcase-binding-per-file](pest-testcase-binding-per-file.md). PHPUnit resta una dipendenza tecnica interna di
Pest e le sue assertion pubbliche possono essere usate come supporto, ma non si introducono suite PHPUnit autonome.

## Conseguenze

- Buono: il comando e il contesto di esecuzione sono espliciti; i test condividono bootstrap e convenzioni.
- Buono: i test restano vicino al codice del modulo o tema owner.
- Cattivo: i test PHPUnit storici non conformi si migrano solo nello scope di una story, senza rompere il comportamento
  storico e senza riscriverli alla cieca.

## Conferma

- Ogni nuovo file di test che usa l'applicazione lega esplicitamente il `TestCase`.
- La suite viene lanciata con `vendor/bin/pest` nel contesto `laravel/`, con PHPStan e con il runner scratch documentato
  in AGENTS.md.
- Riferimenti: [pest-testcase-binding-per-file](pest-testcase-binding-per-file.md) e
  [architecture-tests-pest-arch](architecture-tests-pest-arch.md).

## Verifica

- `cd laravel && vendor/bin/pest Modules/Xot/tests/Unit/ModulePestBootstrapDoesNotBindTestCaseTest.php` fallisce se il
  `Pest.php` di un modulo o tema torna a legare un TestCase globale.
- Per il resto la verifica è la revisione: un file di test nuovo scritto come classe PHPUnit autonoma si respinge con
  un rimando a questo ADR.
