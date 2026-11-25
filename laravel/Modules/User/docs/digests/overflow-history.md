---
title: "Overflow history (ceiling 100)"
type: digest
status: active
qmd: "digest ceiling 100 overflow-history"
---

# Overflow history (ceiling 100)

Overflow force-cap: 19 file oltre target 100.

### `stories/0088-auth-pages-i18n-en-de-es.story.md` — Login e registrazione in inglese, tedesco e spagnolo

# Login e registrazione in inglese, tedesco e spagnolo

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `wiki/topics/00-index.md` — Topic 00-index


# Topic 00-index

Sintesi automatica di 4 documenti (chiave `00-index`).

## 📚 **Indice Documentazione Modulo User**

_Fonte: `00-index-indice-documentazione-modulo-user.md`_

# 📚 **Indice Documentazione Modulo User**

**Status**: ✅ PHPStan Level 10 Compliant
**Module Version**: 2.5.0

## 🎯 **Lettura Essenziale**
1. [README.md](./README.md) - Panoramica completa del sistema di identità.
2. [roadmap.md](./roadmap.md) - Evoluzione 2026: Biometric Auth & AI Moderation.
3. [philosophy.md](./philosophy.md) - "Essere Unici": la gestione dell'identità digitale.

## 🏗️ **Architettura & Auth**

### `wiki/topics/auth-login.md` — Topic auth-login


# Topic auth-login

Sintesi automatica di 3 documenti (chiave `auth-login`).

## Implementazione Corretta della Pagina di Login

_Fonte: `auth-login-implementation-2.md`_

# Implementazione Corretta della Pagina di Login 

