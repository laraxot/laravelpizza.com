---
tags: [documentation]
qmd: "xotbaseresourcetable model audit gdpr batch.story"
issues: []
discussions: []
title: "XotBaseResourceTable $model audit — Gdpr batch"
type: story
module: Gdpr
epic: null
story_id: null
slug: xotbaseresourcetable-model-audit-gdpr-batch
status: done
created: '2026-09-11'
updated: '2026-09-11'
repository: "https://github.com/laraxot/module_gdpr_fila5.git"
github_issue: null
github_discussion: null
estimated_effort: "1 batch (6 file)"
blocked_by: []
blocks: []
supersedes: []
owned_scope:
  - "app/Filament/Clusters/Profile/Resources/ConsentResource/Tables/ConsentsTable.php"
  - "app/Filament/Clusters/Profile/Resources/ProfileResource/Tables/ProfilesTable.php"
  - "app/Filament/Resources/ConsentResource/Tables/ConsentsTable.php"
  - "app/Filament/Resources/EventResource/Tables/EventsTable.php"
  - "app/Filament/Resources/ProfileResource/Tables/ProfilesTable.php"
  - "app/Filament/Resources/TreatmentResource/Tables/TreatmentsTable.php"
related:
  - "../../../Xot/docs/stories/xotbaseresourcetable-model-property-and-column-audit.story.md"
---

# Story: XotBaseResourceTable $model audit — Gdpr batch

**Owner cross-modulo**: [`Modules/Xot/docs/stories/xotbaseresourcetable-model-property-and-column-audit.story.md`](../../../Xot/docs/stories/xotbaseresourcetable-model-property-and-column-audit.story.md)
— story "ombrello" che governa l'audit sulle 99 classi `*Table extends XotBaseResourceTable` in 15
moduli (fase 1 = `$model` esplicito, fase 2 = audit colonne, fase 3 = redesign UX per modulo, backlog).
Questa story documenta l'esecuzione del batch **Gdpr** (fase 1 + fase 2 + una porzione di fase 3, a basso
rischio) senza duplicare l'owner: nessuna modifica al file owned dall'umbrella
(`Modules/Xot/app/Filament/Resources/Tables/XotBaseResourceTable.php`).

**Fase BMAD**: Qualita del codice (contratto esplicito `$model` su `XotBaseResourceTable`) + verifica
schema + micro-miglioria UX tabelle. Nessuna modifica di logica applicativa, nessuna migrazione DB
eseguita.

**Contesto**: audit trasversale al monorepo per aggiungere `protected static string $model = X::class;` a
ogni classe `*Table extends XotBaseResourceTable` (oggi il contratto e' implicito), verificare le chiavi
di `getTableColumns()` contro lo schema DB reale, e applicare migliorie UX additive a basso rischio.
Batch assegnato: modulo `Gdpr`, 6 file.

**Race multi-agente osservata**: all'avvio di questo batch i 6 file risultavano gia' modificati
(working tree) con `$model` aggiunto ma non committati, senza `.lock` attivo. Durante l'esecuzione un
altro agente (stesso autore Git, sessione parallela) ha committato quelle stesse modifiche
(`179fe4f feat(tables): aggiunge $model esplicito...`, riferisce la story owner sopra) includendo anche
`phone`/`type` `->sortable()` su `Clusters/Profile/.../ProfilesTable.php` — identiche, per costruzione,
alle migliorie decise indipendentemente in questo batch per la copia gemella in `Resources/`. Nessun
conflitto: il commit altrui e' stato riletto con `git show` prima di proseguire, invece di sovrascriverlo
alla cieca ([[multi-agent-same-repo-race]]).

## File in scope

- `app/Filament/Clusters/Profile/Resources/ConsentResource/Tables/ConsentsTable.php`
- `app/Filament/Clusters/Profile/Resources/ProfileResource/Tables/ProfilesTable.php`
- `app/Filament/Resources/ConsentResource/Tables/ConsentsTable.php`
- `app/Filament/Resources/EventResource/Tables/EventsTable.php`
- `app/Filament/Resources/ProfileResource/Tables/ProfilesTable.php`
- `app/Filament/Resources/TreatmentResource/Tables/TreatmentsTable.php`

## Task 1 — `protected static string $model`

Gia' presente su tutti e 6 i file al momento in cui questa sessione ha iniziato il batch (nessun file
`.lock` trovato, working tree con le 6 modifiche non committate — probabilmente un passaggio precedente
dello stesso audit). Verificato per ciascuno contro la Resource sorella autorevole (stessa cartella, senza
`/Tables/`), che dichiara `protected static ?string $model = X::class;` esplicito:

| Table file | Model dichiarato | Resource sorella (autorevole) | Match |
|---|---|---|---|
| Clusters/Profile/.../ConsentResource/Tables/ConsentsTable.php | `Modules\Gdpr\Models\Consent` | `app/Filament/Clusters/Profile/Resources/ConsentResource.php:16` | si |
| Clusters/Profile/.../ProfileResource/Tables/ProfilesTable.php | `Modules\Gdpr\Models\Profile` | `app/Filament/Clusters/Profile/Resources/ProfileResource.php:16` | si |
| Resources/ConsentResource/Tables/ConsentsTable.php | `Modules\Gdpr\Models\Consent` | `app/Filament/Resources/ConsentResource.php:18` | si |
| Resources/EventResource/Tables/EventsTable.php | `Modules\Gdpr\Models\Event` | `app/Filament/Resources/EventResource.php:18` | si |
| Resources/ProfileResource/Tables/ProfilesTable.php | `Modules\Gdpr\Models\Profile` | `app/Filament/Resources/ProfileResource.php:17` | si |
| Resources/TreatmentResource/Tables/TreatmentsTable.php | `Modules\Gdpr\Models\Treatment` | `app/Filament/Resources/TreatmentResource.php:18` | si |

Nessuna divergenza trovata: nessun caso di nome-file-non-affidabile (niente Activitys/Activities-style
ambiguita' in questo modulo).

## Task 2 — verifica `getTableColumns()` contro schema reale

Verifica con `php artisan tinker` (sola lettura: `Schema::connection($conn)->getColumnListing($table)` +
`SHOW TABLES`), connessione usata dai model Gdpr: `gdpr` → database fisico `quaeris_data`.

### Consent (entrambe le copie, contenuto identico) — tabella `consents`, connessione `gdpr`

Colonne reali: `id, treatment_id, subject_id, user_type, user_id, type, accepted_at, ip_address,
user_agent, created_at, updated_at, updated_by, created_by, deleted_at, deleted_by, metadata, revoked_at,
revoked_ip_address`.

- `treatment.name` — relazione (punto nel nome), saltata come da istruzioni.
- `subject_id`, `accepted_at`, `revoked_at`, `id`, `created_at`, `updated_at` — tutte presenti. **OK,
  nessuna colonna sospetta.**

### Profile (entrambe le copie, contenuto identico) — tabella `profiles`, connessione `gdpr`

Colonne reali nel DB `quaeris_data` interrogato: `id, post_type, bio, created_at, updated_at, created_by,
updated_by, deleted_by, first_name, surname, email, phone, address, user_id, last_name, tax_code,
vat_number, deleted_at, uuid`.

- `first_name`, `last_name`, `email`, `phone`, `id`, `created_at`, `updated_at` — presenti. OK.
- `is_active` e `type` — **non presenti nell'elenco colonne di questo DB locale**, MA verificate come
  colonne legittime dello schema canonico: definite in modo consistente in 6 migration del modulo `User`
  (`Modules/User/database/migrations/{2022_01_01_000000,2026_01_01_000000,2026_03_12_172000,
  2026_04_20_173500,2026_04_28_120000,2026_09_01_150108}_create_profiles_table.php`, tutte con
  `$table->string('type')->index()->nullable();` e `$table->boolean('is_active')->default(true);`), e
  presenti nel cast di `Modules\User\Models\BaseProfile::casts()` (`'is_active' => 'boolean'`) da cui
  `Modules\Gdpr\Models\Profile` eredita. Conclusione: **non e' un campo rinominato/rimosso**, e' il
  database locale `quaeris_data` (connessione `gdpr`) che non ha ancora applicato le migration piu'
  recenti del modulo `User` per la tabella `profiles`. Non rimosso (nessuna certezza al 100% richiesta
  dalle istruzioni, anzi evidenza opposta: la colonna e' attesa). Nessuna azione sul codice; segnalazione
  per chi gestisce l'ambiente/i seed di `quaeris_data`. **Non e' stato eseguito alcun comando di
  migrazione**, come da vincolo del task.

### Treatment — tabella `treatments`, connessione `gdpr`

Colonne reali: `id, active, required, name, description, documentVersion, documentUrl, weight, created_at,
updated_at, updated_by, created_by, deleted_at, deleted_by`.

- `name`, `active`, `required`, `documentVersion`, `documentUrl`, `weight`, `created_at`, `updated_at` —
  tutte presenti. **OK, nessuna colonna sospetta.**

### Event — tabella attesa `gdpr_events`, connessione `gdpr`

`Schema::connection('gdpr')->hasTable('gdpr_events')` → `no`. La tabella non esiste nel DB locale
`quaeris_data`, nonostante la migration `database/migrations/2024_01_01_000001_create_gdpr_events_table.php`
sia presente nel modulo (probabile ambiente locale non completamente migrato — non e' stato lanciato
alcun comando di migrazione per verificarlo/risolverlo, come da vincolo). Verifica fatta contro le colonne
**definite nella migration** invece che via `Schema::getColumnListing` (impossibile a tabella assente):
`id, treatment_id, consent_id, subject_id, ip, action, payload` + timestamps/soft-delete standard
(`created_at, updated_at, created_by, updated_by, deleted_at, deleted_by`).

- `action`, `subject_id`, `created_at`, `consent_id`, `treatment_id`, `id`, `updated_at` — tutte presenti
  nella definizione di migration. **OK, nessuna colonna sospetta** (limite: verifica contro la
  definizione di migration, non contro uno schema DB realmente applicato, perche' la tabella non esiste
  in questo ambiente).

## Task 3 — migliorie UX additive applicate

Criterio: solo dove il tipo di colonna lo giustifica chiaramente e il rischio e' minimo; nessuna colonna
rimossa; nessuna nuova classe Column condivisa creata (rischio di collisione con altri batch paralleli su
`Modules/UI/app/Filament/Tables/Columns/PersonColumn.php` — riutilizzabile in un giro successivo se si
decide di aggregare `first_name`/`last_name`/`email` di `ProfilesTable` in un'unica colonna "Person",
non fatto qui per restare a basso rischio).

- `app/Filament/Clusters/Profile/Resources/ProfileResource/Tables/ProfilesTable.php` e
  `app/Filament/Resources/ProfileResource/Tables/ProfilesTable.php` (stesso contenuto):
  - `phone`: aggiunto `->sortable()` (mancava, testo semplice ovviamente ordinabile, pattern gia' usato
    per `first_name`/`last_name`/`email` nello stesso file).
  - `type`: aggiunto `->sortable()` (stesso motivo; nessun cast enum reale trovato su `Profile`/
    `BaseProfile` per giustificare `->badge()`, quindi non aggiunto per non supporre semantica non
    verificata).
- `app/Filament/Resources/TreatmentResource/Tables/TreatmentsTable.php`:
  - `documentVersion`: aggiunto `->sortable()` (testo semplice, mancava, pattern gia' usato su `name`).
  - `documentUrl`: aggiunto `->url(fn (Treatment $record): ?string => $record->documentUrl)
    ->openUrlInNewTab()` — colonna semanticamente un URL (schema.org `url`), ora cliccabile invece di solo
    testo copiabile; additivo, non tocca il dato, Filament non renderizza il link se il valore e' vuoto.

Nessuna modifica a `ConsentsTable.php` (entrambe le copie) ed `EventsTable.php`: gia' saturi di
`searchable()`/`sortable()`/`dateTime()`/`badge()` dove pertinente, nessun gap individuato senza
supporre semantica non verificata.

## Verifica

- `php -l` su tutti e 3 i file effettivamente modificati (i restanti 3 non sono stati toccati in questo
  turno oltre al gia' presente `$model`): OK, nessun errore di sintassi.
- `vendor/bin/phpstan analyse` sui 6 file del batch (dalla dir `laravel`): **`[OK] No errors`**.

## Dev Agent Record

### Completion Notes List

- 2026-09-11: audit Task 1 (verificato, gia' presente), Task 2 (verificato via tinker/migration, nessuna
  colonna rimossa, 2 osservazioni documentate su ambiente `quaeris_data` disallineato), Task 3 (4 edit
  additive in 2 file), PHPStan pulito, commit+push sul repo separato del modulo `Gdpr` (remote `laraxot`).

### File List

- `app/Filament/Clusters/Profile/Resources/ConsentResource/Tables/ConsentsTable.php` (solo `$model`, gia'
  presente, non toccato in questo turno)
- `app/Filament/Clusters/Profile/Resources/ProfileResource/Tables/ProfilesTable.php` (`$model` gia'
  presente + `phone`/`type` sortable)
- `app/Filament/Resources/ConsentResource/Tables/ConsentsTable.php` (solo `$model`, gia' presente, non
  toccato in questo turno)
- `app/Filament/Resources/EventResource/Tables/EventsTable.php` (solo `$model`, gia' presente, non
  toccato in questo turno)
- `app/Filament/Resources/ProfileResource/Tables/ProfilesTable.php` (`$model` gia' presente +
  `phone`/`type` sortable)
- `app/Filament/Resources/TreatmentResource/Tables/TreatmentsTable.php` (`$model` gia' presente +
  `documentVersion` sortable + `documentUrl` cliccabile)

## Perche' niente `github_issue`/`epic`/`story_id`

Batch di audit meccanico trasversale a piu' moduli, assegnato direttamente (non tramite epic/PRD di
prodotto in `docs/planning-artifacts/epics.md`, che copre solo Epic 1-3 Quaeris). La story owner in
`Modules/Xot` (vedi sopra) ha anch'essa `github_issue: null`/`github_discussion: null` — stessa
motivazione, non duplicata qui. Coerente anche con le altre story narrative gia' presenti in questo
modulo senza frontmatter/riferimenti GitHub (`gdpr-mixed-type-reduction.story.md`,
`docs-index-audit.story.md`).
