# Piano Folio + Volt per il modulo Meetup

## 1. Stato attuale

- Architettura decisa: **frontoffice = Folio + Volt + Filament solo per admin** (nessun controller/rotte manuali per il frontoffice).
- Esistono già documenti chiave:
  - `architectural-rules.md` – regole architetturali globali.
  - `folio-volt-best-practices.md` – best practices tecniche.
  - `folio-volt-sites-review.md` – case study (Genesis, Warriorfolio, Neon, ecc.).
- Il comando `php artisan folio:list` al momento fallisce con errore `Target class [env] does not exist` → prima di usare Folio in runtime dobbiamo:
  - capire dove viene referenziata la classe `env` nel progetto,
  - correggere/migrare quella chiamata.

Questo documento serve a **pianificare** (non a implementare) come usare Folio+Volt nel modulo Meetup.

## 2. Obiettivi per il modulo Meetup

- Definire quali **pagine pubbliche** del modulo Meetup esporre tramite Folio:
  - lista eventi pubblici,
  - dettaglio evento pubblico,
  - eventuale calendario/archivio meetup,
  - pagine di contenuto legate al modulo (es. pagina "Meetups" su laravelpizza.com).
- Collegare queste pagine ai **dati reali** (modulo Meetup + Filament) usando Volt come strato reattivo.
- Mantenere la separazione:
  - **frontoffice**: Folio + Volt (lettura + azioni utente leggere: registrazione, preferenze, ecc.).
  - **backoffice**: Filament (gestione eventi, categorie, luoghi, ecc.).

## 3. Piano step-by-step (alto livello)

### Step 1 – Sistemare l'errore `env` e validare Folio

- Cercare dove viene usata una classe/alias `env` nel codice Laravel (config, service provider, helpers custom).
- Correggere l'uso (es. usare `config()` / `env()` globale / dependency injection corretta).
- Rilanciare `php artisan folio:list` fino a ottenere l'elenco delle rotte.
- Documentare la soluzione tecnica in un file di troubleshooting separato (es. `TROUBLESHOOTING.md` o sezione dedicata).

### Step 2 – Disegnare la mappa delle pagine Folio per il modulo Meetup

- Definire un albero ideale sotto `resources/views/pages/meetup/` (naming da confermare):

  - `/meetups` → lista eventi
  - `/meetups/[event]` → dettaglio evento
  - `/meetups/archive` → archivio meetup passati (opzionale)

- Per ciascuna pagina, decidere:
  - quali dati caricare (query principali),
  - quali componenti Volt incorporare (lista filtrabile, form registrazione, ecc.),
  - quali middleware applicare (es. nessuno per pagine pubbliche; auth solo per pagine "my meetups").

### Step 3 – Definire i componenti Volt

- Identificare i componenti Volt principali per il modulo Meetup, ad esempio:
  - `meetup-events-list` – listing filtrabile degli eventi.
  - `meetup-event-register` – form di registrazione a un evento.
  - `meetup-user-events` – lista degli eventi a cui l'utente è iscritto (dashboard).
- Per ciascuno:
  - stato (state),
  - azioni (metodi),
  - validazione,
  - integrazione con Actions/Services esistenti.

### Step 4 – Allineare con Filament

- Verificare quali **resources Filament** esistono già per gli eventi.
- Definire come il frontoffice Folio/Volt deve leggere i dati (es. tramite query standard / query object / actions).
- Documentare eventuali convenzioni (es. naming campi, slug degli eventi, URL pubbliche).

### Step 5 – Implementazione incrementale

- Una volta validato `folio:list` e definita la mappa:
  - creare **una sola pagina Folio + Volt pilota** (es. `/meetups`),
  - testarla con dati fittizi o prelevati dal DB esistente,
  - aggiungere test di feature di base (visualizzazione lista, stato HTTP 200, ecc.).
- Solo dopo il successo della pagina pilota, estendere a dettaglio evento e altre pagine.

## 4. Collegamento con altre docs

- Questo piano deve rimanere coerente con:
  - `architectural-rules.md` – nessun controller/rotta manuale per frontoffice.
  - `tailwind-best-practices.md` – stile e componenti CSS.
  - `PROJECT-COMPLETION-PLAN.md` – milestone complessive del progetto.

Qualsiasi decisione importante presa durante l'implementazione Folio+Volt nel modulo Meetup andrà poi riportata in questi documenti principali (non solo qui).
