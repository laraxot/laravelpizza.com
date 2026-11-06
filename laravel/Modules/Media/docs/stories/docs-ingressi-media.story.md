---
title: "[STORY] Ingressi docs del modulo Media verificati sul codice"
type: story
status: done
priority: medium
created: 2026-10-14
updated: 2026-10-14
module: Media
tags: [bmad, docs, indice, verifica, docs-organizer, DOC-002, DOC-010]
qmd: "media docs ingressi README 00-INDEX INDEX architecture ARCHITECTURE stale superseded Tenant Services HLS watermark docs-organizer busy"
related:
  - ../README.md
  - ../00-INDEX.md
  - ../../../Fixcity/docs/stories/dcp-56-organizzazione-docs-moduli-e-temi.story.md
  - ../../../../../bmad-output/docs-architecture/module-theme-docs-contract.md
---

# Ingressi docs del modulo Media verificati sul codice

Fase BMAD: documentazione e qualita' (DOC-010 e DOC-002 del piano `bmad-output/stories/docs-organization/`).

## Richiesta

Studiare il modulo Media (codice e `docs/`), correggere gli ingressi (`README.md`, `00-INDEX.md`, `index.md`) solo con fatti verificati, dichiarare directory canoniche, evidence e legacy, collegare solo file esistenti. Vietato spostare, rinominare o cancellare file; vietato `dups --fix`.

## Analisi (cosa fa il modulo, confrontato con cio' che i docs dicevano)

Codice letto: `app/` (124 file PHP), `routes/`, `config/`, `database/migrations`, `lang/`, `tests/`, `composer.json`, `laravel/config/media-library.php`.

Cosa e' vero:

- `Media` estende il modello Spatie MediaLibrary; `TemporaryUpload` implementa `HasMedia`; `MediaConvert` traccia le conversioni; connessione `media` in `Models/BaseModel`. `laravel/config/media-library.php` imposta `media_model` e `temporary_upload_model` sulle classi del modulo.
- 49 Action in `app/Actions` (Video, Subtitle, Stream, S3, CloudFront, Diagnostic/Aws, Diagnostic/S3, Ffmpeg, Image, Storage, TemporaryUpload), un comando `media:convert-video {disk} {file}`, 3 Resource Filament piu' `HasMediaResource`, cluster `Test` con `AwsTest` e `S3Test`.
- Nessuna rotta propria: `routes/web.php` e `routes/api.php` sono vuoti; il pannello `media::admin` espone 19 rotte (`php artisan route:list --name=media`).
- Dipendenze reali dal codice: Xot 85 righe `use`, User 3, UI 2, Job 1. Consumatori (file in `Modules/*/app` e `Themes/*/app`): Blog 9, Notify 8, User 4, Rating 2, Fixcity 2, Cms 2, Xot 1.

Cosa i docs dicevano di falso o non provato:

| Dove | Affermazione | Esito |
|------|--------------|-------|
| `README.md`, `readme.md`, `architecture.md` | dipende da `Tenant` e isola per tenant | nessun riferimento a `Tenant` in `app/`; solo nei `repositories` di `composer.json` |
| `README.md` | wiki legacy in `docs-archive-2026/` | la directory non esiste ne' nel modulo ne' nella radice del repo |
| `INDEX.md` | Services 2 (`SubtitleService`, `VideoStream`) | `app/Services` non esiste; `Actions/Stream` contiene solo `StreamVideoAction` |
| `INDEX.md` | Models 8, Migrations 3, Filament Resources 30, "101+ classi" | Models 4 (+4 Policy), 5 file di migrazione, 41 file in `app/Filament` (3 Resource), 124 file PHP |
| `index.md` | `SubtitleService`, `VideoStream`, `MediaService` come servizi disponibili | nessuno dei tre esiste |
| `index.md`, `architecture.md` | HLS/DASH, watermark automatico, CDN generico | HLS 0 riscontri, DASH 0, watermark 0; esiste solo CloudFront (12 file) |
| `ARCHITECTURE.md` | `UploadMediaAction`, `ProcessMediaAction`, `DeleteMediaAction`, `MediaItem`, `CollectionResource`, consumatori Activity e Lang | classi assenti (0 riscontri in `app/` e `tests/`); consumatori non confermati |
| `index.md` | 55 link a file inesistenti (27 bersagli distinti, ripetuti per concatenazione di due indici) | resi testo "non presente" |
| `00-index.md`, `wiki/00-index.md` | 4 e 10 link rotti, emoji, "Compliant" non provato | copie per variante di maiuscole, marcate `superseded` |
| `docs/lambda_function.py`, `lambda-function.py` | (nessun docs li cita) | identici (`cmp`), esempio AWS Lambda con ffmpeg; nessun uso nel modulo: zero riscontri di "lambda" in `app/`, `config/`, `tests/` |

Struttura dei docs (548 file `.md`): radice 275, `wiki/` 94, `bmad/` 68, `roadmap/` 29, `stories/` 22, `_integration/` 13, `llm-wiki/` 7, `html2pdf/` 7, `raw/` 6, `performance/` 5. Radice per famiglia (regole sul nome del file, non sul contenuto): PHPStan e qualita' 54, altro 46, prodotto 33, conflitti di merge 33, architettura 27, duplicati 20, MCP e AI 19, FFmpeg e video 18, Filament e migrazioni 15, S3 e AWS 10. 45 gruppi di nomi con varianti di maiuscole o separatori (103 file su 217 nomi distinti), 0 file `superseded` prima di questa passata.

## Modifiche

