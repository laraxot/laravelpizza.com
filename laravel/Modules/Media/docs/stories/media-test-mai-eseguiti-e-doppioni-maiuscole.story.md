---
title: "Media: test mai eseguiti e doppioni per sole maiuscole"
type: story
status: ready-for-dev
priority: P2
created: 2026-10-20
updated: 2026-10-20
module: Media
epic: ../../../Xot/docs/bmad/epic-code-quality-ratchet.md
depends_on: ["decisione dell'utente su quale variante tenere e su quale lato allineare i 3 test rossi", "guardia DB dentro", "verdetto Pest P0 dell'utente"]
related: [./16-4-media-case-variant-consolidation.md, ./16-2-case-variant-dirs-guard.md, ./phpstan-test-wave-media.story.md, ./services-to-actions-media.story.md, ./media-quality-gate.story.md, ./media-webm-non-registrato-e-clip-livewire.story.md, ../case-sensitivity-rules.md, ../../../Xot/docs/stories/test-database-guard.story.md]
tags: [bmad, media, pest, phpunit, suffix, case-sensitivity, tests]
---

# Media: test mai eseguiti e doppioni per sole maiuscole

Fase BMAD: Analisi (nessun test eseguito, nessun file di test toccato).

## Richiesta

Come maintainer del modulo Media voglio che ogni file di test scritto venga davvero raccolto da Pest e che esista una sola copia per nome, cosi' che "verde" voglia dire che i test girano.
Il perche': `laravel/phpunit.xml:11-12` raccoglie solo i file che finiscono per `Test.php` (con la T maiuscola), quindi un test salvato in minuscolo non gira mai e nessuno se ne accorge; in piu' la stessa coppia esiste in due cartelle che differiscono per le maiuscole. Il tema dei doppioni e' gia' in [16-4](./16-4-media-case-variant-consolidation.md) e in [phpstan-test-wave-media](./phpstan-test-wave-media.story.md) ("Aperto" punto 3); qui c'e' il delta: il difetto del suffisso, il confronto dei quattro file e il triage dei 3 test rossi.

## Scopo

`MediaConvertResourceTest` verifica che il form di conversione (`MediaConvertForm`) esponga un `Radio` e un `TextInput`: serve a non rompere in silenzio la scelta del formato di conversione. `MediaHighestMissCoverageTest` e' uno sweep di copertura sulle classi Filament e sui comandi del modulo.

## Stato misurato

