# 🍕 LaravelPizza.com – Il side‑project Laravel che vorrai mostrare al prossimo meetup

## 🎯 Missione del Progetto

**Questo è una CONVERSIONE e MIGLIORAMENTO di https://laravelpizza.com/**

Non stiamo solo replicando - stiamo **ELEVANDO** il sito originale per renderlo:
- ✨ **PIÙ COOL** - Design premium e moderno che cattura l'attenzione
- 🚀 **PIÙ CLICKBAIT** - Headlines e CTA irresistibili che convertono
- 💥 **PIÙ ENGAGING** - Animazioni fluide e interazioni wow-factor
- 🔥 **PIÙ VIRALE** - Progettato per essere condiviso e diventare virale

**Obiettivo**: Prendere laravelpizza.com e renderlo **straordinario** - il genere di sito che fa dire "WOW!" e che viene condiviso spontaneamente.

---

## 🔄 **CRITICAL CORRECTION - 2026-03-07**

### **Problema Risolto**
- **Errore**: Creazione di nuovi moduli invece di estendere quelli esistenti
- **Soluzione**: Utilizzo moduli esistenti per l'implementazione

### **Nuove Regole di Implementazione**
1. **MAI** creare nuovi moduli - **SEMPRE** estendere quelli esistenti
2. **Utilizzare pattern** Laraxot con BaseModel esistenti
3. **Seguire struttura esistente** per ogni modulo
4. **Preservare modularità** esistente

