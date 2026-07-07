---
stepsCompleted: [1, 2, 3, 4]
inputDocuments:
  - _bmad-output/planning-artifacts/prds/prd-laravelpizza.com-2026-07-07/prd.md
  - _bmad-output/planning-artifacts/architecture/architecture-laravelpizza.com-2026-07-07/ARCHITECTURE-SPINE.md
  - _bmad-output/planning-artifacts/ux-designs/ux-laravelpizza.com-2026-07-07/DESIGN.md
  - _bmad-output/planning-artifacts/ux-designs/ux-laravelpizza.com-2026-07-07/EXPERIENCE.md
---

# LaravelPizza.com - Epic Breakdown

## Overview

This document provides the complete epic and story breakdown for LaravelPizza.com, decomposing the requirements from the PRD, UX Design (DESIGN.md + EXPERIENCE.md), and Architecture Spine into implementable stories.

## Requirements Inventory

### Functional Requirements

FR-1: L'Amministratore può creare, modificare ed eliminare un Evento (data, sede, relatori, sponsor, capienza).
FR-2: L'Amministratore può creare, modificare ed eliminare Sedi, Relatori e Sponsor, e associarli a uno o più Eventi.
FR-3: L'Amministratore visualizza una dashboard con il numero di Eventi programmati/passati e le Iscrizioni per Evento.
FR-4: L'Amministratore può visualizzare e gestire la lista Iscrizioni per ciascun Evento (esportazione da confermare).
FR-5: Il Visitatore può sfogliare gli Eventi futuri senza autenticazione.
FR-6: Il Visitatore può consultare l'elenco degli Eventi passati.
FR-7: Il Visitatore può visualizzare la pagina di dettaglio di un Evento con tutti i metadati.
FR-8: Il Visitatore può filtrare gli Eventi per città o data.
FR-9: Il Visitatore può iscriversi a un Evento fornendo email e password valide, diventando Utente.
FR-10: L'Utente riceve un'email di conferma immediatamente dopo l'Iscrizione.
FR-11: Il sistema impedisce Iscrizioni oltre la Capienza massima dell'Evento (già implementato).
FR-12: Le Pagine pubbliche sono renderizzate a partire da file JSON di contenuto.
FR-13: I Blocchi di contenuto supportano testo, immagini e liste di Eventi.
FR-14: Le Pagine CMS possono essere aggiornate modificando il JSON, senza deploy.
FR-15: Tutte le Pagine pubbliche sono renderizzate in italiano e inglese tramite prefisso Locale nell'URL.
FR-16: Un selettore di Locale permette di cambiare lingua su qualsiasi pagina.
FR-17: Tutte le stringhe dell'interfaccia sono tradotte, nessun testo hardcoded.
FR-18: Il consenso ai cookie è raccolto prima di impostare cookie non essenziali.
FR-19: Le Pagine pubbliche rispettano lo standard WCAG 2.1 AA (Home, Eventi, Dettaglio Evento).
FR-20: Ogni Pagina pubblica ha title, meta description e canonical URL.
FR-21: Ogni pagina di dettaglio Evento include dati strutturati JSON-LD (schema.org Event).

### NonFunctional Requirements

Il PRD non ha una sezione NFR separata: i requisiti di qualità/conformità sono già formalizzati come FR-18–21 (cookie consent, accessibilità, SEO, dati strutturati). I seguenti vincoli trasversali emergono dal PRD e dallo Spine architetturale come requisiti non funzionali impliciti:

NFR1: Ogni invariante di business (es. capienza massima) ha un solo punto autorevole di verifica nel codice (Architecture AD-3) — requisito di manutenibilità/coerenza.
NFR2: Nessuna interazione critica dipende solo da hover; navigazione da tastiera completa su tutti i flussi pubblici (EXPERIENCE.md, Accessibility Floor) — requisito di accessibilità trasversale a FR-19.
NFR3: Light e dark mode sono a pari livello su ogni superficie pubblica (DESIGN.md/EXPERIENCE.md, Foundation) — requisito di UX trasversale.
NFR4: PHPStan livello 10 zero errori mantenuto (da CLAUDE.md / SM-4 del PRD) — gate di qualità continuo, non solo al rilascio.

