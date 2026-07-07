---
title: "PRD: LaravelPizza.com"
status: final
created: 2026-07-07
updated: 2026-07-07
---

# PRD: LaravelPizza.com
*Titolo di lavoro — da confermare.*

## 0. Scopo del Documento

Questo PRD è rivolto a chi implementa e verifica la piattaforma (sviluppatori, QA) e a chi ne guida la direzione di prodotto. Costruisce sul [Product Brief](../../briefs/brief-laravelpizza.com-2026-07-07/brief.md) già finalizzato (non lo duplica) e sui requisiti già tracciati in `.planning/REQUIREMENTS.md`, che qui vengono formalizzati come Functional Requirements con ID stabili globali per essere referenziabili da epics/story a valle. Il documento è organizzato per Feature, con i FR annidati sotto ciascuna; il Glossario fissa il vocabolario usato ovunque senza sinonimi; gli `[ASSUMPTION]` inline sono indicizzati in fondo per conferma esplicita.

## 1. Visione

LaravelPizza.com è la piattaforma che permette alla community italiana degli sviluppatori Laravel di scoprire, pubblicare e partecipare a meetup — senza gli attriti di strumenti generici (Meetup.com, gruppi Telegram, form sparsi) che non parlano il linguaggio della community tecnica che li usa.

È al tempo stesso, per scelta esplicita e non negoziabile, un progetto open-source costruito con una disciplina architetturale rara (PHPStan livello 10, zero controller tradizionali, CMS JSON-driven, un solo file di migrazione per tabella): ogni funzionalità che implementiamo è anche una dimostrazione vivente di come si costruisce oggi un'applicazione Laravel moderna e modulare.

Un organizzatore di meetup trova qui uno strumento che pubblica un evento in pochi minuti e lo mette davanti al pubblico giusto; un partecipante si iscrive senza attriti; uno sviluppatore curioso trova un repository leggibile che gli insegna pattern che altrove non troverebbe applicati insieme e coerentemente.

Le due dimensioni non sono indipendenti: più la piattaforma viene usata da meetup reali (SM-1), più il caso di studio tecnico diventa credibile; più il codice resta pulito e documentato, più attrae contributori (SM-2) che a loro volta migliorano il prodotto per gli utenti reali. Il vantaggio competitivo non è la velocità di esecuzione ma la disciplina architetturale mantenuta nel tempo (PHPStan livello 10, regole `.cursor/rules/`, documentazione per modulo) — è ciò che rende il progetto un riferimento riusabile da altri team, non solo un sito che funziona.

Se questo percorso ha successo oltre l'orizzonte di questo PRD, il framework "Laraxot" dimostrato qui potrebbe generalizzarsi in uno starter-kit riusabile per community tech di qualsiasi tipo (vedi [Product Brief, §Visione](../../briefs/brief-laravelpizza.com-2026-07-07/brief.md)) — non è un obiettivo di questo PRD, ma la ragione per cui la disciplina tecnica (SM-4) non è negoziabile.

## 2. Target Utente

### 2.1 Jobs To Be Done

- **Organizzatore di meetup**: vuole pubblicare un evento (data, sede, relatori, sponsor) e vederlo raggiungere gli sviluppatori Laravel della propria città senza dover gestire manualmente iscrizioni via form/spreadsheet.
- **Partecipante/visitatore**: vuole scoprire rapidamente se c'è un meetup Laravel vicino a lui, capire di cosa parla, e iscriversi con il minimo attrito. "Minimo attrito" significa: nessun form multi-step, nessuna verifica manuale, nessun collegamento a provider OAuth esterni (vedi §2.2) — non significa "senza creare un account": l'Iscrizione a un Evento richiede comunque email+password (diventa un Utente, vedi Glossario), ma il costo è deliberatamente limitato a questo.
- **Amministratore della piattaforma**: vuole avere il controllo centralizzato su eventi, sedi, relatori, sponsor e liste iscritti, con visibilità sui numeri (dashboard).
- **Sviluppatore Laravel esterno** [ASSUMPTION: incluso come JTBD secondario coerente col brief]: vuole leggere codice reale che applica Folio+Volt+Filament+architettura modulare per imparare o eventualmente contribuire.
- **Organizzatore di altri meetup tech** [ASSUMPTION: ripreso dal brief come utente terziario, non confermato in questa sessione]: vuole usare la piattaforma o il suo approccio architetturale come riferimento/starter-kit per il proprio gruppo, anche non-Laravel.

### 2.2 Non-Users (v1)

