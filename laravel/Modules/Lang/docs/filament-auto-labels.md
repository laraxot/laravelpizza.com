---
title: "Etichette Filament automatiche (LangServiceProvider e AutoLabelAction)"
type: reference
module: Lang
updated: 2026-11-25
qmd: "LangServiceProvider AutoLabelAction configureUsing label placeholder helper_text heading tooltip icon chiave traduzione GetTransKeyAction FIX label mai ->label() filament"
related:
  - ./translation-keys.md
  - ./adr/0003-filament-labels-are-autoconfigured-by-lang-provider.md
  - ./adr/0004-filament-labels-from-module-translation-files.md
  - ./adr/0007-missing-translations-written-only-in-local.md
---
# Etichette Filament automatiche

**Regola**: nei componenti Filament dei moduli non si scrivono `->label()`, `->placeholder()`, `->helperText()`, `->description()`, `->tooltip()`
con testi: si aggiunge la chiave al file di lingua del modulo. `->label()` sovrascrive la traduzione automatica e rompe la coerenza fra
lingue. Decisioni: [ADR 0003](adr/0003-filament-labels-are-autoconfigured-by-lang-provider.md), [ADR 0004](adr/0004-filament-labels-from-module-translation-files.md).

## Cosa registra `LangServiceProvider::boot()`

1. `translatableComponents()`: `translateLabel()` su `Field`, `BaseFilter`, `Column`, `Entry` (se il metodo esiste).
2. `registerFilamentLabel()`: un `configureUsing()` globale per ogni tipo, che passa dal componente a `AutoLabelAction::execute($component, $tipo)`:

| Componente | Tipi applicati |
|---|---|
| `Field` | `label`, `placeholder`, `helperText`, `description`; inoltre `validationMessages(__('user::validation'))` se quel file di lingua e' un array non vuoto di stringhe |
| `Entry` | `label` |
| `Section` | solo `heading` (in Filament 5 la `label` si disegna sopra il riquadro: il titolo comparirebbe due volte) |
| `BaseFilter`, `Step` | `label` |
| `Column` | `label`, poi `wrapHeader()->verticallyAlignStart()->grow()` |
| `Action` | `label`, `icon`, `tooltip`; senza record diventa `button()` |
| `Select` | `placeholder` da `filament-forms::components.select.placeholder` |

`registerTranslator()` (sostituzione del `translator` con `TranslatorAdapter`) esiste ma la chiamata in `boot()` e' commentata: di default Laravel usa il suo
translator e le chiavi mancanti non finiscono nel database (vedi [translation-files.md](translation-files.md)).

Il pannello admin del modulo (`Providers/Filament/AdminPanelProvider`) aggiunge solo
`SpatieTranslatablePlugin` con default locales `en`/`it` — niente asset CSS/JS dedicati.

## Come si ricava la chiave

`AutoLabelAction` cerca nel `debug_backtrace()` la prima classe `Modules\...` **concreta** che ha chiesto l'etichetta (non il componente stesso) e
ne ricava il prefisso con `Modules\Xot\Actions\GetTransKeyAction`:

`<modulo minuscolo>::<classe in snake_case>`, dopo aver tolto: il suffisso del tipo della cartella (`Resource`, `Page`, `Widget`...), il prefisso
`dashboard|list|get|manage|edit|view|create`, il suffisso `_action` e `_form_schema`. Se nessun frame corrisponde il prefisso e' `lang::txt`.
Esempi: `Modules\User\Filament\Resources\UserResource` => `user::user`; `Modules\Lang\Filament\Resources\TranslationFileResource\Schemas\TranslationFileForm` => `lang::translation_file_form` (file `Modules/Lang/lang/it/translation_file_form.php`).

Poi, per tipo di componente:

| Componente | Chiave completa |
|---|---|
| Field / Entry / Filter / Column | `<prefisso>.fields.<getName()>.<tipo>` |
| Action | `<prefisso>.actions.<nome azione>.<tipo>` |
| Step | `<prefisso>.steps.<label dello step>.label` |
| Section | `<prefisso>.sections.<heading>.heading` (senza titolo: segmento `empty`, valore salvato vuoto) |

`<tipo>` e' il tipo in snake_case: `label`, `placeholder`, `helper_text`, `description`, `tooltip`, `icon`, `heading`.
File: `Modules/<Modulo>/lang/<locale>/<classe_snake>.php`; formato completo delle chiavi in [translation-keys.md](translation-keys.md).

## Chiave mancante e testi ausiliari

- Se la traduzione di `label` non esiste, `AutoLabelAction` chiede a `SaveTransAction::execute()` di scrivere la chiave con il nome del campo come valore;
  la scrittura avviene solo in ambiente `local` (o con `lang.save_missing_translations = true`): [ADR 0007](adr/0007-missing-translations-written-only-in-local.md).