### Additional Requirements

Dallo Spine architetturale (brownfield, nessun starter template — il progetto esiste già):

- AD-1: ogni nuova pagina pubblica è JSON + Blade component in `Themes/Meetup/resources/views/components/blocks/`; mai un controller o route in `web.php`.
- AD-2: ogni nuova Resource/Page/Widget/Filament estende l'equivalente `XotBase*`, mai la classe Filament nativa.
- AD-3: ogni mutazione di stato passa da una `Action` (`Spatie\QueueableAction`); un solo metodo autorevole per invariante (es. `Event::isFull()`); vietato `$record->update()` diretto su entità con invarianti (Event, EventUser/Iscrizione) anche da Filament.
- AD-4: rispettare la direzione di dipendenza tra moduli (Meetup → Xot/User/Activity/Gdpr; mai il contrario; moduli di supporto → solo Xot).
- AD-5: qualunque UI di editing dei content block CMS deve introdurre nella stessa PR un registry/whitelist dei tipi di blocco ammessi (non deferrabile "in un secondo momento").
- AD-6: login/registrazione restano su widget Filament custom, mai un package di scaffolding auth standard.
- AD-7: risoluzione tenant solo in `TenantServiceProvider::boot()`; job/comandi in coda ricevono il tenant esplicitamente al dispatch, non lo ri-derivano.
- AD-8: una tabella, una migrazione di creazione; modifiche successive come migrazioni `add_{column}_to_{table}`.
- AD-9: il tema pubblico si ricava sempre dalla catena APP_URL → tenant → `pub_theme`; mai `Themes\Meetup` hardcoded.
- Deferred noto ma bloccante per lo sviluppo pulito: 174 file con conflitti Git committati in `origin/dev` (commit `c6b3499c5`) vanno risolti prima o durante il lavoro sui moduli che li toccano — non è un requisito di prodotto ma un prerequisito tecnico per alcune epic (in particolare quelle che toccano `Xot`/`Cms`/Filament Resources).

### UX Design Requirements

UX-DR1: Sistema di token colore a 3 scale semantiche (primary/rosso, secondary/ambra, accent/verde) da usare coerentemente su CTA, badge e stati — nessuna quarta famiglia di colore saturo senza revisione di DESIGN.md.
UX-DR2: Componente `event-card` riusabile (titolo, data, Sede, badge stato, CTA "Vedi dettagli", intera card cliccabile).
UX-DR3: Componenti `button-primary`/`button-secondary` standardizzati; un solo `button-primary` per schermata.
UX-DR4: Componente `form-section` per il form di Iscrizione (email+password, validazione inline, non a step).
UX-DR5: Badge Capienza a 3 stati visivi (disponibile/verde, pochi posti/ambra con soglia da definire, esaurito/rosso con CTA disabilitata).
UX-DR6: Stato di conferma inline immediato dopo l'Iscrizione riuscita (prima ancora dell'arrivo dell'email).
UX-DR7: Gestione esplicita dello stato "lista Eventi vuota" dopo filtro (messaggio + CTA per rimuovere il filtro, mai lista vuota senza spiegazione).
UX-DR8: Gestione della race condition di Capienza esaurita durante la compilazione del form (errore prima del falso "riuscito").
UX-DR9: Dark mode di prima classe su ogni superficie pubblica, non solo light mode.
UX-DR10: Focus-visible da tastiera (blu, `{colors.focus-ring}`) mantenuto su ogni elemento interattivo in entrambe le modalità.
UX-DR11: Cambio lingua dal selettore mantiene l'utente sulla stessa pagina/Evento, non riporta alla Home.
UX-DR12: Tono dei microcopy funzionali (CTA, stati, errori) diretto e concreto, mai allarmistico o da marketing aggressivo (coerente con la scelta "energico ma credibile per developer").