### **Moduli Esistenti da Estendere**
- **laravel/Modules/Activity/** - Sistema di attività e log
- **laravel/Modules/Cms/** - Content Management System
- **laravel/Modules/Gdpr/** - Conformità GDPR
- **laravel/Modules/Geo/** - Geolocalizzazione e mappe
- **laravel/Modules/Job/** - Gestione job e code
- **laravel/Modules/Lang/** - Gestione multilingua
- **laravel/Modules/Media/** - Gestione file e media
- **laravel/Modules/Meetup/** - Logica principale meetup
- **laravel/Modules/Notify/** - Sistema notifiche
- **laravel/Modules/Seo/** - Ottimizzazione SEO
- **laravel/Modules/Tenant/** - Multi-tenancy
- **laravel/Modules/UI/** - Componenti UI condivisi
- **laravel/Modules/User/** - Gestione utenti e autenticazione
- **laravel/Modules/Xot/** - Infrastruttura di base
- **laravel/Modules/Setting/** - Configurazione applicazione

---

Benvenuto nella base ufficiale di **LaravelPizza.com**: qui costruiamo un ecosistema completo di **meetup**, **community**,
**tema frontend super curato (Meetup Theme)** e **architettura Laraxot** spinta al massimo.

> Stai cercando un progetto open‑source dove impari **Laravel moderno** (Folio + Volt + Filament) su un caso reale?
> Allora prenditi 2 minuti: questo repo può diventare il tuo **biglietto da visita** al prossimo Laravel meetup.
>
> **Obiettivo dichiarato:** diventare il riferimento per chi vuole lanciare un Laravel Meetup "chiavi in mano", con codice riusabile ovunque.

---

## 🚀 Perché questo repo vale il tuo tempo (e le tue PR)

 - **Tema frontoffice enhanced**: stiamo prendendo `laravelpizza.com` e lo stiamo **migliorando** dentro il **Meetup Theme**
  (home, events, menu, pagina contatti, auth, ecc.), con **Folio + Volt** come architettura obbligatoria.
  **Non è una copia** - è una versione premium, più cool, più coinvolgente.
  
### ⚠️ REGOLA CRITICA - Workflow Tema Separato

**MODIFICHE CSS/JS:**
- Dopo ogni modifica a `resources/css/app.css` o `resources/js/app.js` nel tema Meetup:
  1. `cd laravel/Themes/Meetup/`
  2. `npm run build` (compila con Vite)
  3. `npm run copy` (copia in public_html)
  4. Verifica nel browser con hard refresh

**WORKFLOW COMPLETO:**
1. Modifica file
2. `composer update -W` (tema Meetup)
3. `npm install` (tema Meetup)
4. `npm run build` (compila CSS/JS)
5. `npm run copy` (pubblica asset)
6. PHPStan livello 10
7. Testa nel browser

**Questa regola è ASSOLUTAMENTE OBBLIGATORIA!**
- **Architettura Laraxot**: un vero "framework nel framework":
  - Moduli indipendenti (`Modules/*`)
  - Temi separati (`Themes/*`)
  - Regole rigide su migrazioni, layout, traduzioni, docs.
- **Qualità maniacale**:
  - PHPStan livello **10** obbligatorio
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
- **Configurazione locale**: `laravel/config/local/laravelpizza/`
- **Tema corrente**: `laravel/Themes/Meetup/`

### 🏗️ Architettura Tema Separata

Il progetto ha una struttura di tema separata fondamentale:

**Configurazione del tema:**
```php
// laravel/config/local/laravelpizza/xra.php
'pub_theme' => 'Meetup',  // Tema corrente
'main_module' => 'Meetup', // Modulo principale
```

**Workflow per il tema Meetup:**
1. `cd laravel/Themes/Meetup/`
2. `composer update -W` (aggiorna dipendenze PHP)
3. `npm install` (installa dipendenze Node.js)
4. `npm run build` (compila CSS/JS con Vite)
5. `npm run copy` (copia asset in public_html/themes/Meetup/)

**Importante**: Senza `npm run build` e `npm run copy`, le modifiche CSS/JS non sono visibili nel browser!
- **Moduli** (business logic, servizi, integrazioni): `laravel/Modules/*`
  - `Activity` - Gestione attività e log
  - `Cms` - Content Management System
  - `Gdpr` - Conformità GDPR
  - `Geo` - Geolocalizzazione e mappe
  - `Job` - Gestione job e code
  - `Lang` - Gestione multilingua
  - `Media` - Gestione file e media
  - `Meetup` - Logica principale meetup
  - `Notify` - Sistema notifiche
  - `Seo` - Ottimizzazione SEO
  - `Tenant` - Multi-tenancy
  - `UI` - Componenti UI condivisi
  - `User` - Gestione utenti e autenticazione
  - `Xot` - Infrastruttura di base
- **Temi** (UI/UX, frontend, layout): `laravel/Themes/*`
  - `Meetup` - Tema principale basato su laravelpizza.com
- **Docs per modulo/tema**:
  - `Modules/{ModuleName}/docs/`
  - `Themes/{ThemeName}/docs/`

Ogni cartella `docs` è pensata come **memoria viva del sistema**:
regole, bugfix, decisioni architetturali, analisi delle pagine, tutto passa da lì.

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

### Workflow Critico
- **MAI** creare file .md in posizioni sbagliate - devono essere SOLO dentro cartelle `docs/` esistenti
- **MAI** usare maiuscole nei nomi dei file .md (tranne README.md e CHANGELOG.md)
- **SEMPRE** usare PHPStan Level 10 dopo aver modificato un file
- **SEMPRE** eseguire PHPMD e PHPInsights per qualità codice
- **MAI** usare `property_exists()` su modelli Eloquent
- **SEMPRE** verificare con `hasAttribute()` o type safety actions

Se ti riconosci in questa filosofia, ti troverai a casa.

---

## 🔥 Come iniziare in 3 passi

> Non serve essere "guru": serve voglia di imparare e rispetto per le regole del progetto.

- **1. Leggi le regole critiche**
  - `laravel/Modules/Xot/docs/critical-rules-consolidated.md`
  - `laravel/Modules/Meetup/docs/rules-index.md`
  - `laravel/Themes/Meetup/docs/critical-rules-consolidated.md`
- **2. Avvia l'ambiente**
  - Setup Laravel classico (database, `.env`, ecc.)
  - Installazione dipendenze:
    ```bash
    cd laravel
    composer install
    npm install
    ```
  - Dal tema Meetup:
    ```bash
    cd Themes/Meetup
    npm install
    npm run build && npm run copy  # OBBLIGATORIO dopo ogni cambio CSS/JS
    ```
- **3. Visita il frontoffice**
  - `http://127.0.0.1:8000/it`
  - `http://127.0.0.1:8000/it/events`
  - confronta con `https://laravelpizza.com` e prova a trovare differenze da colmare.

---

## 🛠️ Stack Tecnologico

### Backend
- **PHP 8.2+** con strict types obbligatorio
- **Laravel 11+** con architettura modulare Laraxot
- **Filament v4** per il backoffice
- **PHPStan Livello 10** per qualità codice
- **Pest PHP** per test unitari

### Frontend
- **Tailwind CSS 4.x** con Vite 7
- **Alpine.js 3.x** per interattività
- **DaisyUI** per componenti UI
- **Folio + Volt** per pagine dinamiche
- **TypeScript** per type safety

### Architettura
- **Moduli indipendenti** con dependency injection
- **Multi-tenancy** con Tenant module
- **Queue system** per job asincroni
- **Media library** per gestione file
- **SEO optimization** integrata

---

## 📋 Comandi Utili

### Sviluppo
```bash
# Setup completo progetto
cd laravel
composer run setup

# Sviluppo con hot reload
npm run dev

# Build assets tema Meetup
cd Themes/Meetup
npm run build && npm run copy

# Test completi
composer run test
```

### Qualità Codice
```bash
# PHPStan Livello 10
./vendor/bin/phpstan analyse Modules/ --memory-limit=-1

# Test Pest
./vendor/bin/pest

# Formattazione codice
./vendor/bin/php-cs-fixer fix
```

### Database
```bash
# Migrazioni
php artisan migrate

# Seed dati
php artisan db:seed

# Reset completo
php artisan migrate:fresh --seed
```

---

## 🤝 Come puoi contribuire (anche se è la tua prima volta)

- **Se ami il frontend**:
  - Aiuta a rifinire il tema Meetup (`resources/css/app.css`, `resources/js/app.js`)
  - Porta nuove idee di sezioni/animazioni, ma sempre nel rispetto di Folio + Volt.
  - **IMPORTANTE**: Ogni modifica CSS/JS richiede `npm run build && npm run copy`
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

## ⚠️ Regole Critiche da Ricordare

### Frontend Assets
- **OBBLIGATORIO**: `npm run build && npm run copy` dopo ogni modifica CSS/JS nel tema Meetup
- Gli asset compilati vanno in `public_html/themes/Meetup/`
- Senza build e copy, le modifiche NON sono visibili nel browser

### Laravel 11+ Casts Rule
- **OBBLIGATORIO**: In Laravel 11+ usare metodo `casts()` invece di `protected $casts`
- Tutte le properties usate nel codice DEVONO essere nei casts(), anche se sono in $fillable
- MAI usare `property_exists()` su modelli Eloquent perché gli attributi sono magic properties
- Usare sempre `$model->hasAttribute('attribute')` o `SafeEloquentCastAction` per type safety
- **MAI** usare `protected $casts = []` nei modelli (deprecato in Laravel 11+)

### Architettura Frontoffice
- **MAI** usare controller per pagine pubbliche
- **SEMPRE** usare Folio + Volt
- **SEMPRE** seguire pattern: Request → Folio → Blade → Volt → Action → Service

### Qualità Codice
- **TUTTI** i file PHP devono avere `declare(strict_types=1)`
- **SEMPRE** usare PHPStan Livello 10
- **SEMPRE** scrivere test in Pest PHP
- **MAI** usare `property_exists()` su modelli Eloquent

### Documentazione
- **SOLO** file `.md` dentro cartelle `docs` esistenti
- **MAIUSCOLE** vietate nei nomi (tranne `README.md` e `CHANGELOG.md`)
- **PRIMA** del codice: aggiornare docs
- **DOPO** il codice: verificare e migliorare docs

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
