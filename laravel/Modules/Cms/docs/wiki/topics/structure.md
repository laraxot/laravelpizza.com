---
title: "Topic structure"
type: digest
status: active
qmd: "digest ceiling 100 structure"
---

# Topic structure

Sintesi automatica di 3 documenti (chiave `structure`).

## Struttura del Modulo CMS

_Fonte: `architecture/structure.md`_

# Struttura del Modulo CMS

## Directory Principali

```
Modules/Cms/
├── app/                    # Codice principale del modulo
│   ├── Http/              # Controllers, Middleware, Requests
│   ├── Models/            # Modelli del modulo
│   ├── Filament/          # Resources e Pages di Filament
│   ├── Providers/         # Service Providers
│   └── Console/           # Comandi Artisan
├── config/                # File di configurazione
├── database/              # Migrations e Seeders
│   ├── migrations/        # Migrations
│   └── seeders/          # Seeders
├── resources/             # Assets e Views
│   ├── views/            # Blade views
│   ├── lang/             # File di traduzione
│   └── assets/           # JS, CSS, immagini
├── routes/                # File delle routes
├── tests/                 # Test del modulo
└── docs/                  # Documentazione del modulo
```

## Convenzioni

1. **Namespace**
   - Tutte le classi devono usare il namespace `Modules\Cms`

## Struttura dei Componenti

_Fonte: `components/structure.md`_

# Struttura dei Componenti

## Componenti Base

### Header (`<x-cms::section slug="header" />`)
Il componente header è la sezione superiore del sito che contiene:

1. **Logo**
   - Immagine del brand
   - Link alla home page
   - Dimensioni ottimizzate

2. **Navigazione**
   - Menu principale
   - Link alle sezioni chiave
   - Supporto multilingua

3. **Azioni**
   - Bottoni CTA (Call To Action)
   - Area utente
   - Funzionalità specifiche

### Footer (`<x-cms::section slug="footer" />`)
Il componente footer è la sezione inferiore che include:

1. **Informazioni Aziendali**
   - Nome e logo
   - Descrizione breve
   - Contatti principali

## Struttura dei Temi

_Fonte: `themes/structure.md`_

# Struttura dei Temi

## Documentazione Dettagliata

- [Gestione Assets](./assets.md)
- [Riutilizzabilità](./reusability.md)

## Struttura Standard

1. **Directory Principali**
   ```
   theme/
   ├── app/
   │   ├── Providers/
   │   └── Services/
   ├── resources/
   │   ├── css/
   │   ├── js/
   │   └── views/
   └── config/
       └── theme.php
   ```

2. **Assets**
   - CSS e JavaScript compilati
   - Immagini e media
   - Font e icone

3. **Viste**