- Chi cerca di **acquistare un biglietto a pagamento** — non supportato in v1 (rimandato a v2, vedi §6.2).
- Chi vuole **accedere via login social/OAuth** — v1 supporta solo email/password.
- Chi cerca **una app nativa mobile** — v1 è web-only, mobile-responsive.

### 2.3 Key User Journeys

- **UJ-1. Marco pubblica il prossimo meetup di Roma.**
  Marco, organizzatore volontario del gruppo Laravel Roma, accede al pannello admin Filament, crea un nuovo evento con data, sede, relatori e sponsor, e lo pubblica. Il sistema mostra subito l'evento nella pagina pubblica eventi. **Edge case:** se dimentica la capienza massima, il sistema chiede un valore prima di permettere la pubblicazione.

- **UJ-2. Giulia scopre e si iscrive a un meetup senza creare un account complesso.**
  Giulia, sviluppatrice Laravel junior, arriva sulla home da un link condiviso su LinkedIn, sfoglia gli eventi filtrando per la propria città, apre il dettaglio dell'evento che le interessa, e si iscrive inserendo email e password. Riceve subito un'email di conferma. **Edge case:** se l'evento ha raggiunto la capienza massima, il sistema le impedisce l'iscrizione e lo comunica chiaramente prima che completi il form.

- **UJ-3.** [ASSUMPTION: aggiunta per coerenza con lo scopo vetrina, non esplicitamente confermata] **Un contributore esterno esplora il repository per imparare un pattern.**
  Uno sviluppatore Laravel trova il repo tramite un talk o un post, naviga i moduli (`laravel/Modules/Meetup`) e la documentazione, e capisce come è strutturata la registrazione eventi senza controller tradizionali (Folio+Volt). *Nota: a differenza di UJ-1/UJ-2, questo journey non realizza alcun FR — è illustrativo dello scopo "vetrina" (SM-2) e non è load-bearing per lo sviluppo del prodotto.*

## 3. Glossario

- **Evento** — Un meetup pubblicato, con data, sede, relatori, sponsor, capienza massima e lista iscritti. Appartiene a un solo modulo Meetup.
- **Visitatore** — Chi naviga le pagine pubbliche senza essersi ancora registrato. Diventa un Utente nel momento in cui completa un'Iscrizione (email+password).
- **Utente** — Un Visitatore che ha completato la registrazione (email+password) tramite un'Iscrizione. Non implica un profilo esteso: la registrazione resta a basso attrito (vedi §2.1).
- **Iscrizione** — L'atto che lega un Utente a un Evento, soggetto al limite di Capienza; comporta la creazione dell'account Utente se non già esistente.
- **Capienza** — Numero massimo di Iscrizioni accettate per un Evento.
- **Sede** (Venue) — Luogo fisico associato a uno o più Eventi.
- **Relatore** (Performer) — Persona che presenta un talk a un Evento.
- **Sponsor** — Organizzazione che supporta un Evento, mostrata nella pagina pubblica.
- **Pagina CMS** — Pagina pubblica il cui contenuto è definito da un file JSON in `config/local/laravelpizza/database/content/pages/`, renderizzata via Folio senza controller.
- **Blocco di contenuto** (Content Block) — Unità riusabile di contenuto (hero, features, lista eventi, ecc.) referenziata da una Pagina CMS.
- **Locale** — Lingua attiva della sessione utente (IT o EN in v1), determinata dal prefisso URL secondo `mcamara/laravel-localization`.

## 4. Feature

### 4.1 Amministrazione Eventi (Admin Filament)

**Descrizione:** L'amministratore gestisce Eventi, Sedi, Relatori, Sponsor e Iscrizioni tramite il pannello Filament, con visibilità sui numeri chiave. Realizza UJ-1.

**Functional Requirements:**

#### FR-1: Creazione e gestione Eventi
L'Amministratore può creare, modificare ed eliminare un Evento (data, sede, relatori, sponsor, capienza). Realizza UJ-1.

**Consequences (testable):**
- Un Evento non può essere pubblicato senza una Capienza valorizzata.
- L'eliminazione di un Evento con Iscrizioni attive richiede conferma esplicita.

#### FR-2: Gestione Sedi, Relatori e Sponsor
L'Amministratore può creare, modificare ed eliminare Sedi, Relatori e Sponsor, e associarli a uno o più Eventi.

**Consequences (testable):**
- Una Sede, un Relatore o uno Sponsor eliminato mentre è associato a un Evento futuro richiede conferma esplicita o blocca l'eliminazione.
- Un Evento può essere associato a più Sponsor e più Relatori contemporaneamente.

