---
title: "Collisioni: riscrivere il file completo, non scegliere un lato"
type: story
module: Xot
status: in-progress
created: 2026-11-06
updated: 2026-11-06
owner: Xot (tooling e regole trasversali; i file toccati appartengono ai moduli indicati)
tags: [merge-collisions, rewrite, bmad, multi-agent, docs-organization]
related:
  - ../bmad/stories/merge-marker-fleet-residue.story.md
  - ../bmad/stories/8.24-merge-conflict-resolution-fleet-swarm.story.md
  - ./dcp-201-nomi-dei-file-md-senza-date-e-senza-suffissi.story.md
  - ./phpstan-modules-zero-errors.story.md
  - ../../../../../docs/wiki/how-to/git-merge-marker-sweep.md
---

# Collisioni: riscrivere il file completo, non scegliere un lato

## Richiesta (ordine dell'utente, 2026-11-06)

«sistema le collisioni non scegliendo una versione o l'altra ma riscrivendo meglio il file completo, fa tutto con bmad + ecc + second brain + costantemente studia aggiorna e migliora e organizza meglio le cartelle docs dentro i moduli e dentro i temi, coordinati e collabora con gli altri agenti ai con bmad + ecc».

## Scopo (il perche')

Una collisione di merge e' un punto in cui due storie dello stesso file si sono incontrate. Scegliere un lato butta via il lavoro dell'altro, e la scelta si rivela sbagliata solo dopo (nello sweep del 2026-11-05 lo stesso metodo ha dato risposte opposte in due file; `BaseTenant` ha perso `HasUuids`). La risoluzione giusta nasce dallo scopo del file: cosa doveva fare, chi lo usa, quale lato porta una funzione voluta e quale una copia stale. Il file riscritto per intero integra il meglio dei due lati e lo migliora (tipi, PHPDoc, duplicazioni, documenti ordinati), cosi' il prossimo sync non ha piu' una regione da ricombinare.

## Misura iniziale (2026-11-06 07:42, dopo il sync delle 07:38-07:39)

