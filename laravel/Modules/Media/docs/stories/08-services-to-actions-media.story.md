---
title: "[STORY] Services -> Actions nel modulo Media (residui VideoStream e SubtitleService)"
type: story
status: done
priority: medium
created: 2026-10-08
updated: 2026-10-08
module: Media
tags: [bmad, services, queueable-actions, no-services-rule, subtitle, video-stream, cleanup]
qmd: "media VideoStream SubtitleService residui StreamVideoAction ParseSubtitleXmlAction ConvertSrtToVttAction exit queueable"
related:
  - ./media-services-to-actions.story.md
  - ../../../../bmad-output/epic-code-standards-services-mixed-const.md
  - ../../../../bashscripts/ai/wiki/rules/no-services-rule.md
---

# Services -> Actions nel modulo Media

## Richiesta

Ordine permanente (2026-10-08): nessun `app/Services` ne' classe `*Service`; ogni use case e' una Queueable Action
con tutti i chiamanti aggiornati (epic `bmad-output/epic-code-standards-services-mixed-const.md`).

## Analisi (lo scopo, non il messaggio)

La story di settembre [`media-services-to-actions`](./media-services-to-actions.story.md) aveva gia' mappato
`VideoStream` e `SubtitleService` sulle Action e cancellato i residui. I file sono ricomparsi (commit `d16b681c`,
2026-10-06) e `Actions/Stream/SubtitleService.php` e' di nuovo una copia identica di `Services/SubtitleService.php`
(`diff`: differisce solo la riga `namespace`). Nessuna delle due e' una Action: niente `QueueableAction`, niente `execute()`.

| Classe residua | Use case | Action che lo copre gia' | Chiamanti di produzione |
|---|---|---|---|
| `Services/VideoStream` (init + headers Range + streaming) | stream video con supporto HTTP Range | `Actions/Stream/StreamVideoAction` (stesso codice piu' il controllo autorizzazione owner / super-admin) | nessuno; solo test |
| `Services/SubtitleService::get()`, `getFromXml()` | righe sottotitolo da XML | `Actions/Subtitle/ParseSubtitleXmlAction` | nessuno |
| `SubtitleService::getPlain()` | testo semplice | `Actions/Subtitle/ExtractSubtitlePlainTextAction` | nessuno |
| `SubtitleService::upateModel()` | salva il testo su un campo del model | `Actions/Subtitle/UpdateModelSubtitleFieldAction` | nessuno |
| `SubtitleService::srtToVtt()` | conversione SRT -> WebVTT | `Actions/Subtitle/ConvertSrtToVttAction` | nessuno |
| `setFilePath/setModel/getModel/getInstance/make`, proprieta' `disk`, `subtitles` | stato del singleton | superfluo: le Action ricevono i parametri | nessuno |

`StreamVideoAction` non ha chiamanti di produzione nemmeno lei (solo test): lo streaming oggi non e' agganciato a
nessuna route. Non e' un residuo da togliere, e' un'Action pronta; lo annoto in "Aperto".

## Modifiche

- Eliminati (recuperabili da `HEAD` di `Modules/Media`): `app/Services/VideoStream.php`,
  `app/Services/SubtitleService.php`, `app/Actions/Stream/SubtitleService.php`, i due `.php.bak` tracciati; la directory
  `app/Services/` non esiste piu'.
- Difetto trovato nell'Action successora `ConvertSrtToVttAction` (copiato dal Service): chiamava `exit()` se la lettura
  falliva (in un job in coda ammazza il worker), non chiudeva il file handle, leggeva a pezzi da 8192 byte e
  conteneva un `if ($fileHandle)` sempre vero (`Safe\fopen` lancia). Ora lancia `RuntimeException`, chiude l'handle e
  legge righe intere.
- `ParseSubtitleXmlAction`: il ritorno era `array<int, array<string, float|int|string|mixed>>`, il `mixed` era entrato
  nella migrazione e aveva perso la shape del Service (`@phpstan-type SubtitleItem`). Ripristinata come
  `list<SubtitleRow>` con shape `array{sentence_i: int, item_i: int, start: float|int, end: float|int, time: string, text: string}`.
- Test: tolti i tre blocchi che istanziavano le classi eliminate (`MediaHighestMissCoverageTest`: SubtitleService,
  VideoStream, SubtitleService delle Action; erano anche in parte `try/catch Throwable` che accettavano qualsiasi
  esito); `MediaCoverage100RemainingTest` ora controlla solo `StreamVideoAction` con path inesistente. Nuovi test sulle
  Action: `tests/Unit/Actions/Subtitle/SubtitleTextActionsTest.php` (testo semplice e salvataggio sul campo scelto,
  dalla fixture XML) e `ConvertSrtToVttActionTest.php` (solo le righe dei tempi cambiano la virgola in punto).

Nessuna `const` nel perimetro.

## Verifica

- `rg` su `VideoStream`, `SubtitleService`, `Modules\Media\Services` in `Modules`, `Themes`, `app`, `config`,
  `routes`, `resources`, `tests` (esclusi docs/vendor): zero risultati nel codice.
- Pest senza DB (`group no-media-db`): `Modules/Media/tests/Unit/Actions/Subtitle` 7 passed (la suite
  `ParseSubtitleXmlActionTest` esistente piu' i due file nuovi).
- PHPStan (`nice -n 10 vendor/bin/phpstan analyse` da `laravel/`, config `phpstan.neon`, un'unica esecuzione per i cinque
  moduli) su: `Media/app/Actions/{Subtitle,Stream}`, `Media/tests/Unit/Actions/Subtitle`, i due test Media modificati,
  `Seo/app/Adapters/MetatagFacadeAdapter.php`, `Job/app/Actions`, `Lang/app/Adapters`, `UI/app/Adapters`:
  `[OK] No errors`. Alla prima esecuzione un errore `argument.type` nel mio test nuovo (mock Mockery passato come
  `Model`): risolto con una classe anonima che estende `Model`, non con un'asserzione.
- `php -l` pulito su tutti i PHP modificati.
- Pest (host senza accesso al MySQL di test): le suite `no-media-db` girano. `MediaCoverage100RemainingTest`:
  5 passed. `MediaHighestMissCoverageTest`: 12 passed, 3 failed (`resources expose model pages and form`, `list pages
  expose table columns`, `ViewMedia infolist schema`: chiavi Filament `file`, `file_name`, `media_grid` assenti).
  Non riguardano le classi eliminate (non le referenziano); non ho potuto provare il prima senza stash/checkout, quindi
  li dichiaro come limite, non come verde.

## Decisioni

- `upateModel` (typo nel nome originale) e il suo stato singleton non tornano: `UpdateModelSubtitleFieldAction`
  e' gia' la forma corretta, con model e campo come parametri.
- Stesso schema (residuo di un Service gia' convertito, riapparso) nelle story fratelli `2026-10-08-services-to-actions-*` di UI, Job, Lang e Seo.

## Aperto

- `StreamVideoAction` non e' agganciata a nessuna route o controller: da decidere se serve davvero (il file usa
  `exit` per chiudere la risposta).
- I test `MediaHighestMissCoverageTest` e simili restano in parte sweep di coverage con `try/catch Throwable`; non toccati
  (fuori perimetro).