#### FR-3: Dashboard statistiche
L'Amministratore visualizza una dashboard con il numero di Eventi programmati/passati e le Iscrizioni per Evento.

**Consequences (testable):**
- La dashboard riporta almeno: numero Eventi futuri, numero Eventi passati, numero Iscrizioni totali per Evento futuro.
- I dati mostrati riflettono lo stato del database al momento del caricamento della pagina (nessuna cache stantia oltre la durata della request).

#### FR-4: Gestione Iscrizioni e liste iscritti
L'Amministratore può visualizzare e gestire la lista Iscrizioni per ciascun Evento. [ASSUMPTION: l'esportazione della lista iscritti (es. CSV) è un'estensione rispetto al requisito originale ADMN-04 in `.planning/REQUIREMENTS.md`, non esplicitamente richiesta — da confermare prima dello sviluppo.]

**Consequences (testable):**
- L'Amministratore può visualizzare la lista completa delle Iscrizioni per un dato Evento, incluso lo stato (confermata/in attesa).
- [ASSUMPTION] Se l'esportazione viene confermata: l'export produce un file scaricabile (es. CSV) con almeno email e data Iscrizione per ciascun iscritto.

### 4.2 Scoperta Pubblica Eventi

**Descrizione:** Un Visitatore, senza autenticazione, può sfogliare e filtrare gli Eventi. Realizza UJ-2.

**Functional Requirements:**

#### FR-5: Lista Eventi futuri
Il Visitatore può sfogliare gli Eventi futuri senza autenticazione. Realizza UJ-2.

**Consequences (testable):**
- La lista Eventi futuri è accessibile senza login e senza redirect ad una pagina di autenticazione.
- Gli Eventi sono ordinati per data crescente (il più vicino nel tempo per primo).

#### FR-6: Lista Eventi passati
Il Visitatore può consultare l'elenco degli Eventi passati.

**Consequences (testable):**
- Gli Eventi passati sono ordinati per data decrescente (il più recente per primo) e non mostrano CTA di iscrizione attiva.

#### FR-7: Dettaglio Evento
Il Visitatore può visualizzare la pagina di dettaglio di un Evento con tutti i metadati (Sede, Relatori, Sponsor, Capienza residua).

**Consequences (testable):**
- La pagina di dettaglio mostra la Capienza residua calcolata in tempo reale (Capienza totale − Iscrizioni confermate).
- Se l'Evento non esiste o non è pubblicato, la pagina restituisce 404.

#### FR-8: Ricerca/filtro Eventi
Il Visitatore può filtrare gli Eventi per città o data.

**Consequences (testable):**
- Il filtro per città restituisce solo Eventi la cui Sede è in quella città (match esatto o normalizzato, da definire in fase tecnica).
- L'assenza di risultati per un filtro mostra un messaggio esplicito, non una lista vuota senza spiegazione.

### 4.3 Flusso di Iscrizione

**Descrizione:** Il Visitatore si iscrive a un Evento con la minima frizione possibile. Realizza UJ-2.

**Functional Requirements:**

#### FR-9: Iscrizione con email valida
Il Visitatore può iscriversi a un Evento fornendo email e password valide, diventando così Utente. Realizza UJ-2.

**Consequences (testable):**
- Il sistema rifiuta indirizzi email non validi o già registrati (senza password corrispondente) con messaggio d'errore chiaro.
- L'Iscrizione richiede solo email e password — nessun campo aggiuntivo obbligatorio (coerente con §2.1, "minimo attrito").

#### FR-10: Conferma email immediata
L'Utente riceve un'email di conferma immediatamente dopo l'Iscrizione.

**Consequences (testable):**
- L'email di conferma è inviata entro pochi secondi dal completamento dell'Iscrizione e contiene almeno: nome Evento, data, Sede.

#### FR-11: Prevenzione sovra-iscrizione ✅ *(già implementato)*
Il sistema impedisce Iscrizioni oltre la Capienza massima dell'Evento.

**Consequences (testable):**
- Un tentativo di Iscrizione oltre Capienza restituisce un messaggio d'errore prima del salvataggio, non dopo.

### 4.4 CMS e Strategia dei Contenuti

**Descrizione:** Le pagine pubbliche (home, about, contatti, ecc.) sono gestite come Pagine CMS via JSON, aggiornabili senza deploy — coerente con l'architettura Folio+Volt "no controller" del progetto.

**Functional Requirements:**

#### FR-12: Rendering da JSON
Le Pagine pubbliche sono renderizzate a partire da file JSON di contenuto.

**Consequences (testable):**
- Ogni Pagina pubblica ha un file JSON corrispondente in `config/local/laravelpizza/database/content/pages/`; non esiste una Pagina pubblica renderizzata da un file Blade dedicato con contenuto hardcoded.