- **Mai** si scrivono automaticamente `placeholder`, `helper_text`, `description`, `tooltip`: il «valore di comodo» era il nome del campo e finiva a schermo.
  Un testo ausiliare vuoto, o uguale al nome del campo, non viene applicato.
- I segnaposto gia' finiti nei file si tolgono con `php artisan lang:clean-placeholders [Modulo...] [--dry-run]` (`CleanPlaceholderTranslationsAction`).
- Un'`Action` la cui etichetta e' ancora il suo nome (`edit`, `delete`) tiene la traduzione di Filament.
- `icon`: se il valore tradotto e' un SVG esistente (`SvgExistsAction`) diventa icona (e `iconButton()` se disponibile).
- `helper_text` con HTML e' avvolto in `HtmlString`.
- Se `trans()` non restituisce una stringa, la label diventa `FIX:<chiave>` (segnale visibile nell'interfaccia).
- Un chiamante non identificabile restituisce il componente cosi' com'e': peggio che puo' succedere e' un campo senza etichetta tradotta, mai una pagina rotta.

## Fragilita' nota

La chiave dipende dallo stack delle chiamate: cambiare la classe chiamante o la finestra di `array_slice(..., 2)` in `findCallerFrame()` riscrive le chiavi e
quindi i file di lingua su disco. Qualunque modifica va fatta sapendo che si rinominano chiavi; il comportamento e' bloccato da
`tests/Feature/AutoLabelActionContractTest.php` (gruppi `LANG-AUTOLABEL-INV-1..3`) e dalle fixture `tests/Fixtures/AutoLabel*`.

Limiti di `AutoLabelAction` da tenere presenti:

- `debug_backtrace()` a ogni componente creato: costo misurabile nelle pagine con molte colonne.
- Un `Step` senza etichetta stringa o un componente con nome non stringa fa fallire `Webmozart\Assert`.
- Il `configureUsing()` gira alla creazione del componente: una `->label('...')` successiva vince sempre (per questo non si scrivono etichette a mano).
- Non e' la classe omonima `Modules\Xot\Actions\Filament\AutoLabelAction`: quella non e' registrata in `configureUsing()`.

## Pulizia dei segnaposto: `CleanPlaceholderTranslationsAction`

Per anni `AutoLabelAction` ha scritto nei file di lingua, in locale, anche `helper_text`, `placeholder`, `description`... con il nome del campo come valore;
una volta committati comparivano in produzione sotto e dentro i campi (`route`, `postal_code`). Oggi non li scrive piu' (vedi sopra), ma quelli gia' nei file si tolgono con
`php artisan lang:clean-placeholders {moduli?*} {--dry-run}` (comando `CleanPlaceholderTranslationsCommand`), che chiama `CleanPlaceholderTranslationsAction::execute($directory, $dryRun)`:

- **Cosa toglie**: una voce di tipo `helper_text`, `placeholder`, `description`, `tooltip`, `label`, `heading`, `hint` il cui valore e' uguale alla chiave del gruppo che la contiene
  (`'route' => ['label' => 'route']`); le traduzioni vere restano; un gruppo rimasto vuoto si toglie anch'esso. I file chiamati solo `.php` (senza nome) si cancellano.
- **Cosa non tocca**: un file che non e' «solo dati» (variabili, funzioni, `new`, `::`, `use`, include, operatori: `isPureData()`) non si riscrive, perche' resterebbe
  «congelato» al valore calcolato; va pulito a mano. Con `--dry-run` nessun file viene scritto o cancellato e il risultato e' lo stesso.
- **Ritorno**: `array{files: list<string>, removed: int}` (cartella inesistente = `['files' => [], 'removed' => 0]`). Lavora sulla cartella ricevuta, ricorsivamente: non conosce
  moduli o lingue (li sceglie il comando).
- **Effetti collaterali**: riscrive i file di soli dati con `<?php declare(strict_types=1); return [...]` (commenti e allineamenti originali si perdono); fa `include` di ogni
  `.php` che passa il controllo «solo dati». **Nessun backup**: usarla su un albero sotto git e controllare il diff. Gli errori di lettura/scrittura (funzioni `Safe\`) escono come eccezioni.
- **Non impedisce il ritorno dei segnaposto**: lo garantisce `AutoLabelAction` (solo `label` si salva se manca). Test: `tests/Feature/CleanPlaceholderTranslationsActionTest.php`.

## Anti-pattern

```php
// ERRATO: sovrascrive la traduzione automatica
TextInput::make('first_name')->label('Nome')->required();

// CORRETTO: nessun testo nel codice
TextInput::make('first_name')->required();
// Modules/<Modulo>/lang/it/<risorsa>.php: 'fields' => ['first_name' => ['label' => 'Nome']]
```

Per etichette dinamiche (`'campo_'.$i`) si usa `translateLabel()`, non `->label('testo')`.
