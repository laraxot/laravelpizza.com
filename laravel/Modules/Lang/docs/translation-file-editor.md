---
title: "Editor dei file di traduzione (pannello Lang)"
type: reference
module: Lang
updated: 2026-11-25
qmd: "TranslationFileResource editor traduzioni Sushi TranslationFile LangConfigData SettingPage LocaleSwitcherRefresh TranslationEditor policy translation_file permessi lingue editor"
related:
  - ./translation-files.md
  - ./language-switcher-and-flags.md
  - ./adr/0007-missing-translations-written-only-in-local.md
---
# Editor dei file di traduzione

Il pannello Lang elenca i file `lang/<locale>/*.php` di tutti i moduli e permette a un traduttore di modificarne i testi dal browser.

## Pezzi

| Pezzo | Classe | Note |
|---|---|---|
| Pannello | `Providers\Filament\AdminPanelProvider` (`XotBasePanelProvider`, modulo `Lang`) | plugin `SpatieTranslatablePlugin` con `defaultLocales(['en', 'it'])`; il percorso del pannello e' quello standard di `XotBasePanelProvider` |
| Modello | `Models\TranslationFile` (trait **Sushi**, nessuna tabella) | `getRows()` costruisce le righe da `GetAllTranslationAction` (`id` = chiave `modulo::file`, `name` = nome file, `content` = contenuto); se la lettura fallisce logga un warning e restituisce `[]` |
| Risorsa | `Filament\Resources\TranslationFileResource` (`XotBaseResource`) | pagine `index`, `create`, `edit`; niente `view` |
| Lista | `Pages\ListTranslationFiles`, `Tables\TranslationFilesTable` | colonne `name`, `key` ricercabili e ordinabili, `path` nascosta di default; in testata il selettore `LocaleSwitcherRefresh` |
| Form | `Schemas\TranslationFileForm` | sezione `file` (`name`, `key` in sola lettura) e sezione `content`: una `Section` collassabile per ogni sotto-array, un `TextInput` per ogni testo (un `Textarea` se supera 80 caratteri); la chiave del campo e' il percorso con i punti |
| Modifica | `Pages\EditTranslationFile` | `mutateFormDataBeforeSave` chiama `SaveTransAction::persist($record->key, $data['content'])`: la scrittura da pannello e' voluta anche in produzione; `afterSave` ricarica il record |
| Campo | `Forms\Components\TranslationEditor` (`XotBaseField`) | editor ricorsivo chiave-valore (`lang::filament.forms.components.translation-editor`) |
| Policy | `Models\Policies\TranslationFilePolicy` su `LangBasePolicy` | permessi `translation_file.viewAny|view|create|update|delete|restore|forceDelete`; `super-admin` e `lang::admin` passano sempre (`before()`) |

La modifica scrive nel file della **lingua corrente dell'app** (`GetTransPathAction` usa `app()->getLocale()`): per tradurre in un'altra lingua si cambia lingua con il selettore
in testata, poi si apre il file.

## Lingue dell'editor

Sono le lingue in cui si **modificano** le traduzioni, distinte dalle lingue del sito ([laravel-localization-mcamara-reference.md](laravel-localization-mcamara-reference.md)).

- `Datas\LangConfigData` legge `config/{tenant}/lang.php` (trait `MakesFromTenantConfig`, file letto direttamente, non `config()`, per restare valido con `config:cache`):
  `supported_locales` (default `['it', 'en']`) e `default_locale` (default `null`, cioe' `app.locale`).
- `GetTranslatableLocalesAction` filtra le voci non stringa; una lista vuota (file del tenant rovinato) torna al default della Data.
  `GetDefaultTranslatableLocaleAction` restituisce `default_locale` solo se e' fra le lingue scelte, altrimenti il fallback del chiamante.
- `Filament\Pages\SettingPage` (`BaseSettingPage`, solo super-admin) scrive quel file: `default_locale` (select) e `supported_locales` (almeno una), con le opzioni di
  `ListLocaleOptionsAction` (lingue note a `laravellocalization`). Se il file del tenant non esiste valgono i default.
- Le lingue erano scritte a mano in quattro punti (`TranslationFileResource`, `LangBaseResource`, `EditTranslationFile`, `LocaleSwitcherRefresh`); ora passano tutte da qui.
  `LangBaseResource` (base per le risorse di altri moduli) espone gli stessi due metodi statici.
- Le chiavi `default_locale` e `available_locales` che `config/lang.php` del modulo dichiarava non le leggeva nessuno e sono state tolte.

## Sicurezza e limiti

- Il salvataggio da pannello non fa backup: scrive con `SaveTransAction::persist()` (serializzazione di `SaveArrayAction`). Backup e controllo `php -l` sono di `WriteTranslationFileAction`, oggi non collegata al pannello ([translation-files.md](translation-files.md)). Prima di modifiche massive conviene un commit o una copia dei file.
- Un file che non e' "dati puri" (chiama funzioni, usa variabili) si puo' leggere ma la sua riscrittura perde quelle espressioni: non salvarlo dal pannello.