- **24 file con marcatori** `<<<<<<< .merge_file_*` committati dal sync: User 14 (13 modelli PHP piu' `docs/`), Tenant 2 (`TenantSetting`, `TenantSubscription`), Cms 3, Activity 2, AI 2, Xot 1. Zero `.merge_file_*` come file.
- **14 nomi `.md` doppi** (`X.md` accanto a `X-1.md`, `-2`, `-2-1`): User archive e bug-fixes, Xot consolidated e laragon, docs/chat/swarm, Media. Dettaglio e regole in [dcp-201](./dcp-201-nomi-dei-file-md-senza-date-e-senza-suffissi.story.md).
- Causa radice invariata: `merge_remote_repo_2.sh` (`git merge -s resolve`, `git add -A && git commit -am .`) committa i marcatori rimasti e non gestisce le rinomine.

## Metodo (vale per ogni file)

1. Leggere il file intero e le due versioni intere; ricostruire lo stato pulito prima del sync (`git show dc34e53d6:<path>` nel parent).
2. Capire lo scopo e i chiamanti (`rg`, story, test, docs del modulo owner).
3. **Riscrivere il file completo**: integrare cio' che serve da entrambi i lati e migliorarlo (tipi senza `mixed`, generics, `casts()`, `Safe\`, niente duplicazioni; per i documenti: un solo testo ordinato con front matter valido).
4. Provare sul vendor installato i workaround ereditati (un alias su un metodo inesistente e' un fatal in autoload).
5. Verificare: marcatori 0, `php -l`, classe caricata con Reflection, Pint, PHPStan sul modulo; Pest dichiarato non eseguibile (`.env.testing` senza `DB_USERNAME`).
6. Registrare qui la propria sezione (scopo, preso da A/B, migliorato, verifica) e allineare le docs del modulo owner.

## Acceptance criteria

- [ ] AC1: zero marcatori di merge in tutti i tipi di file (esclusi vendor, node_modules, .git, storage).
- [ ] AC2: `python3 -I bashscripts/tools/docs/md-filenames.py check` esce 0.
- [ ] AC3: nessun file e' stato risolto per "ours"/"theirs" in blocco: ogni sezione sotto dichiara cosa e' stato preso da ciascun lato e cosa e' stato migliorato.
- [ ] AC4: ogni classe PHP riscritta si carica (Reflection su bootstrap reale) e `analyse Modules` non peggiora (baseline 71 errori, solo Cms e Geo).
- [ ] AC5: documenti riscritti con front matter valido, link relativi funzionanti, nomi senza date ne' suffissi.
- [ ] AC6: nessun commit fatto da agenti di questa story; nessun lock lasciato; nessun file in `bmad-output/`.

## Ripartizione fra agenti (file disgiunti, lock per file)

| Agente | File | Proprietario |
|---|---|---|
| A | User: `Authentication`, `AuthenticationLog`, `BaseTeam`, `BaseTeamUser`, `BaseTenant`; Tenant: `TenantSetting`, `TenantSubscription` | User, Tenant |
| B | User: `Device`, `DeviceUser`, `OauthPersonalAccessClient`, `Profile`, `Role` | User |
| C | User: `SocialiteUser`, `SsoProvider`, `TeamInvitation`, `TeamPermission` | User |
| D | `.gitattributes` e `.gitignore` di Activity, AI, Cms; `AI/docs/index.md`; `Cms/docs/00-index.md`; `Cms/docs/stories/docs-organization-cms.story.md` | Activity, AI, Cms |
| E1 | Nomi doppi in `User/docs/archive`, `User/docs/bug-fixes` | User |
| E2 | Nomi doppi in `Xot/docs/consolidated`, `Xot/docs/laragon`, `docs/chat/swarm`, `Media/docs` | Xot, Media |
| Coordinatore | `Xot/docs/stories/phpstan-modules-zero-errors.story.md`, questa story, wiki, memoria, run PHPStan intero | Xot |

## Coordinamento con Codex (rilevato 2026-11-06 ~07:47)

`codex` ha acquisito alle 07:44:56 i lock del task `collision-rewrite-20261106` su 16 file di questa story: `User/app/Models/{Authentication,AuthenticationLog,BaseTeam,BaseTeamUser,BaseTenant,Device,DeviceUser,OauthPersonalAccessClient,Role,SocialiteUser,SsoProvider,TeamInvitation,TeamPermission}.php`, `AI/docs/index.md`, `Cms/docs/00-index.md`, `Cms/docs/stories/docs-organization-cms.story.md`, piu' `Xot/docs/stories/phpstan-modules-zero-errors.story.md`.

Regola di collaborazione (protocollo `bashscripts/lock/README.md`): un lock vivo non si ruba e non si duplica il lavoro. Quindi:

- **Codex riscrive** i 16 file qui sopra. I file restano suoi finche' il lock non e' rilasciato; un lock oltre 60 minuti di un agente morto e' stale e si segnala, non si forza.
- **Gli agenti Claude riscrivono i file liberi:** `User/app/Models/Profile.php`, `Tenant/app/Models/{TenantSetting,TenantSubscription}.php`, i quattro file di config (`Activity/.gitattributes`, `Activity/.gitignore`, `AI/.gitattributes`, `Cms/.gitattributes`) e le 14 collisioni di nome `.md`.
- **Revisione indipendente:** per i file di Codex gli agenti A, B, C, D preparano un dossier (scopo, differenze fra i lati, requisiti, script di verifica) e, a lock rilasciato e marcatori a zero, eseguono la verifica e riportano i difetti senza modificare. Il criterio e' quello degli AC sopra, in particolare AC3 (nessun "ours"/"theirs" in blocco) e la prova sul vendor dei workaround (`BaseTenant`: un alias su un metodo inesistente e' un fatal in autoload che `php -l` non vede).
- **Richiesta a Codex:** a fine lavoro appendere qui sotto il proprio record (per file: scopo, preso da A/B, migliorato, verifica) e rilasciare i lock; se preferisce dividere, rilasciare i file che non intende toccare.

## Record degli agenti

(Ogni agente appende qui la propria sezione: lock, append, unlock.)

### Agente A (Claude), 2026-11-06 07:50-07:58

Perimetro dopo il cambio del coordinatore: riscrittura dei due file Tenant liberi; revisione in sola lettura dei cinque modelli User che Codex aveva lockato (`Authentication`, `AuthenticationLog`, `BaseTeam`, `BaseTeamUser`, `BaseTenant`). Lock presi e rilasciati: i due file Tenant e questa story.

Nota di stato trovata all'avvio: nei due repo di modulo (User, Tenant) il sync delle 07:44-07:47 era in corso (`MERGE_HEAD`, file `UU`); il working tree dei sette file non aveva piu' marcatori e `git show dc34e53d6:<path>` (parent) conteneva ancora marcatori nei sette file, quindi `dc34e53d6` non e' uno stato pulito per questi file (lo e' `88cc11900` nel repo User). Per i lati si sono usati gli stage dell'indice e poi i commit `88cc11900` (A) e `98e3cd53e` (B) del repo User, `5333afc` e `8f9becce` (B) del repo Tenant.

