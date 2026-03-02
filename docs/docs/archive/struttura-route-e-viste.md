# Struttura delle Route e Viste in il progetto

## Indice
1. [Introduzione](#introduzione)
2. [Stack Tecnologico](#stack-tecnologico)
3. [Struttura delle Viste](#struttura-delle-viste)
4. [Mappatura tra URL e File](#mappatura-tra-url-e-file)
5. [Esempi Pratici](#esempi-pratici)
6. [Errori Comuni e Soluzioni](#errori-comuni-e-soluzioni)

## Introduzione

Questo documento descrive la struttura delle route e delle viste nel progetto il progetto, con particolare attenzione alla relazione tra URL, route e file di vista. Comprende anche una guida per identificare correttamente i file corrispondenti a specifiche route.

## Stack Tecnologico

il progetto utilizza un mix di tecnologie moderne per il frontend e il backend:

- **Laravel**: Framework PHP di base
- **Livewire + Volt**: Per componenti dinamici e reattivi
- **Laravel Folio**: Per la gestione delle pagine basate su file
- **Filament**: Per l'interfaccia di amministrazione
- **Laraxot**: Framework proprietario per estendere le funzionalità di Laravel

Questa combinazione di tecnologie crea una struttura particolare per le route e le viste che è importante comprendere.

## Struttura delle Viste

Le viste in il progetto sono organizzate principalmente in due aree:

1. **Backoffice**: Gestito principalmente da Filament
   - Path: `/laravel/app/Filament/` e moduli specifici

2. **Frontoffice**: Gestito da Laravel Folio + Livewire + Volt
   - Path principale: `/laravel/Themes/One/resources/views/pages/`

### Struttura delle Viste del Frontoffice

```
/laravel/Themes/One/resources/views/
├── components/           # Componenti Blade riutilizzabili
├── layouts/              # Layout principali dell'applicazione
└── pages/                # Pagine del frontoffice (gestite da Folio)
    ├── index.blade.php   # Homepage
    ├── auth/             # Pagine di autenticazione
    │   ├── login.blade.php
    │   ├── register.blade.php
    │   └── forgot-password.blade.php
    ├── profile/          # Pagine del profilo utente
    └── ... altre sezioni ...
```

## Mappatura tra URL e File

### Regola Fondamentale

In il progetto, gli URL seguono questa struttura:

```
/{locale}/{sezione}/{risorsa}/{azione?}/{id?}
```

Dove:
- `{locale}` è il codice della lingua (es. `it`, `en`)
- `{sezione}` è l'area del sito (es. `pages`, `auth`, `profile`)
- `{risorsa}` è la risorsa specifica (es. `register`, `login`)

### Come Identificare il File Corrispondente a un URL

Per identificare il file corrispondente a un URL specifico:

1. **Rimuovi il prefisso della lingua** (`/it/`, `/en/`, ecc.)
2. **Identifica la sezione principale** (`auth`, `pages`, ecc.)
3. **Cerca nella directory corrispondente** sotto `/laravel/Themes/One/resources/views/pages/`

#### Esempi:

| URL | File Corrispondente |
|-----|---------------------|
| `/it/auth/register` | `/laravel/Themes/One/resources/views/pages/auth/register.blade.php` |
| `/it/auth/login` | `/laravel/Themes/One/resources/views/pages/auth/login.blade.php` |
| `/it/profile` | `/laravel/Themes/One/resources/views/pages/profile/index.blade.php` |

## Esempi Pratici

### Esempio 1: Pagina di Registrazione

- **URL**: `/it/auth/register`
- **File**: `/laravel/Themes/One/resources/views/pages/auth/register.blade.php`
- **Tecnologie**: Volt + Livewire + Folio
- **Funzionalità**: Gestisce il form di registrazione e la creazione dell'utente

### Esempio 2: Homepage

- **URL**: `/it/` o `/it/home`
- **File**: `/laravel/Themes/One/resources/views/pages/index.blade.php`
- **Contenuto**: Definito nei file JSON in `/laravel/config/local/<directory progetto>/database/content/pages/1.json`

## Errori Comuni e Soluzioni

### Errore 1: Cercare le Route nei File di Routing Tradizionali

**Problema**: Con Laravel Folio, molte route non sono definite nei file di routing tradizionali (`routes/web.php`, ecc.) ma sono generate automaticamente dai file Blade nella directory `pages/`.

**Soluzione**: Cerca prima nella struttura delle directory di Folio (`/laravel/Themes/One/resources/views/pages/`).

### Errore 2: Non Considerare il Tema Attivo

**Problema**: il progetto può supportare più temi, e le viste possono essere in temi diversi.

**Soluzione**: Verifica sempre quale tema è attivo (attualmente "One") e cerca nei percorsi corretti.

### Errore 3: Confondere Backoffice e Frontoffice

**Problema**: Le route e le viste del backoffice (Filament) e del frontoffice sono gestite in modo diverso.

**Soluzione**: Identifica prima se la route appartiene al backoffice o al frontoffice, poi cerca nei percorsi appropriati.
