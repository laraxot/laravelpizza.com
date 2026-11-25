---
title: "ADR — Le etichette Filament vengono dai file di lingua del modulo, applicate globalmente con configureUsing"
type: decision
status: accepted
module: Lang
tags: [adr, lang, filament, labels, translations, configure-using]
created: 2026-11-24
updated: 2026-11-24
related:
  - ../../app/Actions/Filament/AutoLabelAction.php
  - ../../app/Providers/LangServiceProvider.php
  - ../contracts/auto-label-action.md
  - ../../tests/Feature/AutoLabelActionContractTest.php
qmd: "filament labels from translation files etichette"
---

# ADR: le etichette Filament vengono dai file di lingua del modulo, applicate a tutti i componenti

## Contesto

- I moduli girano in più progetti e in quattro lingue: un'etichetta scritta nel codice (`->label('Titolo')`) è una sola
  lingua e un solo progetto.
- Filament permette di configurare ogni componente alla creazione con `Component::configureUsing()`.
- Ogni classe di un modulo ha già una chiave di traduzione derivabile dal nome (Xot `GetTransKeyAction`: modulo +
  classe, es. `blog::article`), e i file di lingua sono organizzati per quella chiave (`fields`, `actions`, `sections`, `steps`).
- Misura (2026-11-24): `grep -rn -- "->label(" Modules/*/app/Filament` trova 546 righe in 155 file: la regola sotto non
  è rispettata ovunque.

Domanda: dove vive il testo che l'utente vede su campi, colonne, azioni e sezioni del pannello?

## Decisione

- `LangServiceProvider::registerFilamentLabel()` registra `configureUsing()` su `Field`, `Entry`, `Section`, `BaseFilter`,
  `Column`, `Step`, `Action`; ognuno passa da `AutoLabelAction`.
- `AutoLabelAction` ricava la chiave dalla prima classe `Modules\…` concreta nel backtrace del chiamante e legge
  `<chiave>.fields.<nome>.label` (e `placeholder`, `helper_text`, `description`, `heading`, `icon`).
- Nelle Resource, form, tabelle e azioni dei moduli **non** si scrivono `->label()`, `->placeholder()`,
  `->helperText()`: si aggiunge la chiave al file di lingua del modulo.
- Le sezioni ricevono solo `heading` (in Filament 5 la `label` di una Section si disegna sopra il riquadro: il titolo
  compariva due volte).

## Alternative scartate

- `->label(__('modulo::file.fields.x.label'))` in ogni componente: funziona, ma ripete la chiave a mano e ogni rinomina
  del campo la rompe in silenzio.
- `->translateLabel()` di Filament: traduce la stringa passata, non ricava la chiave dalla classe, e lascia il testo nel codice.
- Una classe base per ogni componente: impossibile senza sostituire tutti i componenti di Filament; `configureUsing` è
  il punto di estensione previsto.

## Conseguenze

- Pro: un campo nuovo ha l'etichetta nelle lingue del modulo senza codice; in locale la chiave mancante viene creata
  (vedi [ADR chiavi mancanti solo in locale](missing-translations-written-only-in-local.md)).
- Contro: `debug_backtrace()` a ogni componente creato; la chiave dipende da quale classe chiama (spostare un form in
  un'altra classe cambia la chiave); un'etichetta mancante in produzione mostra il nome del campo.
- Debito: esistono due `AutoLabelAction` (Lang, registrata; Xot, con file `.to_lang` accanto) e 546 `->label(` nel
  codice Filament dei moduli da migrare ai file di lingua.

## Verifica

- `cd laravel && vendor/bin/pest Modules/Lang/tests/Feature/AutoLabelActionContractTest.php`: etichetta presa dal file
  del modulo chiamante, salvataggio solo delle etichette mancanti, testo ausiliario uguale al nome non applicato.
- Solo revisione: nessun test vieta `->label()` nelle Resource dei moduli (misura nel Contesto).
