---
title: "Selettore di lingua, bandiere e paesi"
type: reference
module: Lang
updated: 2026-11-25
qmd: "language switcher LanguageSwitcherWidget LanguageSwitcher component ThemeComposer LangData Flag i18n-link NationalFlagSelect rinvex countries bandiere svg LocaleSwitcherRefresh ListLocaleOptionsAction"
related:
  - ./laravel-localization-mcamara-reference.md
  - ./contracts/language-switcher-component.md
  - ./adr/0001-cambio-lingua-con-url-localizzato.md
  - ./adr/0006-language-switcher-standalone-view.md
---
# Selettore di lingua, bandiere e paesi

Tre superfici distinte, con sorgenti diverse. Non vanno confuse.

| Superficie | Classe | Lingue da | Dove si usa |
|---|---|---|---|
| Sito pubblico | `LanguageSwitcherWidget` + componente Blade `LanguageSwitcher` | `LaravelLocalization::getSupportedLocales()` (config `laravellocalization`) | tema e header UI: `<x-lang::language-switcher />` |
| Editor traduzioni (admin) | `LocaleSwitcherRefresh` (azione Filament) | `GetTranslatableLocalesAction` (config tenant `lang.php`) | testata di `TranslationFileResource` |
| Dati per i temi | `ThemeComposer` + `LangData` | `config('laravellocalization.supportedLocales')` | view dei temi che chiedono elenco lingue e bandiera |

## Sito pubblico: widget e componente

`Modules\Lang\Filament\Widgets\LanguageSwitcherWidget` (Livewire, `XotBaseSchemaWidget`, `$isDiscovered = false`, `canView()` sempre `true`):

- `getAvailableLocales()` costruisce per ogni lingua `code`, `name`, `native_name`, `flag` (da `flag` della config, se presente) e `url`;
- `getLanguageUrl($code)` usa `LaravelLocalization::getLocalizedURL($code, null, [], true)`; se la lingua non e' supportata
  (`UnsupportedLocaleException`) o il pacchetto non restituisce una stringa, ripiega su `/{codice}`;
- `changeLanguage($locale)` ignora i codici non supportati e fa `redirect` all'URL localizzato equivalente (stessa pagina, altra lingua);
- non e' una card di dashboard: si monta a mano nel tema con `@livewire(\Modules\Lang\Filament\Widgets\LanguageSwitcherWidget::class)`.

`Modules\Lang\View\Components\LanguageSwitcher` (registrato nel namespace Blade `lang`, quindi `<x-lang::language-switcher />`) incapsula il
widget per i temi: se `canView()` e' falso rende `lang::components.empty`, altrimenti `lang::components.language-switcher` con
`current_locale`, `available_locales` (ognuna con `url` gia' risolto) e `widget_id`. La vista e' un `<details>` con link ordinari:
niente `$this`, niente JavaScript (ADR 0006). Contratto: [contracts/language-switcher-component.md](contracts/language-switcher-component.md).

Il componente anonimo `lang::i18n-link` costruisce un link con `getLocalizedURL($locale, $url, [], $forceLocale)`.

## Editor traduzioni: `LocaleSwitcherRefresh`

Azione Filament (`XotBaseAction`) con un `Select` delle lingue dell'editor (`ListLocaleOptionsAction` su `GetTranslatableLocalesAction`).
`applyLocale($locale)` salva `locale` in sessione e chiama `App::setLocale()`; poi redirect al `Referer`. Un valore non stringa diventa `en`
(`normalizeLocale()`). Le lingue dell'editor sono quelle di `LangConfigData`, non quelle del sito: vedi [translation-file-editor.md](translation-file-editor.md).

## `ThemeComposer` e `LangData`

`Modules\Lang\View\Composers\ThemeComposer`: `languages()`, `otherLanguages()` (senza la corrente), `currentLang($field)`. Ogni voce e' un
`LangData` (`id`, `name`, `flag` HTML, `url`). Il codice paese della bandiera viene da `regional` (`it_IT` => `it`); `en` e' mappato su `gb`.
L'`url` e' `#` sul sito e viene costruito dalla rotta corrente nei pannelli (`inAdmin()`). Se `supportedLocales` manca usa `it` e `en`;
una voce non-array o senza `regional`/`name` lancia `InvalidArgumentException` con il codice della lingua.

## Bandiere

- `resources/svg/flag/<iso2>.svg`: 266 file, nome in minuscolo (`it.svg`, `gb.svg`...). Si richiamano con `AssetAction` (`lang::svg/flag/<iso2>.svg`).
- `ListLocaleOptionsAction`: etichette `🇮🇹 Italiano` per i selettori; la bandiera e' l'emoji ricavata dal paese di `regional`, il nome e' `native` con la
  prima lettera maiuscola (o il codice se manca). Senza paese in `regional` niente bandiera.
- Componente `lang::flag` (`View\Components\Flag`, parametro `name`): la sua vista `flag.blade.php` oggi punta a `lang::svg/it.svg` fisso, senza
  usare `name`. Per una bandiera dinamica usare `lang::svg/flag/<iso2>.svg` come `NationalFlagSelect`.
- Regola di progetto: nessun SVG inline nelle Blade; icone come file `.svg` e `<x-filament::icon>`.

## `NationalFlagSelect`

`Modules\Lang\Filament\Forms\Components\NationalFlagSelect` (`XotBaseSelect`): select ricercabile, `native(false)`, `allowHtml()`, limite 300 opzioni.
I paesi vengono dalla funzione globale `countries()` del pacchetto `rinvex/countries` (dipendenza di Lang); l'opzione e' `codice ISO alpha-2 => <span>bandiera + nome</span>`.
Il nome e' `__('lang::countries.<iso2 minuscolo>')` (file `lang/<locale>/countries.php`); se la chiave non e' una traduzione (stringa) si ripiega sul nome
inglese di rinvex e poi sul codice. Righe senza `iso_3166_1_alpha2` valido sono scartate; sono ordinate per nome. La ricerca confronta il testo con nome
inglese, codice e nome tradotto. I punti di sostituzione per i test sono `resolveCountries()` e `finalizeFilteredCountries()`.
