---
title: "Media: generatore Webm non registrato e componente Livewire Clip"
type: story
status: ready-for-dev
priority: P2
created: 2026-10-20
updated: 2026-10-20
module: Media
epic: ../../../Xot/docs/bmad/epic-code-quality-ratchet.md
depends_on: ["decisione dell'utente: cancellare Webm o completarlo", "decisione dell'utente sulla variante di maiuscole di app/conversions"]
related: [./debug-calls-removal-media.story.md, ./16-4-media-case-variant-consolidation.md, ./12.1.media-clip-not-widget.story.md, ./media-test-mai-eseguiti-e-doppioni-maiuscole.story.md, ../bmad/livewire-inventory.md, ../../../Xot/docs/bmad/livewire-to-filament-widgets-inventory.md, ../../../Xot/docs/bmad/stories/livewire-to-filament-widgets-fleet.story.md]
tags: [bmad, media, media-library, image-generator, ffmpeg, livewire, retire]
---

# Media: generatore Webm non registrato e componente Livewire Clip

Fase BMAD: Analisi e decisione (nessun PHP toccato; `Webm.php` ha una modifica non committata della story [debug-calls-removal-media](./debug-calls-removal-media.story.md)).

## Richiesta

Come maintainer del modulo Media voglio che nel modulo non resti codice che dichiara una capacita' che non ha (un generatore video che lancia sempre) ne' un componente Livewire senza vista ne' chiamanti, cosi' che il codice dica quello che fa e la regola "niente Livewire custom" sia vera anche per Media.
Il perche': `Webm::convert()` e' stato svuotato il 2026-10-20 e lancia `LogicException`; `Clip` e' un componente che la story 12.1 dava per cancellato il 2026-09-21 ed e' invece tracciato.

## Scopo

- `Conversions/VideoGenerators/Webm.php` voleva essere un `ImageGenerator` di Spatie media-library: dato un video, produrre l'immagine di anteprima, per chi carica video nelle collezioni media. E' nato da un generatore webp-to-png ed e' rimasto a meta'.
- `Http/Livewire/Card/Video/Clip.php` (86 righe) mostrava un clip e apriva un modale per cambiare `title` e `subtitle` di un modello qualsiasi (`public Model $model`), per chi cura i contenuti video lato front.

## Stato misurato

