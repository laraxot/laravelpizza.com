---
title: "Topic quick-reference"
type: digest
status: active
qmd: "digest ceiling 100 quick-reference"
---

# Topic quick-reference

Sintesi automatica di 3 documenti (chiave `quick-reference`).

## quick-reference-2

_Fonte: `quick-reference-2.md`_

See canonical documentation: ../../../Themes/docs/shared-components/.gitkeep-Modules

## Guida Rapida alle Traduzioni

_Fonte: `wiki/integrations/_da-riconciliare/quick-reference-2.md`_

# Guida Rapida alle Traduzioni

## Struttura Base

```
lang/
├── it/                 # Traduzioni in italiano
│   ├── auth.php        # Testi di autenticazione
│   ├── validation.php  # Messaggi di validazione
│   └── modules/        # Moduli personalizzati
│       ├── patient.php
│       └── doctor.php
└── en/                 # Traduzioni in inglese
    └── ...
```

## Utilizzo Base

### Nei File Blade
```blade
{{ __('Benvenuto, :name', ['name' => $user->name]) }}

{{ __('patient.profile.title') }}
```

### Nei Controller/Classi PHP
```php
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;

## Topic quick-reference

_Fonte: `wiki/topics/quick-reference.md`_

# Topic quick-reference

Sintesi automatica di 3 documenti (chiave `quick-reference`).

## Lang — quick reference

_Fonte: `bmad/quick-reference.md`_

# Lang — quick reference

> **SUMMARY**: riferimento rapido per lo sviluppo su `Modules\Lang`:
> modelli, action traduzione, adapter, resource Filament, widget e config.
> Tutto derivato da file reali del modulo.

## Namespace e providers

- Namespace: `Modules\Lang`
- Provider principale: `Modules\Lang\Providers\LangServiceProvider`
  (`app/Providers/LangServiceProvider.php:25`, estende `XotBaseServiceProvider`)

## Modelli principali

| Modello | File | Estende | Tabella |
|---|---|---|---|
| `LanguageLine` | `app/Models/LanguageLine.php` | `BaseModel` | `language_lines` |
| `Translation` | `app/Models/Translation.php` | `BaseModel` | `translations` |
| `TranslationFile` | `app/Models/TranslationFile.php` | `BaseModel` | — |
| `Post` | `app/Models/Post.php` | `BaseModel` | `posts` |
| `BaseModel` | `app/Models/BaseModel.php` | `XotBaseModel` | — |
