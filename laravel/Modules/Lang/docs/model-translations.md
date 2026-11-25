---
title: "Modelli e traduzioni di contenuti"
type: reference
module: Lang
updated: 2026-11-25
qmd: "modelli lang Post Translation LanguageLine TranslationFile BaseModelLang LangField HasStrictTranslations TranslatableModel spatie translatable HasTranslationsContract connessione lang"
related:
  - ./migrations.md
  - ./translation-files.md
---
# Modelli e traduzioni di contenuti

Due cose diverse vivono in Lang: i **testi dell'interfaccia** (file `lang/<locale>/*.php`, vedi [translation-files.md](translation-files.md)) e i **contenuti dei modelli** nelle
varie lingue (colonne tradotte con `spatie/laravel-translatable`). Questa pagina riguarda i modelli e le basi che Lang mette a disposizione.

## Modelli del modulo (`Modules\Lang\Models`)

Tutti usano la connessione `lang` (aggiunta come copia della connessione di default da `TenantServiceProvider::registerDB()`).

| Modello | Tabella | Ruolo |
|---|---|---|
| `LanguageLine` | `language_lines` | riga di traduzione per `group`, `key`, `locale`, testo JSON `text`; unica su `(group, key, locale)` |
| `Translation` | `translations` | chiavi di traduzione note al sistema (`lang`, `namespace`, `group`, `item`, `key`, `value`, `locale`, `user_id`): le riempie `RecordMissingTranslationAction`; in stile `barryvdh/laravel-translation-manager` |
| `Post` | `posts` | contenuto editoriale multilingua (`title`, `txt`, `slug`, `status`, `lang`/`locale`, meta SEO, `url_lang` JSON); chiave stringa, slug generato da `title` in `guid` (Spatie Sluggable), `SEARCHABLE_FIELDS = title, guid, txt` |
| `TranslationFile` | nessuna (Sushi) | un file di lingua del filesystem come riga: base dell'editor ([translation-file-editor.md](translation-file-editor.md)) |

Basi riusabili da altri moduli:

- `BaseModel` (astratta, `XotBaseModel`, connessione `lang`, cast `id`/`uuid` stringa e date) e `BaseModelLang` (stesso, chiave `id` stringa, `perPage` 30, `snakeAttributes`).
- `BaseMorphPivot` (`MorphPivot` con `Updater`, connessione `lang`).
- `TranslatableModel` (astratta, su `BaseModel`): usa `HasStrictTranslations`.
- `Models\Contracts\HasTranslationsContract`: `getTranslation($key, $locale, $useFallbackLocale = true)` e `setTranslation($key, $locale, $value)` con tipi stretti.

## Contenuti tradotti: `HasStrictTranslations`

Trait che incapsula `Spatie\Translatable\HasTranslations` restringendo il ritorno di `getTranslation()` a `string|array|int|null` (per PHPStan livello 10):
stringhe, interi e `null` passano; un array viene filtrato alle chiavi stringa; `bool` e `float` diventano `int`; un oggetto con `__toString` diventa stringa; il resto `null`.
L'API di Spatie resta quella standard: `$translatable = [...]` sul modello, `setTranslation()`, `getTranslations()`, valore nella lingua corrente leggendo l'attributo.
Al momento della scrittura nessun altro modulo usa `TranslatableModel`/`HasStrictTranslations`: sono la base disponibile e coperta dai test del modulo.

Nel pannello Lang il plugin `SpatieTranslatablePlugin` (pacchetto `lara-zeus/spatie-translatable`, richiesto da `composer.json`) usa `defaultLocales(['en', 'it'])`;
nelle risorse le lingue vengono da `GetTranslatableLocalesAction`.

## `LangField` e `BaseModelLang`

`Casts\LangField` legge e scrive l'attributo sul `post` collegato al modello (`$model->post->{$key}`), cosi' un modello puo' esporre come proprio un campo che
vive in `posts`; `set()` salva il `post` e non scrive niente sul modello (ritorna `[]`). Richiede un `BaseModelLang` (`Assert::isInstanceOf`).

## Stato di una riga `Translation`

`Enums\TranslationStatusEnum` (`SAVED = 0`, `CHANGED = 1`) e' il vocabolario di `laravel-translation-manager`: la tabella `translations` non ha ancora una colonna `status`,
quindi il modello non dichiara il cast (da aggiungere insieme alla migration).

## Dati e tipi

- `posts.user_id` e `translations.user_id` sono UUID (come gli utenti): conversione e regole in [migrations.md](migrations.md).
- Nessun modello di Lang usa soft delete.
