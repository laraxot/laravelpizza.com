---
title: "Audit approfondito modulo Media"
type: audit
status: review
updated: 2026-11-16
module: Media
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
qmd: "audit approfondito Media inventario policy Filament Actions AwsTest S3Test senza guard TemporaryUpload prunable commentato Media id cast string bigint cancellazione fisica StreamVideoAction ConvertController codice morto PHPStan Pest"
=======
=======
=======
<<<<<<< HEAD
qmd: "audit approfondito Media inventario policy Filament Actions AwsTest S3Test senza guard TemporaryUpload prunable commentato Media id cast string bigint cancellazione fisica StreamVideoAction ConvertController codice morto PHPStan Pest"
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_cMA4DX
qmd: "audit approfondito Media AwsTest S3Test senza guard TemporaryUpload prunable commentato Media id cast string bigint cancellazione fisica StreamVideoAction ConvertController codice morto PHPStan Pest"
=======
qmd: "audit approfondito Media inventario policy Filament Actions AwsTest S3Test senza guard TemporaryUpload prunable commentato Media id cast string bigint cancellazione fisica StreamVideoAction ConvertController codice morto PHPStan Pest"
>>>>>>> .merge_file_qFxrh1
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
qmd: "audit approfondito Media inventario policy Filament Actions AwsTest S3Test senza guard TemporaryUpload prunable commentato Media id cast string bigint cancellazione fisica StreamVideoAction ConvertController codice morto PHPStan Pest"
>>>>>>> laraxot/dev
related:
  - ../audit.md
  - ../piano-miglioramento.md
  - ../purpose.md
  - ../architecture.md
  - ../epics.md
  - ../../ecc/media-ecc-audit.md
  - ../stories/module-bmad-audit.story.md
---

# Audit approfondito — Media

## Metodo

<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_cMA4DX
Source-first (2026-11-16): inventario filesystem, `rg` su policy/marker/label,
lettura purpose esistente, PHPStan globale Modules già a 0 errori. Nessuna UI
inventata. Pest dichiarato solo se eseguito.

## Inventario misurato

| Area | Conteggio |
|---|---:|
| PHP in `app/` | 127 |
| Test PHP | 47 |
| Models (`app/Models/*.php`) | 4 |
| Policy files (approx) | 8 |
| Resource Filament | 3 |
| Actions | 51 |
| Services | 0 |
| Migration | 5 |
| Lang IT files | 48 |
| Marker conflitto | 0 |
| Occorrenze `return true` in Policy | 2 |
| Ratio test/app | 0.37 |

## Scopo (da docs esistenti / codice)

## Lo scopo in una frase **Media custodisce i file che fanno da prova a una decisione, e li rende utilizzabili nei formati che servono senza che il dominio sappia nulla di dischi e conversioni.**

## Finding preliminari (da inventario)

- Nessun finding automatico critico dall'inventario; completare review sicurezza/runtime con story dedicate.

## Finding approfonditi (codice)

- **P0** `StreamVideoAction`: auth solo se media non null; possibile path senza check; `echo`/`exit` nello stream.
- **P1** `TemporaryUpload::$guarded = []` (mass assignment aperto).
- Resources su XotBase (ok).

## Gate

```bash
cd laravel
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Media
# Pest solo fuori da 10.100.200.15 e con DB testing raggiungibile
./vendor/bin/pest Modules/Media/tests --no-coverage
```

PHPStan `Modules` (2026-11-16): **0 errori** sul tree completo.

## Piano

Vedi [piano-miglioramento.md](../piano-miglioramento.md).

## Riferimenti

- [audit.md](../audit.md)
- [ECC](../../ecc/media-ecc-audit.md)
- [Story](../stories/module-bmad-audit.story.md)
=======
>>>>>>> .merge_file_qFxrh1
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> laraxot/dev
Source-first, 2026-11-16: inventario filesystem, `rg -n` con `path:line`, lettura di policy, pagine del cluster `Test`, `TemporaryUpload`, `StreamVideoAction`, `ConvertController`, migration; `php artisan model:prune --pretend --model=…` (sola lettura); PHPStan sul modulo; Pest sullo scratch DB del repo. La documentazione è stata trattata come ipotesi: **dove codice e docs divergono vince il codice.** Nessuna UI o screenshot inventati; nessun comportamento a runtime del pannello è stato provato in un browser.

## Scopo (perché esiste)

