---
title: "PRD: Perfezione assoluta del modulo User"
type: prd
module: User
status: draft
track: perfection-campaign
version: "1.0"
related:
  - ./perfection-brainstorming.md
  - ./perfection-architecture.md
  - ./perfection-epics.md
  - ./perfection-decision-log.md
  - ./prd.md
  - ./epics.md
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "prd: perfezione assoluta del modulo user user"
---

# PRD: Perfezione assoluta del modulo User

**Track:** Perfection campaign (Epic 11-16, continua la numerazione dopo Epic 9/10).
**Source of truth per il *cosa* e il *perche'*.** Il *come* e' in
[perfection-architecture.md](./perfection-architecture.md), i findings grezzi in
[perfection-brainstorming.md](./perfection-brainstorming.md).

## Executive summary

**Problema:** il modulo User (identity, 112 model, 357 file Filament, 59 migration
attive, 310 test) ha superato una campagna di audit a 360 gradi (7 dimensioni
indipendenti, tool reali verificati) che ha trovato **2 vulnerabilita' critiche di
sicurezza attive** (bypass totale di autorizzazione, nessun rate limiting login),
debito architetturale (duplicazione Actions, codice morto), gap di test sulla parte
piu' sensibile (Policy), N+1 attivo, e uno sprawl di documentazione che ha reso
`docs/` (3832 file) largamente inconsultabile (626 file, ~16%, con nomi patologici
da un bug di tooling ricorsivo).

**Soluzione:** questo PRD definisce lo stato-obiettivo verificabile ("perfezione")
per ciascuna delle 6 dimensioni di debito identificate, con criteri misurabili (non
"codice piu' pulito" ma soglie numeriche/booleane verificabili da comando).

**Valore:** un modulo identity senza vulnerabilita' note, con debito tecnico
tracciato e sequenziato, non piu' "grande e mai auditato per intero".

**Esito atteso (fuori da questa sessione, che e' solo audit+documentazione):**
esecuzione delle epic 11-16 in sessioni successive, story per story, con verifica
reale ad ogni chiusura (mai "fatto" senza prova, standing order).

## Vincolo di scope di questa sessione

Questo PRD e i documenti collegati sono **prodotti da una sessione di sola
documentazione**: nessun codice, config, migration o dato e' stato toccato. Ogni
requisito sotto e' backlog per esecuzione futura, non lavoro gia' fatto.

## Requisiti: stato obiettivo per dimensione

### RQ-SEC: Sicurezza (Epic 11, priorita' massima)

- **RQ-SEC-001**: `UserPolicy::view/create/update/delete` applicano un controllo di
  autorizzazione reale (ruolo o self-check), non un `return true` incondizionato.
  *Verifica:* test comportamentale che asserisce `Gate::denies('update', $altroUser)`
  per un utente non-admin: oggi assente (vedi RQ-TEST-001), va scritto insieme al
  fix.
- **RQ-SEC-002**: il login Filament ha rate limiting attivo (per IP e/o per
  identificativo). *Verifica:* tentativi ripetuti oltre soglia restituiscono
  `429`/blocco temporaneo, testabile.
- **RQ-SEC-003**: `DeleteUserAction` (o l'observer collegato) revoca i token OAuth
  attivi e rimuove/anonimizza `SocialiteUser`, `AuthenticationLog`, pivot di ruolo
  per l'utente cancellato. *Verifica:* test che cancella un utente con token/social
  collegati e asserisce zero righe orfane residue.
- **RQ-SEC-004**: `socialite_user.token` e' cifrato a riposo (`cast: encrypted`).
  *Verifica:* lettura diretta della colonna via query raw non espone il token in
  chiaro.
- **RQ-SEC-005**: i DTO/Actions di creazione utente non espongono campi privilegiati
  (`is_active`, `email_verified_at`, `state`, `id`) a input non fidato: o vengono
  rimossi se dead code confermato.

### RQ-ARCH: Architettura (Epic 15)

- **RQ-ARCH-001**: una sola classe `CreateUserAction` nel modulo, basata sul
  pattern gia' corretto (`UserContract` + `XotData::make()->getUserClass()`).
  *Verifica:* `grep -rln "class CreateUserAction" app/Actions` → 1 risultato.
- **RQ-ARCH-002**: `app/Adapters/**` non esiste piu' (dead code rimosso, non solo
  documentato). *Verifica:* directory assente.
- **RQ-ARCH-003**: zero type-hint pubblici su `User`/`Profile` concreti dove il
  contratto (`UserContract`/`ProfileContract`) e' sufficiente: eccetto Observer
  legati a eventi Eloquent nativi. *Verifica:* grep mirato con lista di eccezioni
  esplicite e motivate.
- **RQ-ARCH-004**: nessun fallback hardcoded verso un modulo di progetto specifico
  (`Modules\Egea\...` o equivalente) in codice condiviso multi-progetto. *Verifica:*
  `DeviceData::getSynchronizationId()` fallisce esplicitamente o risolve via SSoT.
- **RQ-ARCH-005**: zero file `.bak`/`.old`/`.no`/`.corrected`/`.wip`/`.to_xot`/
  `.backup-*` residui sotto `app/` e `database/migrations/` (incluso `_bak/`).
  *Verifica:* `find app database/migrations -regextype posix-extended -iregex
  '.*\.(bak|old|no|corrected|wip|to_xot)$|.*\.backup-.*'` → 0 risultati.

### RQ-QUAL: Qualita' codice (Epic 15/16)

- **RQ-QUAL-001**: PHPMD e PHPInsights sono eseguibili nell'ambiente (phar
  funzionante o toolchain composer riparata) e producono un report reale, non un
  fatal error. *Nota:* riguarda l'intero repo, non solo User: la story va aperta
  a livello infrastruttura/tooling, referenziata da qui.
  Correlato: [[quality-tooling-entrypoints]].
