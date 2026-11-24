---
title: "Harness: ADR e contratti verificabili in ogni modulo e tema"
type: story
module: Xot
status: review
created: 2026-11-24
updated: 2026-11-24
tags: [harness, adr, contracts, guard, bmad, second-brain, ecc]
qmd: "story harness adr contracts ogni modulo tema guard lessons invarianti group pest laravelday workshop"
related:
  - ../adr/agent-harness.md
  - ../concepts/agent-harness-guide.md
  - ../rules/action-behavioral-contract.md
---

# Story — harness: ADR e contratti verificabili in ogni pacchetto

Come agente (o persona) che lavora su un modulo o tema, voglio trovare nel pacchetto il **perché** delle sue forme di codice
(`docs/adr/`) e **cosa promettono** le sue Action (`docs/contracts/`), con test che falliscono se queste guide sono vuote,
copiate o scollegate dal codice, così da non copiare i difetti del codice vicino.
Riferimento: workshop laravelday-harness (R. Gallea) + OpenAI / Böckeler / Anthropic sull'harness engineering
(sintesi in [agent-harness-guide](../concepts/agent-harness-guide.md)).

## GitHub (tracciamento)

- Issue: DA CREARE (`gh` non autenticato in sessione) —
  `gh issue create --repo <repo del progetto ospite, da git remote -v> --title "Harness: ADR e contratti verificabili in ogni modulo e tema" --body-file laravel/Modules/Xot/docs/stories/harness-adr-e-contratti-in-ogni-pacchetto.story.md`

## Acceptance criteria

- [x] Canon aggiornato: ADR con `## Verifica`; contratti con invarianti in tabella a ID `<PREFISSO>-INV-<N>` + group Pest;
      docblock `@contract` ([regola](../rules/action-behavioral-contract.md)).
- [x] Sensori: `PackagesHaveContractsAndAdrTest` (frontmatter, 5 sezioni, nessun numero/data nel nome, README indicizza
      ogni file) e `ActionContractsAreCompleteTest` (`@contract`, formato ID, ID unici, group dichiarato esistente nei test).
- [x] ADR Xot riparati: rimosso `0000-template.md`, `0001-actions-over-services.md` (testo del workshop, classi inesistenti)
      riscritto come `actions-over-services.md` con fatti del progetto, `agent-harness.md` riscritto al formato e allo stato reale.