Media custodisce i file che fanno da prova a una decisione e li rende utilizzabili nei formati che servono, senza che il dominio sappia di dischi e conversioni ([purpose.md](../purpose.md)). Criteri usati: (1) un file-prova non si perde; (2) i caricamenti mai confermati si ripuliscono con una regola; (3) un'operazione sul bucket la fa solo chi è autorizzato; (4) il modello rispecchia lo schema.

## Inventario misurato

| Area | Conteggio | Come |
|---|---:|---|
| PHP in `app/` | 127 | `find app -name '*.php'` |
| PHP in `tests/` / `*Test.php` | 47 / 41 | |
| Models top-level | 4 | `BaseModel`, `Media`, `MediaConvert`, `TemporaryUpload` (+ 1 `.backup-…` in `app/Models`) |
| Policy | 4 file | `MediaBasePolicy` (abstract, `before()`) + `MediaPolicy`, `MediaConvertPolicy`, `TemporaryUploadPolicy` |
| Filament Resource | 3 | `Media`, `MediaConvert`, `TemporaryUpload` |
| Pagine di Resource / pagine del cluster `Test` | 15 / 2 | `AwsTest`, `S3Test` |
| Widget | 1 | `MediaResource/Widgets/ConvertWidget` |
| Actions | 51 | `find app/Actions -name '*.php'` |
| Services | **0** | nessuna directory `app/Services` |
| Migration | 5 | 2 `create_medias_table` (`2022_01_01_000011`, `2026_07_23_150000`) |
| Lang IT | 24 file | (un conteggio precedente indicava 48: errato) |
| Marker conflitto / `RefreshDatabase` / `migrate:fresh` | 0 / 0 / 0 | |
| `strict_types` mancante | 0 | |
| `@phpstan-ignore` in `app/` | 2 | `Actions/Video/ConvertVideoByMediaConvertAction.php:55`, `ConvertVideoByConvertDataAction.php:47` |
| `return true` in Policy | 2 | solo `MediaBasePolicy::before()` (`:17,:22`): bypass `super-admin`/`media::admin` voluto |
| Doc `.md` in `docs/` | 512 | 16 senza frontmatter, 31 con nome maiuscolo/datato |