### FR Coverage Map

FR-1: Epic 1 - Creazione/gestione Evento
FR-2: Epic 1 - Gestione Sedi/Relatori/Sponsor
FR-3: Epic 1 - Dashboard statistiche
FR-4: Epic 1 - Gestione Iscrizioni/liste
FR-5: Epic 2 - Lista Eventi futuri
FR-6: Epic 2 - Lista Eventi passati
FR-7: Epic 2 - Dettaglio Evento
FR-8: Epic 2 - Ricerca/filtro Eventi
FR-9: Epic 3 - Iscrizione con email valida
FR-10: Epic 3 - Conferma email immediata
FR-11: Epic 3 - Prevenzione sovra-iscrizione
FR-12: Epic 4 - Rendering pagine da JSON
FR-13: Epic 4 - Blocchi di contenuto multi-tipo
FR-14: Epic 4 - Aggiornamento senza deploy
FR-15: Epic 5 - Rendering multilingua via URL
FR-16: Epic 5 - Selettore di lingua
FR-17: Epic 5 - Nessuna stringa hardcoded
FR-18: Epic 6 - Cookie consent
FR-19: Epic 6 - Accessibilità WCAG 2.1 AA
FR-20: Epic 6 - SEO metadata
FR-21: Epic 6 - Dati strutturati Evento

## Epic List

### Epic 1: Gestione Eventi (Admin)
Un Organizzatore può gestire in autonomia l'intero ciclo di vita di un Evento — crearlo con Sede/Relatori/Sponsor/Capienza, monitorarne lo stato tramite dashboard, e gestire le Iscrizioni — interamente tramite il pannello Filament.
**FRs covered:** FR-1, FR-2, FR-3, FR-4
**Note implementative:** Architecture AD-2 (XotBase obbligatorio), AD-3 (Action per ogni mutazione, no `$record->update()` diretto su Event). Non dipende da altri epic.

### Epic 2: Scoperta Pubblica Eventi
Un Visitatore può sfogliare, filtrare e consultare il dettaglio di qualunque Evento pubblicato, senza autenticazione.
**FRs covered:** FR-5, FR-6, FR-7, FR-8
**Note implementative:** Architecture AD-1 (Folio+Volt, no controller). UX-DR2 (`event-card`), UX-DR7 (stato lista vuota). Dipende dall'esistenza di Eventi pubblicati (Epic 1), ma è funzionalmente completo da solo (un Evento può esistere via seed/fixture per testarlo).

### Epic 3: Iscrizione a un Evento
Un Visitatore può iscriversi a un Evento con email e password, ricevere conferma immediata, e il sistema impedisce l'iscrizione oltre la Capienza massima.
**FRs covered:** FR-9, FR-10, FR-11
**Note implementative:** Architecture AD-3 (single-owner invariant su `Event::isFull()`), AD-6 (auth custom). UX-DR4 (`form-section`), UX-DR5 (badge Capienza), UX-DR6 (conferma inline), UX-DR8 (race condition Capienza). Si appoggia a Epic 2 per il punto di ingresso (Dettaglio Evento), ma la capacità di iscriversi è completa e testabile in autonomia.

### Epic 4: Pagine Pubbliche CMS-Driven
Chiunque gestisca i contenuti del sito (Home, About, Contatti, Termini, Privacy) può pubblicare/aggiornare queste pagine modificando un file JSON, senza richiedere un deploy applicativo.
**FRs covered:** FR-12, FR-13, FR-14
**Note implementative:** Architecture AD-5 (JSON come trusted input, gate esplicito se in futuro editabile da UI). Dominio distinto da Epic 2 (Modulo Cms vs Modulo Meetup), pur condividendo l'infrastruttura Folio+Volt di Epic 1/AD-1.

