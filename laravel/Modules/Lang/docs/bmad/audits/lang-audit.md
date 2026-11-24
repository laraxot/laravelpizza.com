---
title: "Audit approfondito modulo Lang"
type: audit
status: review
updated: 2026-11-16
module: Lang
qmd: "audit approfondito Lang traduzioni AutoLabelAction SaveTransAction TranslatorAdapter registerTranslator non cablato Post fuori scope config lang.php non caricata test coverage schema user_id PHPStan Pest"
related:
  - ../audit.md
  - ../piano-miglioramento.md
  - ../purpose.md
  - ../architecture.md
  - ../epics.md
  - ../../ecc/lang-ecc-audit.md
  - ../stories/module-bmad-audit.story.md
---

# Audit approfondito — Lang

## Metodo

<<<<<<< .merge_file_goqCwG
<<<<<<< .merge_file_AatgRE
=======
=======
>>>>>>> .merge_file_o9Xq29
<<<<<<< HEAD
=======
<<<<<<< .merge_file_ng3muP
Source-first (2026-11-16): inventario filesystem, `rg` su policy/marker/label,
lettura purpose esistente, PHPStan globale Modules già a 0 errori. Nessuna UI
inventata. Pest dichiarato solo se eseguito.

## Inventario misurato

| Area | Conteggio |
|---|---:|
| PHP in `app/` | 72 |
| Test PHP | 51 |
| Models (`app/Models/*.php`) | 7 |
| Policy files (approx) | 8 |
| Resource Filament | 2 |
| Actions | 17 |
| Services | 0 |
| Migration | 11 |
| Lang IT files | 66 |
| Marker conflitto | 0 |
| Occorrenze `return true` in Policy | 2 |
| Ratio test/app | 0.71 |

## Scopo (da docs esistenti / codice)

## Lo scopo in una frase **Lang tiene fuori dal codice ogni parola che un utente legge: nessuna etichetta si scrive dentro una classe, si dichiara in un file di lingua.**

## Finding preliminari (da inventario)

- Nessun finding automatico critico dall'inventario; completare review sicurezza/runtime con story dedicate.

## Finding approfonditi (codice)

- **P1** Label hardcoded in `LocaleSwitcherRefresh` (`Select language` / `Cambia lingua`).
- **P2** Fallback UI `FIX:` in `AutoLabelAction`.
- Policy su `LangBasePolicy` + permission (ok relativo).

## Gate

```bash
cd laravel
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Lang
# Pest solo fuori da 10.100.200.15 e con DB testing raggiungibile
./vendor/bin/pest Modules/Lang/tests --no-coverage
```

PHPStan `Modules` (2026-11-16): **0 errori** sul tree completo.

## Piano

Vedi [piano-miglioramento.md](../piano-miglioramento.md).

## Riferimenti

- [audit.md](../audit.md)
- [ECC](../../ecc/lang-ecc-audit.md)
- [Story](../stories/module-bmad-audit.story.md)
=======
>>>>>>> .merge_file_JsV0G2
>>>>>>> laraxot/dev
<<<<<<< .merge_file_goqCwG
>>>>>>> .merge_file_djLNIz
=======
>>>>>>> .merge_file_o9Xq29
Source-first, 2026-11-16: inventario filesystem, `rg -n` con `path:line`, lettura di `LangServiceProvider`, `AutoLabelAction`, `SaveTransAction`, `WriteTranslationFileAction`, `TranslationFile`, `LocaleSwitcherRefresh`, `config/`; `php artisan tinker` (sola lettura di config); PHPStan sul modulo; Pest sullo scratch DB del repo. La documentazione è stata trattata come ipotesi: **dove codice e docs divergono vince il codice.** Nessuna UI o screenshot inventati; nessun comportamento a runtime del pannello è stato provato in un browser.

## Scopo (perché esiste)

Lang tiene fuori dal codice ogni parola che un utente legge ([purpose.md](../purpose.md)). Criteri usati: (1) ogni etichetta si risolve per convenzione da un file di lingua; (2) chi cura i testi li modifica senza toccare il codice; (3) una chiave mancante si vede e non si perde; (4) il salvataggio dei testi non può rompere le pagine.