- **RQ-QUAL-002**: ogni `@phpstan-ignore` inline nel modulo ha un commento che
  spiega perche' non e' risolvibile diversamente (oggi 11 soppressioni, 7 in
  `HasTeams.php`, senza motivazione). *Verifica:* grep + lettura riga precedente
  per ciascuna occorrenza.
- **RQ-QUAL-003**: `Pint --test` passa senza fixer pendenti sul modulo (oggi FAIL,
  5 file). *Verifica:* comando reale, exit code 0.
- **RQ-QUAL-004**: le Resource `Passport`/`Socialite` ancora sul pattern
  monolitico (`OauthAccessTokenResource`, `OauthPersonalAccessClientResource`,
  `SsoProviderResource`) migrano al pattern `Tables/*Table.php` dedicato, coerente
  con le altre 39 Resource del modulo.
- **RQ-QUAL-005**: le `->label()` esplicite (oggi 41 in 17 file) sono rimosse dove
  la label e' derivabile da `LangServiceProvider`/`AutoLabelAction`, o la
  regola/memoria di progetto viene corretta se il pattern esplicito e' in realta'
  voluto in quei casi specifici (da verificare caso per caso, non bulk-remove
  cieco).
- **RQ-QUAL-006**: zero `dddx()`/debug code residuo in produzione (oggi
  `TermsOfService.php:32`).
- **RQ-QUAL-007**: `livewire-inventory.md` non contiene claim di bug non
  riproducibili nel codice attuale: correzione dei 2 claim falsi identificati,
  prerequisito per sbloccare la story `10.4` esistente.

### RQ-TEST: Test coverage (Epic 17)

- **RQ-TEST-001**: `UserPolicy` ha test comportamentale reale (non solo
  instanziazione) che copre tutti e 4 i metodi con asserzioni su casi
  autorizzato/non-autorizzato.
- **RQ-TEST-002**: il namespace `Actions/Shield/*` (7 resolver) e le 2 varianti di
  `GetPermissionModelAction` hanno almeno un test unitario ciascuno.
- **RQ-TEST-003**: i 4 test skippati in `LoginWidgetTest.php` (righe 60/81/94/115)
  sono riattivati, non piu' skip.
- **RQ-TEST-004**: esiste almeno un guard test automatizzato per: no-
  `RefreshDatabase`, XotBase-only extension, array one-key-per-line (nello scope
  Filament/Actions del modulo). *Rationale:* [[regola-senza-test-regredisce]]: una
  regola vera "per fortuna" oggi puo' regredire silenziosamente domani.
- **RQ-TEST-005**: `tests/Helpers.php` e `tests/Support/helpers.php` sono
  consolidati in un'unica fonte (la sovrapposizione quasi totale va risolta, non
  documentata e lasciata).
- **RQ-TEST-006**: `app/Models/Models/BaseUser.php` (file orfano, namespace errato)
  e' rimosso.
- **RQ-TEST-007**: `tests/Unit/graphify-out/` non esiste piu' dentro l'albero test
  (cache spostata/ignorata correttamente).

### RQ-PERF: Performance (Epic 16)

- **RQ-PERF-001**: `OauthClientResource` (cluster Passport) carica `owner` con
  eager loading, allineato al gemello non-cluster.
- **RQ-PERF-002**: `PassportStatsWidget` non esegue 5 query COUNT non cachate ogni
  5 secondi di default: polling interval aumentato e/o risultati cachati con TTL
  esplicito.
- **RQ-PERF-003**: i widget grafico (`UsersChartWidget`, `
  UserTypeRegistrationsChartWidget`) cachano il risultato della query `Trend` con
  TTL esplicito.
- **RQ-PERF-004**: `ResetPassword` e `VerifyEmail` implementano `ShouldQueue`,
  coerenti con `Otp`.
