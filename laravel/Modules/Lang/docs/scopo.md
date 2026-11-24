---
issues: []
discussions: []
title: "Lang — scopo, confini e come servirlo meglio"
type: concept
module: Lang
status: active
created: 2026-09-02
updated: 2026-09-02
tags: [scopo, confini, servizio-trasversale, traduzioni, i18n, autolabel, dipendenze]
qmd: "scopo lang traduzioni autolabel savetransaction scrittura file lang confini dipendenze codice morto translatoradapter"
---

# Lang — scopo, confini e come servirlo meglio

## Lo scopo, dedotto dal codice

Lang è il modulo più piccolo dei tre servizi trasversali — 62 file PHP, 4.545 righe in
`app/` — e ha l'effetto più esteso di tutti: governa **2.920 file `lang/*.php`**
distribuiti su tutti i moduli e i temi del repo
(`find Modules Themes -path '*/lang/*' -name '*.php' | wc -l`). Quarantasette righe di
codice per ogni file di traduzione che tiene in piedi.

Il meccanismo che gli dà quel potere sta in un solo metodo:
`LangServiceProvider::registerFilamentLabel()`. Al boot registra otto `configureUsing()`
sui tipi base di Filament — `Field`, `Select`, `Entry`, `Section`, `BaseFilter`,
`Column`, `Step`, `Action` — e per ognuno chiama `AutoLabelAction`, che deriva la chiave
di traduzione dal nome del componente e dal modulo chiamante
(`grep -oP '^\s+\K\w+(?=::configureUsing)' app/Providers/LangServiceProvider.php | sort -u`).
È per questo che nel resto
del progetto si scrive `TextInput::make('email')` senza `->label()`: la label arriva da
qui, sempre, per ogni componente di ogni form di ogni modulo.

Il secondo lato dello stesso meccanismo è ciò che rende Lang diverso da una libreria di
lettura: **quando la chiave manca, Lang la scrive**. `AutoLabelAction` chiama
`SaveTransAction`, che apre il file `lang/{locale}/{gruppo}.php` del modulo, ci inserisce
la chiave mancante e lo risalva. Un modulo di traduzione che scrive sui sorgenti
tracciati da git non è un dettaglio implementativo: è la caratteristica che definisce il
suo scopo e il suo rischio.

| Fatto | Dove si verifica | Cosa significa |
|---|---|---|
| 8 `configureUsing()` sui tipi base Filament | `app/Providers/LangServiceProvider.php:48-142` | l'autolabel non è opzionale: è attivo su ogni componente del progetto |
| `SaveTransAction` scrive `lang/*.php` | `app/Actions/SaveTransAction.php:70` | le traduzioni mancanti si materializzano da sole nei sorgenti |
| 3 migrazioni, 4 modelli, `TranslationFile` è `Sushi` | `app/Models/TranslationFile.php:47` | il DB non è la fonte di verità: i file `.php` lo sono |
| 14 Action su 14 usano `QueueableAction` | `grep -rl QueueableAction app/Actions` | nessun oggetto di dominio, solo verbi |

Da qui la formulazione in una riga:

> **Lang è la convenzione che rende inutile scrivere `->label()`: deriva la chiave di
> traduzione dal componente e dal modulo, la risolve dai file `lang/` e — quando manca —
> la scrive lui. La fonte di verità sono i file PHP versionati, non il database.**

I consumatori espliciti sono pochi perché il consumo vero è implicito, via
`configureUsing()`. Misurati il 2026-09-02 con
`grep -rl 'Modules\\Lang\\' Modules/<Modulo>` (esclusi `docs/`, `vendor/`,
`node_modules/`): Xot (8 file), Notify (4), Performance (4), IndennitaResponsabilita (2),
UI (1), Incentivi (1). Il simbolo più importato è `SaveTransAction` (10 occorrenze),
seguito da `TransCollectionAction` (2) e dalle classi base Filament `LangBase*` che
`Notify` usa per `MailTemplateResource`.

Le dipendenze uscenti sono minime e corrette: Xot in 42 file, e nient'altro tranne una
violazione (sotto).

## I confini, e dove oggi sono rotti

### La scrittura sui file `lang/` è protetta da una guardia in cui nessuno crede

`SaveTransAction::execute()` (righe 25-33) apre così:

```php
if (app()->runningUnitTests()) {
    $allow = filter_var(
        config('lang.persist_trans_in_tests', $_ENV['LANG_PERSIST_TRANS_IN_TESTS'] ?? false),
        FILTER_VALIDATE_BOOLEAN,
    );
    if (! $allow) {
        return;
    }
}
```

Il commento sopra dichiara il motivo: *"In Pest/PHPUnit AutoLabel (Filament
configureUsing) chiama SaveTrans su chiavi mancanti: senza guard i file
Modules/\*/lang/\*.php vengono corrotti a metà suite."*

