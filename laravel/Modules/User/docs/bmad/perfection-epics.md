---
title: "Epics: Perfezione assoluta del modulo User"
type: epics
module: User
status: draft
track: perfection-campaign
related:
  - ./perfection-prd.md
  - ./perfection-architecture.md
  - ./perfection-brainstorming.md
  - ./perfection-decision-log.md
  - ./epics.md
  - ./module-excellence-prd.md
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "epics: perfezione assoluta del modulo user user"
---

# Epics: Perfezione assoluta del modulo User

**Track:** Perfection campaign: continua la numerazione dopo Epic 9
(SuperAdmin widget), Epic 10 (ritiro Livewire) ed Epic 12-14
(`module-excellence`, campagna gemella scoperta in corso d'opera: vedi
[perfection-decision-log.md](./perfection-decision-log.md), entry
2026-09-22 "Riconciliazione numerazione con campagna module-excellence").
**Numerazione:** Epic 11 (questa campagna) + Epic 15-19 (questa campagna).
Epic 12-14 sono di **module-excellence** ([epics.md](./epics.md)), non di
questa campagna: referenziate qui solo per cross-link.
**Sources:** [perfection-brainstorming.md](./perfection-brainstorming.md),
[perfection-prd.md](./perfection-prd.md),
[perfection-architecture.md](./perfection-architecture.md)

Tutte le story sotto sono `backlog` (non ancora implementate: audit prodotto in
sessione di sola documentazione). Story files individuali con AC completi esistono
solo per Epic 11 (priorita' massima, sicurezza): le altre epic hanno la
descrizione/scope qui; un story file dedicato va creato al momento del claim,
seguendo il template gia' in uso nel modulo.

---

## Epic 11: Chiudere le vulnerabilita' di sicurezza attive

**Goal:** l'identity module non ha piu' bypass di autorizzazione ne' assenza di
rate limiting sul login; la cancellazione account e' strutturalmente completa.

**Severita' del problema:** CRITICA: 2 finding critici attivi (account takeover,
brute-force senza limite), 2 alti (PII orfane post-delete, token in chiaro).

