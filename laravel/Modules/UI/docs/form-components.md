---
title: "Componenti form (Filament Forms)"
type: reference
module: UI
status: active
updated: 2026-11-25
qmd: "ui form components EnumSelect AddressField IconPicker InlineDatePicker OpeningHoursField RadioBadge RadioCollection SelectState YearSelect PersonSection"
---

# Componenti form

Codice: `app/Filament/Forms/Components/` (21 classi + `Field/QrReader`), view in
`resources/views/filament/forms/components/`. Stessa regola delle colonne: si estende lo specchio `XotBase*`, mai
`Filament\*` ([conventions.md](conventions.md)). Gemelli lista: [table-columns.md](table-columns.md) e
[form-column-parity.md](form-column-parity.md).

## Catalogo

| Classe | Base | Note |
|---|---|---|
| `EnumSelect` | `XotBaseSelect` | select di enum PHP backed: `->enum(Class::class)`, `icons()`, `htmlLabels()`, `placeholderWhenNoSelection()`; `native(false)` (Tom Select) |
| `SelectState` | `XotBaseSelect` | opzioni dagli stati del modello (`getStatesFor()`, `getDefaultStateFor()`), per `spatie/laravel-model-states` |
| `YearSelect` | `XotBaseSelect` | anni da `past()`/`future()`/`range()` (default da -2 a 0); l'anno gia' salvato resta fra le opzioni anche se fuori intervallo, senno' la select appare vuota e il salvataggio fallisce la regola `in` |
| `ParentSelect` | `XotBaseSelect` | classe vuota, estensione per i moduli |
| `AddressField` | `XotBaseField` | indirizzo (`country, street, city, state, zip`) via relazione: `relationship()`, `saveRelationships()`; schema figlio in `getDefaultChildComponents()`; gemello lista `AddressColumn` |
| `OpeningHoursField` | `XotBaseField` | orari settimanali: 5 colonne per giorno (etichetta + `morning_from/to`, `afternoon_from/to`), `TimePicker` a passi di 15 minuti, regola `OpeningHoursRule` (coerenza fra fasce); gemello lista `OpeningHoursColumn` |
| `IconPicker` | `XotBaseTextInput` | azione suffisso con select del *pack* e `RadioIcon` delle icone, dati da `GetAllIconsAction` ([icons-and-svg.md](icons-and-svg.md)) |
| `InlineDatePicker` | `XotBaseDatePicker` | calendario inline: `enabledDates()`, `currentViewMonth()`, navigazione mese (`previousMonth()/nextMonth()`), view `ui::filament.forms.components.inline-date-picker` |
| `RadioBadge`, `RadioIcon`, `RadioImage` | `XotBaseRadio` | radio ricchi; `RadioBadge` ha `defaultColor()`/`selectedColor()` e legge colore/icona dall'enum |
| `RadioCollection` | `XotBaseField` | radio da una `Collection`: `options()`, `itemView()`, `valueKey()` (default `id`), `isOptionSelected()` type-safe |
| `RadioCardSelector` | `XotBaseField` | radio a card che popola un altro campo (`cards()`, `populatesField()`, titoli e stato vuoto); esistono due copie: `Filament/Forms/Components/` (canonica) e `app/Forms/Components/` (fuori namespace Filament, view `ui::forms.components.radio-card-selector`) |
| `PersonSection`, `EventSection`, `OrganizationSection` | `XotBaseSection` | blocchi di campi riusabili con mappatura documentale schema.org (`Person`, `Event`, `Organization`); `getDefaultName()` |
| `PasswordStrengthField` | `XotBaseTextInput` | indicatore di robustezza (`evaluateStrength()`, view `password-strength`) |
| `IDInput` | `XotBaseTextInput` | PK in form: si legge e si copia, non si scrive; gemello di `IDColumn` (maiuscolo `ID` per scelta utente 2026-11-04) |
| `OrderColumn` (form) | `XotBaseViewField` | badge posizione con frecce su/giu' (via Livewire `$set()`) |
| `TreeField`, `Children`, `Field\QrReader` | `XotBaseField`/`XotBaseViewField` | albero, navigation builder, lettore QR |

