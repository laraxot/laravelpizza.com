---
title: "Architecture: Perfezione assoluta del modulo User"
type: architecture
module: User
status: draft
track: perfection-campaign
source_prd: ./perfection-prd.md
related:
  - ./perfection-brainstorming.md
  - ./perfection-epics.md
  - ./perfection-decision-log.md
  - ./architecture.md
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "architecture: perfezione assoluta del modulo user user"
---

# Architecture: Perfezione assoluta del modulo User

**Track:** Perfection campaign (Epic 11-16)
**PRD:** [perfection-prd.md](./perfection-prd.md)

## 1. Overview

Questo documento non introduce nuova architettura di prodotto: il modulo User
resta un modular-monolith Laraxot, identity module, XotBase su tutto il layer
Filament (confermato conforme, vedi brainstorming §2.5/3.4). Il lavoro descritto
qui e' **debito da colmare dentro il pattern esistente**, non un redesign.

**In scope:** ADR per le decisioni architetturali aperte emerse dall'audit (dove
esistono piu' soluzioni valide, serve una decisione esplicita prima che una story
diventi `ready-for-dev`).
**Out of scope:** redesign di Tenant/morph map (confermato corretto), redesign
Filament chrome (coperto da Epic 9/10).

## 2. Stato attuale: assessment per layer

| Layer | Stato | Evidenza |
|---|---|---|
| Contracts (`UserContract`/`ProfileContract`) | Pattern presente e corretto, applicato incompletamente | 20 Actions corrette vs 4 punti su concreto (brainstorming §2.3) |
| Actions (`app/Actions`, Spatie QueueableAction) | 94.7% conforme, ma con duplicazione strutturale | 54/57 `QueueableAction`; 3x `CreateUserAction` (§2.1); `app/Adapters` morto (§2.2) |
| Policies (`app/Models/Policies`) | Esistono, auto-discovered, **una bypassa l'autorizzazione** | `UserPolicy` §1.1 |
| Filament (Resources/Tables/Widgets) | XotBase-compliant al ~100% | §2.5/3.4 |
| Morph map / multi-tenant | Corretta, SSoT unica | §2.6 |
| Schema/migrazioni | FK cascade incompleta, drift UUID cross-modulo | §6 |
| Test | Coverage strutturale forte (factory 1:1) ma buchi mirati sui punti piu' sensibili | §4 |
| Documentazione | Sprawl con bug di tooling ricorsivo | §7 |

## 3. ADR: decisioni architetturali per le epic 11-16

### ADR-P001: risoluzione naming collision `UserPolicy`/`BaseUserPolicy`

**Contesto:** `UserPolicy` (attiva, auto-discovered) estende `UserBasePolicy`
(pass-through vuoto) e bypassa l'autorizzazione. `BaseUserPolicy` (a controllo
ruolo, corretta) esiste ma non e' mai estesa da nessuno: e' codice morto per un
naming quasi-identico che ha portato a costruire la catena di ereditarietà sbagliata.

