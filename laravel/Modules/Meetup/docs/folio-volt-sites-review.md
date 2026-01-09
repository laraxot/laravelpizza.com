# Recensioni siti/app Folio + Volt

## Obiettivo del documento

Questo documento raccoglie una **rassegna di progetti reali** costruiti (o documentati pubblicamente) con **Laravel Folio + Livewire Volt**, evidenziando:

- cosa fanno
- come usano Folio e Volt
- quali pattern possiamo riusare in **Laravel Pizza Meetups** (modulo `Meetup`)

> Nota: non esiste un catalogo completo "ufficiale" di tutti i siti Folio+Volt; qui raccogliamo esempi pubblici significativi (articoli, repo, demo) utili come riferimento architetturale.

---

## 1. Todo Application con Folio + Volt (Nuno Maduro / thinkverse)

- **Fonti**
  - Articolo: "Todo Application With Laravel Folio and Volt" (blog di Nuno Maduro)
  - Repo di esempio: `thinkverse/folio-volt-todo-app` (GitHub)
- **Dominio**: semplice app TODO (lista, aggiunta, completamento task).

### Come usa Folio

- Una pagina Folio principale, ad es. `resources/views/pages/todos.blade.php` → rotta `/todos`.
- Nessuna definizione esplicita in `web.php`.
- La pagina contiene sia il layout Blade sia il blocco Volt (`@volt('todos')`).

### Come usa Volt

- Il componente Volt vive **dentro** la pagina Folio:
  - proprietà per l'input del nuovo task
  - `mount()` per caricare i todo esistenti
  - metodi `addTodo`, `toggle`, `delete` chiamati via `wire:click`.
- Logica e template in un unico file → ottimo esempio di **single file component**.

### Cosa impariamo per il modulo Meetup

- Per le parti semplici (es. **lista eventi personali**, **quick actions dashboard**), possiamo usare lo stesso pattern:
  - 1 pagina Folio → 1 componente Volt interno
  - nessun controller, nessuna rotta manuale.
- L'app TODO mostra bene come mantenere la logica di stato (lista elementi) tutta nel componente, delegando a **Actions/Services** solo quando serve business complesso.

---

## 2. Multi‑Step Form con Folio + Volt + Neon Postgres

- **Fonte**: guida "Building a Multi-Step Form with Laravel Volt, Folio, and Neon Postgres" (neon.tech).
- **Dominio**: form di candidatura multi‑step (dati personali, istruzione, esperienza, review).

### Come usa Folio

- Ogni step è una pagina Folio dedicata, ad es.:
  - `/apply/personal` → `resources/views/pages/apply/personal.blade.php`
  - `/apply/education` → `…/apply/education.blade.php`
  - `/apply/work` → `…/apply/work.blade.php`
  - `/apply/review` → `…/apply/review.blade.php`
- Il routing è quindi **leggibile dall'albero di file**.

### Come usa Volt

- Ogni pagina Folio contiene un componente Volt che:
  - gestisce lo stato dei campi di quello step
  - valida i dati (`$this->validate([...])`)
  - salva/aggiorna l'entità `Applicant` in DB
  - reindirizza allo step successivo (`redirect('/apply/education')`, ecc.).
- Lo stato globale (id applicant) viene tenuto in sessione o in DB.

### Cosa impariamo per il modulo Meetup

- Pattern ottimo per:
  - **wizard di registrazione avanzata** (profilo community, preferenze, città, stack…)
  - **creazione evento guidata** (info base → location → capienza → conferma).
- Importante: ogni step ha responsabilità piccola (principio **KISS + SRP**), mentre la coerenza dei dati è demandata a un modello/servizio centrale.

---

## 3. Podcast / Episodi con Folio + Volt (Jason Beggs / Laravel News example)

- **Fonti**
  - Articolo: "Livewire Volt and Folio" (blog personale di Jason Beggs)
  - Esempio su GitHub: `jasonlbeggs/laravel-news-volt-folio-example` (post.md).
- **Dominio**: lista episodi + pagina dettaglio + player audio.

### Come usa Folio

- Struttura tipica:
  - `resources/views/pages/episodes/index.blade.php` → `/episodes`
  - `resources/views/pages/episodes/[Episode:number].blade.php` → `/episodes/{episode}` con **route model binding** sul modello `Episode`.
- I nomi dei file `[Episode:number].blade.php` sfruttano la sintassi di Folio per tipo/id.

### Come usa Volt

- La pagina `episodes` usa Volt per:
  - caricare elenco episodi con `computed()` o query nel blocco PHP
  - gestire selezione episodio, play/pause, interazioni con un player basato su Alpine.
- Volt mantiene lo stato (episodio corrente) e comunica con componenti Blade/Alpine tramite eventi.

### Cosa impariamo per il modulo Meetup