File toccati (tutti con mtime piu' vecchio di 10 minuti al momento della modifica; nessuna riga altrui sovrascritta, sostituzioni di stringhe esatte):

- `docs/README.md`: scopo, linkage, quick start e limiti verificati; rimossa la citazione di `docs-archive-2026/`.
- `docs/00-INDEX.md`: stato verificato, documenti canonici, mappa delle directory (canonica, evidence, legacy), famiglie della radice con conteggi; frontmatter `type: index`, `status: active`.
- `docs/INDEX.md`: tabella "Module Content Overview" corretta, riferimento a `architecture.md`, riga story aggiornata.
- `docs/index.md`: nota di bridge, link inesistenti ridotti a testo, blocco "Servizi disponibili" corretto, intestazione spuria di 9 righe (residuo di merge) rimossa.
- `docs/architecture.md`: correzioni su Tenant, Services, HLS/DASH, watermark, CDN, conteggi; nota sulla sezione copiata da `ARCHITECTURE.md`; frontmatter spurio interno rimosso.
- `docs/ARCHITECTURE.md`: `docs-organizer.py stale --file ARCHITECTURE.md --fix` (status `stale` e nota).
- `docs/00-index.md`, `docs/wiki/00-index.md`, `docs/wiki/00-INDEX.md`, `docs/wiki/index.md`: `status: superseded` con `superseded_by`; contenuto conservato; `wiki/00-INDEX.md` non aveva frontmatter.
- `docs/wiki/INDEX.md`, `docs/wiki/README.md`: inventario reale della wiki (94 file, 13 sottocartelle); il vecchio README descriveva una struttura inesistente.
- `docs/wiki/log.md`, `docs/decision-log.md`: voce datata del 2026-10-14.

Nessun file cancellato, spostato o rinominato.

## Verifica (output reale)

- `docs-organizer.py --busy-minutes 0 links laravel/Modules/Media/docs --by-name` (sola lettura), eventi `unresolved` sui file toccati: prima 69, dopo 0. Per file: `index.md` 55 a 0, `wiki/00-index.md` 10 a 0, `00-index.md` 4 a 0, gli altri gia' 0 (i riferimenti alla presente story sono stati risolti scrivendola). Totale modulo: 769 a 700.
- Baseline errata: alle 07:38 lo stesso comando senza `--busy-minutes 0` dava 3 eventi, perche' i file toccati da meno di 10 minuti (le passate meccaniche delle 07:28) venivano esclusi senza segnalarlo; con `--busy-minutes 0` i file e gli eventi erano 548 e 769.
- `docs-organizer.py --busy-minutes 0 frontmatter` (dry-run): nessun evento sui 14 file toccati dopo la rimozione dei blocchi spuri; YAML letto con `yaml.safe_load` su tutti e 14, chiavi `title`, `type`, `status`, `updated`, `tags`, `qmd` presenti.
- `php artisan list media`: `media:convert-video  Convert Video`. `php artisan route:list --name=media`: `Showing [19] routes`, tutte `media/admin/...`.
- `vendor/bin/phpstan analyse Modules/Media --memory-limit=3G --no-progress --error-format=raw` da `laravel/`: exit 0, nessun errore.
- Pest non eseguito: la suite usa la connessione `media` e non e' stato verificato l'isolamento dal DB di sviluppo con config cache attiva.

## Decisioni

1. `00-INDEX.md` e' l'unico indice operativo; le copie per variante di maiuscole sono `superseded`, non cancellate (nessun indice con nome alternativo).
2. `ARCHITECTURE.md` e' `stale` e non viene riscritto: la fonte e' `README.md` piu' `architecture.md` corretta.
3. I link inesistenti negli ingressi diventano testo "non presente" invece di essere puntati a file "simili": nessun bersaglio inventato. `--annotate` non e' stato usato perche' lavora su tutta la cartella e non su un file.
4. Le righe aggiunte sono in italiano senza emoji; le copie `superseded` conservano il testo originale, emoji compresi.

## Aperto

- 700 eventi `unresolved` restano in 230 file del modulo (primi: `duplicate-methods-analysis.md` 189, `wiki/bottlenecks.md` e `bmad/bottlenecks.md` 17 ciascuno, `bottlenecks.md` 15, `conflitti-merge-risolti*.md` 13): sono copie e cronaca, da trattare con DOC-004.
- Dry-run `frontmatter` con `--busy-minutes 0` dopo le mie correzioni: 67 file senza chiavi richieste (per lo piu' `status`) e 5 blocchi spuri da correggere a mano; l'esclusione silenziosa dei file recenti ha lasciato fuori questi file dalla passata del lead.
- 45 gruppi di nomi con varianti di maiuscole nella radice: servono migration map e revisione umana (DOC-004, DOC-006).
- Contenuto non verificato riga per riga: `ffmpeg-usage.md`, `queueable-actions.md`, `testing.md`, `MIGRATIONS.md`, `phpstan-level10-fixes.md`, `dependency-intelligence.md` (versioni da `composer show` del 2026-03-02) e i documenti di prodotto.
- Codice (fuori perimetro docs): `app/Filament/Clusters/` contiene un file tracciato da 0 byte in una directory dal nome corrotto accanto a `Test/`; due file di create per `medias` e per `temporary_uploads` (la nota `wiki/concepts/temporary-uploads-migration-consolidation.md` dichiara una sola migrazione per modello); `ConvertController` e `resources/views/convert.blade.php` senza rotta; `app/Conversions` e `app/conversions`, `tests/Filament` e `tests/filament` (story 16-4).
- Nessun commit eseguito; il second brain (`bashscripts/ai/wiki/memories/`) e `llm-wiki-qmd.sh update` restano al lead.
