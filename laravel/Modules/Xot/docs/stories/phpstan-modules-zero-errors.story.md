---
title: PHPStan zero errori sui moduli
type: story
module: Xot
status: in-progress
created: 2026-11-05
updated: 2026-11-06
owner: Xot (qualità trasversale; i file corretti appartengono ai moduli indicati)
tags: [phpstan, quality, multi-agent, bmad]
related:
  - ./collision-rewrite-complete-files.story.md
  - ./dcp-201-nomi-dei-file-md-senza-date-e-senza-suffissi.story.md
  - ../../../User/docs/stories/phpstan-unused-relation-traits.story.md
  - ../../../Cms/docs/stories/phpstan-head-schema.story.md
---

# PHPStan zero errori sui moduli

## Scopo (il perché)

PHPStan a livello massimo serve a garantire che i tipi dicano la verità: ogni errore è un punto in cui il codice può
fallire a runtime senza avvisare. Il lavoro non è far sparire la riga: è rendere il tipo corretto, così il codice fa ciò
che dichiara. Si correggono le cause di dominio e si mantengono i contratti Laraxot, senza soppressioni, baseline
artificiali o modifiche a `laravel/phpstan.neon`.

## Criteri di accettazione

- [ ] AC1: ogni errore è corretto alla sorgente (tipo, generics, visibilità), senza `@phpstan-ignore`, baseline o modifiche a `phpstan.neon`.
- [ ] AC2: i trait inutilizzati non si cancellano senza prova: spesso il `use` è stato perso da un merge e va ripristinato.
- [ ] AC3: `analyse Modules` sul progetto intero esce 0 (il run per modulo produce falsi `trait.unused`).
- [ ] AC4: lock per file, nessuna modifica fuori dal proprio modulo senza lock e senza dichiararla.
- [ ] AC5: ogni collisione è riscritta come file completo coerente (vedi [collision-rewrite-complete-files](./collision-rewrite-complete-files.story.md)).
- [ ] AC6: ogni modulo e tema modificato supera i gate locali; il repository proprietario viene sincronizzato e verificato da chi ha l'ordine di commit (il daemon committa comunque `.` a intervalli).
- [ ] AC7: la documentazione resta organizzata e usa nomi Markdown stabili, senza date o timestamp nel nome.

## Coordinamento

Un modulo alla volta per agente; lo stato per modulo è tracciato in questa story. Gli agenti che lavorano nello stesso
working tree (Claude, Codex) si coordinano con i lock per file di `bashscripts/lock/` e con le story BMAD dei moduli
owner: un lock vivo non si ruba e non si duplica il lavoro.

## Ricomposizione delle collisioni

Il merge precedente aveva duplicato trait, import e relazioni nei modelli User. La ricomposizione mantiene i trait
relazionali dinamici basati su XotData, conserva `HasUuids`, `HasSlug` e i contratti del modello tenant, elimina le
duplicazioni e non copia meccanicamente una delle due versioni. Sono stati ricomposti anche gli indici e le story
documentali di AI e CMS: le voci duplicate e i riferimenti datati sono consolidati in riferimenti stabili.

## Stato verificato

Aggiornato 2026-11-06, dopo la riscrittura delle collisioni.

- `analyse Modules` intero: 253 → 110 → **71** errori nello sweep del 2026-11-05 (sera). Restano solo Cms 50 e Geo 21, entrambi di ambiente (vedi sotto); ogni altro modulo è a 0, Restaurant compreso (37 → 0).
- SVG nei moduli e temi: XML valido, nessun marker Git o pointer LFS.
- Marcatori di conflitto: zero in tutti i tipi di file dopo la ricomposizione del 2026-11-06 (misurato con `rg` escludendo vendor, node_modules, .git, storage).
- Cms 50: `laravel/head` è dichiarato in `Cms/composer.json` ma assente da `composer.lock` e `vendor/` (`Laravel\Head\Schema\*` not found).
- Geo 21: `Filament\Support\Components\Attributes\Exposed` non esiste nel Filament installato (5.9.0; il lock dice 5.10.3, `composer.json` chiede ^5.11).
- Un `composer update -W` mirato non risolve (`laravel/tinker` contro illuminate 13; `symfony/process` bloccato da security advisory). L'aggiornamento delle dipendenze è una decisione dell'utente.
- Pest non eseguibile: `.env.testing` ha `DB_USERNAME` vuoto e `TestCase` fallisce con `Access denied for user ''@'localhost'` prima di ogni asserzione.

## Storico delle misure

### Run per modulo, 2026-11-05 ~10:30

- 18 moduli. Puliti: Activity, Incentivi, Lang, Media, Pdnd, Performance, Progressioni, UI, User, Xot.
- Con errori: IndennitaCondizioniLavoro 1, IndennitaResponsabilita 7, Job 1, Notify 12, Ptv 2, Rating 3, Sigma 2, Tenant 1.
- Conseguenza di un cambio: `tableMorphMany` in RelationX; il fixture IrRelationshipProbe non usa RelationX.

### Incidente di protocollo, 2026-11-05 ~10:50

- Per errore è stato chiamato `unlock.sh` su `Sigma/Ana10f.php` e `Tenant/Tenant.php` dopo che `lock.sh` era fallito, cioè è stato rimosso il lock di un'altra sessione. Non è recuperabile: il proprietario originale è ignoto. Il lock è stato poi acquisito correttamente, le modifiche applicate e il lock rilasciato.
- Azione: chi aveva quei lock verifica che il proprio lavoro su questi due file sia ancora coerente con le modifiche presenti.
- Regola: controllare l'esito di `lock.sh` con `&&` prima di qualsiasi `unlock`, mai unlock dopo un lock fallito.