- Ottimo riferimento per:
  - **pagina eventi + dettaglio evento** con route model binding Folio (`[Event].blade.php`).
  - integrazione con player / componenti JS (es. futura riproduzione talk registrati).
- Mostra come combinare **Volt + Alpine** senza confondere responsabilità: Volt gestisce dati / stato Laravel, Alpine il micro‑comportamento del player.

---

## 4. Product Management App con Folio + Volt (Pedro Souza)

- **Fonte**: Medium "Product Management App With Laravel Folio and Volt" (pt 1).
- **Dominio**: gestione prodotti (CRUD basilare con lista + form).

### Come usa Folio

- Comando `php artisan folio:page products` per creare la pagina principale `/products`.
- In alcuni step usa anche una pagina dinamica `/products/[id]` per il dettaglio.
- L'articolo insiste sull'uso dei **comandi artisan** per generare le pagine invece di creare file manualmente.

### Come usa Volt

- Nella pagina `products` il blocco Volt contiene:
  - array di `products` caricati dal DB
  - proprietà per il form (name, description, price, amount)
  - metodo `addProduct()` con validazione e salvataggio.
- UI reattiva: la lista si aggiorna subito dopo l'inserimento senza ricaricare la pagina.

### Cosa impariamo per il modulo Meetup

- Pattern riusabile per:
  - **lista eventi nel backoffice Filament + vista pubblica Folio+Volt**
  - gestione CRUD semplice lato frontend (es. gestione interessi utente, tag, preferenze).
- Conferma che è pratico tenere **CRUD leggeri** direttamente nel componente Volt quando la logica è semplice e localizzata.

---

## 5. Altri riferimenti ufficiali (Folio + Volt)

- **Blog Laravel – Introducing Folio**
  Spiega la filosofia "page-based" e come la struttura dei file sostituisce le rotte manuali.
- **Blog Laravel – Introducing Volt**
  Mostra come Volt vive dentro le pagine Folio (`@volt`), unendo logica PHP e Blade.

### Impatto sulle nostre scelte

- Confermano che la combinazione **Folio + Volt** è pensata esattamente per il tipo di frontoffice che vogliamo per Laravel Pizza Meetups:
  - routing leggibile dai file,
  - zero controller/`web.php` per l'interfaccia pubblica,
  - componenti reattivi dove serve.
- Le nostre regole in `architectural-rules.md` e `folio-volt-best-practices.md` sono quindi allineate alle best practice pubbliche.

---

## 6. Genesis starter kit (DevDojo)

- **Fonti**
  - Repo: `devdojo/genesis` su GitHub (starter kit ufficiale).
  - Articoli Laravel News collegati allo starter kit.
  - Documentazione e wiki del repo.

### Panoramica

- Starter kit TALL che integra **Laravel**, **Livewire**, **Tailwind**, **Alpine**, più **Folio** (routing) e **Volt** (componenti reattivi).
- Fornisce un frontoffice completo di base:
  - homepage marketing (`index.blade.php`),
  - pagina `about`,
  - flusso auth completo (`auth/login`, `auth/register`, `auth/password/*`, `auth/verify`),
  - dashboard minima (`dashboard/index.blade.php`),
  - pagina profilo (`profile/edit.blade.php`),
  - pagina `learn` che mostra la documentazione.

### Come usa Folio

- Tutte le rotte principali sono derivate dalla struttura in `resources/views/pages`.
- L'output tipico di `php artisan folio:list` nel readme mostra rotte come:
  - `/` → `index.blade.php`
  - `/about` → `about.blade.php`
  - `/auth/login` → `auth/login.blade.php`
  - `/auth/register` → `auth/register.blade.php`
  - `/dashboard` → `dashboard/index.blade.php`
  - `/profile/edit` → `profile/edit.blade.php`
- Alcune pagine dichiarano middleware direttamente nel file, es.:
  `middleware(['auth', 'verified']);` per dashboard e profilo,
  `middleware(['redirect-to-dashboard']);` per la homepage.

### Come integra Livewire / Volt

- Genesis è costruito su **Livewire + Volt**:
  - le pagine auth e profilo usano componenti Livewire/Volt per gestire form, validazione, update profilo, reset password;
  - la dashboard è pensata per essere estesa con widget Livewire/Volt (stats, liste, grafici).
- Pattern chiaro: **Folio definisce la pagina e il layout, Volt/Livewire gestiscono la logica interattiva all'interno della pagina**.

### Cosa impariamo per Laravel Pizza Meetups

- Possiamo usare Genesis come **reference concreta** per il frontoffice Folio+Volt:
  - Struttura delle pagine auth (`resources/views/pages/auth/*.blade.php`).
  - Struttura dashboard (`resources/views/pages/dashboard/index.blade.php`).
  - Pagina profilo/edit (`resources/views/pages/profile/edit.blade.php`).