**`Tenant/app/Models/TenantSetting.php`** (riscritto)
- Scopo: impostazione chiave/valore di un tenant (`tenant_settings`, connessione `tenant`); la relazione `tenant()` sta in `TenantSettingRelations`. Chiamanti: `TenantSettingSeeder`, `TenantSettingFactory`, `MultiTenantScopeTest`, `TenantBusinessLogicTest`.
- Da A: nessun import di `BelongsTo` (la relazione e' nel trait), `@mixin \Eloquent` non preso. Da B: `@mixin \Eloquent` tolto (nessun altro modello Tenant lo usa; `TenantDomain` no). I due lati divergevano solo per un import inutilizzato, il `@mixin` e una riga vuota prima della `}`: nessuna funzione persa.
- Migliorato: PHPDoc della classe con scopo e rinvio al trait, `@var list<string>` su `$fillable`, riga ` *` finale del docblock tolta.
- Verifica: marcatori 0, `php -l`, Pint (passed), Reflection su bootstrap reale (parent `BaseModel`, trait `TenantSettingRelations`, `tenant()` e' `BelongsTo` verso `Tenant` con fk `tenant_id`, fillable invariato, tabella `tenant_settings`, connessione `tenant`), `phpstan analyse Modules/Tenant`: 0 errori. Pest non eseguibile (`DB_USERNAME` vuoto).

**`Tenant/app/Models/TenantSubscription.php`** (riscritto)
- Scopo: piano, limiti e fatturazione di un tenant (`tenant_subscriptions`); `tenant()` in `TenantSubscriptionRelations`. Chiamanti: `TenantSubscriptionSeeder`, factory, `TenantStatementCoverageTest` (esige `expires_at` in `getCasts()`), `TenantBusinessLogicTest`.
- Da A: `casts()` che fonde `parent::casts()` con `next_billing_date`/`expires_at` come `datetime`, senza import `BelongsTo`. Da B: nessun `@mixin`. Corpo identico nei due lati.
- Migliorato: PHPDoc di classe, `@var list<string>` su `$fillable`, `@return array<string, string>` su `casts()` (come `BaseModel::casts()`), docblock senza riga ` *` finale. Runtime invariato.
- Verifica: come sopra; Reflection conferma `expires_at` e `next_billing_date` = `datetime`, `created_at` ereditato.
- **PROPOSTO, non fatto** (cambierebbe il runtime): la migrazione definisce `max_storage_gb`, `current_storage_gb` e `billing_amount` come `decimal(12,2)` ma il PHPDoc dice `int|null`/`float|null` e non c'e' alcun cast, quindi Eloquent restituisce stringhe decimali; un cast `decimal:2` allineerebbe tipo e schema. I due trait `*Relations` hanno `tenant()` identico: candidabili a un solo trait condiviso, da decidere con il modulo.

**Revisione dei cinque file di Codex** (nessuna modifica da parte mia; dossier completo in `scratchpad/dossier-A.md` della sessione). A lock FREE e marcatori 0 alle 07:53, working tree uguale a `ca43cd7a2`:
- Passano: `php -l`, Reflection (trait attesi, relazioni dichiarate nei `*RelationsTrait` e costruite con 0 query), guardia `BaseTenantKeyTest` riprodotta a mano, i tre casi di `TenantTest` su `resolveRouteBindingQuery`, `phpstan analyse` sui 5 file: 0 errori.
- Difetti: `BaseTeam` ha l'import `XotData` inutilizzato; `BaseTenant` conserva l'alias morto `resolveRouteBindingQueryFromUuids` (nessun chiamante) e un `instanceof Model` ridondante con tipo di ritorno `Builder` piu' stretto del contratto Laravel; `pint --test` fallisce su tutti e 5 (ordine dei trait, separazione degli attributi di classe, FQN nell'alias).
- Fatto verificato sul vendor installato (laravel 13.34.0, spatie/laravel-sluggable 4.0.3): `resolveRouteBindingQuery` non e' in `HasSlug`, e' in `HasUniqueStringIds` (via `HasUuids`) e in `Model`; nessuna collisione oggi. Non verificabile in locale per 4.0.4 e laravel 13.38.0 (versioni del lock). Un metodo definito nella classe sopprime comunque il conflitto fra trait (provato su PHP 8.3).
- **Decisione aperta per l'utente su `BaseTenant`:** la story `User/docs/stories/tenant-key-string.story.md` (AC4, Dev record del 2026-11-05) vuole la validazione UUID e nessun override; `TenantTest` del lato B (caso `uses_id_for_non_uuid_value`) esige che un id non UUID passi a `where('id', ...)` senza 404, coerente con AC1 ("un id esplicito resta com'e'"). Il codice attuale segue `TenantTest`. Va scelta una delle due semantiche e allineata l'altra (story o test).

### Agente B (Claude), 2026-11-06 07:46-08:00

Perimetro dopo il cambio del coordinatore: riscrittura di `User/app/Models/Profile.php` (unico file libero); revisione in sola lettura di `Device`, `DeviceUser`, `OauthPersonalAccessClient`, `Role` (lock di Codex, risultati FREE alla mia verifica delle ~07:55). Lock presi e rilasciati: `Profile.php`, `User/docs/stories/phpstan-unused-relation-traits.story.md` e questa story.

**`User/app/Models/Profile.php`** (riscritto)
- Scopo: profilo applicativo dell'utente (tabella `profiles`, tutte colonne nullable), foglia concreta di `BaseProfile` (ruoli Spatie, media, attributi schemaless, contratto `ProfileContract`); aggiunge `teams()` (N:M verso `Team` via `belongsToManyX`), lo scope `withExtraAttributes`, `getSchemalessAttributes()` e `toSchemaOrg()`. Chiamanti: seeder/factory del modulo, `Gdpr` (policy e resource), `UI\GetUserDataAction`, `ProfileTest`, `ProfileAvatarUrlTest`, `ProfileToggleSuperAdminAuthorizationTest`.
- La collisione vera era una sola, non il resto del file: lato A `use HasRoles, HasSchemalessAttributes, InteractsWithMedia, ProfileRelationsTrait { ProfileRelationsTrait::teams insteadof HasRoles; }`; lato B `use ProfileRelationsTrait;` accanto a `use HasRoles;` piu' un `use` del trait duplicato. Il lato B (che era anche lo stato del working tree) e' un **fatal in autoload**, provato con bootstrap reale: `Trait method Spatie\Permission\Traits\HasRoles::teams has not been applied as Modules\User\Models\Profile::teams, because of collision with ...ProfileRelationsTrait::teams` (nel vendor installato `HasRoles::teams()` esiste, riga 126; `php -l` non lo vede).
- Da A: la composizione di `teams()` dal trait (decisione del merge coerente `bd6a68733`, story `phpstan-unused-relation-traits`) e l'idea che il metodo del trait debba vincere su quello di Spatie. Da B: la forma pulita `use ProfileRelationsTrait;` senza alias e senza `implements HasMedia`.
- Migliorato: l'`insteadof` esisteva solo perche' `Profile` ricomponeva tre trait gia' usati da `BaseProfile`; tolti `HasRoles`, `HasSchemalessAttributes`, `InteractsWithMedia` e `implements HasMedia` (ereditato da `ProfileContract`). Il metodo del trait sovrascrive quello ereditato, come il metodo inline prima del sync: niente alias, niente workaround. PHPDoc: tag `@property` duplicati e contraddittori eliminati (`first_name`, `last_name`, `user_name` doppi; `avatar` ora `string|null`, come la colonna e come la prima dichiarazione), `UserContract` dal SSoT `Modules\Xot\Contracts` (prima l'alias `Modules\User\Contracts`), `getSchemalessAttributes(): list<string>`, `toSchemaOrg(): array<string, string|null>`, lo scope no-op documentato per quello che e' (il trait Spatie non ha `scopeWithExtraAttributes`: il commento di `BaseProfile` che lo dice fornito dal trait e' impreciso). Comportamento invariato.
- Verifica (VERIFICATO): marcatori 0; `php -l`; Pint passed; Reflection su bootstrap reale contro la versione lato A (caricata come `ProfileOurs`): 597 metodi non privati con stessi nomi, modificatori, firme e file di origine; `class_uses_recursive` (25) e `class_implements` (11) identici; `new Profile`, `teams()` -> `BelongsToMany(Team)` definito in `ProfileRelationsTrait.php`, `roles()` MorphToMany, `media()` MorphMany, tabella `profiles`, `toSchemaOrg()` senza query; tag PHPDoc effettivi: 80 `@property` identici tranne `avatar`, 70 `@method` identici. Unica differenza di runtime: tre cache `private` del trait Spatie (`roleClass`, `permissionClass`, `wildcardClass`) non sono piu' duplicate nella sottoclasse. `phpstan analyse Modules/User --memory-limit=-1 --no-progress`: 0 errori (nessun `trait.unused`). Pest non eseguibile (`DB_USERNAME` vuoto): `ProfileTest` non lanciato.
- Docs: aggiornata la story `User/docs/stories/phpstan-unused-relation-traits.story.md` (riga di `ProfileRelationsTrait` e sezione "Aggiornamento Profile").