**In scope (cited):** RQ-SEC-001..005 [Source: perfection-prd.md#rq-sec],
ADR-P001, ADR-P004 [Source: perfection-architecture.md]

**Out of scope:** redesign del sistema di ruoli/permessi (Spatie Permission resta
com'e'), nuovo modulo Gdpr dedicato (fuori scope, si lavora dentro User).

**Cross-reference module-excellence:** Epic 14 (`module-excellence`) copre la
matrice permessi come gap *documentale* (~30 Policy scoperte, nessun seeder
aggiornato); questa Epic 11 copre bug *comportamentali* attivi (bypass reale
in produzione). Angoli distinti sullo stesso sottosistema: non duplicati,
14.1 e 11.1 vanno eseguiti in sequenza (11.1 prima: non si documenta la
matrice sopra una policy che sta per cambiare).

**Stories (ordered):**

| ID | Slug | Intent | Severita' | Status |
|----|------|--------|---|--------|
| 11.1 | fix-userpolicy-authorization-bypass | Correggere ereditarieta' UserPolicy → BaseUserPolicy (ADR-P001), rinominare le due classi per rompere la naming collision | CRITICA | backlog |
| 11.2 | login-rate-limiting | Rate limiting reale su LoginWidget/BaseAuthWidget (HasRateLimitedForms o RateLimiter) | CRITICA | backlog |
| 11.3 | gdpr-cascade-delete-user | DeleteUserAction invoca RevokeAllUserTokensAction + pulizia SocialiteUser/AuthenticationLog/pivot ruolo (ADR-P004 step 1) | ALTA | backlog |
| 11.4 | encrypt-socialite-token | Cast `encrypted` su SocialiteUser::token + migration di re-cifratura dei valori esistenti | ALTA | backlog |
| 11.5 | guard-privileged-fields-createuserdata | Verificare/rimuovere campi privilegiati settabili in CreateUserData se confermato dead code | MEDIA | backlog |

**Cross-epic:** 11.3 completa strutturalmente solo con 18.2 (FK cascade
schema-level, ADR-P004 step 2). 11.1 e' prerequisito di 17.1 (test comportamentale
sulla policy corretta, non su quella bypassata) e di 14.1 module-excellence
(matrice permessi documentata sopra la policy gia' corretta).

---

## Epic 15: Consolidamento architetturale e qualita' codice

**Goal:** zero duplicazione di Actions con lo stesso nome/responsabilita', zero
codice morto silenzioso, tooling di qualita' (PHPStan/Pint) pulito senza
soppressioni non motivate.

**In scope (cited):** RQ-ARCH-001..005, RQ-QUAL-001..007
[Source: perfection-prd.md#rq-arch] [Source: perfection-prd.md#rq-qual],
ADR-P002, ADR-P003 [Source: perfection-architecture.md]

**Out of scope:** riscrittura di logica business gia' corretta (Socialite
CreateUserAction resta il modello da copiare, non da riscrivere).

**Cross-reference module-excellence:** sovrapposizione tematica con Epic 13
(`module-excellence`, "Code quality, architettura Filament, test coverage")
ma finding puntuali distinti: nessuna storia qui ripete un ID o uno slug di
13.1-13.9. Eccezione da verificare in esecuzione: 15.10
(`remove-debug-code-termsofservice`, dddx() in TermsOfService.php:32) vs
12.3 module-excellence (`remove-dddx-debug`): controllare se e' lo stesso
`dddx()` prima di lavorarci entrambe, per non duplicare il fix.

**Stories (ordered):**

| ID | Slug | Intent | Severita' | Status |
|----|------|--------|---|--------|
| 15.1 | consolidate-createuseraction | 3 → 1 classe CreateUserAction (ADR-P002) | ALTA | backlog |
| 15.2 | remove-adapters-dead-code | Cancellare app/Adapters/** e i test duplicati (ADR-P003) | ALTA | backlog |
| 15.3 | remove-egea-hardcoded-fallback | DeviceData::getSynchronizationId() fallisce esplicito o risolve via SSoT | ALTA | backlog |
| 15.4 | contract-based-typehints-cleanup | UserContract al posto di User concreto sui 3 punti applicativi (Observer escluso) | MEDIA | backlog |
| 15.5 | cleanup-dead-disabled-files | Rimuovere/archiviare .bak/.old/.no/.corrected/.wip/.to_xot/.backup-* sotto app/ e migrations/ | MEDIA | backlog |
| 15.6 | fix-pint-violations-hasteams-baseuser | Pint --test pulito su HasTeams.php, BaseUser.php + 3 file test | MEDIA | backlog |
| 15.7 | motivate-or-fix-phpstan-ignores | 11 @phpstan-ignore (7 in HasTeams.php): motivare o risolvere | MEDIA | backlog |
| 15.8 | migrate-passport-socialite-resources-to-tables-pattern | OauthAccessTokenResource, OauthPersonalAccessClientResource, SsoProviderResource → Tables/*Table.php dedicato | BASSA | backlog |
| 15.9 | explicit-label-audit | Verificare/rimuovere 41 ->label() espliciti in 17 file contro convenzione AutoLabelAction | BASSA | backlog |
| 15.10 | remove-debug-code-termsofservice | Rimuovere dddx('wip') da TermsOfService.php:32 | BASSA | backlog |
| 15.11 | fix-phpmd-phpinsights-toolchain | Riparare phar/composer.lock per PHPMD e PHPInsights (repo-wide, referenziata da qui) | ALTA | backlog |
| 15.12 | correct-livewire-inventory-stale-claims | Correggere i 2 claim di bug non riproducibili in livewire-inventory.md, prerequisito di 10.4 | MEDIA | backlog |

**Cross-epic:** 15.11 e' repo-wide, non solo User: la story va aperta qui ma
l'esecuzione tocca l'ambiente condiviso. 15.12 sblocca la story esistente
`User/10.4-retire-gdpr-profile-livewire` (oggi `blocked`), stesso obiettivo di
13.3 module-excellence: coordinare per non duplicare lo sblocco.

---

## Epic 16: Performance

**Goal:** nessun N+1 attivo, cache dove il costo di ricalcolo e' ricorrente,
notifiche asincrone dove non serve sincronia.

**In scope (cited):** RQ-PERF-001..007 [Source: perfection-prd.md#rq-perf],
ADR-P005 [Source: perfection-architecture.md]

**Out of scope:** introduzione di un layer di cache condiviso/custom (si usa la
facade `Cache` diretta, niente astrazioni nuove).

**Cross-reference module-excellence:** nessuna sovrapposizione: dimensione
performance non coperta da nessuna delle 24 story di `module-excellence`.

**Stories (ordered):**

| ID | Slug | Intent | Severita' | Status |
|----|------|--------|---|--------|
| 16.1 | fix-n1-oauthclientresource-owner | Eager load `owner` su OauthClientResource cluster Passport | ALTA | backlog |
| 16.2 | cache-passportstatswidget-counts | Polling interval + Cache::remember sui 5 COUNT di PassportStatsWidget | ALTA | backlog |
| 16.3 | cache-chart-widgets | Cache::remember con TTL su UsersChartWidget e UserTypeRegistrationsChartWidget (ADR-P005) | ALTA | backlog |
| 16.4 | queue-auth-notifications | ShouldQueue su ResetPassword e VerifyEmail | MEDIA | backlog |
| 16.5 | batch-revoke-tokens-bulk-action | whereIn()->update() invece di loop per-utente in RevokeAllUserTokensAction | MEDIA | backlog |
| 16.6 | fix-unused-eager-loads-4-resources | TeamUserResource, TenantUserResource, TeamInvitationResource, AuthenticationLogResource: rimuovere with() inutilizzato o mostrare il dato | MEDIA | backlog |
| 16.7 | remove-dead-table-hooks-oauthaccesstoken | Rimuovere le 144 righe di getTableColumns/Filters/Actions/BulkActions mai invocate | MEDIA | backlog |
| 16.8 | remove-redundant-save-after-sync | Rimuovere save() ridondante in ListPermissions bulk action | BASSA | backlog |

**Cross-epic:** nessuna dipendenza da altre epic: puo' partire in parallelo a
tutte.

---

## Epic 17: Test coverage sui punti piu' sensibili

**Goal:** la parte del modulo con piu' impatto (autorizzazione, config Shield,
login) ha test reali; esistono guard test che impediscono regressioni silenziose
delle regole di progetto gia' note.

**In scope (cited):** RQ-TEST-001..007 [Source: perfection-prd.md#rq-test],
ADR-P006 [Source: perfection-architecture.md]

**Out of scope:** raggiungere una soglia di coverage percentuale generica: il
focus e' sui gap identificati, non un target astratto.

**Cross-reference module-excellence:** 13.5 (`pest-coverage-resources-widgets-gap`)
e 13.6 (`playwright-e2e-plan`) coprono la stessa carenza di coverage da un
angolo Resource/Widget generico; questa Epic 17 e' specifica su
autorizzazione/Shield/LoginWidget: nessun ID/slug duplicato, ma 17.1 e 13.5
condividono la superficie `tests/`: coordinare l'esecuzione per non
sovrascrivere lo stesso file di test.

**Stories (ordered):**

| ID | Slug | Intent | Severita' | Status |
|----|------|--------|---|--------|
| 17.1 | test-userpolicy-behavior | Test comportamentale reale su UserPolicy (dopo 11.1) | ALTA | backlog |
| 17.2 | test-actions-shield-namespace | Test unitario per i 7 resolver Shield + 2 varianti GetPermissionModelAction | ALTA | backlog |
| 17.3 | reactivate-stale-skips-loginwidgettest | Riattivare i 4 test skippati (righe 60/81/94/115), bug citato gia' risolto | ALTA | backlog |
| 17.4 | add-architecture-guard-tests | Guard test in tests/Architecture/: no-RefreshDatabase, XotBase-only, array one-key-per-line (ADR-P006) | MEDIA | backlog |
| 17.5 | consolidate-test-helpers | Unificare tests/Helpers.php e tests/Support/helpers.php | MEDIA | backlog |
| 17.6 | remove-orphan-baseuser-models-models | Rimuovere app/Models/Models/BaseUser.php | BASSA | backlog |
| 17.7 | remove-graphify-cache-from-tests | Spostare/ignorare tests/Unit/graphify-out/ | BASSA | backlog |

**Cross-epic:** 17.1 dipende da 11.1 (non si testa un comportamento che sta per
cambiare).

---

## Epic 18: Bonifica schema e migrazioni

**Goal:** nessun drift UUID/PK cross-modulo, FK cascade dove il flusso applicativo
lo richiede, zero file relitto in `database/migrations/`.

**In scope (cited):** RQ-SCHEMA-001..006 [Source: perfection-prd.md#rq-schema],
ADR-P004 step 2 [Source: perfection-architecture.md]

**Out of scope:** ogni migrazione distruttiva o `migrate:fresh`/wipe: solo
migration additive, dati sacri.

**Cross-reference module-excellence:** nessuna sovrapposizione diretta: la
dimensione schema/migrazioni non e' fra le 24 story di `module-excellence`
(solo referenziata come "data debt gia' noto" fuori scope in 14 li').

**Stories (ordered):**

| ID | Slug | Intent | Severita' | Status |
|----|------|--------|---|--------|
| 18.1 | resolve-uuid-drift-profiles-ptv-user | Allineare pattern generazione UUID di profiles.id fra Ptv e User | ALTA | backlog |
| 18.2 | add-fk-cascade-gdpr-tables | FK cascadeOnDelete additiva su oauth_access_tokens/oauth_auth_codes/socialite_user (ADR-P004 step 2) | ALTA | backlog |
| 18.3 | fix-basetenant-uuid-generation-gap | Verificare e correggere generazione UUID in BaseTenant.php | MEDIA | backlog |
| 18.4 | clean-migrations-directory-clutter | Rimuovere .boh/.wip/.old/_bak/ da database/migrations | MEDIA | backlog |
| 18.5 | add-enum-casts-status-columns | Cast enum PHP sulle colonne status oggi stringa libera | MEDIA | backlog |
| 18.6 | deprecate-model-has-permission-singular | Migration additiva di deprecazione per model_has_permission (0 righe, duplicato di model_has_permissions) | BASSA | backlog |

**Cross-epic:** 18.2 completa strutturalmente 11.3.

---

## Epic 19: Bonifica documentazione

**Goal:** `docs/` (3832 file) e' consultabile: zero self-nesting, zero nomi
patologici, indice aggiornato, cluster di cartelle sovrapposte consolidati senza
perdita di contenuto.

**In scope (cited):** RQ-DOCS-001..006 [Source: perfection-prd.md#rq-docs],
ADR-P007 [Source: perfection-architecture.md]

**Out of scope:** cancellazione di qualunque file: solo merge/link/superseded,
mai delete (standing order BMAD).

**Cross-reference module-excellence:** sovrapposizione reale con Epic 12
(`module-excellence`, "Docs hygiene & consolidamento SSoT"). Probabile
duplicato genuino, da riconciliare **in fase di esecuzione, non ora** (nessuna
cancellazione/merge eseguita in questa sessione, solo audit):
- 19.3 (`regenerate-docs-index`) e 12.4 module-excellence
  (`docs-index-curated-map`) sembrano lo stesso obiettivo (sostituire
  `index.md` piatto): verificare se sono la stessa proposta prima di
  eseguirne una sola.
- 19.5 (`consolidate-overlapping-doc-clusters`) e 12.3 module-excellence
  (`archive-folders-consolidation`) coprono lo stesso cluster
  archive/fixes/bug-*: idem.
- 19.1 (self-nesting, 612 file) e 19.2 (nomi patologici) non hanno
  equivalente in module-excellence (che si concentra su cluster
  phpstan/archive/permissions/purpose specifici, non sul bug di
  self-nesting ricorsivo): nessun duplicato su questi due.

**Stories (ordered):**

| ID | Slug | Intent | Severita' | Status |
|----|------|--------|---|--------|
| 19.1 | fix-docs-self-nesting-bug | Bonificare i 612 file in path self-nested (X/X/...), verificando byte-identicita' prima di ogni merge (ADR-P007) | ALTA (per volume) | backlog |
| 19.2 | fix-pathological-filenames | Rinominare i 46 file con nome >100 caratteri e i 15 con spazi, kebab-case 2-5 parole | MEDIA | backlog |
| 19.3 | regenerate-docs-index | Aggiornare docs/index.md per riflettere le cartelle reali | MEDIA | backlog (verificare duplicato con 12.4 module-excellence prima di eseguire) |
| 19.4 | fix-gitignore-anchor-bug | Riassegnare/chiudere la story esistente 5.37-gitignore-archive-legacy-bug-user | MEDIA | backlog (gia' esistente, solo riassegnare) |
| 19.5 | consolidate-overlapping-doc-clusters | Designare cartelle canoniche per bugfix/bugs/bug-fixes/bug-tracking/fixes/fixed, marcare le altre superseded | BASSA | backlog (verificare duplicato con 12.3 module-excellence prima di eseguire) |
| 19.6 | investigate-doc-tooling-root-cause | Documentare/segnalare lo strumento che ha causato il self-nesting ricorsivo (fix fuori modulo se condiviso) | BASSA | backlog |

**Cross-epic:** nessuna dipendenza dalle altre epic: completamente indipendente.
19.4 non crea una nuova story, referenzia `docs/sprint-status.yaml` riga
52125-52130.

---

## Delivery tracking (count)

- Total epics questa campagna: 6 (Epic 11, 15-19)
- Total stories questa campagna: 44 (Epic 11: 5, Epic 15: 12, Epic 16: 8, Epic 17: 7, Epic 18: 6, Epic 19: 6)
- Epic 12-14 (24 story) sono di `module-excellence`, non di questa campagna: vedi [epics.md](./epics.md)
- Done: 0
- Ready-for-dev: 0 (tutte `backlog`: audit di sola documentazione)
- Story con file dedicato completo (AC): Epic 11 (5 story)

## Note

Implementazione **non** in questa sessione (vincolo esplicito utente: solo
documentazione). Handoff: le story di Epic 11 sono gia' `backlog` con story file
completo pronto per essere promosso a `ready-for-dev` alla prima sessione di
esecuzione: priorita' massima per severita' (account takeover attivo).

**Numerazione riconciliata 2026-09-22** dopo scoperta della campagna gemella
`module-excellence` (Epic 12-14, 24 story, scritta in parallelo: verosimilmente
un fork Agent di questa stessa sessione perso nella compattazione del contesto,
vedi [perfection-decision-log.md](./perfection-decision-log.md)). Epic
12-13-14-15-16 originarie di questo documento sono state rinumerate 15-16-17-18-19
per evitare collisione: nessuna story esistente di terzi e' stata cancellata o
rinumerata, solo il draft di questa campagna (mai promosso a file story
individuali prima della riconciliazione).

## GitHub (tracciamento)

Vedi [perfection-decision-log.md](./perfection-decision-log.md) per la decisione
presa su disclosure pubblica vs privata (repo `laraxot/module_user_fila5` e'
**pubblico**, i finding di sicurezza critici non sono stati pubblicati come issue
pubblica in questa sessione).