- [x] Guard `.harness/bin/guard` creato (l'hook condiviso lo cercava già); `GuardTest` reso source-level (L-005) ed esteso.
- [x] `.harness/memory/lessons.md`: L-001…L-007, ogni lezione con pezzo e condizione di rimozione.
- [x] AGENTS.md e `00-TRIGGER_MAP.md` rimandano al canon e ai comandi di verifica.
- [x] Ogni modulo e tema (26) ha README di `adr/` e `contracts/` specifici, ADR reali con Verifica, contratti per le Action
      con effetti collaterali più importanti (lavoro in 6 lane parallele, vedi sotto).
- [x] Sensori verdi sull'intero checkout: `composer harness:check` → 42 passed (63 assertions).

## Lane (claim)

| Lane | Pacchetti | Stato |
|---|---|---|
| 1 | AI, Notify, Gdpr | fatto: 8 ADR, 9 contratti (group reali su Gdpr/AI/Notify Mailjet), 4 test nuovi |
| 2 | Geo, Seo, Lang, Activity | fatto: 11 ADR, 15 contratti (group reali: OSM, Nominatim, IndexNow, log viewer); `wiki/decisions` di Geo convertite in ADR |
| 3 | User, Tenant, Employee, TechPlanner | fatto: 13 ADR, 16 contratti; 3 test nuovi, `CheckAppointmentConflictActionTest` riparato |
| 4 | Media, Blog, Cms, Comment | fatto: 13 ADR (3 di Comment portati al formato), 13 contratti |
| 5 | Job, UI, Rating, Xot `docs/contracts` | fatto: 8 ADR, 14 contratti; fixture Rating riallineata (suite ripartita) |
| 6 | Themes Sixteen, Two, TwentyOne, Zero, Meetup, Barthelemy | fatto: 12 ADR, 4 contratti (Sixteen), 4 test source-level nuovi; Barthelemy stub |
| coordinatore | canon, test, Xot `docs/adr`, guard, lessons, AGENTS.md, story | fatto |

## Fuori scope / note

- Il `.git` annidato di Xot diverge dal working tree del repo radice (711 file): pre-esistente, non toccato.
- Il bootstrap Laravel fallisce (`Modules/Comment/packages/spatie/laravel-comments` mancante nell'autoload): pre-esistente;
  i sensori dell'harness sono source-level apposta.
- Non adottati dal workshop: stop hook con receipt e Task Contract `T-NNN` (la story BMAD fa da Task Contract) — motivi nell'ADR.

## Evidenza

- `vendor/bin/pest Modules/Xot/tests/Unit/Harness/GuardTest.php` → 33 passed (86 assertions), exit 0.
- `phpstan analyse` su GuardTest, PackagesHaveContractsAndAdrTest, ActionContractsAreCompleteTest → 0 errori.
- `AgentInstructionLinksResolveTest`, `InstructionReferencesExistTest` → 2 passed dopo le modifiche ad AGENTS.md e trigger map.
- Guard live: l'ADR lo dava per attivo ma `.claude/` qui è una cartella (gitignored), non il symlink alla config condivisa,
  quindi l'hook non era registrato (`git switch --help` passava). Registrato in `.claude/settings.json`; ora
  `git switch --help` → bloccato `[harness:git.rewind]`, riga in `.harness/runs/trace.jsonl` con session id.
- Due falsi positivi visti dal vivo e corretti con un caso in GuardTest (35 passed): `git switch` nel corpo di un heredoc
  (testo, non comando) e `RefreshDatabase` nominato in un commento (ora conta solo `RefreshDatabase::class` o l'import).
- Nuovo sensore: i path `Modules/...php`/`Themes/...php` citati in `## Verifica` di un ADR devono esistere (al primo giro
  ha trovato `Modules/Comment/app/Contracts/CanComment.php`, inesistente: il file è in `app/Models/Contracts/`).

## Scoperte (debito reale emerso scrivendo i contratti)

| Dove | Problema | Stato |
|---|---|---|
| `Themes/Sixteen/app/Actions/SpidAuthAction.php`, `CieAuthAction.php` | `Log::info` con tutti gli attributi utente (codice fiscale compreso) | **corretto**: solo `attribute_names`; invarianti `SIXTEEN-SPID-INV-6`, `SIXTEEN-CIE-INV-4` con test (21 passed) |
| `Themes/Meetup/app/Providers/ThemeServiceProvider.php` | `POST /events/{slug}/book` senza gruppo `web` (niente sessione/CSRF), con un Controller | da decidere: aggiungere `web` può dare 419 al form esistente |
| `Modules/Xot` `SendMailByRecordAction` | PDF sempre in `my_doc.pdf` sul disco `cache`: due invii paralleli possono allegare il PDF di un altro | da decidere |
| `Modules/Job/app/Filament/Widgets/ScheduleStatusWidget.php` | esegue comandi Artisan senza `SuperAdminOnlyTrait` né autorizzazione ripetuta | da decidere (ADR `artisan-commands-from-ui-exact-match-allowlist`) |
| `Modules/Job` `ClearScheduleCacheAction` | chiavi `job::cache.*` inesistenti: `ScheduleClearCacheCommand` fallisce | da decidere |
| `Themes/TwentyOne` `ResolveFeaturedMarketsGridDataAction` | `$this__(` ×11 invece di `$this->tx(`: fallisce a ogni esecuzione; dipende da un modulo assente | da decidere |
| `Themes/Two` blocco `company/data` | iframe Nominatim contro l'ADR `map-blocks-static-image-and-link` | da decidere |
| `Themes/Two/docs/README.md`, `Themes/Zero/docs/README.md` | marker di merge non risolti | **corretto** (scelta in base ai file esistenti; Two senza nomi di progetto; Zero: 13 coppie di nomi che collidono per maiuscola, ora dichiarate come debito) |
| DB sqlite di test condiviso | mancano `users.state`, colonne di `consents`, tabella `inbound_emails`: test Gdpr/Notify rossi, invarianti senza group | da decidere (migrazioni non applicate al DB di test) |
| `Modules/AI` `ConfirmAiActionProposalAction` | non controlla lo stato: una proposta già eseguita si riesegue | da decidere |
| `Modules/AI` fallback OpenAI | ignora `free_models_only` (può costare) | da decidere |
| `Modules/Gdpr` `DeleteAccountAction` | transazione sulla connessione `user`, ma consensi/activity stanno su altre connessioni (atomicità solo apparente) | da decidere |
| `Modules/Notify` inbound webhook | `message_id` nullo → sovrascrive sempre la stessa riga | da decidere |
| `Modules/Notify` `SendNotificationAction` | annulla le chiavi UUID; 2 test rossi | da decidere |
| `Modules/Cms/app/View/Components/Head.php`, `BuildHeadSchemaAction.php` + test, `Modules/Seo/.../BuildSitemapAction.php`, 5 modelli Blog, `Rating` | **marcatori di conflitto committati** (codice che non compila: `<head>` pubblico e sitemap) | **corretto** unendo le parti complementari; Cms Head 9 passed, PHPStan 0; sensore `NoConflictMarkersInCodeTest` + lezione L-007 |
| `Themes/Sixteen/{layouts,components}/*.blade.php` | 3 copie morte con conflitti (le viste si caricano da `resources/views`) | **rimosse** |
| `Modules/Employee` `AbsenceRequestsTable` | `(int) Auth::id()` tronca gli UUID: `decided_by_user_id` sbagliato | da decidere |
| `Modules/Employee` Approve/Reject | nessun controllo che la richiesta sia ancora in attesa | da decidere |
| `laravel/app/Providers/FolioServiceProvider.php` | esiste, contro l'ADR Cms `folio-volt-sole-owner` (test rosso) | da decidere |
| `composer.lock` | elenca ancora `spatiex/laravel-comments` (pacchetto rimosso): la cache dei pacchetti rigenerata rompe il boot | da decidere: rigenerare il lock |
| `Modules/Activity` `LogModel{Created,Updated,Deleted}Action` | **password, remember_token e segreti 2FA scritti nel log attività**; `RedactModelAttributesAction` esisteva ma nessuno la chiamava | **corretto**: redazione nelle tre Action; invariante `ACTIVITY-MODEL-LOG-INV-1`, test 3 passed, prova di sensibilità (senza fix: 1 failed) |
| `Modules/Geo/vite.config.js` | marcatori di conflitto (build rotta) | **corretto**: import con `refreshPaths`, `node_modules` del modulo (le dipendenze sono nel suo package.json), `buildDirectory: assets/geo`; build non eseguita (node_modules assenti); sensore esteso ai `vite.config.*` |
| `Modules/Geo` `GetAddressDataFromFullAddressAction` | costruisce una notifica e non chiama `send()`; `FilterCoordinatesInRadius.php` con condizione invertita ancora presente | da decidere |
| config activitylog vs modulo Activity | scrittura su connessione di default Spatie, lettura su `activity`: su DB separati divergono | da decidere |
| docs di Geo, Lang, Activity; `Modules/Geo/public/assets` | marcatori di conflitto residui in docs e asset compilati | da sistemare (fuori dal codice sorgente) |

## Evidenza finale

- `cd laravel && composer harness:check` → **42 passed** (Docs ADR/contratti + Harness guard + conflict markers), exit 0.
- Inventario: **69 ADR, 71 contratti** in 26 pacchetti (prima ~15 ADR, 6 contratti); **160 invarianti** con group Pest
  esistente (il sensore verifica che il group ci sia), **93** dichiarate `—` (debito visibile).
- PHPStan sui 147 PHP toccati: 0 errori nuovi (restano solo errori pre-esistenti in `SpidAuthAction`/`CieAuthAction`).
- Test nuovi o con group: Sixteen 21 passed, Activity redazione 3 passed (+ prova di sensibilità), Cms Head 9 passed,
  Rating 173 passed (prima crashava), Gdpr/AI/Notify/Job/UI/Geo/Lang/TechPlanner group verdi lanciati singolarmente.
- Ambiente (pre-esistente, non risolto qui): `composer.lock` disallineato (`cknow/laravel-money`, `laravel/mcp`, … mancanti;
  `spatiex/laravel-comments` ancora elencato), DB sqlite di test con schema vecchio, `core.symlinks=false`.
- Commit: il lavoro è entrato nel commit di sync `cd558c016a` (14:01, già su `laraxot/dev`), insieme a lavoro di altre
  sessioni (pulizia di archivi docs, −446k righe, non di questa story).