### Epic 5: Localizzazione IT/EN
Un Visitatore può usare l'intero sito pubblico (pagine CMS ed Eventi) in italiano o inglese, cambiando lingua in qualunque momento senza perdere il contesto della pagina corrente.
**FRs covered:** FR-15, FR-16, FR-17
**Note implementative:** UX-DR11 (cambio lingua mantiene il contesto pagina). Si applica trasversalmente a Epic 2 e Epic 4 già costruiti — richiede che quelle pagine esistano, ma la capacità di localizzazione è un'unità di valore autonoma e verificabile (URL con prefisso locale, selettore, assenza di stringhe hardcoded).

### Epic 6: Conformità e Qualità per il Lancio
Il sito pubblico rispetta i requisiti minimi per un rilascio pubblico credibile: consenso cookie, accessibilità WCAG 2.1 AA sulle pagine critiche, metadati SEO e dati strutturati per gli Eventi.
**FRs covered:** FR-18, FR-19, FR-20, FR-21
**Note implementative:** NFR2 (accessibilità da tastiera), UX-DR10 (focus-visible). Ultimo gate prima del rilascio pubblico, coerente con SM-1/SM-2 del PRD.

## Epic 1: Gestione Eventi (Admin)

Un Organizzatore può gestire in autonomia l'intero ciclo di vita di un Evento — crearlo con Sede/Relatori/Sponsor/Capienza, monitorarne lo stato tramite dashboard, e gestire le Iscrizioni — interamente tramite il pannello Filament.

### Story 1.1: Creazione e gestione Evento

As a Organizzatore,
I want creare, modificare ed eliminare un Evento con data, sede, relatori, sponsor e capienza,
So that posso pubblicare rapidamente un nuovo meetup senza intervento tecnico.

**Acceptance Criteria:**

**Given** sono autenticato come Organizzatore nel pannello Filament
**When** compilo il form di creazione Evento senza specificare la Capienza
**Then** il sistema impedisce il salvataggio/pubblicazione e mostra un errore esplicito (FR-1)

**Given** un Evento esiste con Iscrizioni attive
**When** tento di eliminarlo
**Then** il sistema richiede una conferma esplicita prima di procedere (FR-1)
**And** la Resource Filament estende `XotBaseResource` (Architecture AD-2) e ogni mutazione passa da un'Action (Architecture AD-3), mai `$record->update()` diretto

### Story 1.2: Gestione Sedi, Relatori e Sponsor

As a Organizzatore,
I want creare, modificare ed eliminare Sedi, Relatori e Sponsor e associarli a uno o più Eventi,
So that posso riutilizzare le stesse anagrafiche su più edizioni del meetup.

**Acceptance Criteria:**

**Given** una Sede, un Relatore o uno Sponsor è associato a un Evento futuro
**When** tento di eliminarlo
**Then** il sistema richiede conferma esplicita o blocca l'eliminazione (FR-2)

**Given** sono nel form di un Evento
**When** seleziono più Sponsor e più Relatori
**Then** posso associarli tutti contemporaneamente allo stesso Evento (FR-2)

### Story 1.3: Dashboard statistiche Eventi

As a Organizzatore,
I want vedere una dashboard con il numero di Eventi programmati/passati e le Iscrizioni per Evento,
So that ho visibilità immediata sullo stato della community senza consultare tabelle separate.

**Acceptance Criteria:**

**Given** esistono Eventi futuri e passati con Iscrizioni
**When** apro la dashboard
**Then** vedo almeno: numero Eventi futuri, numero Eventi passati, numero Iscrizioni totali per Evento futuro (FR-3)
**And** i dati riflettono lo stato del database al momento del caricamento, senza cache stantia oltre la durata della request

### Story 1.4: Gestione Iscrizioni e liste iscritti

As a Organizzatore,
I want visualizzare e gestire la lista delle Iscrizioni per ciascun Evento,
So that so chi parteciperà e posso organizzarmi di conseguenza.