La guardia ha due punti deboli, entrambi verificabili:

1. **La chiave di config non esiste.** `config/lang.php` dichiara `default_locale`,
   `cache`, `validation`, `auto_translate`, `filament`, `structure`, `debug`,
   `performance`, `security`, `business`, `laraxot` — **non** `persist_trans_in_tests`.
   La `config()` cade sempre sul default, quindi il comportamento dipende interamente da
   `$_ENV`, cioè da una variabile che i `TestCase` impostano a mano con `putenv()`.
2. **`runningUnitTests()` non è una proprietà del processo, è una lettura di
   `config('app.env')`.** Se la config è in cache con un `env` diverso da `testing`, la
   guardia non scatta e la scrittura procede — sotto Pest come in produzione.

La prova che il progetto non si fida di quella guardia è nel codice: **quattro moduli
diversi ridefiniscono a mano lo stesso stub no-op**, ognuno con il proprio nome, per
disinnescare `SaveTransAction` prima del boot dei test.

```bash
grep -rn 'extends SaveTransAction' Modules --include='*.php'
```

| File | Classe |
|---|---|
| `Modules/Lang/tests/TestCase.php:25` | `SaveTransActionNoOpStub` |
| `Modules/Performance/tests/TestCase.php:17` | `PerformanceSaveTransActionNoOpStub` |
| `Modules/Incentivi/tests/TestCase.php:21` | `IncentiviSaveTransActionNoOpStub` |
| `Modules/IndennitaResponsabilita/tests/TestCase.php:21` | `IrSaveTransActionNoOpStub` |

Quattro copie della stessa riga vuota. Una guardia che funziona non ha bisogno di essere
ricostruita da ogni modulo che la usa; quattro workaround identici sono una misura del
fatto che non funziona abbastanza.

I chiamanti in produzione sono 9, e nessuno di essi è dentro un test:
`Ptv\Filament\Resources\BaseSchedaResource:181`, `Xot\Filament\Traits\TransFuncTrait:121`,
`Xot\Filament\Traits\NavigationLabelTrait:61`, `Xot\Actions\Filament\AutoLabelAction:84`,
tre resource di `Performance`, `Lang\Filament\...\EditTranslationFile:120` e
`Lang\Actions\Filament\AutoLabelAction:77`.

### Una scrittura di traduzione svuota tutta la cache dell'applicazione

`WriteTranslationFileAction::clearTranslationCache()` chiama `app('cache')->flush()`.
Non invalida le chiavi di traduzione: **svuota l'intero store di cache**. Ogni salvataggio
di un file `lang/` azzera sessioni cachate, query cachate, permessi cachati e qualunque
altra cosa il progetto tenga in cache. Il metodo poi tenta anche il `flush()` mirato sul
`translation.loader`, che è la cosa giusta — ma arriva dopo, quando il danno è già fatto.

### Il TranslatorAdapter è morto in produzione e vivo solo nei test

`app/Adapters/TranslatorAdapter.php` estende il `Translator` di Laravel per intercettare
le chiavi mancanti. Esistono **due** modi per registrarlo:

- `LangServiceProvider::registerTranslator()` (riga 144), che però **non è chiamato**:
  in `boot()`, riga 43, la chiamata è commentata — `// $this->registerTranslator();`
- `Providers\Traits\TranslatorTrait::registerTranslator()`, una seconda implementazione
  dello stesso override, composta da nessun provider reale.

L'unica classe che compone `TranslatorTrait` è
`app/Providers/TranslatorTraitPhpstanProbe.php`, il cui docblock lo dichiara senza giri
di parole: *"Probe host so PHPStan analyses TranslatorTrait in app context."* È una
classe di produzione che esiste solo per far vedere del codice all'analizzatore statico.

Gli unici chiamanti di `registerTranslator()` sono in
`tests/Unit/LangHundredPercentCoverageTest.php` (righe 888 e 903). Lo stesso vale per
`app/Services/TranslatorService.php`: nessun riferimento in `app/`, solo in tre file di
test. Il nome del file di test che li tiene in vita —
`LangHundredPercentCoverageTest` — dice cosa è successo: la ricerca del 100% di
copertura ha coperto codice morto invece di cancellarlo, e adesso quel codice ha dei
test, quindi sembra vivo.

### `AutoLabelAction` esiste due volte, e la copia in Xot non è usata da nessuno

| File | Righe | Chiamanti |
|---|---:|---|
| `Modules/Lang/app/Actions/Filament/AutoLabelAction.php` | 159 | `LangServiceProvider` (8 `configureUsing()`) |
| `Modules/Xot/app/Actions/Filament/AutoLabelAction.php` | 118 | **nessuno** — solo un `@see` in `XotBaseWizardWidget:52` |

