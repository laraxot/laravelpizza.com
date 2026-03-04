# 🍕 LaravelPizza.com – Il side‑project Laravel che vorrai mostrare al prossimo meetup

![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)
![Filament 5.x](https://img.shields.io/badge/Filament-5.x-blue.svg)
![Livewire 4.x](https://img.shields.io/badge/Livewire-4.x-orange.svg)
![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)
[![Pest Coverage](https://img.shields.io/badge/dynamic/json?url=https%3A%2F%2Fraw.githubusercontent.com%2Flaraxot%2Flaravelpizza.com%2Fdev%2Fcoverage-badge.svg&query=%24.message&label=coverage&color=brightgreen)](https://github.com/laraxot/laravelpizza.com/actions/workflows/pest-coverage.yml)

## 🎯 Missione del Progetto

**Questo è una CONVERSIONE e MIGLIORAMENTO di https://laravelpizza.com/**

Non stiamo solo replicando - stiamo **ELEVANDO** il sito originale per renderlo:
- ✨ **PIÙ COOL** - Design premium e moderno che cattura l'attenzione
- 🚀 **PIÙ CLICKBAIT** - Headlines e CTA irresistibili che convertono
- 💥 **PIÙ ENGAGING** - Animazioni fluide e interazioni wow-factor
- 🔥 **PIÙ VIRALE** - Progettato per essere condiviso e diventare virale

**Obiettivo**: Prendere laravelpizza.com e renderlo **straordinario** - il genere di sito che fa dire "WOW!" e che viene condiviso spontaneamente.

---

Benvenuto nella base ufficiale di **LaravelPizza.com**: qui costruiamo un ecosistema completo di **meetup**, **community**,
**tema frontend super curato (Meetup Theme)** e **architettura Laraxot** spinta al massimo.

> Stai cercando un progetto open‑source dove impari **Laravel moderno** (Folio + Volt + Filament) su un caso reale?
> Allora prenditi 2 minuti: questo repo può diventare il tuo **biglietto da visita** al prossimo Laravel meetup.
>
> **Obiettivo dichiarato:** diventare il riferimento per chi vuole lanciare un Laravel Meetup "chiavi in mano", con codice riusabile ovunque.

---

## 🚀 Stack Tecnologico

### Backend
- **PHP**: 8.3+
- **Framework**: Laravel 12.x
- **Admin Panel**: Filament 5.x
- **Frontend Components**: Livewire 4.x
- **Modularità**: nwidart/laravel-modules 12.x
- **Database**: MySQL / SQLite
- **Queue**: Redis
- **Testing**: Pest

### Frontend
- **Routing**: Laravel Folio (file-based, NO controllers)
- **Components**: Laravel Volt (declarative, NO class components)
- **Styling**: Tailwind CSS 4.x
- **JavaScript**: Alpine.js
- **Build**: Vite

### Quality Tools
- **Static Analysis**: PHPStan Level 10 (0 errors su tutti i 14 moduli)
- **Code Formatting**: Laravel Pint
- **Quality Metrics**: PHP Insights
- **Type Safety**: Strict types, generics, PHPDoc

---

## 🚀 Perché questo repo vale il tuo tempo (e le tue PR)

 - **Tema frontoffice enhanced**: stiamo prendendo `laravelpizza.com` e lo stiamo **migliorando** dentro il **Meetup Theme**
  (home, events, menu, pagina contatti, auth, ecc.), con **Folio + Volt** come architettura obbligatoria.
  **Non è una copia** - è una versione premium, più cool, più coinvolgente.
- **Architettura Laraxot**: un vero "framework nel framework":
  - Moduli indipendenti (`Modules/*`)
  - Temi separati (`Themes/*`)
  - Regole rigide su migrazioni, layout, traduzioni, docs.
- **Qualità maniacale**:
  - PHPStan livello **10** obbligatorio (0 errori su tutti i 14 moduli)
  - Niente controller/routing classico per il frontoffice (solo Folio + Volt)
  - Docs curate dentro ogni modulo/tema, niente conoscenza "nascosta".
- **Obiettivo reale**: questo codice non è un "esempio giocattolo", ma la base per meetup veri,
  pagine reali, community reali.

Se ti piace imparare **architettura Laravel avanzata** mentre costruisci qualcosa di *tangibile*,
questo è un repo perfetto per te.

---

## 🧱 Cosa c'è dentro

- **Root progetto**: `/var/www/_bases/base_laravelpizza/`
- **Laravel app**: `laravel/`
- **Moduli** (business logic, servizi, integrazioni): `laravel/Modules/*`
- **Temi** (UI/UX, frontend, layout): `laravel/Themes/*`
- **Tema principale**: `Themes/Meetup` (replica di `laravelpizza.com`)
- **Docs per modulo/tema**:
  - `Modules/{ModuleName}/docs/`
  - `Themes/{ThemeName}/docs/`

Ogni cartella `docs` è pensata come **memoria viva del sistema**:
regole, bugfix, decisioni architetturali, analisi delle pagine, tutto passa da lì.

---

## 📦 Moduli del Progetto (14 Moduli - Tutti PHPStan Level 10 Compliant ✅)

### 🎯 Core Framework
- **Xot** - Fondazione e cuore architetturale di Laraxot (0 errori)
- **User** - Autenticazione, autorizzazione, RBAC, OAuth (0 errori)

### 🌍 Internazionalizzazione & UI
- **Lang** - Sistema centralizzato di traduzione e localizzazione (0 errori)
- **UI** - Componenti Blade condivisi e widget Filament (0 errori)

### 📊 Content & Features
- **Cms** - Content management dinamico con sistema blocks (0 errori)
- **Activity** - Tracking attività e audit logging (0 errori)
- **Geo** - Gestione avanzata dati geografici e indirizzi (0 errori)
- **Media** - Sistema avanzato upload e processing media (0 errori)
- **Job** - Sistema avanzato code e job scheduling (0 errori)
- **Notify** - Sistema notifiche multi-canale (0 errori)

### 🏢 Business Logic
- **Meetup** - Core business logic per piattaforma meetup (0 errori)
- **Tenant** - Supporto multi-tenancy e isolamento dati (0 errori)
- **Gdpr** - Compliance GDPR e privacy dati (0 errori)
- **Seo** - SEO optimization e gestione metadata (0 errori)

**Totale**: 14 moduli, 0 errori PHPStan Level 10 ✅

---

## 🧠 Filosofia del progetto

- **DRY + KISS estremi**: niente complicazioni inutili, ma anche niente "scorciatoie sporche".
- **Una tabella = una migrazione** (Laraxot Migration Philosophy).
- **Frontoffice = Folio + Volt**:
  - niente controller per le pagine pubbliche
  - niente `Route::get()` per le pagine del tema
  - pattern: `Request → Folio → Blade Page → Volt Component → Action → Service/Model`.
- **Layout chiari**:
  - `x-layouts.main` → shell HTML base (no header/footer)
  - `x-layouts.app` → layout completo con header nav + footer (pagina pubblica)
  - `x-layouts.guest` → layout per login/registrazione/password (auth frontoffice).
- **Docs prima del codice**: prima si aggiorna/legge `docs/`, poi si scrive codice.

Se ti riconosci in questa filosofia, ti troverai a casa.

---

## 🔥 Come iniziare in 3 passi

> Non serve essere "guru": serve voglia di imparare e rispetto per le regole del progetto.

- **1. Leggi le regole critiche**
  - `laravel/Modules/Xot/docs/critical-rules-consolidated.md`
  - `laravel/Modules/Meetup/docs/rules-index.md`
  - `laravel/Themes/Meetup/docs/critical-rules-consolidated.md`
- **2. Avvia l'ambiente**
  - setup Laravel classico (database, `.env`, ecc.)
  - dal tema Meetup:
    - `cd laravel/Themes/Meetup`
    - `npm install`
    - `npm run build && npm run copy` (OBBLIGATORIO dopo ogni cambio CSS/JS)
- **3. Visita il frontoffice**
  - `http://127.0.0.1:8000/it`
  - `http://127.0.0.1:8000/it/events`
  - confronta con `https://laravelpizza.com` e prova a trovare differenze da colmare.

---

## 🤝 Come puoi contribuire (anche se è la tua prima volta)

- **Se ami il frontend**:
  - Aiuta a rifinire il tema Meetup (`resources/css/app.css`, `resources/js/app.js`)
  - Porta nuove idee di sezioni/animazioni, ma sempre nel rispetto di Folio + Volt.
- **Se ami il backend/architettura**:
  - Migliora i moduli (`Modules/*`) seguendo PHPStan livello 10
  - Rafforza services, actions, DTO, code quality, pattern Laraxot.
- **Se ami la documentazione**:
  - Migliora/aggiorna i file in `docs/` (senza maiuscole nei nomi, tranne `README.md`)
  - Scrivi analisi di pagine, bugfix log, regole e decisioni architetturali.

Ogni contributo che:
- rispetta le regole,
- migliora la qualità,
- rende più facile per altri capire il progetto,
è il benvenuto.

---

## 🍕 Perché il nome "LaravelPizza"?

Perché l'idea è semplice: **mettere insieme le due cose che rendono felice il 90% degli sviluppatori**:

- scrivere buon codice Laravel,
- mangiare una pizza in compagnia,
- condividere esperienze, problemi, soluzioni.

Questo repo è il passo successivo:
**standardizzare un setup di meetup Laravel "replicabile" ovunque nel mondo.**

Se vuoi far parte di questa cosa, **forka il repo, apri una PR e raccontaci cosa hai fatto nelle docs.**

Ci vediamo al prossimo meetup. 🍕