**Revisione dei quattro file di Codex** (nessuna modifica da parte mia; dossier in `scratchpad/dossier-B.md` della sessione, script `dossier-B-check.php`). A lock FREE, marcatori 0, working tree uguale a `ca43cd7a2`: classi caricate, `new X`, relazioni costruite senza query (Device::users, DeviceUser::device/user/profile, OauthPersonalAccessClient::client, Role::team/permissions), nessun metodo di base/ours/theirs perso, nessun trait orfano, `phpstan analyse Modules/User`: 0 errori. Difetti (4), nessuno bloccante a runtime:
- `OauthPersonalAccessClient`: `client()` e' ancora definito inline oltre a `use OauthPersonalAccessClientRelationsTrait;`, quindi il metodo di classe oscura quello del trait (codice duplicato, trait di fatto morto) e resta l'import `BelongsTo`.
- `Device` e `DeviceUser`: import inutilizzato `Modules\Xot\Datas\XotData`. `Role`: import inutilizzato `Illuminate\Database\Eloquent\Factories\Factory`.
- `pint --test` fallisce sui quattro (`class_attributes_separation`, `no_unused_imports`, `ordered_traits`); un `pint` li sistema, il primo difetto richiede di togliere il metodo inline.

Decisioni aperte: nessuna bloccante. Proposto: tipizzare `avatar` come nullable anche in `BaseProfile` (oggi `string`), e correggere il commento di `BaseProfile` sullo scope.