**Decisione:** `UserPolicy` deve estendere `BaseUserPolicy` (non `UserBasePolicy`).
Rinominare le due classi per eliminare l'ambiguita' semantica: proposta
`UserBasePolicy` (pass-through, se ancora serve per altri model) resta con nome
esplicito solo se ha ancora consumer reali una volta corretto `UserPolicy`;
`BaseUserPolicy` diventa la base a controllo ruolo con nome che non collida (es.
`RoleBasedUserPolicy` o analogo: la scelta finale del nome spetta a chi implementa
la story, il vincolo e' "i due nomi non devono differire solo per l'ordine di due
parole").

**Alternative scartate:** riscrivere la logica a ruoli direttamente dentro
`UserPolicy` senza toccare `BaseUserPolicy`: scartata perche' lascerebbe
`BaseUserPolicy` come dead code duplicato, stesso debito riprodotto.

**Rationale:** memoria di progetto `filament-hook-naming-collision.md`: pattern
gia' noto, qui si ripete sulle Policy invece che sugli hook. La cura e' rompere la
somiglianza del nome, non solo il collegamento.

### ADR-P002: consolidamento `CreateUserAction` (3 → 1)

**Contesto:** 3 classi omonime in namespace diversi (`Actions\`, `Actions\User\`,
`Actions\Socialite\`), solo l'ultima segue il pattern corretto (`UserContract` +
`XotData::make()->getUserClass()`).

**Decisione:** unica classe `Actions\CreateUserAction`, basata sul pattern
Socialite. Deve assorbire le responsabilita' reali delle altre due (validazione +
welcome email + audit log dalla prima; nessuna logica persa) ma con model risolto
via contratto. Le altre due vengono rimosse, non deprecate-in-place (nessun
consumer di produzione le rende necessarie da mantenere come alias, verificare al
momento dell'implementazione che resti vero).

**Alternative scartate:** mantenere 3 classi con responsabilita' esplicitamente
distinte e nomi diversi: scartata perche' il nome identico e' esso stesso il bug
(qualunque nuovo sviluppatore importa quella sbagliata per caso, come probabilmente
gia' successo).

### ADR-P003: rimozione `app/Adapters/**`

**Decisione:** cancellazione diretta (non "superseded", perche' non e' documentazione
ma codice con zero caller di produzione: memoria [[il-duplicato-si-cancella-non-si-
preserva]]). Verificare a tempo di implementazione che il grep "zero consumer" sia
ancora vero (regola [[verify-before-edit-concurrent-sessions]]: altre sessioni
potrebbero aver toccato il modulo nel frattempo).

### ADR-P004: FK cascade per il flusso GDPR (RQ-SEC-003 + RQ-SCHEMA-002)

**Contesto:** oggi la cancellazione utente non ha garanzia strutturale (ne' a
livello Action ne' a livello DB) che token/social/log vengano rimossi.

**Decisione:** doppio livello, non alternativo:
1. **Action-level** (Epic 11): `DeleteUserAction` invoca esplicitamente
   `RevokeAllUserTokensAction` e le Action equivalenti per `SocialiteUser`/
   `AuthenticationLog`/pivot ruolo: comportamento esplicito, testabile,
   indipendente dal motore DB.
2. **Schema-level** (Epic 18, additivo): FK con `cascadeOnDelete()` come
   safety-net per i path che non passano da `DeleteUserAction` (script, tinker,
   comandi artisan futuri).

**Rationale:** un solo livello non basta: solo Action-level e' bypassabile da
scritture dirette; solo schema-level non da' controllo su anonimizzazione (alcuni
dati vanno anonimizzati, non cancellati, per audit trail).

**Vincolo dati sacri:** la migration FK e' additiva; non tocca righe esistenti;
se righe orfane preesistenti violano il nuovo vincolo FK, la story deve
prima misurarle (query read-only) e proporre una migration di pulizia separata,
mai un `migrate:fresh`/wipe.

### ADR-P005: cache layer: dove e come

**Contesto:** 0/357 file usano cache nel modulo; 3 punti identificati (Stats
widget, 2 chart widget) beneficerebbero di un TTL esplicito.

**Decisione:** `Cache::remember()` con chiave che include il tenant (coerente con
`morph-map-e-per-tenant`: mai una chiave cache condivisa fra tenant su dati
tenant-scoped) e TTL breve (60s per gli stat counter, 5-15 min per i grafici
storici che cambiano lentamente). Niente cache layer nuovo/astrazione custom: uso
diretto della facade `Cache` di Laravel, coerente con "niente Services, niente
astrazioni premature".

### ADR-P006: guard test architetturali (RQ-TEST-004)

**Decisione:** i guard test vivono in `tests/Architecture/` (nuova cartella,
Pest `arch()` preset dove applicabile, test custom con `grep`/AST altrove per le
regole che Pest `arch()` non copre nativamente, es. "array one-key-per-line").
Ogni guard test referenzia la memoria/regola che formalizza (link nel commento del
test), cosi' la regola non "non scatta" piu' silenziosamente (memoria
[[memoria-non-scatta-guardia-si]]: una regola non testata regredisce, memoria
[[regola-senza-test-regredisce]]).

### ADR-P007: consolidamento documentazione: non cancellare, mai

**Decisione:** per il bug di self-nesting (626 file) e i cluster di cartelle
sovrapposte, l'approccio e' sempre: designare canonico, linkare/marcare
`superseded` le altre, **mai eliminare**. Per i 612 file self-nested
specificamente, la story deve prima capire se sono *copie byte-identiche* (come
verificato per il campione `docs/docs/`): in quel caso un link/redirect verso il
path corretto e' sufficiente senza perdita di informazione; se non sono identici,
serve merge manuale prima di marcare superseded.

## 4. Sequenza di dipendenza fra epic

```
Epic 11 (Sicurezza)  ──depends on──> Epic 18.2 (FK cascade, ADR-P004 step 2)
     │
     └─ RQ-SEC-003 puo' partire con solo lo step Action-level (ADR-P004.1),
        non blocca su Epic 18 per iniziare: ma non si considera "chiuso"
        finche' anche lo step schema-level non e' fatto.

Epic 15 (Architettura/Qualita') ──independent, puo' partire subito
Epic 16 (Performance) ──independent, puo' partire subito
Epic 17 (Test) ──RQ-TEST-001 dipende dal fix Epic 11.1 (altrimenti si testa
                  comportamento che si sta per cambiare): resto indipendente
Epic 18 (Schema) ──independent salvo il link con Epic 11 sopra
Epic 19 (Documentazione) ──completamente indipendente dalle altre 5
```

Nessuna epic di questa campagna blocca o e' bloccata da Epic 9/10 (widget/Livewire),
che restano su un binario separato.

## 5. Rischi

- **Rischio di regressione su `HasTeams.php`**: il file e' hot-spot sia per
  PHPStan (7 `@phpstan-ignore`) sia per Pint (4 fixer): qualunque story che lo
  tocca (Epic 15) deve passare da un lock esplicito (`bashscripts/lock/`) per
  evitare collisioni con sessioni concorrenti, storicamente frequenti su questo
  modulo (vedi `evidence-based-stale-lock-takeover`, `verify-before-edit-
  concurrent-sessions`).
- **Rischio di falso positivo su "zero consumer"**: piu' finding di questo audit
  (Adapters, top-level CreateUserAction, DTO privilegiati) si basano su grep
  "zero caller trovato oggi": da riverificare a tempo di implementazione, non
  fidarsi del solo audit (memoria [[grep-conta-le-menzioni-non-le-chiamate]]).
- **Rischio disclosure**: la documentazione dettagliata del finding RQ-SEC-001
  (account takeover) vive in un repo pubblico (`laraxot/module_user_fila5`): vedi
  [perfection-decision-log.md](./perfection-decision-log.md) per la decisione presa
  su come tracciarlo senza divulgazione pubblica prematura.
