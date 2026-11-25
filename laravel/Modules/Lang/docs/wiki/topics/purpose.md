---
title: "Topic purpose"
type: digest
status: active
qmd: "digest ceiling 100 purpose"
---

# Topic purpose

Sintesi automatica di 3 documenti (chiave `purpose`).

## Scopo BMAD — Lang

_Fonte: `bmad/purpose.md`_

# Scopo BMAD — Lang

## Lo scopo in una frase

**Lang tiene fuori dal codice ogni parola che un utente legge: nessuna etichetta si scrive dentro una classe, si dichiara in un file di lingua.**

Il perché esteso (regola «niente `->label()`», chiave come ponte, direzioni di miglioramento) è nella SSoT del modulo: [../purpose.md](../purpose.md). Qui solo la sintesi BMAD e il confronto con il codice.

## Perché conta in una PA

I testi di un'applicazione pubblica li rivede chi non programma. Se l'etichetta vive nella classe, ogni correzione di una parola è una modifica di codice; se vive in un file di lingua, è una modifica di contenuto.

## Confini

- Lang **risolve e custodisce** le chiavi; il significato del testo è del modulo che lo usa.
- La scrittura dei file di lingua passa da `SaveTransAction`/`SaveArrayAction` (Xot), mai da codice di dominio.

## Stato del codice rispetto allo scopo (verificato 2026-11-16)

| Promessa | Stato | Evidenza |
|---|---|---|
| Etichette risolte da chiave | **mantenuta** | `LangServiceProvider.php:48-125` (`configureUsing` su Field, Entry, Section, Column, Action, Filter, Step) → `AutoLabelAction` |
| Testi modificabili senza toccare il codice | **mantenuta** | `TranslationFileResource` + `EditTranslationFile` → `SaveTransAction::persist` |
| Il salvataggio non rompe le pagine | **mantenuta** | `SaveTransAction.php:68-75`: file illeggibile non riscritto; scrittura automatica solo in `local` (`:33`) |
| Chiave mancante visibile e non persa | **p

## Lang — perche' esiste

_Fonte: `purpose.md`_

# Lang — perche' esiste

## Lo scopo in una frase

**Lang tiene fuori dal codice ogni parola che un utente legge: nessuna etichetta si
scrive dentro una classe, si dichiara in un file di lingua.**

## L'evidenza

- `LangBase`, `TranslationFile`: i file di traduzione sono **gestibili**, non solo
  presenti su disco.
- 14 Action, 1 Widget, 62 file PHP — e **704 documenti** in `docs/`.

Quel rapporto (62 file di codice, 704 di documentazione) e' il segnale piu' onesto del
modulo: il problema che risolve e' fatto di regole e convenzioni molto piu' che di
codice.

## La regola che genera tutto il resto

In questo progetto e' **vietato** usare `->label()`, `->placeholder()` e
`->helperText()` nelle classi Filament. Il testo si risolve per convenzione dalla
chiave del campo nel file di lingua del modulo.

Non e' pedanteria. Tre conseguenze concrete:

1. Un'etichetta scritta inline e' invisibile a chi cura le traduzioni.
2. La stessa cosa finisce chiamata in due modi in due schermate.
3. Nessuno puo' rivedere i testi senza toccare il codice — e in una PA i testi li
   rivede chi non programma.

## Lang — perche' esiste

_Fonte: `wiki/product/purpose.md`_

# Lang — perche' esiste

## Lo scopo in una frase

**Lang tiene fuori dal codice ogni parola che un utente legge: nessuna etichetta si
scrive dentro una classe, si dichiara in un file di lingua.**

## L'evidenza

- `LangBase`, `TranslationFile`: i file di traduzione sono **gestibili**, non solo
  presenti su disco.
- 14 Action, 1 Widget, 62 file PHP — e **704 documenti** in `docs/`.

Quel rapporto (62 file di codice, 704 di documentazione) e' il segnale piu' onesto del
modulo: il problema che risolve e' fatto di regole e convenzioni molto piu' che di
codice.

## La regola che genera tutto il resto

In questo progetto e' **vietato** usare `->label()`, `->placeholder()` e
`->helperText()` nelle classi Filament. Il testo si risolve per convenzione dalla
chiave del campo nel file di lingua del modulo.

Non e' pedanteria. Tre conseguenze concrete:

1. Un'etichetta scritta inline e' invisibile a chi cura le traduzioni.
2. La stessa cosa finisce chiamata in due modi in due schermate.
3. Nessuno puo' rivedere i testi senza toccare il codice — e in una PA i testi li
   rivede chi non programma.
