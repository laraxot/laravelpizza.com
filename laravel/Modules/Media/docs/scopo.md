---
issues: []
discussions: []
title: "Media — scopo, confini e come servirlo meglio"
type: concept
module: Media
status: active
created: 2026-09-02
updated: 2026-09-02
tags: [scopo, confini, servizio-trasversale, storage, conversioni, s3, public-html, dipendenze]
qmd: "scopo media storage conversioni ffmpeg s3 cloudfront public_html confini dipendenze diagnostica aws duplicati"
---

# Media — scopo, confini e come servirlo meglio

## Lo scopo, dedotto dal codice

Media è l'unico dei tre servizi trasversali che possiede davvero qualcosa: tre tabelle,
tre modelli, tre migrazioni, uno per uno.

| Modello | Migrazione | Cosa rappresenta |
|---|---|---|
| `Media` | `2026_07_23_150000_create_medias_table.php` | il file allegato, in estensione di `Spatie\MediaLibrary\...\Media` |
| `MediaConvert` | `2022_01_01_000000_create_media_converts_table.php` | la richiesta di conversione di un video |
| `TemporaryUpload` | `2026_01_18_152545_create_temporary_uploads_table.php` | il file caricato ma non ancora agganciato a un modello |

Uno a uno, senza modelli orfani e senza migrazioni senza modello — è la regola
`migration-filename-from-model-name` rispettata alla lettera, e in questo repo non è
scontato. `app/Models/BaseModel.php:15` dichiara `protected $connection = 'media'`, e
`Media` la ridichiara a riga 129 perché eredita da Spatie e non da `BaseModel`: la
connection è coerente su tutti e tre.

Ma il dominio di Media non sono quelle tre tabelle: è il **percorso di un byte**. Le 49
Action di `app/Actions/` sono organizzate per tratto di quel percorso — ingresso
(`TemporaryUpload/`, 3), trasformazione (`Video/`, 6 e `Image/`, 2), destinazione
(`S3/`, 5 e `CloudFront/`, 1), uscita (`Stream/`, 2 e `Subtitle/`, 4). Il resto —
`app/Conversions/` con `VideoGenerators/Webm` e `ImageGenerators/PowerPoint`,
`app/Datas/` con `ConvertData`, `CloudFrontData`, `SaveAttachmentsData` — è il vocabolario
tipizzato che passa fra un tratto e l'altro. Non c'è quasi niente da esporre: 3 Filament
Resource, 6 righe di rotte in tutto (`routes/web.php` + `routes/api.php`).

Da qui la formulazione in una riga:

> **Media è il custode del percorso di un file, dall'upload temporaneo alla consegna:
> dove si posa, in quale formato si converte, con che URL si serve. Possiede lo schema di
> quel percorso e non conosce il significato di ciò che trasporta.**

I consumatori, misurati il 2026-09-02 con
`grep -rl 'Modules\\Media\\' Modules/<Modulo>` (esclusi `docs/`, `vendor/`,
`node_modules/`): Notify (7 file), User (4), Xot (2), Rating (2), Ptv (1), Progressioni
(1), IndennitaResponsabilita (1). Il simbolo importato è quasi sempre lo stesso,
`Modules\Media\Models\Media` (16 occorrenze su 18), perché l'aggancio vero avviene per
composizione e non per import: 8 modelli del repo usano `InteractsWithMedia` (5 in User,
1 in Rating, 1 in Notify, 1 in Media) e 13 file compongono form Filament con
`SpatieMediaLibraryFileUpload`. I 7 file di Notify sono tutti modelli, perché
`Notify\Models\BaseModel` implementa `HasMedia` per l'intero modulo.

Le dipendenze uscenti sono 55 verso Xot (piattaforma base, corretto), 2 verso UI
(`GetAllIconsAction`) e **1 verso Job**:
`app/Filament/Resources/MediaConvertResource/Pages/ListMediaConverts.php:9` importa
`Modules\Job\Filament\Widgets\ClockWidget`. Un widget di un altro modulo dentro una
pagina di Media è una decorazione che crea una dipendenza vera.

## I confini, e dove oggi sono rotti

### La proporzione con la documentazione è l'unica sana dei tre

| Misura | `app/` | `docs/` | Rapporto |
|---|---:|---:|---:|
| File | 124 `.php` | 351 `.md` | 2,8 : 1 |
| Righe | 8.716 | 34.337 | **3,9 : 1** |

Contro il 46 : 1 di Notify e il 32 : 1 di Lang, Media documenta in proporzione a quello
che fa. Restano 220 file `.md` piatti nella root di `docs/` e 11 gruppi di file
byte-identici — da ripulire, ma è manutenzione, non ipertrofia.

