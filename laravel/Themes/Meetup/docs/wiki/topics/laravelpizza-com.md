---
title: "Topic laravelpizza-com"
type: digest
status: active
qmd: "digest ceiling 100 laravelpizza-com"
---

# Topic laravelpizza-com

Sintesi automatica di 3 documenti (chiave `laravelpizza-com`).

## Architettura Conversione LaravelPizza.com

_Fonte: `laravelpizza-com-conversion-architecture.md`_

# Architettura Conversione LaravelPizza.com

**Status**: ✅ Documentazione Critica
**Scopo**: Documentare l'architettura di conversione di laravelpizza.com nella struttura base_laravelpizza

---

## 🎯 Obiettivo

**Convertire laravelpizza.com nella struttura base_laravelpizza utilizzando Filament Forms Builder per la gestione dei content blocks.**

Questo progetto è la **conversione fedele** del sito originale laravelpizza.com nella nuova architettura modulare Laraxot.

---

## 🏗️ Architettura del Sistema

### 1. Folio + Volt per Frontoffice

**Pattern Obbligatorio**:
```
Request → Folio (routing) → Blade Page → Volt Component → Action → Service/Model
```

**File**: `Themes/Meetup/resources/views/pages/[slug].blade.php`

```php
<?php
declare(strict_types=1);
use function Laravel\Folio\{middleware, name};

## Analisi Design LaravelPizza.com

_Fonte: `laravelpizza-com-design-analysis.md`_

# Analisi Design LaravelPizza.com

## Data Analisi: [DATE]

## 🎯 Scopo
Analizzare il design di laravelpizza.com (sito community meetup) per adattarlo al nostro sistema di ordinazione pizze.

## 📊 Analisi Sito Originale

### Design System Identificato

#### Colori
- **Background**: `rgb(2, 8, 23)` - Dark slate/black (#020817)
- **Text**: `rgb(248, 250, 252)` - Slate-50 (#f8fafc)
- **Primary**: `--primary: 0 72.2% 50.6%` - Rosso (#dc2626)
- **Secondary**: `--secondary: 217.2 32.6% 17.5%` - Dark slate
- **Accent**: `--accent: 217.2 32.6% 17.5%` - Dark slate

#### Typography
- **Font Family**: `-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell`
- **System Font Stack**: Usa font nativi del sistema

#### Layout
- **Dark Theme**: Background scuro con testo chiaro
- **Navigation**: Sticky top, semi-trasparente con backdrop blur
- **Hero Section**: Centrato, grande heading, CTA buttons
- **Feature Cards**: 4 colonne su desktop, dark cards con bordi

### Struttura Pagina Originale

## Implementazione Completata: Sito Uguale a laravelpizza.com

_Fonte: `laravelpizza-com-implementation-complete.md`_

# Implementazione Completata: Sito Uguale a laravelpizza.com

## Data
8 Gennaio 2026

## Descrizione
Implementazione completa del sistema per rendere http://127.0.0.1:8002/it uguale a https://laravelpizza.com/

## Cambiamenti Effettuati

### 1. Configurazione Tenant
- I file JSON sono stati copiati da `config/local/laravelpizza/` a `config/laravelpizza.local/`
- Questo ha risolto il problema di caricamento dei dati per il tenant corretto basato su `APP_URL=http://laravelpizza.local`

### 2. Componente Hero
- Il componente `pub_theme::components.blocks.hero.main` è già configurato per visualizzare:
  - Testo "Laravel Developers. Pizza. Community." diviso in due righe (bianco e rosso)
  - Icona pizza rossa
  - Schema di colori rosso come in laravelpizza.com originale
- Il sistema SushiToJsons ora carica correttamente i dati da `home.json`

### 3. Configurazione Tema
- Il namespace `pub_theme` è correttamente registrato nel `ThemeServiceProvider`
- La configurazione in `xra.php` e `xot.php` punta correttamente al tema `Meetup`

### 4. Asset Compilati
- File CSS/JS sono stati compilati con `npm run build`
- niente `npm run copy`: `public_html/themes/<Tema>` è un symlink a `../../laravel/Themes/<Tema>/public`
- Lo stile del tema Meetup è ora attivo e funzionante
