---
title: "Overflow history (ceiling 100)"
type: digest
status: active
qmd: "digest ceiling 100 overflow-history"
---

# Overflow history (ceiling 100)

Overflow force-cap: 9 file oltre target 100.

### `folio-volt-localization.md` — Lingua e pagine Folio/Volt

# Lingua e pagine Folio/Volt

Come le pagine pubbliche (Folio + Volt) ricevono la lingua. Il codice sta in Cms; Lang fornisce la sorgente delle lingue
(`laravellocalization.supportedLocales`) e le traduzioni. Regole generali sui link: [laravel-localization-mcamara-reference.md](laravel-localization-mcamara-reference.md).

## Come sono montate le pagine

`Modules\Cms\Providers\FolioVoltServiceProvider` monta le cartelle di pagine **una volta per ogni lingua** di `supportedLocales`
(`Folio::path($path)->uri($locale)`):

- la cartella `pages` del tema pubblico (`XotData::make()->getPubThemeViewPath('pages')`);
- `resources/views/pages` di ogni modulo abilitato; la sottocartella `pages/api` e' montata una sola volta su `/api` con il solo middleware `web`.

Le pagine esistono quindi solo sotto 

### `translation-keys.md` — Chiavi e file di traduzione: regole

# Chiavi e file di traduzione: regole

Il canone dei 5 livelli e' nel wiki di progetto (`bashscripts/ai/wiki/rules/translations-files-keys.md`) e nell'ADR Xot 0037 (protocollo delle chiavi).
Qui: cosa vale nei moduli e come lo applica Lang.

## Dove stanno e come si caricano

- Moduli: `Modules/<Modulo>/lang/<locale>/<file>.php`; temi: `Themes/<Tema>/lang/<locale>/<file>.php`.
- `XotBaseServiceProvider` carica la cartella con `loadTranslationsFrom($langPath, <modulo minuscolo>)` e `loadJsonTranslationsFrom($langPath)`:
  la chiave e' `<modulo>::<file>.<percorso>` (`lang::translation_file_form.fields.name.label`).
- Il modulo Lang ha le sue traduzioni in `Modules/Lang/lang/{it,en,de,es}` (non `resources/lang`).

## Forma della chiave

`<modulo>::<file>.<collezione>.<chiave>.<tipo>`: namespa

### `wiki/integrations/_da-riconciliare/analysis-results-2.md` — Risultati Analisi Modulo Lang - 2025-01-06


# Risultati Analisi Modulo Lang - 2025-01-06

## Data
2025-01-06

## Strumenti Utilizzati
- PHPStan Livello 10
- PHPMD
- Rector (dry-run)
- PHPInsights (installato ma richiede configurazione)

## Risultati PHPStan

**Status**: ⏳ Analisi in corso (bloccata da conflitti Git in altri moduli)

## Risultati PHPMD

### ConvertTranslations.php
**Problemi Identificati**: 30+ problemi

### `wiki/integrations/_da-riconciliare/locale-management-2.md` — Gestione delle Lingue in Laravel


# Gestione delle Lingue in Laravel

## Indice
1. [Configurazione Base](#configurazione-base)
2. [Gestione delle Lingue](#gestione-delle-lingue)
3. [Middleware per la Lingua](#middleware-per-la-lingua)
4. [Best Practice](#best-practice)
5. [Implementazione nel Progetto](#implementazione-nel-progetto)
6. [Risoluzione Problemi](#risoluzione-problemi)

## Configurazione Base

### File di Configurazione Principale

`config/app.php`:
```php
'locale' => 'it',  // Lingua predefinita
'fallback_locale' => 'en',  // Lingua di fallback
'faker_locale' => 'it_IT',  // Impostazioni localizzazione per Faker

### `wiki/integrations/_da-riconciliare/phpstan-fixes.md` — PHPStan Compliance Documentation


# PHPStan Compliance Documentation

## Overview

Documenta tutti i fix di compliance PHPStan implementati per raggiungere 0 errori a livello max.

## Errori Corretti

### 1. TranslationFileResource - Lang Module

**File**: `app/Filament/Resources/TranslationFileResource/Pages/EditTranslationFile.php`

**Errori Originali**:
- `parameter.type` su `$data['content']`
- `return.type` per `makeFromArray()`
- `identifier: missingType.iterableValue`

**Soluzioni Implementate**:
```php

### `wiki/integrations/_da-riconciliare/project-structure-2.md` — Project Structure — Module **Lang**


# Project Structure — Module **Lang**

## Directory Structure

\`\`\`
./laravel/Modules/Lang/docs/
├── wiki/                          # Knowledge base locale (LLM Wiki)
│   ├── index.md                  # Master catalog
│   ├── log.md                    # Activity log
│   ├── concepts/                 # Topic/theme pages
│   ├── entities/                 # Organization/person pages
│   ├── rules/                    # ⚠️ 151+ regole progettuali
│   │   ├── 00-index.md          # Indice regole
│   │   ├── 00-TRIGGER_MAP.md    # Trigger map (link a globale)
│   │   └── *.md                 # Regole specifiche modulo
│   ├── skills/                   # Skill progettuali
│   │   ├── index.md
│   │   └── *.md
│   ├── commands/                 # Comandi progettuali

### `wiki/integrations/_da-riconciliare/quality-analysis-2.md` — Quality Analysis Report - Lang Module


# Quality Analysis Report - Lang Module
**Date**: 2025-11-11
**Analyst**: Claude Code
**Tools**: PHPStan Level 10, PHPInsights, PHPMD

---

title: "quality analysis 2025 11 11"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "quality analysis 2025 11 11"
issues: []
discussions: []
## Executive Summary

The Lang module has been analyzed using three quality assurance tools:
- **PHPStan Level 10**: ✅ **PASS** (1 error fixed)

### `wiki/integrations/_da-riconciliare/translation-process-2.md` — Processo di Traduzione: Da Sviluppatore a Traduttore


# Processo di Traduzione: Da Sviluppatore a Traduttore

## Indice
1. [Introduzione](#introduzione)
2. [Struttura dei File di Traduzione](#struttura-dei-file-di-traduzione)
3. [Preparazione per i Traduttori](#preparazione-per-i-traduttori)
4. [Strumenti Consigliati](#strumenti-consigliati)
5. [Integrazione con il Flusso di Lavoro](#integrazione-con-il-flusso-di-lavoro)
6. [Best Practice](#best-practice)
7. [Automazione](#automazione)

## Introduzione

Questo documento descrive il processo di gestione delle traduzioni nel progetto <nome progetto>, con particolare attenzione alla collaborazione tra sviluppatori e traduttori.

## Struttura dei File di Traduzione

### File JSON (Traduzioni Globali)


### `wiki/integrations/_da-riconciliare/validation-messages-2.md` — Gestione delle Traduzioni dei Messaggi di Validazione

# Gestione delle Traduzioni dei Messaggi di Validazione

## Obiettivo
Fornire una guida completa per:
- Tradurre i messaggi di validazione standard e personalizzati
- Gestire la corrispondenza tra label e nome campo nei messaggi di errore
- Gestire array di campi e placeholder dinamici
- Scrivere messaggi di validazione user-friendly e localizzati

---

## 1. Messaggi di Validazione Standard

Laravel fornisce messaggi di default in `resources/lang/{lang}/validation.php`.  
**Consiglio:**  
- Usa il pacchetto [Laravel-Lang/lang](https://github.com/Laravel-Lang/lang) per avere traduzioni aggiornate e complete.
- Aggiorna i file con `composer require laravel-lang/common --dev` e `php artisan lang:add it`.

---