Misure del 2026-10-20 13:57 UTC, da `laravel/`.
- Non registrato: `grep -n "Webm\|VideoGenerators\|PowerPoint" config/media-library.php | wc -l` stampa `0`; controprova: `grep -n "Video::class" config/media-library.php` stampa la riga 193 (`image_generators`, righe 187-194: Image, Webp, Avif, Pdf, Svg, Video). Il solo file di config e' `laravel/config/media-library.php` (`/usr/bin/find . -name media-library.php -not -path './vendor/*'`).
- Chiamanti: `git grep -nw Webm -- Modules ':!*.md' ':!coverage.xml'` e `rg -n -P "\bWebm\b" Modules --glob '*.php' --glob '!**/docs/**'` danno entrambi `7` righe: 2 definizioni (`app/Conversions/VideoGenerators/Webm.php:11,16` e la copia minuscola `app/conversions/videogenerators/Webm.php:11`) e 4 nel test `tests/Unit/Conversions/GeneratorsAndAttachmentDataTest.php:9,19,26,41`. Nessun chiamante di produzione.
- Ridondanza: lo `ImageGenerator` incluso in Spatie (`vendor/spatie/laravel-medialibrary/src/Conversions/ImageGenerators/Video.php:54-61`) gestisce `webm, mov, mp4, m4v` e i mime corrispondenti; `Webm` dichiara solo `mp4`, `video/mpeg`, `video/mp4` (`Webm.php:40` e `:52`) e `requirementsAreInstalled()` torna sempre `true` senza controllare ffmpeg. La factory sceglie il primo generatore in ordine di config che sa trattare il file (`ImageGeneratorFactory::forMedia`): registrato prima di `Video`, `Webm` intercetterebbe ogni mp4 e lancerebbe.
- ffmpeg: la libreria PHP c'e' (`vendor/php-ffmpeg/php-ffmpeg/src/FFMpeg/FFMpeg.php`), il binario no su questo host (`test -x /usr/bin/ffmpeg` fallisce; `config/media-library.php:213` `FFMPEG_PATH` default `/usr/bin/ffmpeg`): non so se in produzione c'e'.
- La trascodifica vera (non l'anteprima) sta altrove: `app/Actions/Video/ConvertVideoByMediaConvertAction.php` e `app/Console/Commands/ConvertVideoCommand.php`. Un `ImageGenerator` non trascodifica: il nome "Webm" e' fuorviante.
- Coppie per maiuscole in `app/`: `git -C Modules/Media ls-files app | awk '{print tolower($0)}' | sort | uniq -d` stampa 2 chiavi (`PowerPoint`, `Webm`), cioe' 4 file, tutti presenti su disco (`/usr/bin/find Modules/Media/app -ipath '*conversions*' -type f | wc -l` stampa `4`). La story [debug-calls-removal-media](./debug-calls-removal-media.story.md) scriveva che il minuscolo era solo una cartella vuota: oggi non e' vero. La copia minuscola di `Webm` ha ancora il corpo vecchio (restituisce un percorso `.webmXXX` inesistente); quella di `PowerPoint` differisce dalla maiuscola solo per la posizione di `declare(strict_types=1)`. Anche `PowerPoint` non e' in `image_generators`.
- Clip: `/usr/bin/find Modules/Media \( -path '*/Http/Livewire*' -o -path '*/app/Livewire*' \) ! -path './vendor/*'` stampa `app/Http/Livewire`, `.gitkeep`, `_components.json` (`[]`) e `Card/Video/Clip.php`. `git -C Modules/Media log -n1 --format='%h %ad' --date=short -- app/Http/Livewire/Card/Video/Clip.php` stampa `f30fc50e 2026-10-15`: il file e' vivo e modificato dopo il "cancellato" della 12.1.
- Chiamanti di Clip: 0 con due metodi. `git grep -nE "Card\\\\Video\\\\Clip|card\.video\.clip|livewire:card" -- Modules Themes app resources routes config ':!*.md'` e `rg -n -P "Card\\\\+Video\\\\+Clip|card\.video\.clip|<livewire:card\.|@livewire\(\s*['\"]card\."` non stampano nulla; controprova: `git grep -nE "<livewire:" -- Modules Themes ':!*.md' | wc -l` stampa `22`.
- Senza vista e senza ascoltatori: `render()` chiede `GetViewAction::execute('edit')` ma `/usr/bin/find Modules/Media/resources/views -ipath '*clip*' -o -ipath '*livewire*'` non stampa nulla; l'evento `showModal` emesso da `editClip()` (`Clip.php:61`) non ha ascoltatori Livewire in `Modules`, `Themes`, `resources`.
- Il piano Livewire dell'altra sessione lo classifica `RETIRE`, gemello "nessuno": [fleet](../../../Xot/docs/bmad/stories/livewire-to-filament-widgets-fleet.story.md) tabella per classe, e [inventory](../../../Xot/docs/bmad/livewire-to-filament-widgets-inventory.md). `Xot/tests/Unit/NoLivewireDirectoriesInModulesTest.php` (glob `Modules/*/app/Http/Livewire`) e' quindi rosso per Media per lettura (non eseguito).

## Lavoro

1. `Webm`, decisione (utente). Raccomandata A, cancellare: `app/Conversions/VideoGenerators/Webm.php`, la copia minuscola, le due `test()` su Webm in `GeneratorsAndAttachmentDataTest.php` (righe 25-48; il file ha modifiche non committate, usare il lock) e il riferimento nel commento di testa (riga 19). Il lavoro che voleva fare lo fa gia' `Video` di Spatie. Alternativa B, completare: servirebbe ffmpeg verificato, `requirementsAreInstalled()` reale, registrazione dopo `Video` in `image_generators` e test con un file vero; costo alto per un risultato che Spatie gia' offre.
2. Copie minuscole di `app/conversions/**` (`Webm`, `PowerPoint`): secondo la [16-4](./16-4-media-case-variant-consolidation.md) si leggono entrambe le copie e si tiene la PascalCase. Qui: `git rm` delle due minuscole dopo conferma. Se `PowerPoint` resta, decidere se registrarlo o cancellarlo (oggi non lo e').
3. `Clip`, ritiro: cancellare `app/Http/Livewire/Card/Video/Clip.php`, `_components.json`, `.gitkeep`; la cartella `app/Http/Livewire` sparisce. Nessun gemello da scrivere: senza chiamanti, vista e ascoltatore non c'e' funzione da portare. Se serve modificare `title` e `subtitle` di un modello da modale, e' un `EditAction` Filament con schema sulla risorsa proprietaria del modello, fuori da Media.
4. Dopo l'esecuzione aggiornare [12.1](./12.1.media-clip-not-widget.story.md), [debug-calls-removal-media](./debug-calls-removal-media.story.md) e `docs/bmad/livewire-inventory.md` con lo stato reale, e rimisurare dopo il prossimo pull: `Clip.php` e' gia' tornato una volta.
Rischio: basso; l'unico cambiamento di comportamento e' che una futura registrazione di `Webm` non sara' piu' possibile.

## Acceptance criteria

- [ ] `git grep -nw Webm -- Modules ':!*.md' ':!coverage.xml' | wc -l` stampa `0` (variante A; oggi `7`); controprova: `git grep -nw PowerPoint -- Modules/Media/app ':!*.md' | wc -l` stampa un numero maggiore di zero.
- [ ] `/usr/bin/find Modules/Media/app -maxdepth 1 -type d -name conversions | wc -l` stampa `0` (oggi `1`).
- [ ] `/usr/bin/find Modules/Media -type d \( -path '*/app/Http/Livewire' -o -path '*/app/Livewire' \) | wc -l` stampa `0` (oggi `1`); controprova: `/usr/bin/find Modules/Media -type d -path '*/app/Http' | wc -l` stampa `1` (`app/Http` ha altro: Controllers, Middleware, Requests).
- [ ] `git grep -nE "Card\\\\Video\\\\Clip" -- Modules Themes ':!*.md' | wc -l` stampa `0`.
- [ ] `grep -c "Webm" Modules/Media/tests/Unit/Conversions/GeneratorsAndAttachmentDataTest.php` stampa `0`, mentre il test di `PowerPoint` resta.
- [ ] PHPStan gated su `Modules/Media/app/Conversions` e sul test: exit 0.

