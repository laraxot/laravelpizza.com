# Recensioni siti/app Folio + Volt (Tema Meetup)

## Scopo

Questo documento raccoglie **case study reali** di applicazioni costruite con **Laravel Folio + Livewire Volt** e li guarda dal punto di vista **UI/UX e tema** per Laravel Pizza Meetups.

---

## 1. Todo Application (Nuno Maduro / thinkverse)

- **Cosa è**: semplice app TODO (lista + aggiunta task) costruita con Folio + Volt.
- **Perché è interessante per il tema**:
  - Layout minimale, focus sui contenuti → perfetto per pagine funzionali (dashboard, settings).
  - Struttura molto chiara di pagina unica con componente Volt interno.

### Pattern UI rilevanti

- Lista centrale con card/todo molto semplici.
- Form inline per aggiungere un elemento (input + bottone) sopra la lista.
- Stato visivo immediato (todo completato/non completato) con piccole variazioni di stile.

### Idee riusabili per il tema Meetup

- Layout della sezione "Quick Actions" o "My Tasks" nella dashboard.
- Gestione di piccole liste personali (es. interessi, note, to‑do community) senza complicare l'interfaccia.

---

## 2. Multi‑Step Form (Neon – Volt + Folio + Postgres)

- **Cosa è**: form di candidatura multi‑step con più pagine Folio e componenti Volt per ogni step.
- **Focus UI/UX**:
  - Layout pulito, centrato, con progress indicator chiaro.
  - Ogni step concentra l'attenzione su pochi campi.

### Pattern UI rilevanti

- Barra o breadcrumb degli step (Personal → Education → Work → Review).
- Bottoni "Next"/"Back" sempre nella stessa posizione, con stato disabilitato se il form non è valido.
- Messaggi di validazione vicini al campo, integrati nello stile.

### Idee riusabili per il tema Meetup

- Wizard di **registrazione avanzata** (step su profilo, interessi, città, stack).
- Wizard per **creare un evento** con esperienza guidata e coerente con il design dark del tema.

---

## 3. Podcast / Episodi (Jason Beggs – Laravel News Example)

- **Cosa è**: sito demo con lista episodi, pagina dettaglio e player audio.
- **Perché è interessante**:
  - Organizza molto bene contenuto "a lista" (episodi) + dettaglio.
  - Mostra come integrare componenti JS (player) in un layout Folio + Volt.

### Pattern UI rilevanti

- Listing di card episodi con:
  - titolo
  - durata / numero episodio
  - breve descrizione
- Pagina dettaglio con player principale in alto e contenuto testuale sotto.

### Idee riusabili per il tema Meetup

- Pagina **Event Detail** con hero in alto (titolo evento, data, CTA "Register"), e dettagli/descrizione sotto.
- Possibile futura pagina "Talks/Recordings" per meetup passati, con player audio/video.

---

## 4. Product Management App (Pedro Souza – Medium)

- **Cosa è**: CRUD prodotti con lista e form nella stessa pagina Folio.
- **Aspetti di UI interessanti**:
  - Tabella simple, con colonne chiare e pulsante "Add" evidenziato.
  - Form semplice posizionato sopra o a lato della lista.

### Pattern UI rilevanti

- Layout a due sezioni: form + tabella.
- Feedback immediato dopo l'azione (aggiunta prodotto) senza ricaricare la pagina.

### Idee riusabili per il tema Meetup

- Gestione/elenco di **luoghi** dei meetup o **categorie** nel backoffice UI/Filament, con pattern visivo simile.
- Pagine "profilo organizzatore" con tabella eventi organizzati.

---

## 5. Considerazioni generali per il tema Laravel Pizza Meetups

- Gli esempi confermano che **Folio + Volt** funzionano molto bene con layout:
  - semplici
  - fortemente orientati ai contenuti
  - con uno o pochi componenti reattivi ben visibili (form, player, lista dinamica).
- Per il **tema Meetup** questo significa:
  - mantenere Blade + Tailwind per la struttura di base (hero, sezioni, footer, nav).
  - usare Volt dove servono **azioni dell'utente in tempo reale** (login, registrazione evento, chat, dashboard, multi‑step forms).

Queste recensioni completano le linee guida tecniche in `folio-volt-best-practices.md` e aiutano a prendere decisioni di design concrete per le pagine future (dashboard, profile, event detail, forms guidati).

---

## 6. Genesis starter kit (DevDojo) – focus tema

- **Cosa è**: uno starter kit TALL (Tailwind, Alpine, Laravel, Livewire) che integra **Folio + Volt** e fornisce già:
  - home marketing,
  - pagina `about`,
  - flusso auth completo (login, register, reset/verify),
  - dashboard,
  - pagina profilo `profile/edit`,
  - pagina "learn" con documentazione.