Consumatori fuori modulo (file con `use Modules\Media\`, esclusi i test): Notify 8, User 4, Rating 2, IndennitaResponsabilita 1, Progressioni 1, Ptv 1, Xot 1. **Activity e Lang non usano Media.**

## Quadro per area

| Area | Evidenza | Sev |
|---|---|---|
| Pagine `AwsTest`/`S3Test` | scrivono e cancellano oggetti sul bucket, mostrano prefisso chiave e bucket; nessun `canAccess` | **P1** |
| `TemporaryUpload` | `MassPrunable` senza `prunable()`: `model:prune` → `LogicException` (verificato) | **P1** |
| `Media::id` | cast `string` su PK bigint; test fallisce | **P1** |
| Cancellazione | `DeleteAction` senza `SoftDeletes`: contraddice lo scopo «prova» | **P1** |
| `StreamVideoAction`, `ConvertController`, Request S3 | 0 caller in produzione; autorizzazione aggirabile se cablata | **P1** (latente) |
| Docs vs codice | architecture con 6 classi inesistenti; purpose con numeri e «zero Widget» errati | **P1** |
| Hardcoded, ignore, junk, debug, `$guarded=[]`, test «coverage» | vedi P2 | P2 |

## Finding

### P1-1 — Le pagine di diagnostica AWS/S3 operano sul bucket senza autorizzazione esplicita

- `app/Filament/Clusters/Test/Pages/AwsTest.php:345,360` — il test «S3 File Operations» esegue `putObject` e `deleteObject` sul bucket configurato (`filesystems.disks.s3`); `:256-258` mostra prefisso (8 caratteri) di `AWS_ACCESS_KEY_ID`, regione e bucket; `S3Test.php:285-286` mostra prefisso chiave e presenza del secret.
- Nessuna delle due pagine né il cluster `Test` (`Filament/Clusters/Test.php`) definisce `canAccess()` o usa `SuperAdminOnlyTrait` (`rg canAccess app` in Media → 0); `XotBasePage` non lo impone. Il trait di Xot esiste ed è il pattern già usato da Job/Xot (`Xot/app/Filament/Traits/SuperAdminOnlyTrait.php`).
- Effetto atteso: chiunque entri nel pannello Media può avviare scritture/cancellazioni di prova sul bucket di produzione e leggere dettagli di configurazione. **Non provato a runtime**; prerequisito: poter entrare nel pannello.

**Fix:** `SuperAdminOnlyTrait` su `AwsTest` e `S3Test` (o sul cluster); Pest `actingAs` utente senza ruolo → 403.

### P1-2 — `TemporaryUpload` non viene mai ripulito (`prunable()` commentato)

- `app/Models/TemporaryUpload.php:82` — `use MassPrunable;` ma `prunable()` è commentato (`:241-244`, con nota «Call to an undefined method … ::old()»).
- **Verificato:** `php artisan model:prune --pretend --model='Modules\Media\Models\TemporaryUpload'` → `LogicException: Please implement the prunable method on your model.` (`MassPrunable.php:50`).
- Effetto sullo scopo (criterio 2, purpose § 2): i file caricati e mai confermati si accumulano; nessuna regola di scadenza. Inoltre qualunque job di prune che includa il modello fallisce.

**Fix:** implementare `prunable()` (scadenza esplicita, es. 24 h) con scope `old()` corretto, loggando i record rimossi; Pest sul prune.

### P1-3 — `Media::id` è cast a `string` ma la chiave è bigint

- `app/Models/Media.php:144` e `app/Models/BaseModel.php:21` — `'id' => 'string'`; `database/migrations/2022_01_01_000011_create_medias_table.php:23` e `2026_07_23_150000_create_medias_table.php:23` — `$table->id()` (bigint auto-increment).
- Pest `Modules/Media/tests/Unit/Models` su scratch DB: **49 pass, 1 fail** — `tests/Unit/Models/MediaTest.php:369` («media has casts») si aspetta `'id' => 'integer'`, il modello dà `'string'`; lo stesso file asserisce `expect($media->id)->toBeGreaterThan(0)` (`:342`).
- Effetto: `$media->id` è una stringa per una chiave intera; i confronti stretti con interi (`===`, `in_array(..., true)`) falliscono in silenzio. Chi ha ragione, test o modello, va deciso (D-2): lo schema dice intero.

**Fix:** togliere il cast `id` da `Media` (lasciando `Model` gestire `int`), oppure aggiornare il test se esiste un motivo documentato per la stringa. 14 test restano «pending» dopo il primo fallimento (`--stop-on-failure`).

### P1-4 — Cancellazione fisica degli allegati: contraddice lo scopo «prova»

- `app/Filament/Resources/MediaResource/Tables/MediaTable.php:90` — `'delete' => DeleteAction::make()->requiresConfirmation()`; `Pages/EditMedia.php:23` — `DeleteAction::make()`.
- `Media` non usa `SoftDeletes` (`rg SoftDeletes app` → 0; compare solo come `@property $deleted_at`/cast, `Media.php:75,148`); `MediaPolicy.php:47-50` consente `delete` con il solo permesso `media.delete`.
- Dal purpose § 1: un allegato che motiva un'esclusione o un'indennità è **prova**; la cancellazione fisica distrugge la motivazione. Non esiste distinzione fra media «di lavoro» (rigenerabili) e «documentali» (unici). Cosa succeda ai file su disco alla cancellazione è dedotto dalla libreria `spatie/laravel-medialibrary`, **non provato**.

**Fix (D-3):** collection «documentale» con sola cancellazione logica; `delete` ammesso solo sulle collection rigenerabili.

### P1-5 — Codice senza caller che, se cablato, è insicuro

- `app/Actions/Stream/StreamVideoAction.php:71` — l'autorizzazione è applicata solo se `$media !== null && Auth::check()`: con `$media = null` o utente non autenticato **nessun controllo**, e `$disk`/`$path` sono arbitrari (`:79` `exists($path)`); anche quando c'è, vale solo `created_by == utente` o `super-admin`, non la policy (`media::admin` escluso). Lo stream scrive con `echo` e termina con `exit` (`:123,133,161,176`), fuori dal ciclo di risposta di Laravel. La prima analisi lo classificava P0; qui è P1 latente perché non ha caller. Callers: nessuno in `app/` di alcun modulo (`rg` → solo `tests/…Coverage…Test.php`).
- `app/Http/Controllers/ConvertController.php:17` — `view('media::convert')` senza dati, mentre `resources/views/convert.blade.php:12` usa `{{ $id }}`: variabile non definita. `routes/web.php` e `routes/api.php` sono vuoti: il controller non è raggiungibile.
- `app/Http/Requests/CreateTemporaryUploadFromDirectS3UploadRequest.php` — nessun caller in `app/`, nessun `authorize()` (default dei `FormRequest`: `true`).

**Fix:** cancellare le 3 classi o cablarle con policy; se si cabla lo streaming, autorizzare sempre via `Gate`.

### P1-6 — Documentazione che contraddice il codice

- `docs/bmad/architecture.md` (versione precedente) elencava `UploadMediaAction`, `ProcessMediaAction`, `DeleteMediaAction`, `MediaCollections`, `MediaItem`, `CollectionResource` (**non esistono**: `find app -name '<nome>*.php'` → 0 per tutte), «streaming HLS/DASH» e «watermark automatico» (nessuna Action dedicata) e «usato da Activity, Lang» (non importano Media). Riscritta: [architecture.md](../architecture.md).
- `docs/bmad/purpose.md`: «Zero Widget» (esiste `ConvertWidget`), «49 Action / 124 file PHP» (ora 51 / 127). Aggiornato con la sezione di stato.
- `decision-log.md` ed `epics.md` erano template; sistemati.

### P2

- **Stringhe letterali nel modulo.** `Filament/Clusters/Test/Pages/AwsTest.php:55,71,92,113,135` (`->description`/`->label` in inglese), `:308-557` (titoli notifica in inglese), `Filament/Actions/Table/ConvertAction.php:21` `->tooltip('convert')`.
- **Soppressioni PHPStan.** 2 `@phpstan-ignore-next-line method.notFound` (`ConvertVideoByMediaConvertAction.php:55`, `ConvertVideoByConvertDataAction.php:47`) in un progetto «senza baseline: gli errori vanno corretti».
- **Junk.** `app/Models/BaseModel.php.backup-20251015-092511`, `app/Actions/Image/SvgExistsAction.to_xot`, `app/Console/Commands/_components.json`.
- **Debug.** `Console/Commands/ConvertVideoCommand.php:26-27` `print_r` di disco e file.
- **`TemporaryUpload::$guarded = []`** (`:99`): assegnazione di massa totale su un modello alimentato da richieste di upload; oggi nessun caller visibile lo riempie da input (`rg` → nessuno).
- **Test.** 2 `->todo()` con closure vuota (`MediaActionsCoverageTest.php:55,71`); 5 file «coverage» (`Media{HighestMiss,GapCloser,GapAttack}Coverage…`, `MediaCoverage100RemainingTest`, `ModuleCoverageBoostTest`: 719 righe) nominati per la percentuale.
- **Action senza caller.** `ConvertVideoAction`, `ConvertVideoByConvertDataAction` (percorso FFmpeg) e `AttachMediaAction`: nessun riferimento in `app/` di alcun modulo (`rg` → solo `tests/`); la conversione raggiunta oggi passa da `ConvertVideoByMediaConvertAction` (`Filament/Actions/Table/ConvertAction.php`, `MediaConvertsTable.php`).
- **Migration doppia.** Due `create_medias_table` (2022 e 2026): sicure se `tableCreate()` salta a tabella esistente, ma ridondanti.

## Verificato e non è un finding

- Resource su base Xot (`XotBaseResource`/`XotBasePage`).
- Policy: `MediaBasePolicy::before()` con bypass `super-admin`/`media::admin`; le tre figlie decidono per permesso (`media.viewAny`, `media.delete`, `media.forceDelete`, …), nessun `return true`.
- 0 SQL grezzo, 0 `property_exists`, 100% `strict_types`, 0 marker, 0 `RefreshDatabase`.
- `env()` solo in commenti (`Datas/CloudFrontData.php:19-27`).

## Gate

| Gate | Esito |
|---|---|
| PHPStan `Modules/Media` (`php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Media --no-progress`) | **0 errori** (exit 0) |
| Pest `Modules/Media/tests/Unit/Models` (scratch DB, host 127.0.0.1) | **parziale: 49 pass, 1 fail** (`MediaTest.php:369`, P1-3), 14 pending dopo lo stop; resto della suite non eseguito per carico macchina (load ≈ 50) |

Nessun `migrate:fresh`, nessun `--force`, nessun `RefreshDatabase` lanciati dall'audit. Suite completa, solo fuori dalla produzione e con DB testing raggiungibile:

```bash
cd laravel
./vendor/bin/pest Modules/Media/tests --no-coverage
```

## Piano

[piano-miglioramento.md](../piano-miglioramento.md) · [epics.md](../epics.md) · [decision-log.md](../decision-log.md).

## Riferimenti

[Sintesi](../audit.md) · [ECC](../../ecc/media-ecc-audit.md) · [Story](../stories/module-bmad-audit.story.md) · [Brainstorming](../brainstorming.md)