## Inventario misurato

| Area | Conteggio | Come |
|---|---:|---|
| PHP in `app/` | 72 | `find app -name '*.php'` |
| PHP in `tests/` / `*Test.php` | 51 / 29 | |
| Models top-level | 7 | `BaseModel`, `BaseModelLang`, `BaseMorphPivot`, `LanguageLine`, `Post`, `Translation`, `TranslationFile` |
| Policy | 4 file | `LangBasePolicy` (abstract, `before()`) + `PostPolicy`, `TranslationPolicy`, `TranslationFilePolicy` |
| Filament Resource | 2 | `LangBaseResource` (base), `TranslationFileResource` |
| Pagine di Resource | 9 | |
| Widget | 1 | `LanguageSwitcherWidget` |
| Actions | 17 | 16 in `app/Actions` + `Filament/AutoLabelAction` |
| Services | **0** | nessuna directory `app/Services` |
| Migration | 11 | 3 "generazioni" di `create_posts`/`create_translations` (vedi P2) |
| Lang IT | 33 file | |
| Marker conflitto | 0 | |
| `strict_types` mancante | 0 | |
| `RefreshDatabase`, `migrate:fresh`, `dd()`/`echo` in `app/` | 0 / 0 / 0 | |
| `return true` in Policy | 2 | solo `LangBasePolicy::before()` (`:18,:23`): bypass `super-admin` e `lang::admin` voluto |
| Doc `.md` in `docs/` | 955 | 1 senza frontmatter, 111 con nome maiuscolo/datato |