Fuori da `Forms/Components`: `Filament/Components/Schema/PersonForm` (`SchemaComponentContract`: `make(?string $prefix)`
restituisce l'array di campi schema.org Person, `type()` = `Person`) e `Filament/Components/SpatieDocumentUpload`
([media-upload.md](media-upload.md)).

## EnumSelect: contratto minimo

Il componente e' sottile: la logica `case -> valore/label/icona` sta li', i form dichiarano solo `->enum(MyEnum::class)`.

- `make(?string $name = null): static` (stessa firma di `Field::make`) e `enum(string|Closure|null): static`
  (stessa firma di `HasEnum::enum`). Una firma piu' stretta o una visibilita' diversa e' un fatal a runtime quando PHP
  carica la classe, e `php -l` non lo vede; l'errore compare spesso come `Class ... not found`.
- non ridefinire `make()` per applicare default: usare `setUp()` (`native(false)`, `options(...)`).
- non usare nomi comuni (`getLabel()` protected) che collidono con i metodi pubblici di `Select`.
- validare la classe con `enum_exists()` + `is_subclass_of(..., BackedEnum::class)`; input non valido: eccezione chiara.
  `tryFrom()` va chiamato solo su `int|string` (PHPStan).
- label/icona: `HasLabel`/`HasIcon` se implementati, poi `label()`/`icon()`, poi il nome del case.
- `HasIcon` da solo **non** mostra icone: Tom Select non rende Blade component; servono `->icons()` e `->htmlLabels()`
  (HTML nelle option solo con `allowHtml`). `htmlLabels()` mantiene `native(false)`.
- la classe deve stare sotto `app/` (PSR-4 `Modules\UI\` -> `app/`): un file in `Modules/UI/Filament/...` non viene
  trovato da Composer; `optimize:clear` non basta, serve il path giusto e al massimo `composer dump-autoload`.
- ordine di diagnosi di un fatal su `EnumSelect`: firma di `make()`, firma di `enum()`, namespace/path, autoload,
  collisioni di nome con il parent. Le enum di test stanno in path PSR-4 coerenti o sono classi anonime.

## Regole che valgono per tutti i campi

- **niente `$view` hardcoded** dove la base lo risolve dal nome del componente (regola `XotBaseField`). Oggi lo
  dichiarano ancora `AddressField` (`filament-schemas::components.grid`), `OpeningHoursField`, `InlineDatePicker`,
  `RadioCollection`, `RadioCardSelector`, `OrderColumn`, `Children` e `QrReader`: debito noto, da togliere con un test
  che verifichi `getView()`.
- `AddressField` deve chiamare `$component->state($data)` dentro `afterStateHydrated()`: senza, i valori del record non
  vengono idratati (bug corretto 2026-07-12).
- `RadioCollection`: nella view `$optionValue` e `$isSelected` vanno definite in un blocco `@php` prima dell'uso (la
  variabile non definita causava HTTP 500); lo stato Alpine deve restare allineato a `wire:model`.
- una `Section` estratta senza heading di default **perde il titolo** rispetto all'inline: regressione muta.
- estrarre un componente solo dopo aver misurato la duplicazione (`grep -rl`), mai in previsione. Segnale per
  estrarlo: lo stesso `->sortable()->toggleable()->tooltip()...` ripetuto in piu' Resource per lo stesso concetto
  (caso `OrderColumn`: la logica di stile vive nel componente, il Resource scrive solo `OrderColumn::make('order_column')`,
  senza `->label()` esplicito).
- Wizard: lo schema di uno step va in un metodo separato (`getXxxStep()` crea lo step, `getXxxStepSchema()` restituisce
  i campi): una responsabilita' per metodo, schema riusabile e testabile.
- non estendere con HTML grezzo Bootstrap/Font Awesome: gli esempi "input-group" delle vecchie pagine non
  corrispondono a nessun componente del modulo.

Test: `tests/Feature/{AddressField,AddressColumn,InlineDatePicker,OpeningHoursColumn,OrderColumnField,IDColumn}Test.php`,
`tests/Unit/EnumSelectTest.php`, `tests/Unit/OpeningHoursRuleTest.php`, `tests/Unit/IDInputTest.php`.
