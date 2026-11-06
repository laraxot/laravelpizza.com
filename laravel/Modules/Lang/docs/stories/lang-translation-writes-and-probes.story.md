---
title: "Lang: scritture di traduzione in produzione, sonde PHPStan e residui Livewire"
type: story
status: ready-for-dev
priority: P1
created: 2026-10-20
updated: 2026-10-20
module: Lang
epic: ../../../Xot/docs/bmad/epic-code-quality-ratchet.md
depends_on:
  - ../../../Xot/docs/stories/test-database-guard.story.md
  - ./docs-lang-studio.story.md
  - ./12.1.retire-lang-http-switchers.story.md
tags: [bmad, lang, save-trans, config, lock, atomic-write, probe, livewire, sqlite, w1, w2, w4]
---

# Lang: scritture di traduzione in produzione, sonde PHPStan e residui Livewire

Fase BMAD: Create Story (waves W1, W2 e W4 dell'epic, lane Lang, riga n. 5). Solo documentazione: nessun PHP toccato per scriverla.

## Richiesta

Ordine permanente dell'utente (2026-10-20): "migliora qualità codice , fa tutto con bmad + second brain + filament blueprint". Qui: capire perche' il modulo Lang riscrive file di lingua durante le richieste e togliere i silenziatori che coprono codice morto. Epic: [epic-code-quality-ratchet](../../../Xot/docs/bmad/epic-code-quality-ratchet.md). Lo scopo del writer e' gia' ricostruito in [docs-lang-studio](./docs-lang-studio.story.md) (analisi del 2026-10-14): non si ripete. Il ritiro degli switcher e' in [12.1](./12.1.retire-lang-http-switchers.story.md): qui solo il residuo.

## Scopo

- `Actions/SaveTransAction.php` scrive in `Modules/<M>/lang/<locale>/<file>.php` la chiave mancante, con un testo di ripiego, cosi' chi sviluppa vede subito l'etichetta nuova da tradurre. E' chiamata da `AutoLabelAction` (`Actions/Filament/AutoLabelAction.php:115`, registrata con `configureUsing` su Select, Field, Entry, Section, Column, Action), da `Xot/.../NavigationLabelTrait.php:61`, `TransFuncTrait.php:124` e da `EditTranslationFile.php:137`. In produzione conta perche' una richiesta di lettura puo' diventare una scrittura su disco.
- `TranslatorAdapter` + `RecordMissingTranslationAction` dovevano registrare le chiavi mancanti nel DB (`Translation`): scopo diverso e parallelo al writer su file.
- `TranslatorTrait` e `HasStrictTranslations` sono trait di quell'idea. `Providers/TranslatorTraitPhpstanProbe.php` esiste solo per far "usare" il primo e zittire PHPStan.

## Stato misurato

Misura del 2026-10-20 tra le 13:35 e le 14:05 UTC. Cifre volatili.

- `SaveTransAction.php:30`: `Config::get('lang.save_missing_translations', ! app()->runningUnitTests())` e' acceso di default fuori dai test, quindi in produzione. `config/lang.php:211` lo mette a `true`, ma il file viene registrato come `lang.lang` (`Xot/app/Providers/XotBaseServiceProvider.php:199` fa `Config::set($this->nameLower.'.'.$filename, ...)` e `LangServiceProvider` non ridefinisce `registerConfig`): la chiave letta e' sempre `NULL` a runtime (tinker del 2026-10-14 in `docs-lang-studio`). Spegnerlo con la config non funziona senza correggere il nome.
- Nessun lock, nessuna scrittura atomica: lettura con `File::getRequire` (riga 46) e scrittura con `SaveArrayAction` (riga 73) che arriva a `Xot/.../SavePhpArrayAction.php:31`, `file_put_contents` senza `LOCK_EX` ne' rename. Due richieste concorrenti perdono una delle due chiavi. Lo schema atomico esiste gia' in repo: `Xot/app/Actions/File/AssetAction.php:189-200` (copia su temporaneo e `rename`).
- Il `dddx` nel `catch` non c'e' piu' nel working tree: `git -C laravel/Modules/Lang diff -- app/Actions/SaveTransAction.php` mostra `report($e); return;` (file modificato alle 13:24, non committato, di un'altra sessione). `catch (\Exception)` non prende `ParseError`, che `require` solleva su un file corrotto.
- `registerTranslator()`: `rg -n 'registerTranslator' laravel/Modules/Lang/app` trova la definizione `LangServiceProvider.php:147`, il trait `TranslatorTrait.php:14` e la chiamata commentata `LangServiceProvider.php:43`; nessuna chiamata attiva (controprova: `rg -n 'registerFilamentLabel' laravel/Modules/Lang/app` trova la chiamata attiva alla riga 45). `TranslatorAdapter` e' costruito solo da quei due punti.
- Sonda e ignore: `rg -n 'phpstan-ignore' laravel/Modules/Lang/app` stampa `Models/Traits/HasStrictTranslations.php:12` e `Providers/Traits/TranslatorTrait.php:11` (`trait.unused`). `TranslatorTraitPhpstanProbe` (`final class ... extends XotBaseServiceProvider`, `use TranslatorTrait`) e' istanziata solo da `tests/Unit/LangHundredPercentCoverageTest.php:58,888`; `HasStrictTranslations` solo dal fixture `tests/Fixtures/StrictTranslationsHost.php:12`, usato a `LangHundredPercentCoverageTest.php:679`.
- Livewire: `Http/Livewire/Lang/{Change,Switcher}.php` sono cancellati dal commit `30be5133` (2026-10-20 12:17 UTC); l'ultima modifica `9dd9c955` (10:29 UTC, normalizza la locale) e' precedente, quindi non c'e' conflitto. Resta `app/Http/Livewire/` con `.gitkeep` e `_components.json` (`[]`): la guardia `Xot/tests/Unit/NoLivewireDirectoriesInModulesTest.php:21-30` pretende zero cartelle `Modules/*/app/Http/Livewire`. Il gemello `Filament/Widgets/LanguageSwitcherWidget.php` e' montato in `UI/resources/views/components/headernav/simple.blade.php:59`; i tag `<livewire:lang.change>` rimasti in Cms sono commentati (`Cms/resources/views/components/headernav/simple.blade.php:43`).
- `Filament/Actions/LocaleSwitcherRefresh.php` (usata da `TranslationFilesTable.php:32`): `redirect(request()->header('Referer'))` alla riga 43 senza validare l'host; etichette con testo alle righe 34 e 45.
- Test: wiring sqlite in `tests/TestCase.php:32-48` (rimappa ogni connessione sqlite su `database/database.sqlite`) e file temporanei in `LangCoverageGapsTest.php:70-100` e `LangHundredPercentCoverageTest.php:117-146` (contro la regola MySQL, decisione 7.4 dell'epic). Skip: il censimento ne contava 6, ma `rg -n -e '(->|\b)(skip|todo|markTestSkipped)\w*\(' laravel/Modules/Lang/tests` stampa 0 (controprova: stesso pattern su `laravel/Modules/Activity/tests` ne stampa 20): i 6 erano parole "skip" nei nomi dei test. 4 tautologie `assertGreaterThanOrEqual(0, ...)` in `tests/Unit/Actions/GetAllTranslationActionTest.php:22,39,47,53`.

## Lavoro

1. `SaveTransAction.php:30`: default spento fuori da `local` (`Config::get('lang.save_missing_translations', app()->isLocal())`) e correggere il nome letto (`lang.lang.save_missing_translations`) oppure decidere con l'utente sul prefisso (decisione 1). Il test `SaveTransActionRespectsSwitchTest` imposta la chiave a mano e non prova il default. Rischio medio: chi oggi dipende dalla scrittura in staging.
2. Lock e scrittura atomica: avvolgere lettura e scrittura in `Cache::lock('lang-save:'.$filename)` e scrivere su temporaneo piu' `rename` (da riusare nello `SavePhpArrayAction` di Xot: coordinare con la lane Xot). Sostituire `catch (\Exception)` con `\Throwable` (ParseError). Rischio medio.
3. Decidere il destino di `TranslatorAdapter`: agganciarlo (decommentare `LangServiceProvider.php:43`) o cancellare `TranslatorAdapter`, `RecordMissingTranslationAction`, `TranslatorTrait`, `TranslatorTraitPhpstanProbe`, `HasStrictTranslations` e i test collegati (righe 58, 679, 862-890 di `LangHundredPercentCoverageTest`, il fixture). Cancellare e' la scelta della regola 25; mai un altro ignore. Rischio basso. Decisione 2.
4. Cancellare `app/Http/Livewire/` (due file) e annotare in coda alla 12.1 che i punti 1-5 dei suoi task sono chiusi dal `30be5133`. Rischio basso.
5. `LocaleSwitcherRefresh.php:43`: redirect solo verso lo stesso host; righe 34 e 45 verso chiavi `lang::`. Rischio basso.
6. Test: portare `TestCase` e i 2 test inline a MySQL con tabella temporanea (modello: Quaeris `GetAnswersByQuestionChartTest.php`) dopo la decisione 7.4; sostituire le 4 tautologie con asserzioni sul contenuto. Rischio medio.

## Acceptance criteria

- [ ] `rg -n 'phpstan-ignore' laravel/Modules/Lang/app` stampa 0 righe (prima: 2) e `/usr/bin/find laravel/Modules/Lang/app -name '*Probe*'` stampa 0 file.
- [ ] `ls laravel/Modules/Lang/app/Http/Livewire` risponde "No such file or directory" (controprova: `ls laravel/Modules/Lang/app/Http`).
- [ ] Con `APP_ENV=production` simulato nel test di `SaveTransAction` la chiave non viene scritta (test scritto, eseguito solo dopo la guardia DB); con lock, due scritture concorrenti conservano entrambe le chiavi.
- [ ] `rg -n 'file_put_contents' laravel/Modules/Xot/app/Actions/Arr/SavePhpArrayAction.php` non e' piu' l'unico passo di scrittura (rename atomico presente).
- [ ] `rg -n 'registerTranslator' laravel/Modules/Lang/app` coerente con la decisione 2 (0 righe, oppure una chiamata attiva).
- [ ] `phpstan analyse` mirato sui file toccati: `[OK] No errors`; nessun ignore, nessun `mixed` nuovo.

## Verifica

Da `laravel/`, solo lettura: i comandi di "Stato misurato". Ogni zero va controprovato con il comando gemello. Non lanciare nessun test di Lang prima del via sulla guardia: `SaveTransAction` riscrive i file di lingua dell'albero di lavoro (vedi `docs-lang-studio`).

## Vincoli

Nessun Pest/PHPUnit finche' la guardia DB (`Xot/tests/Support/TestDatabaseGuard.php`) non e' dentro e l'utente non ha confermato che i DB `*_test` sono usa-e-getta; in Lang vale anche per il rischio di riscrivere `lang/`. PHPStan solo mirato, in coda `flock` di `bashscripts/docs/prompts/11-phpstan.md`; un solo run completo, a swarm fermo e a RAM libera. Un solo agente per modulo che edita PHP (oggi `SaveTransAction.php` e' di un'altra sessione). `laravel/phpstan.neon` immutabile. Forward-only. Pest resta Pest. Niente nuovi `*Service`: il lock e' in `execute()` di una Action. Niente `mixed`, `@var` o ignore di comodo.

## Decisioni aperte

1. Prefisso della config di modulo: leggere `lang.lang.*` o cambiare `registerConfig` di Xot (tocca tutti i moduli)?
2. Registrare le chiavi mancanti nel DB (agganciare l'adapter) oppure ritirare tutto?
3. La scrittura delle chiavi mancanti deve restare in staging?

## Come ripartire

1. Chiedere alla sessione che ha `SaveTransAction.php` aperto di finire; rileggere il file e `git -C laravel/Modules/Lang status --short app`.
2. Scrivere il test (non eseguirlo) per il default spento fuori da `local` e per il nome di config, poi il fix del punto 1.
3. Aprire la decisione 2 con l'utente; se e' "cancella", il punto 3 e 4 sono a rischio basso e si fanno in un colpo.