**Acceptance Criteria:**

**Given** un Evento ha delle Iscrizioni
**When** apro la vista Iscrizioni di quell'Evento
**Then** vedo la lista completa con stato (confermata/in attesa) per ciascun iscritto (FR-4)
**And** [ASSUMPTION dal PRD FR-4] se l'esportazione (es. CSV) è richiesta, va confermata come estensione esplicita prima dello sviluppo — non è nel requisito originale ADMN-04

## Epic 2: Scoperta Pubblica Eventi

Un Visitatore può sfogliare, filtrare e consultare il dettaglio di qualunque Evento pubblicato, senza autenticazione.

### Story 2.1: Lista Eventi futuri

As a Visitatore,
I want sfogliare gli Eventi futuri senza dover creare un account,
So that posso valutare rapidamente se partecipare a un meetup.

**Acceptance Criteria:**

**Given** non sono autenticato
**When** visito la pagina Eventi
**Then** vedo la lista degli Eventi futuri ordinati per data crescente, senza redirect a una pagina di login (FR-5)
**And** ogni Evento è mostrato tramite il componente `event-card` (UX-DR2), interamente cliccabile verso il Dettaglio

### Story 2.2: Lista Eventi passati

As a Visitatore,
I want consultare l'elenco degli Eventi passati,
So that posso farmi un'idea della storia e continuità della community prima di partecipare.

**Acceptance Criteria:**

**Given** esistono Eventi con data nel passato
**When** consulto la sezione Eventi passati
**Then** sono ordinati per data decrescente e non mostrano una CTA di iscrizione attiva (FR-6)

### Story 2.3: Dettaglio Evento

As a Visitatore,
I want vedere tutti i metadati di un Evento (Sede, Relatori, Sponsor, Capienza residua),
So that posso decidere con sicurezza se partecipare.

**Acceptance Criteria:**

**Given** un Evento pubblicato esiste
**When** apro la sua pagina di dettaglio
**Then** vedo Sede, Relatori, Sponsor e la Capienza residua calcolata in tempo reale (Capienza totale − Iscrizioni confermate) (FR-7)
**And** se l'Evento non esiste o non è pubblicato, la pagina restituisce 404

### Story 2.4: Ricerca/filtro Eventi per città o data

As a Visitatore,
I want filtrare gli Eventi per città o data,
So that trovo rapidamente solo i meetup rilevanti per me.

**Acceptance Criteria:**

**Given** sono sulla lista Eventi
**When** applico un filtro per città
**Then** vedo solo gli Eventi la cui Sede è in quella città (FR-8)

**Given** un filtro non produce risultati
**When** la lista è vuota
**Then** vedo un messaggio esplicito con una CTA per rimuovere il filtro, mai una lista vuota senza spiegazione (UX-DR7)

## Epic 3: Iscrizione a un Evento

Un Visitatore può iscriversi a un Evento con email e password, ricevere conferma immediata, e il sistema impedisce l'iscrizione oltre la Capienza massima.

### Story 3.1: Iscrizione con email e password

As a Visitatore,
I want iscrivermi a un Evento fornendo solo email e password,
So that partecipo senza dover compilare un profilo complesso.

**Acceptance Criteria:**

**Given** sono sulla pagina di Dettaglio Evento con posti disponibili
**When** compilo il form di Iscrizione (`form-section`, UX-DR4) con email e password valide
**Then** divento un Utente e l'Iscrizione viene registrata (FR-9)
**And** non mi vengono richiesti campi aggiuntivi obbligatori, coerente con il requisito di minimo attrito

**Given** inserisco un'email non valida o già registrata senza la password corrispondente
**When** invio il form
**Then** ricevo un messaggio d'errore chiaro (FR-9)

### Story 3.2: Conferma email immediata

As a Utente,
I want ricevere conferma immediata della mia Iscrizione,
So that sono sicuro che la mia partecipazione sia stata registrata.