- Per il modulo Meetup questo si traduce in:
  - definire la stessa mappa di pagine Folio (login/register/dashboard/profile) nel tema Meetup;
  - usare componenti Volt per tutti i form auth/profile, evitando controller;
  - applicare middleware direttamente nei file Folio per proteggere dashboard/profile.
- Genesis dimostra che l'approccio **Folio + Volt + Filament** può coprire tutto il ciclo:
  marketing + auth + dashboard + profilo, esattamente il perimetro che vogliamo per Laravel Pizza Meetups.

---

## 7. Warriorfolio 2 – piattaforma portfolio/blog + Filament

- **Fonti**
  - Repo: `mviniciusca/warriorfolio` su GitHub.
  - Documentazione ufficiale: `warriorfolio.vercel.app`.

### Panoramica

- Applicazione Laravel moderna per **portfolio + blog**, pensata come prodotto installabile (create-project) con:
  - architettura modulare (blocchi di contenuto/feature attivabili),
  - forte focus su **SEO, contenuti e branding personale**,
  - **admin panel Filament** completo per la gestione no‑code.

### Come struttura frontoffice e backoffice

- **Frontoffice**
  - Pagine pubbliche portfolio, blog, about, gallery, ecc. con forte cura per UX e SEO.
  - Layout responsivi basati su **Tailwind + Alpine + componenti riusabili** (Saturn UI / temi).
- **Backoffice (Filament)**
  - Dashboard ridisegnata con widget, quickbar, notifiche.
  - Resources per blog, portfolio, clienti, ecc., completamente gestiti da Filament.

### Pattern architetturali interessanti

- **Modularità dei contenuti**
  - Page builder con blocchi (components/design/core) che permettono di comporre pagine complesse senza toccare codice.
- **Gestione dei moduli visibili**
  - Possibilità di attivare/disattivare sezioni come hero, progetti, clienti, newsletter, footer.
- **Modalità speciali**
  - Maintenance mode con funzioni limitate (contatti, social, messaggio custom).
  - Discovery mode per vedere il sito "live" solo come admin durante la manutenzione.

### Cosa impariamo per il modulo Meetup

- **Gestione eventi/blog come contenuti modulari**
  - Possiamo modellare eventi, articoli meetup, recap, risorse come entità gestite interamente da Filament (alla Warriorfolio), mentre il frontoffice li espone tramite pagine Folio + componenti Volt.
- **Separazione frontoffice/backoffice**
  - Warriorfolio conferma che è sano avere:
    - un frontoffice pensato per SEO, performance e UX,
    - un backoffice Filament ricco ma separato.
  - Nel nostro progetto questo rafforza la regola: **Filament solo per amministrazione, Folio + Volt per il frontoffice pubblico**.
- **Content blocks / layout componibili**
  - L'idea di blocchi (components/design/core) può ispirare la struttura delle viste Folio:
    - sezioni riusabili (hero, lista eventi, CTA, testimonial) come partial Blade,
    - componenti Volt solo dove serve stato/azione (filtri eventi, registrazione, ricerca).

## 8. Altri progetti Folio + Volt (panoramica)

- **SaaS e multi‑tenant** (es. b2bsaas0/b2bsaas, mini‑CRM)
  Molti template Folio+Volt orientati al B2B SaaS usano Folio per strutturare le aree app (dashboard, team, settings) e Volt per i flussi CRUD (team, utenti, fatture), spesso combinati con multitenancy. Questo rafforza l'idea che anche per Laravel Pizza Meetups possiamo avere in futuro un livello "multi‑tenant" (es. network di pizzerie / community locali) mantenendo Folio al centro del routing.
- **Portfolio / siti personali** (es. GothamFolio, altri portfolio)
  Confermano che Folio+Volt si adatta bene a siti portfolio con sezioni multiple (hero, progetti, blog, contatti) e componenti interattivi (form contatto, feedback). Il pattern si traduce quasi 1:1 in "portfolio di eventi" per i meetup.
- **Podcast / media player** (es. progetti podcast player, WeLoveDevs)
  Mostrano come gestire player persistenti e liste di contenuti multimediali con Volt e Folio, utile se in futuro vogliamo pubblicare registrazioni audio/video dei meetup.
- **Starter kit e boilerplate** (es. vflat, nativephp starter, personalized starter kit)
  Offrono esempi di come impostare layout, cartelle `pages/` e convenzioni di naming in modo coerente; molti riprendono direttamente i pattern di Genesis.

In sintesi, l'ecosistema di progetti Folio+Volt conferma che l'architettura scelta per Laravel Pizza Meetups (Folio + Volt + Filament) è adeguata sia per casi semplici (todo, URL shortener) sia per casi complessi (SaaS, portfolio, media app) e che possiamo tranquillamente crescere in quella direzione senza cambiare stack.
