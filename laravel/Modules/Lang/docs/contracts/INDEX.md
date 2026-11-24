---
<<<<<<< .merge_file_FASOud
<<<<<<< .merge_file_ThFA98
<<<<<<< HEAD
=======
>>>>>>> .merge_file_ssfOC2
=======
>>>>>>> .merge_file_f3X4SG
title: "INDEX — Lang"
type: index
status: active
created: 2026-11-23
updated: 2026-11-23
decision-makers: []
---

<!-- File: docs/contracts/INDEX.md · formato MADR breve. -->

# <!-- Titolo: indice operativo Lang -->

Elenco operativo dei contract comportamentali del modulo Lang.

| Operazione | Contract | Classe | Invarianti |
|---|---|---|---|
| Presentazione language switcher | [language-switcher](language-switcher.md) | `Modules\Lang\View\Components\LanguageSwitcher` | LANG-SWITCHER-001, LANG-SWITCHER-002, LANG-SWITCHER-003 |
| Dati vista language switcher | [language-switcher-view-data](language-switcher-view-data.md) | `LanguageSwitcherWidget` | LANG-SWITCHER-001, LANG-SWITCHER-002 |
| Componente language switcher | [language-switcher-component](language-switcher-component.md) | `Modules\Lang\View\Components\LanguageSwitcher` | LANG-SWITCHER-001, LANG-SWITCHER-002, LANG-SWITCHER-003 |

<<<<<<< .merge_file_FASOud
<<<<<<< .merge_file_ThFA98
(End of file - total 18 lines)
=======
title: "INDEX contratti — Lang"
type: index
owner: Lang
updated: 2026-11-24
qmd: "Lang contract INDEX language switcher copertura pest group LANG-SWITCHER"
---

# INDEX contratti — Lang

Copertura = `coperto` se per ogni ID esiste `->group('<ID>')` nei test del modulo (verifica: `rg -n "group\('LANG-" laravel/Modules/Lang/tests`, 2026-11-24: nessun risultato). Gli ID `LANG-SWITCHER-00N` non seguono il formato standard `<SCOPE>-INV-<N>`: sono definiti solo in [language-switcher](language-switcher.md). Comandi da `laravel/`.

| Operazione | Contract | Classe | Invarianti | Copertura | Comando |
|---|---|---|---|---|---|
| Presentazione language switcher | [language-switcher](language-switcher.md) | `Modules\Lang\View\Components\LanguageSwitcher` | LANG-SWITCHER-001, -002, -003 | non coperto | `vendor/bin/pest --group=LANG-SWITCHER-001` (idem -002, -003) |
| Componente language switcher | [language-switcher-component](language-switcher-component.md) | `Modules\Lang\View\Components\LanguageSwitcher` | nessun ID proprio (invarianti in prosa) | non coperto | `vendor/bin/pest Modules/Lang/tests/Unit/Filament/LanguageSwitcherWidgetTest.php` (test indicato nel contract) |
| Dati vista language switcher | [language-switcher-view-data](language-switcher-view-data.md) | `Modules\Lang\Filament\Widgets\LanguageSwitcherWidget` | nessun ID proprio (invarianti in prosa) | non coperto | stesso file di test |

Marker `@contract`/`@see` nel componente: non verificato (fuori scope docs).

## Backlog contract

Action ad alto rischio senza contract (scrivono file di lingua; `laravel/Modules/Lang/app/Actions/`):

- `SaveTransAction.php`, `WriteTranslationFileAction.php` (scrittura con backup), `PublishTranslationAction.php`
- `SyncTranslationsAction.php`, `MergeTranslationsAction.php`, `CleanPlaceholderTranslationsAction.php` (riscrivono file)
- `Filament/AutoLabelAction.php` (le sue chiavi decidono i nomi dei file di lingua: vedi ADR `filament-labels-are-autoconfigured-by-lang-provider`)
- `Translation/RecordMissingTranslationAction.php` (scrive nel database)

Totale Action in `app/Actions`: 17 file `.php`. Contract di Action: 0; contract di presentazione: 3.
>>>>>>> laraxot/dev
=======
(End of file - total 18 lines)
>>>>>>> .merge_file_ssfOC2
=======
(End of file - total 18 lines)
>>>>>>> .merge_file_f3X4SG
