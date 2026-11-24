---
title: "ADR — I blocchi del page builder si scoprono dalla cartella app/Filament/Blocks di ogni modulo"
type: decision
status: accepted
created: 2026-11-24
updated: 2026-11-24
module: UI
tags: [adr, blocks, filament, builder, convention]
related:
  - ../contracts/get-all-blocks-action.md
<<<<<<< HEAD
=======
qmd: "block discovery by filament blocks folder"
>>>>>>> laraxot/dev
---

# ADR: scoperta dei blocchi per cartella e nome di classe

## Contesto

Il campo builder delle pagine (`Cms/app/Filament/Fields/PageContent.php`, `PageContentBuilder.php`) deve offrire i
blocchi di **tutti** i moduli installati, e ogni progetto ne installa un insieme diverso. Un elenco scritto a mano
andrebbe aggiornato in Cms ogni volta che un modulo aggiunge un blocco, e un modulo non installato lascerebbe nell'elenco
una classe inesistente. Il nome del blocco è anche la chiave salvata nel JSON del contenuto della pagina
(`type`), quindi deve essere stabile. Come trova il builder i blocchi disponibili?

## Decisione

- `app/Actions/Block/GetAllBlocksAction.php` fa `glob` di `Modules/*/<modules.paths.generator.model.path>/../Filament/Blocks/*.php`
  (cioè `Modules/<M>/app/Filament/Blocks/*.php`), ricava la classe dal file con `Xot GetClassNameByPathAction` e
  ritorna `ComponentFileData` con `name`, `class`, `module`, `path`.
- `name` = basename della classe in snake_case senza il suffisso `_block` (`HeroBlock` → `hero`); `module` = segmento
  tra `Modules\` e `\Filament\` del namespace.
- Per aggiungere un blocco basta una classe in `app/Filament/Blocks/` del proprio modulo; nessuna registrazione.

## Alternative scartate

- **Registro esplicito in config o in un provider**: un punto in più da tenere allineato, e il motivo per cui un blocco
  "non compare" diventa un elenco dimenticato.
- **Tag nel container / attributo PHP**: richiede che tutti i provider siano caricati e un passo di registrazione per
  blocco; la cartella è già la convenzione dei moduli.

## Conseguenze

- Buono: un modulo porta i suoi blocchi installandolo, li perde disinstallandolo.
- Cattivo: rinominare la classe di un blocco cambia `name`, cioè la chiave `type` già salvata nei contenuti: i blocchi
  salvati con il vecchio nome non vengono più riconosciuti. Rinomina = migrazione dei contenuti.
- Cattivo: un file PHP non-blocco in quella cartella finisce nell'elenco; la cartella contiene solo blocchi.
- Il `glob` gira a ogni chiamata (nessuna cache).

## Verifica

- `cd laravel && vendor/bin/pest Modules/UI/tests/Unit/Actions/Block/GetAllBlocksActionTest.php`
  (`--group=UI-BLOCKS-INV-1`, `UI-BLOCKS-INV-2`): fallisce se un blocco viene da un'altra cartella, se `module` non
  corrisponde al percorso o se `name` non segue la regola snake senza `_block`.
- `cd laravel && vendor/bin/pest Modules/Cms/tests/Feature/FilamentBuilderBlocksTest.php`: i blocchi di Cms sono
  trovati e hanno `make()` e `getBlockSchema()`.
