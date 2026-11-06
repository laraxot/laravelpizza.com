---
title: "Decision log: Perfezione assoluta del modulo User"
type: decision-log
module: User
status: living
track: perfection-campaign
related:
  - ./perfection-prd.md
  - ./perfection-architecture.md
  - ./perfection-epics.md
  - ./perfection-brainstorming.md
  - ./decision-log.md
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "decision log: audit 'perfezione assoluta'   2026-09-22 user"
---

# Decision log: audit "perfezione assoluta": 2026-09-22

## [2026-09-22] Scope: audit dell'intero modulo, non solo la campagna widget

**Decision:** richiesta utente ("studia a fondo il modulo User... porta alla
perfezione assoluta... solo documentare") coperta con un audit a 7 dimensioni
indipendenti (sicurezza, architettura, qualita' codice/Filament, test, performance,
schema/migrazioni, documentazione), separato dalla campagna Epic 9/10 gia' in
corso (SuperAdmin widget + ritiro Livewire), che resta autonoma e non viene
toccata.

**Rationale:** Epic 9/10 copre solo il chrome UI del toggle SuperAdmin e la
migrazione Livewire→Filament; il modulo ha 112 model, 357 file Filament, 59
migration, 310 test: la richiesta di "perfezione assoluta" implica l'intero
modulo, non un sottoinsieme gia' in lavorazione.

## [2026-09-22] Metodo: subagent paralleli, solo general-purpose

**Decision:** i 7 audit sono stati eseguiti con `subagent_type: general-purpose`,
non con i tipi specializzati (`laravel-architecture-reviewer`,
`laravel-security-auditor`, ecc.).

**Rationale:** i 7 agenti specializzati lanciati inizialmente hanno restituito
risultati completamente **hallucinati**: narrazione di comandi mai eseguiti,
verificato via ispezione diretta dei transcript JSONL (zero blocchi `tool_use` in
tutti e 7, solo `thinking`/`text`). Un test diagnostico con `general-purpose`
(comando reale via Bash, output verificato) ha confermato che quel tipo di agente
esegue davvero i tool. Tutti i 7 audit sono stati rilanciati con
`general-purpose` e un prompt che richiede esplicitamente l'uso reale dei tool;
ogni risultato incorporato in questa campagna ha `tool_uses > 0` verificato nella
notifica di completamento (33-73 tool call reali per agente, 96843-159969 token
per agente).

**Nota per sessioni future:** non fidarsi dei risultati di
`laravel-architecture-reviewer`/`laravel-code-reviewer`/`laravel-security-
auditor`/`laravel-testing-expert`/`laravel-documentation-engineer`/
`eloquent-specialist`/`laravel-performance-optimizer` senza verificare
`tool_uses > 0` nella notifica: potrebbe essere un problema di ambiente
specifico di questa sessione, non necessariamente riproducibile sempre, ma il
costo di verifica e' basso e l'impatto di un falso report e' alto.

## [2026-09-22] Disclosure pubblica dei finding di sicurezza critici: NON creato issue/discussion pubblico

**Decision:** i finding RQ-SEC-001 (bypass totale autorizzazione `UserPolicy`,
account takeover) e RQ-SEC-002 (nessun rate limiting login) **non sono stati
pubblicati** come issue/discussion GitHub pubblici, contrariamente al pattern
esistente "1 issue + 1 discussion per campagna" (precedente: #100/#101 per Epic
9/10). Tutto il contenuto resta solo nei file locali `docs/bmad/perfection-*.md` e
`docs/stories/11.x-*.story.md`, non ancora committati/pushati sul repo remoto.

**Rationale:** verificato (`gh repo view laraxot/module_user_fila5 --json
visibility` → `"PUBLIC"`) che il repo del modulo e' **pubblico**. Un issue
GitHub pubblico con path di exploit dettagliato per una vulnerabilita' di
account-takeover non ancora corretta sarebbe una disclosure irresponsabile -
chiunque potrebbe leggerlo e sfruttarlo prima che il fix sia deployato. Questa e'
un'azione visibile a terzi e difficile da revocare (anche cancellando l'issue,
GitHub la mantiene nella cronologia/API e puo' essere stata indicizzata): rientra
esplicitamente nella categoria di azioni che richiedono conferma esplicita
dell'utente prima di procedere, non una decisione che un agente deve prendere da
solo silenziosamente.

**Raccomandazione per l'utente (azione non eseguita, da decidere):**
1. Per RQ-SEC-001/002 (critici): considerare una **GitHub Security Advisory**
   privata (funzione nativa GitHub per repo pubblici, visibile solo ai
   maintainer finche' non viene pubblicata) invece di un issue pubblico.
2. Per il resto della campagna (architettura, qualita', performance, test,
   schema, documentazione: nessuno di questi e' una vulnerabilita' sfruttabile):
   si puo' procedere con il pattern normale issue+discussion pubblico senza
   rischio di disclosure, se l'utente conferma.
3. In alternativa, tracciare tutto solo internamente (`sprint-status.yaml` +
   `docs/bmad/`) senza mai pubblicare su GitHub, se il repo pubblico non e'
   il canale di lavoro preferito per debito noto non ancora risolto.

**Non deciso in questa sessione**: richiede input esplicito dell'utente, non
presunto.

## [2026-09-22] Numerazione epic: 11-16, non riuso di 9/10

**Decision:** le nuove epic partono da 11 (dopo Epic 10 esistente), non
riutilizzano o rinumerano nulla di esistente.

**Rationale:** standing order BMAD: mai cancellare/rinumerare story esistenti;
Epic 9/10 hanno gia' 8 story tracciate in `sprint-status.yaml` con stati reali
(done/in-progress/blocked), toccarle avrebbe rotto la cronologia.

## [2026-09-22] Prefisso `perfection-` per i nuovi file BMAD

**Decision:** tutti i nuovi documenti usano il prefisso `perfection-` (
`perfection-brainstorming.md`, `perfection-prd.md`, ecc.) invece di sovrascrivere
`brainstorming.md`/`prd.md`/`architecture.md`/`epics.md`/`decision-log.md`
esistenti (che restano la SSoT della campagna Epic 9/10).

**Rationale:** evitare collisione/confusione fra le due campagne; entrambe restano
leggibili e referenziabili separatamente.

## [2026-09-22] File story completi solo per Epic 11 in questa sessione

**Decision:** solo le 5 story di Epic 11 (sicurezza, priorita' massima) hanno un
file `.story.md` individuale con AC completi in `docs/stories/`. Le altre 34
story (Epic 12-16) sono documentate nella tabella di `perfection-epics.md` con
status `backlog`, senza file dedicato.

**Rationale:** bilanciamento fra completezza richiesta ("documenta tutto quello
che c'e' da fare") e costo di produrre 39 file story completi in una sola
sessione. Le story di Epic 11 sono le piu' urgenti (vulnerabilita' attive) e
quindi le piu' probabili ad essere reclamate per prima in una sessione di
esecuzione futura: meritano di essere gia' pronte (`backlog` → promuovibili a
`ready-for-dev` senza ulteriore lavoro di stesura). Le altre restano comunque
completamente descritte (intent, severita', citazioni file:riga nel
brainstorming): non e' un gap di documentazione, e' una scelta di dove investire
il dettaglio massimo prima dell'esecuzione.

## [2026-09-22] Data debt morph map: riverificato, non presente su Ptv

**Decision:** il data debt documentato in `decision-log.md` (40 righe stantie
`model_has_role.model_type='Modules\Quaeris\Models\User'`) e' stato riverificato
con una query read-only reale su questa installazione (Ptv): 482/482 righe hanno
`model_type='user'` corretto, zero righe stantie. Il debito riguardava il tenant
Quaeris, non questo. Nessuna azione necessaria su Ptv per questo punto specifico.

**Rationale:** modulo condiviso fra progetti (Sigma/Ptv/Fila5/Quaeris): un data
debt osservato su un tenant non implica lo stesso stato su un altro (memoria
[[moduli-condivisi-fra-progetti]], [[il-morph-map-e-per-tenant]]).

## [2026-09-22] Nessuna scrittura DB, nessuna migration eseguita

**Decision:** confermato a fine sessione: nessun file `app/`, `database/`,
`config/`, `routes/`, `lang/` modificato; unica query eseguita e' stata una
`SELECT ... GROUP BY` via tinker per il punto sopra. Vincolo "dati sacri"
rispettato integralmente.

## [2026-09-22] Riconciliazione numerazione con campagna module-excellence

**Sintomo:** dopo aver scritto le 5 story file di Epic 11
(`docs/stories/11.[1-5]-*.story.md`) e completato `perfection-epics.md` con
Epic 11-16, un controllo `ls docs/stories/ | grep -oE '^[0-9]+\.[0-9]+'`
ha rivelato 24 file `12.1.*` fino a `14.8.*` gia' presenti su disco, scritti
alle 12:19:49: circa 90 secondi dopo i file di questa sessione (12:18:19) -
insieme a `docs/bmad/module-excellence-{product-brief,prd,architecture,
brainstorming}.md` e a modifiche gia' fatte a `README.md`/`decision-log.md`/
`epics.md` (i file canone, non quelli con prefisso `perfection-`).

**Origine (non accertata con certezza, ma verosimile):** il contenuto di
`decision-log.md` entry "Campagna module-excellence additiva" cita
letteralmente "5 ricerche parallele in sola lettura (Agent subagent_type:
fork)": lo stesso meccanismo di fork usato in questa sessione. Ipotesi piu'
probabile: un `Agent` con `subagent_type: "fork"` lanciato prima della
compattazione del contesto di questa conversazione, di cui il riassunto
post-compattazione non ha conservato traccia, ha proseguito in background con
un proprio nome di campagna (`module-excellence` invece di `perfection`) ed e'
terminato scrivendo tutti i suoi artefatti indipendentemente. Alternativa non
esclusa: sessione Claude Code concorrente dell'utente sullo stesso checkout
(pattern gia' noto, vedi [[verify-before-edit-concurrent-sessions]]). In
nessuno dei due casi il contenuto va trattato come spurio: e' stato prodotto
con lo stesso rigore (fonti citate a file:riga, `status: approved` sul suo
PRD, 24 story tutte `backlog`, nessuna scrittura di codice/DB).

**Decision:** nessun file di `module-excellence` e' stato toccato, cancellato
o rinumerato. Il draft di questa campagna (`perfection-epics.md`, mai
promosso a file story individuali per Epic 12-16 prima di questo momento) e'
stato rinumerato: Epic 12→15, 13→16, 14→17, 15→18, 16→19. Epic 11 resta
invariata (nessuna collisione reale: l'unica story 11.1 pre-esistente e'
gia' `superseded_by: 10.1`). Aggiunto un blocco "Cross-reference
module-excellence" a ogni epic rinumerata per segnalare sovrapposizioni
tematiche reali (Epic 19 vs Epic 12 module-excellence su docs hygiene, Epic
15 vs Epic 13 module-excellence su code quality, Epic 17 vs 13.5/13.6 su test
coverage) senza eseguire alcun merge: la riconciliazione dei contenuti resta
per la fase di esecuzione, non per questa sessione di sola documentazione.

**Rationale:** standing order "non cancellare ne' rinumerare story esistenti:
collegarle o marcarle superseded" si applica a story gia' esistenti/tracciate;
il draft interno di `perfection-epics.md` per Epic 12-16 non era ancora stato
promosso a file individuali ne' referenziato da `sprint-status.yaml`, quindi
rinumerarlo prima della promozione e' l'azione meno distruttiva: l'alternativa
(rinumerare `module-excellence`, gia' completa di 24 file story individuali e
gia' linkata da `README.md`) avrebbe richiesto toccare e rinominare 24 file
oltre a 3 file canone condivisi. Riferimento: [[le-story-del-modulo-si-leggono-prima]]
- lezione applicata qui prima di scrivere altro, non dopo.

**Verifica:** `ls docs/stories/ | grep -oE '^(1[1-9]|20)\.[0-9]+' | sort -u`
non mostra piu' collisioni fra i due prefissi di campagna dopo la correzione
di `perfection-epics.md` (i file individuali 12.x-14.x restano di proprieta'
esclusiva di module-excellence, nessun file 15.x-19.x esiste ancora su disco
per questa campagna: solo tabella in `perfection-epics.md`, come da nota
"story dedicato completo solo per Epic 11").

## [2026-09-22] Chiusura riconciliazione: confermata analisi di module-excellence, verificato GitHub reale

**Decision:** letta integralmente l'entry di `decision-log.md` "Riconciliazione
con la campagna concorrente 'perfection-' (sessione parallela)": conferma
indipendente, dall'altro lato, della stessa riconciliazione fatta qui.
Attribuisce correttamente i 6 file orfani `docs/stories/12.[1-6].filament-ux-
*.story.md` (+ `bmad/filament-ux-{architecture,brainstorming}.md`) a un
tentativo precedente di questa stessa campagna (prefisso "filament-ux",
Epic 12 "Audit UI/Filament modulo User"), abbandonato quando questa sessione
e' passata al prefisso `perfection-` e alla numerazione Epic 11+15-19.
Nessuna azione ulteriore su quei 6 file: non vengono cancellati ne'
rinominati (standing order), restano un candidato di pulizia futura gia'
segnalato dall'altra sessione.

**GitHub verificato (non assunto):** `gh issue list`/`gh api discussions/104`
confermano reali issue #103 (parent), #105-116, discussion #104 per
`module-excellence` (Epic 12-14): nessuna hallucination. Fra queste, #113
("~30 Policy senza permesso nel seeder, silent-deny") e' adiacente ma
qualitativamente diversa dai finding RQ-SEC-001/002 di questa campagna: un
gap di permessi mancanti fallisce chiudendo l'accesso (silent-deny), mentre
UserPolicy bypass e assenza rate-limiting falliscono aprendo un percorso di
privilege escalation attivo. La presenza di issue pubbliche gia' aperte su
temi adiacenti non cambia la decisione presa sopra ("Decision" GitHub
disclosure, non ancora pubblicata): i due RQ-SEC critici restano non
pubblicati, in attesa di input esplicito dell'utente.

**Stato finale a fine sessione:** nessuna ulteriore collisione di numerazione
residua. Le due campagne (`perfection` Epic 11/15-19, `module-excellence`
Epic 12-14) sono reciprocamente coerenti, entrambe tracciate in
`docs/sprint-status.yaml` (chiavi `User/11.x`-`User/19.x`), lock rilasciati,
second brain aggiornato (`qmd update` eseguito, 53 nuovi + 47 aggiornati file
indicizzati).