**Acceptance Criteria:**

**Given** ho completato un'Iscrizione
**When** il form viene inviato con successo
**Then** vedo uno stato di conferma inline immediato, prima ancora dell'arrivo dell'email (UX-DR6)
**And** ricevo un'email di conferma entro pochi secondi con almeno nome Evento, data, Sede (FR-10)

### Story 3.3: Prevenzione sovra-iscrizione

As a Organizzatore,
I want che il sistema impedisca automaticamente le Iscrizioni oltre la Capienza massima,
So that non mi ritrovo con più partecipanti di quanti la Sede possa ospitare.

**Acceptance Criteria:**

**Given** un Evento ha raggiunto la Capienza massima
**When** un Visitatore tenta di iscriversi
**Then** il tentativo viene rifiutato con un messaggio d'errore prima del salvataggio, non dopo (FR-11, già implementato in `RegisterAttendeeToEventAction`)

**Given** la Capienza si esaurisce mentre un Visitatore sta compilando il form (race condition)
**When** invia il form
**Then** vede l'errore prima di un eventuale redirect di successo, mai un falso "riuscito" (UX-DR8)
**And** la verifica passa sempre dal metodo autorevole unico `Event::isFull()` (Architecture AD-3), mai ricalcolata localmente

## Epic 4: Pagine Pubbliche CMS-Driven

Chiunque gestisca i contenuti del sito può pubblicare/aggiornare pagine pubbliche modificando un file JSON, senza deploy.

### Story 4.1: Rendering pagina pubblica da JSON

As a Visitatore,
I want vedere pagine come Home, About, Contatti renderizzate correttamente,
So that posso conoscere la community senza che il sito sembri incompleto.

**Acceptance Criteria:**

**Given** esiste un file JSON di contenuto per una Pagina pubblica
**When** visito il suo slug
**Then** la pagina è renderizzata a partire da quel JSON (FR-12)
**And** ogni Pagina pubblica ha un file JSON corrispondente in `config/local/{tenant}/database/content/pages/`, mai un Blade dedicato con contenuto hardcoded (Architecture AD-1)

### Story 4.2: Blocchi di contenuto multi-tipo

As a chi gestisce i contenuti,
I want comporre una pagina con blocchi di tipo diverso (hero, features, lista eventi),
So that posso costruire pagine ricche senza scrivere codice.

**Acceptance Criteria:**

**Given** un content block JSON dichiara un `type` (es. `hero`, `features`, `events-list`)
**When** la pagina viene renderizzata
**Then** il blocco usa il componente Blade corrispondente in `Themes/Meetup/resources/views/components/blocks/` (FR-13)
**And** se in futuro un'interfaccia admin permette di editare il campo `view`/type, la stessa PR introduce un registry/whitelist dei tipi ammessi (Architecture AD-5 — non deferrabile)

### Story 4.3: Aggiornamento pagina senza deploy

As a chi gestisce i contenuti,
I want modificare il JSON di una pagina e vederla aggiornata immediatamente,
So that non dipendo da un ciclo di deploy per correggere un testo o un'immagine.

**Acceptance Criteria:**

**Given** modifico il file JSON di una Pagina pubblica esistente
**When** ricarico la pagina pubblica
**Then** vedo il contenuto aggiornato senza build, migrazioni o riavvii applicativi, al più con un'invalidazione esplicita della cache (FR-14)

## Epic 5: Localizzazione IT/EN

Un Visitatore può usare l'intero sito pubblico in italiano o inglese, cambiando lingua senza perdere il contesto della pagina corrente.

### Story 5.1: Rendering multilingua via prefisso URL

As a Visitatore,
I want accedere a qualunque pagina pubblica sia in italiano sia in inglese,
So that posso usare il sito nella lingua che preferisco.

**Acceptance Criteria:**