## Verifica

- I comandi degli AC, con le controprove indicate.
- `php -l` sul test toccato e PHPStan col gate dei Vincoli.
- Dopo la guardia DB: Pest sul solo `Modules/Media/tests/Unit/Conversions/GeneratorsAndAttachmentDataTest.php` (gruppo `no-media-db`, solo memoria), atteso "passed" per i test rimasti.
- Verifica funzionale dell'anteprima video: fuori da questa story, serve ffmpeg (`command -v ffmpeg` in produzione).

## Vincoli

- PHPStan: unica config `laravel/phpstan.neon`, la modifica solo l'utente; mai altri `.neon`, mai `-c`/`--level`, nessun baseline/ignore. Ogni invocazione passa dal gate condiviso: `cd laravel && flock -w 1500 /tmp/claude-1000/-mnt-nas07-var-www--bases-base-quaeris-fila5/aeabb365-8395-48f4-b7d4-9fbb17ad85d3/scratchpad/phpstan-gate.lock nice -n 10 ./vendor/bin/phpstan analyse <path...> --memory-limit=2G --no-progress --error-format=raw` (max ~8 file o un modulo; `analyse Modules` intero solo dopo il "run completo finito" dell'altra sessione).
- Pest e PHPUnit FERMI: il 2026-10-20 `RefreshDatabase` ha fatto `migrate:fresh` su `quaeris_data_test`. Si riprende solo quando la guardia DB e' dentro (story `laravel/Modules/Xot/docs/stories/test-database-guard.story.md`) e l'utente ha confermato che i DB `*_test` sono usa-e-getta. Fino ad allora la verifica e' PHPStan + `php -l` + lettura.
- Concorrenza: altre sessioni scrivono nello stesso repo. Prima di scrivere un file esistente: `bashscripts/lock/check.sh <f> && [ $(( $(date +%s) - $(stat -c %Y <f>) )) -gt 120 ] && bashscripts/lock/lock.sh <f>`; un solo agente PHP per modulo; niente commit, reset, checkout, stash.
- zsh non divide `$VAR` in argomenti: usa array (`A=(x y); cmd $A`) o `xargs -a`. Un pattern `rg` che inizia con `-` richiede `-e`. Un `0` va sempre controprovato (rg -P piu' un secondo metodo).
- Docs: artefatti BMAD solo in `laravel/Modules/<M>/docs/`; nomi senza date; nessun Service (`app/Services` vietata, logica in Spatie QueueableAction con `execute()`); Filament: solo basi `XotBase*`, logica nelle Actions, nessuna stringa UI hardcoded (chiavi in `lang/`).
- Specifici: non toccare `laravel/config/media-library.php` (i generatori registrati restano quelli di Spatie); non ricreare cartelle Livewire; prima di cancellare rimisurare i chiamanti il giorno stesso.

## Decisioni aperte

1. `Webm`: cancellare (raccomando) o completare.
2. `PowerPoint`: cancellare, registrare o lasciare; oggi non e' in `image_generators` ed e' fuori da questa story. Raccomando di decidere insieme a `Webm`, per lo stesso criterio.
3. Se in produzione serve davvero un'anteprima di video: verificare che ffmpeg esista; e' una domanda di operations, non di codice.

## Come ripartire

1. `cd /mnt/nas07/var/www/_bases/base_quaeris_fila5/laravel && git grep -nw Webm -- Modules ':!*.md' ':!coverage.xml'` e il `find` di `app/Http/Livewire`, per rimisurare.
2. Chiedere all'utente le decisioni 1 e 2; poi, sotto lock, cancellare nell'ordine: test su Webm, `Webm` (due copie), `PowerPoint` minuscolo, `Clip` e cartella.
3. Eseguire gli AC, `php -l`, PHPStan col gate; aggiornare 12.1, la story di debug e l'inventario.
