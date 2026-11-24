<<<<<<< .merge_file_JD7HAR
<<<<<<< .merge_file_SbQnln
<<<<<<< HEAD
=======
>>>>>>> .merge_file_LECYvR
=======
>>>>>>> .merge_file_XbEy19
# Glossario di dominio Lang

<!-- Le parole del dominio e dove stanno nel codice. Topology di AGENTS.md punta qui.
     Un termine per riga; se glossario e codice non coincidono, vale il codice e si corregge il glossario. -->

| Termine | Significato | Nel codice |
|---|---|---|
<<<<<<< .merge_file_JD7HAR
<<<<<<< .merge_file_SbQnln
| <!-- termine --> | <!-- cosa vuol dire per il business, con unità e stati se servono --> | <!-- classe, colonna, rotta --> |
=======
---
title: "Glossario di dominio Lang"
type: glossary
owner: Lang
updated: 2026-11-24
qmd: "glossario Lang traduzione chiave locale file di lingua language switcher AutoLabel segnaposto"
---

# Glossario di dominio Lang

Se glossario e codice divergono vale il codice. Percorsi relativi a `laravel/Modules/Lang/`.

| Termine | Significato | Nel codice |
|---|---|---|
| Locale | Codice lingua attivo dell'applicazione (`app()->getLocale()`), scelto fra le lingue supportate. | `app/Actions/GetTransPathAction.php`, `laravel/config/laravellocalization.php` (`supportedLocales`) |
| Lingua supportata | Lingua nota al progetto, con codice, nome nativo e bandiera. | `app/Actions/ListLocaleOptionsAction.php` |
| Lingue traducibili | Lingue in cui lavora l'editor delle traduzioni; se la lista del tenant è vuota vale il default. | `app/Actions/ResolveTranslatableLocalesAction.php`, `app/Actions/ResolveDefaultTranslatableLocaleAction.php` |
| Chiave di traduzione | Stringa `<namespace>::<file>.<...>.<tipo>` che identifica un testo. | `app/Actions/GetTransPathAction.php:19-24`, ADR `lang-owns-localization-data` |
| File di lingua | File PHP in `Modules/<Mod>/lang/<locale>/` con le traduzioni del modulo. | `app/Actions/GetTransPathAction.php`, `app/Models/TranslationFile.php` |
| Auto-etichetta | Etichetta/segnaposto/aiuto di un componente Filament ricavati dalla chiave di traduzione, mai scritti a mano. | `app/Actions/Filament/AutoLabelAction.php`, `app/Providers/LangServiceProvider.php:48` |
| Traduzione segnaposto | Testo uguale al nome del campo, scritto in automatico e poi ripulito. | `app/Actions/CleanPlaceholderTranslationsAction.php` |
| Traduzione mancante | Chiave letta ma assente, registrata nel database dal translator. | `app/Actions/Translation/RecordMissingTranslationAction.php`, `app/Adapters/TranslatorAdapter.php` |
| Scrittura traduzione | Scrittura di un file di lingua con backup automatico. | `app/Actions/WriteTranslationFileAction.php`, `app/Actions/SaveTransAction.php` |
| Sincronizzazione | Copia delle traduzioni da una lingua sorgente (default `it`) alle lingue target. | `app/Actions/SyncTranslationsAction.php` |
| Fusione traduzioni | Unione di più file di traduzione; i file successivi sovrascrivono. | `app/Actions/MergeTranslationsAction.php` |
| Stato traduzione | Stato di sincronizzazione di una riga `Translation` rispetto ai file di lingua. | `app/Enums/TranslationStatusEnum.php` |
| Language switcher | Selettore di lingua come normale link a URL localizzato. | `app/View/Components/LanguageSwitcher.php`, `app/Filament/Widgets/LanguageSwitcherWidget.php` |
| Campo multilingua | Cast Eloquent per attributi con valori per lingua. | `app/Casts/LangField.php`, `app/Models/TranslatableModel.php` |
| Riga di lingua | Modello della tabella delle traduzioni a database. | `app/Models/LanguageLine.php`, `app/Models/Translation.php` |
>>>>>>> laraxot/dev
=======
| <!-- termine --> | <!-- cosa vuol dire per il business, con unità e stati se servono --> | <!-- classe, colonna, rotta --> |
>>>>>>> .merge_file_LECYvR
=======
| <!-- termine --> | <!-- cosa vuol dire per il business, con unità e stati se servono --> | <!-- classe, colonna, rotta --> |
>>>>>>> .merge_file_XbEy19