Consumatori fuori modulo (file con `use Modules\Lang\`, esclusi i test): Xot 7, Notify 5, Performance 3, IndennitaResponsabilita 1, UI 1. **Activity non usa Lang.**

## Quadro per area

| Area | Evidenza | Sev |
|---|---|---|
| Tracker "chiavi mancanti" su DB | `registerTranslator()` commentato in `boot()`; `TranslatorTrait` usato solo da una classe-sonda PHPStan; `translations`/`LanguageLine` senza scrittore in produzione | **P1** |
| Docs vs codice | architecture cita classi/tabelle inesistenti; decision-log con voci di esempio fittizie; epics e purpose template | **P1** |
| Test | 4 file "coverage" da 2.248 righe; 13/23 fail in `tests/Feature` su scratch DB (`user_id` bigint vs UUID) | **P1** |
| Stringhe hardcoded nel modulo che le vieta | `LocaleSwitcherRefresh.php:34,45` | P2 |
| `config/lang.php` mai letto | 12 blocchi di config, 0 consumatori | P2 |
| `Post` (CMS) dentro Lang | 223 righe + 6 migration/seeder/factory/policy, nessun consumatore fuori da Lang | P2 |
| Codice morto | `WriteTranslationFileAction`, `ReadTranslationFileAction`: solo test | P2 |
| `CreateTranslationFile` | modello Sushi in memoria: la creazione non scrive su disco | P2 |

## Finding

### P1-1 — Il tracker "chiavi mancanti su DB" non è cablato

- `app/Providers/LangServiceProvider.php:43` — `// $this->registerTranslator();` commentato nel `boot()`; il metodo esiste (`:147`) ma nessuno lo chiama.
- `app/Providers/Traits/TranslatorTrait.php:13` — versione alternativa di `registerTranslator()`; l'unico `use TranslatorTrait` in `app/` è `Providers/TranslatorTraitPhpstanProbe.php:13`, una classe «sonda» che esiste solo perché PHPStan analizzi il trait.
- `Adapters/TranslatorAdapter.php:70` → `RecordMissingTranslationAction` → `Translation::firstOrCreate`: unico scrittore di `translations` in produzione (`rg 'Translation::' app` → solo quella riga); altrimenti solo `database/seeders/TranslationSeeder.php:50`.
- Effetto sullo scopo (criterio 3): la tabella `translations` e `LanguageLine` non si popolano da sole; la «chiave mancante» oggi non lascia traccia su DB. L'unico meccanismo vivo è `SaveTransAction` (file, solo in `local`, vedi non-finding).
- **Non provato a runtime** se `XotBaseServiceProvider` registri comunque il translator: la ricerca di `registerTranslator` fuori da Lang non è stata estesa a Xot.

**Fix (scelta in D-2):** o cablare `registerTranslator` con `TranslatorTrait` (unica versione) e un Pest sulla chiave mancante, oppure ritirare `Translation`/`LanguageLine`/`TranslatorAdapter`/`RecordMissingTranslationAction` e la sonda.

### P1-2 — Documentazione che contraddice il codice

- `docs/bmad/architecture.md` (versione precedente) elencava `ValidateTranslationsAction` e `LangResource` (**non esistono**: `find app -name 'ValidateTranslationsAction*' -o -name 'LangResource.php'` → vuoto), una tabella `lang_table` (**non esiste** nelle migration) e «usato da Activity, Notify»: Activity non importa Lang. Riscritta: [architecture.md](../architecture.md).
- `docs/bmad/decision-log.md` conteneva solo voci di esempio fittizie («Filament Widget invece di Livewire»); `epics.md` era template; `purpose.md` troncato. Sistemati in questo giro: [decision-log](../decision-log.md), [epics](../epics.md), [purpose](../purpose.md).
- `docs/business-logic-overview.md` ripete le stesse classi inesistenti (non riscritto: fuori pack, segnalato in E5).

### P1-3 — Test: copertura inseguita e suite non verde su scratch DB

- `tests/Unit/LangHundredPercentCoverageTest.php` (935 r.), `LangFinalGapsTest.php` (585), `LangCoverageGapsTest.php` (389), `LangCoverageBoostTest.php` (339): 2.248 righe nominate per la percentuale, non per un comportamento; nel modulo c'è `tests/Unit` **e** `tests/unit` (due alberi).
- `bashscripts/tools/pest-scratch-db.sh Modules/Lang/tests/Feature` → **10 pass, 13 fail**. Causa, dall'errore SQL: `Data truncated for column 'user_id'` / `Incorrect integer value: '<uuid>' for column posts.user_id` in `LangBusinessLogicTest.php:20,42,61,…` (`UserFactory` crea utenti UUID). La migration di correzione esiste (`2026_11_05_100000_update_user_id_uuid_on_posts_table.php`, converte solo se la colonna è ancora bigint): lo scratch clona la struttura del DB sorgente, quindi **ipotesi** — nel DB sorgente la conversione non risulta applicata. Non verificato con `migrate:status` e **non corretto da me** (dati sacri: solo migrate additivo, in carico a chi gestisce quel DB).

**Fix:** applicare la migration sul DB sorgente (additiva); sostituire i 4 file "coverage" con test di comportamento (E3).

### P2

- **Hardcoded nel modulo che lo vieta.** `Filament/Actions/LocaleSwitcherRefresh.php:34` `->label('Select language')` (inglese) e `:45` `->modalHeading('Cambia lingua')` (italiano): due lingue diverse, nessuna chiave. Altre occorrenze di `->label()` letterale in `app/`: `Forms/Components/TranslationEditor.php:37` (`''`, vuota di proposito) e `AutoLabelAction.php:139` (`'FIX:'.$label_key`, marcatore di chiave assente voluto).
- **Config morta.** `config/lang.php` (12 blocchi: `cache`, `validation`, `auto_translate`, `security`, `business`, …) viene caricata come `lang.lang.*` (`config('lang')` ha chiavi `name`, `config`, `lang`) e nessuno legge `lang.lang.*` (`rg` → 0). `save_missing_translations => true` (`:211`) è inoltre fuorviante: `SaveTransAction.php:33` legge `lang.save_missing_translations` (assente) con default `app()->isLocal()`. Il commento di `config/lang.php` lo ammette; il valore va tolto.
- **`Post` fuori scope.** `Models/Post.php` (223 r., SEO, slug, stato editoriale) + `PostPolicy`, `PostFactory`, `PostSeeder`, 5 migration: nessun consumatore fuori da Lang (`rg 'Modules\\Lang\\Models\\Post'` fuori da Lang → solo `Media/tests/Unit/Models/MediaTest.php`). Un modello di contenuto editoriale dentro il modulo che «tiene le parole fuori dal codice» ha confini poco chiari (D-3).
- **Codice morto.** `WriteTranslationFileAction` e `ReadTranslationFileAction`: nessun caller in `app/` di alcun modulo (solo `tests/` e `Fixtures/`). `WriteTranslationFileAction::clearTranslationCache()` fa `cache->flush()` dell'intera cache e `validatePhpSyntax()` esegue `exec("php -l {$tempFile}")`: innocua finché è morta, pericolosa se qualcuno la cabla.
- **`CreateTranslationFile` non crea nulla.** `TranslationFile` è un modello Sushi (`use Sushi`, righe lette dal disco): la pagina di creazione compila una riga in memoria, senza scrivere un file di lingua. Dedotto dal codice, non provato in UI.
- **Percorso da chiave + locale di sessione.** `GetTransPathAction.php:26-35` compone `$langPath/$lang/$piece[0].php`; nel ramo `catch` il namespace entra senza allowlist in `base_path('Modules/'.$ns.'/lang')`. Oggi `$key` arriva dal record (righe lette dal disco) e `$lang` da `LocaleSwitcherRefresh::applyLocale()` (`:61`) senza controllo sulle lingue consentite (il `Select` filtra in UI). Difesa in profondità mancante, non sfruttabile dalla sola lettura del codice.
- **Migration a tre generazioni.** `create_posts_table` e `create_translations_table` esistono in 3 versioni (`2026_01_21`, `2026_08_06`, `2026_11_05`) più 3 `update_*`: sicure perché `tableCreate()` salta se la tabella esiste (`XotBaseMigration.php:298`), ma illeggibili.

## Verificato e non è un finding

- Policy: `LangBasePolicy::before()` con bypass `super-admin`/`lang::admin`; le tre policy figlie non hanno `return true` (deny-by-default per permessi di risorsa: `translation_file.*`, `post.*`).
- `SaveTransAction::execute()` scrive solo se `lang.save_missing_translations === true`, default `app()->isLocal()` (`:33`); `persist()` non riscrive un file illeggibile (`:68-75`) e usa `SaveArrayAction` (SSoT Xot) per la scrittura.
- `Translation::scopeSelectDistinctGroup` usa `DB::raw` su una stringa costante per driver (`:106-111`): nessun input.
- 0 `strict_types` mancanti, 0 marker, 0 `RefreshDatabase`, 0 `dd()`.

## Gate

| Gate | Esito |
|---|---|
| PHPStan `Modules/Lang` (`php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Lang --no-progress`) | **0 errori** (exit 0) |
| Pest `Modules/Lang/tests/Feature` (scratch DB, host 127.0.0.1) | **parziale: 10 pass, 13 fail** per schema `user_id` (P1-3); `tests/Unit` non eseguito per carico macchina (load ≈ 50) |

Nessun `migrate:fresh`, nessun `--force`, nessun `RefreshDatabase` lanciati dall'audit. Pest si esegue solo fuori dalla produzione e con DB di test raggiungibile.

Una revisione precedente di questo audit (inventario automatico) riportava 8 policy e 66 file di lingua IT: conteggi approssimati, non confermati dal filesystem (ricontrollo 2026-11-19: 4 policy, 33 file in `lang/it`).

## Piano

[piano-miglioramento.md](../piano-miglioramento.md) · [epics.md](../epics.md) · [decision-log.md](../decision-log.md).

## Riferimenti

[Sintesi](../audit.md) · [ECC](../../ecc/lang-ecc-audit.md) · [Story](../stories/module-bmad-audit.story.md) · [Brainstorming](../brainstorming.md)
