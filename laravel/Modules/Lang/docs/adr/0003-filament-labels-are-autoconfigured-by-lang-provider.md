---
title: "ADR — Le etichette Filament si configurano da LangServiceProvider"
type: decision
status: accepted
created: 2026-11-24
updated: 2026-11-24
decision-makers: [Lang module owner]
module: Lang
qmd: "ADR AutoLabelAction LangServiceProvider configureUsing label Filament traduzione chiave debug_backtrace"
---

# Le etichette Filament si configurano da LangServiceProvider

## Contesto

Ogni campo, colonna, filtro, entry, sezione, step e azione Filament ha bisogno di etichetta, segnaposto e testo d'aiuto tradotti. La regola di progetto vieta stringhe hardcoded nelle UI: niente `->label('...')` (`AGENTS.md:66`). Serve un meccanismo unico che ricavi il testo da un file di traduzione del modulo owner del componente.

## Driver della decisione

- Nessuna stringa visibile nei sorgenti Filament dei moduli: le etichette vivono in `Modules/<Mod>/lang`.
- Copertura uniforme di tutti i tipi di componente senza che ogni Resource se ne occupi.
- Una chiave di traduzione prevedibile derivata dalla classe che costruisce il componente.
- Un componente senza chiave non deve far cadere il rendering della pagina.

## Alternative scartate

- **`->label()` esplicito in ogni componente**: stringhe hardcoded e traduzioni sparse, vietato dalla regola di progetto.
- **Un trait o una base da richiamare in ogni Resource**: copertura dipendente dalla disciplina di chi scrive, componenti dimenticati senza etichetta.
- **Sola traduzione dichiarativa nei file di lingua senza hook**: il componente non saprebbe quale chiave leggere.

## Decisione

Scelta: **`configureUsing` globale dei componenti Filament in `LangServiceProvider::registerFilamentLabel()`**, che chiama `AutoLabelAction` per `Field`, `Entry`, `Section` (intestazione), `BaseFilter`, `Column`, `Step` e `Action` (`app/Providers/LangServiceProvider.php:48-108`). L'Action individua la classe chiamante da `debug_backtrace()` (`app/Actions/Filament/AutoLabelAction.php:61-63`), ne ricava la chiave con `GetTransKeyAction` e, se la traduzione manca, la salva con `SaveTransAction` (solo in locale, righe 197-201). Senza classe chiamante riconoscibile restituisce il componente invariato invece di sollevare un'eccezione.

## Conseguenze

- Buono, perché ogni componente Filament dei moduli ottiene etichette tradotte senza codice per componente.
- Buono, perché un chiamante non identificabile degrada a campo senza etichetta e non a pagina rotta.
- Cattivo, perché la chiave dipende dallo stack delle chiamate: cambiare la classe chiamante o la finestra di `array_slice` riscrive le chiavi, quindi i file di lingua su disco (docblock `AutoLabelAction.php:40-60`).
- Cattivo, perché la scrittura automatica può persistere segnaposto uguali al nome del campo: esiste `CleanPlaceholderTranslationsAction` proprio per ripulirli.

## Conferma

- Test del modulo che esercitano `AutoLabelAction`: `Modules/Lang/tests/Unit/LangFinalGapsTest.php:321,357`, `Modules/Lang/tests/Unit/LangHundredPercentCoverageTest.php`, `Modules/Lang/tests/Feature/SaveTransActionRespectsSwitchTest.php`.
- Documento descrittivo: [filament-label](../filament-label.md).