## Collegamenti correlati
- [Documentazione centrale](/docs/readme.md)
- [Collegamenti documentazione](/docs/collegamenti-documentazione.md)
- [Regole Traduzioni](/laravel/modules/lang/docs/translation-keys-rules-2.md)
- [Implementazione Auth Pages](/laravel/modules/user/docs/auth-pages-implementation.md)
- [Volt Folio Auth](/laravel/modules/user/docs/volt-folio-auth-implementation-3.md)
- [Documentazione centrale](/docs/README.md)
- [Collegamenti documentazione](/docs/collegamenti-documentazione.md)
- [Regole Traduzioni](/laravel/modules/lang/docs/translation-keys-rule

### `wiki/topics/auth-pages.md` — Topic auth-pages


# Topic auth-pages

Sintesi automatica di 5 documenti (chiave `auth-pages`).

## Implementazione Corretta delle Pagine Auth

_Fonte: `auth-pages-implementation-1-1.md`_

# Implementazione Corretta delle Pagine Auth 

## Collegamenti correlati
- [Documentazione centrale](../../../../docs/README.md)
- [Collegamenti documentazione](../../../docs/collegamenti-documentazione.md)
- [README modulo User](./README.md)
- [Convenzioni Path](./path-conventions.md)
- [Volt Errors](./volt-errors.md)
- [Volt Folio Logout](./volt-folio-logout.md)
- [Volt Logout Action](./volt-logout-action.md)


### `wiki/topics/cms-link.md` — Topic cms-link


# Topic cms-link

Sintesi automatica di 3 documenti (chiave `cms-link`).

## Collegamento al Modulo Cms

_Fonte: `cms-link-1.md`_

# Collegamento al Modulo Cms

Questo documento descrive le relazioni e i collegamenti tra il modulo User e il modulo Cms per quanto riguarda i componenti Filament e le convenzioni di namespace.

## Convenzioni di Namespace

Sia il modulo User che il modulo Cms seguono le stesse convenzioni di namespace per i componenti Filament:

- Il namespace corretto è sempre `Modules\<NomeModulo>\Filament`, anche se i file si trovano in `app/Filament`
- Non va mai aggiunto `App` nel namespace


### `wiki/topics/dry-kiss.md` — Topic dry-kiss


# Topic dry-kiss

Sintesi automatica di 9 documenti (chiave `dry-kiss`).

## DRY & KISS Analysis - Modulo User

_Fonte: `dry-kiss-018b09.md`_

# DRY & KISS Analysis - Modulo User

**Data:** 15 Ottobre 2025
**Modulo:** User
**DRY Score:** ✅ 95%
**KISS Score:** ✅ 92%

## 📊 Stato Attuale

### ✅ Punti di Forza


### `wiki/topics/filament-4.md` — Topic filament-4


# Topic filament-4

Sintesi automatica di 3 documenti (chiave `filament-4`).

## Filament 4: Namespace Actions - Filosofia Laraxot

_Fonte: `filament-4-actions-namespace.md`_

# Filament 4: Namespace Actions - Filosofia Laraxot

**Data Creazione**: 2025-01-22
**Status**: Documentazione Completa
**Versione**: 1.0.0

## 🏛️ Comandamento Sacro: Namespace Filament 4

### Principio Fondamentale

**"In Filament 4, tutte le Actions sono in `Filament\Actions\*`, NON in `Filament\Tables\Actions\*`"**

### `wiki/topics/get-login.md` — Topic get-login


# Topic get-login

Sintesi automatica di 3 documenti (chiave `get-login`).

## GetLoginHistoryAction

_Fonte: `contracts/get-login-history-action.md`_

# GetLoginHistoryAction

Serie storica degli accessi, bucket per giorno o per mese, letta da `authentication_logs`. Codice: `app/Actions/Login/GetLoginHistoryAction.php:23-113`.

## Input

- `?CarbonImmutable $since`: inizio della serie; se nullo parte dal giorno del primo log (righe 46-55).
- `string $granularity`: `day` o `month` (riga 36).

## Output


### `wiki/topics/get-user.md` — Topic get-user


# Topic get-user

Sintesi automatica di 3 documenti (chiave `get-user`).

## GetUserModelAttributesFromSocialiteAction

_Fonte: `contracts/get-user-model-attributes-from-socialite-action.md`_

# GetUserModelAttributesFromSocialiteAction

Traduce l'identità OAuth in un DTO di attributi per il modello utente, con validazioni esplicite. Codice: `app/Actions/Socialite/GetUserModelAttributesFromSocialiteAction.php`.

## Input

- `string $provider`, `SocialiteUserContract $oauthUser`.

## Output

- `SocialiteUserAttributesData`: `name`, `firstName`, `lastName`, `email`, `provider`.

### `wiki/topics/git-merge.md` — Topic git-merge


# Topic git-merge

Sintesi automatica di 4 documenti (chiave `git-merge`).

## git-merge-conflict-inventory-1

_Fonte: `wiki/troubleshooting/git-merge-conflict-inventory-1.md`_

> Questo file è stato rinominato in [git-merge-conflict-inventory-1.md](git-merge-conflict-inventory-1.md). Non aggiungere date nel filename; usare `created/updated` nel front matter.

## Git Conflict Inventory

_Fonte: `wiki/troubleshooting/git-merge-conflict-inventory-28.md`_

# Git Conflict Inventory

- Date: 2026-04-28
- Owner: Modules/User
- Files with conflict markers: 5

### `wiki/topics/git-push.md` — Topic git-push


# Topic git-push

Sintesi automatica di 4 documenti (chiave `git-push`).

## User Module — Git Push & LFS Issue (2026-07-28)

_Fonte: `git-push-lfs-issue-28.md`_

# User Module — Git Push & LFS Issue (2026-07-28)

## Problem

Push to `provtv/module_user_fila5` fails with LFS (Git Large File Storage) error:

```
remote: error: GH008: Your push referenced at least 11 unknown Git LFS objects:
  e400cd031a594c8b3ea19d7711c0394f1315eeabb182f13351602aaf935cde53
  d82a070ef9ee39f25805bce168450feaeabef237ff9b9177afdb77ed88860b26
  5375e5ef35f8c770fd8d39c1702e6c90f715fd6752c8fec51c9d0f9b410f4f48

### `wiki/topics/lang-link.md` — Topic lang-link


# Topic lang-link

Sintesi automatica di 3 documenti (chiave `lang-link`).

## Collegamento alle Traduzioni del Modulo User

_Fonte: `lang-link-1.md`_

# Collegamento alle Traduzioni del Modulo User

Questo modulo utilizza le traduzioni centralizzate nella cartella [Lang](../../Lang/docs/).

Consulta la documentazione delle traduzioni:
- [Introduzione alle Traduzioni](../../Lang/docs/introduction.md)
- [Struttura delle Traduzioni](../../Lang/docs/structure.md)
- [Gestione dei File di Lingua](../../lang/docs/module_lang.md)

## Collegamento Bidirezionale


### `wiki/topics/passport.md` — Topic passport


# Topic passport

Sintesi automatica di 3 documenti (chiave `passport`).

## passport

_Fonte: `-integration/passport.md`_

# passport

<!-- Contenuto migrato da _docs/passport.txt -->

https://medium.com/@mrcyna/laravel-passport-and-microservice-architecture-ef6be7fcc79f

## passport

_Fonte: `_integration/passport.md`_

See canonical documentation: ../../../../Themes/docs/shared-components/passport.md

### `wiki/topics/roadmap.md` — Topic roadmap


# Topic roadmap

Sintesi automatica di 3 documenti (chiave `roadmap`).

## Policy globale (puntatore)

_Fonte: `development/roadmap.md`_

# Policy globale (puntatore)

Contenuto in wiki di progetto — non duplicare nei moduli ([#124](https://github.com/provtv/base_ptv_fila5_mono/issues/124)).

→ [docs/wiki/rules/00-TRIGGER_MAP.md](../../../../../docs/wiki/rules/00-TRIGGER_MAP.md)

## User Module Roadmap (2025 Q4)

_Fonte: `roadmap/roadmap.md`_

# User Module Roadmap (2025 Q4)

### `wiki/topics/socialite.md` — Topic socialite


# Topic socialite

Sintesi automatica di 3 documenti (chiave `socialite`).

## socialite

_Fonte: `_integration/socialite.md`_

# socialite

<!-- Contenuto migrato da _docs/socialite.txt -->

-------------------------------------------------------------------------------------------------------------
How to customize Laravel filament login page
https://dev.to/mfazail/how-to-customize-laravel-filament-login-page-455n
-------------------------------------------------------------------------------------------------------------

https://github.com/DutchCodingCompany/filament-socialite


### `wiki/topics/team.md` — Topic team


# Topic team

Sintesi automatica di 4 documenti (chiave `team`).

## Team

_Fonte: `models/models/team.md`_

# Team

Il modello `Team` rappresenta un team nel sistema, implementando l'interfaccia `TeamContract`.

## Proprietà

- `id` - UUID del team
- `name` - Nome del team
- `owner_id` - ID del proprietario del team
- `personal_team` - Flag che indica se è un team personale


### `wiki/topics/terms-and.md` — Topic terms-and


# Topic terms-and

Sintesi automatica di 4 documenti (chiave `terms-and`).

## terms_and_conditions - User

_Fonte: `_integration/legacy/terms-and-conditions.md`_

# terms_and_conditions - User

## Overview

Documentazione per terms_and_conditions nel modulo User.

## Dettagli

[Da completare]

## Collegamenti

### `wiki/topics/testing.md` — Topic testing


# Topic testing

<<<<<<< .merge_file_rJ7Xmj
Sintesi automatica di 6 documenti (chiave `testing`).

## testing

_Fonte: `best-practices/testing.md`_

See canonical documentation: ../../../../Themes/docs/shared-components/testing-rules.md
=======
Sintesi automatica di 5 documenti (chiave `testing`).
>>>>>>> .merge_file_R6LD0i

## Testing del Bug Fix: Infinite Loop in make:filament-user

_Fonte: `bugs/testing.md`_

# Testing del Bug Fix: Infinite Loop in make:filament-user

### `wiki/uservsprofile.md` — User vs Profile Models


# User vs Profile Models

To adhere to the **Single Responsibility Principle**, PTVX separates authentication data from public/extended profile data.

## 1. Responsibilities

### User Model (The Identity)
- **Primary Goal**: Authentication and Authorization.
- **Fields**: `email`, `password`, `is_active`, `type`, `state`, `lang`.
- **Connections**: Handled by the `auth` database connection.

### Profile Model (The Persona)
- **Primary Goal**: Public display and extended metadata.
- **Fields**: `first_name`, `last_name`, `avatar`, `bio`, `phone`, `city`.
- **Connections**: Handled by module-specific connections (e.g., `meetup`, `performance`).

## 2. Decision Matrix

| Data Type | User Model | Profile Model |