La copia in Xot è marcata `-WIP` nel docblock di testa, importa
`Modules\Lang\Actions\SaveTransAction` e non viene istanziata da nessuna parte. Oltre a
essere morta, crea una dipendenza `Xot -> Lang` che la piattaforma base non dovrebbe
avere.

### `Lang` conosce `Ptv` in tre righe di PHPDoc

```bash
grep -rn 'Modules\\Ptv\\' Modules/Lang/app
```

```
app/Models/LanguageLine.php:33: * @property-read \Modules\Ptv\Models\Profile|null $creator
app/Models/LanguageLine.php:34: * @property-read \Modules\Ptv\Models\Profile|null $deleter
app/Models/LanguageLine.php:35: * @property-read \Modules\Ptv\Models\Profile|null $updater
```

Un servizio trasversale che tipizza sul profilo di un modulo foglia rende il modulo
foglia non sostituibile. È lo stesso identico difetto già misurato in Sigma (271
occorrenze) e la correzione è la stessa: `Modules\Xot\Contracts\ProfileContract`. Qui
costa tre righe.

### `app/Services/` esiste ancora

Un file: `app/Services/TranslatorService.php`. Viola la policy no-services
(`bashscripts/ai/wiki/rules/no-services-rule.md`) ed è morto in produzione (sopra). Non
va convertito in Action: va cancellato.

### La documentazione è 32 volte il codice

| Misura | `app/` | `docs/` | Rapporto |
|---|---:|---:|---:|
| File | 62 `.php` | 704 `.md` | 11 : 1 |
| Righe | 4.545 | 145.101 | **32 : 1** |

**443 dei 704 file stanno piatti nella root di `docs/`**, e ci sono 20 gruppi di file
`.md` byte-identici. Meno grave di Notify in valore assoluto, identico come sintomo.

## Come servire meglio lo scopo

### 1. Spostare la guardia dal runtime alla registrazione

File: `app/Actions/SaveTransAction.php`, `config/lang.php`,
`Modules/{Lang,Performance,Incentivi,IndennitaResponsabilita}/tests/TestCase.php`.

Due passi, nell'ordine. Primo: dichiarare davvero `'persist_trans_in_tests' => false` in
`config/lang.php`, così la chiave letta esiste. Secondo — quello che chiude il problema —
smettere di chiedere a runtime "sono in un test?" e decidere **al binding**: il
`TestCase` base di Xot registra l'implementazione no-op nel container una volta sola, e
i quattro stub duplicati nei moduli spariscono. Una guardia che sta nel container non
può essere aggirata da una config in cache, perché non legge nessuna config.

```bash
cd laravel
grep -rn 'extends SaveTransAction' Modules --include='*.php' | wc -l   # 4 -> 1 (solo in Xot)
grep -n 'persist_trans_in_tests' Modules/Lang/config/lang.php          # deve trovare la chiave
```

### 2. Non svuotare la cache dell'applicazione per una traduzione

File: `app/Actions/WriteTranslationFileAction.php`, metodo `clearTranslationCache()`.
Togliere `app('cache')->flush()` e tenere solo il `flush()` sul `translation.loader`, già
presente due righe sotto. Se serve invalidare una cache applicativa, si usa un tag o un
prefisso (`config('lang.cache.prefix')` esiste già e vale `lang_translations`), non la
bomba.

```bash
cd laravel
grep -n "cache')->flush()" Modules/Lang/app/Actions/WriteTranslationFileAction.php  # obiettivo: 0
```

### 3. Decidere se il TranslatorAdapter serve, e agire di conseguenza

File: `app/Providers/LangServiceProvider.php:43`, `app/Providers/Traits/TranslatorTrait.php`,
`app/Providers/TranslatorTraitPhpstanProbe.php`, `app/Services/TranslatorService.php`,
`app/Adapters/TranslatorAdapter.php`.

Due esiti possibili, nessun terzo. Se l'intercettazione delle chiavi mancanti serve, si
decommenta la riga 43, si cancella `TranslatorTrait` (duplicato) e con esso il probe
PHPStan che esiste solo per ospitarlo. Se non serve, si cancellano `TranslatorAdapter`,
`TranslatorTrait`, il probe, `TranslatorService` e i test che li tengono in vita. Lo
stato attuale — codice morto con copertura al 100% — è l'unico esito da non conservare.

```bash
cd laravel
grep -rn 'TranslatorService\|TranslatorTraitPhpstanProbe' Modules/*/app | wc -l   # obiettivo: 0
find Modules/Lang/app/Services -type f ! -name '.gitkeep' | wc -l                 # obiettivo: 0
```

### 4. Un solo `AutoLabelAction`

