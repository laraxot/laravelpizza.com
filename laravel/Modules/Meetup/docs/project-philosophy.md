# Filosofia del Progetto LaravelPizza.com

## Data
[DATE]

## Obiettivo Dichiarato

**Diventare il riferimento per chi vuole lanciare un Laravel Meetup "chiavi in mano", con codice riusabile ovunque.**

Questo progetto non è un "esempio giocattolo", ma la base per **meetup veri, pagine reali, community reali**.

## Principi Fondamentali

### DRY + KISS Estremi

- **Niente complicazioni inutili**, ma anche **niente "scorciatoie sporche"**
- Ogni decisione architetturale deve essere giustificata dalla logica di business
- Sempre preferire soluzioni semplici e dirette

### Una Tabella = Una Migrazione (Laraxot Migration Philosophy)

- **Single Source of Truth**: Una sola fonte di verità per struttura tabella
- **Evoluzione Organica**: La migrazione "cresce" nel tempo
- **Anti-Frammentazione**: Evita esplosione di micro-migrazioni

Vedi: [Laraxot Migration Philosophy](../../user/docs/laraxot-migration-philosophy.md)

### Frontoffice = Folio + Volt

**REGOLA CRITICA**: Nel frontoffice NON usare controller né scrivere rotte in `web.php` o `api.php`.

**Pattern obbligatorio**:
```
Request → Folio (routing) → Blade Page → Volt Component → Action → Service/Model
```

**✅ OBBLIGATORIO**:
- Usare Folio per routing file-based: pagine in `resources/views/pages/*.blade.php` = rotte automatiche
- Usare Volt per interattività: `@volt('component-name')` direttamente nelle pagine Folio
- Chiamare Actions da componenti Volt, non da controller

**❌ VIETATO**:
- Creare controller per pagine pubbliche
- Scrivere rotte in `routes/web.php` o `routes/api.php` per pagine pubbliche
- Usare `Route::get()` per routing frontoffice

Vedi: [Architettura Frontoffice](./architecture-reference.md)

### Layout Chiari

- **`x-layouts.main`** → shell HTML base (no header/footer), NON usare direttamente nelle pagine
- **`x-layouts.app`** → layout completo con header nav + footer (pagina pubblica frontoffice)
- **`x-layouts.guest`** → layout per login/registrazione/password (auth frontoffice)

Vedi: [Layout System Analysis](../../../themes/meetup/docs/layout-system-analysis.md)

### Qualità Maniacale

- **PHPStan livello 10 obbligatorio** per tutto il codice PHP
- **Niente controller/routing classico** per il frontoffice (solo Folio + Volt)
- **Docs curate** dentro ogni modulo/tema, niente conoscenza "nascosta"

### Docs Prima del Codice

**REGOLA ASSOLUTA**: Prima si aggiorna/legge `docs/`, poi si scrive codice.

Ogni cartella `docs` è pensata come **memoria viva del sistema**:
- Regole
- Bugfix
- Decisioni architetturali
- Analisi delle pagine
- Tutto passa da lì

## Struttura del Progetto

- **Root progetto**: `/var/www/_bases/base_laravelpizza/`
- **Laravel app**: `laravel/`
- **Moduli** (business logic, servizi, integrazioni): `laravel/Modules/*`
- **Temi** (UI/UX, frontend, layout): `laravel/Themes/*`
- **Tema principale**: `Themes/Meetup` (replica di `laravelpizza.com`)
- **Docs per modulo/tema**:
  - `Modules/{ModuleName}/docs/`
  - `Themes/{ThemeName}/docs/`

## Come Iniziare

1. **Leggi le regole critiche**:
   - `laravel/Modules/Xot/docs/critical-rules-consolidated.md`
   - `laravel/Modules/Meetup/docs/rules-index.md`
   - `laravel/Themes/Meetup/docs/critical-rules-consolidated.md`

2. **Avvia l'ambiente**:
   - Setup Laravel classico (database, `.env`, ecc.)
   - Dal tema Meetup:
     - `cd laravel/Themes/Meetup`
     - `npm install`
     - `npm run build && npm run copy` (OBBLIGATORIO dopo ogni cambio CSS/JS)

3. **Visita il frontoffice**:
   - `http://127.0.0.1:8000/it`
   - `http://127.0.0.1:8000/it/events`
   - Confronta con `https://laravelpizza.com` e prova a trovare differenze da colmare

## Come Contribuire

Ogni contributo che:
- rispetta le regole,
- migliora la qualità,
- rende più facile per altri capire il progetto,
è il benvenuto.

### Se ami il frontend
- Aiuta a rifinire il tema Meetup (`resources/css/app.css`, `resources/js/app.js`)
- Porta nuove idee di sezioni/animazioni, ma sempre nel rispetto di Folio + Volt

### Se ami il backend/architettura
- Migliora i moduli (`Modules/*`) seguendo PHPStan livello 10
- Rafforza services, actions, DTO, code quality, pattern Laraxot

### Se ami la documentazione
- Migliora/aggiorna i file in `docs/` (senza maiuscole nei nomi, tranne `README.md`)
- Scrivi analisi di pagine, bugfix log, regole e decisioni architetturali

## Perché il Nome "LaravelPizza"?

Perché l'idea è semplice: **mettere insieme le due cose che rendono felice il 90% degli sviluppatori**:
- scrivere buon codice Laravel,
- mangiare una pizza in compagnia,
- condividere esperienze, problemi, soluzioni.

Questo repo è il passo successivo:
**standardizzare un setup di meetup Laravel "replicabile" ovunque nel mondo.**

## Riferimenti

- [README Principale](../../../../readme.md)
- [Regole Critiche Consolidate](./critical-rules-consolidated.md)
- [Architettura Frontoffice](./architecture-reference.md)
- [Layout System](../../../themes/meetup/docs/layout-system-analysis.md)

---

**Ultimo aggiornamento**: [DATE]
**Versione**: 1.0
**Compatibilità**: LaravelPizza.com base_laravelpizza
