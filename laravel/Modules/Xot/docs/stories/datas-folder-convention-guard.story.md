---
title: "Datas, mai Data ne' DTOs: causa alla fonte e guardia a test"
type: story
module: Xot
status: review
created: 2026-10-23
updated: 2026-10-23
tags: [datas, dto, spatie-laravel-data, convenzioni, guardia, architecture-test]
qmd: "app/Datas plurale perche Data singolare DTOs make:data namespace config data.php guardia DatasFolderConventionTest structure caching"
related:
  - ../../../../../bashscripts/docs/prompts/04-datas-not-dtos.md
  - ../data/data-objects.md
  - ../../tests/Unit/Architecture/DatasFolderConventionTest.php
  - ../../tests/Unit/Architecture/NoServicesTest.php
---

# Datas, mai Data ne' DTOs

## Perche'

L'utente (2026-10-23, due messaggi): `app/Data/` e `app/DTOs/` sono sbagliate, la cartella e' `app/Datas/`; capire il perche', non ripetere l'errore.

- **Il senso del plurale.** In Laraxot la cartella si ricava dal suffisso della classe: `*Action` in `Actions/`, `*Enum` in `Enums/`, `*Data` in `Datas/`. Un nome solo per 18 moduli: un `glob` li trova, PHPStan e i test cercano in un posto, e `Data` da sola indica sempre `Spatie\LaravelData\Data`.
- **Da dove nasce l'errore.** Il default di Spatie: `make:data` genera in `App\Data` (`config/data.php`, `commands.make.namespace = 'Data'`) e la documentazione del pacchetto usa `app/Data`. Chi segue il pacchetto invece del progetto lo riproduce (oggi: Mobile e Seo in `Data/`, Xot in `DTOs/`, Geo in `DataTransferObjects/` nei test).
- **Perche' una regola scritta non bastava.** Il divieto c'era gia' nel prompt 04 ed e' stato violato lo stesso: nessun controllo a macchina. Una guardia a test vale per ogni strumento che scrive qui (Claude, Codex, OpenCode), un hook solo per uno.

## Cosa e' stato fatto (questa sessione)

| File | Modifica | Prova |
|------|----------|-------|
| `laravel/config/data.php` | `commands.make.namespace` da `Data` a `Datas` | `php -l` ok; letto da `DataMakeCommand` (`config('data.commands.make.namespace', 'Data')`) |
| `Modules/Xot/app/DTOs/*` | `FieldDTO`, `FieldFilterDTO`, `links.md` ritirati (`.old`): 0 chiamanti PHP, solo report di coverage storici | `rg` a zero, controprova `LocationDTO` trovato; la cartella e' stata poi rimossa da un'altra sessione, il contenuto resta nella storia git |
| `Modules/Xot/tests/Unit/Architecture/DatasFolderConventionTest.php` | guardia nuova (riscritta in parallelo da un'altra sessione con `File::allDirectories`, tenuta) | verde 2,9 s; **rossa** con una sonda `app/DTOs/ProbeGuardDTO.php` (nome del file nel diff), sonda rimossa; PHPStan 0 |
| `bashscripts/docs/prompts/04-datas-not-dtos.md` | perche' del plurale, causa alla fonte, guardia nel gate | |

Spostamenti Mobile (`app/Data` -> `app/Datas`, `tests/Unit/Data` -> `Datas`), Seo e Geo (cartelle dei test): fatti da un'altra sessione fra le 14:45 e le 14:58, non toccati qui.

## Cache delle strutture di laravel-data

`deploy.sh` lancia `php artisan optimize`, che esegue `data:cache-structures`. Con `structure_caching.directories = [app_path('Data')]` (cartella inesistente) la cache in produzione non contiene **nessuna** classe. Puntarla a `Modules/*/app/Datas` non basta: con `reflection_discovery.enabled = true` il nome della classe si ricava dal percorso (`Modules\AI\app\Datas\X`, sbagliato per il segmento `app/`) e le classi trovate restano **0**; con il parser (`reflection_discovery.enabled = false`) sono **157**, nomi corretti (misura in memoria, store `array`, nessuna scrittura).

Il rischio: `optimize:clear` non svuota la cache di laravel-data (il pacchetto registra solo `optimize`) e la durata e' infinita, quindi in sviluppo un `optimize` congelerebbe la forma dei Data che gli agenti modificano di continuo.

**Decisione applicata (15:3x):** `config/data.php` ha `enabled = env('DATA_STRUCTURE_CACHING', APP_ENV === 'production')` (acceso in produzione, spento in locale senza toccare nessun `.env`), `directories` = `Modules/*/app/Datas`, `reflection_discovery.enabled = false` (parser). Su un mancato riscontro laravel-data ricade sulla reflection (`CachedDataConfig::getDataClass`), quindi una cache parziale non rompe nulla; `deploy.sh` rilancia `optimize` a ogni deploy.

**Difetto trovato provandolo come in produzione** (`APP_ENV=production CACHE_STORE=array data:cache-structures`): exit 1, `Class "Modules\Blog\Datas\ArticleDataCore" does not exist`. `Blog/app/Datas/ArticleData.php` dichiarava tre classi (`ArticleDataCore`, `ArticleDataBlocks`, `ArticleData`): le prime due si caricavano solo se `ArticleData` era gia' in memoria (`ArticleDataPayloadMapper` le usa direttamente). Con `set -e` in `deploy.sh` il deploy si sarebbe fermato. Corretto alla fonte: una classe per file (`ArticleDataCore.php`, `ArticleDataBlocks.php`, FQCN invariati). Dopo: `Cached 157 data classes`, exit 0; PHPStan `Blog/app/Datas` 0. Guardia: secondo test in `DatasFolderConventionTest` («ogni classe trovata in app/Datas si carica da sola», la stessa ricerca del comando), rosso con una sonda `ProbeGuardDataExtra` in un file di nome diverso, verde dopo. Config cache di sviluppo rigenerata: `enabled=false`, `make.namespace=Datas`, home 200.

## Incoerenza da risolvere

`docs/data/data-objects.md` (sezione «Cartella canonica», scritta da un'altra sessione) dice che il nome della classe «puo' restare `LocationDTO`»; il prompt 04, fonte di verita', vieta il suffisso `DTO` e chiede `*Data` che estende `Data`. Vale il prompt. **Risolta** (15:05): la sezione ora dice `LocationDTO` -> `LocationData`, con il perche' del plurale, la causa e il link alla guardia.

## Acceptance

- [x] causa alla fonte corretta (`make:data` genera in `Datas`)
- [x] guardia a test, prova rossa e verde
- [x] nessun `.php` in cartelle vietate (`DatasFolderConventionTest` verde)
- [x] decisione sulla cache delle strutture (produzione si', locale no; 157 classi in cache, deploy non piu' bloccato da `ArticleData.php`)
- [ ] classi con suffisso `DTO` rinominate in `*Data` (Geo `LocationDTO`, in corso altrove)