### Esito parziale, 2026-11-05 ~11:00

- Fatto: IR RelationshipTrait (anno: `mixed` → `int|null` senza azzerare il null), IR fixture IrRelationshipProbe (usa RelationX per `tableMorphMany`), Rating HasRatingsTrait (generic `int|string`, cast tipizzati con `is_numeric`), Sigma `Ana10f::getNome` (`string|null`), Tenant docblock (Xot UserContract), Sigma EnteStabiMutator (rimosso blocco `$repar` morto nell'accessor, duplicato di `getReparTxt`), ICL CondizioniLavoroMutatorTrait (trait morto: tutti i suoi 27 metodi sono già nel modello CondizioniLavoro; rimosso).
- Bloccato da un lock di `agent-general-accessors` (task accessor-methods-trait-extraction, 09:42): Notify, 12 errori (generics sulle relazioni in `Traits/*Relations.php` e MailTemplateVersion / NotificationTemplateVersion, tipi su NotifyThemeMutators). Correzioni pronte: relazioni con `@return BelongsTo<Related, $this>` o `MorphTo<Model, $this>` e visibilità `public`; rimuovere la docblock fuori posto su `restoreTemplate()`.
- Da verificare col run completo: Job TaskCommentRelations (errore di parse su un import User), Ptv HasWorkerTypesConfig e HasWorkerTypeNavigation (segnalati `unused` solo dal run per modulo: sono usati da Progressioni, IR, Performance).
- Regola: il run per modulo genera falsi `trait.unused`. Il criterio vincolante è il run sul progetto intero.

### Run completo `analyse Modules`, 2026-11-05 ~11:00: 24 errori, tutti in file lockati

Il run sul progetto intero non aveva errori in nessun altro modulo: Activity, Incentivi, IR, Ptv, Rating, Sigma, Tenant, ICL erano puliti.

- Job (14 errori, 13 file): Result.php:64 e ScheduleHistory.php:95 (docblock `@return` fuori posto), `Traits/*Relations.php` (generics mancanti su belongsTo/hasMany), `Traits/TaskRelations.php` (`@phpstan-return` non coincide col tipo: frequencies → Frequency, results → Result).
- Notify (10 errori): MailTemplateVersion.php:86 e NotificationTemplateVersion.php:59 (docblock di relazione fuori posto su `restoreTemplate`), `Traits/*Relations.php` (generics), NotifyThemeMutators (`getLogo` e `getLogoAttribute` con `array<string, mixed>`), NotifyThemeRelations::linkable (`MorphTo<Model, $this>`).
- Proprietario: `agent-general-accessors` (lock 09:42, file ancora in modifica alle 10:58). Il lock non è stato forzato; ricetta consegnata al proprietario.

### Sweep swarm, 2026-11-05 (sera): 253 → 110 → 71

Mandato permanente dell'utente (memoria `feedback_phpstan_swarm_standing_order`): `analyse Modules` in ordine casuale, in parallelo, partendo dallo scopo del codice e non dalla riga d'errore.

- **Misure** (stesso comando, `--error-format=json`): 253 → 110 → **71**.
- **Cause radice trovate** (non le righe):
  - Il lato `HEAD` dei marcatori di merge aveva tolto i `use Trait` dai modelli: i `trait.unused` a grappolo di User/Lang non erano codice morto. Ripristinati in avanti ([phpstan-unused-relation-traits](../../../User/docs/stories/phpstan-unused-relation-traits.story.md)).
  - `BaseTenant` aveva perso `HasUuids`. Ripristinato senza l'alias `resolveRouteBindingQuery` del lato `laraxot/dev`: in Spatie Sluggable 4.0.x quel metodo non è in `HasSlug`, l'alias era un fatal in autoload. Guardia: `User/tests/Unit/Models/BaseTenantKeyTest.php` (non eseguita, vedi Pest sopra).
  - Lang: due copie piatte stale di `PostMutators`/`PostRelations` rientrate col sync (`merge -s resolve` non gestisce le rinomine); rimosse, le sottocartelle sono le più nuove (`Lang/docs/stories/phpstan-zero-errors-lang.story.md`).
  - Restaurant: tipi di dominio, UI Filament e test, tre story (`Restaurant/docs/stories/phpstan-*-types.story.md`). `@property $pec` di `Company` e `Location` allineato al nome reale `certified_email` (la migrazione `translate_identifiers_to_english` lo aveva già rinominato).
- **Decisioni aperte:**
  - `Restaurant ChangesOrder`: con `Safe\preg_match` una nota con UTF-8 non valido ora lancia `PcreException` invece di essere trattata come nota libera.
  - `Order::$waiter_id` è documentato `int|null` ma la colonna è uuid e non ha cast (dipende da ADR-108): non toccato.
  - Lang: se un clone gemello ha ancora i file piatti, `merge_remote_repo_2.sh` può riportarli; in quel caso ricancellarli.
  - `Restaurant/docs/stories/20.{2,3,4,5}*.lock`: quattro lock del 2026-10-14 su story che non esistono nella cartella, di agenti morti; da pulire con `bashscripts/lock/README.md` alla mano.

## Metodo operativo

Prima di ogni modifica: lock del file, studio dei chiamanti e dei trait, verifica della storia Git e della documentazione
del modulo. Dopo ogni modifica: `php -l`, PHPStan mirato, gate di qualità disponibili, unlock. Mai reset, restore,
revert o force push; git solo in avanti.