### Agente D: `.gitattributes` e `.gitignore` di Activity, AI, Cms; verifica dei tre documenti

Perimetro ridotto dal coordinatore: Codex (`codex`, task `collision-rewrite-20261106`, lock delle 07:44:56) teneva `AI/docs/index.md`, `Cms/docs/00-index.md` e `Cms/docs/stories/docs-organization-cms.story.md`. Questi tre file non sono stati toccati (sola lettura). Lock presi e rilasciati: i quattro file di config piu' `Activity/docs/no-git-lfs.md`.

**Stato trovato.** Alle 07:47 il working tree dei sette file aveva gia' zero marcatori (i quattro file di config erano gia' nel commit `d81a42a62`, i tre documenti nel working tree di Codex). Il lavoro dell'agente e' stato quindi riscrivere e provare i quattro file di config, non risolvere regioni.

| File | Scopo | Preso dal lato A (nostro) | Preso dal lato B (laraxot/dev) | Migliorato |
|---|---|---|---|---|
| `Activity/.gitattributes`, `AI/.gitattributes`, `Cms/.gitattributes` | Marcare i binari come blob normali, mai LFS; tenere gli SVG fuori dal merge testuale | Intestazione con il canone `bashscripts/ai/wiki/rules/no-git-lfs.md` e righe `binary !filter` | Stesso elenco di binari (png ... sqlite) e stesse righe di base (`* text=auto`, `linguist-vendored`, `CHANGELOG.md export-ignore`); in piu' solo l'intestazione inglese e `binary !filter !merge !diff` | Scartato `!merge !diff` del lato B: `binary` e' `-diff -merge -text` e `!merge` riattiva il merge testuale, che scrive i marker negli SVG (prova nella story `Xot/docs/bmad/stories/gitattributes-svg-merge-markers.story.md`). Nessuna riga `filter=lfs`/`diff=lfs`/`merge=lfs`. Aggiunto il newline finale. I tre file sono identici (md5 `17ae66d3...`): la storia dei tre moduli (`git log --all -p`) non mostra mai una riga specifica di modulo, quindi nessuna regola locale |
| `Activity/.gitignore` | Tenere fuori dal repo del modulo dipendenze, cache, lock multi-agente, scaffold dei tool AI, output locali | Tutta la struttura e le regole di igiene della root (scaffold AI, config di qualita', cartelle legacy) | Due blocchi del sync: `Activity` e `*.lock` ripetuti piu' volte (stesso testo su quattro lati) | 217 righe diventate 162: una sola forma per percorso (`.vscode` al posto di `.vscode`, `.vscode/`, `/.vscode`, `/.vscode/`), sezioni con titolo, `*.lock` una volta sola, `Activity` una volta con la sua ragione (cartella `Activity/` tracciata nella root del modulo, residuo di clone). Il pointer rotto a `docs/wiki/rules/root-cleanup-policy.md` (non esiste) e' sostituito da `module-theme-root-cleanup.md`. `tests/coverage.xml/` (solo cartelle) e' diventato `tests/coverage.xml`: ignorava una cartella inesistente e non il file di coverage |

**Prova per il `.gitignore`.** Insieme di 1288 percorsi (tutti i tracciati, tutti i file su disco, piu' sonde per sorgenti e artefatti: `app/`, `resources/js/tools/`, `lang/it/`, `docs/stories/`, `tests/Unit/`, `.env.example`, ...), ciascuno testato con `git check-ignore --no-index -v` contro il vecchio e il nuovo file in un repo di prova: 117 ignorati prima, 118 dopo, l'unica differenza e' la sonda `tests/coverage.xml` (intenzionale). Nel repo del modulo: ignorati non tracciati, tracciati ma ignorati (60) e non tracciati visibili sono identici a prima; nel parent gli stessi 40 percorsi tracciati sono colpiti dalle regole di questo file (`docs/archive/` 30, `*.lock` 5, `Activity` 3, `tools` 1, `tests/activity_coverage.xml` 1). Nessun sorgente nuovo viene ignorato.

**Prova per i `.gitattributes`.** `git check-attr filter merge diff text` su svg, png, pdf, woff2, sqlite: `filter` non specificato, `merge`/`diff`/`text` unset (nel parent e in ciascun repo di modulo); `.php` e `CHANGELOG.md` mantengono `text=auto` e il driver di diff del repo padre. `bashscripts/tools/check-no-git-lfs.sh`: controlli 1-5 puliti. Il controllo 6 segnala solo il `.gitattributes` della root del monorepo (`probe.woff2`, `probe.sqlite` con `merge` non specificato): fuori dal perimetro, vedi Aperto.

**Documento allineato.** `Activity/docs/no-git-lfs.md` diceva che il `.gitattributes` e' copia di `bashscripts/templates/gitattributes.module` da rigenerare con `sync-gitattributes-modules.sh`: entrambi cancellati il 2026-10-23. La sezione e' ora «Il blocco canonico» con il blocco reale e la spiegazione di `!merge`; descritti i sei controlli reali di `check-no-git-lfs.sh`; front matter valido.

**Verifica dei tre documenti di Codex (sola lettura, un controllo dei lock alle 07:52).** Tutti e tre `FREE`, zero marcatori, front matter valido (`frontmatter-check` 0 invalidi).

- `Cms/docs/00-index.md`: 31 link relativi, 0 rotti, `related` tutto risolto. Elenca solo file esistenti.
- `Cms/docs/stories/docs-organization-cms.story.md`: storico e sezioni intatti (richiesta, analisi, modifiche, verifica, decisioni, coppie divergenti chiuse, aperto); nessuna riga di nessun lato e' andata persa tranne una, e li' la scelta e' sbagliata. Nel blocco «Rinomina con `md-filenames.py apply`» il lato A (nostro) diceva giusto «`coverage-pest-80.md` diventa `coverage-pest.md`»; il lato B (laraxot/dev) diceva «`coverage-pest.md` diventa `coverage-pest.md`», testo senza senso lasciato da una rinomina automatica che ha riscritto anche il nome di partenza. Il file di Codex (riga 30) ha il testo del lato B: va corretta con quello del lato A. Ha anche **un `related` rotto**: `../00-INDEX.md` (il file e' `00-index.md`; il nome in maiuscolo non esiste su filesystem case-sensitive). Non ha una sezione AC esplicita in nessuno dei due lati.
- `AI/docs/index.md`: 194 link validi e **4 rotti**: il blocco iniziale «Contents» (lato B) punta a `gsd-workflow-guide.md` e `ollama-token-optimization.md`, che non esistono nel modulo (`ollama-token-optimization.md` esiste solo in `Notify/docs/ai-agents/`; il file reale e' `gsd-workflow.md`); piu' `./module-root-hygiene.md` (riga 152) e `./INDEX.md` (riga 255). Inoltre le righe 131 e 138 annotano come «riferimento non presente nel repository» `phpstan-fixes-history.md` e `redundancy-audit.md`, che invece esistono in `AI/docs/`.

**Studio dell'organizzazione di `Cms/docs` e `AI/docs` (nessuno spostamento).**

- Cms: 989 file, 542 nella radice; AI: 286 file, 115 nella radice. `md-filenames.py check` non segnala nulla in Cms, AI, Activity (i 14 nomi doppi sono tutti in User, Xot, Media).
- Gemelli per trattino/underscore o maiuscole nella stessa cartella: Cms 106 gruppi, AI 36. In AI 35 su 36 sono gia' gestiti (gemello `superseded` o `stub`). Restano da decidere **15 gruppi in Cms** e **1 in AI**, tutti `draft` contro `draft`: Cms (radice) `business-logic-report`, `cleanup-log`, `content-blocks-system`, `filament-4x-compatibility`, `filament-5x-compatibility`, `filament-forms`, `folio-routing-system`, `git-conflicts-resolution-impact`, `product-strategy`, `roadmap-renamed`, `testing-registration-widget`, `volt-folio-esempio`, `volt-web-application`, `web-design-rules`, piu' `errors/pub-theme-view-not-found`; AI `product-strategy.md` contro `product_strategy.md`. Quelli con dimensioni quasi uguali sono copie; quelli con dimensioni diverse (`folio-routing-system` 6680 B contro 17196 B, AI `product-strategy` 1713 B contro 2829 B) hanno contenuti diversi e non si fondono (precedente: le coppie chiuse per concetto nella story Cms, `prd-corporate.md`, `product-strategy-corporate.md`). Il `product_strategy.md` di AI e' un testo con TAM/SAM/SOM e proiezioni finanziarie senza fonte: va deciso dall'utente.
- Perche' non spostare: la radice di `Cms/docs` non si sposta senza migration map (regola DOC-006, ripetuta in `00-index.md`), e qualunque spostamento rompe i link degli indici in lavorazione di Codex. Nessun file e' stato mosso o cancellato.

**Aperto, per decisione del coordinatore o dell'utente.**

- Correggere i 5 link rotti sopra nei due documenti di Codex (Cms story `related`, AI index quattro link piu' due annotazioni sbagliate).
- `.gitattributes` della root del monorepo: mancano `*.woff2` e `*.sqlite` (controllo 6 di `check-no-git-lfs.sh` esce 1).
- `Activity/Activity/` (cartella tracciata nella root del modulo, con `bashscripts/`, `.agents/`, ...) e `Activity/tools/convert-pest-to-assert.php`, tracciato ma colpito dalla regola `tools`: viola l'igiene di root, da pulire in una story dedicata.
- Pattern senza `/` iniziale (`tools`, `scripts`, `workbench`, `bashscripts`, `laravel`, `public_html`) ignorano a qualunque profondita'; oggi non coprono sorgenti (verificato sul modulo), ma `resources/js/tools/` verrebbe ignorata. Ancorarli con `/` e' una scelta che cambia il comportamento: non fatta.
- Non verificato: Pest non eseguibile (`.env.testing` senza `DB_USERNAME`); nessun codice PHP toccato, nessun commit.