File: `Modules/Xot/app/Actions/Filament/AutoLabelAction.php` (da cancellare),
`Modules/Xot/app/Filament/Widgets/XotBaseWizardWidget.php:52` (il `@see` da ripuntare
sulla versione di Lang).

L'autolabel è di Lang: è Lang che conosce i file `lang/`, le convenzioni di chiave e i
locale. Una copia in Xot fa dipendere la piattaforma base dal servizio di traduzione,
che è la direzione sbagliata.

```bash
cd laravel
find Modules -name 'AutoLabelAction.php' -not -path '*/docs/*' | wc -l   # 2 -> 1
grep -rl 'Modules\\Lang\\' Modules/Xot/app | wc -l                       # deve calare
```

### 5. Tipizzare `LanguageLine` sul contratto

File: `app/Models/LanguageLine.php`, righe 33-35. Sostituire
`\Modules\Ptv\Models\Profile` con `\Modules\Xot\Contracts\ProfileContract`.

```bash
cd laravel
grep -rl 'Modules\\Ptv\\' Modules/Lang/app | wc -l   # obiettivo: 0
./vendor/bin/phpstan analyse Modules/Lang            # deve restare a 0 errori
```

## Cosa NON è compito di Lang

- **Non** traduce. Non c'è nessun motore di traduzione automatica nel codice: la sezione
  `auto_translate` di `config/lang.php` ha `'enabled' => false`, `'api_key' => null` e
  nessun consumatore. Lang sincronizza chiavi fra locale (`SyncTranslationsAction`), non
  ne inventa il contenuto.
- **Non** è la fonte di verità delle traduzioni. Lo sono i file `lang/*.php` versionati.
  `TranslationFile` è un modello `Sushi` — legge i file, non li possiede — e
  `LanguageLine` è un complemento, non un sostituto.
- **Non** conosce i moduli foglia. Non deve sapere cos'è una scheda, una progressione o
  un profilo Ptv: il profilo si tipizza su `Xot\Contracts\ProfileContract`.
- **Non** decide *cosa* si chiama un campo. Decide *dove* cercare quel nome. Il testo
  italiano sta nei file `lang/` del modulo proprietario, ed è il modulo proprietario a
  risponderne.
- **Non** ha una tabella `mylog`: non è un modulo di dominio, non ha un flusso da
  tracciare.

## Verifica

```bash
cd laravel

# scopo: la superficie governata
find Modules Themes -path '*/lang/*' -name '*.php' | wc -l               # 2920
find Modules/Lang/app -name '*.php' | wc -l                              # 62
grep -oP '^\s+\K\w+(?=::configureUsing)' \
  Modules/Lang/app/Providers/LangServiceProvider.php | sort -u          # 8 tipi Filament

# confini: la guardia sulla scrittura dei lang/*.php
grep -rn 'extends SaveTransAction' Modules --include='*.php' | wc -l     # 4 stub duplicati -> 1
grep -n 'persist_trans_in_tests' Modules/Lang/config/lang.php            # oggi: nessun risultato

# confini: cache flush globale
grep -n "cache')->flush()" Modules/Lang/app/Actions/WriteTranslationFileAction.php

# confini: codice morto tenuto in vita dai test
grep -n 'registerTranslator' Modules/Lang/app/Providers/LangServiceProvider.php   # riga 43 commentata
grep -rn 'TranslatorService' Modules/*/app | wc -l                       # obiettivo: 0
find Modules/Lang/app/Services -type f ! -name '.gitkeep' | wc -l        # obiettivo: 0

# confini: duplicazione e direzione delle dipendenze
find Modules -name 'AutoLabelAction.php' -not -path '*/docs/*' | wc -l   # 2 -> 1
grep -rl 'Modules\\Ptv\\' Modules/Lang/app | wc -l                       # 1 -> 0

# proporzione documentazione/codice
find Modules/Lang/app  -name '*.php' -print0 | xargs -0 cat | wc -l      # 4545
find Modules/Lang/docs -name '*.md'  -print0 | xargs -0 cat | wc -l      # 145101

./vendor/bin/phpstan analyse Modules/Lang                                # deve restare a 0 errori
```

## Collegamenti

- [README.md](../README.md) — badge e stato misurato del modulo
- [no-services-rule](../../../../bashscripts/ai/wiki/rules/no-services-rule.md) — perché `app/Services` non deve esistere
- [sigma-ptv-dependency-direction](../../../../docs/wiki/rules/sigma-ptv-dependency-direction.md) — la direzione delle dipendenze e il `ProfileContract`
- [data-sacred-no-destructive-db](../../../../docs/wiki/memories/data-sacred-no-destructive-db.md) — i file `lang/` tracciati sono dati, non artefatti
- [Sigma/docs/scopo.md](../../Sigma/docs/scopo.md) — il modello di questo documento