#### FR-13: Blocchi di contenuto multi-tipo
I Blocchi di contenuto supportano testo, immagini e liste di Eventi.

**Consequences (testable):**
- Un Blocco di contenuto dichiara il proprio `type` (es. `hero`, `features`, `events-list`) e il rendering corrispondente esiste come componente Blade in `Themes/Meetup/resources/views/components/blocks/`.

#### FR-14: Aggiornamento senza deploy
Le Pagine CMS possono essere aggiornate modificando il JSON, senza richiedere un nuovo deploy applicativo.

**Consequences (testable):**
- Una modifica al file JSON di una Pagina CMS è visibile pubblicamente senza eseguire build, migrazioni o riavvii applicativi (al più una cache invalidation esplicita).

### 4.5 Localizzazione (IT/EN)

**Descrizione:** Tutte le pagine pubbliche sono disponibili in italiano e inglese.

**Functional Requirements:**

#### FR-15: Rendering multilingua via prefisso URL
Tutte le Pagine pubbliche sono renderizzate in italiano e inglese tramite prefisso Locale nell'URL.

**Consequences (testable):**
- Ogni Pagina pubblica è raggiungibile sia su `/it/{slug}` sia su `/en/{slug}` e restituisce contenuto nella lingua corrispondente.
- Un URL senza prefisso Locale valido effettua redirect al Locale di default o a quello rilevato dal browser.

#### FR-16: Selettore di lingua
Un selettore di Locale permette di cambiare lingua su qualsiasi pagina.

**Consequences (testable):**
- Cambiare Locale dal selettore mantiene l'utente sulla stessa Pagina pubblica (stesso slug), non riporta alla home.

#### FR-17: Nessuna stringa hardcoded
Tutte le stringhe dell'interfaccia sono tradotte, nessun testo hardcoded nel codice.

**Consequences (testable):**
- Un audit a campione delle view del tema Meetup non trova stringhe utente-visibili al di fuori delle chiavi di traduzione `trans('pub_theme::*')`.

### 4.6 Qualità e Conformità

**Descrizione:** Requisiti trasversali di conformità legale e accessibilità, condizione necessaria per un rilascio pubblico credibile (sia come prodotto sia come vetrina tecnica).

**Functional Requirements:**

#### FR-18: Cookie consent
Il consenso ai cookie è raccolto prima di impostare cookie non essenziali.

**Consequences (testable):**
- Nessun cookie non essenziale (analytics, marketing) viene impostato prima che l'utente dia consenso esplicito tramite il banner.

#### FR-19: Accessibilità WCAG 2.1 AA
Le Pagine pubbliche rispettano lo standard WCAG 2.1 AA.