Misure del 2026-10-20 13:54 UTC, da `laravel/`.
- Suffisso: `sed -n 11,12p phpunit.xml` stampa `<directory suffix="Test.php">tests</directory>` e `<directory suffix="Test.php">Modules/*/tests</directory>`; il suffisso e' confrontato in modo sensibile alle maiuscole.
- Media: `/usr/bin/find Modules/Media/tests -type f -name '*.php' | wc -l` stampa `48`; con `-name '*Test.php'` stampa `40`; i 6 di supporto sono stub, fixture, `TestCase.php`, `Pest.php`; i 2 non raccolti sono `tests/Filament/Resources/mediaconvertresourcetest.php` e `tests/filament/resources/mediaconvertresourcetest.php`. Controprova: `/usr/bin/find Modules/Media/tests -type f -iname '*test.php' | wc -l` stampa `42` (40 + 2): il filtro vede i nomi in minuscolo.
- Stesso difetto fuori da Media, due metodi concordi: `git ls-files -- 'Modules/*/tests/*' | grep -iP 'test\.php$' | grep -vP 'Test\.php$' | wc -l` e `/usr/bin/find Modules/*/tests -type f -iname '*test.php' ! -name '*Test.php'` danno `17`: Cms 10, Media 2, Notify 2, Gdpr 1, Geo 1, Xot 1. Non sono di Media: vanno segnalati ai rispettivi moduli.
- Doppioni: `git -C Modules/Media ls-files tests | awk '{print tolower($0)}' | sort | uniq -d` stampa 1 chiave, che raccoglie 4 file (l'altra sessione parla di "4": sono 4 file di un solo gruppo, non 4 coppie). Le directory `tests/Feature` e `tests/feature` della 16-4 sono gia' risolte (`ls Modules/Media/tests` mostra solo `Filament` e `filament` come coppia).
- Fuori da `tests/` restano altre 2 coppie per maiuscole in `app/conversions` (`PowerPoint`, `Webm`): le tratta [media-webm-non-registrato-e-clip-livewire](./media-webm-non-registrato-e-clip-livewire.story.md).
- I 4 file hanno lo stesso namespace `Modules\Media\Tests\Filament\Resources` e lo stesso test "get form schema returns expected components". Differenze lette con `diff`: `Filament/Resources/MediaConvertResourceTest.php` (23 righe) chiama `(new MediaConvertForm)->getFormSchema()` e usa `Modules\Media\Tests\TestCase`; `filament/resources/MediaConvertResourceTest.php` e `filament/resources/mediaconvertresourcetest.php` sono identici fra loro (stesso md5) e chiamano `app(MediaConvertResource::class)->getFormSchema()`; `Filament/Resources/mediaconvertresourcetest.php` fa lo stesso ma con `Tests\TestCase` (la base dell'app, non del modulo). Solo 2 dei 4 vengono raccolti (quelli in `Test.php`).
- Storia: i tre doppioni sono comparsi con il commit `4d58d665` del 2026-10-08 (`git -C Modules/Media log --name-status -- tests/Filament tests/filament`); [case-sensitivity-rules](../case-sensitivity-rules.md) dice che la variante minuscola era stata rimossa: non e' vero.
- 3 test rossi (riportati da [phpstan-test-wave-media](./phpstan-test-wave-media.story.md) e [services-to-actions-media](./services-to-actions-media.story.md), non rieseguiti oggi). Cause lette nel codice: `tests/Unit/MediaHighestMissCoverageTest.php:66` pretende la chiave `file` in `MediaForm::getFormSchema()`, che restituisce `name`, `file_name`, `mime_type`, `disk`, `size`, `collection_name` (`MediaResource/Schemas/MediaForm.php:18-25`); `:78` chiama `ListMedia::getTableColumns()`, che e' `final` in `Xot/app/Filament/Resources/Pages/XotBaseListRecords.php:85` e restituisce `[]` (le colonne vivono in `Tables/MediaTable.php:28`, dove `file_name` c'e'); `:140` riflette `ViewMedia::getInfolistSchema()`, che nella pagina non esiste (`grep -n getInfolistSchema Media/app/Filament/Resources/MediaResource/Pages/*.php` e `Xot/app/Filament/Resources/Pages/*.php`: 0 righe; il metodo e' in `Schemas/MediaInfolist.php:16`) e `media_grid` non e' tra le sue chiavi. Quindi i test 2 e 3 cercano il dato nella pagina invece che nella classe Table/Schema.

## Lavoro

1. Scegliere la copia da tenere leggendo i file, non per data (regola della 16-4). Raccomandata: `tests/Filament/Resources/MediaConvertResourceTest.php`: chiama lo schema direttamente e usa la `TestCase` del modulo.
2. Portare nel file tenuto il caso che solo le altre copie coprono: un secondo `test()` che passa dal `MediaConvertResource` e controlla le stesse chiavi (cosi' si verifica anche la delega). Poi rimuovere con `git rm` i tre doppioni (`Filament/Resources/mediaconvertresourcetest.php`, `filament/resources/*`) e la cartella `tests/filament`. Non rinominare la variante minuscola in `...Test.php`: creerebbe un terzo doppione.
3. Rendere il difetto non ripetibile: una guardia (test di architettura o Pest) che fallisca se un file sotto `tests/` finisce per `test.php` senza la T maiuscola. Per Media in questa story; per gli altri 15 file serve una riga ai moduli e, per la guardia globale, a Xot.
4. I 3 test rossi, solo dopo la ripresa di Pest: allineare il test al prodotto (usare `MediaTable`, `MediaInfolist`, le chiavi reali di `MediaForm`), salvo decisione diversa sul prodotto.
Rischio: alla ripresa di Pest i 2 test oggi invisibili possono rivelarsi rossi; sono comunque codice mai provato.

## Acceptance criteria

- [ ] `git -C Modules/Media ls-files tests | awk '{print tolower($0)}' | sort | uniq -d | wc -l` stampa `0` (oggi `1`).
- [ ] `/usr/bin/find Modules/Media/tests -type f -name '*.php' -iname '*test.php' ! -name '*Test.php' | wc -l` stampa `0` (oggi `2`); controprova: stesso comando senza `! -name` stampa il numero dei test.
- [ ] `ls Modules/Media/tests/filament` fallisce con "No such file".
- [ ] `grep -c "^test(" Modules/Media/tests/Filament/Resources/MediaConvertResourceTest.php` stampa almeno `2`.
- [ ] Esiste la guardia sul suffisso e fallisce se si aggiunge un file `tests/x/fooboartest.php` di prova (poi rimosso).
- [ ] I 3 test di `MediaHighestMissCoverageTest.php` passano o sono rimossi con motivazione scritta; PHPStan gated su `Modules/Media/tests`: exit 0.

## Verifica

- I comandi degli AC. Dopo la guardia DB e il verdetto Pest: `cd laravel && XDEBUG_MODE=off ./vendor/bin/pest --no-coverage Modules/Media/tests/Filament/Resources/MediaConvertResourceTest.php Modules/Media/tests/Unit/MediaHighestMissCoverageTest.php`, con output atteso "passed" e nessun "skipped" per DB.
- Controprova del `0` sul suffisso: creare un file di prova `Modules/Media/tests/Unit/zztest.php` in una copia temporanea (non nel repo) e vedere che il comando lo conta; oppure applicare lo stesso `find` a `Modules/Cms/tests`, che deve stampare 10.
- `php -l` sui test toccati e PHPStan col gate dei Vincoli.

## Vincoli

- PHPStan: unica config `laravel/phpstan.neon`, la modifica solo l'utente; mai altri `.neon`, mai `-c`/`--level`, nessun baseline/ignore. Ogni invocazione passa dal gate condiviso: `cd laravel && flock -w 1500 /tmp/claude-1000/-mnt-nas07-var-www--bases-base-quaeris-fila5/aeabb365-8395-48f4-b7d4-9fbb17ad85d3/scratchpad/phpstan-gate.lock nice -n 10 ./vendor/bin/phpstan analyse <path...> --memory-limit=2G --no-progress --error-format=raw` (max ~8 file o un modulo; `analyse Modules` intero solo dopo il "run completo finito" dell'altra sessione).
- Pest e PHPUnit FERMI: il 2026-10-20 `RefreshDatabase` ha fatto `migrate:fresh` su `quaeris_data_test`. Si riprende solo quando la guardia DB e' dentro (story `laravel/Modules/Xot/docs/stories/test-database-guard.story.md`) e l'utente ha confermato che i DB `*_test` sono usa-e-getta. Fino ad allora la verifica e' PHPStan + `php -l` + lettura.
- Concorrenza: altre sessioni scrivono nello stesso repo. Prima di scrivere un file esistente: `bashscripts/lock/check.sh <f> && [ $(( $(date +%s) - $(stat -c %Y <f>) )) -gt 120 ] && bashscripts/lock/lock.sh <f>`; un solo agente PHP per modulo; niente commit, reset, checkout, stash.
- zsh non divide `$VAR` in argomenti: usa array (`A=(x y); cmd $A`) o `xargs -a`. Un pattern `rg` che inizia con `-` richiede `-e`. Un `0` va sempre controprovato (rg -P piu' un secondo metodo).
- Docs: artefatti BMAD solo in `laravel/Modules/<M>/docs/`; nomi senza date; nessun Service (`app/Services` vietata, logica in Spatie QueueableAction con `execute()`); Filament: solo basi `XotBase*`, logica nelle Actions, nessuna stringa UI hardcoded (chiavi in `lang/`).
- Specifici: niente `RefreshDatabase`/`migrate:fresh` nei test; non toccare `laravel/phpunit.xml` per cambiare il suffisso (cambierebbe cosa si esegue in tutto il repo); non cancellare i file di test senza decisione scritta dell'utente.

## Decisioni aperte

1. Quale copia tenere e se cancellare le altre tre. Raccomando di si: sono varianti di un test da 22 righe.
2. Per i 3 test rossi, allineare il test al prodotto (raccomando) o il prodotto al test (aggiungere `file` a `MediaForm`, `media_grid` all'infolist).
3. Una guardia globale sul suffisso, che toccherebbe i 15 file di altri moduli: serve il consenso di Xot e dei moduli.

## Come ripartire

1. `cd /mnt/nas07/var/www/_bases/base_quaeris_fila5/laravel && git -C Modules/Media ls-files tests | awk '{print tolower($0)}' | sort | uniq -d` e `/usr/bin/find Modules/Media/tests -type f -iname '*test.php' ! -name '*Test.php'`, per rimisurare.
2. Leggere i 4 file con `diff` (comandi nello Stato misurato), chiedere all'utente le decisioni 1 e 2.
3. Eseguire il Lavoro 1-3 con il lock, poi gli AC con i comandi indicati; il punto 4 solo quando Pest riprende.
