# Piano Folio + Volt per il tema Meetup

## 1. Scopo del documento

Questo documento definisce un **piano di implementazione** per portare il tema HTML Meetup:

- da `resources/html/*.html` + layout statici
- a **pagine Folio + componenti Volt** dentro `resources/views/pages`

mantenendo i vincoli del progetto:

- niente controller/rotte dentro `web.php`/`api.php` per il frontoffice.
- routing file-based con Folio.
- interattività con Volt (Livewire 3), solo dove serve.
- Filament usato solo per il backoffice/admin.

## 2. Stato attuale

- Esistono già pagine HTML statiche nel tema:
  - `index.html` (home/landing marketing)
  - `events.html` (listing eventi)
  - `dashboard.html` (dashboard utente)
  - `profile.html` (profilo utente)
  - pagine auth (`login.html`, `register.html`, ecc.)
- Esistono docs di riferimento:
  - `folio-volt-best-practices.md` – regole tecniche Folio+Volt.
  - `folio-volt-sites-review.md` – case study (Genesis, Warriorfolio, Neon, ecc.).
  - `PROJECT-COMPLETION-PLAN.md` – piano di completamento generale del tema.

## 3. Mappa obiettivi Folio + Volt (tema)

### 3.1. Pagina Home (`/`)

- File target: `resources/views/pages/index.blade.php`
- Obiettivo:
  - replicare layout e contenuto di `resources/html/index.html`.
  - usare **Blade + Tailwind** (Blade-first) per la struttura.
  - usare Volt solo per piccole parti dinamiche future (newsletter, CTA interattive, ecc.).
- Collegamenti con case study:
  - Genesis: home marketing semplice, hero forte, sezioni a blocchi.
  - Warriorfolio: cura di tipografia e sezioni, tema dark pulito.

### 3.2. Pagina Eventi (`/events`)

- File target: `resources/views/pages/events/index.blade.php`
- Obiettivo:
  - trasformare `events.html` in una pagina Folio.
  - integrare un componente Volt per **lista eventi filtrabile** (pattern tipo gallery Warriorfolio).
- Possibili componenti Volt:
  - `events-list` – gestisce caricamento, filtri (città, data, tema), paginazione.
  - `event-filters` – pannello filtri responsive.

### 3.3. Dettaglio Evento (`/events/[event]`)

- File target: `resources/views/pages/events/[event].blade.php` (naming esatto da definire in base al model reale).
- Obiettivo:
  - pagina "Event Detail" ispirata al pattern episodios/podcast (Jason Beggs) + portfolio card Warriorfolio.
  - hero con titolo, data, città, CTA "Register".
  - sezione dettagli (descrizione, speaker, agenda).
- Componente Volt previsto:
  - `event-register` – form di registrazione evento (gestisce validazione, invio, conferma).

### 3.4. Dashboard (`/dashboard`)

- File target: `resources/views/pages/dashboard/index.blade.php`
- Obiettivo:
  - allineare dashboard attuale (HTML) con:
    - design laravelpizza.com,
    - pattern Genesis (dashboard minimal, pronta per widget Volt/Livewire).
  - sezioni previste:
    - overview (numero eventi, prossimi meetup),
    - quick actions,
    - lista "my meetups".
- Volt:
  - `user-dashboard-widgets` – componenti per stats e quick actions.

### 3.5. Profile (`/profile` o `/profile/edit`)

- File target: `resources/views/pages/profile/edit.blade.php` (o simile, allineato a Genesis).
- Obiettivo:
  - migrare layout di `profile.html` seguendo pattern Genesis + Warriorfolio:
    - sezioni separate per dati profilo, preferenze, sicurezza.
- Volt:
  - `profile-form` – gestione aggiornamento dati profilo.

### 3.6. Pagine Auth (`/auth/login`, `/auth/register`, …)

- File target principali:
  - `resources/views/pages/auth/login.blade.php`
  - `resources/views/pages/auth/register.blade.php`
- Obiettivo:
  - prendere il meglio da:
    - HTML attuale del tema (branding Laravel Pizza),
    - layout auth di Genesis (card centrale, semplicità, messaggi chiari).
- Volt:
  - `auth-login-form`, `auth-register-form` – logica di login/registrazione.

## 4. Vincoli e priorità

1. **Vincoli**
   - Tutte le nuove pagine frontoffice devono essere Folio.
   - Tutta l'interattività non banale (form, filtri, wizard) deve passare da Volt.
   - Nessun controller personalizzato per il frontoffice.
2. **Priorità**
   - P1: `index.blade.php` (home), `events/index.blade.php` (listing), pagine auth.
   - P2: `events/[event].blade.php` (dettaglio), `dashboard/index.blade.php`.
   - P3: `profile/edit.blade.php` e pagine secondarie.

## 5. Sequenza di lavoro (tema)

1. **Analisi e sync HTML → Blade**
   - per ogni pagina target, fare una migrazione 1:1 da HTML statico a Blade, senza ancora Volt.
   - mantenere tutte le classi Tailwind e la struttura di design.
2. **Aggiunta layout (x-layouts.app / marketing)**
   - definire i layout base del tema (in linea con `architectural-rules.md` e best practices dei case study).
   - collegare le pagine Folio ai layout corretti (marketing vs app autenticata).
3. **Introduzione componenti Volt**
   - partire da una singola feature (es. filtri eventi) e introdurla come componente Volt,
   - testare la UX e le performance.
4. **Rifinitura e allineamento con Filament**
   - garantire che i dati mostrati nel frontoffice corrispondano a ciò che viene gestito nel backoffice Filament.

Questo piano dovrà essere rivisto man mano che risolviamo l'errore `env` e che `php artisan folio:list` ci darà visibilità completa sulle rotte Folio registrate.