### Un file da zero byte con il nome corrotto, tracciato da git

```
laravel/Modules/Media/app/Filament/Clusters/极est/Pages/AwsTest.php
```

La directory si chiama `极est`: `Test` in cui la `T` è stata sostituita da un ideogramma
cinese, mojibake da una conversione di encoding. Il file dentro è **vuoto, 0 byte**, ed è
**tracciato** (`git ls-files` lo elenca come `"\346\236\201est/Pages/AwsTest.php"`).
Accanto, la versione buona: `app/Filament/Clusters/Test/Pages/AwsTest.php`, 538 righe.

In tutto il repository esistono **due soli** path tracciati con caratteri non-ASCII
sfuggiti (`git ls-files | grep -cP '\\\d{3}'` restituisce 2), e uno dei due è questo.
Non rompe l'autoload — PSR-4 non trova niente in una cartella che non corrisponde a un
namespace — ma sopravvive a ogni clone, compare in ogni `grep`, e la sua sola esistenza
dice che nessuno ha mai riletto l'albero dei file di questo modulo.

Nella stessa famiglia: `app/View/View/Components/_components.json`, anch'esso tracciato,
con il segmento `View` duplicato — un `mv` finito nella cartella sbagliata e mai
disfatto.

### Il fallback di un errore punta a un disco che non esiste

`app/Actions/Video/GetVideoFrameContentAction.php:47`:

```php
} catch (Exception) {
    return Storage::disk('public_html')->get('img/video_not_exists.jpg');
}
```

`config/filesystems.php` definisce tre dischi: `local`, `public`, `s3`. **`public_html`
non è fra questi**, e nessun provider lo registra a runtime
(`grep -rn "Storage::extend" Modules/*/app/Providers/` non trova nulla). Quel `catch`
esiste per trasformare un fallimento di FFmpeg in un'immagine segnaposto; quello che fa
davvero è sostituire l'eccezione originale con un
`InvalidArgumentException: Disk [public_html] does not have a configured driver`.
Il gestore dell'errore è l'errore.

Il nome tradisce la confusione da cui nasce: `public_html` è la cartella pubblica del
progetto — `public_path()` è ridefinito in `laravel/app/Application.php:18` come
`$this->basePath.'/../public_html'`, e Media lo usa correttamente in 10 punti
(`app/Actions/Subtitle/ConvertSrtToVttAction.php`, `app/Actions/Image/Merge.php`). Ma
una *cartella* non è un *disco*: la prima si raggiunge con `public_path()`, il secondo va
dichiarato in `filesystems.php`. Qui il concetto giusto è stato usato con l'API
sbagliata.

### `SubtitleService` esiste due volte, identico riga per riga

```bash
diff app/Services/SubtitleService.php app/Actions/Stream/SubtitleService.php
```

L'unica differenza è la riga 5, il `namespace`. 217 righe duplicate alla lettera. È
evidentemente il residuo di una conversione `Services -> Actions` iniziata e mai
completata: la copia nuova è stata creata, la vecchia non è stata cancellata, e la copia
nuova non è nemmeno stata rinominata secondo la convenzione — si chiama ancora
`SubtitleService`, dentro `app/Actions/`, senza `execute()` e senza `QueueableAction`.

`app/Services/` contiene anche `VideoStream.php` (167 righe). Entrambe le classi in
`app/Services/` sono referenziate **solo dai test** (`MediaHighestMissCoverageTest`,
`MediaCoverage100RemainingTest`): nessun file di `app/` le usa. Come in Lang, la ricerca
della copertura ha dato dei test a del codice morto invece di cancellarlo.

Nella stessa categoria, `app/Actions/Image/Merge.php`: un'Action che non si chiama
`*Action`. Sono le uniche due eccezioni su 49
(`find app/Actions -name '*.php' ! -name '*Action.php'`), e 41 Action su 49 usano
`QueueableAction` — le 8 che non lo usano sono da guardare a mano.

### Due interfacce identiche, zero implementatori

`app/Contracts/PathGenerator.php` e `app/Contracts/PathGeneratorContract.php`
dichiarano gli stessi tre metodi (`getPath()`, `getPathForConversions()`,
`getPathForResponsiveImages()`) con le stesse firme. Nessuna classe implementa né l'una
né l'altra: l'unico posto in cui compaiono fuori da sé stesse è
`app/Support/TemporaryUploadPathGenerator.php`, righe 11-13, **commentate**:

```php
// use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
// use Modules\Media\Contracts\PathGenerator;
// implements PathGenerator
```

`TemporaryUploadPathGenerator` implementa i tre metodi ma non dichiara nessun contratto.
Il risultato è il peggiore dei tre esiti possibili: c'è un contratto (due, anzi), c'è
un'implementazione, e non sono collegati — quindi il compilatore non verifica nulla e chi
legge crede che ci sia un'astrazione dove non c'è.

