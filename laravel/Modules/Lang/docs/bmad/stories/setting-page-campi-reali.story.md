---
title: "SettingPage di Lang: le lingue dell'editor delle traduzioni"
status: done
module: Lang
type: story
qmd: "Lang SettingPage LangConfigData lingue editor traduzioni TranslationFileResource LocaleSwitcherRefresh supported_locales default_locale"
related:
  - ../../../../Xot/docs/bmad/stories/setting-page-campi-reali.story.md
  - ./setting-page.story.md
---

# SettingPage di Lang: le lingue dell'editor delle traduzioni

## Fase BMAD

Build, dentro la story madre di Xot [setting-page-campi-reali](../../../../Xot/docs/bmad/stories/setting-page-campi-reali.story.md).
Richiesta dell'utente (testuale): "nei SettingPage il metodo getFormSchema non puo restituire [] in ogni modulo c'e'
qualcosa da settare". Sostituisce la bozza [setting-page](./setting-page.story.md) (marcata superseded).

## Chi decide la lingua, verificato

| Cosa | Dove | Chi lo legge |
|------|------|--------------|
| Lingua dell'applicazione | `app.locale` (file `app` del tenant, `it` in `local/trade` e `localhost`) | traduttore di Laravel, mcamara (`defaultLocale`), `TranslationFileResource` |
| Lingue del sito | `laravellocalization.supportedLocales` (`config/laravellocalization.php`: `en`, `es`, `it`) | `LanguageSwitcherWidget`, rotte di Cms, `SetFolioLocale`, `ResolveLocalizedBlockDataAction` |
| Lingua primaria dei contenuti | `xra.primary_lang` (`XotData`) | `HasBlocks` di Cms (campo di Cms) |
| Lingue dell'editor delle traduzioni | scritte a mano `['it', 'en']` in quattro punti | `TranslationFileResource`, `LangBaseResource`, `EditTranslationFile`, `LocaleSwitcherRefresh` |

Le prime tre righe hanno gia' un proprietario (Tenant/Xot/Cms) e un meccanismo (il file `app`, `laravellocalization`,
`xra`): duplicarle in `lang.php` non le avrebbe cambiate. Resta la quarta, che e' di Lang e che nessuna config governava.

## Cosa si configura davvero

| Campo | Default | Chi lo legge |
|-------|---------|--------------|
| `supported_locales` | `['it', 'en']` (come era scritto) | `ResolveTranslatableLocalesAction`, chiamata da `TranslationFileResource::getTranslatableLocales()`, `LangBaseResource::getTranslatableLocales()`, `EditTranslationFile::getTranslatableLocales()` e da `LocaleSwitcherRefresh::setUp()` (opzioni del selettore) |
| `default_locale` | `null`: la lingua dell'applicazione | `ResolveDefaultTranslatableLocaleAction`, chiamata da `TranslationFileResource::getDefaultTranslatableLocale()`, `LangBaseResource::getDefaultTranslatableLocale()` (fallback `app.locale`) e da `LocaleSwitcherRefresh::setUp()` (fallback `it`, come prima) |

- Le scelte del form sono le lingue note al progetto (`laravellocalization.supportedLocales`), con bandiera e nome nativo
  (`ListLocaleOptionsAction`): per `it` e `en` le etichette sono identiche alle vecchie (`🇮🇹 Italiano`, `🇬🇧 English`).
- Una lista vuota non arriva mai all'editor (torna `['it', 'en']`); una lingua predefinita fuori dall'elenco viene ignorata.
- `default_locale` della bozza di Codex valeva `it` e `supported_locales` era un campo di testo libero a 2 lettere: ora
  il default e' "come l'applicazione" e le lingue si scelgono da una lista.

## Lasciato fuori, e perche'

- `save_missing_translations` (`SaveTransAction`): e' un'impostazione vera con un lettore vivo, ma e' tri-stato (spento,
  acceso solo in locale, acceso sempre) e il valore "acceso sempre" scrive i file di lingua dal web in produzione: il
  commento nel codice documenta il rischio (file lasciato a meta' = 500 su ogni pagina). Esiste gia' come chiave
  `save_missing_translations` di `config/{tenant}/lang.php` e due test la proteggono; non la espongo in un form.
- `fallback_locale` di `Modules/Lang/config/lang.php`: nessun lettore, resta com'e' (la lingua di riserva e' `app.fallback_locale`).
- Tolte da `Modules/Lang/config/lang.php`, perche' duplicati senza lettore (e discordanti: `available_locales` diceva
  `it`, `en`, `de`): `default_locale` e `available_locales`. `cache.*` e `validation.*` restano dove sono: la story madre
  le dice senza lettori, io non l'ho riverificato e non sono lingue.
- `RouteServiceProvider::registerLang()` (legge `laravellocalization` e fa `setLocale`): nessun chiamante.

## Verifica

- Pest `Modules/Lang/tests/Unit/Datas/LangConfigDataTest.php`: 10 test, 21 asserzioni; `LocaleSwitcherRefreshTest` passa.
- `LangCoverageBoostTest` ha un fallimento che non dipende da questa modifica: `TranslationFilesTable::getTableColumns()` non ha
  la colonna `created_at` (riga 160 del test), prima di arrivare alle asserzioni sulle lingue (che passano nel test nuovo).
- PHPStan livello max sui file toccati: 0 errori. Pint: passed.
- Effetto collaterale visto: lanciare i test Lang riscrive `lang/en/txt.php` (salvataggio delle chiavi mancanti); non e'
  parte di questa story e non e' stato committato.