### Pattern UI/UX rilevanti

- **Home marketing**
  - hero grande con call‑to‑action chiara,
  - sezioni a blocchi (benefit, feature, call‑to‑action secondaria).
- **Layout auth**
  - pagine login/register minimal, centrati, con card su sfondo scuro chiaro,
  - messaggi di errore/validazione integrati nel form.
- **Dashboard**
  - struttura pulita pronta per ospitare cards, tabelle e widget Livewire/Volt.
- **Profile edit**
  - sezioni distinte per dati profilo, password, cancellazione account.

### Idee riusabili per il tema Meetup

- Usare Genesis come **riferimento visivo** quando porteremo login, register, dashboard e profile da HTML statico a Folio + Volt:
  - mantenere una **home marketing** forte (come la nostra `index.html`) ma con la stessa chiarezza di Genesis.
  - per le **pagine auth**, replicare la semplicità di layout: card centrale, poche distrazioni, testo chiaro.
  - per **dashboard** e **profile**, seguire l'idea di layout modulare: blocchi separati (stats, eventi, impostazioni) che possono diventare componenti Volt o Filament.
- Conferma anche lato tema che la combinazione **Blade layout + Folio pages + Volt per le parti dinamiche** è uno standard de‑facto, che possiamo tranquillamente seguire per Laravel Pizza Meetups.

## 7. Warriorfolio 2 – focus tema/UI

- **Cosa è**: piattaforma portfolio + blog moderna costruita con **Laravel + Filament + Livewire + Tailwind + Alpine**.
- È pensata per creare siti personali/professionali con:
  - portfolio progetti,
  - blog,
  - pagine marketing,
  - gestione contenuti completamente via pannello Filament.

### Pattern UI/UX rilevanti

- **Saturn UI / Juno Theme**
  - interfacce moderne con molto uso di card, tab, e layout a colonne,
  - dark/light mode con inversione tema.
- **Portfolio gallery**
  - griglie di progetti con filtri rapidi e quick view,
  - focus su immagini di impatto e micro‑dettagli (tags, categoria, ruolo).
- **Blog & search**
  - layout leggibile (titolo grande, meta info, reading time),
  - ricerca veloce con debounce e filtri.
- **Dashboard/admin**
  - widgets, quickbar, accesso rapido a sezioni frequenti.

### Idee riusabili per il tema Meetup

- **Pagina eventi come portfolio**
  - usare la stessa logica di gallery per la pagina eventi: card evento con tag (città, tipo meetup, livello),
  - filtri rapidi in alto (città, data, tema),
  - eventuale quick view con info principali.
- **Blog meetup / articoli**
  - layout articoli ispirato al blog di Warriorfolio (grande tipografia, meta chiare), utile per recap meetup, annunci, guide.
- **Tema dark con accenti chiari**
  - molte scelte di Warriorfolio si sposano bene con il nostro stile dark rosso Laravel Pizza:
    - card con bordo/ombra leggera,
    - contenuti ben separati in sezioni,
    - uso consistente di icone e badge per evidenziare info.

Questi spunti, insieme a quelli di Genesis, ci danno una base solida per disegnare il tema Meetup come **ibrido tra landing marketing, portfolio eventi e blog di community**, con Filament che gestisce i contenuti e Folio + Volt che li espongono nel frontoffice.

## 8. Altri progetti Folio + Volt – UI/UX

- **Siti SaaS / dashboard**
  I template Folio+Volt orientati al B2B (b2bsaas*, mini‑CRM) mostrano dashboard con navigazione chiara, sidebar persistente e contenuti principali in card/tabelle. Questo si traduce bene nella futura dashboard Meetup (statistiche eventi, lista iscrizioni, quick actions).
- **Portfolio e siti personali**
  Progetti come GothamFolio confermano l'efficacia di layout a sezioni verticali (hero, about, skills, portfolio, contatti) con forte tipografia e uso di gradienti/ombre leggere. La pagina eventi può adottare la stessa logica, sostituendo i progetti con meetup.
- **Podcast / media**
  I player podcast Folio+Volt usano barre fisse (bottom bar) e componenti compatti per controlli play/pause, timeline, cover. Questo pattern è riusabile per eventuali "recent talks" o highlight multimediali di meetup.
- **Starter kit e boilerplate**
  Starter come vflat, starter nativephp, personalized starter kit mostrano come strutturare il tema con layout coerenti (frontend/app), componenti UI piccoli e riutilizzabili e una gerarchia chiara delle pagine.

L'insieme di questi esempi conferma le nostre scelte per il tema Meetup: interfaccia a blocchi, navigazione semplice, uso di Volt solo dove serve vera interazione (forms, filtri, player), mantenendo Blade + Tailwind per tutto il resto.