**Consequences (testable):**
- Le pagine Home, Eventi (lista) ed Evento (dettaglio) — i percorsi critici di UJ-1/UJ-2 — passano un audit automatico (es. axe-core o Lighthouse Accessibility) senza violazioni di livello A o AA. [ASSUMPTION: lo strumento e la soglia numerica esatti (es. punteggio Lighthouse minimo) sono da fissare in fase tecnica; qui si vincola solo l'ambito pagine e il metodo di verifica.]

#### FR-20: SEO metadata
Ogni Pagina pubblica ha title, meta description e canonical URL.

**Consequences (testable):**
- Ogni Pagina pubblica ha un `<title>` univoco, una meta description non vuota e un tag `<link rel="canonical">` che punta all'URL localizzato corrente.

#### FR-21: Dati strutturati Evento
Ogni pagina di dettaglio Evento include dati strutturati JSON-LD.

**Consequences (testable):**
- Ogni pagina di dettaglio Evento include un blocco `<script type="application/ld+json">` con schema.org `Event` valido (nome, data, luogo) verificabile con lo strumento di test dei rich result.

## 5. Non-Goal Espliciti

- Non costruiamo un sistema di pagamento/biglietteria in v1 (Stripe/Apple Pay, rimandato a v2) **né la fatturazione/ricevute automatiche associate (v2 PAYM-02)** — costo accettato: nessun evento a pagamento è organizzabile tramite la piattaforma finché v2 non è consegnato.
- Non costruiamo profili utente pubblici con storico partecipazioni in v1 — costo accettato: nessuna visibilità sociale delle proprie iscrizioni passate, coerente con la scelta di tenere la registrazione a basso attrito (§2.1) invece che arricchire il profilo.
- Non costruiamo chat in tempo reale, app native, live streaming o login OAuth esterno in v1 — vedi `.planning/REQUIREMENTS.md` per il razionale di ciascuna esclusione.
- Non diventiamo una piattaforma di eventi generica multi-categoria: restiamo scoped a meetup tecnici, con focus Laravel/community italiana — costo accettato: rinunciamo a un mercato più ampio in cambio di una identità di prodotto chiara e coerente con lo scopo vetrina (§1).

## 6. Scope MVP

### 6.1 In Scope

- Amministrazione Eventi/Sedi/Relatori/Sponsor/Iscrizioni via Filament (FR-1 – FR-4)
- Scoperta pubblica Eventi con filtro città/data (FR-5 – FR-8)
- Iscrizione con conferma email e limite capienza (FR-9 – FR-11)
- Pagine pubbliche CMS-driven da JSON (FR-12 – FR-14)
- Localizzazione IT/EN completa (FR-15 – FR-17)
- Conformità: cookie consent, WCAG 2.1 AA, SEO/JSON-LD (FR-18 – FR-21)

### 6.2 Out of Scope per MVP

- Pagamenti/biglietti a pagamento (Stripe/Apple Pay) — v2.
- Profili utente con storico partecipazioni, profili pubblici Relatori — v2. [NOTE FOR PM: se un meetup partner chiede profili pubblici prima del previsto, va rivalutato — è il tipo di richiesta community-driven che può accelerare la priorità.]
- Chat in tempo reale, app native, live streaming, OAuth esterno — esclusi esplicitamente, nessun piano di v2 noto.

## 7. Success Metrics

**Primary**
- **SM-1**: Almeno un meetup Laravel italiano reale pubblica e gestisce un Evento end-to-end (pubblicazione → iscrizioni → partecipazione) entro 3-6 mesi dal rilascio. Valida FR-1, FR-9, FR-11.
- **SM-2**: Il repository riceve interesse esterno misurabile (star, fork, o almeno una issue/PR da contributore non affiliato al team originale) entro 6 mesi. Valida la Visione (nessun FR diretto — obiettivo di prodotto trasversale).

**Secondary**
- **SM-3**: Tutti i requisiti FR-1 – FR-21 completati e verificati (da `.planning/REQUIREMENTS.md`).
- **SM-4** [ASSUMPTION]: PHPStan livello 10 a zero errori e copertura test Pest mantenuta secondo l'obiettivo Track B di `.planning/PROJECT.md`, come precondizione di credibilità per SM-2.

**Counter-metrics (da non ottimizzare)**
- **SM-C1**: Non ottimizzare il numero di Pagine CMS o Blocchi di contenuto come proxy di attività — contenuti duplicati o superflui degradano l'esperienza di scoperta Eventi (SM-1) senza guadagno reale. Contrappesa SM-3.

## 8. Domande Aperte

1. Chi possiede/gestisce operativamente il primo meetup pilota reale (SM-1) — è già identificato un gruppo Laravel italiano disponibile a fare da early adopter?
2. Qual è il piano di deploy/hosting per il primo rilascio pubblico (oggi `APP_URL` è ancora locale)? Non è nello scope di questo PRD di prodotto ma blocca SM-1/SM-2.
3. Chi modera/approva le Iscrizioni in caso di abuso (email fasulle, spam)? Non coperto da FR-9/FR-10 così come definiti.

## 9. Indice delle Assunzioni

- §2.1 — Lo sviluppatore Laravel esterno è incluso come JTBD secondario, coerente col brief ma non confermato esplicitamente dall'utente in questa sessione. *(Confermata dall'utente il 2026-07-07.)*
- §2.1 — L'organizzatore di altri meetup tech è incluso come utente terziario, ripreso dal brief, non confermato esplicitamente in questa sessione.
- §2.3 (UJ-3) — Il journey del contributore esterno è stato aggiunto per coerenza con lo scopo "vetrina", non confermato esplicitamente. *(Confermata dall'utente il 2026-07-07; marcato esplicitamente come non load-bearing per nessun FR.)*
- §4.1 (FR-4) — L'esportazione della lista iscritti è un'estensione rispetto al requisito originale ADMN-04, da confermare prima dello sviluppo.
- §4.6 (FR-19) — Lo strumento di audit accessibilità e la soglia numerica esatta sono da fissare in fase tecnica; qui si vincola solo l'ambito pagine (Home, Eventi, Evento) e il metodo (audit automatico).
- §7 (SM-4) — Il mantenimento degli standard di qualità tecnica (PHPStan L10, coverage) è trattato come precondizione di credibilità per la vetrina, ripreso dal brief. *(Confermata dall'utente il 2026-07-07.)*