### Quasi metà delle Action sono diagnostica AWS

| Sottocartella | File | % di `app/Actions/` |
|---|---:|---:|
| `Diagnostic/` (Aws 9, S3 9, Support 3) | **21** | **43 %** |
| tutto il resto | 28 | 57 % |

Ventuno Action che testano credenziali IAM, policy di bucket, URL firmati CloudFront,
permessi S3. Aggiungendo `app/Filament/Clusters/Test/Pages/` (`AwsTest.php` 538 righe,
`S3Test.php`) il quadro è chiaro: una configurazione AWS difficile da far funzionare ha
generato un intero sottomodulo di strumenti per capire *perché* non funziona, e quegli
strumenti sono rimasti nel codice di produzione. Ci vive anche tutto l'hardcoding del
nome del disco: le 17 occorrenze di `disk('s3')` del modulo — su 35 chiamate `disk()`
totali — stanno **tutte** in `Diagnostic/S3/` e in `Clusters/Test/Pages/S3Test.php`,
nessuna nel percorso di produzione.

Non è debito da cancellare a cuor leggero: quando l'infrastruttura è opaca, la
diagnostica ha valore. Ma è debito da **spostare**: un comando artisan o un pacchetto
`dev` non entra nel pannello di amministrazione insieme alle funzioni vere.

## Come servire meglio lo scopo

### 1. Rimuovere il file mojibake e il path duplicato dall'indice git

File: `laravel/Modules/Media/app/Filament/Clusters/极est/Pages/AwsTest.php` (0 byte),
`laravel/Modules/Media/app/View/View/Components/_components.json`,
`app/Actions/Image/SvgExistsAction.to_xot`.

Sono tre `git rm`. La versione buona di `AwsTest.php` esiste già in
`Clusters/Test/Pages/`, quella di `_components.json` in `app/View/Components/`.

```bash
cd /var/www/html/ptvx
git ls-files | grep -cP '\\\d{3}'                                    # 2 -> 1
find laravel/Modules/Media/app -type f ! -name '*.php' ! -name '.gitkeep' | wc -l   # 5 -> 3
```

### 2. Riparare il fallback che non può funzionare

File: `app/Actions/Video/GetVideoFrameContentAction.php:47`.

Due modi corretti, uno solo va scelto: leggere il segnaposto dal filesystem con
`public_path('img/video_not_exists.jpg')` — coerente con gli altri 10 usi del modulo — o
dichiarare il disco `public_html` in `config/filesystems.php` con root
`public_path()`. Il primo è più piccolo e non aggiunge configurazione. In entrambi i casi
va aggiunto un test che esercita il ramo `catch`, perché è esattamente il ramo che oggi
nessuno percorre.

```bash
cd laravel
grep -rn "disk('public_html')" Modules/Media/app                      # obiettivo: 0
php -r '$c=require "config/filesystems.php"; echo implode(",",array_keys($c["disks"])),"\n";'
```

### 3. Chiudere la conversione `Services -> Actions` lasciata a metà

File: `app/Services/SubtitleService.php` (da cancellare, è la copia vecchia),
`app/Actions/Stream/SubtitleService.php` (da rinominare in `ParseSubtitleAction` con
`execute()` e `QueueableAction`), `app/Services/VideoStream.php` (da valutare: nessun
consumatore in `app/`), `app/Actions/Image/Merge.php` (da rinominare `MergeImagesAction`).

I test che oggi puntano a `Modules\Media\Services\*` vanno ripuntati o cancellati con il
codice che coprono; non vanno usati come argomento per tenere in vita la copia vecchia.

```bash
cd laravel
find Modules/Media/app/Services -type f ! -name '.gitkeep' | wc -l    # 2 -> 0
find Modules/Media/app/Actions -name '*.php' ! -name '*Action.php'    # obiettivo: nessun risultato
```

### 4. Collegare l'astrazione dei path, o cancellarla

File: `app/Contracts/PathGeneratorContract.php` (da tenere),
`app/Contracts/PathGenerator.php` (da cancellare, duplicato),
`app/Support/TemporaryUploadPathGenerator.php` (da far `implements PathGeneratorContract`,
scommentando ciò che è già scritto alle righe 11-13).

Se invece l'astrazione non serve — Spatie ha già la sua `PathGenerator` — si cancellano
entrambe le interfacce. Quello che non ha senso è tenerne due e non usarne nessuna.

```bash
cd laravel
ls Modules/Media/app/Contracts | wc -l                                # 2 -> 1 (o 0)
grep -rn 'implements PathGeneratorContract' Modules/Media/app | wc -l # obiettivo: 1
```

