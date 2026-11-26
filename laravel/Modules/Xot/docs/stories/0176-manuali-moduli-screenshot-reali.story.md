---
title: "STORY — manuali di moduli e temi con screenshot reali e verificabili"
type: story
status: in-progress            # proposed | in-progress | review | done | cancelled
date: 2026-11-25
module: Xot
decision-makers: utente
qmd: "bmad story manuali docs manuals screenshot reali manual-screenshots scratch fixture"
related:
  - ../../../../../bashscripts/docs/operations/manual-screenshots.md
  - ../../../Rating/docs/bmad/stories/0101-manuals-screenshots-dashboard-widget.story.md
---

# Manuali di moduli e temi con screenshot reali e verificabili

## Context and Problem Statement

Solo 9 unità su 17 avevano `docs/manuals`, e ognuna conteneva lo **stesso** `front-office-home.png` (una cattura copiata
ovunque: la home pubblica, che non documenta nessun pannello) più PDF di cui non si trova il generatore. Un altro attore
ha poi salvato come «dashboard» di Rating la pagina di login, e la story 0101 di Rating ha la casella «screenshot reali»
spuntata su quella base. Come si producono manuali con screenshot che siano davvero la pagina promessa, senza dati reali
in un repository pubblico e senza duplicare il lavoro di chi scrive negli stessi file?

## Decision Drivers

- Ordine dell'utente: «non ti devi inventare nulla»; i difetti trovati scrivendo il manuale si correggono.
- Repository pubblico: niente account né dati reali negli screenshot (convenzione di `fo-sweep.mjs`: «mai l'utente reale»).
- Policy script: `.mjs` in `bashscripts/tools/<area>/`, doc in `bashscripts/docs/`, i DB di sviluppo non si scrivono.
- Tetto di 100 `.md` per `docs/` (già superato in molti moduli): un manuale sostituisce un file, non ne aggiunge.
- Più scrittori concorrenti (sessione peer, Cursor, script di sync): scope disgiunti e rilettura prima di scrivere.

## Considered Options

- Status quo: una home generica per modulo. Scartata: non documenta nulla e inganna.
- Catturare il dev server con la sessione dell'utente reale. Scartata: dati reali in un repo pubblico, scrive sul DB di sviluppo.
- **Tool `manual-screenshots.mjs` + istanza scratch isolata + guard sulle pagine sbagliate.**

## Decision Outcome

Scelta: **tool senza dipendenze + istanza scratch**, perché è l'unica opzione che dà prove (data, HTTP, sha256 per ogni
scatto), non usa dati reali e rifiuta da sola login-al-posto-della-pagina, pagine d'errore e pagine senza CSS.

- Tool: `bashscripts/tools/docs/manual-screenshots.mjs`; doc: `bashscripts/docs/operations/manual-screenshots.md`.
- Manifest per unità: `docs/manuals/screenshots.json`; immagini `docs/manuals/assets/<nome>.webp`.
- Istanza: `bashscripts/tools/visual/scratch-auth-fixture.sh`, resa utilizzabile da `laravel/server.php` (shim con `return require`).

### Consequences

- Buono: ogni affermazione del manuale è tracciabile a uno scatto o a un file; i difetti emergono (Rating: etichette non tradotte, doppio «Nuovo», Impostazioni vuota).
- Buono: si scoprono bug dell'ambiente (router mancante, radice risolta nel progetto sbagliato via symlink).
- Cattivo: le liste scratch sono vuote («Nessun risultato»); i dati di esempio vanno inseriti e dichiarati.
- Cattivo: i PDF `manuale-utente.pdf` esistenti restano vecchi rispetto ai `.md`; il loro generatore è ignoto.

### Confirmation

- Rating: `node bashscripts/tools/docs/manual-screenshots.mjs Rating` → 7 `OK`, exit 0; ogni immagine aperta e controllata a occhio; manuale riscritto con evidenza.
- Il primo giro era HTTP 200 ma senza CSS (router senza `return`): il guard «font di default sul body» ora lo rifiuta.
- `laravel/server.php`: shim con `return require` del router del framework; senza `return` i file statici escono vuoti.
- Onda 1 (Activity, Geo, Media, UI, Xot, tema Meetup), onda 2A (Notify, Cms, User, Tenant, Lang) e onda 2B (AI, Gdpr, Job, Seo, Meetup) consegnate: 16 unità con `screenshots.json`.
- Guardia automatica: `Modules/Xot/tests/Unit/Docs/ManualScreenshotsHaveProvenanceTest.php` fallisce se un manuale di un'unità con manifest incorpora un'immagine che manca, non è registrata o ha un sha256 diverso dalla cattura. Alla prima esecuzione ha trovato 18 immagini non provate (Tenant senza `captured`, home del tema, UI e Media con PNG di Cursor) e ha mostrato che modulo e tema Meetup collidevano nella stessa chiave (corretto: `Modules/Meetup` e `Themes/Meetup`).
- Effetto collaterale delle catture (risolto): il rendering dei pannelli nella fixture scriveva nel `lang/it/` reale dei moduli un file spurio `lang/it/.php` (nome vuoto) in 14 moduli, 4 già committati dal sync (Geo, Rating, UI, User). Causa: le azioni del menu utente (`profile`, `logout`) non sono classi `Modules\...`, quindi `GetTransKeyAction` risaliva il backtrace fino alla pagina Dashboard in rendering e, togliendo il prefisso `dashboard`, restava una chiave `modulo::` vuota. Corretto in Xot (`GetTransKeyAction`, con test) e con una guardia in `Lang SaveTransAction::persist()` che rifiuta chiavi senza nome file. Verificato alle 22:41 catturando tre Dashboard: nessun `.php` ricompare. Restano segnaposto `actions.profile.label='profile'` in `<modulo>/lang/it/dashboard.php`, scritti da `AutoLabelAction` in locale: da valutare prima di committare.
- Lo strumento ha imparato dalle catture: rifiuta la modale d'errore Livewire (UI/dashboard andava in `TypeError` con HTTP 200) e i campi segreti con valore. Due falsi positivi del secondo controllo (checkbox `password_expires_at` in User, campo `key` in Lang) sono stati corretti restringendo la regex; il rischio segreti era di design (`EnvWidget`), non una fuga: `MAIL_PASSWORD` vale `null` e le chiavi API sono vuote.
- Difetti corretti scrivendo i manuali, tutti in `lang/it` o in una vista: etichette grezze (Activity, Media, Rating, Cms, Lang, Notify, User, Xot), `UI/stat-with-icon.blade.php` (dashboard in errore), `Rating` (campo `percentage` che il form accettava e `fill()` scartava).
- Un terzo attore (Cursor con Playwright e la sessione reale su `127.0.0.1:8000`) ha riscritto più volte i manuali e salvato come «dashboard» di Rating la pagina di login: va fermato o coordinato dall'utente.
- Da fare a fine lavoro: `scratch-auth-fixture.sh stop`. La casella «screenshot reali» della 0101 di Rating è già spuntata (la story è stata condensata in `Rating/docs/digests/overflow-history.md`).