**Given** una Pagina pubblica esiste
**When** la visito su `/it/{slug}` e su `/en/{slug}`
**Then** ricevo il contenuto nella lingua corrispondente (FR-15)

**Given** visito un URL senza prefisso Locale valido
**When** la pagina viene risolta
**Then** vengo reindirizzato al Locale di default o a quello rilevato dal browser (FR-15)

### Story 5.2: Selettore di lingua

As a Visitatore,
I want cambiare lingua da qualunque pagina tramite un selettore,
So that non devo ricominciare la navigazione da capo per cambiare lingua.

**Acceptance Criteria:**

**Given** sono su una pagina di Dettaglio Evento in italiano
**When** cambio lingua dal selettore
**Then** resto sulla stessa pagina/Evento, ora in inglese, senza tornare alla Home (FR-16, UX-DR11)

### Story 5.3: Audit e completamento traduzioni

As a Visitatore,
I want che ogni testo dell'interfaccia sia tradotto,
So that non incontro mai un testo nella lingua sbagliata durante la navigazione.

**Acceptance Criteria:**

**Given** navigo le view pubbliche del tema Meetup
**When** verifico le stringhe visibili
**Then** non trovo testo hardcoded al di fuori delle chiavi `trans('pub_theme::*')` (FR-17)

## Epic 6: Conformità e Qualità per il Lancio

Il sito pubblico rispetta i requisiti minimi per un rilascio pubblico credibile.

### Story 6.1: Cookie consent

As a Visitatore,
I want essere informato e poter scegliere prima che vengano impostati cookie non essenziali,
So that la mia privacy è rispettata fin dal primo accesso.

**Acceptance Criteria:**

**Given** visito il sito per la prima volta
**When** la pagina si carica
**Then** nessun cookie non essenziale (analytics, marketing) viene impostato prima che io dia consenso esplicito tramite banner (FR-18)

### Story 6.2: Accessibilità WCAG 2.1 AA sulle pagine critiche

As a Visitatore che usa tecnologie assistive,
I want che le pagine principali siano navigabili con screen reader e tastiera,
So that posso usare il sito indipendentemente dalle mie capacità.

**Acceptance Criteria:**

**Given** le pagine Home, Eventi (lista) ed Evento (dettaglio)
**When** vengono sottoposte ad audit automatico (es. axe-core/Lighthouse Accessibility)
**Then** non emergono violazioni di livello A o AA (FR-19)
**And** la navigazione da tastiera con focus-visible (`{colors.focus-ring}`) funziona su ogni elemento interattivo, in light e dark mode (UX-DR10, NFR2)

### Story 6.3: SEO metadata

As a Visitatore che arriva da un motore di ricerca,
I want che ogni pagina abbia titolo e descrizione chiari nei risultati di ricerca,
So that capisco cosa aspettarmi prima di cliccare.

**Acceptance Criteria:**

**Given** qualunque Pagina pubblica
**When** ne ispeziono l'head HTML
**Then** trovo un `<title>` univoco, una meta description non vuota e un `<link rel="canonical">` verso l'URL localizzato corrente (FR-20)

### Story 6.4: Dati strutturati Evento (JSON-LD)

As a Visitatore che arriva da un motore di ricerca,
I want che gli Eventi appaiano con informazioni ricche nei risultati di ricerca,
So that riconosco subito data e luogo prima di cliccare.

**Acceptance Criteria:**

**Given** una pagina di Dettaglio Evento
**When** ne ispeziono il markup
**Then** trovo un blocco `<script type="application/ld+json">` con schema.org `Event` valido (nome, data, luogo), verificabile con lo strumento di test dei rich result (FR-21)
**Note implementative:** NFR2 (accessibilità da tastiera), UX-DR10 (focus-visible). Si applica alle superfici pubbliche costruite negli epic precedenti (Epic 2, 4) — è l'ultimo gate prima che il sito sia presentabile pubblicamente, coerente con SM-1/SM-2 del PRD.