### 5. Portare la diagnostica AWS fuori dal pannello di produzione

File: `app/Actions/Diagnostic/**` (21 file),
`app/Filament/Clusters/Test/Pages/{AwsTest,S3Test}.php`.

La destinazione naturale è un comando artisan (`app/Console/Commands/`, dove oggi c'è
solo `ConvertVideoCommand`), che si esegue quando serve e non compare nella navigazione
dell'admin. Il criterio per decidere cosa resta: se una classe risponde alla domanda
"perché la configurazione non funziona", è diagnostica; se risponde a "cosa faccio con
questo file", è Media.

```bash
cd laravel
find Modules/Media/app/Actions -name '*.php' | wc -l                  # 49
find Modules/Media/app/Actions/Diagnostic -name '*.php' | wc -l       # 21 -> 0
```

## Cosa NON è compito di Media

- **Non** sa cosa sia il file che trasporta. Un allegato di una scheda Ptv, l'avatar di
  un profilo e un video di formazione per Media sono lo stesso oggetto: `model_type` e
  `model_id` sono polimorfici apposta. Se una classe di Media nomina un concetto di un
  modulo foglia, è nel posto sbagliato.
- **Non** decide chi può vedere un file. L'autorizzazione sta nelle policy del modulo
  proprietario del `model_type`; le `app/Models/Policies/` di Media coprono
  l'amministrazione dei record `Media`, non l'accesso al contenuto.
- **Non** scrive in `laravel/public/`. La cartella pubblica del progetto è `public_html/`,
  e si raggiunge con `public_path()` — mai con un path costruito a mano. Cfr.
  `laravel/app/Application.php:18` e la memoria `public-path-is-public-html`.
- **Non** è il posto dove si diagnostica AWS. La configurazione dell'infrastruttura è di
  chi gestisce l'ambiente; Media la consuma, non la certifica.
- **Non** è un modulo di dominio, quindi **non** ha una tabella `mylog`: non c'è un
  flusso utente da tracciare, c'è un file da spostare.

## Verifica

```bash
cd laravel

# scopo: uno schema piccolo e coerente, 1 modello = 1 migrazione
ls Modules/Media/database/migrations | wc -l                          # 3
find Modules/Media/app/Models -maxdepth 1 -name '*.php' ! -name 'Base*' | wc -l   # 3
grep -rn "connection = 'media'" Modules/Media/app/Models              # BaseModel + Media

# scopo: il percorso del byte, non il suo significato
find Modules/Media/app/Actions -name '*.php' | wc -l                  # 49
find Modules/Media/app/Actions/Diagnostic -name '*.php' | wc -l       # 21 (43%)
grep -rl 'QueueableAction' Modules/Media/app/Actions | wc -l          # 41 su 49

# confini: residui tracciati da git
cd /var/www/html/ptvx && git ls-files | grep -P '\\\d{3}'             # 2 path, uno e' di Media
find laravel/Modules/Media/app -type f ! -name '*.php' ! -name '.gitkeep'
cd laravel

# confini: il disco che non esiste
grep -rn "disk('public_html')" Modules/Media/app
php -r '$c=require "config/filesystems.php"; echo implode(",",array_keys($c["disks"])),"\n";'

# confini: policy no-services e duplicati
find Modules/Media/app/Services -type f ! -name '.gitkeep' | wc -l    # 2 -> 0
diff Modules/Media/app/Services/SubtitleService.php \
     Modules/Media/app/Actions/Stream/SubtitleService.php             # oggi: solo il namespace
find Modules/Media/app/Actions -name '*.php' ! -name '*Action.php'    # 2 -> 0
ls Modules/Media/app/Contracts                                        # 2 interfacce identiche -> 1

# proporzione documentazione/codice (la piu' sana dei tre servizi)
find Modules/Media/app  -name '*.php' -print0 | xargs -0 cat | wc -l  # 8716
find Modules/Media/docs -name '*.md'  -print0 | xargs -0 cat | wc -l  # 34337

./vendor/bin/phpstan analyse Modules/Media                            # deve restare a 0 errori
```

## Collegamenti

- [README.md](../README.md) — badge e stato misurato del modulo
- [public-path-is-public-html](../../../../docs/wiki/memories/public-path-is-public-html.md) — perché `public_path()` è `public_html/`
- [no-services-rule](../../../../bashscripts/ai/wiki/rules/no-services-rule.md) — perché `app/Services` non deve esistere
- [migration-filename-from-model-name](../../../../docs/wiki/rules/migration-filename-from-model-name.md) — la regola che qui è rispettata
- [Sigma/docs/scopo.md](../../Sigma/docs/scopo.md) — il modello di questo documento