- **RQ-PERF-005**: la revoca token in bulk usa una singola query `whereIn(...)
  ->update(...)` invece di un loop per-utente.
- **RQ-PERF-006**: i 4 `getEloquentQuery()->with(...)` che caricano relazioni mai
  usate dalla Table sono corretti (rimossi, o la colonna aggiunta se il dato serve
  davvero all'utente finale: miglioramento UX collaterale accettabile).
- **RQ-PERF-007**: le 144 righe di hook tabella duplicati e mai invocati in
  `OauthAccessTokenResource.php:166-309` sono rimosse.

### RQ-SCHEMA: Schema/migrazioni (Epic 18)

- **RQ-SCHEMA-001**: `profiles.id` ha lo stesso pattern di generazione (UUID vs
  autoincrement) in `Modules\Ptv` e `Modules\User`: nessun drift cross-modulo.
- **RQ-SCHEMA-002**: le tabelle collegate a un utente (`oauth_access_tokens`,
  `oauth_auth_codes`, `socialite_user`, e le altre identificate dall'agente schema)
  hanno FK con `cascadeOnDelete()` dove il flusso GDPR (RQ-SEC-003) lo richiede -
  additivo, mai una migration distruttiva su dati esistenti.
- **RQ-SCHEMA-003**: `BaseTenant.php` genera UUID in modo coerente col resto del
  modulo (gap da verificare puntualmente).
- **RQ-SCHEMA-004**: `database/migrations/` non contiene piu' file relitto
  (`.boh`/`.wip`/`.old`/`_bak/`).
- **RQ-SCHEMA-005**: le colonne di stato oggi stringa libera hanno un cast enum
  PHP nativo, dove il dominio di valori e' chiuso e verificabile.
- **RQ-SCHEMA-006**: `model_has_permission` (singolare, 0 righe, duplicato di
  `model_has_permissions`) e' rimossa con migration additiva di deprecazione (mai
  un DROP su dati sacri senza verifica esplicita che sia davvero orfana ovunque).

### RQ-DOCS: Documentazione (Epic 19)

- **RQ-DOCS-001**: zero cartelle self-nested (`X/X/...`) sotto `Modules/User/docs`.
  *Verifica:* script che cammina l'albero e segnala ogni path con un segmento
  ripetuto consecutivo: oggi 612 file coinvolti.
- **RQ-DOCS-002**: zero file con nome base >100 caratteri o con spazi.
  *Verifica:* `find docs -iname "*.md" | awk -F/ '{print length($NF), $0}' | sort
  -rn | head` → prima riga <100.
- **RQ-DOCS-003**: `docs/index.md` e' rigenerato/aggiornato e riflette le cartelle
  reali (oggi ne menziona 6 su 60+).
- **RQ-DOCS-004**: `docs/.gitignore` righe `archive/**`/`legacy/**` sono ancorate
  (`/archive/**`): riattiva la story esistente `5.37-gitignore-archive-legacy-bug-
  user` (backlog, root `sprint-status.yaml`), non ne serve una nuova.
- **RQ-DOCS-005**: i cluster di cartelle sovrapposte (`bugfix`/`bugs`/`bug-fixes`/
  `bug-tracking`/`fixes`/`fixed`) hanno una cartella canonica designata, le altre
  marcate `superseded` con link: **mai cancellate**.
- **RQ-DOCS-006**: causa radice del bug di self-nesting identificata e comando
  suggerito per non farlo ripetere (probabile fix nello strumento di generazione
  doc, fuori scope di questo modulo se lo strumento e' condiviso: solo
  documentare qui, aprire l'issue sullo strumento altrove).

## Criteri di "perfezione assoluta": definizione operativa

Il modulo si considera "alla perfezione assoluta" quando, in un solo comando
riproducibile per categoria:

1. `phpstan analyse Modules/User` → 0 errori **e** 0 `@phpstan-ignore` non motivati.
2. `pint --test Modules/User` → exit 0.
3. PHPMD/PHPInsights eseguibili e sotto soglia (soglia da definire quando il
   tooling e' riparato, RQ-QUAL-001).
4. Pest: tutti i test verdi, zero skip stale, coverage su Policy/Actions/Shield
   colmata (RQ-TEST-001/002/003).
5. Nessun finding ALTO/CRITICO aperto dalle sezioni 1-6 di
   [perfection-brainstorming.md](./perfection-brainstorming.md).
6. `docs/` senza self-nesting, senza nomi patologici, `index.md` aggiornato.

## Out of scope (questa campagna)

- Le campagne Epic 9 (SuperAdmin widget) ed Epic 10 (ritiro Livewire) restano
  autonome: questa campagna le referenzia ma non le assorbe.
- Nessun refactor speculativo non ancorato a un finding reale dell'audit.
- Nessuna modifica al modulo `Tenant` (morph map): confermato conforme, out of
  scope per definizione.
