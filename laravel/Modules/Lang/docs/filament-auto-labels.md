---
title: "Etichette Filament automatiche (LangServiceProvider e AutoLabelAction)"
type: reference
module: Lang
updated: 2026-11-25
qmd: "LangServiceProvider AutoLabelAction configureUsing label placeholder helper_text heading tooltip icon chiave traduzione GetTransKeyAction FIX label mai ->label() filament"
related:
  - ./contracts/auto-label-action.md
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

## Anti-pattern

```php
// ERRATO: sovrascrive la traduzione automatica
TextInput::make('first_name')->label('Nome')->required();

// CORRETTO: nessun testo nel codice
TextInput::make('first_name')->required();
// Modules/<Modulo>/lang/it/<risorsa>.php: 'fields' => ['first_name' => ['label' => 'Nome']]
```

Per etichette dinamiche (`'campo_'.$i`) si usa `translateLabel()`, non `->label('testo')`.
