# Tema One per

## Introduzione

Il Tema One è il tema predefinito per , basato su Filament 3.3. Questo tema fornisce un'interfaccia moderna e responsive per il frontend del sito.
# Tema One per <nome progetto>

## Introduzione

Il Tema One è il tema predefinito per <nome progetto>, basato su Filament 3.3. Questo tema fornisce un'interfaccia moderna e responsive per il frontend del sito.

## Requisiti

- PHP 8.1+
- Laravel 10+
- Filament 3.3+
- Node.js 16+
- NPM 8+

## Struttura del Tema

```
Themes/One/
├── app/
│   └── Providers/
│       └── ThemeServiceProvider.php
├── config/
│   └── theme.php
├── resources/
│   └── views/
│       ├── components/
│       │   └── blocks/
│       ├── layouts/
│       └── pages/
└── assets/
    ├── css/
    └── js/
```

## Blocchi Disponibili

Il tema One include i seguenti blocchi:

### Hero
Un blocco hero per le pagine principali con titolo, sottotitolo, immagine e call-to-action.

### Feature Sections
Sezioni di caratteristiche con icone, titoli e descrizioni.

### Team
Sezione per visualizzare i membri del team con foto, nomi, ruoli e biografie.

### Stats
Statistiche con numeri e etichette.

### CTA
Call-to-action con titolo, descrizione e pulsante.

## Personalizzazione

### Modificare le Viste
Le viste possono essere modificate nella directory `resources/views`.

### Modificare gli Assets
Gli assets CSS e JavaScript possono essere modificati nella directory `assets`.

### Configurazione
La configurazione del tema può essere modificata nel file `config/theme.php`.

## Integrazione con Laravel Folio

Il tema One utilizza Laravel Folio per la gestione delle rotte del frontend. Le pagine sono definite nella directory `resources/views/pages` e seguono la convenzione di naming di Folio.

Esempio:
- `resources/views/pages/about.blade.php` -> `/about`
- `resources/views/pages/blog/[slug].blade.php` -> `/blog/{slug}`

## Integrazione con il Modulo CMS

Il tema One si integra con il modulo CMS per la gestione dei contenuti. I contenuti sono definiti in file JSON nella directory `config/local/<nome progetto>/database/content/pages`.

## Supporto

Per supporto tecnico, contattare il team .
Il tema One si integra con il modulo CMS per la gestione dei contenuti. I contenuti sono definiti in file JSON nella directory `config/local/<nome progetto>/database/content/pages`.

## Supporto

Per supporto tecnico, contattare il team <nome progetto>.
